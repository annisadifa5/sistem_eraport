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
                <i class="text-blue-600"></i> Catatan Siswa
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
            <div class="grid grid-cols-2 gap-4 mb-6">

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
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">Tampilkan</button>
        </form>

        <!-- AJAX GET SISWA -->
        <script>
            document.getElementById('kelasSelect').addEventListener('change', function() {
                let idKelas = this.value;
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
                            siswaSelect.innerHTML += `<option value="${s.id_siswa}">${s.nama_siswa}</option>`;
                        });
                    });
            });
        </script>

        <!-- Jika belum pilih filter -->
        @if (!$request->id_kelas || !$request->id_siswa)
            <p class="text-gray-500 mt-6">Silahkan pilih semua filter di atas...</p>

        <!-- Jika filter lengkap -->
        @elseif ($siswaTerpilih)

        <!-- FORM CATATAN -->
        <form action="{{ route('input.catatan.simpan') }}" method="POST" class="mt-6 text-sm">
            @csrf

            <input type="hidden" name="id_kelas" value="{{ $request->id_kelas }}">
            <input type="hidden" name="id_siswa" value="{{ $request->id_siswa }}">

            <!-- KOKURIKULER -->
            <div class="mb-6">
                <h3 class="font-semibold bg-gray-200 px-4 py-2">KOKURIKULER</h3>
                <textarea name="kokurikuler" class="w-full border rounded p-3 mt-2" rows="4">{{ $rapor->kokurikuler ?? '' }}</textarea>
            </div>

            <!-- EKSTRAKURIKULER -->
            <div class="mb-6" 
                x-data="{
                    list: {{ json_encode(
                        $nilaiEkskul->map(fn($i)=>[
                            'id_ekskul' => $i->id_ekskul,
                            'keterangan' => $i->keterangan
                        ]) ?: [['id_ekskul'=>'','keterangan'=>'']]
                    ) }}
                }">

                <h3 class="font-semibold bg-gray-200 px-4 py-2">EKSTRAKURIKULER</h3>

                <table class="w-full mt-3 border text-sm">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="py-2 px-3 w-10">No</th>
                            <th class="py-2 px-3">Ekstrakurikuler</th>
                            <th class="py-2 px-3">Keterangan</th>
                        </tr>
                    </thead>

                    <tbody>
                        <template x-for="(item, index) in list" :key="index">
                            <tr class="border-b">
                                <td class="px-3 text-center" x-text="index + 1"></td>

                                <!-- DROPDOWN -->
                                <td class="px-3">
                                    <select class="border rounded w-full px-2 py-1"
                                            :name="'ekskul['+index+'][id_ekskul]'"
                                            x-model="item.id_ekskul">
                                        <option value="">-- Pilih Ekstrakurikuler --</option>
                                        @foreach ($listEkskul as $e)
                                            <option value="{{ $e->id_ekskul }}">{{ $e->nama_ekskul }}</option>
                                        @endforeach
                                    </select>
                                </td>

                                <!-- KETERANGAN -->
                                <td class="px-3">
                                    <input type="text" class="border rounded w-full px-2 py-1"
                                        :name="'ekskul['+index+'][keterangan]'"
                                        x-model="item.keterangan">
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>

                <button type="button" 
                    @click="list.push({id_ekskul:'', keterangan:''})"
                    class="mt-3 bg-green-600 text-white px-3 py-1 rounded">
                    + Tambah Ekstrakurikuler
                </button>
            </div>


            <!-- KETIDAKHADIRAN -->
            <div class="mb-6 grid grid-cols-2 gap-6">
                <!-- lanjutkan field ketidakhadiran -->
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan Catatan</button>
        </form>

        @endif  <!-- end kondisi filter -->

    </div>
</div>

</body>
</html>
