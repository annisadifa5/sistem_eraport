<!-- resources/views/dashboard/data_kelas.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Data Kelas</title>

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
      dataSekolahOpen: true,
      inputNilaiOpen: false,
      modalOpen: false,
      openEditModal: false,
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
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center border-b mb-6">
                <div class="flex justify-between items-center pb-3 pt-2 mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Detail Data Kelas</h2>
            </div>
                <!-- Tombol Tambah Data + Popup Modal -->
                <div x-data="{ openModal: false }" class="text-right mb-4">
                    <button 
                        @click="openModal = true"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow text-sm flex items-center gap-2 mx-2">
                        <i class="fa-solid fa-plus"></i>
                        Tambah Data
                    </button>

                    <!-- Modal Overlay -->
                    <div 
                        x-show="openModal" 
                        x-transition.opacity
                        class="fixed inset-0 bg-black bg-opacity-30 backdrop-blur-sm flex items-center justify-center z-50">
                        <!-- Modal Box -->
                        <div 
                            x-show="openModal" 
                            x-transition
                            @click.away="openModal = false"
                            class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6 relative">
                        
                            <!-- Tombol Close -->
                            <button 
                                @click="openModal = false"
                                class="absolute top-3 right-3 text-gray-400 hover:text-red-500"
                            >
                                <i class="fa-solid fa-xmark text-lg"></i>
                            </button>

                            <!-- Header -->
                            <div class="flex items-center gap-2 mb-4 border-b pb-2">
                                <div class="bg-blue-500 text-white p-2 rounded-lg">
                                    <i class="fa-solid fa-chalkboard text-lg"></i>
                                </div>
                                <h2 class="text-lg font-semibold text-gray-800">Tambah Data Kelas</h2>
                            </div>

                            <!-- Form -->
                            <form action="{{ route('dashboard.data_kelas.store') }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-sm text-left font-medium text-gray-700">Nama Kelas</label>
                                    <input type="text" name="nama_kelas" required
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                </div>

                                <div>
                                    <label class="block text-sm text-left font-medium text-gray-700">Tingkat</label>
                                    <select name="tingkat" required
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-400 text-gray-700">
                                        <option value="">Pilih Tingkat</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm text-left font-medium text-gray-700">Jurusan</label>
                                    <select name="jurusan" required
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-400 text-gray-700">
                                        <option value="">Pilih Jurusan</option>
                                        @if(isset($jurusan) && count($jurusan))
                                            @foreach($jurusan as $j)
                                                <option value="{{ $j->nama_jurusan }}">{{ $j->nama_jurusan }}</option>
                                            @endforeach
                                        @else
                                            <!-- fallback static options jika tidak ada data jurusan -->
                                            <option>Akuntansi dan Keuangan Lembaga</option>
                                            <option>Manajemen Perkantoran dan Layanan Bisnis</option>
                                            <option>Bisnis Daring dan Pemasaran</option>
                                            <option>Kuliner</option>
                                            <option>Tata Busana</option>
                                            <option>Tata Kecantikan dan Spa</option>
                                        @endif
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm text-left font-medium text-gray-700">Wali Kelas</label>
                                    <select name="wali_kelas"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-400 text-gray-700">
                                        <option value="">Pilih Wali Kelas</option>
                                        @if(isset($guru) && count($guru))
                                            @foreach($guru as $g)
                                                <option value="{{ $g->nama }}">{{ $g->nama }}</option>
                                            @endforeach
                                        @else
                                            <option>Nora</option>
                                            <option>Party</option>
                                            <option>Fina</option>
                                            <option>Rudi</option>
                                            <option>Tina</option>
                                        @endif
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm text-left font-medium text-gray-700">Jumlah Siswa</label>
                                    <input type="number" name="jumlah_siswa"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                </div>

                                <!-- Tombol Tambah -->
                                <div class="text-right pt-3">
                                    <button type="submit"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow">
                                        Tambah
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Export & Search -->
            <div class="flex justify-between items-center mb-4">
                <div class="space-x-2">
                    <a href="{{ route('dashboard.data_kelas.export.pdf') }}" 
                    class="bg-gray-200 px-4 py-1 rounded hover:bg-gray-300 inline-block">PDF</a>
                    <a href="{{ route('dashboard.data_kelas.export.csv') }}" 
                    class="bg-gray-200 px-4 py-1 rounded hover:bg-gray-300 inline-block">CSV</a>
                </div>

                <input type="text" placeholder="Search..." class="border px-3 py-1 rounded focus:ring-1 focus:ring-blue-400 outline-none">
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="py-2 px-4">No.</th>
                            <th class="py-2 px-4">Nama Kelas</th>
                            <th class="py-2 px-4">Tingkat</th>
                            <th class="py-2 px-4">Jurusan</th>
                            <th class="py-2 px-4">Wali Kelas</th>
                            <th class="py-2 px-4">Jml Siswa</th>
                            <th class="py-2 px-4 text-center">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kelas as $i => $k)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-4">{{ $i + 1 }}</td>
                            <td class="py-2 px-4">{{ $k->nama_kelas }}</td>
                            <td class="py-2 px-4">{{ $k->tingkat }}</td>
                            <td class="py-2 px-4">{{ $k->jurusan }}</td>
                            <td class="py-2 px-4">{{ $k->wali_kelas }}</td>
                            <td class="py-2 px-4">{{ \App\Models\Siswa::where('id_kelas', $k->id_kelas)->count() }}</td>
                            <td class="py-2 px-4 text-center space-x-2">
                            <!-- Dropdown Aksi -->
                            <div class="relative inline-block text-left" 
                                x-data="{ openDropdown:false, openDelete:false, openDownload:false }">

                                <button 
                                    @click="openDropdown = !openDropdown"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm flex items-center justify-between relative z-20">
                                    <span>Aksi</span>
                                    <i class="fa-solid fa-caret-down ml-1"></i>
                                </button>

                                <!-- Overlay transparan agar bisa klik di luar -->
                                <div 
                                    x-show="openDropdown"
                                    @click="openDropdown=false"
                                    class="fixed inset-0 z-10">
                                </div>

                                <!-- Dropdown menu -->
                                <div 
                                    x-show="openDropdown" 
                                    x-transition
                                    class="absolute z-30 right-0 mt-1 w-28 bg-white border border-gray-200 rounded shadow-lg">
                                    
                                    <button 
                                        @click="openDropdown = false; setTimeout(() => $dispatch('open-edit', { id: {{ $k->id_kelas }} }), 100)"
                                        class="w-full text-left px-3 py-1 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                        <i class="fa-solid fa-pen text-blue-500 text-xs"></i> Edit
                                    </button>

                                    <!-- Tombol Hapus -->
                                    <button 
                                        @click="openDelete = true; openDropdown = false"
                                        class="w-full text-left px-3 py-1 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                        <i class="fa-solid fa-trash text-red-500 text-xs"></i> Hapus
                                    </button>

                                    <!-- Tombol Unduh -->
                                    <button 
                                        @click="openDownload = true; openDropdown = false"
                                        class="w-full text-left px-3 py-1 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                        <i class="fa-solid fa-download text-green-500 text-xs"></i> Unduh
                                    </button>
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
                                <form action="{{ route ('dashboard.data_kelas.destroy', $k->id_kelas) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 text-white px-4 py-1 rounded font-medium hover:bg-red-700">
                                        Hapus
                                    </button>
                                </form>
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
                            <a href="{{ route('dashboard.data_kelas.export.kelas', $k->id_kelas) }}" 
                                class="bg-blue-600 text-white px-4 py-1 rounded font-medium hover:bg-blue-700 flex items-center gap-1">
                                <i class="fa-solid fa-download text-sm"></i> Unduh
                            </a>

                        </div>
                    </div>
                </div>
            </div>
                            <!-- Tombol Anggota -->
                            <div x-data="{ modalOpen:false }" class="inline-block">
                                <button @click="modalOpen = true"
                                    class="bg-orange-400 text-white px-3 py-1 rounded text-sm hover:bg-orange-500">
                                    Anggota
                                </button>

                                <!-- Modal Anggota -->
                                <div x-show="modalOpen" x-transition
                                    class="fixed inset-0 flex items-center justify-center backdrop-blur-sm z-50"
                                    @click.self="modalOpen=false">

                                    <div class="bg-white w-3/4 md:w-1/2 rounded-2xl shadow-xl p-6 relative max-h-[80vh] overflow-y-auto">
                                        <!-- Header Modal -->
                                        <div class="flex justify-between items-center mb-4 border-b pb-2">
                                            <h2 class="text-lg font-semibold flex items-center gap-2">
                                                <i class="fa-solid fa-users text-blue-600"></i>
                                                Anggota Kelas - {{ $k->nama_kelas }}
                                            </h2>
                                            <form action="{{ route('dashboard.data_kelas.anggota.hapus', $k->id_kelas) }}" 
                                                method="POST" 
                                                onsubmit="return confirm('Yakin ingin menghapus semua anggota di kelas ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
                                                    <i class="fa-solid fa-trash"></i> Hapus Semua
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Tabel Anggota -->
                                        <div class="overflow-x-auto border rounded-lg">
                                            <table class="w-full text-sm text-left border-collapse">
                                                <thead class="bg-blue-600 text-white">
                                                    <tr>
                                                        <th class="py-2 px-3 w-12">No.</th>
                                                        <th class="py-2 px-3">Nama</th>
                                                        <th class="py-2 px-3">NISN</th>
                                                        <th class="py-2 px-3">Kelas</th>
                                                        <th class="py-2 px-3 text-center w-32">Opsi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @php
                                                    $anggota_list = \App\Models\Siswa::where('id_kelas', $k->id_kelas)->get();
                                                @endphp

                                                @forelse ($anggota_list as $index => $angg)
                                                    <tr class="border-b hover:bg-gray-50">
                                                        <td class="py-2 px-3">{{ $index + 1 }}</td>
                                                        <td class="py-2 px-3">{{ $angg->nama_siswa }}</td>
                                                        <td class="py-2 px-3">{{ $angg->nisn }}</td>
                                                        <td class="py-2 px-3">{{ $k->nama_kelas }}</td>
                                                        <td class="py-2 px-3 text-center">
                                                            <form action="{{ route('dashboard.data_kelas.anggota.hapus', $angg->id_siswa) }}" 
                                                                method="POST" 
                                                                class="inline"
                                                                onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="bg-red-500 text-white text-xs px-3 py-1 rounded hover:bg-red-600">
                                                                    <i class="fa-solid fa-trash"></i> Hapus
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="py-4 px-3 text-center text-gray-500">
                                                            Belum ada anggota di kelas ini.
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>

                                            </table>
                                        </div>

                                        <!-- Tombol Tutup -->
                                        <div class="flex justify-center mt-5">
                                            <button @click="modalOpen=false"
                                                class="bg-gray-300 text-gray-700 px-6 py-1 rounded hover:bg-gray-400">
                                                Tutup
                                            </button>
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

            <!-- Modal Edit (global handlers: we will create per-row edit listeners below) -->
            <!-- NOTE: to keep UI identical, edit modals are generated per-row below (listened via events) -->

            {{-- Per-row Edit Modals: generate them after table so DOM order sama --}}
            @foreach ($kelas as $k_edit)
            <div 
                x-data
                x-on:open-edit.window="
                    if ($event.detail.id === {{ $k_edit->id_kelas }}) {
                        document.querySelector('.edit-modal-{{ $k_edit->id_kelas }}').classList.remove('hidden');
                        document.querySelector('.edit-modal-{{ $k_edit->id_kelas }}').classList.add('flex');
                    }">
                 <!-- Modal container -->
                <div 
                    class="edit-modal-{{ $k_edit->id_kelas }} hidden fixed inset-0 bg-black bg-opacity-30 backdrop-blur-sm items-center justify-center z-50">
                    <div 
                        @click.away="
                            document.querySelector('.edit-modal-{{ $k_edit->id_kelas }}').classList.add('hidden');
                            document.querySelector('.edit-modal-{{ $k_edit->id_kelas }}').classList.remove('flex');
                        "
                        class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6 relative">
                        
                        <!-- Tombol Close -->
                        <button 
                            onclick="document.querySelector('.edit-modal-{{ $k_edit->id_kelas }}').classList.add('hidden'); document.querySelector('.edit-modal-{{ $k_edit->id_kelas }}').classList.remove('flex')"
                            class="absolute top-3 right-3 text-gray-400 hover:text-red-500">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>

                        <div class="flex items-center gap-2 mb-4 border-b pb-2">
                            <div class="bg-blue-500 text-white p-2 rounded-lg">
                                <i class="fa-solid fa-pen-to-square text-lg"></i>
                            </div>
                            <h2 class="text-lg font-semibold text-gray-800">Edit Data Kelas</h2>
                        </div>

                        <form action="{{ route('dashboard.data_kelas.update', $k_edit->id_kelas) }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <div>
                                <label class="block text-sm text-left font-medium text-gray-700">Nama Kelas</label>
                                <input type="text" name="nama_kelas" value="{{ $k_edit->nama_kelas }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-sm text-left font-medium text-gray-700">Tingkat</label>
                                <select name="tingkat" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                    <option value="10" @if($k_edit->tingkat == '10') selected @endif>10</option>
                                    <option value="11" @if($k_edit->tingkat == '11') selected @endif>11</option>
                                    <option value="12" @if($k_edit->tingkat == '12') selected @endif>12</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm text-left font-medium text-gray-700">Jurusan</label>
                                <select type="text" name="jurusan" value="{{ $k_edit->jurusan }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                    <option value="Akuntansi dan Keuangan Lembaga" @if($k_edit->jurusan == 'Akuntansi dan Keuangan Lembaga') selected @endif>Akuntansi dan Keuangan Lembaga</option>
                                    <option value="Manajemen Perkantoran dan Layanan Bisnis" @if($k_edit->jurusan == 'Manajemen Perkantoran dan Layanan Bisnis') selected @endif>Manajemen Perkantoran dan Layanan Bisnis</option>
                                    <option value="Bisnis Daring dan Pemasaran" @if($k_edit->jurusan == 'Bisnis Daring dan Pemasaran') selected @endif>Bisnis Daring dan Pemasaran</option>
                                    <option value="Kuliner" @if($k_edit->jurusan == 'Kuliner') selected @endif>Kuliner</option>
                                    <option value="Tata Busana" @if($k_edit->jurusan == 'Tata Busana') selected @endif>Tata Busana</option>
                                    <option value="Tata Kecantikan dan Spa" @if($k_edit->jurusan == 'Tata Kecantikan dan Spa') selected @endif>Tata Kecantikan dan Spa</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm text-left font-medium text-gray-700">Wali Kelas</label>
                                <input type="text" name="wali_kelas" value="{{ $k_edit->wali_kelas }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-sm text-left font-medium text-gray-700">Jumlah Siswa</label>
                                <input type="number" name="jumlah_siswa" value="{{ $k_edit->jumlah_siswa }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            </div>
                            <div class="text-right pt-3">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-lg shadow">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
</body>
</html>
