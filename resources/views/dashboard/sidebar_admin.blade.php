<!-- Sidebar -->
<div 
    :class="sidebarOpen 
        ? '{{ request()->routeIs('dashboard') ? 'w-[17rem]' : 'w-56' }}' 
        : 'w-20'"
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
                    <!-- <a href="{{ route('input.tugas') }}" 
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
                    </a> -->
                    <a href="{{ route('input.rapor') }}" 
                       class="block py-2 flex items-center space-x-2 transition 
                            {{ request()->routeIs('input.rapor') ? 'bg-blue-700/70 rounded-l-md' : 'hover:bg-blue-700' }}">
                        <i class="fa-solid fa-users text-xs"></i><span>Rapor</span>
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