<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Nilai</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style> body { font-family: 'Poppins', sans-serif; font-size: 15px; } </style>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-gray-100">
<div 
  x-data="{
        sidebarOpen: true,
        dataSekolahOpen: true,
        inputNilaiOpen: false,
        openTambah: false,
        openEdit: false,
        openDetail: false,
        openDelete: false,
        openDownload: false
  }"
  class="flex min-h-screen">

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

<!-- Main Content -->
<div class="flex-1 p-8">
    <div class="bg-white rounded-lg shadow p-6">

        <!-- Header Judul & Tombol Cetak -->
        <div class="flex justify-between items-center border-b mb-6 pb-3">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <i class="text-blue-600"></i> Cetak Nilai
            </h2>
            <button 
                id="btn-cetak"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow text-sm flex items-center gap-2">
                <i class="fa-solid fa-file-pdf"></i>
                Cetak PDF
            </button>
        </div>

        <!-- Filter Kelas dan Siswa -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                <select id="kelas" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">Pilih Kelas</option>
                    <option value="1">X IPA 1</option>
                    <option value="2">X IPA 2</option>
                    <option value="3">XI IPS 1</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Siswa</label>
                <select id="siswa" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">Pilih Siswa</option>
                    <option value="1">Ahmad Setiawan</option>
                    <option value="2">Budi Santoso</option>
                    <option value="3">Citra Lestari</option>
                </select>
            </div>
        </div>

        <!-- Export & Search -->
        <!-- <div class="flex justify-between items-center mb-4">
            <div class="space-x-2">
                <button class="bg-gray-200 px-4 py-1 rounded hover:bg-gray-300">PDF</button>
                <button class="bg-gray-200 px-4 py-1 rounded hover:bg-gray-300">CSV</button>
            </div>
            <input 
                type="text" 
                placeholder="Cari nilai..." 
                class="border px-3 py-1 rounded focus:ring-1 focus:ring-blue-400 outline-none"
            >
        </div> -->

        <!-- Tabel Nilai -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="py-2 px-4">No</th>
                        <th class="py-2 px-4">Mata Pelajaran</th>
                        <th class="py-2 px-4">KKM</th>
                        <th class="py-2 px-4">Tugas</th>
                        <th class="py-2 px-4">UH</th>
                        <th class="py-2 px-4">STS</th>
                        <th class="py-2 px-4">SAS</th>
                        <th class="py-2 px-4">SAT</th>
                        <th class="py-2 px-4">Ekskul</th>
                        <th class="py-2 px-4">Rata-rata</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2 px-4 text-center">1</td>
                        <td class="py-2 px-4">Matematika</td>
                        <td class="py-2 px-4 text-center">75</td>
                        <td class="py-2 px-4 text-center">85</td>
                        <td class="py-2 px-4 text-center">80</td>
                        <td class="py-2 px-4 text-center">88</td>
                        <td class="py-2 px-4 text-center">90</td>
                        <td class="py-2 px-4 text-center">85</td>
                        <td class="py-2 px-4 text-center">Basket</td>
                        <td class="py-2 px-4 text-center">85.6</td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2 px-4 text-center">2</td>
                        <td class="py-2 px-4">Bahasa Indonesia</td>
                        <td class="py-2 px-4 text-center">70</td>
                        <td class="py-2 px-4 text-center">80</td>
                        <td class="py-2 px-4 text-center">82</td>
                        <td class="py-2 px-4 text-center">78</td>
                        <td class="py-2 px-4 text-center">85</td>
                        <td class="py-2 px-4 text-center">88</td>
                        <td class="py-2 px-4 text-center">Pramuka</td>
                        <td class="py-2 px-4 text-center">82.6</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Deskripsi Penilaian -->
        <div class="mt-6 border-t pt-5">
            <label class="block mb-2 font-semibold text-gray-700">Deskripsi Penilaian Siswa</label>
            <textarea 
                id="deskripsi" 
                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-400 outline-none" 
                rows="4" 
                placeholder="Masukkan deskripsi penilaian siswa..."></textarea>

            <div class="text-right mt-3">
                <button 
                    id="btn-simpan" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow">
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>


    <script>
        // Demo interaksi frontend (tanpa backend)
        document.getElementById('btn-simpan').addEventListener('click', () => {
            alert('Deskripsi disimpan (dummy).');
        });
        document.getElementById('btn-cetak').addEventListener('click', () => {
            alert('Cetak PDF (demo frontend).');
        });
    </script>
</body>
</html>
