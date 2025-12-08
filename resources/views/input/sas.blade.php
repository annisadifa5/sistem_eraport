<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: true, dataSekolahOpen: true, inputNilaiOpen: false, openModal: false }" x-cloak>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Nilai Sumatif Akhir Semester</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="flex bg-gray-100 min-h-screen">

<!-- Sidebar -->
      @if(auth()->user()->role == 'admin')
          @include('dashboard.sidebar_admin')
      @elseif(auth()->user()->role == 'guru' && auth()->user()->is_walikelas == 0)
          @include('dashboard.sidebar_guru')
      @elseif(auth()->user()->role == 'guru' && auth()->user()->is_walikelas == 1)
          @include('dashboard.sidebar_wali')
      @endif

   <!-- Main Content -->
    <div class="flex-1 p-8 overflow-y-auto">
        <div class="bg-white rounded-lg shadow p-6">
            <!-- Header -->
            <div class="flex items-center justify-between border-b pb-3 mb-6">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i class="text-blue-600"></i> Input Nilai Sumatif Akhir Semester
                </h2>
            </div>

            <!-- Filter Dropdown -->
            <div class="grid grid-cols-5 gap-4 mb-6 text-sm">
                <select class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 text-gray-700">
                    <option value="">Kelas</option>
                    <option>10 AKL</option>
                    <option>11 BDP</option>
                    <option>12 RPL</option>
                </select>
                <select class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 text-gray-700">
                    <option value="">Semester</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    <option>6</option>
                </select>
                <select class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 text-gray-700">
                    <option value="">Tahun Ajaran</option>
                    <option>2024/2025</option>
                    <option>2025/2026</option>
                </select>
                <select class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 text-gray-700">
                    <option value="">Mapel</option>
                    <option>Pendidikan Agama Islam</option>
                    <option>Matematika</option>
                    <option>Bahasa Indonesia</option>
                </select>
                <!-- <select class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 text-gray-700">
                    <option value="">Kategori</option>
                    <option>Tugas Teori</option>
                    <option>Tugas Praktek</option>
                </select> -->
                <div class="relative">
                    <input type="date" class="border rounded-lg px-3 py-2 w-full focus:ring-2 focus:ring-blue-400 text-gray-700">
                    <i class="right-3 top-2.5 text-gray-500"></i>
                </div>
            </div>

            <!-- Export & Search -->
            <div class="flex justify-between items-center mb-4">
                <div class="space-x-2">
                    <button class="bg-gray-200 px-4 py-1 rounded hover:bg-gray-300">PDF</button>
                    <button class="bg-gray-200 px-4 py-1 rounded hover:bg-gray-300">CSV</button>
                </div>
                <input type="text" placeholder="Search..." class="border px-3 py-1 rounded focus:ring-1 focus:ring-blue-400 outline-none">
            </div>

            <!-- Table -->
            <div x-data="nilaiTable()" class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-blue-600 text-white text-sm">
                        <tr>
                            <th class="py-2 px-4">No.</th>
                            <th class="py-2 px-4">Nama Siswa</th>
                            <th class="py-2 px-4">NIS</th>
                            <th class="py-2 px-4">Nilai</th>
                            <th class="py-2 px-4">KKM</th>
                            <th class="py-2 px-4">Keterangan</th>
                            <!-- <th class="py-2 px-4 text-center">Aksi</th> -->
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        <template x-for="(row, index) in rows" :key="index">
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-2 px-4 text-center" x-text="index + 1"></td>
                                <td class="py-2 px-4" x-text="row.nama"></td>
                                <td class="py-2 px-4" x-text="row.nis"></td>
                                <td class="py-2 px-4">
                                    <input type="number" min="0" max="100"
                                        class="border rounded px-2 py-1 w-20 text-center focus:ring-1 focus:ring-blue-400"
                                        x-model.number="row.nilai"
                                        @input="updateKeterangan(row)">
                                </td>
                                <td class="py-2 px-4 text-center" x-text="row.kkm"></td>
                                <td class="py-2 px-4" 
                                    :class="row.keterangan === 'Tuntas' ? 'text-green-600 font-medium' : 'text-red-600 font-medium'" 
                                    x-text="row.keterangan"></td>
                                <!-- <td class="py-2 px-4 text-center">
                                    <button @click="hapusRow(index)" class="text-red-600 hover:text-red-800">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td> -->
                            </tr>
                        </template>
                    </tbody>
                </table>

                <!-- Tombol Simpan -->
                <div class="text-right mt-4">
                    <button @click="simpanData()"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow text-sm">
                        <i class="fa-solid fa-save mr-1"></i> Simpan Semua Nilai
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Alpine.js Script -->
<script>
function nilaiTable() {
    return {
        rows: [
            { nama: 'Aghist Aprilia Eka Putri', nis: '12345', nilai: 85, kkm: 75, keterangan: 'Tuntas' },
            { nama: 'Aghist Aprilia Eka Putri', nis: '12345', nilai: 70, kkm: 75, keterangan: 'Belum Tuntas' },
        ],
        updateKeterangan(row) {
            row.keterangan = row.nilai >= row.kkm ? 'Tuntas' : 'Belum Tuntas';
        },
        hapusRow(index) {
            this.rows.splice(index, 1);
        },
        simpanData() {
            alert('Semua nilai telah disimpan!');
            console.log(this.rows);
        }
    }
}
</script>



</body>
</html>
