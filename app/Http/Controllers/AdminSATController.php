<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminSATController extends Controller
{
    // Halaman Input Sumatif Tengah Semester
    public function inputSAT()
    {
        return view('input.sat');
    }

}
