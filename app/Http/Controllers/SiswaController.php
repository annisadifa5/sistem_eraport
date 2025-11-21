<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\DetailSiswa;
use App\Models\Kelas;
use App\Models\Ekskul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    /**
     * Tampilkan list siswa
     */
    public function dataSiswa()
    {
        $siswa = Siswa::with('kelas')->get();
        $kelas = Kelas::all();
        $ekskul = Ekskul::all();

        return view('dashboard.data_siswa', compact('siswa', 'kelas', 'ekskul'));
    }

    /**
     * Simpan siswa + detail siswa (modal tambah)
     */
    public function store(Request $request)
    {
        // Validasi siswa
        $request->validate([
            'nipd'          => 'required',
            'nisn'          => 'required',
            'nama_siswa'    => 'required',
            'jenis_kelamin' => 'required',
            'tingkat'       => 'required',
            'id_kelas'      => 'required'
        ]);

        DB::transaction(function () use ($request) {

            // Insert ke tabel siswa
            $siswa = Siswa::create([
                'nipd'          => $request->nipd,
                'nisn'          => $request->nisn,
                'nama_siswa'    => $request->nama_siswa,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tingkat'       => $request->tingkat,
                'id_kelas'      => $request->id_kelas,
                'id_ekskul'     => $request->id_ekskul,
            ]);

            // Ambil semua data detail
            $detailData = $request->except([
                'nipd',
                'nisn',
                'nama_siswa',
                'jenis_kelamin',
                'tingkat',
                'id_ekskul',
                '_token',
            ]);

            // WAJIB: id_siswa
            $detailData['id_siswa'] = $siswa->id_siswa; // gunakan PK yg benar

            // simpan detail
            DetailSiswa::create($detailData);
        });

        return back()->with('success', 'Siswa berhasil ditambahkan');
    }


    /**
     * Detail siswa (modal hanya view)
     */
    public function show($id)
    {
        $siswa = Siswa::with('detail', 'kelas')->findOrFail($id);
        return response()->json($siswa);
    }

    /**
     * Ambil data untuk modal edit
     */
    public function edit($id)
    {
        $siswa = Siswa::with('detail')->findOrFail($id);
        return response()->json($siswa);
    }

    /**
     * Update siswa + detail siswa
     */
    public function update(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {

            $siswa = Siswa::findOrFail($id);

            // Update data siswa
            $siswa->update([
                'nipd'          => $request->nipd,
                'nisn'          => $request->nisn,
                'nama_siswa'    => $request->nama_siswa,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tingkat'       => $request->tingkat,
                'id_kelas'      => $request->id_kelas,
                'nama_kelas'    => $siswa->kelas->nama_kelas, 
                'id_ekskul'     => $request->id_ekskul,
            ]);

            // Ambil data detail siswa
            $detailData = $request->except([
                'nipd', 'nisn', 'nama_siswa', 'jenis_kelamin', 
                'tingkat', 'id_ekskul'
            ]);

            // Jika detail belum ada, buat
            if (!$siswa->detail) {
                $detailData['id_siswa'] = $id;
                DetailSiswa::create($detailData);
            } else {
                $siswa->detail->update($detailData);
            }

        });

        return redirect()->back()->with('success', 'Data siswa berhasil diperbarui');
    }

    /**
     * Hapus siswa + detail siswa
     */
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {

            // Hapus detail siswa
            DetailSiswa::where('id_siswa', $id)->delete();

            // Hapus siswa
            Siswa::where('id_siswa', $id)->delete();
        });

        return redirect()->back()->with('success', 'Data siswa berhasil dihapus');
    }

    public function export()
    {
        return response()->json([
            'status' => 'ok',
            'message' => 'Export function works'
        ]);
    }

}
