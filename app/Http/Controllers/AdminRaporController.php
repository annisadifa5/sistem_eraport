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
        $kelas = Kelas::all();
        $mapel = MataPelajaran::all();

        $siswa = collect();
        $rapor = collect();

        // Jika kelas & mapel sudah dipilih → tampilkan tabel seluruh siswa
        if ($request->id_kelas && $request->id_mapel) {

            // Semua siswa dalam kelas
            $siswa = Siswa::where('id_kelas', $request->id_kelas)->get();

            // Ambil rapor per siswa (jika ada)
            $rapor = Rapor::where('id_kelas', $request->id_kelas)
                        ->where('id_mapel', $request->id_mapel)
                        ->get()
                        ->keyBy('id_siswa'); 
        }

        return view('input.rapor', [
            'kelas' => $kelas,
            'mapel' => $mapel,
            'siswa' => $siswa,
            'rapor' => $rapor,
            'request' => $request,
        ]);
    }

    public function simpanRapor(Request $request)
    {
        foreach ($request->id_siswa as $index => $id_siswa) {

            Rapor::updateOrCreate(
                [
                    'id_siswa' => $id_siswa,
                    'id_mapel' => $request->id_mapel,
                ],
                [
                    'id_kelas' => $request->id_kelas,
                    'nilai'    => $request->nilai[$index],
                    'capaian'  => $request->capaian[$index],
                ]
            );
        }

        return back()->with('success', 'Nilai berhasil disimpan / diperbarui!');
    }


    public function getSiswa($id_kelas)
    {
        return Siswa::where('id_kelas', $id_kelas)->get();
    }

}
