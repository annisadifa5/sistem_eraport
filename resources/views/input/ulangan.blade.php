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
                <i class="text-blue-600"></i> Input Nilai Ulangan Harian
            </h2>
        </div>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('input.ulangan') }}">
            <div class="grid grid-cols-5 gap-4 mb-6 text-sm">

                <!-- Kelas -->
                <select name="id_kelas" class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 text-gray-700">
                    <option value="">Kelas</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->id_kelas }}" {{ $request->id_kelas == $k->id_kelas ? 'selected' : '' }}>
                         {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>

                <!-- Semester -->
                <select name="semester" class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 text-gray-700">
                    <option value="">Semester</option>
                    <option value="1" {{ $request->semester == 1 ? 'selected' : '' }}>1</option>
                    <option value="2" {{ $request->semester == 2 ? 'selected' : '' }}>2</option>
                    <option value="3" {{ $request->semester == 3 ? 'selected' : '' }}>3</option>
                    <option value="4" {{ $request->semester == 4 ? 'selected' : '' }}>4</option>
                    <option value="5" {{ $request->semester == 5 ? 'selected' : '' }}>5</option>
                    <option value="6" {{ $request->semester == 6 ? 'selected' : '' }}>6</option>
                </select>

                <!-- Tahun Ajaran -->
                <select name="id_tahun_ajaran" class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 text-gray-700">
                    <option value="">Tahun Ajaran</option>
                    @foreach ($tahunAjaran as $t)
                        <option value="{{ $t->id_tahun_ajaran }}" {{ $request->tahun_ajaran_id == $t->id_tahun_ajaran ? 'selected' : '' }}>
                            {{ $t->tahun_ajaran }}
                        </option>
                    @endforeach
                </select>

                <!-- Mapel -->
                <select name="id_mapel" class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 text-gray-700">
                    <option value="">Mapel</option>
                    @foreach ($mapel as $m)
                        <option value="{{ $m->id_mapel }}" {{ $request->id_mapel == $m->id_mapel ? 'selected' : '' }}>
                            {{ $m->nama_mapel }}
                        </option>
                    @endforeach
                </select>

                <!-- Tanggal -->
                <div class="relative">
                    <input type="date" name="tanggal" value="{{ $request->tanggal }}" class="border rounded-lg px-3 py-2 w-full focus:ring-2 focus:ring-blue-400 text-gray-700">
                </div>
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow">
                Tampilkan Siswa
            </button>
        </form>

        <!-- Jika belum memilih filter -->
        @if (!$request->id_kelas || !$request->id_mapel || !$request->semester || !$request->id_tahun_ajaran || !$request->tanggal)
            <p class="text-gray-500 mt-6">Silahkan pilih semua filter di atas...</p>
        @else

        <!-- Form Simpan Nilai -->
        <form action="{{ route('input.ulangan.simpan') }}" method="POST">
            @csrf

            <!-- Hidden Fields -->
            <input type="hidden" name="id_kelas" value="{{ $request->id_kelas }}">
            <input type="hidden" name="id_mapel" value="{{ $request->id_mapel }}">
            <input type="hidden" name="semester" value="{{ $request->semester }}">
            <input type="hidden" name="id_tahun_ajaran" value="{{ $request->id_tahun_ajaran }}">
            <input type="hidden" name="tanggal" value="{{ $request->tanggal }}">

            <!-- Table -->
            <div class="overflow-x-auto mt-6">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-blue-600 text-white text-sm">
                        <tr>
                            <th class="py-2 px-4">No.</th>
                            <th class="py-2 px-4">Nama Siswa</th>
                            <th class="py-2 px-4">NIS</th>
                            <th class="py-2 px-4">Nilai</th>
                            <th class="py-2 px-4">KKM</th>
                            <th class="py-2 px-4">Keterangan</th>
                        </tr>
                    </thead>

                    <tbody class="text-sm">
                        @foreach ($siswa as $index => $s)
                            <tr class="border-b hover:bg-gray-50">

                                <td class="py-2 px-4 text-center">{{ $index + 1 }}</td>

                                <td class="py-2 px-4">{{ $s->nama_siswa }}</td>

                                <td class="py-2 px-4">{{ $s->nipd }}</td>

                                <!-- Input Nilai -->
                                <td class="py-2 px-4">
                                    @php
                                    $ulangan = $s->ulangan->first();
                                    @endphp

                                    <input 
                                        type="number" 
                                        name="nilai[{{ $s->id_siswa }}]"
                                        min="0" max="100"
                                        class="border rounded px-2 py-1 w-20 text-center focus:ring-1 focus:ring-blue-400"
                                        value="{{ $ulangan->nilai ?? '' }}">
                                </td>

                                <td class="py-2 px-4 text-center">{{ $s->kelas->kkm ?? 75 }}</td>

                                <td class="py-2 px-4">
                                    {{ $ulangan->keterangan ?? '-' }}
                                </td>


                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Tombol Simpan -->
                <div class="text-right mt-4">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow text-sm">
                        <i class="fa-solid fa-save mr-1"></i> 
                        {{ $nilaiSudahAda ? 'Update Nilai' : 'Simpan Semua Nilai' }}
                    </button>
                </div>

            </div>
        </form>

        @endif
    </div>
</div>

</body>
</html>
