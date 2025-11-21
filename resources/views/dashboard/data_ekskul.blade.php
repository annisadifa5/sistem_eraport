<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Data Ekstrakurikuler | E-RAPOR</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        html, body { margin: 0; padding: 0; height: 100%; overflow-x: hidden; }
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-gray-100">

<div x-data="{
        sidebarOpen: true,
        dataSekolahOpen: true,
        inputNilaiOpen: false,
        /* ========== Modal Ekskul ========== */
        showTambahEkskul: false,
        showEditEkskul: false,
        showHapusEkskul: false,

        /* Modal siswa ekskul */
        showTambahSiswa: false,
        showEditSiswa: false,
        showHapus: false,
        
        toggleSidebar() {
            this.sidebarOpen = !this.sidebarOpen;
            if (!this.sidebarOpen) {
                this.dataSekolahOpen = false;
                this.inputNilaiOpen = false;
            }
        }
    }"
    x-cloak
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
        <div class="bg-white rounded-lg shadow p-6">

            <!-- Header -->
            <div class="flex justify-between items-center border-b mb-6 pb-2">
                <h1 class="text-lg font-semibold text-gray-800">Data Ekstrakurikuler</h1>
                <div class="flex items-center space-x-2"></div>
            </div>

            <!-- Filter -->
            <form action="{{ route('dashboard.data_ekskul') }}" method="GET">
                <div class="rounded-lg p-4 mb-6">

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">

                        <!-- Nama Ekskul -->
                        <select class="border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-400 text-gray-400"
                                onchange="this.style.color = this.selectedIndex === 0 ? '#9ca3af' : '#000';">
                            <option selected disabled>Nama Ekstrakurikuler</option>
                             @foreach ($ekskul as $e)
                            <option value="{{ $e->id_ekskul }}">{{ $e->nama_ekskul }}</option>
                        @endforeach
                        </select>

                        <!-- Pembina -->
                        <select class="border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-400 text-gray-400"
                                onchange="this.style.color = this.selectedIndex === 0 ? '#9ca3af' : '#000';">
                            <option selected disabled>Pembina</option>
                            @foreach ($guru as $g)
                            <option value="{{ $g->id_guru }}">{{ $g->nama_guru }}</option>
                        @endforeach
                        </select>

                        <!-- Jadwal -->
                        <select class="border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-400 text-gray-400"
                                onchange="this.style.color = this.selectedIndex === 0 ? '#9ca3af' : '#000';">
                            <option selected disabled>Jadwal</option>
                            @foreach ($ekskul as $e)
                            <option value="{{ $e->jadwal_ekskul }}">
                                {{ \Carbon\Carbon::parse($e->jadwal_ekskul)->translatedFormat('l, H:i') }}
                            </option>
                        @endforeach
                        </select>

                        <!-- Aksi -->
                        <select 
                          class="bg-blue-500 text-white font-medium rounded-md p-2 px-4 shadow hover:bg-blue-600 cursor-pointer"
                          @change="
                              if ($event.target.value === 'Tambah') showTambahEkskul = true;
                              else if ($event.target.value === 'Edit') showEditEkskul = true;
                              else if ($event.target.value === 'Hapus') showHapusEkskul = true;
                              $event.target.value = '';
                          ">
                          <option value="">Aksi</option>
                          <option value="Tambah">Tambah</option>
                          <option value="Edit">Edit</option>
                          <option value="Hapus">Hapus</option>
                      </select>
                    </div>

                    <!-- Tombol Export -->
                    <div class="flex gap-2 mt-4">
                        <button class="bg-gray-200 px-4 py-1 rounded hover:bg-gray-300">PDF</button>
                        <button class="bg-gray-200 px-4 py-1 rounded hover:bg-gray-300">CSV</button>
                    </div>
                </div>
            </form>
                                      <!-- ============================
                                        MODAL TAMBAH ESKUL (DATA UTAMA)
                                      ================================= -->

                                          <!-- Modal -->
                                          <div 
                                              x-show="showTambahEkskul"
                                              x-transition
                                              class="fixed inset-0 bg-black bg-opacity-50 z-40 flex items-center justify-center">
                                              <div class="bg-white rounded-lg w-full max-w-md p-6 relative shadow-lg">

                                                  <h2 class="text-lg font-semibold mb-5">Tambah Ekstrakurikuler</h2>

                                                  <form 
                                                      method="POST" 
                                                      action="{{ route('dashboard.data_ekskul.storeEkskul') }}"
                                                      class="space-y-4"
                                                  >
                                                      @csrf

                                                      <!-- Nama Ekskul -->
                                                      <div>
                                                          <label class="text-sm font-medium text-gray-700">Nama Ekstrakurikuler</label>
                                                          <input 
                                                              type="text" 
                                                              name="nama_ekskul"
                                                              required
                                                              class="w-full border p-2 rounded"
                                                          >
                                                      </div>

                                                      <!-- Pembina -->
                                                      <div>
                                                          <label class="text-sm font-medium text-gray-700">Pembina</label>
                                                          <select 
                                                              name="id_guru" 
                                                              required 
                                                              class="w-full border p-2 rounded"
                                                          >
                                                              <option disabled selected>Pilih Pembina</option>
                                                              @foreach($guru as $g)
                                                                  <option value="{{ $g->id_guru }}">{{ $g->nama_guru }}</option>
                                                              @endforeach
                                                          </select>
                                                      </div>

                                                      <!-- Jadwal Ekskul -->
                                                      <div>
                                                          <label class="text-sm font-medium text-gray-700">Jadwal Ekskul</label>
                                                          <input 
                                                              type="datetime-local" 
                                                              name="jadwal_ekskul"
                                                              required
                                                              class="w-full border p-2 rounded text-gray-500"
                                                              oninput="this.classList.remove('text-gray-500')"
                                                          >
                                                      </div>

                                                      <div class="flex justify-end gap-3 mt-4">
                                                          <button 
                                                              @click="showTambahEkskul = false"
                                                              type="button"
                                                              class="px-3 py-1 bg-gray-300 rounded"
                                                          >Batal</button>

                                                          <button 
                                                              type="submit"
                                                              class="px-3 py-1 bg-blue-600 text-white rounded"
                                                          >Tambah</button>
                                                      </div>

                                                      <button 
                                                          @click="showTambahEkskul = false"
                                                          type="button"
                                                          class="absolute top-2 right-3 text-gray-400 hover:text-gray-600 text-lg"
                                                      >
                                                          &times;
                                                      </button>

                                                  </form>
                                              </div>
                                          </div>

                                    


                                      <!-- ============================
                                        MODAL EDIT ESKUL (DATA UTAMA)
                                      ================================= -->

                                      @foreach ($ekskul as $e)
                                      <div 
                                          x-data="{ showEditEkskul{{ $e->id_ekskul }}: false }"
                                          x-cloak
                                      >

                                          <!-- Tombol biasanya ada di dropdown/aksi tabel -->
                                          <!-- Contoh:
                                              <button @click="showEditEkskul{{ $e->id_ekskul }} = true">Edit</button>
                                          -->

                                          <div 
                                              x-show="showEditEkskul{{ $e->id_ekskul }}"
                                              <!x-transition>
                                              class="fixed inset-0 bg-black bg-opacity-50 z-40 flex items-center justify-center"
                                          >
                                              <div class="bg-white rounded-lg w-full max-w-md p-6 relative shadow-lg">

                                                  <h2 class="text-lg font-semibold mb-5">Edit Ekstrakurikuler</h2>

                                                  <form 
                                                      method="POST" 
                                                      action="{{ route('dashboard.dta_ekskul.updateEkskul', $e->id_ekskul) }}"
                                                      class="space-y-4"
                                                  >
                                                      @csrf
                                                      @method('PUT')

                                                      <!-- Nama Ekskul -->
                                                      <div>
                                                          <label class="text-sm font-medium text-gray-700">Nama Ekstrakurikuler</label>
                                                          <input 
                                                              type="text" 
                                                              name="nama_ekskul"
                                                              value="{{ $e->nama_ekskul }}"
                                                              required
                                                              class="w-full border p-2 rounded"
                                                          >
                                                      </div>

                                                      <!-- Pembina -->
                                                      <div>
                                                          <label class="text-sm font-medium text-gray-700">Pembina</label>
                                                          <select name="id_guru" class="w-full border p-2 rounded">
                                                              @foreach($guru as $g)
                                                                  <option 
                                                                      value="{{ $g->id_guru }}"
                                                                      {{ $g->id_guru == $e->id_guru ? 'selected' : '' }}
                                                                  >
                                                                      {{ $g->nama_guru }}
                                                                  </option>
                                                              @endforeach
                                                          </select>
                                                      </div>

                                                      <!-- Jadwal Ekskul -->
                                                      <div>
                                                          <label class="text-sm font-medium text-gray-700">Jadwal Ekskul</label>
                                                          <input 
                                                              type="datetime-local"
                                                              name="jadwal_ekskul"
                                                              value="{{ \Carbon\Carbon::parse($e->jadwal_ekskul)->format('Y-m-d\TH:i') }}"
                                                              class="w-full border p-2 rounded"
                                                          >
                                                      </div>

                                                      <div class="flex justify-end gap-3 mt-4">
                                                          <button 
                                                              @click="showEditEkskul{{ $e->id_ekskul }} = false"
                                                              type="button"
                                                              class="px-3 py-1 bg-gray-300 rounded"
                                                          >Batal</button>

                                                          <button 
                                                              @click="showEditEkskul{{ $e->id_ekskul }}"
                                                              type="submit"
                                                              class="px-3 py-1 bg-blue-600 text-white rounded"
                                                          >Simpan</button>
                                                      </div>

                                                      <button 
                                                          @click="showEditEkskul{{ $e->id_ekskul }} = false"
                                                          type="button"
                                                          class="absolute top-2 right-3 text-gray-400 hover:text-gray-600 text-lg"
                                                      >
                                                          &times;
                                                      </button>

                                                  </form>
                                              </div>
                                          </div>
                                        </div>
                                      
                                      @endforeach


                                  <!-- ============================
                                        MODAL HAPUS DATA ESKUL
                                  ================================= -->

                                  @foreach ($ekskul as $e)
                                  <div 
                                      x-data="{ showHapusEkskul{{ $e->id_ekskul }}: false }"
                                      x-cloak
                                  >
                                      <!-- Tombol untuk memanggil modal hapus (biasanya ada di dropdown aksi) -->
                                      <!-- Contoh:
                                          <button @click="showHapusEkskul{{ $e->id_ekskul }} = true">
                                              Hapus
                                          </button>
                                      -->

                                      <!-- Modal -->
                                      <div 
                                          x-show="showHapusEkskul{{ $e->id_ekskul }}"
                                          x-transition
                                          class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center"
                                      >
                                          <div class="bg-white rounded-lg w-96 p-6 shadow-lg text-center relative">

                                              <p class="text-gray-700 mb-3">
                                                  Tindakan ini akan menghapus<br>
                                                  <span class="font-semibold">{{ $e->nama_ekskul }}</span>
                                                  <br>
                                                  dan seluruh data terkait.
                                              </p>

                                              <p class="text-sm text-gray-600 mb-4">
                                                  <b>Data yang sudah dihapus tidak dapat dikembalikan.</b>
                                              </p>

                                              <div class="flex justify-center gap-3">
                                                  <button 
                                                      @click="showHapusEkskul{{ $e->id_ekskul }} = false"
                                                      class="px-4 py-1 bg-gray-300 rounded hover:bg-gray-400"
                                                  >Batal</button>

                                                  <form 
                                                      method="POST" 
                                                      action="{{ route('dashboard.data_ekskul.destroyEkskul', $e->id_ekskul) }}"
                                                  >
                                                      @csrf
                                                      @method('DELETE')

                                                      <button 
                                                          type="submit"
                                                          class="px-4 py-1 bg-red-600 text-white rounded hover:bg-red-700"
                                                      >
                                                          Hapus
                                                      </button>
                                                  </form>
                                              </div>

                                              <!-- Tombol close (X) -->
                                              <button 
                                                  @click="showHapusEkskul{{ $e->id_ekskul }} = false"
                                                  class="absolute top-2 right-3 text-gray-400 hover:text-gray-600 text-lg"
                                              >
                                                  &times;
                                              </button>

                                          </div>
                                      </div>
                                  </div>
                                  @endforeach

          <!-- ===== Table Data Siswa Ekskul ===== -->
          <div class="overflow-x-auto">
              <div class="bg-white shadow-md rounded-lg overflow-visible">

                  <table class="w-full border-collapse text-sm">
                      <thead class="bg-blue-600 text-white">
                          <tr>
                              <th class="px-4 py-2">No.</th>
                              <th class="px-4 py-2">Nama Siswa</th>
                              <th class="px-4 py-2">Nama Ekskul</th>
                              <th class="px-4 py-2">Pembina</th>
                              <th class="px-4 py-2">Jadwal</th>
                              <th class="px-4 py-2 text-center">Aksi</th>
                          </tr>
                      </thead>

                      <tbody class="text-gray-800">

                          @foreach($siswaEkskul as $index => $item)
                          <tr class="hover:bg-gray-100">
                              <td class="px-4 py-2 text-center">{{ $index + 1 }}.</td>
                              <td class="px-4 py-2">{{ $item->siswa->nama_siswa }}</td>
                              <td class="px-4 py-2">{{ $item->ekskul->nama_ekskul }}</td>
                              <td class="px-4 py-2">{{ $item->ekskul->guru->nama_guru }}</td>
                              <td class="px-4 py-2">{{ $item->ekskul->jadwal_ekskul }}</td>

                              <!-- ========================= Aksi Dropdown ========================= -->
                              <td class="px-4 py-2 text-center">

                                  <div x-data="{
                                          openDropdown: false,
                                          showTambahSiswa: false,
                                          showEditSiswa: false,
                                          showHapus: false
                                      }"
                                      class="relative inline-block text-left"
                                  >

                                      <!-- Tombol Aksi -->
                                      <button 
                                          @click="openDropdown = !openDropdown"
                                          class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600 flex items-center gap-1">
                                          Aksi <i class="fa-solid fa-caret-down text-xs"></i>
                                      </button>

                                      <!-- Klik luar untuk menutup -->
                                      <div 
                                          x-show="openDropdown"
                                          @click="openDropdown = false"
                                          class="fixed inset-0 z-10"
                                      ></div>

                                      <!-- Dropdown -->
                                      <div 
                                          x-show="openDropdown"
                                          x-transition
                                          class="absolute z-30 right-0 mt-1 w-32 bg-white border border-gray-200 rounded shadow-lg"
                                      >
                                          <button 
                                              @click="showTambahSiswa = true; openDropdown = false"
                                              class="w-full text-left px-3 py-1.5 text-sm hover:bg-gray-100 flex items-center gap-2"
                                          >
                                              <i class="fa-solid fa-plus text-green-500 text-xs"></i> Tambah
                                          </button>

                                          <button 
                                              @click="showEditSiswa = true; openDropdown = false"
                                              class="w-full text-left px-3 py-1.5 text-sm hover:bg-gray-100 flex items-center gap-2"
                                          >
                                              <i class="fa-solid fa-pen text-blue-500 text-xs"></i> Edit
                                          </button>

                                          <button 
                                              @click="showHapus = true; openDropdown = false"
                                              class="w-full text-left px-3 py-1.5 text-sm hover:bg-gray-100 flex items-center gap-2"
                                          >
                                              <i class="fa-solid fa-trash text-red-500 text-xs"></i> Hapus
                                          </button>
                                      </div>

                                      <!-- =============== Modal Tambah Siswa Ekskul =============== -->
                                      <div 
                                          x-show="showTambahSiswa"
                                          x-transition
                                          x-cloak
                                          class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-40"
                                      >
                                          <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6 relative">

                                              <h2 class="text-lg font-semibold mb-4">Tambah Siswa Ekstrakurikuler</h2>

                                              <form method="POST" action="{{ route('dashboard.ekskul_siswa.storeEkskulSiswa') }}" class="space-y-4">
                                                  @csrf

                                                  <!-- Nama Siswa -->
                                                  <div>
                                                      <label class="block text-sm font-medium text-gray-700 mb-1">Nama Siswa</label>
                                                      <select name="id_siswa" required class="w-full border p-2 rounded">
                                                          <option disabled selected>Pilih Siswa</option>
                                                          @foreach($siswa as $s)
                                                          <option value="{{ $s->id_siswa }}">{{ $s->nama_siswa }}</option>
                                                          @endforeach
                                                      </select>
                                                  </div>

                                                  <!-- Nama Ekskul -->
                                                  <div>
                                                      <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ekstrakurikuler</label>
                                                      <select name="id_ekskul" required class="w-full border p-2 rounded">
                                                          <option disabled selected>Pilih Ekstrakurikuler</option>
                                                          @foreach($ekskul as $e)
                                                          <option value="{{ $e->id_ekskul }}">{{ $e->nama_ekskul }}</option>
                                                          @endforeach
                                                      </select>
                                                  </div>

                                                  <!-- Pembina -->
                                                  <div>
                                                      <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pembina</label>
                                                      <select name="id_guru" class="w-full border p-2 rounded">
                                                          <option value="">-- Biarkan kosong jika tidak ingin mengubah --</option>
                                                          @foreach($guru as $g)
                                                          <option value="{{ $g->id_guru }}">{{ $g->nama_guru }}</option>
                                                          @endforeach
                                                      </select>
                                                  </div>

                                                  <!-- Jadwal -->
                                                  <div>
                                                      <label class="block text-sm font-medium text-gray-700 mb-1">Jadwal</label>
                                                      <input type="datetime-local" name="jadwal_ekskul"
                                                          class="w-full border rounded p-2 text-gray-400"
                                                          oninput="this.classList.toggle('text-gray-800', this.value !== '');">
                                                  </div>

                                                  <div class="flex justify-end gap-2 mt-4">
                                                      <button type="button" @click="showTambahSiswa = false" class="px-3 py-1 bg-gray-300 rounded">Batal</button>
                                                      <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded">Tambah</button>
                                                  </div>

                                                  <button 
                                                      @click="showTambahSiswa = false"
                                                      type="button"
                                                      class="absolute top-2 right-3 text-gray-400 hover:text-gray-600 text-lg">
                                                      &times;
                                                  </button>

                                              </form>
                                          </div>
                                      </div>

                                      <!-- =============== Modal Edit Siswa Ekskul =============== -->
                                      <div 
                                          x-show="showEditSiswa"
                                          x-transition
                                          x-cloak
                                          class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-40"
                                      >
                                          <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6 relative">

                                              <h2 class="text-lg font-semibold mb-4">Edit Siswa Ekstrakurikuler</h2>

                                              <form method="POST" action="{{ route('dashboard.ekskul_siswa.updateEkskulSiswa', $item->id) }}" class="space-y-4">
                                                  @csrf
                                                  @method('PUT')

                                                  <!-- Nama Siswa -->
                                                  <div>
                                                      <label class="block text-sm font-medium text-gray-700 mb-1">Nama Siswa</label>
                                                      <select name="id_siswa" class="w-full border p-2 rounded">
                                                          @foreach($siswa as $s)
                                                          <option value="{{ $s->id_siswa }}" {{ $s->id_siswa == $item->id_siswa ? 'selected' : '' }}>
                                                              {{ $s->nama_siswa }}
                                                          </option>
                                                          @endforeach
                                                      </select>
                                                  </div>

                                                  <!-- Nama Ekskul -->
                                                  <div>
                                                      <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ekstrakurikuler</label>
                                                      <select name="id_ekskul" class="w-full border p-2 rounded">
                                                          @foreach($ekskul as $e)
                                                          <option value="{{ $e->id_ekskul }}" {{ $e->id_ekskul == $item->id_ekskul ? 'selected' : '' }}>
                                                              {{ $e->nama_ekskul }}
                                                          </option>
                                                          @endforeach
                                                      </select>
                                                  </div>

                                                  <!-- Pembina -->
                                                  <div>
                                                      <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pembina</label>
                                                      <select name="id_guru" class="w-full border p-2 rounded text-gray-400" @change="$event.target.classList.remove('text-gray-400')">
                                                          <option value="">-- Biarkan kosong jika tidak ingin mengubah pembina --</option>
                                                          @foreach($guru as $g)
                                                          <option value="{{ $g->id_guru }}" {{ $item->ekskul->id_guru == $g->id_guru ? 'selected' : '' }}>
                                                              {{ $g->nama_guru }}
                                                          </option>
                                                          @endforeach
                                                      </select>
                                                  </div>

                                                  <!-- Jadwal -->
                                                  <div>
                                                      <label class="block text-sm font-medium text-gray-700 mb-1">Jadwal</label>
                                                      <input 
                                                          name="jadwal_ekskul"
                                                          type="datetime-local"
                                                          class="w-full border p-2 rounded text-gray-400"
                                                          oninput="this.classList.remove('text-gray-400')"
                                                          value="{{ isset($item->ekskul->jadwal_ekskul) ? \Carbon\Carbon::parse($item->ekskul->jadwal_ekskul)->format('Y-m-d\TH:i') : '' }}">
                                                  </div>

                                                  <div class="flex justify-end gap-2 mt-4">
                                                      <button type="button" @click="showEditSiswa = false" class="px-3 py-1 bg-gray-300 rounded">Batal</button>
                                                      <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded">Simpan</button>
                                                  </div>

                                                  <button 
                                                      @click="showEditSiswa = false"
                                                      type="button"
                                                      class="absolute top-2 right-3 text-gray-400 hover:text-gray-600 text-lg">
                                                      &times;
                                                  </button>

                                              </form>
                                          </div>
                                      </div>

                                      <!-- =============== Modal Hapus Siswa Ekskul =============== -->
                                      <div 
                                          x-show="showHapus"
                                          x-transition
                                          x-cloak
                                          class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-40"
                                      >
                                          <div class="bg-white w-96 rounded-lg shadow-lg p-6 text-center">
                                              <p class="text-gray-700 mb-3">
                                                  Tindakan ini akan menghapus seluruh data yang terkait. <br>
                                                  <span class="font-medium">Data tidak dapat dikembalikan.</span>
                                              </p>

                                              <div class="flex justify-center gap-3 mt-4">
                                                  <button @click="showHapus = false" class="px-3 py-1 bg-gray-300 rounded">Batal</button>

                                                  <form method="POST" action="{{ route('dashboard.ekskul_siswa.destroyEkskulSiswa', $item->id) }}">
                                                      @csrf
                                                      @method('DELETE')
                                                      <button class="px-3 py-1 bg-red-600 text-white rounded">Hapus</button>
                                                  </form>
                                              </div>
                                          </div>
                                      </div>

                                  </div>
                              </td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
          </div>
    </div> <!-- end container utama -->
</div> <!-- end content wrapper -->

<!-- AlpineJS -->
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</body>
</html>
