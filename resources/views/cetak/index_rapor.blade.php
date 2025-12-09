@extends('layouts.master')

@section('title', 'Cetak Rapor')

@php
    $cetakNilaiOpen = true;
@endphp

@section('content')

<div class="bg-white rounded-lg shadow p-6">

    <!-- =========================
          FILTER KELAS & SEMESTER
    ========================== -->
    <form action="{{ route('cetak.rapor.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

        <!-- Kelas -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Kelas</label>
            <select name="id_kelas" required class="w-full border rounded-lg p-2">
                <option value="">---</option>
                @foreach($kelas as $k)
                <option value="{{ $k->id_kelas }}" {{ request('id_kelas') == $k->id_kelas ? 'selected' : '' }}>
                    {{ $k->nama_kelas }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Semester -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
            <select name="semester" required class="w-full border rounded-lg p-2">
                <option value="">---</option>
                <option value="ganjil" {{ request('semester') == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                <option value="genap" {{ request('semester') == 'genap' ? 'selected' : '' }}>Genap</option>
            </select>
        </div>

        <!-- Tahun -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Ajaran</label>

            @php
                $tahunSekarang = date('Y');
                $bulanSekarang = date('n'); // 1 - 12

                // Tentukan tahun ajaran berdasarkan aturan:
                if ($bulanSekarang < 7) {
                    // Januari–Juni → tahun_sekarang-1 / tahun_sekarang
                    $defaultTA1 = $tahunSekarang - 1;
                    $defaultTA2 = $tahunSekarang;
                } else {
                    // Juli–Desember → tahun_sekarang / tahun_sekarang+1
                    $defaultTA1 = $tahunSekarang;
                    $defaultTA2 = $tahunSekarang + 1;
                }

                $defaultTahunAjaran = $defaultTA1 . '/' . $defaultTA2;

                // Range daftar tahun ajaran
                $tahunMulai = 2025;
                $tahunAkhir = 2032;
            @endphp

            <select name="tahun_ajaran" required class="w-full border rounded-lg p-2">
                <option value="">---</option>

                @for ($tahun = $tahunMulai; $tahun <= $tahunAkhir; $tahun++)
                    @php
                        $ta = $tahun . '/' . ($tahun + 1);
                    @endphp

                    <option value="{{ $ta }}" 
                        {{ request('tahun_ajaran', $defaultTahunAjaran) == $ta ? 'selected' : '' }}>
                        {{ $ta }}
                    </option>
                @endfor
            </select>
        </div>


        <!-- Tombol -->
        <div class="flex items-end">
            <button type="submit" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow w-full">
                Tampilkan
            </button>
        </div>

    </form>


    <!-- =========================
          LIST SISWA MUNCUL SETELAH FILTER
    ========================== -->

    @if(request('id_kelas') && request('semester'))
        <h3 class="text-lg font-semibold mb-3">
            Daftar Siswa Kelas: 
            <span class="text-blue-600">
                {{ $kelasDipilih->tingkat }} {{ $kelasDipilih->nama_kelas }} - {{ $kelasDipilih->jurusan }}
            </span>
        </h3>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left text-sm">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="px-3 py-2 w-10 text-center">
                            <input type="checkbox" id="checkAll">
                        </th>    
                        <th class="px-4 py-2">No.</th>
                        <th class="px-4 py-2">Nama Siswa</th>
                        <th class="px-4 py-2">NISN</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800">
                    @foreach($siswa as $i => $s)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-3 py-2 text-center">
                            <input type="checkbox" name="id_siswa[]" value="{{ $s->id_siswa }}" class="checkItem">
                        </td>
                        <td class="px-4 py-2">{{ $i+1 }}</td>
                        <td class="px-4 py-2">{{ $s->nama_siswa }}</td>
                        <td class="px-4 py-2">{{ $s->nisn }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('cetak.rapor', $s->id_siswa) }}"
                                class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">
                                Cetak PDF
                            </a>
                        </td>
                    </tr>
                    @endforeach

                    @if(count($siswa) == 0)
                    <tr>
                        <td colspan="4" class="py-3 text-center text-gray-500">
                            Tidak ada data siswa pada kelas ini.
                        </td>
                    </tr>
                    @endif

                </tbody>
            </table>
            {{-- Tombol CETAK MASSAL --}}
            @if(count($siswa) > 0)
                <div class="text-right mt-4">
                    <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                        Cetak PDF Terpilih
                    </button>
                </div>
            @endif

            </form>


            {{-- JS PILIH SEMUA --}}
            <script>
            document.getElementById('checkAll').addEventListener('click', function() {
                let checkboxes = document.querySelectorAll('.checkItem');
                checkboxes.forEach(cb => cb.checked = this.checked);
            });
            </script>
        </div>

    @else
        <!-- =========================
              KOSONG DI AWAL (default)
        ========================== -->
        <div class="text-center text-gray-500 py-10">
            Silakan pilih <b>Kelas</b> dan <b>Semester</b> terlebih dahulu.
        </div>
    @endif

</div>

@endsection
