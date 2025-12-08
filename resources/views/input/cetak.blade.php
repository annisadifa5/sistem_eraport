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
      @if(auth()->user()->role == 'admin')
          @include('dashboard.sidebar_admin')
      @elseif(auth()->user()->role == 'guru' && auth()->user()->is_walikelas == 0)
          @include('dashboard.sidebar_guru')
      @elseif(auth()->user()->role == 'guru' && auth()->user()->is_walikelas == 1)
          @include('dashboard.sidebar_wali')
      @endif

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
