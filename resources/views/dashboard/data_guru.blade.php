<!-- resources/views/dashboard/data_guru.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Data Guru</title>
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Tailwind & Alpine -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; font-size: 15px; }
  </style>

  </head>

<body class="bg-gray-100">
<div
  x-data="{
    ...guruManager(),
    sidebarOpen: true,
    dataSekolahOpen: true,
    inputNilaiOpen: false,
    openDownload: false
  }"
  class="flex min-h-screen"
>
<!-- Sidebar -->
    <div 
    :class="sidebarOpen ? 'w-56' : 'w-20'"
     class="bg-blue-700 text-white transition-all duration-300 flex flex-col justify-between shadow-lg">
    <div>
        <!-- Header -->
        <div :class="sidebarOpen ? 'flex items-center justify-center py-4 border-b border-blue-500' : 'flex items-center justify-center py-4 border-b border-blue-500'"> 
            <template x-if="sidebarOpen"> 
                <h1 class="text-lg font-semibold">Super Admin</h1> 
            </template> 
            <button @click="sidebarOpen = !sidebarOpen" class="text-white focus:outline-none transition-all duration-300" :class="sidebarOpen ? 'ml-3' : 'mx-auto'"> 
                <i class="fa-solid fa-bars text-2xl"></i> 
            </button> 
        </div>

        <!-- Menu -->
        <nav class="mt-6 space-y-1 font-medium">
            <!-- Beranda -->
            <a href="{{ route('dashboard') }}" 
               class="flex items-center py-2 transition
                    {{ request()->routeIs('dashboard') ? 'bg-blue-800' : 'hover:bg-blue-800' }}"
               :class="sidebarOpen ? 'px-4 justify-start' : 'justify-center'">
                <i class="fa-solid fa-house text-2xl"></i>
                <span x-show="sidebarOpen" class="ml-3 text-base">Beranda</span>
            </a>

            <!-- Data Sekolah -->
            <div>
                <button @click="dataSekolahOpen = !dataSekolahOpen"
                        class="w-full flex items-center transition py-2
                            {{ request()->routeIs('dashboard.info_sekolah') ||
                               request()->routeIs('dashboard.data_kelas') ||
                               request()->routeIs('dashboard.data_siswa') ||
                               request()->routeIs('dashboard.data_guru')? 'bg-blue-800' : 'hover:bg-blue-800' }}"
                        :class="sidebarOpen ? 'px-4 justify-between' : 'justify-center'">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-school text-2xl"></i>
                        <span x-show="sidebarOpen">Data Sekolah</span>
                    </div>
                    <i x-show="sidebarOpen" 
                       :class="{'rotate-90': dataSekolahOpen}"
                       class="fa-solid fa-chevron-right text-xs transition-transform"></i>
                </button>

                <div x-show="dataSekolahOpen" x-transition class="pl-10 bg-blue-600/40 text-sm overflow-hidden">
                    <a href="{{ route('dashboard.info_sekolah') }}" 
                       class="block py-2 flex items-center space-x-2 transition 
                            {{ request()->routeIs('dashboard.info_sekolah') ? 'bg-blue-700/70 rounded-l-md' : 'hover:bg-blue-700' }}">
                        <i class="fa-regular fa-circle-right text-xs"></i><span>Info Sekolah</span>
                    </a>

                    <a href="{{ route('dashboard.data_kelas') }}" 
                       class="block py-2 flex items-center space-x-2 transition 
                            {{ request()->routeIs('dashboard.data_kelas') ? 'bg-blue-700/70 rounded-l-md' : 'hover:bg-blue-700' }}">
                        <i class="fa-solid fa-chalkboard text-xs"></i><span>Data Kelas</span>
                    </a>

                     <a href="{{ route('dashboard.data_guru') }}" 
                       class="block py-2 flex items-center space-x-2 transition 
                            {{ request()->routeIs('dashboard.data_guru') ? 'bg-blue-700/70 rounded-l-md' : 'hover:bg-blue-700' }}">
                        <i class="fa-solid fa-chalkboard text-xs"></i><span>Data Guru</span>
                    </a>

                    <a href="{{ route('dashboard.data_siswa') }}" 
                       class="block py-2 flex items-center space-x-2 transition 
                            {{ request()->routeIs('dashboard.data_siswa') ? 'bg-blue-700/70 rounded-l-md' : 'hover:bg-blue-700' }}">
                        <i class="fa-solid fa-users text-xs"></i><span>Data Siswa</span>
                    </a>

                     <a href="{{ route('dashboard.data_mapel') }}" 
                       class="block py-2 flex items-center space-x-2 transition 
                            {{ request()->routeIs('dashboard.data_mapel') ? 'bg-blue-700/70 rounded-l-md' : 'hover:bg-blue-700' }}">
                        <i class="fa-solid fa-users text-xs"></i><span>Data Mapel</span>
                    </a>

                    <a href="{{ route('dashboard.data_pembelajaran') }}" 
                       class="block py-2 flex items-center space-x-2 transition 
                            {{ request()->routeIs('dashboard.data_pembelajaran') ? 'bg-blue-700/70 rounded-l-md' : 'hover:bg-blue-700' }}">
                        <i class="fa-solid fa-users text-xs"></i><span>Data Pembelajaran</span>
                    </a>

                     <a href="{{ route('dashboard.data_ekskul') }}" 
                       class="block py-2 flex items-center space-x-2 transition 
                            {{ request()->routeIs('dashboard.data_ekskul') ? 'bg-blue-700/70 rounded-l-md' : 'hover:bg-blue-700' }}">
                        <i class="fa-solid fa-users text-xs"></i><span>Data Ekstrakulikuler</span>
                    </a>
                </div>
            </div>

            <!-- Input Nilai -->
            <div>
                <button @click="inputNilaiOpen = !inputNilaiOpen"
                        class="w-full flex items-center transition py-2
                            {{ request()->routeIs('dashboard.input.*') ? 'bg-blue-800' : 'hover:bg-blue-800' }}"
                        :class="sidebarOpen ? 'px-4 justify-between' : 'justify-center'">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-pen-to-square text-2xl"></i>
                        <span x-show="sidebarOpen">Input Nilai</span>
                    </div>
                    <i x-show="sidebarOpen" 
                       :class="{'rotate-90': inputNilaiOpen}"
                       class="fa-solid fa-chevron-right text-xs transition-transform"></i>
                </button>

                <div x-show="inputNilaiOpen" x-transition class="pl-10 bg-blue-600/40 text-sm">
                    <a href="{{ route('input.tugas') }}" 
                       class="block py-2 flex items-center space-x-2 transition 
                            {{ request()->routeIs('input.tugas') ? 'bg-blue-700/70 rounded-l-md' : 'hover:bg-blue-700' }}">
                        <i class="fa-solid fa-users text-xs"></i><span>Tugas</span>
                    </a>
                    <a href="{{ route('input.ulangan') }}" 
                       class="block py-2 flex items-center space-x-2 transition 
                            {{ request()->routeIs('input.ulangan') ? 'bg-blue-700/70 rounded-l-md' : 'hover:bg-blue-700' }}">
                        <i class="fa-solid fa-users text-xs"></i><span>Ulangan Harian</span>
                    </a>
                    <a href="{{ route('input.sts') }}" 
                       class="block py-2 flex items-center space-x-2 transition 
                            {{ request()->routeIs('input.sts') ? 'bg-blue-700/70 rounded-l-md' : 'hover:bg-blue-700' }}">
                        <i class="fa-solid fa-users text-xs"></i><span>STS</span>
                    </a>
                    <a href="{{ route('input.sas') }}" 
                       class="block py-2 flex items-center space-x-2 transition 
                            {{ request()->routeIs('input.sas') ? 'bg-blue-700/70 rounded-l-md' : 'hover:bg-blue-700' }}">
                        <i class="fa-solid fa-users text-xs"></i><span>SAS</span>
                    </a>
                    <a href="{{ route('input.sat') }}" 
                       class="block py-2 flex items-center space-x-2 transition 
                            {{ request()->routeIs('input.sat') ? 'bg-blue-700/70 rounded-l-md' : 'hover:bg-blue-700' }}">
                        <i class="fa-solid fa-users text-xs"></i><span>SAT</span>
                    </a>
                </div>
            </div>

            <!-- Cetak Nilai -->
            <a href="#" 
               class="flex items-center py-2 transition
                    {{ request()->routeIs('dashboard.cetak') ? 'bg-blue-800' : 'hover:bg-blue-800' }}"
               :class="sidebarOpen ? 'px-4 justify-start' : 'justify-center'">
                <i class="fa-solid fa-print text-2xl"></i>
                <span x-show="sidebarOpen" class="ml-3 text-base">Cetak Nilai</span>
            </a>
        </nav>
    </div>

   <!-- Logout -->
        <div class="px-4 py-3 border-t border-blue-500">
            <a href="{{ route('logout') }}" class="flex items-center space-x-2 hover:text-gray-200 transition">
                <i class="fa-solid fa-right-from-bracket text-xl"></i>
                <span x-show="sidebarOpen">Keluar</span>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="GET" class="hidden">
                @csrf
            </form>
        </div>
