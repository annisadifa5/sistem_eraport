@extends('layouts.master')

@section('title', 'Edit Data Siswa')

@php
    $dataSekolahOpen = true; 
    $detail = $siswa->detail; 
@endphp

@section('content')

<div class="p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Data Siswa: {{ $siswa->nama_siswa }}</h2>
    
    <form action="{{ route('siswa.update', $siswa->id_siswa) }}" method="POST">
        @csrf
        @method('PUT')
        
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded border border-red-300">
                <p class="font-bold">Terjadi kesalahan:</p>
                <ul class="list-disc list-inside mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- BAGIAN 1: Data Utama Siswa --}}
        <h3 class="text-xl font-bold mb-4 border-b pb-2 text-blue-600">1. Data Umum Siswa</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            {{-- Nama Siswa --}}
            <div>
                <label for="nama_siswa" class="block text-sm font-medium text-gray-700 mb-1">Nama Siswa <span class="text-red-500">*</span></label>
                <input type="text" id="nama_siswa" name="nama_siswa" value="{{ old('nama_siswa', $siswa->nama_siswa) }}" required
                       class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            
            {{-- NISN --}}
            <div>
                <label for="nisn" class="block text-sm font-medium text-gray-700 mb-1">NISN <span class="text-red-500">*</span></label>
                <input type="text" id="nisn" name="nisn" value="{{ old('nisn', $siswa->nisn) }}" required
                       class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>

            {{-- NIPD --}}
            <div>
                <label for="nipd" class="block text-sm font-medium text-gray-700 mb-1">NIPD <span class="text-red-500">*</span></label>
                <input type="text" id="nipd" name="nipd" value="{{ old('nipd', $siswa->nipd) }}" required
                       class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            
            {{-- Jenis Kelamin --}}
            <div>
                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                <select id="jenis_kelamin" name="jenis_kelamin" required
                        class="w-full border border-gray-300 rounded-md shadow-sm">
                    @php $jk = old('jenis_kelamin', $siswa->jenis_kelamin); @endphp
                    <option value="L" {{ $jk == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ $jk == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            
            {{-- Tingkat --}}
            <div>
                <label for="tingkat" class="block text-sm font-medium text-gray-700 mb-1">Tingkat <span class="text-red-500">*</span></label>
                <input type="text" id="tingkat" name="tingkat" value="{{ old('tingkat', $siswa->tingkat) }}" required
                       class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>

            {{-- Kelas --}}
            <div>
                <label for="id_kelas" class="block text-sm font-medium text-gray-700 mb-1">Kelas <span class="text-red-500">*</span></label>
                <select id="id_kelas" name="id_kelas" required
                        class="w-full border border-gray-300 rounded-md shadow-sm">
                    <option value="">Pilih Kelas</option>
                    @foreach ($kelasList as $kelas)
                        <option value="{{ $kelas->id_kelas }}" {{ old('id_kelas', $siswa->id_kelas) == $kelas->id_kelas ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>
            
             {{-- Ekskul --}}
            <div>
                <label for="id_ekskul" class="block text-sm font-medium text-gray-700 mb-1">Ekskul</label>
                <select id="id_ekskul" name="id_ekskul"
                        class="w-full border border-gray-300 rounded-md shadow-sm">
                    <option value="">Tidak Ikut Ekskul</option>
                    @foreach ($ekskulList as $ekskul)
                        <option value="{{ $ekskul->id_ekskul }}" {{ old('id_ekskul', $siswa->id_ekskul) == $ekskul->id_ekskul ? 'selected' : '' }}>
                            {{ $ekskul->nama_ekskul }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- BAGIAN 2: Detail Pribadi & Alamat --}}
        <h3 class="text-xl font-bold mb-4 border-b pb-2 mt-8 text-red-600">2. Data Pribadi & Alamat</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            {{-- NIK --}}
            <div>
                <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                <input type="text" name="nik" value="{{ old('nik', $detail->nik ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            {{-- No KK --}}
            <div>
                <label for="no_kk" class="block text-sm font-medium text-gray-700 mb-1">Nomor KK</label>
                <input type="text" name="no_kk" value="{{ old('no_kk', $detail->no_kk ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            {{-- Tempat Lahir --}}
            <div>
                <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $detail->tempat_lahir ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            {{-- Tanggal Lahir --}}
            <div>
                <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $detail->tanggal_lahir ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            
            {{-- Agama --}}
            <div>
                <label for="agama" class="block text-sm font-medium text-gray-700 mb-1">Agama</label>
                <input type="text" name="agama" value="{{ old('agama', $detail->agama ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            {{-- No Regis Akta Lahir --}}
            <div>
                <label for="no_regis_akta_lahir" class="block text-sm font-medium text-gray-700 mb-1">No. Regis Akta Lahir</label>
                <input type="text" name="no_regis_akta_lahir" value="{{ old('no_regis_akta_lahir', $detail->no_regis_akta_lahir ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            {{-- Anak ke --}}
            <div>
                <label for="anak_ke_berapa" class="block text-sm font-medium text-gray-700 mb-1">Anak Ke-berapa</label>
                <input type="number" name="anak_ke_berapa" value="{{ old('anak_ke_berapa', $detail->anak_ke_berapa ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            {{-- Jumlah Saudara --}}
            <div>
                <label for="jml_saudara_kandung" class="block text-sm font-medium text-gray-700 mb-1">Jml. Saudara Kandung</label>
                <input type="number" name="jml_saudara_kandung" value="{{ old('jml_saudara_kandung', $detail->jml_saudara_kandung ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            
            <div class="md:col-span-4 mt-4">
                <h4 class="text-md font-semibold mb-2 text-gray-700">Detail Alamat</h4>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="md:col-span-4">
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                        <textarea name="alamat" rows="2" class="w-full border border-gray-300 rounded-md shadow-sm">{{ old('alamat', $detail->alamat ?? '') }}</textarea>
                    </div>
                    <div>
                        <label for="rt" class="block text-sm font-medium text-gray-700 mb-1">RT</label>
                        <input type="text" name="rt" value="{{ old('rt', $detail->rt ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label for="rw" class="block text-sm font-medium text-gray-700 mb-1">RW</label>
                        <input type="text" name="rw" value="{{ old('rw', $detail->rw ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label for="dusun" class="block text-sm font-medium text-gray-700 mb-1">Dusun</label>
                        <input type="text" name="dusun" value="{{ old('dusun', $detail->dusun ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label for="kelurahan" class="block text-sm font-medium text-gray-700 mb-1">Kelurahan</label>
                        <input type="text" name="kelurahan" value="{{ old('kelurahan', $detail->kelurahan ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label for="kecamatan" class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                        <input type="text" name="kecamatan" value="{{ old('kecamatan', $detail->kecamatan ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label for="kode_pos" class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                        <input type="text" name="kode_pos" value="{{ old('kode_pos', $detail->kode_pos ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
                    </div>
                </div>
            </div>
        </div>

        {{-- BAGIAN 3: Data Orang Tua --}}
        <h3 class="text-xl font-bold mb-4 border-b pb-2 mt-8 text-green-600">3. Data Orang Tua & Wali</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            {{-- Ayah --}}
            <div class="p-4 border border-gray-200 rounded-md bg-gray-50">
                <h4 class="font-semibold mb-3">Ayah</h4>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ayah</label>
                    <input type="text" name="nama_ayah" value="{{ old('nama_ayah', $detail->nama_ayah ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm mb-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIK Ayah</label>
                    <input type="text" name="nik_ayah" value="{{ old('nik_ayah', $detail->nik_ayah ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm mb-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Lahir</label>
                    <input type="number" name="tahun_lahir_ayah" value="{{ old('tahun_lahir_ayah', $detail->tahun_lahir_ayah ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm mb-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pendidikan</label>
                    <input type="text" name="jenjang_pendidikan_ayah" value="{{ old('jenjang_pendidikan_ayah', $detail->jenjang_pendidikan_ayah ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm mb-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan</label>
                    <input type="text" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah', $detail->pekerjaan_ayah ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm mb-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Penghasilan</label>
                    <input type="text" name="penghasilan_ayah" value="{{ old('penghasilan_ayah', $detail->penghasilan_ayah ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
                </div>
            </div>

            {{-- Ibu --}}
            <div class="p-4 border border-gray-200 rounded-md bg-gray-50">
                <h4 class="font-semibold mb-3">Ibu</h4>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ibu</label>
                    <input type="text" name="nama_ibu" value="{{ old('nama_ibu', $detail->nama_ibu ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm mb-2">
                </div>
                 <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIK Ibu</label>
                    <input type="text" name="nik_ibu" value="{{ old('nik_ibu', $detail->nik_ibu ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm mb-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Lahir</label>
                    <input type="number" name="tahun_lahir_ibu" value="{{ old('tahun_lahir_ibu', $detail->tahun_lahir_ibu ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm mb-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pendidikan</label>
                    <input type="text" name="jenjang_pendidikan_ibu" value="{{ old('jenjang_pendidikan_ibu', $detail->jenjang_pendidikan_ibu ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm mb-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan</label>
                    <input type="text" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu', $detail->pekerjaan_ibu ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm mb-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Penghasilan</label>
                    <input type="text" name="penghasilan_ibu" value="{{ old('penghasilan_ibu', $detail->penghasilan_ibu ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
                </div>
            </div>

            {{-- Wali --}}
            <div class="p-4 border border-gray-200 rounded-md bg-gray-50">
                <h4 class="font-semibold mb-3">Wali (Opsional)</h4>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Wali</label>
                    <input type="text" name="nama_wali" value="{{ old('nama_wali', $detail->nama_wali ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm mb-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIK Wali</label>
                    <input type="text" name="nik_wali" value="{{ old('nik_wali', $detail->nik_wali ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm mb-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Lahir</label>
                    <input type="number" name="tahun_lahir_wali" value="{{ old('tahun_lahir_wali', $detail->tahun_lahir_wali ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm mb-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pendidikan</label>
                    <input type="text" name="jenjang_pendidikan_wali" value="{{ old('jenjang_pendidikan_wali', $detail->jenjang_pendidikan_wali ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm mb-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan</label>
                    <input type="text" name="pekerjaan_wali" value="{{ old('pekerjaan_wali', $detail->pekerjaan_wali ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm mb-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Penghasilan</label>
                    <input type="text" name="penghasilan_wali" value="{{ old('penghasilan_wali', $detail->penghasilan_wali ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
                </div>
            </div>
        </div>

        {{-- BAGIAN 4: Kesejahteraan & Fisik --}}
        <h3 class="text-xl font-bold mb-4 border-b pb-2 mt-8 text-blue-600">4. Kesejahteraan & Fisik</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            {{-- KPS --}}
            <div>
                <label for="penerima_kps" class="block text-sm font-medium text-gray-700 mb-1">Penerima KPS</label>
                <select name="penerima_kps" class="w-full border border-gray-300 rounded-md shadow-sm">
                    @php $kps = old('penerima_kps', $detail->penerima_kps ?? '0'); @endphp
                    <option value="0" {{ $kps == '0' ? 'selected' : '' }}>TIDAK</option>
                    <option value="1" {{ $kps == '1' ? 'selected' : '' }}>YA</option>
                </select>
            </div>
            <div>
                <label for="no_kps" class="block text-sm font-medium text-gray-700 mb-1">No. KPS</label>
                <input type="text" name="no_kps" value="{{ old('no_kps', $detail->no_kps ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
             {{-- KIP --}}
            <div>
                <label for="penerima_kip" class="block text-sm font-medium text-gray-700 mb-1">Penerima KIP</label>
                <select name="penerima_kip" class="w-full border border-gray-300 rounded-md shadow-sm">
                    @php $kip = old('penerima_kip', $detail->penerima_kip ?? '0'); @endphp
                    <option value="0" {{ $kip == '0' ? 'selected' : '' }}>TIDAK</option>
                    <option value="1" {{ $kip == '1' ? 'selected' : '' }}>YA</option>
                </select>
            </div>
            <div>
                <label for="no_kip" class="block text-sm font-medium text-gray-700 mb-1">No. KIP</label>
                <input type="text" name="no_kip" value="{{ old('no_kip', $detail->no_kip ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>

            {{-- Fisik & Transportasi --}}
            <div>
                <label for="tb" class="block text-sm font-medium text-gray-700 mb-1">Tinggi Badan (cm)</label>
                <input type="number" name="tb" value="{{ old('tb', $detail->tb ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label for="bb" class="block text-sm font-medium text-gray-700 mb-1">Berat Badan (kg)</label>
                <input type="number" name="bb" value="{{ old('bb', $detail->bb ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label for="alat_transportasi" class="block text-sm font-medium text-gray-700 mb-1">Alat Transportasi</label>
                <input type="text" name="alat_transportasi" value="{{ old('alat_transportasi', $detail->alat_transportasi ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label for="jarak_rumah" class="block text-sm font-medium text-gray-700 mb-1">Jarak Rumah (km)</label>
                <input type="text" name="jarak_rumah" value="{{ old('jarak_rumah', $detail->jarak_rumah ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            
             {{-- Sisanya --}}
            <div class="md:col-span-2">
                <label for="sekolah_asal" class="block text-sm font-medium text-gray-700 mb-1">Sekolah Asal</label>
                <input type="text" name="sekolah_asal" value="{{ old('sekolah_asal', $detail->sekolah_asal ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            <div class="md:col-span-2">
                <label for="kebutuhan_khusus" class="block text-sm font-medium text-gray-700 mb-1">Kebutuhan Khusus</label>
                <input type="text" name="kebutuhan_khusus" value="{{ old('kebutuhan_khusus', $detail->kebutuhan_khusus ?? '') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="mt-6 pt-4 border-t border-gray-200 flex justify-end gap-3">
            <a href="{{ route('siswa.index') }}"
               class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 transition duration-150">
                Batal
            </a>
            <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 transition duration-150">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection