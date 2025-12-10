@extends('layouts.master')

@section('title', 'Detail Data Guru')

@php
    $dataSekolahOpen = true; 
    $dataGuruOpen = true; 
    // Ambil detail guru untuk mempermudah akses
    $detail = $guru->detailGuru;
@endphp

@section('content')

<div class="mb-4 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">{{ $guru->nama_guru }}</h2>
    <div class="space-x-2">
        <a href="{{ route('guru.edit', $guru->id_guru) }}"
           class="inline-flex items-center gap-2 bg-yellow-500/20 text-yellow-700 border border-yellow-400 px-3 py-1.5 rounded hover:bg-yellow-500/30 text-sm">
            <i class="fa-solid fa-pen-to-square text-sm"></i>
            Edit Data
        </a>
        <a href="{{ route('guru.index') }}" class="inline-flex items-center gap-2 bg-gray-200 text-gray-700 border border-gray-400 px-3 py-1.5 rounded hover:bg-gray-300 text-sm">
            <i class="fa-solid fa-arrow-left text-sm"></i>
            Kembali
        </a>
    </div>
</div>

{{-- Notifikasi Error --}}
@if(session('error'))
    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
        {{ session('error') }}
    </div>
@endif

<div class="space-y-6">

    @if (!$detail)
        <div class="p-6 bg-yellow-100 text-yellow-800 rounded-lg shadow-md">
            <p class="font-bold">Perhatian:</p>
            <p>Data detail guru belum lengkap. Mohon lengkapi di halaman <a href="{{ route('guru.edit', $guru->id_guru) }}" class="underline">Edit Data</a>.</p>
        </div>
    @endif
    
    {{-- BAGIAN 1: Data Utama & Pribadi --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- KOLOM KIRI: Data Utama Guru (Tabel Guru) --}}
        <div class="lg:col-span-1 p-6 bg-white rounded-lg shadow-md h-fit">
            <h3 class="text-lg font-bold mb-4 border-b pb-2 text-blue-600">Data Umum</h3>
            <dl class="text-sm space-y-3">
                <div class="border-b pb-1">
                    <dt class="font-medium text-gray-500">Nama Guru:</dt>
                    <dd class="text-gray-900 font-semibold text-base">{{ $guru->nama_guru }}</dd>
                </div>
                <div class="border-b pb-1">
                    <dt class="font-medium text-gray-500">NIP:</dt>
                    <dd class="text-gray-900">{{ $guru->nip ?? '-' }}</dd>
                </div>
                <div class="border-b pb-1">
                    <dt class="font-medium text-gray-500">NUPTK:</dt>
                    <dd class="text-gray-900">{{ $guru->nuptk ?? '-' }}</dd>
                </div>
                <div class="border-b pb-1">
                    <dt class="font-medium text-gray-500">Jenis PTK:</dt>
                    <dd class="text-gray-900">{{ $guru->jenis_ptk }}</dd>
                </div>
                <div class="border-b pb-1">
                    <dt class="font-medium text-gray-500">Role Sistem:</dt>
                    <dd class="text-gray-900">{{ $guru->role }}</dd>
                </div>
                <div class="pb-1">
                    <dt class="font-medium text-gray-500">Status:</dt>
                    <dd class="text-gray-900">
                        <span class="px-2 py-0.5 rounded text-xs font-medium 
                            @if($guru->status == 'aktif') bg-green-200 text-green-800 
                            @else bg-red-200 text-red-800 
                            @endif">
                            {{ ucfirst($guru->status) }}
                        </span>
                    </dd>
                </div>
            </dl>
        </div>

        {{-- KOLOM KANAN: Detail Pribadi & Kontak (Tabel DetailGuru) --}}
        <div class="lg:col-span-2 p-6 bg-white rounded-lg shadow-md">
            <h3 class="text-lg font-bold mb-4 border-b pb-2 text-blue-600">Informasi Pribadi & Kontak</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                
                {{-- Baris 1: NIK, Tgl Lahir --}}
                <div class="border-b pb-1">
                    <dt class="font-medium text-gray-500">NIK / No. KK:</dt>
                    <dd class="text-gray-900">{{ $detail->nik ?? '-' }} / {{ $detail->no_kk ?? '-' }}</dd>
                </div>
                <div class="border-b pb-1">
                    <dt class="font-medium text-gray-500">Tempat/Tgl Lahir:</dt>
                    <dd class="text-gray-900">{{ $detail->tempat_lahir ?? '-' }}, {{ $detail->tanggal_lahir ? \Carbon\Carbon::parse($detail->tanggal_lahir)->format('d F Y') : '-' }}</dd>
                </div>
                
                {{-- Baris 2: Gender, Agama --}}
                <div class="border-b pb-1">
                    <dt class="font-medium text-gray-500">Jenis Kelamin / Agama:</dt>
                    <dd class="text-gray-900">{{ $guru->jenis_kelamin ?? '-' }} / {{ $detail->agama ?? '-' }}</dd>
                </div>
                <div class="border-b pb-1">
                    <dt class="font-medium text-gray-500">Kewarganegaraan:</dt>
                    <dd class="text-gray-900">{{ $detail->kewarganegaraan ?? '-' }}</dd>
                </div>
                
                {{-- Baris 3: Kontak --}}
                <div class="border-b pb-1">
                    <dt class="font-medium text-gray-500">Email:</dt>
                    <dd class="text-gray-900 break-all">{{ $detail->email ?? '-' }}</dd>
                </div>
                <div class="border-b pb-1">
                    <dt class="font-medium text-gray-500">Nomor HP/Telp:</dt>
                    <dd class="text-gray-900">{{ $detail->no_hp ?? $detail->no_telp ?? '-' }}</dd>
                </div>

                {{-- Baris 4: Alamat (Lebar Penuh) --}}
                <div class="col-span-full pt-2">
                    <dt class="font-medium text-gray-500">Alamat Lengkap:</dt>
                    <dd class="text-gray-900">
                        {{ $detail->alamat ?? '-' }} 
                        @if($detail->rt && $detail->rw)
                            <br>RT {{ $detail->rt }}/RW {{ $detail->rw }}
                        @endif
                        @if($detail->dusun)
                            <br>Dusun {{ $detail->dusun }}
                        @endif
                        @if($detail->kelurahan)
                            <br>{{ $detail->kelurahan }}, {{ $detail->kecamatan ?? '' }}, Kode Pos: {{ $detail->kode_pos ?? '-' }}
                        @endif
                    </dd>
                </div>
            </div>
        </div>
    </div>
    
    {{-- BAGIAN 2: Data Kepegawaian (Kolom 2x2 pada layar besar) --}}
    <div class="p-6 bg-white rounded-lg shadow-md">
        <h3 class="text-lg font-bold mb-4 border-b pb-2 text-red-600">Data Kepegawaian</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-sm">
            
            {{-- KOLOM KIRI (Umum Kepegawaian) --}}
            <div class="space-y-4">
                <div class="border-b pb-1">
                    <dt class="font-medium text-gray-500">Status Kepegawaian:</dt>
                    <dd class="text-gray-900">{{ $detail->status_kepegawaian ?? '-' }}</dd>
                </div>
                <div class="border-b pb-1">
                    <dt class="font-medium text-gray-500">Pangkat/Golongan:</dt>
                    <dd class="text-gray-900">{{ $detail->pangkat_gol ?? '-' }}</dd>
                </div>
                <div class="border-b pb-1">
                    <dt class="font-medium text-gray-500">Sumber Gaji:</dt>
                    <dd class="text-gray-900">{{ $detail->sumber_gaji ?? '-' }}</dd>
                </div>
                <div class="pb-1">
                    <dt class="font-medium text-gray-500">Tugas Tambahan:</dt>
                    <dd class="text-gray-900">{{ $detail->tugas_tambahan ?? '-' }}</dd>
                </div>
            </div>
            
            {{-- KOLOM KANAN (Dokumen & Tanggal) --}}
            <div class="space-y-4">
                <div class="border-b pb-1">
                    <dt class="font-medium text-gray-500">SK CPNS / Tgl CPNS:</dt>
                    <dd class="text-gray-900">{{ $detail->sk_cpns ?? '-' }} / {{ $detail->tgl_cpns ?? '-' }}</dd>
                </div>
                <div class="border-b pb-1">
                    <dt class="font-medium text-gray-500">SK Pengangkatan / TMT:</dt>
                    <dd class="text-gray-900">{{ $detail->sk_pengangkatan ?? '-' }} / {{ $detail->tmt_pengangkatan ?? '-' }}</dd>
                </div>
                <div class="border-b pb-1">
                    <dt class="font-medium text-gray-500">Lembaga Pengangkatan:</dt>
                    <dd class="text-gray-900">{{ $detail->lembaga_pengangkatan ?? '-' }}</dd>
                </div>
                <div class="pb-1">
                    <dt class="font-medium text-gray-500">NPWP / Nama WP:</dt>
                    <dd class="text-gray-900 break-all">{{ $detail->npwp ?? '-' }} / {{ $detail->nama_wajib_pajak ?? '-' }}</dd>
                </div>
            </div>
            
            {{-- Baris Lanjutan (Lebar Penuh) --}}
            <div class="col-span-full pt-4 border-t border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <dt class="font-medium text-gray-500">Karpeg / Karis Karsu:</dt>
                        <dd class="text-gray-900">{{ $detail->karpeg ?? '-' }} / {{ $detail->karis_karsu ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-500">Lisensi Kepsek / Diklat Pengawasan:</dt>
                        <dd class="text-gray-900">{{ $detail->lisensi_kepsek ?? '-' }} / {{ $detail->diklat_kepengawasan ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-500">Keahlian Braille / Isyarat:</dt>
                        <dd class="text-gray-900">{{ $detail->keahlian_braille ?? '-' }} / {{ $detail->keahlian_isyarat ?? '-' }}</dd>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- BAGIAN 3: Data Bank & Keluarga --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Data Keluarga --}}
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h3 class="text-lg font-bold mb-4 border-b pb-2 text-green-600">Informasi Keluarga</h3>
            <div class="space-y-4 text-sm">
                <div class="border-b pb-1">
                    <dt class="font-medium text-gray-500">Nama Ibu Kandung:</dt>
                    <dd class="text-gray-900">{{ $detail->nama_ibu_kandung ?? '-' }}</dd>
                </div>
                <div class="border-b pb-1">
                    <dt class="font-medium text-gray-500">Status Perkawinan:</dt>
                    <dd class="text-gray-900">{{ $detail->status_perkawinan ?? '-' }}</dd>
                </div>
                <div class="border-b pb-1">
                    <dt class="font-medium text-gray-500">Nama Suami/Istri:</dt>
                    <dd class="text-gray-900">{{ $detail->nama_suami_istri ?? '-' }}</dd>
                </div>
                <div class="border-b pb-1">
                    <dt class="font-medium text-gray-500">NIP Suami/Istri:</dt>
                    <dd class="text-gray-900">{{ $detail->nip_suami_istri ?? '-' }}</dd>
                </div>
                <div class="pb-1">
                    <dt class="font-medium text-gray-500">Pekerjaan Suami/Istri:</dt>
                    <dd class="text-gray-900">{{ $detail->pekerjaan_suami_istri ?? '-' }}</dd>
                </div>
            </div>
        </div>

        {{-- Data Bank --}}
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h3 class="text-lg font-bold mb-4 border-b pb-2 text-green-600">Informasi Bank</h3>
            <div class="space-y-4 text-sm">
                <div class="border-b pb-1">
                    <dt class="font-medium text-gray-500">Nama Bank:</dt>
                    <dd class="text-gray-900">{{ $detail->bank ?? '-' }}</dd>
                </div>
                <div class="border-b pb-1">
                    <dt class="font-medium text-gray-500">Nomor Rekening:</dt>
                    <dd class="text-gray-900">{{ $detail->norek_bank ?? '-' }}</dd>
                </div>
                <div class="pb-1">
                    <dt class="font-medium text-gray-500">Atas Nama Rekening:</dt>
                    <dd class="text-gray-900">{{ $detail->nama_rek ?? '-' }}</dd>
                </div>
            </div>
        </div>
    </div>
    
    {{-- BAGIAN 4: Data Pembelajaran (Menggunakan Tabel) --}}
    <div class="p-6 bg-white rounded-lg shadow-md">
        <h3 class="text-lg font-bold mb-4 border-b pb-2 text-blue-600">Daftar Mengajar (Pembelajaran)</h3>
        @if ($guru->pembelajaran && $guru->pembelajaran->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm min-w-max">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 border w-12">No</th>
                            <th class="px-4 py-2 border">Kelas</th>
                            <th class="px-4 py-2 border">Mata Pelajaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($guru->pembelajaran as $i => $p)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $i + 1 }}</td>
                            <td class="px-4 py-2 border">{{ $p->kelas->nama_kelas ?? 'N/A' }}</td>
                            <td class="px-4 py-2 border">{{ $p->mapel->nama_mapel ?? 'N/A' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">Guru ini belum memiliki jadwal mengajar.</p>
        @endif
    </div>
</div>

@endsection