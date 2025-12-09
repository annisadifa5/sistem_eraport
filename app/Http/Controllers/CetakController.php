<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CetakController extends Controller
{
    public function index()
    {
        return view('cetak.index'); // opsional
    }

    public function rapor(Request $request)
    {
        return view('cetak.rapor'); // view yang kemarin kita buat
    }

    public function raporPdf()
    {
        // sementara testing
        return "Generate PDF Rapor berhasil";
    }
}
