<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Rapor;
use App\Models\Ekskul;
use App\Models\EkskulSiswa;

class AdminCatatanController extends Controller
{
    /**
     * Tampilkan halaman input catatan
     */
    public function inputCatatan(Request $request)
    {
        $kelas = Kelas::all();
        $siswa = Siswa::when($request->id_kelas, function($q) use ($request) {
            $q->where('id_kelas', $request->id_kelas);
        })->get();

        // Tahun ajaran static
            $tahunAjaranList = [
                "2025/2026",
                "2026/2027",
                "2027/2028",
                "2028/2029",
                "2029/2030"
            ];

            // Semester static
            $semesterList = ["Ganjil", "Genap"];

        // Ambil data rapor siswa jika sudah pilih filter
        $rapor = null;
        $ekskul = collect();
        $siswaTerpilih = null;

        if ($request->id_kelas && $request->id_siswa) {
            $siswaTerpilih = Siswa::find($request->id_siswa);

            $rapor = \DB::table('catatan')
                    ->where('id_kelas', $request->id_kelas)
                    ->where('id_siswa', $request->id_siswa)
                    ->where('tahun_ajaran', $request->tahun_ajaran)
                    ->where('semester', $request->semester)
                    ->first();

            // Ambil ekskul jika sudah ada
            $ekskul = Ekskul::all();

    }

        return view('input.catatan', [
            'kelas' => $kelas,
            'siswa' => $siswa,
            'request' => $request,
            'rapor' => $rapor,
            'ekskul' => $ekskul,
            'siswaTerpilih' => $siswaTerpilih,
            'tahunAjaranList' => $tahunAjaranList,
            'semesterList' => $semesterList,
        ]);
    }

    /**
     * AJAX get siswa berdasarkan kelas
     */
public function getSiswa($id_kelas)
{
    try {
        return Siswa::where('id_kelas', $id_kelas)->get();
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage()
        ], 500);
    }
}


    /**
     * Simpan Catatan Rapor
     */
public function simpanCatatan(Request $request)
{
    // Ubah ekskul menjadi string
    $idEkskul = [];
    $keteranganEkskul = [];

    if ($request->has('ekskul')) {
        foreach ($request->ekskul as $e) {
            if (!empty($e['id_ekskul'])) {
                $idEkskul[] = $e['id_ekskul'];
                $keteranganEkskul[] = $e['keterangan'] ?? '';
            }
        }
    }

    // Simpan catatan utama
    \DB::table('catatan')->updateOrInsert(
        [
            'id_kelas' => $request->id_kelas,
            'id_siswa' => $request->id_siswa,
            'tahun_ajaran' => $request->tahun_ajaran,
            'semester' => $request->semester,
        ],
        [
            'kokurikuler' => $request->kokurikuler,
            'id_ekskul'   => implode(',', $idEkskul),          // SIMPAN BANYAK id ekskul
            'keterangan'  => implode(' | ', $keteranganEkskul), // SIMPAN BANYAK keterangan
            'sakit' => $request->sakit,
            'ijin' => $request->ijin,
            'alpha' => $request->alpha,
            'catatan_wali_kelas' => $request->catatan_wali_kelas,
            'updated_at' => now(),
        ]
    );

    return back()->with('success', 'Berhasil disimpan!');
}


}