<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminSASController extends Controller
{
     // Halaman Input Sumatif Tengah Semester
    public function inputSAS()
    {
        return view('input.sas');
    }
}
