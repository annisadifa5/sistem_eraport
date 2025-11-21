<!-- resources/views/dashboard/data_mapel.blade.php -->
<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: true, dataSekolahOpen: true, inputNilaiOpen: false, openModal: false }" x-cloak>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mapel</title>
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
    <div class="flex-1 p-8">
        <div class="bg-white rounded-lg shadow p-6">

            <!-- Header Judul & Tombol Tambah -->
            <div class="flex justify-between items-center border-b mb-6">
                <div class="flex justify-between items-center pb-3 pt-2 mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Detail Data Mata Pelajaran</h2>
                </div>

                <!-- Tombol Tambah Data -->
                <div x-data="{ openModal: false }" class="text-right mb-4">
                    <button 
                        @click="openModal = true"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow text-sm flex items-center gap-2 mx-2">
                        <i class="fa-solid fa-plus"></i>
                        Tambah Data
                    </button>

                    <!-- 🟦 Modal Tambah Data -->
                    <div 
                        x-show="openModal" 
                        x-transition.opacity
                        class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex items-center justify-center z-50">
                        <div 
                            x-show="openModal" 
                            x-transition
                            @click.away="openModal = false"
                            class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6 relative">
                        
                            <!-- Tombol Close -->
                            <button 
                                @click="openModal = false"
                                class="absolute top-3 right-3 text-gray-400 hover:text-red-500">
                                <i class="fa-solid fa-xmark text-lg"></i>
                            </button>

                            <!-- Header Modal -->
                            <div class="flex items-center gap-2 mb-4 border-b pb-2">
                                <div class="bg-blue-500 text-white p-2 rounded-lg">
                                    <i class="fa-solid fa-book-open text-lg"></i>
                                </div>
                                <h2 class="text-lg font-semibold text-gray-800">Tambah Data Mata Pelajaran</h2>
                            </div>

                            <!-- Form -->
                            <form action="{{ route('dashboard.data_mapel.store') }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-sm text-left font-medium text-gray-700">Nama Mata Pelajaran</label>
                                    <input type="text" name="nama_mapel"
                                        placeholder="Masukkan nama mata pelajaran"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 
                                            focus:outline-none focus:ring-2 focus:ring-blue-400">
                                </div>

                                <div>
                                    <label class="block text-sm text-left font-medium text-gray-700">Nama Singkat</label>
                                    <input type="text" name="nama_singkat"
                                        placeholder="Masukkan nama singkat"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 
                                            focus:outline-none focus:ring-2 focus:ring-blue-400">
                                </div>

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
                    <a href="{{ route('dashboard.data_mapel.export.pdf') }}" 
                    class="bg-gray-200 px-4 py-1 rounded hover:bg-gray-300">PDF</a>
                    <a href="{{ route('dashboard.data_mapel.export.csv') }}" 
                    class="bg-gray-200 px-4 py-1 rounded hover:bg-gray-300">CSV</a>
                </div>

                <input type="text" placeholder="Search..." 
                    class="border px-3 py-1 rounded focus:ring-1 focus:ring-blue-400 outline-none">
            </div>

            <!-- 🧾 Tabel Data -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="py-2 px-4">No.</th>
                            <th class="py-2 px-4">Nama Mata Pelajaran</th>
                            <th class="py-2 px-4">Nama Singkat</th>
                            <th class="py-2 px-4 text-center">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Tabel Data -->
                         @forelse ($mapel as $index => $m)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-4 text-center">{{ $index + 1 }}</td>
                            <td class="py-2 px-4">{{ $m->nama_mapel }}</td>
                            <td class="py-2 px-4">{{ $m->nama_singkat }}</td>
                            <td class="py-2 px-4 text-center">
                                <div class="relative inline-block text-left" 
                                    x-data="{ openDropdown:false, openDelete:false, openEdit:false }">

                                    <!-- Tombol Dropdown -->
                                    <button 
                                        @click="openDropdown = !openDropdown"
                                        class="bg-blue-500 text-white px-4 py-1 rounded text-sm hover:bg-blue-600 flex items-center justify-between w-20 relative z-20">
                                        <span>Aksi</span>
                                        <i class="fa-solid fa-caret-down ml-1"></i>
                                    </button>

                                    <!-- Overlay Klik di Luar -->
                                    <div 
                                        x-show="openDropdown"
                                        @click="openDropdown=false"
                                        class="fixed inset-0 z-10">
                                    </div>

                                    <!-- Menu Dropdown -->
                                    <div 
                                        x-show="openDropdown" 
                                        x-transition
                                        class="absolute z-30 right-0 mt-1 w-28 bg-white border border-gray-200 rounded shadow-lg">
                                        
                                        <button 
                                            @click="openEdit = true; openDropdown = false"
                                            class="w-full text-left px-3 py-1 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                            <i class="fa-solid fa-pen text-blue-500 text-xs"></i> Edit
                                        </button>

                                        <button 
                                            @click="openDelete = true; openDropdown = false"
                                            class="w-full text-left px-3 py-1 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                            <i class="fa-solid fa-trash text-red-500 text-xs"></i> Hapus
                                        </button>
                                    </div>

                                    <!-- 🟨 Modal Edit Data -->
                                    <div 
                                        x-show="openEdit" 
                                        x-transition.opacity
                                        class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex items-center justify-center z-50">
                                        <div 
                                            x-show="openEdit" 
                                            x-transition
                                            @click.away="openEdit = false"
                                            class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6 relative">
                                        
                                            <!-- Tombol Close -->
                                            <button 
                                                @click="openEdit = false"
                                                class="absolute top-3 right-3 text-gray-400 hover:text-red-500">
                                                <i class="fa-solid fa-xmark text-lg"></i>
                                            </button>

                                            <!-- Header Modal -->
                                            <div class="flex items-center gap-2 mb-4 border-b pb-2">
                                                <div class="bg-blue-500 text-white p-2 rounded-lg">
                                                    <i class="fa-solid fa-pen text-lg"></i>
                                                </div>
                                                <h2 class="text-lg font-semibold text-gray-800">Edit Data Mata Pelajaran</h2>
                                            </div>

                                            <!-- Form Edit -->
                                            <form action="{{ route('dashboard.data_mapel.update', $m->id_mapel) }}" method="POST" class="space-y-4">
                                                @csrf
                                                @method('PUT')
                                                <div>
                                                    <label class="block text-sm text-left font-medium text-gray-700">Nama Mata Pelajaran</label>
                                                    <input type="text" name="nama_mapel"
                                                        value="{{ $m->nama_mapel }}"
                                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 
                                                            focus:outline-none focus:ring-2 focus:ring-blue-400">
                                                </div>

                                                <div>
                                                    <label class="block text-sm text-left font-medium text-gray-700">Nama Singkat</label>
                                                    <input type="text" name="nama_singkat"
                                                        value="{{ $m->nama_singkat }}"
                                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 
                                                            focus:outline-none focus:ring-2 focus:ring-blue-400">
                                                </div>

                                                <div class="text-right pt-3">
                                                    <button type="submit"
                                                        class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-lg shadow">
                                                        Simpan Perubahan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- 🟩 Modal Hapus Data -->
                                    <div x-show="openDelete"
                                        class="fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center z-50">
                                        <div class="bg-white p-6 rounded-lg shadow-lg w-96 text-center">
                                            <p class="text-gray-700 text-sm mb-3">
                                                Tindakan ini akan menghapus seluruh data yang terkait dengan data tersebut. <strong>{{ $m->nama_mapel }}</strong>
                                                <br>
                                                <span class="font-medium">Data yang sudah dihapus tidak dapat dikembalikan.</span>
                                            </p>

                                            <div class="flex justify-center gap-3 mt-4">
                                                <button @click="openDelete = false"
                                                    class="bg-gray-200 text-gray-700 px-4 py-1 rounded font-medium hover:bg-gray-300">
                                                    Batal
                                                </button>
                                                <form action="{{ route('dashboard.data_mapel.delete', $m->id_mapel) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-600 text-white px-4 py-1 rounded font-medium hover:bg-red-700">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                         @empty
                        <tr>
                            <td colspan="4" class="py-4 px-3 text-center text-gray-500">Belum ada data mata pelajaran.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>



</body>
</html>
