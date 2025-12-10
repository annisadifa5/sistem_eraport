@extends('layouts.master')

@section('title', 'Data Siswa')

@php
    $dataSekolahOpen = true; // Sesuaikan dengan layout Anda
@endphp

@section('content')
<div class="text-right mb-4">
    <a href="{{ route('siswa.create') }}"
        class="inline-flex items-center gap-2 bg-blue-500/20 text-blue-700 border border-blue-400 
                px-3 py-1.5 rounded hover:bg-blue-500/30 text-sm">
        <i class="fa-solid fa-plus text-sm"></i>
        Tambah Siswa
    </a>
</div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-4">
        <div class="space-x-2">
            <a href="{{ route('siswa.export.pdf') }}" 
            class="bg-gray-200 px-4 py-1 rounded hover:bg-gray-300 inline-block">PDF</a>
            <a href="{{ route('siswa.export.csv') }}" 
            class="bg-gray-200 px-4 py-1 rounded hover:bg-gray-300 inline-block">CSV</a>
        </div>

        <input type="text" placeholder="Search..." class="border px-3 py-1 rounded focus:ring-1 focus:ring-blue-400 outline-none">
    </div>

    <div class="overflow-x-auto">

        <table class="w-full text-left border-collapse">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-4 py-2 w-12">No</th>
                    <th class="px-4 py-2">Nama Siswa</th>
                    <th class="px-4 py-2">NISN / NIPD</th>
                    <th class="px-4 py-2">Kelas</th>
                    <th class="px-4 py-2">Tingkat</th>
                    <th class="px-4 py-2">Jenis Kelamin</th>
                    <th class="px-4 py-2 text-center">Ekskul</th>
                    <th class="px-4 py-2 text-center w-52">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($siswas as $i => $s)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $siswas->firstItem() + $i }}</td>
                    <td class="px-4 py-2">{{ $s->nama_siswa }}</td>
                    <td class="px-4 py-2">{{ $s->nisn }} / {{ $s->nipd }}</td>
                    {{-- Menggunakan relasi kelas --}}
                    <td class="px-4 py-2">{{ $s->kelas->nama_kelas ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $s->tingkat }}</td>
                    {{-- Display L/P as Laki-laki/Perempuan --}}
                    <td class="px-4 py-2">{{ $s->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    {{-- Menggunakan relasi ekskul --}}
                    <td class="px-4 py-2 text-center">{{ $s->ekskul->nama_ekskul ?? '-' }}</td>

                    <td class="px-4 py-2 text-center flex gap-2 justify-center">
                        {{-- Lihat Detail --}}
                        <a href="{{ route('siswa.show', $s->id_siswa) }}"
                        class="p-1.5 rounded bg-blue-500/20 text-blue-700 border border-blue-400 hover:bg-blue-500/30"
                        title="Lihat Detail">
                            <i class="fa-solid fa-user-gear text-[13px]"></i>
                        </a>

                        {{-- Edit --}}
                        <a href="{{ route('siswa.edit', $s->id_siswa) }}"
                        class="p-1.5 rounded bg-yellow-500/20 text-yellow-700 border border-yellow-400 hover:bg-yellow-500/30"
                        title="Edit Siswa">
                            <i class="fa-solid fa-pen-to-square text-[13px]"></i>
                        </a>

                        {{-- Delete --}}
                        <form action="{{ route('siswa.destroy', $s->id_siswa) }}"
                            method="POST"
                            onsubmit="return confirm('Hapus data siswa {{ $s->nama_siswa }}?')">
                            @csrf
                            @method('DELETE')
                            <button 
                                class="p-1.5 rounded bg-red-500/20 text-red-700 border border-red-400 hover:bg-red-500/30"
                                title="Hapus Siswa">
                                <i class="fa-solid fa-trash text-[13px]"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4 text-gray-500">
                        Belum ada data siswa.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
    
    {{-- Pagination --}}
    <div class="mt-4">
        {{ $siswas->links() }}
    </div>


@endsection