<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ClassRoom;
use App\Models\Payment;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardAdminControlller extends Controller
{
    public function index()
    {
        $data = [];
        // 'count' => 'Rp. ' . number_format($totalTrans, 0, ',', '.'),
        $student_count = Student::all()->count();
        $admin_count = User::where('role', 'admin')->get()->count();
        $pengguna_count = User::where('role', 'pengguna')->get()->count();

        $kelas_count = ClassRoom::all()->count();
        $kegiatan_count = Activity::all()->count();

        $paymment_totalAmount = Payment::where('status', 'paid')->sum('amount');
        $paymment_totalPaid = Payment::where('status', 'paid')->count();
        $paymment_totalFailed = Payment::where('status', 'failed')->count();
        $paymment_totalPending = Payment::where('status', 'pending')->count();

        $data = [
            'user' => Auth::user(),
            'active' => 'dashboard',
            'account' => [
                'student' => [
                    'title' => "Total Murid",
                    'count' => $student_count
                ],
                'admin' => [
                    'title' => "Total Admin",
                    'count' => $admin_count
                ],
                'pengguna' => [
                    'title' => "Total Pengguna",
                    'count' => $pengguna_count
                ]
            ],
            'classRoom' => [
                'total' => [
                    'title' => 'Total Kelas',
                    'count' => $kelas_count
                ]
            ],
            'activity' => [
                'total' => [
                    'title' => 'Total Kegiatan',
                    'count' => $kelas_count
                ],
                'total_true' => [
                    'title' => 'Total Kegiatan Aktif',
                    'count' => $kelas_count
                ],
                'total_false' => [
                    'title' => 'Total Kegiatan Tidak Aktif',
                    'count' => $kelas_count
                ]

            ],
            'payment' => [
                'total_amount' => [
                    'title' => 'Total Uang Pembayaran',
                    'count' => $paymment_totalAmount
                ],
                'total_paid' => [
                    'title' => 'Total Pembayaran Succes',
                    'count' => $paymment_totalPaid
                ],
                'total_failed' => [
                    'title' => 'Total Pembayaran Failed',
                    'count' => $paymment_totalFailed
                ],
                'total_pending' => [
                    'title' => 'Total Pembayaran Pending',
                    'count' => $paymment_totalPending
                ],
            ]


        ];


        return view('index.admin.index', compact('data'))->with(['success' => "Berhasil menampilkan dashboard "]);
    }
}
