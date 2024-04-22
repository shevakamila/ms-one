<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function listActivity()
    {
        $data['user'] = Auth::user();
        $data['activities'] = Activity::withCount('students')->orderByDesc('students_count')->get();

        return view('index.user.kegiatan.kegiatan-list', compact('data'));
    }
}
