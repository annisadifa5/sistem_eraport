<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: true, dataSekolahOpen: true, inputNilaiOpen: true }" x-cloak>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Nilai Ulangan Harian</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="flex bg-gray-100 min-h-screen">

<!-- Sidebar -->
      @if(auth()->user()->role == 'admin')
          @include('dashboard.sidebar_admin')
      @elseif(auth()->user()->role == 'guru' && auth()->user()->is_walikelas == 0)
          @include('dashboard.sidebar_guru')
      @elseif(auth()->user()->role == 'guru' && auth()->user()->is_walikelas == 1)
          @include('dashboard.sidebar_wali')
      @endif

<!-- Main Content -->
<div class="flex-1 p-8 overflow-y-auto">
    <div class="bg-white rounded-lg shadow p-6">

        <!-- Header -->
        <div class="flex items-center justify-between border-b pb-3 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <i class="text-blue-600"></i> Input Nilai Rapor
            </h2>
        </div>

        <!-- Notifikasi -->
        @if (session('success'))
        <div 
            x-data="{ show: true }" 
            x-show="show"
            x-init="setTimeout(() => show = false, 2500)"
            class="mb-4 p-3 bg-green-500 text-white rounded shadow">
            {{ session('success') }}
        </div>
        @endif

        <!-- Filter Form -->
        <!-- FILTER -->
<form method="GET" action="{{ route('input.rapor') }}">
    <div class="grid grid-cols-2 gap-4 mb-6">

        <!-- Kelas -->
        <select name="id_kelas" class="border rounded px-3 py-2">
            <option value="">Pilih Kelas</option>
            @foreach ($kelas as $k)
                <option value="{{ $k->id_kelas }}" {{ $request->id_kelas == $k->id_kelas ? 'selected' : '' }}>
                    {{ $k->nama_kelas }}
                </option>
            @endforeach
        </select>

        <!-- Mapel -->
        <select name="id_mapel" class="border rounded px-3 py-2">
            <option value="">Pilih Mapel</option>
            @foreach ($mapel as $m)
                <option value="{{ $m->id_mapel }}" {{ $request->id_mapel == $m->id_mapel ? 'selected' : '' }}>
                    {{ $m->nama_mapel }}
                </option>
            @endforeach
        </select>

    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">Tampilkan</button>
</form>


<!-- Jika belum pilih -->
@if(!$request->id_kelas || !$request->id_mapel)
    <p class="text-gray-500 mt-6">Silakan pilih kelas dan mapel.</p>

@elseif($siswa->count() > 0)

<form action="{{ route('input.rapor.simpan') }}" method="POST" class="mt-6">
    @csrf

    <!-- Hidden -->
    <input type="hidden" name="id_kelas" value="{{ $request->id_kelas }}">
    <input type="hidden" name="id_mapel" value="{{ $request->id_mapel }}">

    <table class="w-full text-left border-collapse mt-4">
        <thead class="bg-blue-600 text-white text-sm">
            <tr>
                <th class="py-2 px-3">No</th>
                <th class="py-2 px-3">Nama Siswa</th>
                <th class="py-2 px-3">Nilai</th>
                <th class="py-2 px-3">Capaian</th>
            </tr>
        </thead>

        <tbody class="text-sm">
            @foreach ($siswa as $i => $s)
            <tr class="border-b">

                <td class="px-3 py-2">{{ $i+1 }}</td>
                <td class="px-3 py-2">{{ $s->nama_siswa }}</td>

                <input type="hidden" name="id_siswa[]" value="{{ $s->id_siswa }}">

                <td class="px-3 py-2">
                    <input type="number"
                           name="nilai[]"
                           class="border px-2 py-1 rounded w-20"
                           value="{{ $rapor[$s->id_siswa]->nilai ?? '' }}">
                </td>

                <td class="px-3 py-2">
                    <textarea name="capaian[]" class="border px-2 py-1 rounded w-full">
                        {{ $rapor[$s->id_siswa]->capaian ?? '' }}
                    </textarea>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4 text-right">
        <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan Semua</button>
    </div>

</form>

@endif


            </div>
        </div>

</body>
</html>
