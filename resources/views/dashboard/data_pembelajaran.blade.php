@extends('layouts.master')

@section('title', 'Data Kelas')

@php
    // SET SUBMENU YANG AKTIF UNTUK SIDEBAR
    $dataSekolahOpen = true; 
@endphp

@section('content')

    <!-- Main Content -->
    
        

            <!-- Header Judul & Tombol Tambah -->
            <div class="flex justify-between items-center border-b mb-6">
                

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
                                <h2 class="text-lg font-semibold text-gray-800">Tambah Data Pembelajaran</h2>
                            </div>

                            <!-- Form -->
                            <form action="{{ route('dashboard.data_pembelajaran.store') }}" method="POST" class="space-y-4">
                                @csrf
                                <!-- Dropdown Nama Mata Pelajaran -->
                                <div>
                                    <label class="block text-sm text-left font-medium text-gray-700">Nama Mata Pelajaran</label>
                                    <select name="id_mapel"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 
                                            focus:outline-none focus:ring-2 focus:ring-blue-400">
                                        <option value="">Pilih Mata Pelajaran</option>
                                         @foreach($mapel as $m)
                                        <option value="{{ $m->id_mapel }}">{{ $m->nama_mapel }}</option>
                                    @endforeach
                                    </select>
                                </div>

                                <!-- Dropdown Kelas -->
                                <div>
                                    <label class="block text-sm text-left font-medium text-gray-700">Kelas</label>
                                    <select name="id_kelas"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 
                                            focus:outline-none focus:ring-2 focus:ring-blue-400">
                                            <option value="">Pilih Kelas</option>
                                            @foreach($kelas as $k)
                                            <option value="{{ $k->id_kelas }}">
                                                {{ $k->tingkat }} {{ $k->nama_kelas }} - {{ $k->jurusan }}
                                            </option>
                                    @endforeach
                                    </select>
                                </div>

                                <!-- Dropdown Guru Mapel -->
                                <div>
                                    <label class="block text-sm text-left font-medium text-gray-700">Guru Mapel</label>
                                    <select name="id_guru"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 
                                            focus:outline-none focus:ring-2 focus:ring-blue-400">
                                        <option value="">Pilih Guru Mapel</option>
                                         @foreach($guru as $g)
                                            <option value="{{ $g->id_guru }}">{{ $g->nama_guru }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Tombol Submit -->
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
                    <a href="{{ route('dashboard.data_pembelajaran.export.pdf') }}" 
                    class="bg-gray-200 px-4 py-1 rounded hover:bg-gray-300">PDF</a>
                    <a href="{{ route('dashboard.data_pembelajaran.export.csv') }}" 
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
                            <th class="py-2 px-4">Tingkat</th>
                            <th class="py-2 px-4">Kelas</th>
                            <th class="py-2 px-4">Jurusan</th>
                            <th class="py-2 px-4">Guru Mapel</th>
                            <th class="py-2 px-4 text-center">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Tabel Data -->
                        @forelse ($pembelajaran as $index => $p)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-4 text-center">{{ $index + 1 }}</td>
                            <td class="py-2 px-4">{{ $p->mapel->nama_mapel ?? '-' }}</td>
                            <td class="py-2 px-4">{{ $p->kelas->tingkat ?? '-' }}</td>
                            <td class="py-2 px-4">{{ $p->kelas->nama_kelas ?? '-' }}</td>
                            <td class="py-2 px-4">{{ $p->kelas->jurusan ?? '-' }}</td>
                            <td class="py-2 px-4">{{ $p->guru->nama_guru ?? '-' }}</td>
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
                                            <form action="{{ route('dashboard.data_pembelajaran.update', $p->id_pembelajaran) }}" method="POST" class="space-y-4">
                                                @csrf
                                                @method('PUT')
                                                <div>
                                                    <label class="block text-sm text-left font-medium text-gray-700">Nama Mata Pelajaran</label>
                                                    <input type="text" name="nama_mapel_edit"
                                                        value="Pendidikan Agama Islam"
                                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 
                                                            focus:outline-none focus:ring-2 focus:ring-blue-400">
                                                </div>

                                                <div>
                                                    <label class="block text-sm text-left font-medium text-gray-700">Tingkat</label>
                                                    <input type="text" name="tingkat_edit"
                                                        value="10"
                                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 
                                                            focus:outline-none focus:ring-2 focus:ring-blue-400">
                                                </div>

                                                <div>
                                                    <label class="block text-sm text-left font-medium text-gray-700">Kelas</label>
                                                    <input type="text" name="kelas_edit"
                                                        value="10 AKT 1"
                                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 
                                                            focus:outline-none focus:ring-2 focus:ring-blue-400">
                                                </div>

                                                <div>
                                                    <label class="block text-sm text-left font-medium text-gray-700">Jurusan</label>
                                                    <input type="text" name="jurusan_edit"
                                                        value="Akuntansi"
                                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 
                                                            focus:outline-none focus:ring-2 focus:ring-blue-400">
                                                </div>

                                                <div>
                                                    <label class="block text-sm text-left font-medium text-gray-700">Guru Mapel</label>
                                                    <input type="text" name="guru_mapel_edit"
                                                        value="Wahyu"
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
                                </div>
                            </td>
                        </tr>
                         @empty
                        <tr>
                            <td colspan="7" class="text-center py-3 text-gray-500">Belum ada data pembelajaran.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        
    

@endsection