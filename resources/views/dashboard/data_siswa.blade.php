<!-- resources/views/dashboard/data_siswa.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Data Siswa</title>

    <!-- Tailwind + Alpine -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style> body { font-family: 'Poppins', sans-serif; font-size: 15px; } </style>
</head>

<body class="bg-gray-100">
<div 
    x-data="appHandler()"
    class="flex min-h-screen">

    <!-- Sidebar -->
    @if(auth()->user()->role == 'admin')
        @include('dashboard.sidebar_admin')
    @elseif(auth()->user()->role == 'guru' && auth()->user()->is_walikelas == 0)
        @include('dashboard.sidebar_guru')
    @elseif(auth()->user()->role == 'guru' && auth()->user()->is_walikelas == 1)
        @include('dashboard.sidebar_wali')
    @endif

    <!-- Main Content -->
    <div class="flex-1 p-8 bg-gray-100">
        <div class="bg-white rounded-lg shadow p-6">
            <!-- Header -->
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Data Siswa Kelas</h2>
                <button 
                    @click="openTambahForm()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow text-sm flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Tambah Data
                </button>
            </div>
           <!-- Export & Search -->
            <div class="flex justify-between items-center mb-4">
            <!-- Tombol di kiri -->
            <div class="flex items-center space-x-2">
                <button class="bg-gray-200 text-black px-4 py-1 rounded hover:bg-gray-300 font-bold">+</button>
                <button class="bg-gray-200 px-4 py-1 rounded hover:bg-gray-300">PDF</button>
                <button class="bg-gray-200 px-4 py-1 rounded hover:bg-gray-300">CSV</button>
            </div>

            <!-- Search di kanan -->
            <input
                type="text"
                placeholder="Search..."
                class="border px-3 py-1 rounded focus:ring-1 focus:ring-blue-400 outline-none"/>
            </div>

            <!-- Tabel -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="px-4 py-2">No</th>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">NIS</th>
                            <th class="px-4 py-2">NISN</th>
                            <th class="px-4 py-2">JK</th>
                            <th class="px-4 py-2">Tingkat</th>
                            <th class="px-4 py-2">Kelas</th>
                            <th class="px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswa as $index => $s)
                        <tr class="border-t hover:bg-gray-50" x-data="{ openDropdown:false }">
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $s->nama_siswa }}</td>
                            <td class="px-4 py-2">{{ $s->nipd }}</td>
                            <td class="px-4 py-2">{{ $s->nisn }}</td>
                            <td class="px-4 py-2">{{ $s->jenis_kelamin }}</td>
                            <td class="px-4 py-2">{{ $s->tingkat }}</td>
                            <td class="px-4 py-2">{{ $s->kelas->nama_kelas ?? '-'  }}</td>
                            <!-- <td class="px-4 py-2">{{ $s->rombel }}</td> -->

                            <td class="px-4 py-2 text-center">
                                <div class="flex justify-center gap-2 relative">
                                    <!-- Tombol Aksi (dropdown) -->
                                    <div class="relative">
                                        <button 
                                            @click="openDropdown = !openDropdown"
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm flex items-center gap-1">
                                            <span>Aksi</span>
                                            <i class="fa-solid fa-caret-down ml-1"></i>
                                        </button>

                                        <!-- Dropdown -->
                                        <div 
                                            x-show="openDropdown"
                                            @click.away="openDropdown = false"
                                            x-transition
                                            class="absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded shadow-lg text-left z-20">
                                             <!-- EDIT -->
                                            <button 
                                                @click="openDropdown=false; editData('{{ route('dashboard.data_siswa.show', $s->id_siswa) }}')"
                                                class="w-full px-3 py-1 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                                <i class="fa-solid fa-pen text-blue-500 text-xs"></i> Edit
                                            </button>

                                             <!-- DELETE -->
                                            <button 
                                                @click="openDropdown=false; confirmDelete('{{ route('dashboard.data_siswa.destroy', $s->id_siswa) }}')"
                                                class="w-full px-3 py-1 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                                <i class="fa-solid fa-trash text-red-500 text-xs"></i> Hapus
                                            </button>
                                            <!-- UNDUH -->
                                            <button 
                                                @click="openDropdown=false; openDownload=true"
                                                class="w-full px-3 py-1 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                                <i class="fa-solid fa-download text-green-500 text-xs"></i> Unduh
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Tombol Detail -->
                                    <button 
                                        @click="showDetail('{{ route('dashboard.data_siswa.show', $s->id_siswa) }}')"
                                        class="bg-orange-400 hover:bg-orange-500 text-white px-3 py-1 rounded text-sm flex items-center gap-1">
                                        <i class="fa-solid fa-circle-info"></i> Detail
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ======== MODAL TAMBAH / EDIT ======== -->
        <div 
            x-show="openTambah || openEdit"
            x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center backdrop-blur-sm z-30"
        >

        <div class="bg-white rounded-2xl shadow-2xl w-2/4 p-6 relative overflow-y-auto max-h-[90vh]">

            <!-- Close -->
            <button @click="openTambah=false; openEdit=false"
                    class="absolute top-3 right-3 text-gray-500 hover:text-red-600">
                <i class="fa-solid fa-xmark text-2xl"></i>
            </button>

            <!-- Judul -->
            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i :class="openTambah ? 'fa-solid fa-user-plus text-blue-600' : 'fa-solid fa-pen text-blue-600'"></i>
                <span x-text="openTambah ? 'Tambah Data Siswa' : 'Edit Data Siswa'"></span>
            </h2>

            <!-- FORM -->
             @if ($errors->any())
                <div class="bg-red-200 text-red-700 p-2">
                    <pre>{{ print_r($errors->all(), true) }}</pre>
                </div>
            @endif

            <form
                method="POST"
                x-ref="formEdit"
                x-bind:action="openTambah 
                    ? '{{ route('dashboard.data_siswa.store') }}'
                    : '{{ url('/dashboard/data_siswa') }}/' + formData.id_siswa"
                enctype="multipart/form-data"
                class="flex flex-col gap-4 text-sm">
                @csrf
                <template x-if="openEdit">
                    <input type="hidden" name="_method" value="PUT">
                </template>


                    <!-- ========== DATA SISWA ========== -->
                    <div class="border-t pt-3"><h3 class="font-bold text-gray-700 mb-2 text-lg">Data Siswa</h3></div>
                    
                    <div class="grid grid-cols-2 gap-4">
                    <!-- NAMA SISWA -->
                    <div><label class="block mb-1 font-medium">Nama Siswa</label><input name="nama_siswa" x-model="formData.nama_siswa" type="text"class="w-full border rounded-lg px-3 py-2"></div>
                    <!-- NIPD -->
                    <div><label class="block mb-1 font-medium">NIPD</label><input name="nipd" x-model="formData.nipd" type="text"class="w-full border rounded-lg px-3 py-2"></div>
                    <!-- NISN -->
                    <div><label class="block mb-1 font-medium">NISN</label><input name="nisn" x-model="formData.nisn" type="text"class="w-full border rounded-lg px-3 py-2"></div>
                    <!-- NIK -->
                    <div><label class="block mb-1 font-medium">NIK</label><input name="nik" x-model="formData.nik" type="text"class="w-full border rounded-lg px-3 py-2"></div>
                    <!-- TEMPAT LAHIR -->
                    <div><label class="block mb-1 font-medium">Tempat Lahir</label><input name="tempat_lahir" x-model="formData.tempat_lahir" type="text"class="w-full border rounded-lg px-3 py-2"></div>
                    <!-- TANGGAL LAHIR -->
                    <div><label class="block mb-1 font-medium">Tanggal Lahir</label><input name="tanggal_lahir" x-model="formData.tanggal_lahir" type="date"class="w-full border rounded-lg px-3 py-2"></div>
                    <!-- JENIS KELAMIN -->
                    <div><label class="block mb-1 font-medium">Jenis Kelamin</label>
                        <select name="jenis_kelamin" x-model="formData.jenis_kelamin"
                                class="w-full border rounded-lg px-3 py-2">
                            <option value="">Pilih...</option>
                            <option value="L">L</option>
                            <option value="P">P</option></select></div>
                    <!-- AGAMA -->
                    <div><label class="block mb-1 font-medium">Agama</label>
                        <select name="agama" x-model="formData.agama"
                                class="w-full border rounded-lg px-3 py-2">
                            <option value="">Pilih...</option>
                            <option>Islam</option>
                            <option>Kristen</option>
                            <option>Katholik</option>
                            <option>Budha</option>
                            <option>Hindu</option></select></div>
                    <!-- ALAMAT -->
                    <div class="col-span-2"><label class="block mb-1 font-medium">Alamat</label><textarea name="alamat" x-model="formData.alamat"class="w-full border rounded-lg px-3 py-2"></textarea></div>
                    <!-- RT -->
                    <div><label class="block mb-1 font-medium">RT</label><input name="rt" x-model="formData.rt" type="number"class="w-full border rounded-lg px-3 py-2"></div>
                    <!-- RW -->
                    <div><label class="block mb-1 font-medium">RW</label><input name="rw" x-model="formData.rw" type="number"class="w-full border rounded-lg px-3 py-2"></div>
                    <!-- Dusun -->
                    <div><label class="block mb-1 font-medium">Dusun</label><input name="dusun" x-model="formData.dusun" type="text"class="w-full border rounded-lg px-3 py-2"></div>
                    <!-- Jenis Tinggal -->
                    <div><label class="block mb-1 font-medium">Jenis Tinggal</label>
                        <select name="jenis_tinggal" x-model="formData.jenis_tinggal"
                                class="w-full border rounded-lg px-3 py-2">
                            <option value="">Pilih...</option>
                            <option>Asrama</option>
                            <option>Bersama Orang Tua</option>
                            <option>Kost</option>
                            <option>Panti Asuhan</option>
                            <option>Pesantren</option>
                            <option>Wali</option>
                            <option>Lainnya</option></select></div>
                    <!-- Alat Transportasi -->
                    <div><label class="block mb-1 font-medium">Alat Transportasi</label>
                        <select name="alat_transportasi" x-model="formData.alat_transportasi"
                                class="w-full border rounded-lg px-3 py-2">
                            <option value="">Pilih...</option>
                            <option>Angkutan Umum/Bus/Pete-pete</option>
                            <option>Jalan Kaki</option>
                            <option>Mobil Pribadi</option>
                            <option>Mobil/Bus Antar Jemput</option>
                            <option>Motor</option>
                            <option>Sepeda</option>
                            <option>Ojek</option>
                            <option>Lainnya</option></select></div>
                    <!-- No Telp --><div><label class="block mb-1 font-medium">Telepon</label><input name="telepon" x-model="formData.telepon" type="number"class="w-full border rounded-lg px-3 py-2"></div>
                    <!-- No HP --><div><label class="block mb-1 font-medium">No HP</label><input name="no_hp" x-model="formData.no_hp" type="number"class="w-full border rounded-lg px-3 py-2"></div>
                    <!-- Email--><div><label class="block mb-1 font-medium">Email</label><input name="email" x-model="formData.email" type="email"class="w-full border rounded-lg px-3 py-2"></div>
                    <!-- SKHUN --><div><label class="block mb-1 font-medium">SKHUN</label><input name="skhun" accept=".pdf,.jpg,.png" type="file"class="w-full border rounded-lg px-3 py-2"></div>
                    <!-- Penerima KPS --><div><label class="block mb-1 font-medium">Penerima KPS</label>
                        <select name="penerima_kps" x-model="formData.penerima_kps"
                                class="w-full border rounded-lg px-3 py-2">
                            <option value="">Pilih...</option>
                            <option>Ya</option>
                            <option>Tidak</option></select></div>
                    <!-- No KPS --><div><label class="block mb-1 font-medium">No KPS</label><input name="no_kps" x-model="formData.no_kps" type="text"class="w-full border rounded-lg px-3 py-2"></div>
                    <!-- Rombel/Kelas/Tingkat -->
                    <div><label class="block mb-1 font-medium">Rombel</label>
                        <select name="tingkat" x-model="formData.tingkat"
                                class="w-full border rounded-lg px-3 py-2">
                            <option value="">Pilih...</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option></select></div>
                    <div><label for="id_kelas" class="block mb-1 font-medium">Kelas</label>
                        <select 
                            name="id_kelas" 
                            id="id_kelas" 
                            x-model="formData.id_kelas"
                            class="w-full border rounded-lg px-3 py-2"
                            required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id_kelas }}">
                                    {{ $k->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- No Peserta UN -->
                    <div><label class="block mb-1 font-medium">No Peserta Ujian Nasional</label><input name="no_peserta_ujian_nasional" x-model="formData.no_peserta_ujian_nasional" type="text"class="w-full border rounded-lg px-3 py-2"></div>
                    <!-- No Seri Ijazah -->
                    <div><label class="block mb-1 font-medium">No Seri Ijazah</label><input name="no_seri_ijazah" x-model="formData.no_seri_ijazah" type="text"class="w-full border rounded-lg px-3 py-2"></div>
                    <!-- Penerima KIP -->
                    <div><label class="block mb-1 font-medium">Penerima KIP</label>
                        <select name="penerima_kip" x-model="formData.penerima_kip"
                                class="w-full border rounded-lg px-3 py-2">
                            <option value="">Pilih...</option>
                            <option>Ya</option>
                            <option>Tidak</option></select></div>
                    <!-- No KIP -->
                    <div>
                        <label class="block mb-1 font-medium">No KIP</label>
                        <input name="no_kip" x-model="formData.no_kip" type="text"
                            class="w-full border rounded-lg px-3 py-2">
                    </div>
                    <!-- Nama KIP -->
                    <div>
                        <label class="block mb-1 font-medium">Nama di KIP</label>
                        <input name="nama_kip" x-model="formData.nama_kip" type="text"
                            class="w-full border rounded-lg px-3 py-2">
                    </div>
                    <!-- No KKS -->
                    <div>
                        <label class="block mb-1 font-medium">No KKS</label>
                        <input name="no_kks" x-model="formData.no_kks" type="text"
                            class="w-full border rounded-lg px-3 py-2">
                    </div>
                    <!-- No Regis Akta Lahir -->
                    <div>
                        <label class="block mb-1 font-medium">No Registrasi Akta Lahir</label>
                        <input name="no_regis_akta_lahir" x-model="formData.no_regis_akta_lahir" type="text"
                            class="w-full border rounded-lg px-3 py-2">
                    </div>
                    <!-- Bank -->
                    <div>
                        <label class="block mb-1 font-medium">Bank</label>
                        <input name="bank" x-model="formData.bank" type="text"
                            class="w-full border rounded-lg px-3 py-2">
                    </div>
                    <!-- No Rek Bank -->
                    <div>
                        <label class="block mb-1 font-medium">No Rekening Bank</label>
                        <input name="no_rek_bank" x-model="formData.no_rek_bank" type="text"
                            class="w-full border rounded-lg px-3 py-2">
                    </div>
                    <!-- Rekening Atas Nama -->
                    <div>
                        <label class="block mb-1 font-medium">Rekening Atas Nama</label>
                        <input name="rek_atas_nama" x-model="formData.rek_atas_nama" type="text"
                            class="w-full border rounded-lg px-3 py-2">
                    </div>
                    <!-- Layak PIP -->
                    <div>
                        <label class="block mb-1 font-medium">Layak PIP</label>
                        <select name="layak_pip_usulan" x-model="formData.layak_pip_usulan"
                                class="w-full border rounded-lg px-3 py-2">
                            <option value="">Pilih...</option>
                            <option>Ya</option>
                            <option>Tidak</option>
                        </select>
                    </div>
                    <!-- Alasan Layak PIP -->
                    <div>
                        <label class="block mb-1 font-medium">Alasan Layak PIP</label>
                        <select name="alasan_layak_pip" x-model="formData.alasan_layak_pip"
                                class="w-full border rounded-lg px-3 py-2">
                            <option value="">Pilih...</option>
                            <option>Pemegang PKH/KPS/KKS</option>
                            <option>Siswa Miskin/Rentan Miskin</option>
                            <option>Sudah Mampu</option>
                            <option>Yatim Piatu/Panti Asuhan/Panti Sosial</option>
                        </select>
                    </div>
                    <!-- Kebutuhan Khusus -->
                    <div>
                        <label class="block mb-1 font-medium">Kebutuhan Khusus</label>
                        <select name="kebutuhan_khusus" x-model="formData.kebutuhan_khusus"
                                class="w-full border rounded-lg px-3 py-2">
                            <option value="">Pilih...</option>
                            <option>Kesulitan Belajar</option>
                            <option>Tidak Ada</option>
                        </select>
                    </div>
                    <!-- Asal Sekolah -->
                    <div>
                        <label class="block mb-1 font-medium">Sekolah Asal</label>
                        <input name="sekolah_asal" x-model="formData.sekolah_asal" type="text"
                            class="w-full border rounded-lg px-3 py-2">
                    </div>
                    <!-- Anak Ke -->
                    <div>
                        <label class="block mb-1 font-medium">Anak Ke-</label>
                        <input name="anak_ke_berapa" x-model="formData.anak_ke_berapa" type="number"
                            class="w-full border rounded-lg px-3 py-2">
                    </div>
                    <!-- Lintang -->
                    <div>
                        <label class="block mb-1 font-medium">Lintang</label>
                        <input name="lintang" x-model="formData.lintang" type="text"
                            class="w-full border rounded-lg px-3 py-2">
                    </div>
                    <!-- Bujur -->
                    <div>
                        <label class="block mb-1 font-medium">Bujur</label>
                        <input name="bujur" x-model="formData.bujur" type="text"
                            class="w-full border rounded-lg px-3 py-2">
                    </div>
                    <!-- No KK -->
                    <div>
                        <label class="block mb-1 font-medium">No KK</label>
                        <input name="no_kk" x-model="formData.no_kk" type="text"
                            class="w-full border rounded-lg px-3 py-2">
                    </div>
                    <!-- BB -->
                    <div>
                        <label class="block mb-1 font-medium">Berat Badan</label>
                        <input name="bb" x-model="formData.bb" type="number"
                            class="w-full border rounded-lg px-3 py-2">
                    </div>
                    <!-- TB -->
                    <div>
                        <label class="block mb-1 font-medium">Tinggi Badan</label>
                        <input name="tb" x-model="formData.tb" type="number"
                            class="w-full border rounded-lg px-3 py-2">
                    </div>
                    <!-- Lingkar Kepala -->
                    <div>
                        <label class="block mb-1 font-medium">Lingkar Kepala</label>
                        <input name="lingkar_kepala" x-model="formData.lingkar_kepala" type="number"
                            class="w-full border rounded-lg px-3 py-2">
                    </div>
                    <!-- Jumlah Saudara Kandung -->
                    <div>
                        <label class="block mb-1 font-medium">Jumlah Saudara Kandung</label>
                        <input name="jml_saudara_kandung" x-model="formData.jml_saudara_kandung" type="number"
                            class="w-full border rounded-lg px-3 py-2">
                    </div>
                    <!-- Jarak Rumah ke Sekolah -->
                    <div>
                        <label class="block mb-1 font-medium">Jarak Rumah ke Sekolah</label>
                        <input name="jarak_rumah" x-model="formData.jarak_rumah" type="number"
                            class="w-full border rounded-lg px-3 py-2">
                    </div>
                    <!-- Ekskul -->
                    <div>
                        <label class="block mb-1 font-medium">Ekstrakulikuler</label>
                        <select name="id_ekskul" x-model="formData.id_ekskul"
                                class="w-full border rounded-lg px-3 py-2">
                            <option value="">Pilih...</option>
                            @foreach($ekskul as $e)
                                <option value="{{ $e->id_ekskul }}">
                                    {{ $e->nama_ekskul }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                    
                    <!-- ========== DATA AYAH ========== -->
                    <div class="border-t pt-3">
                    <h3 class="font-bold text-gray-700 mb-2 text-lg">Data Ayah</h3>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <!-- NAMA Ayah -->
                        <div>
                            <label class="block mb-1 font-medium">Nama Ayah</label>
                            <input name="nama_ayah" x-model="formData.nama_ayah" type="text"
                                class="w-full border rounded-lg px-3 py-2">
                        </div>
                        <!-- Tahun Lahir Ayah -->
                        <div>
                            <label class="block mb-1 font-medium">Tahun Lahir (Ayah)</label>
                            <input name="tahun_lahir_ayah" x-model="formData.tahun_lahir_ayah" type="number"
                                class="w-full border rounded-lg px-3 py-2">
                        </div>
                        <!-- Jenjang Pendidikan Ayah -->
                        <div>
                            <label class="block mb-1 font-medium">Jenjang Pendidikan (Ayah)</label>
                            <select name="jenjang_pendidikan_ayah" x-model="formData.jenjang_pendidikan_ayah"
                                    class="w-full border rounded-lg px-3 py-2">
                                <option value="">Pilih...</option>
                                <option>SD/Sederajat</option>
                                <option>SMP/Sederajat</option>
                                <option>SMA/Sederajat</option>
                                <option>D1</option>
                                <option>D2</option>
                                <option>D3</option>
                                <option>D4</option>
                                <option>S1</option>
                                <option>S2</option>
                                <option>Tidak Bersekolah</option>
                            </select>
                        </div>
                        <!-- Pekerjaan Ayah -->
                        <div>
                            <label class="block mb-1 font-medium">Pekerjaan (Ayah)</label>
                            <input name="pekerjaan_ayah" x-model="formData.pekerjaan_ayah" type="text"
                                class="w-full border rounded-lg px-3 py-2">
                        </div>
                        <!-- Penghasilan Ayah -->
                        <div>
                            <label class="block mb-1 font-medium">Penghasilan Ayah</label>
                            <select name="penghasilan_ayah" x-model="formData.penghasilan_ayah"
                                    class="w-full border rounded-lg px-3 py-2">
                                <option value="">Pilih...</option>
                                <option>< Rp. 500.000</option>
                                <option>Rp 500.000 - Rp 999.999</option>
                                <option>Rp 1.000.000 - Rp 4.999.999</option>
                                <option>> Rp 5.000.000</option>
                                <option>Tidak Berpenghasilan</option>
                            </select>
                        </div>
                        <!-- NIK Ayah -->
                        <div>
                            <label class="block mb-1 font-medium">NIK (Ayah)</label>
                            <input name="nik_ayah" x-model="formData.nik_ayah" type="text"
                                class="w-full border rounded-lg px-3 py-2">
                        </div>
                    </div>

                    <!-- ========== DATA IBU ========== -->
                    <div class="border-t pt-3">
                        <h3 class="font-bold text-gray-700 mb-2 text-lg">Data Ibu</h3>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <!-- NAMA Ibu -->
                        <div>
                            <label class="block mb-1 font-medium">Nama Ibu</label>
                            <input name="nama_ibu" x-model="formData.nama_ibu" type="text"
                                class="w-full border rounded-lg px-3 py-2">
                        </div>
                        <!-- Tahun Lahir Ibu -->
                        <div>
                            <label class="block mb-1 font-medium">Tahun Lahir (Ibu)</label>
                            <input name="tahun_lahir_ibu" x-model="formData.tahun_lahir_ibu" type="number"
                                class="w-full border rounded-lg px-3 py-2">
                        </div>
                        <!-- Jenjang Pendidikan Ibu -->
                        <div>
                            <label class="block mb-1 font-medium">Jenjang Pendidikan (Ibu)</label>
                            <select name="jenjang_pendidikan_ibu" x-model="formData.jenjang_pendidikan_ibu"
                                    class="w-full border rounded-lg px-3 py-2">
                                <option value="">Pilih...</option>
                                <option>SD/Sederajat</option>
                                <option>SMP/Sederajat</option>
                                <option>SMA/Sederajat</option>
                                <option>D1</option>
                                <option>D2</option>
                                <option>D3</option>
                                <option>D4</option>
                                <option>S1</option>
                                <option>S2</option>
                                <option>Tidak Bersekolah</option>
                            </select>
                        </div>
                        <!-- Pekerjaan Ibu -->
                        <div>
                            <label class="block mb-1 font-medium">Pekerjaan (Ibu)</label>
                            <input name="pekerjaan_ibu" x-model="formData.pekerjaan_ibu" type="text"
                                class="w-full border rounded-lg px-3 py-2">
                        </div>
                        <!-- Penghasilan Ibu -->
                        <div>
                            <label class="block mb-1 font-medium">Penghasilan (Ibu)</label>
                            <select name="penghasilan_ibu" x-model="formData.penghasilan_ibu"
                                    class="w-full border rounded-lg px-3 py-2">
                                <option value="">Pilih...</option>
                                <option>< Rp. 500.000</option>
                                <option>Rp 500.000 - Rp 999.999</option>
                                <option>Rp 1.000.000 - Rp 4.999.999</option>
                                <option>> Rp 5.000.000</option>
                                <option>Tidak Berpenghasilan</option>
                            </select>
                        </div>
                        <!-- NIK Ibu -->
                        <div>
                            <label class="block mb-1 font-medium">NIK (Ibu)</label>
                            <input name="nik_ibu" x-model="formData.nik_ibu" type="text"
                                class="w-full border rounded-lg px-3 py-2">
                        </div>
                    </div>

                    <!-- ========== DATA WALI ========== -->
                    <div class="border-t pt-3">
                        <h2 class="font-bold text-gray-700 mb-2 text-lg">Data Wali</h2>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <!-- NAMA Wali -->
                        <div>
                            <label class="block mb-1 font-medium">Nama Wali</label>
                            <input name="nama_wali" x-model="formData.nama_wali" type="text"
                                class="w-full border rounded-lg px-3 py-2">
                        </div>
                        <!-- Tahun Lahir Wali -->
                        <div>
                            <label class="block mb-1 font-medium">Tahun Lahir (Wali)</label>
                            <input name="tahun_lahir_wali" x-model="formData.tahun_lahir_wali" type="number"
                                class="w-full border rounded-lg px-3 py-2">
                        </div>
                        <!-- Jenjang Pendidikan Wali -->
                        <div>
                            <label class="block mb-1 font-medium">Jenjang Pendidikan (Wali)</label>
                            <select name="jenjang_pendidikan_wali" x-model="formData.jenjang_pendidikan_wali"
                                    class="w-full border rounded-lg px-3 py-2">
                                <option value="">Pilih...</option>
                                <option>SD/Sederajat</option>
                                <option>SMP/Sederajat</option>
                                <option>SMA/Sederajat</option>
                                <option>D1</option>
                                <option>D2</option>
                                <option>D3</option>
                                <option>D4</option>
                                <option>S1</option>
                                <option>S2</option>
                                <option>Tidak Bersekolah</option>
                            </select>
                        </div>
                        <!-- Pekerjaan Wali -->
                        <div>
                            <label class="block mb-1 font-medium">Pekerjaan (Wali)</label>
                            <input name="pekerjaan_wali" x-model="formData.pekerjaan_wali" type="text"
                                class="w-full border rounded-lg px-3 py-2">
                        </div>
                        <!-- Penghasilan Wali -->
                        <div>
                            <label class="block mb-1 font-medium">Penghasilan (Wali)</label>
                            <select name="penghasilan_wali" x-model="formData.penghasilan_wali"
                                    class="w-full border rounded-lg px-3 py-2">
                                <option value="">Pilih...</option>
                                <option>< Rp. 500.000</option>
                                <option>Rp 500.000 - Rp 999.999</option>
                                <option>Rp 1.000.000 - Rp 4.999.999</option>
                                <option>> Rp 5.000.000</option>
                                <option>Tidak Berpenghasilan</option>
                            </select>
                        </div>
                        <!-- NIK Wali -->
                        <div>
                            <label class="block mb-1 font-medium">NIK (Wali)</label>
                            <input name="nik_wali" x-model="formData.nik_wali" type="text"
                                class="w-full border rounded-lg px-3 py-2">
                        </div>
                    </div>

                    <!-- ========== BUTTON SIMPAN ========== -->
                        <div class="flex justify-end gap-3 mt-4 pt-4 border-t">
                            <button type="button"
                                    @click="openTambah=false; openEdit=false"
                                    class="px-4 py-2 rounded-lg bg-gray-400 hover:bg-gray-500 text-white">
                                Batal
                            </button>

                            <button type="submit"
                                    class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white">
                                Simpan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
            <!-- ======== END MODAL ======== -->


            <!-- ======== MODAL DETAIL ======== -->
            <div x-show="openDetail" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center backdrop-blur-sm z-30" x-transition>
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl p-6 relative overflow-y-auto max-h-[90vh]">
                <button @click="openDetail = false" class="absolute top-3 right-3 text-gray-500 hover:text-red-600">
                <i class="fa-solid fa-xmark text-2xl"></i>
                </button>
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-circle-info text-blue-600"></i> Detail Siswa
                </h2>

                <form class="flex flex-col gap-4 text-sm">
                <!-- Loop Section -->
                <template x-for="section in detailSections" :key="section.title">
                    <div>
                        <div class="border-t pt-3 mb-2">
                            <h3 class="font-bold text-gray-700 mb-2 text-lg" x-text="section.title"></h3>
                        </div>

                        <!-- Loop Field -->
                        <template x-for="field in section.fields" :key="field.label">
                            <div class="mb-2">
                                <label class="block mb-1 text-gray-700 font-medium" x-text="field.label"></label>

                                <!-- Auto binding field -->
                                <input type="text" readonly
                                    class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600"
                                    :value="getFieldValue(field.key)">
                            </div>
                        </template>

                    </div>
                    </form>
                    </template>
                </div>
                </div>

            <!-- 🟩 Modal Hapus Data -->
            <div x-show="openDelete"
                            class="fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white p-6 rounded-lg shadow-lg w-96 text-center">
                    <p class="text-gray-700 text-sm mb-3">
                        Tindakan ini akan menghapus seluruh data yang terkait dengan data tersebut.
                    <br>
                        <span class="font-medium">Data yang sudah dihapus tidak dapat dikembalikan.</span>
                    </p>

                    <div class="flex justify-center gap-3 mt-4">
                    <button @click="openDelete = false"
                        class="bg-gray-200 text-gray-700 px-4 py-1 rounded font-medium hover:bg-gray-300">
                        Batal
                    </button>
                    <button @click="openDelete = false"
                        class="bg-red-600 text-white px-4 py-1 rounded font-medium hover:bg-red-700">
                        Hapus
                    </button>
                </div>
                </div>
                </div>

                <!-- 🟩 Modal Unduh -->
                    <div x-show="openDownload"
                        x-transition.opacity
                        class="fixed inset-0 bg-gray-500 bg-opacity-50 flex backdrop-blur-sm items-center justify-center z-50">
                        <div class="bg-white p-6 rounded-lg shadow-lg w-96 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fa-solid fa-download text-blue-600 text-3xl mb-3"></i>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Unduh Data</h3>
                                <p class="text-gray-600 text-sm mb-4">
                                    Klik tombol di bawah untuk mengunduh seluruh data dalam format yang tersedia.
                                </p>
                            </div>
                            <div class="flex justify-center gap-3">
                                <button @click="openDownload=false"
                                    class="bg-gray-200 text-gray-700 px-4 py-1 rounded font-medium hover:bg-gray-300">
                                    Batal
                                </button>
                                <button 
                                    @click="downloadExcel()"
                                    class="bg-blue-600 text-white px-4 py-1 rounded font-medium hover:bg-blue-700 flex items-center gap-1">
                                    <i class="fa-solid fa-download text-sm"></i> Unduh
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- 🟩 End Modal Unduh -->

                <script>
                function appHandler() {
                    return {
                        sidebarOpen: true,
                        dataSekolahOpen: true,
                        inputNilaiOpen: false,   // ➜ DITAMBAHKAN
                        openTambah: false,
                        openEdit: false,
                        openDetail: false,
                        openDelete: false,
                        openDownload: false,

                        detailData: {},
                        detailSections: [],      // ➜ DITAMBAHKAN

                        formData: {
                            id_siswa: "",
                            nama_siswa: "",
                            nipd: "",
                            nisn: "",
                            nik: "",
                            tempat_lahir: "",
                            tanggal_lahir: "",
                            jenis_kelamin: "",
                            agama: "",
                            alamat: "",
                            rt: "",
                            rw: "",
                            dusun: "",
                            jenis_tinggal: "",
                            alat_transportasi: "",
                            no_telepon: "",
                            no_hp: "",
                            email: "",
                            skhun: "",
                            penerima_kps: "",
                            no_kps: "",
                            rombel: "",
                            no_peserta_ujian_nasional: "",
                            no_seri_ijazah: "",
                            penerima_kip: "",
                            no_kip: "",
                            nama_kip: "",
                            no_kks: "",
                            no_regis_akta_lahir: "",
                            bank: "",
                            no_rek_bank: "",
                            rek_atas_nama: "",
                            layak_pip_usulan: "",
                            alasan_layak_pip: "",
                            kebutuhan_khusus: "",
                            asal_sekolah: "",
                            anak_ke_berapa: "",
                            lintang: "",
                            bujur: "",
                            no_kk: "",
                            bb: "",
                            tb: "",
                            lingkar_kepala: "",
                            jml_saudara_kandung: "",
                            jarak_rumah: "",
                            ekskul: "",

                            // AYAH
                            nama_ayah: "",
                            tahun_lahir_ayah: "",
                            jenjang_pendidikan_ayah: "",
                            pekerjaan_ayah: "",
                            penghasilan_ayah: "",
                            nik_ayah: "",

                            // IBU
                            nama_ibu: "",
                            tahun_lahir_ibu: "",
                            jenjang_pendidikan_ibu: "",
                            pekerjaan_ibu: "",
                            penghasilan_ibu: "",
                            nik_ibu: "",

                            // WALI
                            nama_wali: "",
                            tahun_lahir_wali: "",
                            jenjang_pendidikan_wali: "",
                            pekerjaan_wali: "",
                            penghasilan_wali: "",
                            nik_wali: "",
                        },

                        resetForm() {
                            Object.keys(this.formData).forEach(k => this.formData[k] = "");
                        },

                        openTambahForm() {
                            this.resetForm();
                            this.openTambah = true;
                            this.openEdit = false;
                        },
                        // buka modal edit
                        openEditForm(data) {
                            this.openTambah = false;
                            this.openEdit = true;
                            this.formData = { ...data };
                        },

                        async editData(url) {
                                    this.openEdit = true;

                                    try {
                                        let res = await fetch(url);
                                        let data = await res.json();

                                        this.formData = data;   // isi data ke semua x-model
                                    } catch (e) {
                                        console.error("Gagal mengambil data siswa:", e);
                                    }
                                },

                        showDetail(url) {
                            this.openDetail = true;
                            fetch(url)
                                .then(r => r.json())
                                .then(d => this.detailData = d);
                        },

                        confirmDelete(url) {
                            this.deleteUrl = url;
                            this.openDelete = true;
                        },

                        deleteData() {
                            fetch(this.deleteUrl, {
                                method: "DELETE",
                                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
                            }).then(() => location.reload());
                        },

                        downloadExcel() {
                            window.location.href = "{{ route('dashboard.data_siswa.export') }}";
                            this.openDownload = false;
                        }
                    }
                }
                </script>
        </div>
</div>
<script src="//cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
