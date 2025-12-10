<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\DetailSiswa;
use App\Models\Kelas; // Diperlukan untuk dropdown
use App\Models\Ekskul; // Diperlukan untuk dropdown
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SiswaController extends Controller
{
    // Field fillable untuk Siswa
    protected $siswaFillable = ['nipd', 'nisn', 'nama_siswa', 'jenis_kelamin', 'tingkat', 'id_kelas', 'id_ekskul'];

    /**
     * Tampilkan daftar semua siswa (index).
     */
    public function index()
    {
        // Eager load relasi kelas dan ekskul untuk tampilan index
        $siswas = Siswa::with('kelas', 'ekskul')->paginate(20); 
        return view('siswa.index', compact('siswas'));
    }

    /**
     * Tampilkan form untuk membuat siswa baru.
     */
    public function create()
    {
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $ekskulList = Ekskul::orderBy('nama_ekskul')->get();
        
        return view('siswa.create', compact('kelasList', 'ekskulList'));
    }

    /**
     * Simpan siswa baru ke database (Multi-Model Transaction).
     */
    public function store(Request $request)
    {
        // 1. Validasi Data
        $request->validate([
            // Siswa (Wajib)
            'nipd' => 'required|string|max:20|unique:siswa,nipd',
            'nisn' => 'required|string|max:10|unique:siswa,nisn',
            'nama_siswa' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tingkat' => 'required|string|max:10',
            'id_kelas' => 'required|integer|exists:kelas,id_kelas',
            'id_ekskul' => 'nullable|integer|exists:ekskul,id_ekskul',

            // Detail Siswa (Beberapa field penting)
            'nik' => 'nullable|string|max:20|unique:detail_siswa,nik',
            'email' => 'nullable|email|unique:detail_siswa,email',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            // ... (Tambahkan validasi untuk field DetailSiswa lainnya)
        ]);

        DB::beginTransaction();
        try {
            // 2. Create Model Siswa
            $siswa = Siswa::create($request->only($this->siswaFillable));

            // 3. Create Model DetailSiswa (Relasi HasOne)
            $detailFields = (new DetailSiswa())->getFillable();
            
            // Hapus id_siswa dan id_kelas dari detailFields karena akan di-handle oleh relasi
            $detailData = $request->only(array_diff($detailFields, ['id_siswa', 'id_kelas']));

            // Hubungkan id_kelas juga di detail_siswa (jika diperlukan)
            $detailData['id_kelas'] = $request->id_kelas;

            $siswa->detail()->create($detailData);

            DB::commit();
            return redirect()->route('siswa.index')->with('success', 'Data Siswa berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Error saat menyimpan data Siswa: " . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data siswa: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail data siswa tertentu beserta relasinya.
     */
    public function show($id)
    {
        // Eager load relasi detail, kelas, dan ekskul
        $siswa = Siswa::with('detail', 'kelas', 'ekskul')->findOrFail($id);

        return view('siswa.show', compact('siswa'));
    }
    
    /**
     * Tampilkan form untuk mengedit siswa tertentu.
     */
    public function edit($id)
    {
        $siswa = Siswa::with('detail', 'kelas', 'ekskul')->findOrFail($id);
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $ekskulList = Ekskul::orderBy('nama_ekskul')->get();

        return view('siswa.edit', compact('siswa', 'kelasList', 'ekskulList'));
    }

    /**
     * Perbarui data siswa tertentu di database (Multi-Model Transaction).
     */
    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);
        
        // 1. Validasi Data
        $request->validate([
            // Siswa (Ignored for unique check)
            'nipd' => ['required', 'string', 'max:20', Rule::unique('siswa', 'nipd')->ignore($siswa->id_siswa, 'id_siswa')],
            'nisn' => ['required', 'string', 'max:10', Rule::unique('siswa', 'nisn')->ignore($siswa->id_siswa, 'id_siswa')],
            'nama_siswa' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'id_kelas' => 'required|integer|exists:kelas,id_kelas',
            // ... (Validasi lainnya)
            
            // Detail Siswa (Ignored for unique check)
            'nik' => ['nullable', 'string', 'max:20', Rule::unique('detail_siswa', 'nik')->ignore($siswa->id_siswa, 'id_siswa')],
            'email' => ['nullable', 'email', Rule::unique('detail_siswa', 'email')->ignore($siswa->id_siswa, 'id_siswa')],
        ]);
        
        DB::beginTransaction();
        try {
            // 2. Update Model Siswa
            $siswa->update($request->only($this->siswaFillable));

            // 3. Update Model DetailSiswa (updateOrCreate)
            $detailFields = (new DetailSiswa())->getFillable();
            $detailData = $request->only(array_diff($detailFields, ['id_siswa']));

            // Hubungkan id_kelas juga di detail_siswa
            $detailData['id_kelas'] = $request->id_kelas;

            $siswa->detail()->updateOrCreate(
                ['id_siswa' => $siswa->id_siswa],
                $detailData
            );

            DB::commit();
            return redirect()->route('siswa.index')->with('success', 'Data Siswa berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Error saat memperbarui data Siswa: " . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data siswa: ' . $e->getMessage());
        }
    }

    /**
     * Hapus siswa tertentu dari database (Multi-Model Transaction).
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $siswa = Siswa::findOrFail($id);
            
            // Hapus data DetailSiswa terkait
            if ($siswa->detail) {
                $siswa->detail->delete();
            }

            // Hapus Model Siswa utama
            $siswa->delete();

            DB::commit();
            return redirect()->route('siswa.index')->with('success', 'Data Siswa dan detailnya berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus data siswa: ' . $e->getMessage());
        }
    }
}