<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AboutUsController extends Controller
{
    public function index()
    {

        $data = [];
        $data['user'] = Auth::user();
        return view('index.about-us', compact('data'));
    }
}
