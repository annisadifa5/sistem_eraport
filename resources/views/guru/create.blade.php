@extends('layouts.master')

@section('title', 'Tambah Data Guru')

@php
    $dataSekolahOpen = true; 
    $dataGuruOpen = true; 
@endphp

@section('content')

<div class="p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Tambah Data Guru Baru</h2>
    
    {{-- Form untuk menyimpan data guru baru --}}
    <form action="{{ route('guru.store') }}" method="POST">
        @csrf
        
        {{-- Notifikasi Error Validasi --}}
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

        {{-- BAGIAN 1: Data Utama Guru --}}
        <h3 class="text-xl font-bold mb-4 border-b pb-2 text-blue-600">1. Data Umum Guru</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            {{-- Nama Guru --}}
            <div>
                <label for="nama_guru" class="block text-sm font-medium text-gray-700 mb-1">Nama Guru <span class="text-red-500">*</span></label>
                <input type="text" id="nama_guru" name="nama_guru" 
                       value="{{ old('nama_guru') }}" required
                       class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            
            {{-- NIP --}}
            <div>
                <label for="nip" class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                <input type="text" id="nip" name="nip" 
                       value="{{ old('nip') }}"
                       class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>

            {{-- NUPTK --}}
            <div>
                <label for="nuptk" class="block text-sm font-medium text-gray-700 mb-1">NUPTK</label>
                <input type="text" id="nuptk" name="nuptk" 
                       value="{{ old('nuptk') }}"
                       class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            
            {{-- Status --}}
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Kepegawaian <span class="text-red-500">*</span></label>
                <select id="status" name="status" required
                        class="w-full border border-gray-300 rounded-md shadow-sm">
                    @php $status = old('status'); @endphp
                    <option value="aktif" {{ $status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="non-aktif" {{ $status == 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
            </div>
            
            {{-- Jenis PTK --}}
            <div>
                <label for="jenis_ptk" class="block text-sm font-medium text-gray-700 mb-1">Jenis PTK <span class="text-red-500">*</span></label>
                <input type="text" id="jenis_ptk" name="jenis_ptk" 
                       value="{{ old('jenis_ptk', 'Guru') }}" required
                       class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>

            {{-- Role --}}
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role/Peran <span class="text-red-500">*</span></label>
                <select id="role" name="role" required
                        class="w-full border border-gray-300 rounded-md shadow-sm">
                    @php $role = old('role'); @endphp
                    <option value="" disabled {{ $role == null ? 'selected' : '' }}>Pilih Role</option>
                    <option value="Guru Mata Pelajaran" {{ $role == 'Guru Mata Pelajaran' ? 'selected' : '' }}>Guru Mata Pelajaran</option>
                    <option value="Wali Kelas" {{ $role == 'Wali Kelas' ? 'selected' : '' }}>Wali Kelas</option>
                    <option value="BK" {{ $role == 'BK' ? 'selected' : '' }}>Bimbingan Konseling (BK)</option>
                    <option value="Kepala Sekolah" {{ $role == 'Kepala Sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                </select>
            </div>
        </div>
        
        {{-- BAGIAN 2: Detail Pribadi & Kontak --}}
        <h3 class="text-xl font-bold mb-4 border-b pb-2 mt-8 text-red-600">2. Detail Pribadi & Kontak</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            {{-- Jenis Kelamin --}}
            <div>
                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                <select id="jenis_kelamin" name="jenis_kelamin" required
                        class="w-full border border-gray-300 rounded-md shadow-sm">
                    @php $jk = old('jenis_kelamin'); @endphp
                    <option value="L" {{ $jk == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ $jk == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            {{-- Agama --}}
            <div>
                <label for="agama" class="block text-sm font-medium text-gray-700 mb-1">Agama</label>
                <input type="text" name="agama" value="{{ old('agama') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            {{-- Kewarganegaraan --}}
            <div>
                <label for="kewarganegaraan" class="block text-sm font-medium text-gray-700 mb-1">Kewarganegaraan</label>
                <input type="text" name="kewarganegaraan" value="{{ old('kewarganegaraan') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            {{-- NIK --}}
            <div>
                <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                <input type="text" name="nik" value="{{ old('nik') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            {{-- No KK --}}
            <div>
                <label for="no_kk" class="block text-sm font-medium text-gray-700 mb-1">Nomor KK</label>
                <input type="text" name="no_kk" value="{{ old('no_kk') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            {{-- Tempat Lahir --}}
            <div>
                <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            {{-- Tanggal Lahir --}}
            <div>
                <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            {{-- NO HP --}}
            <div>
                <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            {{-- Email --}}
            <div class="md:col-span-2">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
        </div>

        {{-- Alamat --}}
        <div class="mt-4 mb-6">
            <h4 class="text-lg font-semibold mb-2 text-gray-700">Detail Alamat</h4>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="md:col-span-4">
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                    <textarea name="alamat" rows="3" class="w-full border border-gray-300 rounded-md shadow-sm">{{ old('alamat') }}</textarea>
                </div>
                <div>
                    <label for="rt" class="block text-sm font-medium text-gray-700 mb-1">RT</label>
                    <input type="text" name="rt" value="{{ old('rt') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="rw" class="block text-sm font-medium text-gray-700 mb-1">RW</label>
                    <input type="text" name="rw" value="{{ old('rw') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="dusun" class="block text-sm font-medium text-gray-700 mb-1">Dusun</label>
                    <input type="text" name="dusun" value="{{ old('dusun') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="kelurahan" class="block text-sm font-medium text-gray-700 mb-1">Kelurahan</label>
                    <input type="text" name="kelurahan" value="{{ old('kelurahan') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="kecamatan" class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                    <input type="text" name="kecamatan" value="{{ old('kecamatan') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="kode_pos" class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                    <input type="text" name="kode_pos" value="{{ old('kode_pos') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
                </div>
            </div>
        </div>

        {{-- BAGIAN 3: Data Kepegawaian & Dokumen --}}
        <h3 class="text-xl font-bold mb-4 border-b pb-2 mt-8 text-green-600">3. Data Kepegawaian & Dokumen</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div>
                <label for="status_kepegawaian" class="block text-sm font-medium text-gray-700 mb-1">Status Kepegawaian</label>
                <input type="text" name="status_kepegawaian" value="{{ old('status_kepegawaian') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label for="pangkat_gol" class="block text-sm font-medium text-gray-700 mb-1">Pangkat/Golongan</label>
                <input type="text" name="pangkat_gol" value="{{ old('pangkat_gol') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label for="sumber_gaji" class="block text-sm font-medium text-gray-700 mb-1">Sumber Gaji</label>
                <input type="text" name="sumber_gaji" value="{{ old('sumber_gaji') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label for="tugas_tambahan" class="block text-sm font-medium text-gray-700 mb-1">Tugas Tambahan</label>
                <input type="text" name="tugas_tambahan" value="{{ old('tugas_tambahan') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            {{-- Dokumen --}}
            <div>
                <label for="sk_cpns" class="block text-sm font-medium text-gray-700 mb-1">SK CPNS</label>
                <input type="text" name="sk_cpns" value="{{ old('sk_cpns') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label for="tgl_cpns" class="block text-sm font-medium text-gray-700 mb-1">Tgl CPNS</label>
                <input type="date" name="tgl_cpns" value="{{ old('tgl_cpns') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label for="sk_pengangkatan" class="block text-sm font-medium text-gray-700 mb-1">SK Pengangkatan</label>
                <input type="text" name="sk_pengangkatan" value="{{ old('sk_pengangkatan') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label for="tmt_pengangkatan" class="block text-sm font-medium text-gray-700 mb-1">TMT Pengangkatan</label>
                <input type="date" name="tmt_pengangkatan" value="{{ old('tmt_pengangkatan') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label for="lembaga_pengangkatan" class="block text-sm font-medium text-gray-700 mb-1">Lembaga Pengangkatan</label>
                <input type="text" name="lembaga_pengangkatan" value="{{ old('lembaga_pengangkatan') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label for="tmt_pns" class="block text-sm font-medium text-gray-700 mb-1">TMT PNS</label>
                <input type="date" name="tmt_pns" value="{{ old('tmt_pns') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label for="karpeg" class="block text-sm font-medium text-gray-700 mb-1">Karpeg</label>
                <input type="text" name="karpeg" value="{{ old('karpeg') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label for="karis_karsu" class="block text-sm font-medium text-gray-700 mb-1">Karis/Karsu</label>
                <input type="text" name="karis_karsu" value="{{ old('karis_karsu') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label for="npwp" class="block text-sm font-medium text-gray-700 mb-1">NPWP</label>
                <input type="text" name="npwp" value="{{ old('npwp') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label for="nama_wajib_pajak" class="block text-sm font-medium text-gray-700 mb-1">Nama Wajib Pajak</label>
                <input type="text" name="nama_wajib_pajak" value="{{ old('nama_wajib_pajak') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
        </div>

        {{-- BAGIAN 4: Keluarga & Bank --}}
        <h3 class="text-xl font-bold mb-4 border-b pb-2 mt-8 text-green-600">4. Keluarga & Bank</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div>
                <label for="nama_ibu_kandung" class="block text-sm font-medium text-gray-700 mb-1">Nama Ibu Kandung</label>
                <input type="text" name="nama_ibu_kandung" value="{{ old('nama_ibu_kandung') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label for="status_perkawinan" class="block text-sm font-medium text-gray-700 mb-1">Status Perkawinan</label>
                <input type="text" name="status_perkawinan" value="{{ old('status_perkawinan') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label for="nama_suami_istri" class="block text-sm font-medium text-gray-700 mb-1">Nama Suami/Istri</label>
                <input type="text" name="nama_suami_istri" value="{{ old('nama_suami_istri') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label for="nip_suami_istri" class="block text-sm font-medium text-gray-700 mb-1">NIP Suami/Istri</label>
                <input type="text" name="nip_suami_istri" value="{{ old('nip_suami_istri') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label for="pekerjaan_suami_istri" class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Suami/Istri</label>
                <input type="text" name="pekerjaan_suami_istri" value="{{ old('pekerjaan_suami_istri') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            {{-- Bank --}}
            <div>
                <label for="bank" class="block text-sm font-medium text-gray-700 mb-1">Nama Bank</label>
                <input type="text" name="bank" value="{{ old('bank') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label for="norek_bank" class="block text-sm font-medium text-gray-700 mb-1">Nomor Rekening</label>
                <input type="text" name="norek_bank" value="{{ old('norek_bank') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label for="nama_rek" class="block text-sm font-medium text-gray-700 mb-1">Nama Rekening</label>
                <input type="text" name="nama_rek" value="{{ old('nama_rek') }}" class="w-full border border-gray-300 rounded-md shadow-sm">
            </div>
        </div>


        {{-- BAGIAN 5: Pengajaran (Pembelajaran) --}}
        <h3 class="text-xl font-bold mb-4 border-b pb-2 mt-8 text-blue-600">5. Pengajaran (Pembelajaran)</h3>
        <p class="text-sm text-gray-600 mb-4">Tambahkan mata pelajaran yang akan diajarkan oleh guru ini (opsional).</p>

        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
            <div id="pembelajaran-container">
                
                @php
                    // Jika ada old input untuk pembelajaran, gunakan itu. Jika tidak, sediakan satu template kosong.
                    $pembelajarans = old('pembelajaran', [[]]); // [[]] ensures at least one empty template
                @endphp

                @foreach ($pembelajarans as $i => $p)
                <div class="pembelajaran-item grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-4 items-end border-b pb-4">
                    <div class="sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                        <select name="pembelajaran[{{ $i }}][id_kelas]" class="w-full border border-gray-300 rounded-md shadow-sm">
                            <option value="">Pilih Kelas</option>
                            @foreach ($kelasList as $kelas)
                                <option value="{{ $kelas->id_kelas }}" {{ ($p['id_kelas'] ?? '') == $kelas->id_kelas ? 'selected' : '' }}>
                                    {{ $kelas->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
                        <select name="pembelajaran[{{ $i }}][id_mapel]" class="w-full border border-gray-300 rounded-md shadow-sm">
                            <option value="">Pilih Mapel</option>
                            @foreach ($mapelList as $mapel)
                                <option value="{{ $mapel->id_mapel }}" {{ ($p['id_mapel'] ?? '') == $mapel->id_mapel ? 'selected' : '' }}>
                                    {{ $mapel->nama_mapel }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-1 text-right">
                        {{-- Sembunyikan tombol hapus untuk item pertama kecuali ada old input lebih dari satu --}}
                        <button type="button" class="btn-remove-pembelajaran text-red-500 hover:text-red-700 text-sm p-2 {{ $i === 0 && count($pembelajarans) === 1 ? 'hidden' : '' }}">Hapus</button>
                    </div>
                </div>
                @endforeach
            </div>
            
            <button type="button" id="btn-add-pembelajaran" 
                    class="mt-2 text-sm text-blue-600 hover:text-blue-800">
                + Tambah Mata Pelajaran Lain
            </button>
        </div>

        {{-- Tombol Aksi --}}
        <div class="mt-6 pt-4 border-t border-gray-200 flex justify-end gap-3">
            <a href="{{ route('guru.index') }}"
               class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 transition duration-150">
                Batal
            </a>
            <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition duration-150">
                Simpan Data Guru
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('pembelajaran-container');
        const addButton = document.getElementById('btn-add-pembelajaran');
        
        // Mulai index dari jumlah elemen yang sudah ada (atau 0 jika tidak ada)
        let index = container.children.length; 

        // Fungsi untuk menghandle penghapusan baris
        const handleRemove = (e) => {
            e.target.closest('.pembelajaran-item').remove();
        };

        // Pasang listener pada tombol Hapus yang sudah ada saat load (dari old input)
        container.querySelectorAll('.btn-remove-pembelajaran').forEach(btn => {
            btn.addEventListener('click', handleRemove);
        });

        // Fungsi untuk membuat template baris baru (dipanggil saat tombol Tambah diklik)
        const cloneTemplate = () => {
            // Template HTML lengkap untuk baris baru
            const templateHtml = `
                <div class="pembelajaran-item grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-4 items-end border-b pb-4">
                    <div class="sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                        <select name="pembelajaran[${index}][id_kelas]" class="w-full border border-gray-300 rounded-md shadow-sm">
                            <option value="">Pilih Kelas</option>
                            @foreach ($kelasList as $kelas)
                                <option value="{{ $kelas->id_kelas }}">{{ $kelas->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
                        <select name="pembelajaran[${index}][id_mapel]" class="w-full border border-gray-300 rounded-md shadow-sm">
                            <option value="">Pilih Mapel</option>
                            @foreach ($mapelList as $mapel)
                                <option value="{{ $mapel->id_mapel }}">{{ $mapel->nama_mapel }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-1 text-right">
                        <button type="button" class="btn-remove-pembelajaran text-red-500 hover:text-red-700 text-sm p-2">Hapus</button>
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', templateHtml);
            
            // Pasang listener pada tombol hapus yang baru dibuat
            const newClone = container.lastElementChild;
            newClone.querySelector('.btn-remove-pembelajaran').addEventListener('click', handleRemove);
            
            index++;
        };
        
        // Pasang listener pada tombol Tambah
        addButton.addEventListener('click', cloneTemplate);
    });
</script>
@endpush
@endsection