@extends('layouts.master')

@section('title', 'Detail Data Siswa')

@php
    $dataSekolahOpen = true; 
    $detail = $siswa->detail;
    $jk_text = $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan';
    
    $showValue = function($value) {
        return '<dd class="text-gray-900 border border-gray-300 rounded-md shadow-sm py-1.5 px-3 bg-gray-50">' . ($value ?? '-') . '</dd>';
    };
@endphp

@section('content')

<div class="mb-4 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">Detail Siswa: {{ $siswa->nama_siswa }}</h2>
    <div class="space-x-2">
        <a href="{{ route('siswa.edit', $siswa->id_siswa) }}"
           class="inline-flex items-center gap-2 bg-yellow-500/20 text-yellow-700 border border-yellow-400 px-3 py-1.5 rounded hover:bg-yellow-500/30 text-sm">
            <i class="fa-solid fa-pen-to-square text-sm"></i>
            Edit Data
        </a>
        <a href="{{ route('siswa.index') }}" class="inline-flex items-center gap-2 bg-gray-200 text-gray-700 border border-gray-400 px-3 py-1.5 rounded hover:bg-gray-300 text-sm">
            <i class="fa-solid fa-arrow-left text-sm"></i>
            Kembali
        </a>
    </div>
</div>

@if (!$detail)
    <div class="p-6 bg-yellow-100 text-yellow-800 rounded-lg shadow-md mb-6">
        <p class="font-bold">Perhatian:</p>
        <p>Data detail siswa belum lengkap. Mohon lengkapi di halaman <a href="{{ route('siswa.edit', $siswa->id_siswa) }}" class="underline">Edit Data</a>.</p>
    </div>
@endif

