<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: true, dataSekolahOpen: true, inputNilaiOpen: true }" x-cloak>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Catatan</title>
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
                <i class="text-blue-600"></i> Catatan
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
        <form method="GET" action="{{ route('input.catatan') }}">
            <div class="grid grid-cols-4 gap-4 mb-6 text-sm">

                <!-- Kelas -->
                <select name="id_kelas" id="kelasSelect" class="border rounded-lg px-3 py-2">
                    <option value="">Pilih Kelas</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->id_kelas }}" {{ $request->id_kelas == $k->id_kelas ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>

                <!-- Siswa -->
                <select name="id_siswa" id="siswaSelect" class="border rounded-lg px-3 py-2">
                    <option value="">Pilih Siswa</option>
                    @foreach ($siswa as $s)
                        <option value="{{ $s->id_siswa }}" {{ $request->id_siswa == $s->id_siswa ? 'selected' : '' }}>
                            {{ $s->nama_siswa }}
                        </option>
                    @endforeach
                </select>
            <!-- TAHUN AJARAN -->
                    <select name="tahun_ajaran" class="border rounded-lg px-3 py-2">
                        <option value="">Tahun Ajaran</option>
                        @foreach ($tahunAjaranList as $ta)
                            <option value="{{ $ta }}" {{ $request->tahun_ajaran == $ta ? 'selected' : '' }}>
                                {{ $ta }}
                            </option>
                        @endforeach
                    </select>

                    <!-- SEMESTER -->
                    <select name="semester" class="border rounded-lg px-3 py-2">
                        <option value="">Semester</option>
                        @foreach ($semesterList as $sem)
                            <option value="{{ $sem }}" {{ $request->semester == $sem ? 'selected' : '' }}>
                                {{ $sem }}
                            </option>
                        @endforeach
                    </select>
                 </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">Tampilkan</button>
        </form>

                <script>
                document.getElementById('kelasSelect').addEventListener('change', function() {
                    let idKelas = this.value;

                    // Kosongkan dropdown siswa sebelum diisi ulang
                    let siswaSelect = document.getElementById('siswaSelect');
                    siswaSelect.innerHTML = '<option value="">Memuat...</option>';

                    if (idKelas === "") {
                        siswaSelect.innerHTML = '<option value="">Pilih Siswa</option>';
                        return;
                    }

                    fetch('/get-siswa/' + idKelas)
                        .then(response => response.json())
                        .then(data => {
                            siswaSelect.innerHTML = '<option value="">Pilih Siswa</option>';
                            data.forEach(s => {
                                siswaSelect.innerHTML += <option value="${s.id_siswa}">${s.nama_siswa}</option>;
                            });
                        });
                });
                </script>


                <!-- Jika belum pilih filter -->
@if (!$request->id_kelas || !$request->id_siswa)
    <p class="text-gray-500 mt-6">Silahkan pilih semua filter di atas...</p>


{{-- Jika filter sudah dipilih --}}
@elseif (isset($siswaTerpilih) && $siswaTerpilih)
<form action="{{ route('input.catatan.simpan') }}" method="POST" class="mt-6 text-sm">
    @csrf

    <input type="hidden" name="id_kelas" value="{{ $request->id_kelas }}">
    <input type="hidden" name="id_siswa" value="{{ $request->id_siswa }}">
    <input type="hidden" name="tahun_ajaran" value="{{ $request->tahun_ajaran }}">
    <input type="hidden" name="semester" value="{{ $request->semester }}">


    <!-- ==========================
         KOKURIKULER
    =========================== -->
    <div class="mb-6">
        <h3 class="font-semibold bg-gray-200 px-4 py-2">KOKURIKULER</h3>
        <textarea name="kokurikuler" class="w-full border rounded p-3 mt-2" rows="4">{{ $rapor->kokurikuler ?? '' }}</textarea>
    </div>


    <!-- ==========================
         EKSTRAKURIKULER
    =========================== -->
    <div x-data="{ rows: [{id_ekskul:'', keterangan:''}] }">


        <table class="w-full border text-sm">
            <thead class="bg-gray-200 text-black">
                <tr>
                    <th class="py-2 px-3 w-10">No</th>
                    <th class="py-2 px-3">Ekstrakurikuler</th>
                    <th class="py-2 px-3">Keterangan</th>
                </tr>
            </thead>

            <tbody>
                <template x-for="(row, index) in rows" :key="index">
                    <tr class="border-b">
                        <td class="px-3 text-center" x-text="index+1"></td>

                        <td class="px-3">
                            <select :name="'ekskul['+index+'][id_ekskul]'" 
                                    class="border rounded w-full px-2 py-1"
                                    x-model="row.id_ekskul">
                                <option value="">Pilih Ekstrakurikuler</option>
                                @foreach($ekskul as $e)
                                    <option value="{{ $e->id_ekskul }}">{{ $e->nama_ekskul }}</option>
                                @endforeach
                            </select>
                        </td>

                        <td class="px-3">
                            <input type="text" 
                                   :name="'ekskul['+index+'][keterangan]'" 
                                   class="border rounded w-full px-2 py-1"
                                   x-model="row.keterangan">
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>

        <button type="button" 
                @click="rows.push({ekskul:'', ket:''})"
                class="mt-3 bg-blue-600 text-white px-3 py-1 rounded">
            + Tambah Ekstrakurikuler
        </button>
    </div>


    <!-- ==========================
         KETIDAKHADIRAN
    =========================== -->
    <div class="mt-6">
    <h3 class="font-semibold bg-gray-200 px-4 py-2 mb-2">KETIDAKHADIRAN</h3>

    <div class="grid grid-cols-3 gap-6 w-full">

        <!-- Sakit -->
        <div>
            <label class="block mb-1 font-semibold">Sakit</label>
            <input type="number" name="sakit"
                   class="border rounded px-3 py-2 w-full"
                   value="{{ $rapor->sakit ?? '' }}">
        </div>

        <!-- Ijin -->
        <div>
            <label class="block mb-1 font-semibold">Ijin</label>
            <input type="number" name="ijin"
                   class="border rounded px-3 py-2 w-full"
                   value="{{ $rapor->ijin ?? '' }}">
        </div>

        <!-- Alpha -->
        <div>
            <label class="block mb-1 font-semibold">Alpha</label>
            <input type="number" name="alpha"
                   class="border rounded px-3 py-2 w-full"
                   value="{{ $rapor->alpha ?? '' }}">
        </div>

    </div>
</div>



    <!-- ==========================
         CATATAN WALI KELAS
    =========================== -->
    <div class="mt-6">
        <h3 class="font-semibold bg-gray-200 px-4 py-2 mb-2">CATATAN WALI KELAS</h3>

        <textarea name="catatan_wali_kelas" class="w-full border rounded p-3" rows="4">
            {{ $rapor->catatan_wali_kelas ?? '' }}
        </textarea>
    </div>

    <!-- BTN SIMPAN -->
    <div class="text-right mt-6">
        <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
    </div>

</form>
@endif


            </div>
        </div>

</body>
</html>