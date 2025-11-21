<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Mata Pelajaran</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Data Mata Pelajaran</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mata Pelajaran</th>
                <th>Nama Singkat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mapel as $i => $m)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $m->nama_mapel }}</td>
                <td>{{ $m->nama_singkat }}</td>
            @endforeach
        </tbody>
    </table>
</body>
</html>
