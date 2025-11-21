<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ekskul;
use App\Models\EkskulSiswa;
use App\Models\Guru;
use App\Models\Siswa;

class EkskulController extends Controller
{
    public function dataEkskul()
    {
        $ekskul = Ekskul::with('guru')->get();
        $siswaEkskul = EkskulSiswa::with(['siswa', 'ekskul.guru'])->get();
        $guru = Guru::orderBy('nama_guru')->get();
        $siswa = Siswa::orderBy('nama_siswa')->get();

        return view('dashboard.data_ekskul', compact('ekskul', 'guru', 'siswa', 'siswaEkskul'));
    }

    // === CRUD Ekskul ===
    public function storeEkskul(Request $request)
    {
        $request->validate([
            'nama_ekskul' => 'required|string|max:100',
            'id_guru' => 'required|exists:guru,id_guru',
            'jadwal_ekskul' => 'required|string|max:100',
        ]);

        Ekskul::create($request->only('nama_ekskul', 'id_guru', 'jadwal_ekskul'));

        return redirect()->back()->with('success', 'Data ekskul berhasil ditambahkan.');
    }

    public function updateEkskul(Request $request, $id_ekskul)
    {
        $ekskul = Ekskul::findOrFail($id_ekskul);

        $request->validate([
            'nama_ekskul' => 'required|string|max:100',
            'id_guru' => 'required|exists:guru,id_guru',
            'jadwal_ekskul' => 'required|string|max:100',
        ]);

        $ekskul->update($request->only('nama_ekskul', 'id_guru', 'jadwal_ekskul'));

        return redirect()->back()->with('success', 'Data ekskul berhasil diperbarui.');
    }

    public function destroyEkskul($id_ekskul)
    {
        $ekskul = Ekskul::findOrFail($id_ekskul);
        $ekskul->delete();

        return redirect()->back()->with('success', 'Data ekskul berhasil dihapus.');
    }

    // === CRUD Siswa Ekskul ===
    public function storeSiswaEkskul(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required|exists:siswa,id_siswa',
            'id_ekskul' => 'required|exists:ekskul,id_ekskul',
        ]);

        EkskulSiswa::create($request->only('id_siswa', 'id_ekskul'));

        return redirect()->back()->with('success', 'Siswa berhasil ditambahkan ke ekskul.');
    }

    public function updateSiswaEkskul(Request $request, $id_ekskul_siswa)
    {
        $data = EkskulSiswa::findOrFail($id_ekskul_siswa);

        $request->validate([
            'id_siswa' => 'required|exists:siswa,id_siswa',
            'id_ekskul' => 'required|exists:ekskul,id_ekskul',
        ]);

        $data->update($request->only('id_siswa', 'id_ekskul'));

        return redirect()->back()->with('success', 'Data siswa ekskul berhasil diperbarui.');
    }

    public function destroySiswaEkskul($id_ekskul_siswa)
    {
        $data = EkskulSiswa::findOrFail($id_ekskul_siswa);
        $data->delete();

        return redirect()->back()->with('success', 'Siswa ekskul berhasil dihapus.');
    }
}
