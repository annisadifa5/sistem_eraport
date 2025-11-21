<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InfoSekolah;

class InfoSekolahController extends Controller
{
    // Halaman Info Sekolah
    public function infoSekolah()
    {
        //ambil data info dari db
        $info = InfoSekolah::first();

        return view('dashboard.info_sekolah', compact('info'));
    }

    public function update_info_sekolah(Request $request)
    {
        $info = InfoSekolah::first();

        if (!$info) {
            $info = new InfoSekolah();
        }

        $info->update([
            'nama_kepsek' => $request->nama_kepsek,
            'nip_kepsek' => $request->nip_kepsek,
        ]);

        return redirect()->route('dashboard.info_sekolah')
        ->with('success', 'Data kepala sekolah berhasil diperbarui!');
    }
}
