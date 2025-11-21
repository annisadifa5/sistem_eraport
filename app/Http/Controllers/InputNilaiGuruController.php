<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InputNilaiGuruController extends Controller
{
     // Halaman Input Tugas
    public function inputTugas()
    {
        return view('guru.input.tugas');
    }

    // Halaman Input Ulangan Harian
    public function inputUlangan()
    {
        return view('guru.input.ulangan');
    }

    // Halaman Input Sumatif Tengah Semester
    public function inputSTS()
    {
        return view('guru.input.sts');
    }

    // Halaman Input Sumatif Tengah Semester
    public function inputSAS()
    {
        return view('guru.input.sas');
    }

    // Halaman Input Sumatif Tengah Semester
    public function inputSAT()
    {
        return view('guru.input.sat');
    }
}
