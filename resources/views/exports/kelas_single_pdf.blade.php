<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Kelas - {{ $kelas->nama_kelas }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Data Kelas: {{ $kelas->nama_kelas }}</h2>
    <p><b>Tingkat:</b> {{ $kelas->tingkat }} | <b>Jurusan:</b> {{ $kelas->jurusan }}</p>
    <p><b>Wali Kelas:</b> {{ $kelas->wali_kelas }}</p>

    <h4>Daftar Anggota Kelas:</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NISN</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kelas->anggotaKelas as $i => $a)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $a->nama }}</td>
                <td>{{ $a->nisn }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
