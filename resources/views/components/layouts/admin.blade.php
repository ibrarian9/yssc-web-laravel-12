<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin' }} — YSSC</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50 font-sans antialiased" x-data="{ sidebarOpen: false }">

    <div class="min-h-screen flex">
        {{-- ═══════════ SIDEBAR ═══════════ --}}
        {{-- Mobile overlay --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-40 lg:hidden" x-transition.opacity></div>

        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-900 text-gray-300 transform transition-transform duration-300 lg:translate-x-0 lg:static lg:z-auto"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            {{-- Logo --}}
            <div class="h-auto py-8 flex items-center justify-center border-b border-gray-800">
                {{-- Tambahkan w-full agar link memenuhi container --}}
                <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-center w-full px-4">
                    @php $adminLogo = \App\Models\Profile::first(); @endphp
                    <img src="{{ $adminLogo?->logo ? asset('storage/' . $adminLogo->logo) : asset('assets/logo.png') }}" 
                        alt="Logo" 
                        class="w-full h-auto max-h-24 object-contain brightness-200 transition-all duration-300">
                </a>
            </div>

            {{-- Navigation --}}
            <nav class="px-3 py-4 space-y-1 overflow-y-auto h-[calc(100vh-5rem)]">
                @php
                    $menuItems = [
                        ['label' => 'Dashboard', 'icon' => 'dashboard', 'route' => 'admin.dashboard'],
                        ['type' => 'divider', 'label' => 'Konten'],
                        ['label' => 'Berita & Kegiatan', 'icon' => 'newspaper', 'route' => 'admin.berita.index', 'prefix' => 'admin.berita*'],
                        ['label' => 'Kategori', 'icon' => 'category', 'route' => 'admin.kategori.index', 'prefix' => 'admin.kategori*'],
                        ['type' => 'divider', 'label' => 'Profil Organisasi'],
                        ['label' => 'Profil & Dokumen', 'icon' => 'business', 'route' => 'admin.profil.index', 'prefix' => 'admin.profil*'],
                        ['label' => 'Anggota & Divisi', 'icon' => 'groups', 'route' => 'admin.anggota.index', 'prefix' => 'admin.anggota*'],
                        ['type' => 'divider', 'label' => 'Donasi'],
                        ['label' => 'Program Donasi', 'icon' => 'volunteer_activism', 'route' => 'admin.program-donasi.index', 'prefix' => 'admin.program-donasi*'],
                        ['label' => 'Transaksi Donasi', 'icon' => 'receipt_long', 'route' => 'admin.transaksi-donasi.index', 'prefix' => 'admin.transaksi-donasi*'],
                        ['type' => 'divider', 'label' => 'Lainnya'],
                        ['label' => 'Perizinan', 'icon' => 'description', 'route' => 'admin.perizinan.index', 'prefix' => 'admin.perizinan*'],
                        ['label' => 'Mitra', 'icon' => 'handshake', 'route' => 'admin.mitra.index', 'prefix' => 'admin.mitra*'],
                        ['label' => 'Pengguna', 'icon' => 'people', 'route' => 'admin.users.index', 'prefix' => 'admin.users*'],
                        ['label' => 'Audit Log', 'icon' => 'history', 'route' => 'admin.audit-log.index', 'prefix' => 'admin.audit-log*'],
                        ['type' => 'divider', 'label' => 'Pengaturan'],
                        ['label' => 'Slider Home', 'icon' => 'view_carousel', 'route' => 'admin.sliders.index', 'prefix' => 'admin.sliders*'],
                    ];
                @endphp

                @foreach($menuItems as $item)
                    @if(isset($item['type']) && $item['type'] === 'divider')
                        <div class="pt-4 pb-1 px-3">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-500">{{ $item['label'] }}</p>
                        </div>
                    @else
                        @php $isActive = request()->routeIs($item['prefix'] ?? $item['route']); @endphp
                        <a href="{{ route($item['route']) }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200
                                  {{ $isActive ? 'bg-teal-600 text-white shadow-lg shadow-teal-600/30' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                            <span class="material-symbols-outlined text-[20px]!">{{ $item['icon'] }}</span>
                            {{ $item['label'] }}
                        </a>
                    @endif
                @endforeach
            </nav>
        </aside>

        {{-- ═══════════ MAIN AREA ═══════════ --}}
        <div class="flex-1 flex flex-col min-w-0">
            {{-- Header --}}
            <header class="bg-white border-b border-gray-100 h-16 md:h-20 flex items-center px-4 sm:px-6 lg:px-8 sticky top-0 z-30">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 mr-3">
                    <span class="material-symbols-outlined">menu</span>
                </button>

                <div class="flex-1">
                    <h1 class="text-lg font-bold text-gray-800">{{ $header ?? 'Dashboard' }}</h1>
                </div>

                {{-- User dropdown --}}
                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" target="_blank" class="text-sm text-gray-500 hover:text-teal-600 flex items-center gap-1 transition">
                        <span class="material-symbols-outlined text-[18px]!">open_in_new</span>
                        <span class="hidden sm:inline">Lihat Website</span>
                    </a>

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 px-2 py-1.5 rounded-lg hover:bg-gray-50 transition">
                            <div class="w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center">
                                <span class="text-teal-700 font-bold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                            <div class="hidden sm:block text-left">
                                <p class="text-sm font-semibold text-gray-700 leading-tight">{{ auth()->user()->name }}</p>
                                <p class="text-[10px] text-gray-400 uppercase tracking-wider">{{ auth()->user()->role->label() }}</p>
                            </div>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-1 z-50">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50">
                                    <span class="material-symbols-outlined text-[18px]!">logout</span> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                {{-- Flash Messages --}}
                @if(session('success'))
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ session('success') }}', timer: 3000, showConfirmButton: false, toast: true, position: 'top-end' });
                        });
                    </script>
                @endif
                @if(session('error'))
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            Swal.fire({ icon: 'error', title: 'Gagal!', text: '{{ session('error') }}', timer: 4000, showConfirmButton: false, toast: true, position: 'top-end' });
                        });
                    </script>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html>
