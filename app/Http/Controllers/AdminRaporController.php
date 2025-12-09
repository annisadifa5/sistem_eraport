<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\MataPelajaran;
use App\Models\Rapor;
use App\Models\TahunAjaran;

class AdminRaporController extends Controller
{
    public function inputRapor(Request $request)
    {
        $kelas = Kelas::all();
        $mapel = MataPelajaran::all();
        $tahunAjaran = TahunAjaran::all();

        $siswa = collect();
        $rapor = collect();

        // Jika SEMUA filter dipilih
        if ($request->id_kelas && $request->id_mapel && $request->id_tahun_ajaran && $request->semester) {

            // konversi semester ganjil/genap
            $semester = $request->semester == 'ganjil' ? 1 : 2;

            $siswa = Siswa::where('id_kelas', $request->id_kelas)->get();

            $rapor = Rapor::where('id_kelas', $request->id_kelas)
                        ->where('id_mapel', $request->id_mapel)
                        ->where('id_tahun_ajaran', $request->id_tahun_ajaran)
                        ->where('semester', $semester)
                        ->get()
                        ->keyBy('id_siswa');
        }


        return view('input.rapor', [
            'kelas' => $kelas,
            'mapel' => $mapel,
            'tahunAjaran' => $tahunAjaran,
            'siswa' => $siswa,
            'rapor' => $rapor,
            'request' => $request
        ]);
    }

    public function simpanRapor(Request $request)
    {
        $request->validate([
        'id_kelas' => 'required',
        'id_mapel' => 'required',
        'id_tahun_ajaran' => 'required',
        'semester' => 'required',
        'id_siswa' => 'required|array',
    ]);
    $semester = $request->semester == 'ganjil' ? 1 : 2;

        foreach ($request->id_siswa as $index => $id_siswa) {

            $nilai = $request->nilai[$index];
            $capaian = $request->capaian[$index];

            // Jika keduanya kosong, skip simpan
            if ($nilai === null && (!$capaian || trim($capaian) === "")) {
            continue;
            }

            Rapor::updateOrCreate(
                [
                    'id_siswa'        => $id_siswa,
                    'id_mapel'        => $request->id_mapel,
                    'id_tahun_ajaran' => $request->id_tahun_ajaran,
                    'semester'        => $semester,
                ],
                [
                    'id_kelas' => $request->id_kelas,
                    'nilai'    => $nilai,
                    'capaian'  => $capaian,
                ]
            );
        }

        // Redirect agar data tampil kembali setelah saving
        return redirect()->route('input.rapor', [
            'id_kelas'        => $request->id_kelas,
            'id_mapel'        => $request->id_mapel,
            'id_tahun_ajaran' => $request->id_tahun_ajaran,
            'semester'        => $request->semester,
        ])->with('success', 'Nilai berhasil disimpan!');
    }
}
