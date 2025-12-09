@extends('layouts.master')
@section('title','Edit Mata Pelajaran')
@php $dataSekolahOpen = true; @endphp
@section('content')

<form action="{{ route('mapel.update',$mapel->id_mapel) }}" method="POST">
    @csrf 
    @method('PUT')

    <div class="mb-3">
        <label>Nama Mapel</label>
        <input type="text" name="nama_mapel" value="{{ $mapel->nama_mapel }}" required class="border rounded w-full p-2">
    </div>

    <div class="mb-3">
        <label>Nama Singkat</label>
        <input type="text" name="nama_singkat" value="{{ $mapel->nama_singkat }}" required class="border rounded w-full p-2">
    </div>

    <div class="mb-3">
        <label>Kategori Mapel</label>
        <select name="kategori" required class="border rounded w-full p-2">
            @foreach($kategoriList as $id => $nama)
            <option value="{{ $id }}" {{ $mapel->kategori == $id ? 'selected' : '' }}>
                {{ $nama }}
            </option>
            @endforeach
        </select>
    </div>

    <div>
    <label class="block font-semibold">Urutan</label>
        <input type="number" name="urutan" value="{{ $mapel->urutan }}" class="border rounded w-full p-2 mb-3" required>
    </div>
    
    <div class="mb-3">
        <label>Guru Pengampu</label>
        <select name="id_guru" class="border rounded w-full p-2">
            <option value="">-- Pilih Guru --</option>
            @foreach($guru as $g)
            <option value="{{ $g->id_guru }}" {{ $mapel->id_guru == $g->id_guru ? 'selected' : '' }}>
                {{ $g->nama_guru }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="text-right mt-4">
        <button class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
    </div>

</form>

@endsection
