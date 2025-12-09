<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Rapor;
use App\Models\Ekskul;

class AdminCatatanController extends Controller
{
    /**
     * Tampilkan halaman input catatan
     */
    public function index(Request $request)
    {
        $kelas = Kelas::all();
        $siswa = Siswa::when($request->id_kelas, function($q) use ($request) {
            $q->where('id_kelas', $request->id_kelas);
        })->get();

        // Ambil data rapor siswa jika sudah pilih filter
        $rapor = null;
        $ekskul = collect();
        $siswaTerpilih = null;

        if ($request->id_kelas && $request->id_siswa) {
            $siswaTerpilih = Siswa::find($request->id_siswa);

            // Ambil rapor jika sudah ada
            $rapor = Rapor::where('id_kelas', $request->id_kelas)
                          ->where('id_siswa', $request->id_siswa)
                          ->first();

            // Ambil ekskul jika sudah ada
        if ($rapor) {
            $ekskul = Ekskul::where('id_rapor', $rapor->id_rapor)->get();
        }
        }

        return view('input.catatan', [
            'kelas' => $kelas,
            'siswa' => $siswa,
            'request' => $request,
            'rapor' => $rapor,
            'ekskul' => $ekskul,
            'siswaTerpilih' => $siswaTerpilih,
        ]);
    }

    /**
     * AJAX get siswa berdasarkan kelas
     */
    public function getSiswa($id_kelas)
    {
        return Siswa::where('id_kelas', $id_kelas)->get();
    }

    /**
     * Simpan Catatan Rapor
     */
public function simpan(Request $request)
{
    $request->validate([
        'id_kelas' => 'required',
        'id_siswa' => 'required',
    ]);

    // 1. Pastikan rapor ada (untuk ekskul)
    $rapor = Rapor::firstOrCreate([
        'id_kelas' => $request->id_kelas,
        'id_siswa' => $request->id_siswa
    ]);

    // 2. SIMPAN / UPDATE CATATAN RAPOR BERDASARKAN id_kelas + id_siswa
    \DB::table('catatan_rapor')->updateOrInsert(
        [
            'id_kelas' => $request->id_kelas,
            'id_siswa' => $request->id_siswa,
        ],
        [
            'kokurikuler' => $request->kokurikuler,
            'updated_at'  => now(),
        ]
    );

    // 3. HAPUS EKSKUL DETAIL LAMA BERDASARKAN RAPOR
    Ekskul::where('id_rapor', $rapor->id_rapor)->delete();

    // 4. SIMPAN EKSKUL DETAIL BARU
    if ($request->ekskul) {
        foreach ($request->ekskul as $ex) {
            if (!empty($ex['id'])) {
                Ekskul::create([
                    'id_rapor'   => $rapor->id_rapor,
                    'id_ekskul'  => $ex['id'],        // id dari dropdown
                    'keterangan' => $ex['keterangan'],
                ]);
            }
        }
    }

    return back()->with('success', 'Catatan rapor berhasil disimpan!');
}


}
