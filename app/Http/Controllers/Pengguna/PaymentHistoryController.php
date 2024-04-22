<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentHistoryController extends Controller
{
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
            ->where('user_id', $data['user']->id)
            ->latest()
            ->get();
        return view('index.user.payment-history', compact('data'));
    }
}
