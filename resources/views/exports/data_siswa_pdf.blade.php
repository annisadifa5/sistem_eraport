<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Siswa</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h3 style="text-align:center;">Data Seluruh Siswa</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIPD</th>
                <th>NISN</th>
                <th>Jenis Kelamin</th>
                <th>Tingkat</th>
                <th>Kelas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($siswa as $i => $s)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $s->nama_siswa }}</td>
                <td>{{ $s->nipd }}</td>
                <td>{{ $s->nisn }}</td>
                <td>{{ $s->jenis_kelamin }}</td>
                <td>{{ $s->tingkat }}</td>
                <td>{{ $s->kelas->nama_kelas ?? '-'  }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
