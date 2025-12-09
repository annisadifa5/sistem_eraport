@extends('layouts.master')

@section('title', 'Edit Kelas')

@php
    $dataSekolahOpen = true;
@endphp

@section('content')

<div class="flex-1 p-8">
    <div class="bg-white shadow rounded-lg p-6">

        <!-- Header -->
        <div class="border-b pb-3 mb-5 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-700">Edit Data Kelas</h2>

            <a href="{{ route('kelas.index') }}"
               class="text-sm px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded">
                Kembali
            </a>
        </div>

        <!-- Form Edit -->
        <form action="{{ route('kelas.update', $kelas->id_kelas) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Kelas</label>
                <input type="text" name="nama_kelas" value="{{ $kelas->nama_kelas }}"
                       class="w-full px-3 py-2 border rounded focus:ring focus:ring-blue-300">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Tingkat</label>
                <input type="number" name="tingkat" value="{{ $kelas->tingkat }}"
                       class="w-full px-3 py-2 border rounded focus:ring focus:ring-blue-300">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Jurusan</label>
                <input type="text" name="jurusan" value="{{ $kelas->jurusan }}"
                       class="w-full px-3 py-2 border rounded focus:ring focus:ring-blue-300">
            </div>

            <!-- Wali Kelas -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Wali Kelas</label>
                <select name="wali_kelas"
                    class="w-full px-3 py-2 border rounded focus:ring focus:ring-blue-300 bg-white">
                    
                    <option value="">-- Pilih Wali Kelas --</option>

                    @foreach ($guru as $g)
                        <option value="{{ $g->nama_guru }}" 
                            {{ $g->nama_guru == old('wali_kelas', $kelas->wali_kelas) ? 'selected' : '' }}>
                            {{ $g->nama_guru }}
                        </option>
                    @endforeach

                </select>
            </div>
            <div class="pt-3">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded shadow">
                    Simpan Perubahan
                </button>
            </div>
        </form>

    </div>
</div>

@endsection

