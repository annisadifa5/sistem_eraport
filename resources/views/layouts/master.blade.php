<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Rapor | @yield('title')</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
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

    @stack('head')
</head>

<body class="bg-gray-100">

{{-- ========================================================= --}}
{{-- ===================== GLOBAL STATE ======================= --}}
{{-- ========================================================= --}}
<div 
    x-data="{
        sidebarOpen: @json($sidebarOpen ?? true),
        dataSekolahOpen: @json($dataSekolahOpen ?? false),
        inputNilaiOpen: @json($inputNilaiOpen ?? false),
        cetakNilaiOpen: @json($cetakNilaiOpen ?? false),
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

    {{-- ========================================================= --}}
    {{-- ======================== SIDEBAR ========================= --}}
    {{-- ========================================================= --}}
    @if(auth()->user()->role == 'admin')
        @include('dashboard.sidebar_admin')
    @elseif(auth()->user()->role == 'guru' && auth()->user()->is_walikelas == 0)
        @include('dashboard.sidebar_guru')
    @elseif(auth()->user()->role == 'guru' && auth()->user()->is_walikelas == 1)
        @include('dashboard.sidebar_wali')
    @endif

    {{-- ========================================================= --}}
    {{-- ======================= MAIN AREA ======================== --}}
    {{-- ========================================================= --}}
    <main class="flex-1 p-8">
        <div class="bg-white rounded-2xl shadow p-8">

            {{-- HEADER PAGE --}}
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h2 class="text-lg font-semibold text-gray-800">@yield('title')</h2>

                {{-- Optional right area --}}
                @yield('actions')
            </div>

            {{-- PAGE CONTENT --}}
            @yield('content')

        </div>
    </main>

</div>

@stack('scripts')
</body>
</html>
