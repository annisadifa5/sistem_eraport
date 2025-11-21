<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Rapor | Info Sekolah</title>

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
            font-size: 15px; /* agar mudah dibaca */
        }
    </style>
</head>

<body class="bg-gray-100">
<div 
  x-data="{
      sidebarOpen: true,
      dataSekolahOpen: false,
      inputNilaiOpen: false,
      modalOpen: false,
      toggleSidebar() {
          this.sidebarOpen = !this.sidebarOpen;
          if (!this.sidebarOpen) {
              this.dataSekolahOpen = false;
              this.inputNilaiOpen = false;
          }
      }
  }"
  class="flex min-h-screen"
>

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
        <div class="bg-white rounded-2xl shadow p-8">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Detail Data Sekolah</h2>
            </div>

            <!-- IDENTITAS SEKOLAH -->
            <section class="space-y-6">
                <!-- Identitas -->
                <div>
                    <h3 class="font-semibold text-gray-700 mb-2">IDENTITAS SEKOLAH</h3>
                    <div class="grid grid-cols-2 gap-y-2 text-gray-800 text-base">
                        <p>Nama Sekolah</p><p class="border-b border-gray-300">{{ $info->nama_sekolah ?? '-' }}</p>
                        <p>Jenjang</p><p class="border-b border-gray-300">{{ $info->jenjang ?? '-' }}</p>
                        <p>NISN</p><p class="border-b border-gray-300">{{ $info->nisn ?? '-' }}</p>
                        <p>NPSN</p><p class="border-b border-gray-300">{{ $info->npsn ?? '-' }}</p>
                    </div>
                </div>

                <!-- Alamat -->
                <div>
                    <h3 class="font-semibold text-gray-700 mb-2 mt-4">ALAMAT</h3>
                    <div class="grid grid-cols-2 gap-y-2 text-gray-800 text-base">
                        <p>Jalan</p><p class="border-b border-gray-300">{{ $info->jalan ?? '-' }}</p>
                        <p>Desa / Kelurahan</p><p class="border-b border-gray-300">{{ $info->kelurahan ?? '-' }}</p>
                        <p>Kecamatan</p><p class="border-b border-gray-300">{{ $info->kecamatan ?? '-' }}<</p>
                        <p>Kabupaten / Kota</p><p class="border-b border-gray-300">{{ $info->kota_kab ?? '-' }}</p>
                        <p>Provinsi</p><p class="border-b border-gray-300">{{ $info->provinsi ?? '-' }}</p>
                        <p>Kode Pos</p><p class="border-b border-gray-300">{{ $info->kode_pos ?? '-' }}</p>
                    </div>
                </div>

                <!-- Kontak -->
                <div>
                    <h3 class="font-semibold text-gray-700 mb-2 mt-4">KONTAK</h3>
                    <div class="grid grid-cols-2 gap-y-2 text-gray-800 text-base">
                        <p>Telepon./Fax.</p><p class="border-b border-gray-300">{{ $info->telp_fax ?? '-' }}</p>
                        <p>Email</p><p class="border-b border-gray-300">{{ $info->email ?? '-' }}</p>
                        <p>Website</p><p class="border-b border-gray-300">{{ $info->website ?? '-' }}</p>
                    </div>
                </div>

               <!-- KEPALA SEKOLAH -->
                <div>
                    <h3 class="font-semibold text-gray-700 mb-2 mt-4">KEPALA SEKOLAH</h3>
                    <div class="grid grid-cols-2 gap-y-2 text-gray-800 text-base">
                        <p>Nama Kepala Sekolah</p><p class="border-b border-gray-300">{{ $info->nama_kepsek ?? '-' }}</p>
                        <p>NIP Kepala Sekolah</p><p class="border-b border-gray-300">{{ $info->nip_kepsek ?? '-' }}</p>
                    </div>

                    <!-- Tombol Edit -->
                    <div class="flex justify-end mt-4">
                        <button 
                            @click="modalOpen = true"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm shadow flex items-center space-x-2">
                            <i class="fa-solid fa-pen"></i>
                            <span>Edit Data Kepsek</span>
                        </button>
                    </div>

                    <!-- POPUP EDIT DATA KEPSEK -->
                    <div 
                        x-show="modalOpen"
                        x-transition
                        class="fixed inset-0 flex items-center justify-center z-50 backdrop-blur-sm"
                    >

                        <!-- Box Form -->
                        <div 
                            @click.away="modalOpen = false"
                            class="bg-white rounded-2xl shadow-2xl w-full max-w-xl p-6 border border-gray-100 relative transform transition-all duration-300"
                        >
                            <!-- Header -->
                            <div class="flex justify-between items-center border-b pb-2 mb-4">
                                <h2 class="text-lg font-semibold text-gray-700">Edit Data Kepala Sekolah</h2>
                                <button @click="modalOpen = false" class="text-gray-500 hover:text-gray-700">
                                    <i class="fa-solid fa-xmark text-lg"></i>
                                </button>
                            </div>

                            <!-- Form -->
                            <form action="{{route('dashboard.info_sekolah.update')}}" method="POST" class="space-y-4">
                                @csrf
                            <!-- Baris 1 -->
                            <div class="flex items-start space-x-2">
                                <label class="w-48 text-gray-700 text-sm font-medium flex justify-between">
                                    <span>Nama Kepala Sekolah</span>
                                    <span>:</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="nama_kepsek"
                                    value="{{ $info->nama_kepsek ?? '' }}"
                                    class="flex-1 border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none text-sm ml-2"
                                >
                            </div>

                            <!-- Baris 2 -->
                            <div class="flex items-start space-x-2">
                                <label class="w-48 text-gray-700 text-sm font-medium flex justify-between">
                                    <span>NIP Kepala Sekolah</span>
                                    <span>:</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="nip_kepsek"
                                    value="{{ $info->nip_kepsek ?? '' }}"
                                    class="flex-1 border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none text-sm ml-2"
                                >
                            </div>

                            <!-- Tombol Simpan -->
                            <div class="flex justify-end pt-3">
                                <button 
                                    type="submit" 
                                    @click="modalOpen = false"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm shadow-md"
                                >
                                    Simpan
                                </button>
                            </div>
                        </form>

                        </div>
                    </div>


            </section>
        </div>
    </div>
</div>
</body>
</html>

