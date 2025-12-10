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
        $siswa = Siswa::with(['kelas','detail'])->findOrFail($id_siswa);

    $nilai = Rapor::with('mapel')
        ->where('id_siswa',$id_siswa)
        ->orderBy('id_mapel')
        ->get();

    return Pdf::loadView('cetak.rapor_pdf', compact('siswa','nilai'))
        ->setPaper('A4', 'portrait')
        ->stream("RAPOR_{$siswa->nama_siswa}.pdf");
    }

    public function raporPdfMassal(Request $request)
    {
        if(!$request->id_siswa){
            return back()->with('warning','Pilih minimal satu siswa!');
        }

        $siswa = Siswa::whereIn('id_siswa', $request->id_siswa)->get();

        $pdf = PDF::loadView('cetak.pdf.massal_rapor', compact('siswa'))
                ->setPaper('a4', 'portrait');

        return $pdf->download('RAPOR_MASSAL_'.date('Y').'.pdf');
    }

}
