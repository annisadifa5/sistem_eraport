@extends('layouts.master')

@section('title', 'Data Guru')

{{-- Tentukan variabel untuk menandai menu aktif di sidebar (sesuaikan dengan master layout Anda) --}}
@php
    $dataSekolahOpen = true; // Contoh, jika menu Guru berada di bawah Data Sekolah
@endphp

@section('content')

{{-- Tombol Tambah Guru --}}
<div class="text-right mb-4">
    <a href="{{ route('guru.create') }}"
        class="inline-flex items-center gap-2 bg-blue-500/20 text-blue-700 border border-blue-400 
                px-3 py-1.5 rounded hover:bg-blue-500/30 text-sm">
        <i class="fa-solid fa-plus text-sm"></i>
        Tambah Guru
    </a>
</div>

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-4">
        
        {{-- BAGIAN KIRI: Export & Import --}}
        <div class="space-x-2 flex items-center">
            {{-- 3. Form Import CSV (Menggunakan FORM POST) --}}
            <form action="{{ route('guru.import') }}" method="POST" enctype="multipart/form-data" class="inline-block" onsubmit="return confirm('Yakin ingin mengimpor data guru? Data lama akan diperbarui.')">
                @csrf
                
                <input type="file" name="file" id="import_guru_csv" style="display: none;" onchange="this.form.submit()">

                <button type="button" 
                        onclick="document.getElementById('import_guru_csv').click()"
                        class="bg-blue-500/20 text-blue-700 border border-blue-400 px-4 py-1 rounded hover:bg-blue-500/30 text-sm">
                    <i class="fa-solid fa-download"></i> Import
                </button>
            </form>
            {{-- 1. Tombol Export PDF --}}
            <a href="{{ route('guru.export.pdf') }}" 
            class="bg-gray-200 px-4 py-1 rounded hover:bg-gray-300 inline-block text-sm">
                <i class="fa-solid fa-file-pdf"></i> PDF
            </a>
            {{-- 2. Tombol Export CSV --}}
            <a href="{{ route('guru.export.csv') }}" 
            class="bg-gray-200 px-4 py-1 rounded hover:bg-gray-300 inline-block text-sm">
                <i class="fa-solid fa-file-csv"></i> CSV
            </a>
        </div>

        {{-- BAGIAN KANAN: Form Pencarian --}}
        <form method="GET" action="{{ route('guru.index') }}" class="inline-block">
            <input type="text" 
                name="search" 
                placeholder="Cari Nama Guru..." 
                value="{{ request('search') }}" 
                onchange="this.form.submit()"
                class="border px-3 py-1 rounded focus:ring-1 focus:ring-blue-400 outline-none">
            
            {{-- Opsional: Tombol submit tersembunyi untuk support Enter Key --}}
            <button type="submit" style="display:none;"></button>
        </form>
    </div>

    {{-- Tabel Data Guru --}}
    <div class="overflow-x-auto">

        <table class="w-full text-left border-collapse">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-4 py-2 w-12">No</th>
                    <th class="px-4 py-2">Nama Guru</th>
                    <th class="px-4 py-2">NIP / NUPTK</th>
                    <th class="px-4 py-2">Jenis Kelamin</th>
                    <th class="px-4 py-2">Jenis PTK</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2 text-center w-52">Action</th>
                </tr>
            </thead>

            <tbody>
                {{-- Loop melalui koleksi guru yang dikirim dari controller --}}
                @forelse ($gurus as $i => $g)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $i + 1 }}</td>
                    <td class="px-4 py-2">{{ $g->nama_guru }}</td>
                    {{-- Menampilkan NIP atau NUPTK (pilih salah satu atau gabungkan) --}}
                    <td class="px-4 py-2">{{ $g->nip ?? $g->nuptk ?? '-' }}</td> 
                    <td class="px-4 py-2">{{ $g->jenis_kelamin }}</td>
                    <td class="px-4 py-2">{{ $g->jenis_ptk }}</td>
                    <td class="px-4 py-2">
                        {{-- Contoh badge untuk status --}}
                        <span class="px-2 py-0.5 rounded text-xs 
                            @if($g->status == 'aktif') bg-green-200 text-green-800 
                            @else bg-red-200 text-red-800 
                            @endif">
                            {{ ucfirst($g->status) }}
                        </span>
                    </td>

                    {{-- Tombol Action --}}
                    <td class="px-4 py-2 text-center flex gap-2 justify-center">
                        {{-- Lihat Detail (Lihat Anggota pada Kelas) --}}
                        <a href="{{ route('guru.show', $g->id_guru) }}"
                        class="p-1.5 rounded bg-blue-500/20 text-blue-700 border border-blue-400 hover:bg-blue-500/30"
                        title="Lihat Detail Guru">
                            <i class="fa-solid fa-user-tie text-[13px]"></i>
                        </a>

                        {{-- Edit --}}
                        <a href="{{ route('guru.edit', $g->id_guru) }}"
                        class="p-1.5 rounded bg-yellow-500/20 text-yellow-700 border border-yellow-400 hover:bg-yellow-500/30"
                        title="Edit Guru">
                            <i class="fa-solid fa-pen-to-square text-[13px]"></i>
                        </a>

                        {{-- Delete --}}
                        <form action="{{ route('guru.destroy', $g->id_guru) }}"
                            method="POST"
                            onsubmit="return confirm('Hapus data guru {{ $g->nama_guru }}?')">
                            @csrf
                            @method('DELETE')
                            <button 
                                class="p-1.5 rounded bg-red-500/20 text-red-700 border border-red-400 hover:bg-red-500/30"
                                title="Hapus Guru">
                                <i class="fa-solid fa-trash text-[13px]"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500">
                        Belum ada data guru.
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>


@endsection