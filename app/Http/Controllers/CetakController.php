<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kelas;
use Barryvdh\DomPDF\Facade\Pdf;

class CetakController extends Controller
{
    public function index(Request $request)
    {
        $kelas = Kelas::orderBy('tingkat')->get();

        // Jika belum memilih kelas → tampilkan kosong
        if (!$request->id_kelas || !$request->semester) {
            return view('cetak.index_rapor', [
                'kelas' => $kelas,
                'siswa' => [],
            ]);
        }

        $kelasDipilih = Kelas::find($request->id_kelas);

        $siswa = Siswa::where('id_kelas', $request->id_kelas)
                    ->orderBy('nama_siswa')
                    ->get();

        return view('cetak.index_rapor', [
            'kelas' => $kelas,
            'siswa' => $siswa,
            'kelasDipilih' => $kelasDipilih,
        ]);
    }

    /** Tampilkan halaman rapor */
    public function rapor($id_siswa)
    {
        $siswa = Siswa::with(['detail', 'kelas.guru'])->findOrFail($id_siswa);

        return view('cetak.rapor', compact('siswa'));
    }

    /** Export PDF rapor */
    public function raporPdf($id_siswa)
    {
        $siswa = Siswa::with(['detail', 'kelas.guru'])->findOrFail($id_siswa);

        $pdf = Pdf::loadView('cetak.rapor', compact('siswa'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('Rapor-'.$siswa->nama_siswa.'.pdf');
    }
}
