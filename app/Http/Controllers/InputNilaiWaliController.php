<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InputNilaiWaliController extends Controller
{
    // Halaman Input Tugas
    public function inputTugas()
    {
        return view('wali.input.tugas');
    }

    // Halaman Input Ulangan Harian
    public function inputUlangan()
    {
        return view('wali.input.ulangan');
    }

    // Halaman Input Sumatif Tengah Semester
    public function inputSTS()
    {
        return view('wali.input.sts');
    }

    // Halaman Input Sumatif Tengah Semester
    public function inputSAS()
    {
        return view('wali.input.sas');
    }

    // Halaman Input Sumatif Tengah Semester
    public function inputSAT()
    {
        return view('wali.input.sat');
    }

     // Halaman Cetak Nilai
    public function cetakNilai()
    {
        return view('wali.input.cetak');
    }
}
