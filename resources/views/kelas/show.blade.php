@extends('layouts.master')

@section('title', 'Detail Kelas')

@php
    $dataSekolahOpen = true;
@endphp

@section('content')
<div class="flex-1 p-8">

    <div class="bg-white shadow rounded-lg p-6">

        {{-- Header --}}
        <h2 class="text-xl font-semibold border-b pb-3 mb-4">
            Detail Kelas & Anggota
        </h2>

        {{-- Informasi Kelas --}}
        <div class="grid grid-cols-2 gap-4 mb-6">

            <div>
                <label class="font-semibold text-gray-700">Nama Kelas:</label>
                <p class="text-gray-800">{{ $kelas->nama_kelas }}</p>
            </div>

            <div>
                <label class="font-semibold text-gray-700">Jurusan:</label>
                <p class="text-gray-800">{{ $kelas->jurusan }}</p>
            </div>

            <div>
                <label class="font-semibold text-gray-700">Tingkat:</label>
                <p class="text-gray-800">{{ $kelas->tingkat }}</p>
            </div>

            <div>
                <label class="font-semibold text-gray-700">Wali Kelas:</label>
                <p class="text-gray-800">
                    {{ $kelas->guru->nama_guru ?? '-' }}
                </p>
            </div>

        </div>

        {{-- Daftar Siswa --}}
        <h3 class="font-semibold text-lg mb-3">Daftar Nama Siswa:</h3>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="py-2 px-4 text-center">No</th>
                        <th class="py-2 px-4">Nama Siswa</th>
                        <th class="py-2 px-4">NISN</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($anggota as $i => $s)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2 px-4 text-center">{{ $i + 1 }}</td>
                        <td class="py-2 px-4">{{ $s->nama_siswa }}</td>
                        <td class="py-2 px-4">{{ $s->nisn }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="py-3 text-center text-gray-500">
                            Belum ada siswa dalam kelas ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    {{-- Tombol kembali --}}
    <div class="mt-4">
        <a href="{{ route('kelas.index') }}"
           class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded">
           Kembali
        </a>
    </div>

</div>
@endsection