</div>

  <!-- MAIN CONTENT -->
  <div class="flex-1 p-8 bg-gray-100">
    <div class="bg-white rounded-lg shadow p-6">
      <!-- Header -->
      <div class="flex justify-between items-center border-b pb-3 mb-4">
        <h2 class="text-lg font-semibold text-gray-800">Data Guru</h2>
        <button @click="openTambah = true"
          class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow text-sm flex items-center gap-2">
          <i class="fa-solid fa-plus"></i> Tambah Data
        </button>
      </div>

      <!-- Export & Search -->
      <div class="flex justify-between items-center mb-4">
        <div class="flex items-center space-x-2">
        <form action="{{ route('dashboard.data_guru.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label class="bg-gray-200 text-black px-4 py-1 rounded hover:bg-gray-300 font-bold cursor-pointer">
                +
                <input type="file" name="file" accept=".csv" class="hidden" onchange="this.form.submit()">
            </label>
        </form>

        <a href="{{ route('dashboard.data_guru.export.pdf') }}">
            <button class="bg-gray-200 px-4 py-1 rounded hover:bg-gray-300">PDF</button>
        </a>

        <a href="{{ route('dashboard.data_guru.export.csv') }}">
            <button class="bg-gray-200 px-4 py-1 rounded hover:bg-gray-300">CSV</button>
        </a>

        </div>
        <input type="text" placeholder="Search..." class="border px-3 py-1 rounded focus:ring-1 focus:ring-blue-400 outline-none"/>
      </div>

      <!-- TABLE -->
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead class="bg-blue-600 text-white">
            <tr>
              <th class="px-4 py-2">No</th>
              <th class="px-4 py-2">Nama PTK</th>
              <th class="px-4 py-2">NIP</th>
              <th class="px-4 py-2">NUPTK</th>
              <th class="px-4 py-2">JK</th>
              <th class="px-4 py-2">Jenis PTK</th>
              <th class="px-4 py-2">Status</th>
              <th class="px-4 py-2 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <template x-for="(guru, index) in dataGuru" :key="guru.id_guru">
              <tr class="border-t hover:bg-gray-50" x-data="{ openDropdown:false }">
                <td class="px-4 py-2" x-text="index + 1"></td>
                <td class="px-4 py-2" x-text="guru.nama_guru"></td>
                <td class="px-4 py-2" x-text="guru.nip"></td>
                <td class="px-4 py-2" x-text="guru.nuptk"></td>
                <td class="px-4 py-2" x-text="guru.jenis_kelamin"></td>
                <td class="px-4 py-2" x-text="guru.jenis_ptk"></td>
                <td class="px-4 py-2">
                  <span class="px-2 py-1 text-xs rounded-full"
                    :class="guru.status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                    x-text="guru.status === 'aktif' ? 'Aktif' : 'Non Aktif'">
                  </span>
                </td>
                <td class="px-4 py-2 text-center">
                  <div class="flex justify-center gap-2 relative">
                    <!-- Dropdown Aksi -->
                    <div class="relative">
                      <button @click="openDropdown = !openDropdown"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm flex items-center gap-1">
                        <span>Aksi</span>
                        <i class="fa-solid fa-caret-down ml-1"></i>
                      </button>
                      <div x-show="openDropdown" @click.away="openDropdown = false" x-transition
                        class="absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded shadow-lg text-left z-20">
                        <button @click="editGuru(guru.id_guru)"
                          class="w-full px-3 py-1 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                          <i class="fa-solid fa-pen text-blue-500 text-xs"></i> Edit
                        </button>
                        <button @click="deleteGuru(guru.id_guru)"
                          class="w-full px-3 py-1 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                          <i class="fa-solid fa-trash text-red-500 text-xs"></i> Hapus
                        </button>
                        <button @click="openDropdown=false; openDownload=true"
                          class="w-full px-3 py-1 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                          <i class="fa-solid fa-download text-green-500 text-xs"></i> Unduh
                        </button>
                      </div>
                    </div>
                    <button @click="detailGuru(guru.id_guru)"
                      class="bg-orange-400 hover:bg-orange-500 text-white px-3 py-1 rounded text-sm flex items-center gap-1">
                      <i class="fa-solid fa-circle-info"></i> Detail
                    </button>
                  </div>
                </td>
              </tr>
            </template>
          </tbody>
        </table>
      </div>
    </div>

   <!-- 🟦 MODAL TAMBAH / EDIT DATA GURU -->
    <template x-if="openTambah || openEdit">
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center backdrop-blur-sm z-30" x-transition>
        <div class="bg-white rounded-2xl shadow-2xl w-2/4 p-6 relative overflow-y-auto max-h-[90vh]">
        <!-- Tombol Close -->
        <button @click="openTambah=false; openEdit=false; resetForm(); currentEditId = null"
                class="absolute top-3 right-3 text-gray-500 hover:text-red-600">
            <i class="fa-solid fa-xmark text-2xl"></i>
        </button>

         <!-- Judul -->
            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i :class="openTambah ? 'fa-solid fa-user-plus text-blue-600' : 'fa-solid fa-pen text-blue-600'"></i>
                <span x-text="openTambah ? 'Tambah Data Guru' : 'Edit Data Guru'"></span>
            </h2>

            <!-- Form -->
            <form @submit.prevent="saveGuru()" class="flex flex-col gap-4 text-sm">

                <!-- Data Utama Guru -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Nama PTK</label>
                        <input x-model="formData.nama_guru" type="text" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">NIP</label>
                        <input x-model="formData.nip" type="text" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">NUPTK</label>
                        <input x-model="formData.nuptk" type="text" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Jenis Kelamin</label>
                        <select x-model="formData.jenis_kelamin" required
                                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Jenis PTK</label>
                        <input x-model="formData.jenis_ptk" type="text" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Role</label>
                        <select x-model="formData.role" required
                                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                            <option value="guru_mapel">Guru Mapel</option>
                            <option value="walikelas_gurumapel">Wali Kelas & Guru Mapel</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Status</label>
                        <select x-model="formData.status" required
                                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                            <option value="aktif">Aktif</option>
                            <option value="non_aktif">Non Aktif</option>
                        </select>
                    </div>
                  </div>

                <!-- Data Detail Guru -->
                <h3 class="font-semibold text-gray-800 mt-4 mb-2 border-t pt-4">Data Detail Guru</h3>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Tempat Lahir</label>
                        <input x-model="formData.tempat_lahir" type="text" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Tanggal Lahir</label>
                        <input x-model="formData.tanggal_lahir" type="date" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Status Kepegawaian</label>
                        <input x-model="formData.status_kepegawaian" type="text" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Agama</label>
                        <input x-model="formData.agama" type="text" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                </div>

                <!-- Alamat -->
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Alamat</label>
                    <textarea x-model="formData.alamat" required
                              class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300" rows="2"></textarea>
                </div>

                <div class="grid grid-cols-4 gap-4">
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">RT</label>
                        <input x-model="formData.rt" type="number" required max="999"
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">RW</label>
                        <input x-model="formData.rw" type="number" required max="999"
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Dusun</label>
                        <input x-model="formData.dusun" type="text" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Kelurahan</label>
                        <input x-model="formData.kelurahan" type="text" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Kecamatan</label>
                        <input x-model="formData.kecamatan" type="text" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Kode Pos</label>
                        <input x-model="formData.kode_pos" type="number" required maxlength="5"
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">No. Telepon</label>
                        <input x-model="formData.no_telp" type="text" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">No. HP</label>
                        <input x-model="formData.no_hp" type="text" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Email</label>
                        <input x-model="formData.email" type="email" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Tugas Tambahan</label>
                        <input x-model="formData.tugas_tambahan" type="text"
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                </div>

                <!-- Kepegawaian -->
                <h3 class="font-semibold text-gray-800 mt-4 mb-2 border-t pt-4">Data Kepegawaian</h3>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">SK CPNS</label>
                        <input x-model="formData.sk_cpns" type="text" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Tanggal CPNS</label>
                        <input x-model="formData.tgl_cpns" type="date" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">SK Pengangkatan</label>
                        <input x-model="formData.sk_pengangkatan" type="text" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">TMT Pengangkatan</label>
                        <input x-model="formData.tmt_pengangkatan" type="date" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Lembaga Pengangkatan</label>
                        <input x-model="formData.lembaga_pengangkatan" type="text" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Pangkat/Golongan</label>
                        <input x-model="formData.pangkat_gol" type="text" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Sumber Gaji</label>
                        <input x-model="formData.sumber_gaji" type="text" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">TMT PNS</label>
                        <input x-model="formData.tmt_pns" type="date" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                </div>

                <!-- Keluarga -->
                <h3 class="font-semibold text-gray-800 mt-4 mb-2 border-t pt-4">Data Keluarga</h3>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Nama Ibu Kandung</label>
                        <input x-model="formData.nama_ibu_kandung" type="text" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Status Perkawinan</label>
                        <input x-model="formData.status_perkawinan" type="text" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Nama Suami/Istri</label>
                        <input x-model="formData.nama_suami_istri" type="text"
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">NIP Suami/Istri</label>
                        <input x-model="formData.nip_suami_istri" type="text"
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Pekerjaan Suami/Istri</label>
                        <input x-model="formData.pekerjaan_suami_istri" type="text"
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                </div>

                <!-- Lainnya -->
                <h3 class="font-semibold text-gray-800 mt-4 mb-2 border-t pt-4">Data Lainnya</h3>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Lisensi Kepala Sekolah</label>
                        <select x-model="formData.lisensi_kepsek" required
                                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                            <option value="Tidak">Tidak</option>
                            <option value="Ya">Ya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Diklat Kepengawasan</label>
                        <select x-model="formData.diklat_kepengawasan" required
                                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                            <option value="Tidak">Tidak</option>
                            <option value="Ya">Ya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Keahlian Braille</label>
                        <select x-model="formData.keahlian_braille" required
                                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                            <option value="Tidak">Tidak</option>
                            <option value="Ya">Ya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Keahlian Bahasa Isyarat</label>
                        <select x-model="formData.keahlian_isyarat" required
                                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                            <option value="Tidak">Tidak</option>
                            <option value="Ya">Ya</option>
                        </select>
                    </div>
                </div>

                <!-- Bank & Data Pribadi -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">NPWP</label>
                        <input x-model="formData.npwp" type="text" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Nama Wajib Pajak</label>
                        <input x-model="formData.nama_wajib_pajak" type="text" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Kewarganegaraan</label>
                        <input x-model="formData.kewarganegaraan" type="text" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Bank</label>
                        <input x-model="formData.bank" type="text" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">No. Rekening</label>
                        <input x-model="formData.norek_bank" type="text" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Rekening Atas Nama</label>
                        <input x-model="formData.nama_rek" type="text" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">NIK</label>
                        <input x-model="formData.nik" type="number" required maxlength="16"
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">No. KK</label>
                        <input x-model="formData.no_kk" type="number" required maxlength="16"
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Karpeg</label>
                        <input x-model="formData.karpeg" type="text" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Karis/Karsu</label>
                        <input x-model="formData.karis_karsu" type="text" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Lintang</label>
                        <input x-model="formData.lintang" type="number" step="any" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">Bujur</label>
                        <input x-model="formData.bujur" type="number" step="any" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 font-medium">NUKS</label>
                        <input x-model="formData.nuks" type="text" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                    </div>
                </div>

            <div class="text-right mt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow">
                    Simpan
                </button>
            </div>
        </form>
        </div>
    </div>
    </template>


    <!-- 🟦 MODAL DETAIL DATA GURU -->
    <template x-if="openDetail">
    <div
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center backdrop-blur-sm z-30"
        x-transition>
        <div
        class="bg-white rounded-2xl shadow-2xl w-2/4 p-6 relative overflow-y-auto max-h-[90vh]"
        >
        <!-- Tombol Close -->
        <button
            @click="openDetail=false"
            class="absolute top-3 right-3 text-gray-500 hover:text-red-600"
        >
            <i class="fa-solid fa-xmark text-2xl"></i>
        </button>

        <!-- Judul -->
        <h2
            class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2"
        >
            <i class="fa-solid fa-circle-info text-blue-600"></i>
            <span>Detail Data Guru</span>
        </h2>

        <!-- Detail Form -->
        <form class="flex flex-col gap-4 text-sm">
            <!-- Data Utama Guru -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Nama PTK</label>
                    <input x-model="formData.nama_guru" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">NIP</label>
                    <input x-model="formData.nip" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">NUPTK</label>
                    <input x-model="formData.nuptk" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Jenis Kelamin</label>
                    <select x-model="formData.jenis_kelamin" disabled
                            class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Jenis PTK</label>
                    <input x-model="formData.jenis_ptk" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Status</label>
                    <select x-model="formData.status" disabled
                            class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                        <option value="aktif">Aktif</option>
                        <option value="non_aktif">Non Aktif</option>
                    </select>
                </div>
            </div>

            <!-- Data Detail Guru -->
            <h3 class="font-semibold text-gray-800 mt-4 mb-2 border-t pt-4">Data Detail Guru</h3>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Tempat Lahir</label>
                    <input x-model="formData.tempat_lahir" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Tanggal Lahir</label>
                    <input x-model="formData.tanggal_lahir" type="date" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Status Kepegawaian</label>
                    <input x-model="formData.status_kepegawaian" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Agama</label>
                    <input x-model="formData.agama" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
            </div>

            <!-- Alamat -->
            <div>
                <label class="block mb-1 text-gray-700 font-medium">Alamat</label>
                <textarea x-model="formData.alamat" readonly
                          class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600" rows="2"></textarea>
            </div>

            <div class="grid grid-cols-4 gap-4">
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">RT</label>
                    <input x-model="formData.rt" type="number" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">RW</label>
                    <input x-model="formData.rw" type="number" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Dusun</label>
                    <input x-model="formData.dusun" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Kelurahan</label>
                    <input x-model="formData.kelurahan" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Kecamatan</label>
                    <input x-model="formData.kecamatan" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Kode Pos</label>
                    <input x-model="formData.kode_pos" type="number" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">No. Telepon</label>
                    <input x-model="formData.no_telp" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">No. HP</label>
                    <input x-model="formData.no_hp" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Email</label>
                    <input x-model="formData.email" type="email" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Tugas Tambahan</label>
                    <input x-model="formData.tugas_tambahan" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
            </div>

            <!-- Kepegawaian -->
            <h3 class="font-semibold text-gray-800 mt-4 mb-2 border-t pt-4">Data Kepegawaian</h3>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">SK CPNS</label>
                    <input x-model="formData.sk_cpns" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Tanggal CPNS</label>
                    <input x-model="formData.tgl_cpns" type="date" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">SK Pengangkatan</label>
                    <input x-model="formData.sk_pengangkatan" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">TMT Pengangkatan</label>
                    <input x-model="formData.tmt_pengangkatan" type="date" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Lembaga Pengangkatan</label>
                    <input x-model="formData.lembaga_pengangkatan" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Pangkat/Golongan</label>
                    <input x-model="formData.pangkat_gol" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Sumber Gaji</label>
                    <input x-model="formData.sumber_gaji" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">TMT PNS</label>
                    <input x-model="formData.tmt_pns" type="date" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
            </div>

            <!-- Keluarga -->
            <h3 class="font-semibold text-gray-800 mt-4 mb-2 border-t pt-4">Data Keluarga</h3>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Nama Ibu Kandung</label>
                    <input x-model="formData.nama_ibu_kandung" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Status Perkawinan</label>
                    <input x-model="formData.status_perkawinan" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Nama Suami/Istri</label>
                    <input x-model="formData.nama_suami_istri" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">NIP Suami/Istri</label>
                    <input x-model="formData.nip_suami_istri" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Pekerjaan Suami/Istri</label>
                    <input x-model="formData.pekerjaan_suami_istri" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
            </div>

            <!-- Lainnya -->
            <h3 class="font-semibold text-gray-800 mt-4 mb-2 border-t pt-4">Data Lainnya</h3>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Lisensi Kepala Sekolah</label>
                    <select x-model="formData.lisensi_kepsek" disabled
                            class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                        <option value="Tidak">Tidak</option>
                        <option value="Ya">Ya</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Diklat Kepengawasan</label>
                    <select x-model="formData.diklat_kepengawasan" disabled
                            class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                        <option value="Tidak">Tidak</option>
                        <option value="Ya">Ya</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Keahlian Braille</label>
                    <select x-model="formData.keahlian_braille" disabled
                            class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                        <option value="Tidak">Tidak</option>
                        <option value="Ya">Ya</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Keahlian Bahasa Isyarat</label>
                    <select x-model="formData.keahlian_isyarat" disabled
                            class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                        <option value="Tidak">Tidak</option>
                        <option value="Ya">Ya</option>
                    </select>
                </div>
            </div>

            <!-- Bank & Data Pribadi -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">NPWP</label>
                    <input x-model="formData.npwp" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Nama Wajib Pajak</label>
                    <input x-model="formData.nama_wajib_pajak" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Kewarganegaraan</label>
                    <input x-model="formData.kewarganegaraan" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Bank</label>
                    <input x-model="formData.bank" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">No. Rekening</label>
                    <input x-model="formData.norek_bank" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Rekening Atas Nama</label>
                    <input x-model="formData.nama_rek" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">NIK</label>
                    <input x-model="formData.nik" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">No. KK</label>
                    <input x-model="formData.no_kk" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Karpeg</label>
                    <input x-model="formData.karpeg" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Karis/Karsu</label>
                    <input x-model="formData.karis_karsu" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Lintang</label>
                    <input x-model="formData.lintang" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Bujur</label>
                    <input x-model="formData.bujur" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">NUKS</label>
                    <input x-model="formData.nuks" type="text" readonly
                           class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600">
                </div>
            </div>
        </form>
        </div>
    </div>
    </template>
    <style>
    .readonly-field {
        background-color: #f3f4f6;
        color: #6b7280;
        pointer-events: none; /* benar-benar tidak bisa diklik */
        cursor: default !important;
    }
