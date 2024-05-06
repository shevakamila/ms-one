<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Payment;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{

    public function pageListPayment()
    {

        $data = [];
        $data['user'] = Auth::user();

        $data['activities'] = $data['user']->student->activities()->where('is_active', 1)->get();
        return view('index.student.payment-list', compact('data'));
    }
    public function detailPayment(Activity $activity, Student $student)
    {

        $data['student'] = $student;
        $data['activity'] = $activity;
        $data['user'] = Auth::user();

        $data['is_paid_off'] = $student->activities()->where('activity_id', $activity->id)->first()->pivot->is_paid_off;

        $data['payment']['totalAmountPayment'] = $student->payments()->where('activity_id', $activity->id)->where('status', 'paid')->sum('amount');
        $data['payment']['totalPaymentSuccess'] = $student->payments()->where('activity_id', $activity->id)->where('status', 'paid')->count();
        $data['payment']['totalPaymentFailed'] = $student->payments()->where('activity_id', $activity->id)->where('status', 'failed')->count();


        return view('index.student.payment-detail', compact('data'));
    }

    public function checkOut(Request $request)
    {
        $data['user'] = Auth::user();

        $validatedData = $request->validate([
            'student_id' => 'required',
            'amount' => 'required|numeric|min:0',
            'activity_id' => 'required',
        ]);
        $totalPayment = Payment::where('student_id', $validatedData['student_id'])
            ->where('activity_id', $validatedData['activity_id'])
            ->where('status', 'paid')
            ->sum('amount');

        $activity = Activity::find($validatedData['activity_id']);
        $hargaKegiatan = $activity->amount;

        $sisaPayment = $hargaKegiatan - $totalPayment;
        if ($request->amount > $sisaPayment) {
            return redirect()->back()->with([
                'error' => 'Pembayaran tidak boleh lebih dari uang kurang'
            ]);
        }

        try {

            $payment = new Payment();
            $payment->id = Str::uuid();
            $payment->student_id = $validatedData['student_id'];
            $payment->user_id = $data['user']->id;
            $payment->amount = $validatedData['amount'];
            $payment->activity_id = $validatedData['activity_id'];
            $payment->status = 'pending';
            $payment->save();

            // Generate Snap Token
            \Midtrans\Config::$serverKey = config('midtrans.serverKey');
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $params = array(
                'transaction_details' => array(
                    'order_id' => $payment->id,
                    'gross_amount' => $payment->amount,
                ),
                'enabled_payments' => array('credit_card'),
                "customer_details" => [
                    "email" => $payment->user->email,
                ]
            );
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            $payment->snap_token = $snapToken;
            $payment->save();
            $data['payment'] = $payment;
            return view('index.student.payment-invoice', compact('data'));
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Jaringan  internet anda tidak stabil');
        }
    }

    public function successPayment(Payment $payment)
    {
        $user = Auth::user();
        $payment->status = 'paid';
        $payment->payment_time = now();
        $payment->save();


        $student = $payment->student;
        $activity = $payment->activity;

        $totalPayment = $student->payments()
            ->where('activity_id', $activity->id)
            ->where('status', 'paid')
            ->sum('amount');

        $totalActivityAmount = $activity->amount;

        if ($totalPayment >= $totalActivityAmount) {
            $payment->activity->students()->updateExistingPivot($payment->student_id, ['is_paid_off' => true]);
        }
        $data['user'] = Auth::user();
        $data['payment'] = $payment;
        return view('index.student.payment-invoice', compact('data'));
    }

    public function batalPayment(Payment $payment)
    {
        $payment->status = 'failed';
        $payment->save();

        return redirect('/student/payment/payment-history');
    }
    public function pageHistory()
    {
        $user = Auth::user();

        $oneDayAgo = Carbon::now()->subDay();
        $payments = Payment::where('user_id', $user->id)
            ->where('status', 'pending')
            ->where('created_at', '<=', $oneDayAgo)
            ->get();

        foreach ($payments as $payment) {
            $payment->update(['status' => 'failed']);
        }
        $data['user'] = Auth::user();

        $data['payment'] = Payment::with(['user.student', 'activity', 'student.user'])
            ->where('student_id', $data['user']->id)
            ->latest()
            ->get();
        return view('index.student.payment-history', compact('data'));
    }
}
