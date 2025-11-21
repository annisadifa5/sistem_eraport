<!DOCTYPE html>
<html>
<head>
    <title>Data Guru</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        table, th, td {
            border: 1px solid #000;
            padding: 4px;
        }
        th {
            background: #ddd;
        }
    </style>
</head>
<body>

<h3 style="text-align:center;">Data Guru</h3>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Guru</th>
            <th>NIP</th>
            <th>NUPTK</th>
            <th>Jenis Kelamin</th>
            <th>Jenis PTK</th>
            <th>Role</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach($guru as $g)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $g->nama_guru }}</td>
            <td>{{ $g->nip }}</td>
            <td>{{ $g->nuptk }}</td>
            <td>{{ $g->jenis_kelamin }}</td>
            <td>{{ $g->jenis_ptk }}</td>
            <td>{{ $g->role }}</td>
            <td>{{ $g->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>