</style>


    <!-- MODAL HAPUS -->
    <div x-show="openDelete" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white p-6 rounded-lg shadow-lg w-96 text-center">
        <p class="text-gray-700 text-sm mb-3">
          Tindakan ini akan menghapus seluruh data guru terkait.
          <br><span class="font-medium">Data yang sudah dihapus tidak dapat dikembalikan.</span>
        </p>
        <div class="flex justify-center gap-3 mt-4">
          <button @click="openDelete=false; deleteId = null" class="bg-gray-200 text-gray-700 px-4 py-1 rounded font-medium hover:bg-gray-300">Batal</button>
          <button @click="confirmDelete()" class="bg-red-600 text-white px-4 py-1 rounded font-medium hover:bg-red-700">Hapus</button>
        </div>
      </div>
    </div>

    <!-- MODAL UNDUH -->
    <div x-show="openDownload" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-50 flex backdrop-blur-sm items-center justify-center z-50">
      <div class="bg-white p-6 rounded-lg shadow-lg w-96 text-center">
        <div class="flex flex-col items-center">
          <i class="fa-solid fa-download text-blue-600 text-3xl mb-3"></i>
          <h3 class="text-lg font-semibold text-gray-800 mb-2">Unduh Data</h3>
          <p class="text-gray-600 text-sm mb-4">Klik tombol di bawah untuk mengunduh data guru.</p>
        </div>
        <div class="flex justify-center gap-3">
          <button @click="openDownload=false" class="bg-gray-200 text-gray-700 px-4 py-1 rounded font-medium hover:bg-gray-300">Batal</button>
          <button @click="openDownload=false" class="bg-blue-600 text-white px-4 py-1 rounded font-medium hover:bg-blue-700 flex items-center gap-1">
            <i class="fa-solid fa-download text-sm"></i> Unduh
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('alpine:init', function() {
    Alpine.data('guruManager', function() {
        return {
            openTambah: false,
            openEdit: false,
            openDetail: false,
            openDelete: false,
            deleteId: null,
            currentEditId: null,
            currentDetailId: null,
            dataGuru: {!! json_encode($guru) !!},
            formData: {
                // Data Guru
                nama_guru: '',
                nip: '',
                nuptk: '',
                jenis_kelamin: 'L',
                jenis_ptk: '',
                role: 'guru_mapel',
                status: 'aktif',

                // Data Detail Guru
                tempat_lahir: '',
                tanggal_lahir: '',
                status_kepegawaian: '',
                agama: '',
                alamat: '',
                rt: '',
                rw: '',
                dusun: '',
                kelurahan: '',
                kecamatan: '',
                kode_pos: '',
                no_telp: '',
                no_hp: '',
                email: '',
                tugas_tambahan: '',
                sk_cpns: '',
                tgl_cpns: '',
                sk_pengangkatan: '',
                tmt_pengangkatan: '',
                lembaga_pengangkatan: '',
                pangkat_gol: '',
                sumber_gaji: '',
                nama_ibu_kandung: '',
                status_perkawinan: '',
                nama_suami_istri: '',
                nip_suami_istri: '',
                pekerjaan_suami_istri: '',
                tmt_pns: '',
                lisensi_kepsek: 'Tidak',
                diklat_kepengawasan: 'Tidak',
                keahlian_braille: 'Tidak',
                keahlian_isyarat: 'Tidak',
                npwp: '',
                nama_wajib_pajak: '',
                kewarganegaraan: 'WNI',
                bank: '',
                norek_bank: '',
                nama_rek: '',
                nik: '',
                no_kk: '',
                karpeg: '',
                karis_karsu: '',
                lintang: '',
                bujur: '',
                nuks: ''
            },

            resetForm() {
                this.formData = {
                    // Data Guru
                    nama_guru: '',
                    nip: '',
                    nuptk: '',
                    jenis_kelamin: 'L',
                    jenis_ptk: '',
                    role: 'guru_mapel',
                    status: 'aktif',

                    // Data Detail Guru
                    tempat_lahir: '',
                    tanggal_lahir: '',
                    status_kepegawaian: '',
                    agama: '',
                    alamat: '',
                    rt: '',
                    rw: '',
                    dusun: '',
                    kelurahan: '',
                    kecamatan: '',
                    kode_pos: '',
                    no_telp: '',
                    no_hp: '',
                    email: '',
                    tugas_tambahan: '',
                    sk_cpns: '',
                    tgl_cpns: '',
                    sk_pengangkatan: '',
                    tmt_pengangkatan: '',
                    lembaga_pengangkatan: '',
                    pangkat_gol: '',
                    sumber_gaji: '',
                    nama_ibu_kandung: '',
                    status_perkawinan: '',
                    nama_suami_istri: '',
                    nip_suami_istri: '',
                    pekerjaan_suami_istri: '',
                    tmt_pns: '',
                    lisensi_kepsek: 'Tidak',
                    diklat_kepengawasan: 'Tidak',
                    keahlian_braille: 'Tidak',
                    keahlian_isyarat: 'Tidak',
                    npwp: '',
                    nama_wajib_pajak: '',
                    kewarganegaraan: 'WNI',
                    bank: '',
                    norek_bank: '',
                    nama_rek: '',
                    nik: '',
                    no_kk: '',
                    karpeg: '',
                    karis_karsu: '',
                    lintang: '',
                    bujur: '',
                    nuks: ''
                };
            },

            async saveGuru() {
                try {
                    const url = this.currentEditId ?
                        `/dashboard/data_guru/${this.currentEditId}` :
                        '/dashboard/data_guru';

                    const method = this.currentEditId ? 'PUT' : 'POST';

                    const response = await fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(this.formData)
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Show success notification
                        this.showNotification('success', data.message);

                        // Close modal
                        this.openTambah = false;
                        this.openEdit = false;

                        // Refresh data
                        await this.loadData();

                        // Reset form
                        this.resetForm();
                        this.currentEditId = null;
                    } else {
                        // Show error notification
                        this.showNotification('error', data.message);
                        if (data.errors) {
                            console.error('Validation errors:', data.errors);
                        }
                    }
                } catch (error) {
                    console.error('Error:', error);
                    this.showNotification('error', 'Terjadi kesalahan saat menyimpan data');
                }
            },

            async editGuru(id) {
                try {
                    const response = await fetch(`/dashboard/data_guru/${id}`);
                    const data = await response.json();

                    if (data.success) {
                        // Fill form with guru data
                        const guru = data.data;

                        // Data Guru
                        this.formData.nama_guru = guru.nama_guru || '';
                        this.formData.nip = guru.nip || '';
                        this.formData.nuptk = guru.nuptk || '';
                        this.formData.jenis_kelamin = guru.jenis_kelamin || 'L';
                        this.formData.jenis_ptk = guru.jenis_ptk || '';
                        this.formData.role = guru.role || 'guru_mapel';
                        this.formData.status = guru.status || 'aktif';

                        // Data Detail Guru
                        if (guru.detail_guru) {
                            this.formData.tempat_lahir = guru.detail_guru.tempat_lahir || '';
                            this.formData.tanggal_lahir = guru.detail_guru.tanggal_lahir || '';
                            this.formData.status_kepegawaian = guru.detail_guru.status_kepegawaian || '';
                            this.formData.agama = guru.detail_guru.agama || '';
                            this.formData.alamat = guru.detail_guru.alamat || '';
                            this.formData.rt = guru.detail_guru.rt || '';
                            this.formData.rw = guru.detail_guru.rw || '';
                            this.formData.dusun = guru.detail_guru.dusun || '';
                            this.formData.kelurahan = guru.detail_guru.kelurahan || '';
                            this.formData.kecamatan = guru.detail_guru.kecamatan || '';
                            this.formData.kode_pos = guru.detail_guru.kode_pos || '';
                            this.formData.no_telp = guru.detail_guru.no_telp || '';
                            this.formData.no_hp = guru.detail_guru.no_hp || '';
                            this.formData.email = guru.detail_guru.email || '';
                            this.formData.tugas_tambahan = guru.detail_guru.tugas_tambahan || '';
                            this.formData.sk_cpns = guru.detail_guru.sk_cpns || '';
                            this.formData.tgl_cpns = guru.detail_guru.tgl_cpns || '';
                            this.formData.sk_pengangkatan = guru.detail_guru.sk_pengangkatan || '';
                            this.formData.tmt_pengangkatan = guru.detail_guru.tmt_pengangkatan || '';
                            this.formData.lembaga_pengangkatan = guru.detail_guru.lembaga_pengangkatan || '';
                            this.formData.pangkat_gol = guru.detail_guru.pangkat_gol || '';
                            this.formData.sumber_gaji = guru.detail_guru.sumber_gaji || '';
                            this.formData.nama_ibu_kandung = guru.detail_guru.nama_ibu_kandung || '';
                            this.formData.status_perkawinan = guru.detail_guru.status_perkawinan || '';
                            this.formData.nama_suami_istri = guru.detail_guru.nama_suami_istri || '';
                            this.formData.nip_suami_istri = guru.detail_guru.nip_suami_istri || '';
                            this.formData.pekerjaan_suami_istri = guru.detail_guru.pekerjaan_suami_istri || '';
                            this.formData.tmt_pns = guru.detail_guru.tmt_pns || '';
                            this.formData.lisensi_kepsek = guru.detail_guru.lisensi_kepsek || 'Tidak';
                            this.formData.diklat_kepengawasan = guru.detail_guru.diklat_kepengawasan || 'Tidak';
                            this.formData.keahlian_braille = guru.detail_guru.keahlian_braille || 'Tidak';
                            this.formData.keahlian_isyarat = guru.detail_guru.keahlian_isyarat || 'Tidak';
                            this.formData.npwp = guru.detail_guru.npwp || '';
                            this.formData.nama_wajib_pajak = guru.detail_guru.nama_wajib_pajak || '';
                            this.formData.kewarganegaraan = guru.detail_guru.kewarganegaraan || 'WNI';
                            this.formData.bank = guru.detail_guru.bank || '';
                            this.formData.norek_bank = guru.detail_guru.norek_bank || '';
                            this.formData.nama_rek = guru.detail_guru.nama_rek || '';
                            this.formData.nik = guru.detail_guru.nik || '';
                            this.formData.no_kk = guru.detail_guru.no_kk || '';
                            this.formData.karpeg = guru.detail_guru.karpeg || '';
                            this.formData.karis_karsu = guru.detail_guru.karis_karsu || '';
                            this.formData.lintang = guru.detail_guru.lintang || '';
                            this.formData.bujur = guru.detail_guru.bujur || '';
                            this.formData.nuks = guru.detail_guru.nuks || '';
                        }

                        this.currentEditId = id;
                        this.openEdit = true;
                    } else {
                        this.showNotification('error', data.message);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    this.showNotification('error', 'Terjadi kesalahan saat mengambil data guru');
                }
            },

            async detailGuru(id) {
                try {
                    const response = await fetch(`/dashboard/data_guru/${id}`);
                    const data = await response.json();

                    if (data.success) {
                        // Fill form with guru data
                        const guru = data.data;

                        // Data Guru
                        this.formData.nama_guru = guru.nama_guru || '';
                        this.formData.nip = guru.nip || '';
                        this.formData.nuptk = guru.nuptk || '';
                        this.formData.jenis_kelamin = guru.jenis_kelamin || 'L';
                        this.formData.jenis_ptk = guru.jenis_ptk || '';
                        this.formData.role = guru.role || 'guru_mapel';
                        this.formData.status = guru.status || 'aktif';

                        // Data Detail Guru
                        if (guru.detail_guru) {
                            this.formData.tempat_lahir = guru.detail_guru.tempat_lahir || '';
                            this.formData.tanggal_lahir = guru.detail_guru.tanggal_lahir || '';
                            this.formData.status_kepegawaian = guru.detail_guru.status_kepegawaian || '';
                            this.formData.agama = guru.detail_guru.agama || '';
                            this.formData.alamat = guru.detail_guru.alamat || '';
                            this.formData.rt = guru.detail_guru.rt || '';
                            this.formData.rw = guru.detail_guru.rw || '';
                            this.formData.dusun = guru.detail_guru.dusun || '';
                            this.formData.kelurahan = guru.detail_guru.kelurahan || '';
                            this.formData.kecamatan = guru.detail_guru.kecamatan || '';
                            this.formData.kode_pos = guru.detail_guru.kode_pos || '';
                            this.formData.no_telp = guru.detail_guru.no_telp || '';
                            this.formData.no_hp = guru.detail_guru.no_hp || '';
                            this.formData.email = guru.detail_guru.email || '';
                            this.formData.tugas_tambahan = guru.detail_guru.tugas_tambahan || '';
                            this.formData.sk_cpns = guru.detail_guru.sk_cpns || '';
                            this.formData.tgl_cpns = guru.detail_guru.tgl_cpns || '';
                            this.formData.sk_pengangkatan = guru.detail_guru.sk_pengangkatan || '';
                            this.formData.tmt_pengangkatan = guru.detail_guru.tmt_pengangkatan || '';
                            this.formData.lembaga_pengangkatan = guru.detail_guru.lembaga_pengangkatan || '';
                            this.formData.pangkat_gol = guru.detail_guru.pangkat_gol || '';
                            this.formData.sumber_gaji = guru.detail_guru.sumber_gaji || '';
                            this.formData.nama_ibu_kandung = guru.detail_guru.nama_ibu_kandung || '';
                            this.formData.status_perkawinan = guru.detail_guru.status_perkawinan || '';
                            this.formData.nama_suami_istri = guru.detail_guru.nama_suami_istri || '';
                            this.formData.nip_suami_istri = guru.detail_guru.nip_suami_istri || '';
                            this.formData.pekerjaan_suami_istri = guru.detail_guru.pekerjaan_suami_istri || '';
                            this.formData.tmt_pns = guru.detail_guru.tmt_pns || '';
                            this.formData.lisensi_kepsek = guru.detail_guru.lisensi_kepsek || 'Tidak';
                            this.formData.diklat_kepengawasan = guru.detail_guru.diklat_kepengawasan || 'Tidak';
                            this.formData.keahlian_braille = guru.detail_guru.keahlian_braille || 'Tidak';
                            this.formData.keahlian_isyarat = guru.detail_guru.keahlian_isyarat || 'Tidak';
                            this.formData.npwp = guru.detail_guru.npwp || '';
                            this.formData.nama_wajib_pajak = guru.detail_guru.nama_wajib_pajak || '';
                            this.formData.kewarganegaraan = guru.detail_guru.kewarganegaraan || 'WNI';
                            this.formData.bank = guru.detail_guru.bank || '';
                            this.formData.norek_bank = guru.detail_guru.norek_bank || '';
                            this.formData.nama_rek = guru.detail_guru.nama_rek || '';
                            this.formData.nik = guru.detail_guru.nik || '';
                            this.formData.no_kk = guru.detail_guru.no_kk || '';
                            this.formData.karpeg = guru.detail_guru.karpeg || '';
                            this.formData.karis_karsu = guru.detail_guru.karis_karsu || '';
                            this.formData.lintang = guru.detail_guru.lintang || '';
                            this.formData.bujur = guru.detail_guru.bujur || '';
                            this.formData.nuks = guru.detail_guru.nuks || '';
                        }

                        this.currentDetailId = id;
                        this.openDetail = true;
                    } else {
                        this.showNotification('error', data.message);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    this.showNotification('error', 'Terjadi kesalahan saat mengambil data guru');
                }
            },

            deleteGuru(id) {
                this.deleteId = id;
                this.openDelete = true;
            },

            async confirmDelete() {
                try {
                    const response = await fetch(`/dashboard/data_guru/${this.deleteId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        this.showNotification('success', data.message);
                        this.openDelete = false;
                        this.deleteId = null;
                        await this.loadData();
                    } else {
                        this.showNotification('error', data.message);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    this.showNotification('error', 'Terjadi kesalahan saat menghapus data');
                }
            },

            async loadData() {
                try {
                    // Refresh halaman untuk mendapatkan data terbaru
                    location.reload();
                } catch (error) {
                    console.error('Error:', error);
                    this.showNotification('error', 'Terjadi kesalahan saat memuat data');
                }
            },

            showNotification(type, message) {
                // Create notification element
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all transform ${
                    type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
                }`;
                notification.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-2"></i>
                        <span>${message}</span>
                    </div>
                `;

                document.body.appendChild(notification);

                // Remove notification after 3 seconds
                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }
        }
    });
});
</script>

</body>
</html>
