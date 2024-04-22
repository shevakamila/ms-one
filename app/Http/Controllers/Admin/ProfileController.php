<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function pageProfile()
    {
        $data['user'] = Auth::user();
        $data['active'] = 'profile';
        return view('index.admin.profile.index', compact('data'));
    }
}
