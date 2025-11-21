<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminCetakController extends Controller
{
    // Halaman Cetak Nilai
    public function cetakNilai()
    {
        return view('input.cetak');
    }
}
