<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function pageProfile()
    {
        $data['user'] = Auth::user();

        $totalAmountPayment = $data['user']->payments()
            ->where('status', 'paid')
            ->sum('amount');
        $totalPaymentDoing = $data['user']->payments()
            ->count();
        $totalPaymentSuccess = $data['user']->payments()
            ->where('status', 'paid')
            ->count();
        $totalPaymentFailed = $data['user']->payments()
            ->where('status', 'failed')
            ->count();

        $paymentHistory = $data['user']->payments()
            ->latest()
            ->with(['user', 'student', 'activity'])
            ->take(3)
            ->get();
        $data['payment'] = [

            'totalAmountPayment' => $totalAmountPayment,
            'totalPaymentDoing' => $totalPaymentDoing,
            'totalPaymentSuccess' => $totalPaymentSuccess,
            'totalPaymentFailed' => $totalPaymentFailed,
            'paymentHistory' => $paymentHistory
        ];
        // dd($data['user']);
        return view('index.user.profile', compact('data'));
    }


    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validasi input

        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
        ]);

        // Update nama
        $user->name = $request->name;

        // Update gambar jika ada
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('img/user'), $imageName);
            $user->image = $imageName;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
