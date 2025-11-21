<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminSTSController extends Controller
{
    // Halaman Input Sumatif Tengah Semester
    public function inputSTS()
    {
        return view('input.sts');
    }

}
