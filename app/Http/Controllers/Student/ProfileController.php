<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function pageProfile()
    {
        $data['user'] = Auth::user();
        $user = Auth::user();
        $student = $data['user']->student;
        $totalAmountPayment = Payment::where('student_id', $user->id)
            ->where('status', 'paid')
            ->sum('amount');
        $totalPaymentDoing = Payment::where('student_id', $user->id)
            ->count();
        $totalPaymentSuccess = Payment::where('student_id', $user->id)
            ->where('status', 'paid')
            ->count();
        $totalPaymentFailed = Payment::where('student_id', $user->id)
            ->where('status', 'failed')
            ->count();

        $paymentHistory = Payment::where('student_id', $user->id)
            ->latest()
            ->with(['user', 'student', 'activity'])
            ->take(3)
            ->get();
        $activityRegistered = $student->activities()->count();
        $activityPaid = $student->activities()
            ->wherePivot('is_paid_off', true)
            ->count();
        $activityUnpaid = $student->activities()
            ->wherePivot('is_paid_off', false)
            ->count();

        $data['payment'] = [
            'paymentHistory' => $paymentHistory,
            'totalAmountPayment' => $totalAmountPayment,
            'totalPaymentDoing' => $totalPaymentDoing,
            'totalPaymentSuccess' => $totalPaymentSuccess,
            'totalPaymentFailed' => $totalPaymentFailed,
            'activityRegistered' => $activityRegistered,
            'activityPaid' => $activityPaid,
            'activityUnpaid' => $activityUnpaid,
        ];
        // dd($data['user']);
        return view('index.student.profile', compact('data'));
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

    public function generateNewUniqueCode(Request $request)
    {

        $validatedData = $request->validate([
            'unique_code_new' => 'required|string|max:255',
            'student_id' => 'required|exists:students,id',
        ]);

        try {
            $student = Student::findOrFail($validatedData['student_id']);

            $student->unique_code = $validatedData['unique_code_new'];

            $student->save();

            return back()->with('success', 'New unique code generated successfully.');
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return back()->with('error', 'Failed to generate new unique code. Please try again.');
        }
    }
}
