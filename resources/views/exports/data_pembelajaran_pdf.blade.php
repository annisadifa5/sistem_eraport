<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Pembelajaran</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; margin-bottom: 15px; }
    </style>
</head>
<body>
    <h2>Data Pembelajaran</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mata Pelajaran</th>
                <th>Tingkat</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>Guru Mapel</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pembelajaran as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $p->mapel->nama_mapel ?? '-' }}</td>
                <td>{{ $p->kelas->tingkat ?? '-' }}</td>
                <td>{{ $p->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $p->kelas->jurusan ?? '-' }}</td>
                <td>{{ $p->guru->nama_guru ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
