<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InfoSekolah;

class DashboardController extends Controller
{
    // Halaman utama Admin (dashboard)
    public function index()
    {
        return view('dashboard.index');
    }
    
    // Halaman utama Guru (dashboard)
    public function indexGuru()
    {
        return view('guru.input.index_guru');
    }

    // Halaman utama Wali (dashboard)
    public function indexWali()
    {
        return view('wali.input.index_wali');
    }
}
