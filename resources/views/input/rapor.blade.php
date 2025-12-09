@extends('layouts.master')

@section('title', 'Input Nilai Rapor')

@php
    $inputNilaiOpen = true;
@endphp

@section('content')

<div class="bg-white rounded-lg shadow p-6">
     
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

        <!-- FILTER -->
        <form method="GET" action="{{ route('input.rapor') }}" class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                <!-- Kelas -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                    <select name="id_kelas" required class="w-full border rounded-lg p-2">
                        <option value="">---</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id_kelas }}" 
                                {{ request('id_kelas') == $k->id_kelas ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Mapel -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
                    <select name="id_mapel" required class="w-full border rounded-lg p-2">
                        <option value="">---</option>
                        @foreach ($mapel as $m)
                            <option value="{{ $m->id_mapel }}" 
                                {{ request('id_mapel') == $m->id_mapel ? 'selected' : '' }}>
                                {{ $m->nama_mapel }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Semester -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                    <select name="semester" class="w-full border rounded-lg p-2">
                        <option value="">---</option>
                        <option value="ganjil" {{ request('semester') == 'ganjil' ? 'selected' : '' }}>
                            Ganjil
                        </option>
                        <option value="genap" {{ request('semester') == 'genap' ? 'selected' : '' }}>
                            Genap
                        </option>
                    </select>
                </div>

                <!-- Tahun Ajaran -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Ajaran</label>
                    <select name="id_tahun_ajaran" class="w-full border rounded-lg p-2">
                        <option value="">---</option>
                        @foreach ($tahunAjaran as $t)
                            <option value="{{ $t->id_tahun_ajaran }}" 
                                {{ request('id_tahun_ajaran') == $t->id_tahun_ajaran ? 'selected' : '' }}>
                                {{ $t->tahun_ajaran }}
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



    <!-- Jika belum pilih -->
    @if(!$request->id_kelas || !$request->id_mapel || !$request->id_tahun_ajaran || !$request->semester)
        <p class="text-gray-500 mt-6">Silakan pilih semua filter di atas.</p>

    @elseif($siswa->count() > 0)

    <form action="{{ route('input.rapor.simpan') }}" method="POST" class="mt-6">
        @csrf

    <!-- Hidden -->
    <input type="hidden" name="id_kelas" value="{{ $request->id_kelas }}">
    <input type="hidden" name="id_mapel" value="{{ $request->id_mapel }}">
    <input type="hidden" name="id_tahun_ajaran" value="{{ $request->id_tahun_ajaran }}">
    <input type="hidden" name="semester" value="{{ $request->semester }}">


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
                    value="{{ optional($rapor->get($s->id_siswa))->nilai }}">
            </td>

            <td class="px-3 py-2">
                <textarea name="capaian[]" class="border px-2 py-1 rounded w-full">{{ optional($rapor->get($s->id_siswa))->capaian }}</textarea>
            </td>

        </tr>
        @endforeach
        </tbody>

    </table>

    <div class="mt-4 text-right">
        <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan Semua</button>
    </div>

</form>

</div>

@endif

@endsection
