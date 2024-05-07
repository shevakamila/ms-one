<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{


    public function pageListPayment()
    {
        $data = [];
        $data['user'] = Auth::user();
        $data['activities'] = [];
        return view('index.user.payment-list', compact('data'));
    }

    public function checkPaymentList(Request $request)
    {
        $data['user'] = Auth::user();
        $nisn = $request->nisn;

        try {
            $student = Student::where('nisn', $nisn)->firstOrFail();

            if ($request->unique_code === $student->unique_code) {
                // $data['student'] = $student->load('activities');
                $data['student'] = $student->load(['activities' => function ($query) {
                    $query->where('is_active', 1);
                }]);

                return view('index.user.payment-list', compact('data'));
            } else {
                return redirect()->back()->with('error', 'Kode unik tidak valid.');
            }
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Siswa tidak ditemukan.');
        }
    }

    // public function detailPayment2(Activity $activity, Student $student)
    // {

    //     $data['student'] = $student;
    //     $data['activity'] = $student->load(['activities' => function ($query) use ($activity) {
    //         $query->where('activity_id', $activity->id);
    //     }]);
    //     $data['totalAmountPayment'] = Payment::getTotalAmountPayment($student->id, $activity->id);
    //     $data['totalAmountLess'] = Payment::getOutstandingAmountPayment($student->id, $activity->id);
    //     $data['totalPayment'] =  Payment::getCountPayment($student->id, $activity->id);
    //     $data['user'] = Auth::user();
    //     return view('index.user.payment-detail', compact('data'));
    // }


    public function detailPayment(Activity $activity, Student $student)
    {

        $data['student'] = $student;
        $data['activity'] = $activity;
        $data['user'] = Auth::user();
        $data['is_paid_off'] = $student->activities()->where('activity_id', $activity->id)->first()->pivot->is_paid_off;
        return view('index.user.payment-detail', compact('data'));
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
            return view('index.user.payment-invoice', compact('data'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Jaringan  internet anda tidak stabil');
        }
    }

    public function pageMidtrans()
    {
        $data['user'] = Auth::user();
        return view('index.user.pay-midtrans');
    }


    public function batalPayment(Payment $payment)
    {
        $payment->status = 'failed';
        $payment->save();

        return redirect('/user/payment/payment-history');
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
        return view('index.user.payment-invoice', compact('data'));
    }
}
