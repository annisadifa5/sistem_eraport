<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use App\Models\UlanganHarian;

class AdminUlanganController extends Controller
{
    public function inputUlangan(Request $request)
    {
        $kelas = Kelas::all();
        $tahunAjaran = TahunAjaran::all();
        $mapel = MataPelajaran::all();
        $siswa = [];

        $nilaiSudahAda = false;

        if ($request->id_kelas && $request->id_mapel && $request->semester && $request->id_tahun_ajaran && $request->tanggal) {

            $siswa = Siswa::where('id_kelas', $request->id_kelas)
            ->with(['ulangan' => function ($q) use ($request) {
                $q->where('id_mapel', $request->id_mapel)
                ->where('semester', $request->semester)
                ->where('id_tahun_ajaran', $request->id_tahun_ajaran)
                ->where('tanggal', $request->tanggal);
            }])
            ->get();

            $nilaiSudahAda = false;
            if (count($siswa) > 0) {
                foreach ($siswa as $s) {
                    if ($s->ulangan->count() > 0) {
                        $nilaiSudahAda = true;
                        break;
                    }
                }
            }


        }

        return view('input.ulangan', [
            'kelas' => $kelas,
            'mapel' => $mapel,
            'tahunAjaran' => $tahunAjaran,
            'siswa' => $siswa,
            'request' => $request,
            'nilaiSudahAda' => $nilaiSudahAda
        ]);
    }

    public function simpanUlangan(Request $request)
    {
        $kkm = 75;

        foreach ($request->nilai as $id_siswa => $nilai) {
            if ($nilai === null || $nilai === "") continue; // <-- nilai kosong dilewati
            
            $keterangan = $nilai >= $kkm ? "tuntas" : "belum_tuntas";

            UlanganHarian::updateOrCreate(
                [
                    'id_siswa' => $id_siswa,
                    'id_kelas' => $request->id_kelas,
                    'id_mapel' => $request->id_mapel,
                    'semester' => $request->semester,
                    'id_tahun_ajaran' => $request->id_tahun_ajaran,
                    'tanggal' => $request->tanggal,
                ],
                [
                    'nilai' => $nilai,
                    'kkm' => $kkm,
                    'keterangan' => $keterangan,
                    'id_user' => 1
                ]
            );
        }

        return back()->with('success', 'Nilai berhasil disimpan / diperbarui!');
    }
}
