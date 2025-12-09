@extends('layouts.master')

@section('title', 'Catatan Siswa')

@php
    $inputNilaiOpen = true;
@endphp

@section('content')

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
        <form method="GET" action="{{ route('input.catatan') }}" class="mb-6">

            <!-- 2 Kolom Filter -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

                <!-- Kelas -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                    <select name="id_kelas" id="kelasSelect" class="w-full border rounded-lg px-3 py-2">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($kelas as $k)
                            <option value="{{ $k->id_kelas }}" 
                                {{ request('id_kelas') == $k->id_kelas ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Siswa -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Siswa</label>
                    <select name="id_siswa" id="siswaSelect" class="w-full border rounded-lg px-3 py-2">
                        <option value="">-- Pilih Siswa --</option>
                        @foreach ($siswa as $s)
                            <option value="{{ $s->id_siswa }}" 
                                {{ request('id_siswa') == $s->id_siswa ? 'selected' : '' }}>
                                {{ $s->nama_siswa }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <!-- Tombol -->
            <div class="mt-4">
                <button class="bg-blue-600 hover:bg-blue-700 transition text-white px-4 py-2 rounded-lg shadow">
                    Tampilkan
                </button>
            </div>

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

@endsection
