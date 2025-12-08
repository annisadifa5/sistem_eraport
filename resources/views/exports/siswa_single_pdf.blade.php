<!DOCTYPE html>
<html>
<head>
    <style>
        table { width: 100%; border-collapse: collapse; font-size: 11px; }
        th, td { border: 1px solid #333; padding: 4px; text-align: left; }
        th { background: #f2f2f2; font-weight: bold; }
        h2 { margin-bottom: 10px; }
    </style>
</head>

<body>

<h2>Data Siswa Lengkap</h2>

<table>
    <thead>
        <tr>
            <th>Nama</th>
            <th>NIPD</th>
            <th>NISN</th>
            <th>NIK</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Jenis Kelamin</th>
            <th>Agama</th>
            <th>Alamat</th>
            <th>RT</th>
            <th>RW</th>
            <th>Dusun</th>
            <th>Jenis Tinggal</th>
            <th>Alat Transportasi</th>
            <th>No Telepon</th>
            <th>No HP</th>
            <th>Email</th>
            <th>SKHUN</th>
            <th>Penerima KPS</th>
            <th>No KPS</th>
            <th>Rombel</th>
            <th>No Peserta UN</th>
            <th>No Seri Ijazah</th>
            <th>Penerima KIP</th>
            <th>No KIP</th>
            <th>Nama KIP</th>
            <th>No KKS</th>
            <th>No Regis Akta</th>
            <th>Bank</th>
            <th>No Rek</th>
            <th>Rek Atas Nama</th>
            <th>Layak PIP</th>
            <th>Alasan Layak PIP</th>
            <th>Kebutuhan Khusus</th>
            <th>Asal Sekolah</th>
            <th>Anak ke</th>
            <th>Lintang</th>
            <th>Bujur</th>
            <th>No KK</th>
            <th>BB</th>
            <th>TB</th>
            <th>Lingkar Kepala</th>
            <th>Jumlah Saudara Kandung</th>
            <th>Jarak Rumah</th>
            <th>Ekskul</th>

            <!-- AYAH -->
            <th>Nama Ayah</th>
            <th>Tahun Lahir Ayah</th>
            <th>Pendidikan Ayah</th>
            <th>Pekerjaan Ayah</th>
            <th>Penghasilan Ayah</th>
            <th>NIK Ayah</th>

            <!-- IBU -->
            <th>Nama Ibu</th>
            <th>Tahun Lahir Ibu</th>
            <th>Pendidikan Ibu</th>
            <th>Pekerjaan Ibu</th>
            <th>Penghasilan Ibu</th>
            <th>NIK Ibu</th>

            <!-- WALI -->
            <th>Nama Wali</th>
            <th>Tahun Lahir Wali</th>
            <th>Pendidikan Wali</th>
            <th>Pekerjaan Wali</th>
            <th>Penghasilan Wali</th>
            <th>NIK Wali</th>
        </tr>
    </thead>

    <tbody>

        @foreach ($siswa as $s)
            <tr>
                <td>{{ $s->nama_siswa }}</td>
                <td>{{ $s->nipd }}</td>
                <td>{{ $s->nisn }}</td>
                <td>{{ $s->nik }}</td>
                <td>{{ $s->tempat_lahir }}</td>
                <td>{{ $s->tanggal_lahir }}</td>
                <td>{{ $s->jenis_kelamin }}</td>
                <td>{{ $s->agama }}</td>

                <td>{{ $s->alamat }}</td>
                <td>{{ $s->rt }}</td>
                <td>{{ $s->rw }}</td>
                <td>{{ $s->dusun }}</td>
                <td>{{ $s->jenis_tinggal }}</td>
                <td>{{ $s->alat_transportasi }}</td>
                <td>{{ $s->no_telepon }}</td>
                <td>{{ $s->no_hp }}</td>
                <td>{{ $s->email }}</td>
                <td>{{ $s->skhun }}</td>
                <td>{{ $s->penerima_kps }}</td>
                <td>{{ $s->no_kps }}</td>
                <td>{{ $s->rombel }}</td>
                <td>{{ $s->no_peserta_ujian_nasional }}</td>
                <td>{{ $s->no_seri_ijazah }}</td>
                <td>{{ $s->penerima_kip }}</td>
                <td>{{ $s->no_kip }}</td>
                <td>{{ $s->nama_kip }}</td>
                <td>{{ $s->no_kks }}</td>
                <td>{{ $s->no_regis_akta_lahir }}</td>
                <td>{{ $s->bank }}</td>
                <td>{{ $s->no_rek_bank }}</td>
                <td>{{ $s->rek_atas_nama }}</td>
                <td>{{ $s->layak_pip_usulan }}</td>
                <td>{{ $s->alasan_layak_pip }}</td>
                <td>{{ $s->kebutuhan_khusus }}</td>
                <td>{{ $s->asal_sekolah }}</td>
                <td>{{ $s->anak_ke_berapa }}</td>
                <td>{{ $s->lintang }}</td>
                <td>{{ $s->bujur }}</td>
                <td>{{ $s->no_kk }}</td>
                <td>{{ $s->bb }}</td>
                <td>{{ $s->tb }}</td>
                <td>{{ $s->lingkar_kepala }}</td>
                <td>{{ $s->jml_saudara_kandung }}</td>
                <td>{{ $s->jarak_rumah }}</td>
                <td>{{ $s->ekskul }}</td>

                <!-- AYAH -->
                <td>{{ $s->nama_ayah }}</td>
                <td>{{ $s->tahun_lahir_ayah }}</td>
                <td>{{ $s->jenjang_pendidikan_ayah }}</td>
                <td>{{ $s->pekerjaan_ayah }}</td>
                <td>{{ $s->penghasilan_ayah }}</td>
                <td>{{ $s->nik_ayah }}</td>

                <!-- IBU -->
                <td>{{ $s->nama_ibu }}</td>
                <td>{{ $s->tahun_lahir_ibu }}</td>
                <td>{{ $s->jenjang_pendidikan_ibu }}</td>
                <td>{{ $s->pekerjaan_ibu }}</td>
                <td>{{ $s->penghasilan_ibu }}</td>
                <td>{{ $s->nik_ibu }}</td>

                <!-- WALI -->
                <td>{{ $s->nama_wali }}</td>
                <td>{{ $s->tahun_lahir_wali }}</td>
                <td>{{ $s->jenjang_pendidikan_wali }}</td>
                <td>{{ $s->pekerjaan_wali }}</td>
                <td>{{ $s->penghasilan_wali }}</td>
                <td>{{ $s->nik_wali }}</td>

            </tr>
        @endforeach

    </tbody>
</table>

</body>
</html>
