<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentHistoryController extends Controller
{
    public function pageHistory()
    {

        $data['user'] = Auth::user();

        $data['payment'] = Payment::with(['user.student', 'activity', 'student.user'])
            ->where('user_id', $data['user']->id)
            ->paginate(10);
        return view('index.user.payment-history', compact('data'));
    }
}
