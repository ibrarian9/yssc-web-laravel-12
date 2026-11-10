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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50 font-sans antialiased overflow-x-clip" x-data="{ sidebarOpen: false }" @keydown.window.escape="sidebarOpen = false">

    <div class="min-h-screen bg-gray-50">
        {{-- ═══════════ SIDEBAR ═══════════ --}}
        {{-- Mobile overlay --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-40 lg:hidden" x-transition.opacity></div>

        <aside class="fixed inset-y-0 left-0 z-50 lg:z-40 w-64 bg-gray-900 text-gray-300 transform transition-transform duration-300 flex flex-col lg:translate-x-0"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            {{-- Logo --}}
            <div class="h-16 md:h-20 shrink-0 px-4 flex items-center justify-between lg:justify-center border-b border-gray-800 gap-2">
                <a href="{{ route('admin.dashboard') }}" wire:navigate.hover class="flex items-center justify-center flex-1 lg:w-full">
                    @php $adminLogo = \App\Models\Profile::getCached(); @endphp
                    <img src="{{ $adminLogo?->logo ? asset('storage/' . $adminLogo->logo) : asset('assets/logo.png') }}" 
                        alt="Logo" 
                        class="max-h-10 md:max-h-12 w-auto object-contain brightness-200 transition-all duration-300">
                </a>
                <button type="button" @click="sidebarOpen = false" aria-label="Tutup Menu"
                        class="lg:hidden min-w-[40px] min-h-[40px] flex items-center justify-center rounded-xl text-gray-400 hover:bg-gray-800 hover:text-white transition shrink-0">
                    <span class="material-symbols-outlined text-[20px]!">close</span>
                </button>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto overscroll-contain [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden hover:[&::-webkit-scrollbar]:block hover:[scrollbar-width:thin] hover:[scrollbar-color:#374151_transparent] [&::-webkit-scrollbar]:w-1.5 [&::-webkit-scrollbar-thumb]:bg-gray-700/60 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-transparent">
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
                        ['label' => 'Relawan', 'icon' => 'volunteer_activism', 'route' => 'admin.relawan.index', 'prefix' => 'admin.relawan*'],
                        ['type' => 'divider', 'label' => 'Sistem (Super Admin)', 'superadminOnly' => true],
                        ['label' => 'Pengguna', 'icon' => 'people', 'route' => 'admin.users.index', 'prefix' => 'admin.users*', 'superadminOnly' => true],
                        ['label' => 'Audit Log', 'icon' => 'history', 'route' => 'admin.audit-log.index', 'prefix' => 'admin.audit-log*', 'superadminOnly' => true],
                        ['type' => 'divider', 'label' => 'Pengaturan'],
                        ['label' => 'Slider Home', 'icon' => 'view_carousel', 'route' => 'admin.sliders.index', 'prefix' => 'admin.sliders*'],
                        ['label' => 'Hero Banner Menu', 'icon' => 'wallpaper', 'route' => 'admin.hero-sections.index', 'prefix' => 'admin.hero-sections*'],
                        ['type' => 'divider', 'label' => 'Bantuan'],
                        ['label' => 'Tutorial Admin', 'icon' => 'menu_book', 'route' => 'admin.tutorial.index', 'prefix' => 'admin.tutorial*'],
                    ];
                @endphp

                @foreach($menuItems as $item)
                    @continue(($item['superadminOnly'] ?? false) && ! auth()->user()?->isSuperAdmin())
                    @if(isset($item['type']) && $item['type'] === 'divider')
                        <div class="pt-4 pb-1 px-3">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-500">{{ $item['label'] }}</p>
                        </div>
                    @else
                        @php $isActive = request()->routeIs($item['prefix'] ?? $item['route']); @endphp
                        <a href="{{ route($item['route']) }}" wire:navigate.hover @click="sidebarOpen = false"
                           class="flex items-center gap-3 min-h-[44px] px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200
                                  {{ $isActive ? 'bg-teal-600 text-white shadow-lg shadow-teal-600/30' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                            <span class="material-symbols-outlined text-[20px]!">{{ $item['icon'] }}</span>
                            {{ $item['label'] }}
                        </a>
                    @endif
                @endforeach
            </nav>
        </aside>

        {{-- ═══════════ MAIN AREA ═══════════ --}}
        <div class="lg:pl-64 flex flex-col min-h-screen min-w-0 flex-1">
            {{-- Header --}}
            <header class="bg-white border-b border-gray-100 h-16 md:h-20 flex items-center justify-between gap-2 px-4 sm:px-6 lg:px-8 sticky top-0 z-30">
                <div class="flex items-center gap-3 min-w-0 flex-1">
                    <button type="button" @click="sidebarOpen = !sidebarOpen" aria-label="Buka Menu Admin"
                            class="lg:hidden inline-flex items-center gap-1.5 min-h-[44px] px-3 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs sm:text-sm font-semibold shrink-0 cursor-pointer transition">
                        <span class="material-symbols-outlined text-[20px]!">menu</span>
                        <span>Menu</span>
                    </button>

                    <h1 class="text-base sm:text-lg font-bold text-gray-800 truncate">{{ $header ?? 'Dashboard' }}</h1>
                </div>

                {{-- User dropdown --}}
                <div class="flex items-center gap-2 sm:gap-4 shrink-0">
                    <a href="{{ route('home') }}" target="_blank" title="Lihat Website"
                       class="min-h-[44px] min-w-[44px] sm:px-3 inline-flex items-center justify-center gap-1.5 rounded-xl text-sm text-gray-500 hover:text-teal-600 hover:bg-teal-50/60 transition">
                        <span class="material-symbols-outlined text-[20px]!">open_in_new</span>
                        <span class="hidden sm:inline font-medium">Lihat Website</span>
                    </a>

                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button type="button" @click="open = !open" class="min-h-[44px] flex items-center gap-2 px-2 py-1.5 rounded-xl hover:bg-gray-50 transition cursor-pointer">
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
                        document.addEventListener('livewire:navigated', () => {
                            if (typeof Swal !== 'undefined') Swal.fire({ icon: 'success', title: 'Berhasil!', text: @js(session('success')), timer: 3000, showConfirmButton: false, toast: true, position: 'top-end' });
                        }, { once: true });
                    </script>
                @endif
                @if(session('error'))
                    <script>
                        document.addEventListener('livewire:navigated', () => {
                            if (typeof Swal !== 'undefined') Swal.fire({ icon: 'error', title: 'Gagal!', text: @js(session('error')), timer: 4000, showConfirmButton: false, toast: true, position: 'top-end' });
                        }, { once: true });
                    </script>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html>
