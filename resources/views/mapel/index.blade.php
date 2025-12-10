@extends('layouts.master')
@section('title','Data Mata Pelajaran')
@php $dataSekolahOpen = true; @endphp

@section('content')

<div class="text-right mb-4">
    <a href="{{ route('mapel.create') }}"
        class="inline-flex items-center gap-2 bg-blue-500/20 text-blue-700 border border-blue-400 
               px-3 py-1.5 rounded hover:bg-blue-500/30 text-sm">
        <i class="fa-solid fa-plus text-sm"></i> Tambah Mapel
    </a>
</div>

@if(session('success'))
<div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
@endif

<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
    <thead class="bg-blue-600 text-white">
        <tr>
            <th class="px-4 py-2 w-12">No</th>
            <th class="px-4 py-2">Mata Pelajaran</th>
            <th class="px-4 py-2">Singkatan</th>
            <th class="px-4 py-2">Kategori</th>
            <th class="px-4 py-2">Urutan Dalam Rapor</th>
            <th class="px-4 py-2 w-32 text-center">Action</th>
        </tr>
    </thead>

    <tbody>
        @forelse($mapel as $i => $m)
        <tr class="border-b hover:bg-gray-50">
            <td class="px-4 py-2">{{ $i + 1 }}</td>
            <td class="px-4 py-2">{{ $m->nama_mapel }}</td>
            <td class="px-4 py-2">{{ $m->nama_singkat }}</td>
            <td class="px-4 py-2">
                @php
                    $kategoriList = [1=>'Umum',2=>'Kejuruan',3=>'Pilihan',4=>'Muatan Lokal'];
                @endphp
                {{ $kategoriList[$m->kategori] ?? '-' }}
            </td>
            <td class="px-4 py-2">{{ $m->urutan }}</td>

            <td class="px-4 py-2 text-center flex gap-2 justify-center">

                <a href="{{ route('mapel.edit',$m->id_mapel) }}"
                class="p-1.5 rounded bg-yellow-500/20 text-yellow-700 border border-yellow-400 hover:bg-yellow-500/30"
                title="Edit">
                    <i class="fa-solid fa-pen-to-square text-[13px]"></i>
                </a>

                <form action="{{ route('mapel.destroy',$m->id_mapel) }}" method="POST"
                    onsubmit="return confirm('Hapus mata pelajaran ini?')">
                    @csrf @method('DELETE')
                    <button class="p-1.5 rounded bg-red-500/20 text-red-700 border border-red-400 hover:bg-red-500/30">
                        <i class="fa-solid fa-trash text-[13px]"></i>
                    </button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center py-4 text-gray-500">Belum ada data mapel.</td></tr>
        @endforelse
    </tbody>
</table>
</div>
@endsection
