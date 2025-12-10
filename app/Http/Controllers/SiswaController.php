<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\DetailSiswa;
use App\Models\Kelas; // Diperlukan untuk dropdown
use App\Models\Ekskul; // Diperlukan untuk dropdown
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon; // Digunakan untuk format tanggal

class SiswaController extends Controller
{
    // Field fillable untuk Siswa
    protected $siswaFillable = ['nipd', 'nisn', 'nama_siswa', 'jenis_kelamin', 'tingkat', 'id_kelas', 'id_ekskul'];

    /**
     * Tampilkan daftar semua siswa (index).
     */
    public function index(Request $request)
    {
        $query = Siswa::with('kelas', 'ekskul');
        // Eager load relasi kelas dan ekskul untuk tampilan index
        $siswas = Siswa::with('kelas', 'ekskul')->paginate(20); 
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            
            // Mencari nama siswa yang mengandung string pencarian (case-insensitive)
            // $query->where('nama_siswa', 'like', '%' . $search . '%');
            
            // Opsi: Anda juga bisa menambahkan pencarian berdasarkan NISN atau NIPD
            
            $query->where(function ($q) use ($search) {
                $q->where('nama_siswa', 'like', '%' . $search . '%')
                  ->orWhere('nisn', 'like', '%' . $search . '%')
                  ->orWhere('nipd', 'like', '%' . $search . '%');
            });
            
        }
        
        // 2. Terapkan Pagination dan ambil hasil
        $siswas = $query->paginate(20)->withQueryString();
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
            
            // 1. Hapus data UlanganHarian terkait (hasMany)
            //    Panggil delete() pada query builder relasi
            $siswa->ulangan()->delete(); 
            
            // 2. Hapus data DetailSiswa terkait (hasOne)
            //    Panggil delete() pada query builder relasi, lebih aman daripada menghapus instance.
            $siswa->detail()->delete(); // <<< PERBAIKAN DI SINI

            // 3. Hapus Model Siswa utama
            $siswa->delete();

