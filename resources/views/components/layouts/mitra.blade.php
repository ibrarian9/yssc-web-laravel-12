<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Mitra Panel' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50 font-sans antialiased overflow-x-clip" x-data="{ sidebarOpen: false }" @keydown.window.escape="sidebarOpen = false">
    <div class="min-h-screen bg-gray-50">
        {{-- Mobile / Tablet Backdrop --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-40 lg:hidden" x-transition.opacity></div>

        {{-- Sidebar --}}
        <aside class="fixed inset-y-0 left-0 z-50 lg:z-40 w-64 bg-gradient-to-b from-emerald-900 via-emerald-800 to-emerald-900 text-white flex flex-col transform transition-transform duration-300 lg:translate-x-0"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            <div class="h-16 md:h-20 px-4 flex items-center justify-between border-b border-emerald-700/50 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-emerald-500/30 rounded-lg flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[20px]! text-emerald-300">handshake</span>
                    </div>
                    <div>
                        <div class="text-sm font-extrabold">Mitra Panel</div>
                        <div class="text-[10px] text-emerald-400 uppercase tracking-wider">Dashboard</div>
                    </div>
                </div>
                <button type="button" @click="sidebarOpen = false" aria-label="Tutup Menu"
                        class="lg:hidden min-w-[40px] min-h-[40px] flex items-center justify-center rounded-xl text-emerald-200 hover:bg-emerald-700/50 hover:text-white transition">
                    <span class="material-symbols-outlined text-[20px]!">close</span>
                </button>
            </div>

            <nav class="px-3 py-4 space-y-1 flex-1 overflow-y-auto overscroll-contain">
                @php
                    $menuItems = [
                        ['label' => 'Dashboard', 'icon' => 'dashboard', 'route' => 'mitra.dashboard'],
                        ['type' => 'divider', 'label' => 'Kelola'],
                        ['label' => 'Program Donasi', 'icon' => 'volunteer_activism', 'route' => 'mitra.program-donasi.index', 'prefix' => 'mitra.program-donasi*'],
                        ['label' => 'Berita & Kegiatan', 'icon' => 'newspaper', 'route' => 'mitra.berita.index', 'prefix' => 'mitra.berita*'],
                    ];
                @endphp

                @foreach($menuItems as $item)
                    @if(isset($item['type']) && $item['type'] === 'divider')
                        <div class="pt-4 pb-1 px-3">
                            <span class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest">{{ $item['label'] }}</span>
                        </div>
                    @else
                        @php $isActive = request()->routeIs($item['prefix'] ?? $item['route']); @endphp
                        <a href="{{ route($item['route']) }}" wire:navigate.hover @click="sidebarOpen = false"
                           class="flex items-center gap-3 min-h-[44px] px-3 py-2.5 rounded-xl text-sm transition-all {{ $isActive ? 'bg-emerald-500/20 text-white font-bold' : 'text-emerald-200 hover:bg-emerald-700/30 hover:text-white' }}">
                            <span class="material-symbols-outlined text-[20px]! {{ $isActive ? 'text-emerald-300' : '' }}">{{ $item['icon'] }}</span>
                            {{ $item['label'] }}
                        </a>
                    @endif
                @endforeach
            </nav>

            {{-- Footer --}}
            <div class="px-3 py-4 border-t border-emerald-700/50 shrink-0">
                <a href="{{ route('home') }}" class="flex items-center gap-2 min-h-[44px] px-3 py-2 text-sm text-emerald-200 hover:text-white transition rounded-xl hover:bg-emerald-700/30">
                    <span class="material-symbols-outlined text-[18px]!">open_in_new</span>Lihat Website
                </a>
            </div>
        </aside>

        {{-- Main --}}
        <div class="lg:pl-64 flex flex-col min-h-screen min-w-0 flex-1">
            {{-- Header --}}
            <header class="bg-white shadow-sm border-b border-gray-100 h-16 md:h-20 px-4 sm:px-6 flex items-center justify-between sticky top-0 z-30 shrink-0">
                <div class="flex items-center gap-3 min-w-0">
                    <button type="button" @click="sidebarOpen = !sidebarOpen" aria-label="Buka Menu"
                            class="lg:hidden inline-flex items-center gap-1.5 min-h-[44px] px-3 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs sm:text-sm font-semibold transition cursor-pointer shrink-0">
                        <span class="material-symbols-outlined text-[20px]!">menu</span>
                        <span>Menu</span>
                    </button>
                    <h1 class="text-base sm:text-lg font-bold text-gray-800 truncate">{{ $header ?? 'Dashboard' }}</h1>
                </div>
                <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                    @auth
                        <span class="hidden sm:inline text-sm text-gray-600 font-medium">{{ auth()->user()->name }}</span>
                        <div class="w-8 h-8 bg-emerald-600 text-white rounded-full flex items-center justify-center text-xs font-bold shrink-0">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="min-h-[40px] px-2.5 text-xs font-semibold text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition cursor-pointer">Keluar</button>
                        </form>
                    @endauth
                </div>
            </header>

            {{-- Content --}}
            <main class="flex-1 p-4 sm:p-6">
                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]!">check_circle</span>{{ session('success') }}
                    </div>
                @endif
                {{ $slot }}
            </main>
        </div>
    </div>
    @livewireScripts
</body>
</html>
