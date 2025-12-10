<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\DetailSiswa;
use App\Models\Kelas;
use App\Models\Ekskul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use League\Csv\Reader;




class SiswaController extends Controller
{
    /**
     * Tampilkan list siswa
     */
    public function dataSiswa(Request $request)
    {
        $query = Siswa::with('kelas');

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_siswa', 'like', '%'.$request->search.'%')
                ->orWhere('nisn', 'like', '%'.$request->search.'%')
                ->orWhere('nipd', 'like', '%'.$request->search.'%');
        }

        $siswa = $query->paginate(50);

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

    public function export($id)
    {
        $s = Siswa::with('detail')->findOrFail($id);
        $d = $s->detail;

        $fileName = "data_siswa_{$s->id_siswa}.csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function() use ($s, $d) {
            $file = fopen('php://output', 'w');

            // HEADER CSV
            fputcsv($file, [
                // DATA SISWA
                'NIPD','NISN','Nama','Jenis Kelamin','Tingkat','ID Kelas',

                // DETAIL SISWA LENGKAP
                'Tempat Lahir','Tanggal Lahir','Agama','Alamat','Kelurahan','Kecamatan','Kode Pos',
                'Telepon','No HP','Email','NIK','RT','RW','Dusun','Jenis Tinggal','Alat Transportasi',
                'SKHUN','Penerima KPS','No KPS','Rombel','No Peserta UN','No Seri Ijazah','Penerima KIP',
                'No KIP','Nama KIP','No KKS','No Regis Akta','Bank','No Rek','Atas Nama Rek','Layak PIP Usulan',
                'Alasan Layak PIP','Kebutuhan Khusus','Sekolah Asal','Anak Ke Berapa','Lintang','Bujur','No KK',
                'BB','TB','Lingkar Kepala','Jml Saudara Kandung','Jarak Rumah',

                // AYAH
                'Nama Ayah','Tahun Lahir Ayah','Jenjang Pendidikan Ayah','Pekerjaan Ayah','Penghasilan Ayah','NIK Ayah',

                // IBU
                'Nama Ibu','Tahun Lahir Ibu','Jenjang Pendidikan Ibu','Pekerjaan Ibu','Penghasilan Ibu','NIK Ibu',

                // WALI
                'Nama Wali','Tahun Lahir Wali','Jenjang Pendidikan Wali','Pekerjaan Wali','Penghasilan Wali','NIK Wali'
            ]);

            // ROW DATA
            fputcsv($file, [
                // Siswa
                $s->nipd,
                $s->nisn,
                $s->nama_siswa,
                $s->jenis_kelamin,
                $s->tingkat,
                $s->id_kelas,

                // Detail lengkap
                $d->tempat_lahir ?? '-',
                $d->tanggal_lahir ?? '-',
                $d->agama ?? '-',
                $d->alamat ?? '-',
                $d->kelurahan ?? '-',
                $d->kecamatan ?? '-',
                $d->kode_pos ?? '-',
                $d->telepon ?? '-',
                $d->no_hp ?? '-',
                $d->email ?? '-',
                $d->nik ?? '-',
                $d->rt ?? '-',
                $d->rw ?? '-',
                $d->dusun ?? '-',
                $d->jenis_tinggal ?? '-',
                $d->alat_transportasi ?? '-',
                $d->skhun ?? '-',
                $d->penerima_kps ?? '-',
                $d->no_kps ?? '-',
                $d->rombel ?? '-',
                $d->no_peserta_ujian_nasional ?? '-',
                $d->no_seri_ijazah ?? '-',
                $d->penerima_kip ?? '-',
                $d->no_kip ?? '-',
                $d->nama_kip ?? '-',
                $d->no_kks ?? '-',
                $d->no_regis_akta_lahir ?? '-',
                $d->bank ?? '-',
                $d->no_rek_bank ?? '-',
                $d->rek_atas_nama ?? '-',
                $d->layak_pip_usulan ?? '-',
                $d->alasan_layak_pip ?? '-',
                $d->kebutuhan_khusus ?? '-',
                $d->sekolah_asal ?? '-',
                $d->anak_ke_berapa ?? '-',
                $d->lintang ?? '-',
                $d->bujur ?? '-',
                $d->no_kk ?? '-',
                $d->bb ?? '-',
                $d->tb ?? '-',
                $d->lingkar_kepala ?? '-',
                $d->jml_saudara_kandung ?? '-',
                $d->jarak_rumah ?? '-',

                // AYAH
                $d->nama_ayah ?? '-',
                $d->tahun_lahir_ayah ?? '-',
                $d->jenjang_pendidikan_ayah ?? '-',
                $d->pekerjaan_ayah ?? '-',
                $d->penghasilan_ayah ?? '-',
                $d->nik_ayah ?? '-',

                // IBU
                $d->nama_ibu ?? '-',
                $d->tahun_lahir_ibu ?? '-',
                $d->jenjang_pendidikan_ibu ?? '-',
                $d->pekerjaan_ibu ?? '-',
                $d->penghasilan_ibu ?? '-',
                $d->nik_ibu ?? '-',

                // WALI
                $d->nama_wali ?? '-',
                $d->tahun_lahir_wali ?? '-',
                $d->jenjang_pendidikan_wali ?? '-',
                $d->pekerjaan_wali ?? '-',
                $d->penghasilan_wali ?? '-',
                $d->nik_wali ?? '-',
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf()
    {
        $siswa = Siswa::all();

        $pdf = Pdf::loadView('exports.data_siswa_pdf', [
            'siswa' => $siswa
        ]);

        return $pdf->download('data-siswa.pdf');
    }

    public function exportCsv()
    {
        $siswa = Siswa::all();

        return response()->streamDownload(function() use ($siswa) {

            $file = fopen('php://output', 'w');

            fputcsv($file, ['No','Nama','NIPD','NISN','Jenis Kelamin','Tingkat','Kelas']);

            $no = 1;

            foreach ($siswa as $s) {
                fputcsv($file, [
                    $no++,
                    $s->nama_siswa,
                    $s->nipd,
                    $s->nisn,
                    $s->jenis_kelamin,
                    $s->tingkat,
                    $s->kelas->nama_kelas,
                ]);
            }

            fclose($file);

        }, 'data-siswa.csv', [
            'Content-Type' => 'text/csv'
        ]);
    }

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
