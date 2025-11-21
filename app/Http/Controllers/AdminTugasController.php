<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminTugasController extends Controller
{
    // Halaman Input Tugas
    public function inputTugas()
    {
        return view('input.tugas');
    }
}
