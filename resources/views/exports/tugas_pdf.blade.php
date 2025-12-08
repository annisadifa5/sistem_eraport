<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nilai Tugas</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        table, th, td {
            border: 1px solid black;
            padding: 5px;
        }
        th {
            background: #f2f2f2;
        }
    </style>
</head>
<body>

<h3 style="text-align:center">LAPORAN NILAI TUGAS</h3>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            <th>NIS</th>
            <th>Nilai</th>
            <th>KKM</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $d)
        <tr>
            <td>{{ $d['no'] }}</td>
            <td>{{ $d['nama'] }}</td>
            <td>{{ $d['nis'] }}</td>
            <td>{{ $d['nilai'] }}</td>
            <td>{{ $d['kkm'] }}</td>
            <td>{{ $d['keterangan'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
