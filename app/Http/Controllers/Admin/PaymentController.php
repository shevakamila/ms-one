<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $data['payments'] = Payment::latest()->get();
        $data['active'] = 'allPayment';
        $data['user'] = Auth::user();
        return view('index.admin.payment.index', compact('data'));
    }
}
