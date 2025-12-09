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
    public function inputCatatan(Request $request)
    {
        $kelas = Kelas::all();
        $siswa = Siswa::when($request->id_kelas, fn($q) =>
            $q->where('id_kelas', $request->id_kelas)
        )->get();

        $rapor = null;
        $nilaiEkskul = collect();
        $siswaTerpilih = null;

        // Ambil daftar ekskul master
        $listEkskul = Ekskul::all();

        if ($request->id_kelas && $request->id_siswa) {

            $siswaTerpilih = Siswa::find($request->id_siswa);

            // Ambil rapor (atau buat baru)
            $rapor = Rapor::where('id_kelas', $request->id_kelas)
             ->where('id_siswa', $request->id_siswa)
             ->first();


            // Ambil data ekskul anak
            $nilaiEkskul = EkskulSiswa::where('id_rapor', $rapor->id_rapor)->get();
        }

        return view('input.catatan', [
            'kelas' => $kelas,
            'siswa' => $siswa,
            'request' => $request,
            'rapor' => $rapor,
            'nilaiEkskul' => $nilaiEkskul,
            'siswaTerpilih' => $siswaTerpilih,
            'listEkskul' => $listEkskul,
        ]);
    }

    public function getSiswa($id_kelas)
    {
        return Siswa::where('id_kelas', $id_kelas)->get();
    }

    public function simpanCatatan(Request $request)
    {
        $request->validate([
            'id_kelas' => 'required',
            'id_siswa' => 'required',
            'sakit' => 'required|integer|min(0)',
            'ijin' => 'required|integer|min(0)',
            'alpha' => 'required|integer|min(0)',
            'catatan_wali_kelas' => 'nullable|string',
            'konkurikuler' => 'nullable|string',
            'ekskul' => 'nullable|array',
        ]);

        // simpan catatan utama
        $catatan = \App\Models\Catatan::updateOrCreate(
            [
                'id_kelas' => $request->id_kelas,
                'id_siswa' => $request->id_siswa,
            ],
            [
                'konkurikuler' => $request->konkurikuler,
                'sakit' => $request->sakit,
                'ijin' => $request->ijin,
                'alpha' => $request->alpha,
                'catatan_wali_kelas' => $request->catatan_wali_kelas,
            ]
        );

        // Hapus ekskul lama
        \App\Models\EkskulSiswa::where('id_catatan', $catatan->id_catatan)->delete();

        // Simpan ekskul baru
        if ($request->ekskul) {
            foreach ($request->ekskul as $ex) {
                if ($ex['id_ekskul']) {
                    \App\Models\EkskulSiswa::create([
                        'id_catatan' => $catatan->id_catatan,
                        'id_ekskul' => $ex['id_ekskul'],
                        'keterangan' => $ex['keterangan'] ?? '',
                    ]);
                }
            }
        }

        return back()->with('success', 'Catatan rapor berhasil disimpan!');
    }

}