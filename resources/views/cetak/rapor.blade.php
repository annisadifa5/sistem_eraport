<!DOCTYPE html>
<html>
<head>
    <title>Cetak Rapor - {{ $siswa->nama_siswa }}</title>

    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        td { padding: 4px; vertical-align: top; }
        .section-title { font-weight: bold; background: #eee; padding: 6px; margin-top: 15px; }
    </style>

</head>
<body>

<h2>RAPOR SISWA</h2>
<p style="text-align:center;">Semester … / Tahun Pelajaran …</p>

{{-- ========================= --}}
{{-- IDENTITAS SISWA --}}
{{-- ========================= --}}
<div class="section-title">A. IDENTITAS PESERTA DIDIK</div>

<table>
    <tr>
        <td width="30%">Nama Lengkap</td>
        <td>: {{ $siswa->nama_siswa }}</td>
    </tr>

    <tr>
        <td>NIPD</td>
        <td>: {{ $siswa->nipd ?? '-' }}</td>
    </tr>

    <tr>
        <td>NISN</td>
        <td>: {{ $siswa->nisn ?? '-' }}</td>
    </tr>

    <tr>
        <td>Tempat/Tgl Lahir</td>
        <td>: 
            {{ $siswa->detail->tempat_lahir ?? '-' }},
            {{ $siswa->detail->tanggal_lahir ?? '-' }}
        </td>
    </tr>

    <tr>
        <td>Alamat</td>
        <td>: {{ $siswa->detail->alamat ?? '-' }}</td>
    </tr>

    <tr>
        <td>Kelas</td>
        <td>: {{ $siswa->kelas->nama_kelas ?? '-' }}</td>
    </tr>

    <tr>
        <td>Wali Kelas</td>
        <td>: {{ $siswa->kelas->guru->nama_guru ?? '-' }}</td>
    </tr>
</table>

{{-- ================================================== --}}
{{-- ESKUL (Jika Pakai id_ekskul di tabel siswa) --}}
{{-- ================================================== --}}

@if ($siswa->ekskul)
<div class="section-title">B. DATA EKSTRAKURIKULER</div>

<table border="1">
    <tr>
        <td width="30%">Nama Ekskul</td>
        <td>{{ $siswa->ekskul->nama_ekskul ?? '-' }}</td>
    </tr>

    <tr>
        <td>Pembina</td>
        <td>{{ $siswa->ekskul->guru->nama_guru ?? '-' }}</td>
    </tr>

    <tr>
        <td>Jadwal</td>
        <td>{{ $siswa->ekskul->jadwal_ekskul ?? '-' }}</td>
    </tr>
</table>
@endif


{{-- =============================== --}}
{{-- BAGIAN NILAI (NANTI DITAMBAHKAN) --}}
{{-- =============================== --}}

<div class="section-title">C. NILAI AKADEMIK</div>
<p><i>Belum tersedia — menunggu struktur nilai selesai.</i></p>


{{-- =============================== --}}
{{-- BAGIAN ABSENSI --}}
{{-- =============================== --}}
<p class="section-title">D. ABSENSI</p>
<p><i>Belum tersedia.</i></p>

</body>
</html>
