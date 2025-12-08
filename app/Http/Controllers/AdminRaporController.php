<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\MataPelajaran;
use App\Models\Rapor;

class AdminRaporController extends Controller
{
    public function inputRapor(Request $request)
    {
        // Ambil dropdown kelas & mapel
        $kelas = Kelas::all();
        $mapel = MataPelajaran::all();

        // ambil semua siswa untuk dropdown (optional)
        $siswa = ($request->id_kelas)
                    ? Siswa::where('id_kelas', $request->id_kelas)->get()
                    : collect();

        // ambil hanya siswa terpilih untuk tampilkan form
        $siswaTerpilih = ($request->id_siswa)
                    ? Siswa::find($request->id_siswa)
                    : null;
        
        $rapor = null;
        if ($request->id_siswa && $request->id_mapel) {
            $rapor = Rapor::where('id_siswa', $request->id_siswa)
                        ->where('id_mapel', $request->id_mapel)
                        ->first();
        }


        return view('input.rapor', [
        'kelas' => $kelas,
        'mapel' => $mapel,
        'siswa' => $siswa,
        'siswaTerpilih' => $request->id_siswa ? Siswa::find($request->id_siswa) : null,
        'rapor' => $rapor,
        'request' => $request
    ]);
    }

    public function simpanRapor(Request $request)
    {
        Rapor::updateOrCreate(
            [
                'id_siswa' => $request->id_siswa,
                'id_mapel' => $request->id_mapel,
            ],
            [
                'id_kelas' => $request->id_kelas,
                'nilai'    => $request->nilai,
                'capaian'  => $request->capaian,
            ]
        );

        return redirect()->route('input.rapor', [
            'id_kelas' => $request->id_kelas,
            'id_siswa' => $request->id_siswa,
            'id_mapel' => $request->id_mapel,
        ])->with('success', 'Nilai berhasil disimpan!');

    }

    public function getSiswa($id_kelas)
    {
        return Siswa::where('id_kelas', $id_kelas)->get();
    }

}