            DB::commit();
            return redirect()->route('siswa.index')->with('success', 'Data Siswa dan detailnya berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            // Log error secara detail
            \Log::error("Gagal menghapus Siswa $id: " . $e->getMessage()); 
            return redirect()->back()->with('error', 'Gagal menghapus data siswa: ' . $e->getMessage());
        }
    }

    // =========================================================================
    // IMPORT CSV METHOD (Revisi Lengkap)
    // =========================================================================

    public function importCsv(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        $file = $request->file('file');

        // $rows = array_map('str_getcsv', file($file->getPathname()));

        $rawLines = file($file->getPathname());

        $rows = array_map(function ($line) {
            $line = str_replace(['`', '“', '”'], '"', $line);

            return str_getcsv($line, ',', '"', '\\');
        }, $rawLines);

        
        if (count($rows) < 10) {
            return back()->with('error', 'File CSV tidak valid!');
        }

        // ================================
        // HEADER CSV DI BARIS KE 5 (index 4)
        // ================================
        $headerRow1 = str_getcsv($rows[4][0]); // Baris 5
        $headerRow2 = str_getcsv($rows[5][0]); // Baris 6

        // Gabungkan dua baris header
        $rawHeader = array_merge($headerRow1, $headerRow2);

        $header = array_map(function ($h) {
            $h = strtolower(trim($h));
            $h = str_replace(["\r", "\n"], '_', $h);
            return str_replace([' ', '.', '-', '/', '\\', '(', ')'], '_', $h);
        }, $rawHeader);


        // ================================
        // DATA MULAI DARI BARIS 10 (index 9)
        // ================================
        $dataStart = 9;
        $count = 0;

        for ($i = $dataStart; $i < count($rows); $i++) {

            if (!isset($rows[$i][0]) || trim($rows[$i][0]) == '') {
                continue;
            }
            // $row = str_getcsv($rows[$i][0]);

            $row = str_getcsv($rows[$i][0] ?? '', ',', '"', '\\');

            if (count($row) <= 1) {
                $row = str_getcsv($rawLines[$i], ',', '"', '\\');
            }

            if (count($row) < count($header)) {
                $row = array_pad($row, count($header), null);
            }
            if (count($row) > count($header)) {
                $row = array_slice($row, 0, count($header));
            }

            $mapped = array_combine($header, $row);
            if (!$mapped) continue;

            // ================================
            // GENERATE KELAS DARI ROMBEL CSV
            // ================================
            $rombel = $mapped['rombel_saat_ini'] ?? null;  // contoh: "10 AKL 1"

            $idKelas = null;
            $tingkat = null;

            if ($rombel) {
                // Ambil angka tingkat (misal "10")
                $parts = explode(' ', $rombel);
                $tingkat = is_numeric($parts[0]) ? intval($parts[0]) : 10;

                // Cek apakah kelas sudah ada di tabel kelas
                $kelas = Kelas::where('nama_kelas', $rombel)->first();

                if (!$kelas) {
                    $kelas = Kelas::create([
                        'nama_kelas' => $rombel,      
                        'tingkat'    => $tingkat,      
                        'jurusan'    => $parts[1] ?? '', 
                        'wali_kelas' => null,         
                        'jumlah_siswa' => 0,
                    ]);
                }

                $idKelas = $kelas->id_kelas;
            }


            // Data Ayah (kolom 24–29)
            $mapped['data_ayah_nama']               = $row[24] ?? null;
            $mapped['data_ayah_tahun_lahir']        = $row[25] ?? null;
            $mapped['data_ayah_jenjang_pendidikan'] = $row[26] ?? null;
            $mapped['data_ayah_pekerjaan']          = $row[27] ?? null;
            $mapped['data_ayah_penghasilan']        = $row[28] ?? null;
            $mapped['data_ayah_nik']                = $row[29] ?? null;

            // Data Ibu (kolom 30–35)
            $mapped['data_ibu_nama']                = $row[30] ?? null;
            $mapped['data_ibu_tahun_lahir']         = $row[31] ?? null;
            $mapped['data_ibu_jenjang_pendidikan']  = $row[32] ?? null;
            $mapped['data_ibu_pekerjaan']           = $row[33] ?? null;
            $mapped['data_ibu_penghasilan']         = $row[34] ?? null;
            $mapped['data_ibu_nik']                 = $row[35] ?? null;

            // Data Wali (kolom 36–41)
            $mapped['data_wali_nama']               = $row[36] ?? null;
            $mapped['data_wali_tahun_lahir']        = $row[37] ?? null;
            $mapped['data_wali_jenjang_pendidikan'] = $row[38] ?? null;
            $mapped['data_wali_pekerjaan']          = $row[39] ?? null;
            $mapped['data_wali_penghasilan']        = $row[40] ?? null;
            $mapped['data_wali_nik']                = $row[41] ?? null;

            // Fix nama kolom rusak
            $mapped['no_kps'] = $mapped['no__kps'] ?? null;

            // Kolom rusak panjang (jumlah saudara kandung)
            $mapped['jml_saudara_kandung'] = preg_replace('/[^0-9]/', '', ($row[64] ?? ''));

            // Jarak rumah (jika ada)
            $mapped['jarak_rumah'] = $row[65] ?? null;

            // ========================================
            // PECAH ROMBEL SAAT INI → tingkat + kelas
            // ========================================
            $rombel = $mapped['rombel_saat_ini'] ?? null;

            if ($rombel) {
                // Ambil angka pertama sebagai tingkat
                preg_match('/^\d+/', $rombel, $match);
                $mapped['tingkat'] = $match[0] ?? null;

                // Kelas lengkap tetap sama
                $mapped['kelas'] = $rombel;
            } else {
                $mapped['tingkat'] = null;
                $mapped['kelas'] = null;
            }

            // ================================
            //  INSERT KE TABLE SISWA
            // ================================
            $siswa = Siswa::create([
                'nipd'          => $mapped['nipd'] ?? null,
                'nisn'          => $mapped['nisn'] ?? null,
                'nama_siswa'    => $mapped['nama'] ?? null,
                'jenis_kelamin' => $mapped['jk'] ?? null,
                'tingkat'       => $tingkat,
                'id_kelas'      => $idKelas, 
                'id_ekskul'     => null,
            ]);

            // ================================
            // UPDATE JUMLAH SISWA DI TABLE KELAS
            // ================================
            if ($idKelas) {
                Kelas::where('id_kelas', $idKelas)->increment('jumlah_siswa');
            }


            // ================================
            // INSERT KE TABLE DETAIL SISWA
            // ================================
            DetailSiswa::create([
                'id_siswa' => $siswa->id_siswa,
                'id_kelas' => $idKelas, 

                'tempat_lahir' => $mapped['tempat_lahir'] ?? null,
                'tanggal_lahir' => $mapped['tanggal_lahir'] ?? null,
                'agama' => $mapped['agama'] ?? null,
                'alamat' => $mapped['alamat'] ?? null,
                'kelurahan' => $mapped['kelurahan'] ?? null,
                'kecamatan' => $mapped['kecamatan'] ?? null,
                'kode_pos' => $mapped['kode_pos'] ?? null,
                'telepon' => $mapped['telepon'] ?? null,
                'no_hp' => $mapped['hp'] ?? null,
                'email' => $mapped['e_mail'] ?? null,
                'nik' => $mapped['nik'] ?? null,
                'rt' => $mapped['rt'] ?? null,
                'rw' => $mapped['rw'] ?? null,
                'dusun' => $mapped['dusun'] ?? null,
                'jenis_tinggal' => $mapped['jenis_tinggal'] ?? null,
                'alat_transportasi' => $mapped['alat_transportasi'] ?? null,
                'skhun' => $mapped['skhun'] ?? null,
                'penerima_kps' => $mapped['penerima_kps'] ?? null,
                'no_kps' => $mapped['no_kps'] ?? null,
                'rombel' => $mapped['kelas'] ?? null,
                'no_peserta_ujian_nasional' => $mapped['no_peserta_ujian_nasional'] ?? null,
                'no_seri_ijazah' => $mapped['no_seri_ijazah'] ?? null,
                'penerima_kip' => $mapped['penerima_kip'] ?? null,
                'no_kip' => $mapped['nomor_kip'] ?? null,
                'nama_kip' => $mapped['nama_di_kip'] ?? null,
                'no_kks' => $mapped['nomor_kks'] ?? null,
                'no_regis_akta_lahir' => $mapped['no_registrasi_akta_lahir'] ?? null,
                'bank' => $mapped['bank'] ?? null,
                'no_rek_bank' => $mapped['nomor_rekening_bank'] ?? null,
                'rek_atas_nama' => $mapped['rekening_atas_nama'] ?? null,
                'layak_pip_usulan' => $mapped['layak_pip__usulan_dari_sekolah_'] ?? null,
                'alasan_layak_pip' => $mapped['alasan_layak_pip'] ?? null,
                'kebutuhan_khusus' => $mapped['kebutuhan_khusus'] ?? null,
                'sekolah_asal' => $mapped['sekolah_asal'] ?? null,
                'anak_ke_berapa' => $mapped['anak_ke_berapa'] ?? null,
                'lintang' => $mapped['lintang'] ?? null,
                'bujur' => $mapped['bujur'] ?? null,
                'no_kk' => $mapped['no_kk'] ?? null,
                'bb' => $mapped['berat_badan'] ?? null,
                'tb' => $mapped['tinggi_badan'] ?? null,
                'lingkar_kepala' => $mapped['lingkar_kepala'] ?? null,
                'jml_saudara_kandung' => $mapped['jml_saudara_kandung'],
                'jarak_rumah' => $mapped['jarak_rumah'] ?? null,


                // AYAH
                'nama_ayah' => $mapped['data_ayah_nama'] ?? null,
                'tahun_lahir_ayah' => $mapped['data_ayah_tahun_lahir'] ?? null,
                'jenjang_pendidikan_ayah' => $mapped['data_ayah_jenjang_pendidikan'] ?? null,
                'pekerjaan_ayah' => $mapped['data_ayah_pekerjaan'] ?? null,
                'penghasilan_ayah' => $mapped['data_ayah_penghasilan'] ?? null,
                'nik_ayah' => $mapped['data_ayah_nik'] ?? null,

                // IBU
                'nama_ibu' => $mapped['data_ibu_nama'] ?? null,
                'tahun_lahir_ibu' => $mapped['data_ibu_tahun_lahir'] ?? null,
                'jenjang_pendidikan_ibu' => $mapped['data_ibu_jenjang_pendidikan'] ?? null,
                'pekerjaan_ibu' => $mapped['data_ibu_pekerjaan'] ?? null,
                'penghasilan_ibu' => $mapped['data_ibu_penghasilan'] ?? null,
                'nik_ibu' => $mapped['data_ibu_nik'] ?? null,

                // WALI
                'nama_wali' => $mapped['data_wali_nama'] ?? null,
                'tahun_lahir_wali' => $mapped['data_wali_tahun_lahir'] ?? null,
                'jenjang_pendidikan_wali' => $mapped['data_wali_jenjang_pendidikan'] ?? null,
                'pekerjaan_wali' => $mapped['data_wali_pekerjaan'] ?? null,
                'penghasilan_wali' => $mapped['data_wali_penghasilan'] ?? null,
                'nik_wali' => $mapped['data_wali_nik'] ?? null,
            ]);

            $count++;
        }

        return back()->with('success', "Import selesai! Total baris masuk: $count");
    }
}
