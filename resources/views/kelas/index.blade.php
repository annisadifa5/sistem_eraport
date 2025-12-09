@extends('layouts.master')

@section('title', 'Data Kelas')

@php
    $dataSekolahOpen = true;
@endphp

@section('content')
<div class="text-right mb-4">
    <a href="{{ route('kelas.create') }}"
        class="inline-flex items-center gap-2 bg-blue-500/20 text-blue-700 border border-blue-400 
               px-3 py-1.5 rounded hover:bg-blue-500/30 text-sm">
        <i class="fa-solid fa-plus text-sm"></i>
        Tambah Kelas
    </a>
</div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Export & Search -->
    <div class="flex justify-between items-center mb-4">
            <div class="space-x-2">
                <a href="{{ route('kelas.export.pdf') }}" 
                class="bg-gray-200 px-4 py-1 rounded hover:bg-gray-300 inline-block">PDF</a>
                <a href="{{ route('kelas.export.csv') }}" 
                class="bg-gray-200 px-4 py-1 rounded hover:bg-gray-300 inline-block">CSV</a>
            </div>

        <input type="text" placeholder="Search..." class="border px-3 py-1 rounded focus:ring-1 focus:ring-blue-400 outline-none">
    </div>

    <div class="overflow-x-auto">

        <table class="w-full text-left border-collapse">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-4 py-2 w-12">No</th>
                    <th class="px-4 py-2">Nama Kelas</th>
                    <th class="px-4 py-2">Tingkat</th>
                    <th class="px-4 py-2">Jurusan</th>
                    <th class="px-4 py-2">Wali Kelas</th>
                    <th class="px-4 py-2 text-center">Jumlah Siswa</th>
                    <th class="px-4 py-2 text-center w-40">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($kelas as $i => $k)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $i + 1 }}</td>
                    <td class="px-4 py-2">{{ $k->nama_kelas }}</td>
                    <td class="px-4 py-2">{{ $k->tingkat }}</td>
                    <td class="px-4 py-2">{{ $k->jurusan }}</td>
                    <td class="px-4 py-2">{{ $k->wali_kelas }}</td>
                    <td class="px-4 py-2 text-center">{{ $k->jumlah_siswa ?? 0 }}</td>

                    <td class="px-4 py-2 text-center flex gap-2 justify-center">
                            {{-- Lihat Anggota --}}
                            <a href="{{ route('kelas.show', $k->id_kelas) }}"
                            class="p-1.5 rounded bg-blue-500/20 text-blue-700 border border-blue-400 hover:bg-blue-500/30"
                            title="Lihat Anggota">
                                <i class="fa-solid fa-users text-[13px]"></i>
                            </a>

                            {{-- Edit --}}
                            <a href="{{ route('kelas.edit', $k->id_kelas) }}"
                            class="p-1.5 rounded bg-yellow-500/20 text-yellow-700 border border-yellow-400 hover:bg-yellow-500/30"
                            title="Edit Kelas">
                                <i class="fa-solid fa-pen-to-square text-[13px]"></i>
                            </a>

                            {{-- Delete --}}
                            <form action="{{ route('kelas.destroy', $k->id_kelas) }}"
                                method="POST"
                                onsubmit="return confirm('Hapus kelas ini?')">
                                @csrf
                                @method('DELETE')
                                <button 
                                    class="p-1.5 rounded bg-red-500/20 text-red-700 border border-red-400 hover:bg-red-500/30"
                                    title="Hapus Kelas">
                                    <i class="fa-solid fa-trash text-[13px]"></i>
                                </button>
                            </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500">
                        Belum ada data kelas.
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>


@endsection
