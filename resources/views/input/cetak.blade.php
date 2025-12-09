<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: true, dataSekolahOpen: true, inputNilaiOpen: true }" x-cloak>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Nilai</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; font-size: 15px; }
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="flex bg-gray-100 min-h-screen">

    {{-- Sidebar --}}
    @if(auth()->user()->role == 'admin')
        @include('dashboard.sidebar_admin')
    @elseif(auth()->user()->role == 'guru' && auth()->user()->is_walikelas == 0)
        @include('dashboard.sidebar_guru')
    @elseif(auth()->user()->role == 'guru' && auth()->user()->is_walikelas == 1)
        @include('dashboard.sidebar_wali')
    @endif

    {{-- MAIN CONTENT --}}
    <div class="flex-1 p-8 overflow-y-auto">
        <div class="bg-white rounded-lg shadow p-6">

            {{-- HEADER --}}
            <div class="flex justify-between items-center border-b mb-6 pb-3">
                <h2 class="text-lg font-semibold text-gray-800">Cetak Nilai</h2>

                <button id="btn-cetak"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow text-sm flex items-center gap-2">
                    <i class="fa-solid fa-file-pdf"></i> Cetak PDF
                </button>
            </div>

            {{-- FILTER FORM --}}
            <form method="GET" action="{{ route('input.cetak') }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

                    {{-- Pilih Kelas --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                        <select name="id_kelas"
                                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400"
                                onchange="this.form.submit()">
                            <option value="">Pilih Kelas</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id_kelas }}"
                                    {{ $request->id_kelas == $k->id_kelas ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Pilih Siswa --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Siswa</label>
                        <select name="id_siswa"
                                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400"
                                onchange="this.form.submit()">

                            <option value="">Pilih Siswa</option>

                            @foreach($siswa as $s)
                                <option value="{{ $s->id_siswa }}"
                                    {{ $request->id_siswa == $s->id_siswa ? 'selected' : '' }}>
                                    {{ $s->nama_siswa }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                </div>
            </form>

            {{-- TABEL RAPOR --}}
            <div class="overflow-x-auto mt-6">

                @if($rapor->count() == 0 && $request->id_siswa)
                    <p class="text-center text-gray-500 py-4">Belum ada data nilai untuk siswa ini.</p>
                @endif

                @if($rapor->count() > 0)
                <table class="w-full text-sm border-collapse">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="py-2 px-4">No</th>
                            <th class="py-2 px-4">Mata Pelajaran</th>
                            <th class="py-2 px-4">Nilai</th>
                            <th class="py-2 px-4">Capaian</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($rapor as $index => $r)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-4 text-center">{{ $index + 1 }}</td>
                            <td class="py-2 px-4">{{ $r->mapel->nama_mapel }}</td>
                            <td class="py-2 px-4 text-center">{{ $r->nilai }}</td>
                            <td class="py-2 px-4">{{ $r->capaian }}</td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
                @endif

            </div>

        </div>
    </div>
</div>

{{-- SCRIPT --}}
<script>
    document.getElementById('btn-cetak').addEventListener('click', () => {
        alert('Cetak PDF belum dibuat.');
    });
</script>

</body>
</html>
