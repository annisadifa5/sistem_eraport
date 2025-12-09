<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Rapor | Cetak Rapor</title>

    <!-- Tailwind + Alpine -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Font Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
        }
    </style>
</head>

<body class="bg-gray-100">

<div 
  x-data="{
      sidebarOpen: true,
      dataSekolahOpen: false,
      inputNilaiOpen: false,
      cetakNilaiOpen: true,   /* <-- Biar submenu Cetak langsung terbuka */
      modalOpen: false,

      toggleSidebar() {
          this.sidebarOpen = !this.sidebarOpen;
          if (!this.sidebarOpen) {
              this.dataSekolahOpen = false;
              this.inputNilaiOpen = false;
              this.cetakNilaiOpen = false;
          }
      }
  }"
  class="flex min-h-screen"
>

    <!-- Sidebar -->
    @include('dashboard.sidebar_admin')

    <!-- MAIN CONTENT -->
    <div class="flex-1 p-8">
        <div class="bg-white rounded-2xl shadow p-8">

            <!-- Header -->
            <div class="flex justify-between items-center border-b pb-3 mb-6">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-file-pdf text-blue-600"></i>
                    Cetak E-Rapor
                </h2>
            </div>

            <!-- FORM FILTER CETAK -->
            <form action="{{ route('cetak.rapor.pdf') }}" method="GET" class="space-y-6">

                <!-- Baris 1 -->
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Kelas</label>
                        <select name="kelas" class="w-full border rounded-lg px-3 py-2 mt-1 text-gray-700 focus:ring-2 focus:ring-blue-400">
                            <option value="">Pilih Kelas</option>
                            @foreach($kelas ?? [] as $k)
                                <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700">Semester</label>
                        <select name="semester" class="w-full border rounded-lg px-3 py-2 mt-1 text-gray-700 focus:ring-2 focus:ring-blue-400">
                            <option value="1">Ganjil</option>
                            <option value="2">Genap</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700">Tahun Ajaran</label>
                        <select name="tahun" class="w-full border rounded-lg px-3 py-2 mt-1 text-gray-700 focus:ring-2 focus:ring-blue-400">
                            @foreach($tahun ?? [] as $t)
                                <option value="{{ $t }}">{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Baris 2 -->
                <div>
                    <label class="text-sm font-medium text-gray-700">Nama Siswa</label>
                    <select name="siswa" class="w-full border rounded-lg px-3 py-2 mt-1 text-gray-700 focus:ring-2 focus:ring-blue-400">
                        <option value="">Pilih Siswa</option>
                        @foreach($siswa ?? [] as $s)
                            <option value="{{ $s->id_siswa }}">{{ $s->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tombol Cetak -->
                <div class="flex justify-end pt-4">
                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow text-sm flex items-center gap-2"
                    >
                        <i class="fa-solid fa-print"></i>
                        Cetak PDF
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
</body>
</html>
