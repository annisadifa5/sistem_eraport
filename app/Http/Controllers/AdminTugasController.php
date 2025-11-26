<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\NilaiTugas;
use Illuminate\Http\Request;

class AdminTugasController extends Controller
{
    // Tahun ajaran otomatis
    private function getCurrentTahunAjaran()
    {
        $tahun = date('Y');
        return $tahun . '/' . ($tahun + 1);
    }

    public function index()
    {
        return view('input_tugas', [
            'kelas' => Kelas::all(),
            'mapel' => Mapel::all(),
            'tahun_ajaran' => $this->getCurrentTahunAjaran(),
            'semester' => ['Ganjil', 'Genap'] // static
        ]);
    }

    public function filter(Request $request)
    {
        $siswa = Siswa::where('kelas_id', $request->kelas_id)->get();
        $tahunAjaran = $this->getCurrentTahunAjaran();

        $data = $siswa->map(function($s) use ($request, $tahunAjaran) {
            $nilai = NilaiTugas::where('siswa_id', $s->id)
                ->where('mapel_id', $request->mapel_id)
                ->where('kategori', $request->kategori)
                ->where('tanggal', $request->tanggal)
                ->where('tahun_ajaran', $tahunAjaran)
                ->where('semester', $request->semester)
                ->first();

            return [
                'id' => $s->id,
                'nama' => $s->nama,
                'nis' => $s->nis,
                'nilai' => $nilai->nilai ?? '',
                'kkm' => 75,
                'keterangan' => ($nilai && $nilai->nilai >= 75) ? 'Tuntas' : 'Belum Tuntas',
            ];
        });

        return response()->json($data);
    }

    public function simpanSemua(Request $request)
    {
        $tahunAjaran = $this->getCurrentTahunAjaran();

        foreach ($request->nilai as $item) {
            NilaiTugas::updateOrCreate(
                [
                    'siswa_id' => $item['siswa_id'],
                    'mapel_id' => $request->mapel_id,
                    'kategori' => $request->kategori,
                    'tanggal' => $request->tanggal,
                    'tahun_ajaran' => $tahunAjaran,
                    'semester' => $request->semester,
                ],
                [
                    'nilai' => $item['nilai'],
                    'kkm' => 75
                ]
            );
        }

        return response()->json(['status' => 'success']);
    }
}
