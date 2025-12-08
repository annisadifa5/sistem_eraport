<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use App\Models\NilaiTugas;
use App\Models\TahunAjaran;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Tugas;
=======
>>>>>>> 10de75b1645ab26b2c7f9a3ca811660a3d28312e
use Illuminate\Http\Request;


class AdminTugasController extends Controller
{
    // Halaman Input Tugas
    public function inputTugas()
    {
<<<<<<< HEAD
        $tahun = date('Y');
        return $tahun . '/' . ($tahun + 1);
    }

    // 🔥 Generate dropdown tahun ajaran otomatis 5 tahun
    private function generateTahunAjaran()
    {
        $tahunSekarang = date('Y');
        $list = [];

        for ($i = 0; $i < 5; $i++) {
            $awal = $tahunSekarang + $i;
            $akhir = $awal + 1;
            $list[] = $awal . '/' . $akhir;
        }

        return $list;
    }

    public function index()
    {
        return view('input.tugas', [
            'kelas' => Kelas::all(),
            'mapel' => MataPelajaran::all(),
            'ajaran' => $this->generateTahunAjaran(),
            'semester' => ['Ganjil', 'Genap'] // static
        ]);
    }

    public function filter(Request $request)
    {
        $siswa = Siswa::where('kelas_id', $request->kelas_id)->get();
        $tahunAjaran = $this->getCurrentTahunAjaran();

        $data = $siswa->map(function($s) use ($request, $tahunAjaran) {
            $nilai = NilaiTugas::where('id_siswa', $s->id)
                ->where('id_mapel', $request->id_mapel)
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

//pdf csv
public function exportPdf()
{
    $data = Tugas::with('siswa')->get();

    $mapped = $data->map(function ($item, $index) {
        return [
            'no'          => $index + 1,
            'nama'        => $item->siswa->nama ?? '-',
            'nis'         => $item->siswa->nis ?? '-',
            'nilai'       => $item->nilai ?? '-',
            'kkm'         => 75,
            'keterangan'  => ($item->nilai >= 75) ? 'Tuntas' : 'Belum Tuntas',
        ];
    });

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
        'exports.tugas_pdf',
        ['data' => $mapped]
    );

    return $pdf->download('nilai-tugas.pdf');
}


public function exportCsv()
{
    $data = Tugas::with('siswa')->get();

    $filename = "nilai-tugas.csv";

    return response()->streamDownload(function() use ($data) {

        $file = fopen('php://output', 'w');

        // HEADER CSV
        fputcsv($file, ['No', 'Nama Siswa', 'NIS', 'Nilai', 'KKM', 'Keterangan']);

        $no = 1;
        foreach ($data as $item) {
            fputcsv($file, [
                $no++,
                $item->siswa->nama ?? '-',
                $item->siswa->nis ?? '-',
                $item->nilai ?? '-',
                75,
                ($item->nilai >= 75) ? 'Tuntas' : 'Belum Tuntas',
            ]);
        }

        fclose($file);

    }, $filename, [
        'Content-Type' => 'text/csv'
    ]);
}

 
=======
        return view('input.tugas');
    }
>>>>>>> 10de75b1645ab26b2c7f9a3ca811660a3d28312e
}
