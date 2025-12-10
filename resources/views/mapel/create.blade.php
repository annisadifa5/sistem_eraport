@extends('layouts.master')
@section('title','Tambah Mata Pelajaran')

@php $dataSekolahOpen = true; @endphp

@section('content')



    <form action="{{ route('mapel.store') }}" method="POST">
        @csrf

        <label class="block font-semibold">Nama Mapel</label>
        <input type="text" name="nama_mapel" class="border rounded w-full p-2 mb-3" required>

        <label class="block font-semibold">Singkatan</label>
        <input type="text" name="nama_singkat" class="border rounded w-full p-2 mb-3" required>

        <label class="block font-semibold">Kategori</label>
        <select name="kategori" class="border rounded w-full p-2 mb-3" required>
            <option value="1">Mata Pelajaran Umum</option>
            <option value="2">Mata Pelajaran Kejuruan</option>
            <option value="3">Mata Pelajaran Pilihan</option>
            <option value="4">Muatan Lokal</option>
        </select>

        <label class="block font-semibold">Urutan</label>
        <input type="number" name="urutan" class="border rounded w-full p-2 mb-3" required>

        <label class="block font-semibold">Guru Pengampu</label>
        <select name="id_guru" class="border rounded w-full p-2 mb-5">
            <option value="">-- Belum diatur --</option>
            @foreach($guru as $g)
                <option value="{{ $g->id_guru }}">{{ $g->nama_guru }}</option>
            @endforeach
        </select>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
    </form>

@endsection
