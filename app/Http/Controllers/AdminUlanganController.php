<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminUlanganController extends Controller
{
    // Halaman Input Ulangan Harian
    public function inputUlangan()
    {
        return view('input.ulangan');
    }
}