<div class="space-y-6">

    {{-- BAGIAN 1: Data Utama & Sekolah --}}
    <div class="p-6 bg-white rounded-lg shadow-md">
        <h3 class="text-lg font-bold mb-4 border-b pb-2 text-blue-600">Data Umum & Sekolah</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-sm">
            <div class="pb-1">
                <dt class="font-medium text-gray-500">NISN / NIPD:</dt>
                {!! $showValue(($siswa->nisn ?? '-') . ' / ' . ($siswa->nipd ?? '-')) !!}
            </div>
            <div class="pb-1">
                <dt class="font-medium text-gray-500">Kelas / Tingkat:</dt>
                {!! $showValue(($siswa->kelas->nama_kelas ?? '-') . ' / ' . ($siswa->tingkat ?? '-')) !!}
            </div>
            <div class="pb-1">
                <dt class="font-medium text-gray-500">Sekolah Asal:</dt>
                {!! $showValue($detail->sekolah_asal ?? '-') !!}
            </div>
            <div class="pb-1">
                <dt class="font-medium text-gray-500">Rombel:</dt>
                {!! $showValue($detail->rombel ?? '-') !!}
            </div>
            <div class="pb-1">
                <dt class="font-medium text-gray-500">Ekskul:</dt>
                {!! $showValue($siswa->ekskul->nama_ekskul ?? '-') !!}
            </div>
            <div class="pb-1">
                <dt class="font-medium text-gray-500">No. Peserta UN:</dt>
                {!! $showValue($detail->no_peserta_ujian_nasional ?? '-') !!}
            </div>
            <div class="pb-1">
                <dt class="font-medium text-gray-500">SKHUN / No. Ijazah:</dt>
                {!! $showValue(($detail->skhun ?? '-') . ' / ' . ($detail->no_seri_ijazah ?? '-')) !!}
            </div>
            <div class="pb-1">
                <dt class="font-medium text-gray-500">Tinggi / Berat Badan:</dt>
                {!! $showValue(($detail->tb ?? '-') . ' cm / ' . ($detail->bb ?? '-') . ' kg') !!}
            </div>
        </div>
    </div>
    
    {{-- BAGIAN 2: Data Pribadi & Kontak --}}
    <div class="p-6 bg-white rounded-lg shadow-md">
        <h3 class="text-lg font-bold mb-4 border-b pb-2 text-red-600">Data Pribadi & Alamat</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-sm">
            <div class="pb-1">
                <dt class="font-medium text-gray-500">NIK / No. KK:</dt>
                {!! $showValue(($detail->nik ?? '-') . ' / ' . ($detail->no_kk ?? '-')) !!}
            </div>
            <div class="pb-1">
                <dt class="font-medium text-gray-500">Tempat/Tgl Lahir:</dt>
                {!! $showValue(($detail->tempat_lahir ?? '-') . ', ' . ($detail->tanggal_lahir ? \Carbon\Carbon::parse($detail->tanggal_lahir)->format('d F Y') : '-')) !!}
            </div>
            <div class="pb-1">
                <dt class="font-medium text-gray-500">Jenis Kelamin / Agama:</dt>
                {!! $showValue(($jk_text ?? '-') . ' / ' . ($detail->agama ?? '-')) !!}
            </div>
            <div class="pb-1">
                <dt class="font-medium text-gray-500">Anak ke / Jumlah Saudara:</dt>
                {!! $showValue(($detail->anak_ke_berapa ?? '-') . ' / ' . ($detail->jml_saudara_kandung ?? '-')) !!}
            </div>
            <div class="pb-1">
                <dt class="font-medium text-gray-500">No. HP / Telepon:</dt>
                {!! $showValue(($detail->no_hp ?? '-') . ' / ' . ($detail->telepon ?? '-')) !!}
            </div>
            <div class="pb-1">
                <dt class="font-medium text-gray-500">Email:</dt>
                {!! $showValue($detail->email ?? '-') !!}
            </div>
            <div class="col-span-4 pt-2">
                <dt class="font-medium text-gray-500">Alamat Lengkap:</dt>
                <dd class="text-gray-900 border border-gray-300 rounded-md shadow-sm py-1.5 px-3 bg-gray-50 whitespace-pre-line">
                    {{ $detail->alamat ?? '-' }} 
                    @if($detail->rt && $detail->rw)
                        &#10;RT {{ $detail->rt }}/RW {{ $detail->rw }}
                    @endif
                    @if($detail->dusun)
                        &#10;Dusun {{ $detail->dusun }}
                    @endif
                    @if($detail->kelurahan)
                        &#10;{{ $detail->kelurahan }}, {{ $detail->kecamatan ?? '' }}, Kode Pos: {{ $detail->kode_pos ?? '-' }}
                    @endif
                </dd>
            </div>
        </div>
    </div>

    {{-- BAGIAN 3: Data Orang Tua --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        {{-- Ayah --}}
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h3 class="text-lg font-bold mb-4 border-b pb-2 text-green-600">Data Ayah</h3>
            <div class="space-y-3 text-sm">
                <div class="pb-1"><dt class="font-medium text-gray-500">Nama Ayah:</dt>{!! $showValue($detail->nama_ayah) !!}</div>
                <div class="pb-1"><dt class="font-medium text-gray-500">NIK Ayah:</dt>{!! $showValue($detail->nik_ayah) !!}</div>
                <div class="pb-1"><dt class="font-medium text-gray-500">Thn Lahir:</dt>{!! $showValue($detail->tahun_lahir_ayah) !!}</div>
                <div class="pb-1"><dt class="font-medium text-gray-500">Pendidikan:</dt>{!! $showValue($detail->jenjang_pendidikan_ayah) !!}</div>
                <div class="pb-1"><dt class="font-medium text-gray-500">Pekerjaan:</dt>{!! $showValue($detail->pekerjaan_ayah) !!}</div>
                <div class="pb-1"><dt class="font-medium text-gray-500">Penghasilan:</dt>{!! $showValue($detail->penghasilan_ayah) !!}</div>
            </div>
        </div>

        {{-- Ibu --}}
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h3 class="text-lg font-bold mb-4 border-b pb-2 text-green-600">Data Ibu</h3>
            <div class="space-y-3 text-sm">
                <div class="pb-1"><dt class="font-medium text-gray-500">Nama Ibu:</dt>{!! $showValue($detail->nama_ibu) !!}</div>
                <div class="pb-1"><dt class="font-medium text-gray-500">NIK Ibu:</dt>{!! $showValue($detail->nik_ibu) !!}</div>
                <div class="pb-1"><dt class="font-medium text-gray-500">Thn Lahir:</dt>{!! $showValue($detail->tahun_lahir_ibu) !!}</div>
                <div class="pb-1"><dt class="font-medium text-gray-500">Pendidikan:</dt>{!! $showValue($detail->jenjang_pendidikan_ibu) !!}</div>
                <div class="pb-1"><dt class="font-medium text-gray-500">Pekerjaan:</dt>{!! $showValue($detail->pekerjaan_ibu) !!}</div>
                <div class="pb-1"><dt class="font-medium text-gray-500">Penghasilan:</dt>{!! $showValue($detail->penghasilan_ibu) !!}</div>
            </div>
        </div>
        
        {{-- Wali --}}
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h3 class="text-lg font-bold mb-4 border-b pb-2 text-green-600">Data Wali (Opsional)</h3>
            <div class="space-y-3 text-sm">
                <div class="pb-1"><dt class="font-medium text-gray-500">Nama Wali:</dt>{!! $showValue($detail->nama_wali) !!}</div>
                <div class="pb-1"><dt class="font-medium text-gray-500">NIK Wali:</dt>{!! $showValue($detail->nik_wali) !!}</div>
                <div class="pb-1"><dt class="font-medium text-gray-500">Thn Lahir:</dt>{!! $showValue($detail->tahun_lahir_wali) !!}</div>
                <div class="pb-1"><dt class="font-medium text-gray-500">Pendidikan:</dt>{!! $showValue($detail->jenjang_pendidikan_wali) !!}</div>
                <div class="pb-1"><dt class="font-medium text-gray-500">Pekerjaan:</dt>{!! $showValue($detail->pekerjaan_wali) !!}</div>
                <div class="pb-1"><dt class="font-medium text-gray-500">Penghasilan:</dt>{!! $showValue($detail->penghasilan_wali) !!}</div>
            </div>
        </div>
    </div>
    
    {{-- BAGIAN 4: Data Kesejahteraan & Tambahan --}}
    <div class="p-6 bg-white rounded-lg shadow-md">
        <h3 class="text-lg font-bold mb-4 border-b pb-2 text-blue-600">Data Kesejahteraan & Fisik</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-sm">
            <div class="pb-1">
                <dt class="font-medium text-gray-500">Penerima KPS/KIP/KKS:</dt>
                {!! $showValue(($detail->penerima_kps ? 'Ya' : 'Tidak') . ' / ' . ($detail->penerima_kip ? 'Ya' : 'Tidak') . ' / ' . ($detail->no_kks ?? '-')) !!}
            </div>
            <div class="pb-1">
                <dt class="font-medium text-gray-500">No. KPS / No. KIP:</dt>
                {!! $showValue(($detail->no_kps ?? '-') . ' / ' . ($detail->no_kip ?? '-')) !!}
            </div>
            <div class="pb-1">
                <dt class="font-medium text-gray-500">Layak PIP Usulan / Alasan:</dt>
                {!! $showValue(($detail->layak_pip_usulan ? 'Ya' : 'Tidak') . ' / ' . ($detail->alasan_layak_pip ?? '-')) !!}
            </div>
            <div class="pb-1">
                <dt class="font-medium text-gray-500">Kebutuhan Khusus:</dt>
                {!! $showValue($detail->kebutuhan_khusus ?? '-') !!}
            </div>
            <div class="pb-1">
                <dt class="font-medium text-gray-500">Jenis Tinggal / Transportasi:</dt>
                {!! $showValue(($detail->jenis_tinggal ?? '-') . ' / ' . ($detail->alat_transportasi ?? '-')) !!}
            </div>
            <div class="pb-1">
                <dt class="font-medium text-gray-500">Lingkar Kepala / Jarak Rumah:</dt>
                {!! $showValue(($detail->lingkar_kepala ?? '-') . ' cm / ' . ($detail->jarak_rumah ?? '-') . ' km') !!}
            </div>
            <div class="pb-1">
                <dt class="font-medium text-gray-500">No. Regis Akta Lahir:</dt>
                {!! $showValue($detail->no_regis_akta_lahir ?? '-') !!}
            </div>
            <div class="pb-1">
                <dt class="font-medium text-gray-500">Bank / No. Rekening:</dt>
                {!! $showValue(($detail->bank ?? '-') . ' / ' . ($detail->no_rek_bank ?? '-')) !!}
            </div>
        </div>
    </div>
</div>

@endsection