<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeStudentController extends Controller
{
    public function index()
    {

        return view('index.student.index');
    }
}
