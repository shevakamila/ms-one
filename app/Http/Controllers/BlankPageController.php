<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlankPageController extends Controller
{
    public function index()
    {

        $data = [];
        return view('index.blank', compact('data'));
    }
}
