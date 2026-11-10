<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO Meta --}}
    <title>{{ $title ?? 'Yayasan Seribu Satu Cita' }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'Yayasan Seribu Satu Cita - Tumbuhkan anak dengan ilmu, sayapnya akan terbang bebas di dunia.' }}">
    <meta property="og:title" content="{{ $title ?? 'Yayasan Seribu Satu Cita' }}">
    <meta property="og:description" content="{{ $metaDescription ?? 'Yayasan Seribu Satu Cita - Tumbuhkan anak dengan ilmu.' }}">
    <meta property="og:type" content="website">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" />

    {{-- SweetAlert2 (deferred so it never blocks rendering) --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
@php
    $siteProfile = $profile ?? \App\Models\Profile::getCached();
    $isDonasiActive = $siteProfile?->is_donasi_enabled ?? true;
@endphp
<body class="bg-gray-50 font-sans text-gray-800 antialiased overflow-x-clip pb-16 md:pb-0" x-data="{ mobileOpen: false }" @keydown.window.escape="mobileOpen = false">

    {{-- ═══════════ NAVBAR ═══════════ --}}
    <nav class="bg-white/95 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50 transition-all duration-300">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 md:h-20">
                {{-- Logo --}}
                <a href="{{ route('home') }}" wire:navigate.hover class="flex items-center gap-3 group shrink-0">
                    <img src="{{ $siteProfile?->logo ? asset('storage/' . $siteProfile->logo) : asset('assets/logo.png') }}"
                         alt="Logo YSSC"
                         class="h-9 sm:h-10 md:h-12 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                </a>

                {{-- Desktop / Tablet Landscape Menu --}}
                <div class="hidden lg:flex items-center gap-0.5">
                    {{-- Beranda --}}
                    <a href="{{ route('home') }}" wire:navigate.hover
                       class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200
                              {{ request()->routeIs('home') ? 'text-teal-700 bg-teal-50' : 'text-gray-600 hover:text-teal-700 hover:bg-gray-50' }}">
                        Beranda
                    </a>

                    {{-- Berita dropdown --}}
                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" @click.away="open = false" @keydown.escape.window="open = false">
                        <button @click="open = !open" :aria-expanded="open"
                                class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200 flex items-center gap-1
                                       {{ request()->routeIs('berita.*', 'kegiatan.*') ? 'text-teal-700 bg-teal-50' : 'text-gray-600 hover:text-teal-700 hover:bg-gray-50' }}">
                            Berita
                            <span class="material-symbols-outlined text-[16px]! transition-transform duration-200" :class="open && 'rotate-180'">expand_more</span>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                             class="absolute top-full left-0 mt-1 w-52 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                            <a href="{{ route('berita.index') }}" wire:navigate.hover class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium transition {{ request()->routeIs('berita.*') ? 'text-teal-700 bg-teal-50' : 'text-gray-600 hover:bg-gray-50 hover:text-teal-700' }}">
                                <span class="material-symbols-outlined text-[18px]!">newspaper</span> Berita
                            </a>
                            <a href="{{ route('kegiatan.index') }}" wire:navigate.hover class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium transition {{ request()->routeIs('kegiatan.*') ? 'text-teal-700 bg-teal-50' : 'text-gray-600 hover:bg-gray-50 hover:text-teal-700' }}">
                                <span class="material-symbols-outlined text-[18px]!">event</span> Kegiatan
                            </a>
                        </div>
                    </div>

                    {{-- Tentang Kami dropdown --}}
                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" @click.away="open = false" @keydown.escape.window="open = false">
                        <button @click="open = !open" :aria-expanded="open"
                                class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200 flex items-center gap-1
                                       {{ request()->routeIs('profil.*', 'anggota.*') ? 'text-teal-700 bg-teal-50' : 'text-gray-600 hover:text-teal-700 hover:bg-gray-50' }}">
                            Tentang Kami
                            <span class="material-symbols-outlined text-[16px]! transition-transform duration-200" :class="open && 'rotate-180'">expand_more</span>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                             class="absolute top-full left-0 mt-1 w-52 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                            <a href="{{ route('profil.index') }}" wire:navigate.hover class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium transition {{ request()->routeIs('profil.*') ? 'text-teal-700 bg-teal-50' : 'text-gray-600 hover:bg-gray-50 hover:text-teal-700' }}">
                                <span class="material-symbols-outlined text-[18px]!">business</span> Profil Yayasan
                            </a>
                            <a href="{{ route('anggota.index') }}" wire:navigate.hover class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium transition {{ request()->routeIs('anggota.*') ? 'text-teal-700 bg-teal-50' : 'text-gray-600 hover:bg-gray-50 hover:text-teal-700' }}">
                                <span class="material-symbols-outlined text-[18px]!">groups</span> Anggota
                            </a>
                        </div>
                    </div>

                    {{-- Layanan dropdown --}}
                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" @click.away="open = false" @keydown.escape.window="open = false">
                        <button @click="open = !open" :aria-expanded="open"
                                class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200 flex items-center gap-1
                                       {{ request()->routeIs('donasi.*', 'perizinan.*', 'mitra.*', 'relawan.*') ? 'text-teal-700 bg-teal-50' : 'text-gray-600 hover:text-teal-700 hover:bg-gray-50' }}">
                            Layanan
                            <span class="material-symbols-outlined text-[16px]! transition-transform duration-200" :class="open && 'rotate-180'">expand_more</span>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                             class="absolute top-full left-0 mt-1 w-56 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                            @if($isDonasiActive)
                                <a href="{{ route('donasi.index') }}" wire:navigate.hover class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium transition {{ request()->routeIs('donasi.*') ? 'text-teal-700 bg-teal-50' : 'text-gray-600 hover:bg-gray-50 hover:text-teal-700' }}">
                                    <span class="material-symbols-outlined text-[18px]!">volunteer_activism</span> Donasi
                                </a>
                            @endif
                            <a href="{{ route('relawan.index') }}" wire:navigate.hover class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium transition {{ request()->routeIs('relawan.*') ? 'text-teal-700 bg-teal-50' : 'text-gray-600 hover:bg-gray-50 hover:text-teal-700' }}">
                                <span class="material-symbols-outlined text-[18px]!">diversity_3</span> Relawan
                            </a>
                            <a href="{{ route('mitra.index') }}" wire:navigate.hover class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium transition {{ request()->routeIs('mitra.*') ? 'text-teal-700 bg-teal-50' : 'text-gray-600 hover:bg-gray-50 hover:text-teal-700' }}">
                                <span class="material-symbols-outlined text-[18px]!">handshake</span> Mitra
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="{{ route('perizinan.form') }}" wire:navigate.hover class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium transition {{ request()->routeIs('perizinan.*') ? 'text-teal-700 bg-teal-50' : 'text-gray-600 hover:bg-gray-50 hover:text-teal-700' }}">
                                <span class="material-symbols-outlined text-[18px]!">description</span> Perizinan
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Desktop Auth --}}
                <div class="hidden lg:flex items-center gap-3">
                    @auth
                        <div class="relative" x-data="{ open: false }" @click.away="open = false" @keydown.escape.window="open = false">
                            <button @click="open = !open" :aria-expanded="open" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-50 transition">
                                <div class="w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center">
                                    <span class="text-teal-700 font-bold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-700">{{ auth()->user()->name }}</span>
                                <span class="material-symbols-outlined text-[18px]! text-gray-400 transition-transform" :class="open && 'rotate-180'">expand_more</span>
                            </button>

                            <div x-show="open" x-transition
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-1 z-50">
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                                        <span class="material-symbols-outlined text-[18px]!">dashboard</span> Panel Admin
                                    </a>
                                @elseif(auth()->user()->role->isMitra())
                                    <a href="{{ route('mitra.dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                                        <span class="material-symbols-outlined text-[18px]!">handshake</span> Panel Mitra
                                    </a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50">
                                        <span class="material-symbols-outlined text-[18px]!">logout</span> Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:text-teal-700 transition">Masuk</a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 bg-gradient-to-r from-teal-600 to-teal-700 text-white text-sm font-bold rounded-lg hover:from-teal-700 hover:to-teal-800 shadow-md shadow-teal-500/20 transition-all hover:shadow-lg hover:scale-[1.02]">
                            Daftar
                        </a>
                    @endguest
                </div>

                {{-- Mobile & Tablet Hamburger Controls --}}
                <div class="lg:hidden flex items-center gap-2">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline-flex items-center gap-1.5 min-h-[44px] px-3 py-2 rounded-xl bg-teal-50 text-teal-700 text-xs font-bold hover:bg-teal-100 transition">
                                <span class="material-symbols-outlined text-[18px]!">dashboard</span> Admin
                            </a>
                        @elseif(auth()->user()->role->isMitra())
                            <a href="{{ route('mitra.dashboard') }}" class="hidden sm:inline-flex items-center gap-1.5 min-h-[44px] px-3 py-2 rounded-xl bg-emerald-50 text-emerald-700 text-xs font-bold hover:bg-emerald-100 transition">
                                <span class="material-symbols-outlined text-[18px]!">handshake</span> Mitra
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center min-h-[44px] px-3.5 py-2 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
                            Masuk
                        </a>
                    @endauth
                    <button type="button" @click="mobileOpen = !mobileOpen" :aria-expanded="mobileOpen" aria-label="Toggle Menu Navigasi"
                            class="inline-flex items-center gap-1.5 min-h-[44px] px-3.5 py-2 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 active:bg-gray-100 text-gray-700 text-sm font-semibold transition cursor-pointer">
                        <span class="material-symbols-outlined text-[22px]!" x-text="mobileOpen ? 'close' : 'menu'">menu</span>
                        <span x-text="mobileOpen ? 'Tutup' : 'Menu'">Menu</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile & Tablet Drawer Menu --}}
        <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
             class="lg:hidden border-t border-gray-100 bg-white shadow-xl max-h-[calc(100dvh-4.5rem)] overflow-y-auto overscroll-contain" x-data="{ openGroup: '' }">
            <div class="container mx-auto px-4 py-4 space-y-1">
                {{-- Beranda --}}
                <a href="{{ route('home') }}" wire:navigate @click="mobileOpen = false" class="flex items-center gap-3 min-h-[44px] px-4 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('home') ? 'text-teal-700 bg-teal-50' : 'text-gray-700 hover:bg-gray-50' }}">
                    <span class="material-symbols-outlined text-[20px]!">home</span> Beranda
                </a>

                {{-- Berita group --}}
                <div>
                    <button type="button" @click="openGroup = openGroup === 'berita' ? '' : 'berita'" class="w-full flex items-center justify-between min-h-[44px] px-4 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('berita.*', 'kegiatan.*') ? 'text-teal-700 bg-teal-50' : 'text-gray-700 hover:bg-gray-50' }}">
                        <span class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px]!">newspaper</span> Berita & Kegiatan
                        </span>
                        <span class="material-symbols-outlined text-[20px]! transition-transform duration-200" :class="openGroup === 'berita' && 'rotate-180'">expand_more</span>
                    </button>
                    <div x-show="openGroup === 'berita'" x-collapse class="pl-6 space-y-1 mt-1">
                        <a href="{{ route('berita.index') }}" wire:navigate @click="mobileOpen = false" class="flex items-center gap-2.5 min-h-[44px] px-4 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('berita.*') ? 'text-teal-700 bg-teal-50' : 'text-gray-600 hover:bg-gray-50' }}">
                            <span class="material-symbols-outlined text-[18px]!">newspaper</span> Berita
                        </a>
                        <a href="{{ route('kegiatan.index') }}" wire:navigate @click="mobileOpen = false" class="flex items-center gap-2.5 min-h-[44px] px-4 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('kegiatan.*') ? 'text-teal-700 bg-teal-50' : 'text-gray-600 hover:bg-gray-50' }}">
                            <span class="material-symbols-outlined text-[18px]!">event</span> Kegiatan
                        </a>
                    </div>
                </div>

                {{-- Tentang Kami group --}}
                <div>
                    <button type="button" @click="openGroup = openGroup === 'tentang' ? '' : 'tentang'" class="w-full flex items-center justify-between min-h-[44px] px-4 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('profil.*', 'anggota.*') ? 'text-teal-700 bg-teal-50' : 'text-gray-700 hover:bg-gray-50' }}">
                        <span class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px]!">business</span> Tentang Kami
                        </span>
                        <span class="material-symbols-outlined text-[20px]! transition-transform duration-200" :class="openGroup === 'tentang' && 'rotate-180'">expand_more</span>
                    </button>
                    <div x-show="openGroup === 'tentang'" x-collapse class="pl-6 space-y-1 mt-1">
                        <a href="{{ route('profil.index') }}" wire:navigate @click="mobileOpen = false" class="flex items-center gap-2.5 min-h-[44px] px-4 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('profil.*') ? 'text-teal-700 bg-teal-50' : 'text-gray-600 hover:bg-gray-50' }}">
                            <span class="material-symbols-outlined text-[18px]!">business</span> Profil Yayasan
                        </a>
                        <a href="{{ route('anggota.index') }}" wire:navigate @click="mobileOpen = false" class="flex items-center gap-2.5 min-h-[44px] px-4 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('anggota.*') ? 'text-teal-700 bg-teal-50' : 'text-gray-600 hover:bg-gray-50' }}">
                            <span class="material-symbols-outlined text-[18px]!">groups</span> Anggota
                        </a>
                    </div>
                </div>

                {{-- Layanan group --}}
                <div>
                    <button type="button" @click="openGroup = openGroup === 'layanan' ? '' : 'layanan'" class="w-full flex items-center justify-between min-h-[44px] px-4 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('donasi.*', 'perizinan.*', 'mitra.*', 'relawan.*') ? 'text-teal-700 bg-teal-50' : 'text-gray-700 hover:bg-gray-50' }}">
                        <span class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px]!">volunteer_activism</span> Layanan
                        </span>
                        <span class="material-symbols-outlined text-[20px]! transition-transform duration-200" :class="openGroup === 'layanan' && 'rotate-180'">expand_more</span>
                    </button>
                    <div x-show="openGroup === 'layanan'" x-collapse class="pl-6 space-y-1 mt-1">
                        @if($isDonasiActive)
                            <a href="{{ route('donasi.index') }}" wire:navigate @click="mobileOpen = false" class="flex items-center gap-2.5 min-h-[44px] px-4 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('donasi.*') ? 'text-teal-700 bg-teal-50' : 'text-gray-600 hover:bg-gray-50' }}">
                                <span class="material-symbols-outlined text-[18px]!">volunteer_activism</span> Donasi
                            </a>
                        @endif
                        <a href="{{ route('relawan.index') }}" wire:navigate @click="mobileOpen = false" class="flex items-center gap-2.5 min-h-[44px] px-4 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('relawan.*') ? 'text-teal-700 bg-teal-50' : 'text-gray-600 hover:bg-gray-50' }}">
                            <span class="material-symbols-outlined text-[18px]!">diversity_3</span> Relawan
                        </a>
                        <a href="{{ route('mitra.index') }}" wire:navigate @click="mobileOpen = false" class="flex items-center gap-2.5 min-h-[44px] px-4 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('mitra.*') ? 'text-teal-700 bg-teal-50' : 'text-gray-600 hover:bg-gray-50' }}">
                            <span class="material-symbols-outlined text-[18px]!">handshake</span> Mitra
                        </a>
                        <a href="{{ route('perizinan.form') }}" wire:navigate @click="mobileOpen = false" class="flex items-center gap-2.5 min-h-[44px] px-4 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('perizinan.*') ? 'text-teal-700 bg-teal-50' : 'text-gray-600 hover:bg-gray-50' }}">
                            <span class="material-symbols-outlined text-[18px]!">description</span> Perizinan
                        </a>
                    </div>
                </div>

                <hr class="my-3 border-gray-100">

                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 min-h-[44px] px-4 py-2.5 rounded-xl text-sm font-semibold text-teal-700 bg-teal-50/70 hover:bg-teal-50">
                            <span class="material-symbols-outlined text-[20px]!">dashboard</span> Panel Admin
                        </a>
                    @elseif(auth()->user()->role->isMitra())
                        <a href="{{ route('mitra.dashboard') }}" class="flex items-center gap-3 min-h-[44px] px-4 py-2.5 rounded-xl text-sm font-semibold text-emerald-700 bg-emerald-50/70 hover:bg-emerald-50">
                            <span class="material-symbols-outlined text-[20px]!">handshake</span> Panel Mitra
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 min-h-[44px] text-left px-4 py-2.5 rounded-xl text-sm font-semibold text-red-600 hover:bg-red-50">
                            <span class="material-symbols-outlined text-[20px]!">logout</span> Keluar
                        </button>
                    </form>
                @else
                    <div class="grid grid-cols-2 gap-3 pt-2">
                        <a href="{{ route('login') }}" class="flex items-center justify-center min-h-[44px] px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50">Masuk</a>
                        <a href="{{ route('register') }}" class="flex items-center justify-center min-h-[44px] px-4 py-2.5 bg-teal-600 rounded-xl text-sm font-bold text-white hover:bg-teal-700">Daftar</a>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    {{-- ═══════════ FLASH MESSAGES ═══════════ --}}
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

    {{-- ═══════════ MAIN CONTENT ═══════════ --}}
    <main>
        {{ $slot }}
    </main>

    {{-- ═══════════ FOOTER ═══════════ --}}
    @php $profile = $siteProfile; @endphp
    <footer class="bg-gray-900 text-gray-300">
        {{-- Top section --}}
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                {{-- Brand --}}
                <div class="lg:col-span-1">
                    <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-3 mb-4">
                        <img src="{{ $profile?->logo ? asset('storage/' . $profile->logo) : asset('assets/logo.png') }}" alt="Logo YSSC" class="h-12 w-auto brightness-200" loading="lazy" decoding="async">
                    </a>
                    <p class="text-sm leading-relaxed text-gray-400 mb-6">
                        {{ $profile?->tagline ?? 'Tumbuhkan anak dengan ilmu, sayapnya akan terbang bebas di dunia.' }}
                    </p>
                    {{-- Social Icons --}}
                    <div class="flex gap-3">
                        @if($profile?->instagram)
                            <a href="{{ $profile->instagram }}" target="_blank" class="w-9 h-9 bg-gray-800 hover:bg-teal-600 rounded-lg flex items-center justify-center transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                        @endif
                        @if($profile?->facebook)
                            <a href="{{ $profile->facebook }}" target="_blank" class="w-9 h-9 bg-gray-800 hover:bg-teal-600 rounded-lg flex items-center justify-center transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385h-3.047v-3.47h3.047v-2.642c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953h-1.514c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385c5.737-.9 10.125-5.864 10.125-11.854z"/></svg>
                            </a>
                        @endif
                        @if($profile?->youtube)
                            <a href="{{ $profile->youtube }}" target="_blank" class="w-9 h-9 bg-gray-800 hover:bg-teal-600 rounded-lg flex items-center justify-center transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-4">Menu</h4>
                    <ul class="space-y-1.5">
                        <li><a href="{{ route('home') }}" wire:navigate class="inline-flex items-center py-1.5 text-sm hover:text-teal-400 transition">Beranda</a></li>
                        <li><a href="{{ route('berita.index') }}" wire:navigate class="inline-flex items-center py-1.5 text-sm hover:text-teal-400 transition">Berita</a></li>
                        <li><a href="{{ route('kegiatan.index') }}" wire:navigate class="inline-flex items-center py-1.5 text-sm hover:text-teal-400 transition">Kegiatan</a></li>
                        <li><a href="{{ route('profil.index') }}" wire:navigate class="inline-flex items-center py-1.5 text-sm hover:text-teal-400 transition">Profil</a></li>
                        @if($isDonasiActive)
                            <li><a href="{{ route('donasi.index') }}" wire:navigate class="inline-flex items-center py-1.5 text-sm hover:text-teal-400 transition">Donasi</a></li>
                        @endif
                    </ul>
                </div>

                {{-- Other Links --}}
                <div>
                    <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-4">Lainnya</h4>
                    <ul class="space-y-1.5">
                        <li><a href="{{ route('anggota.index') }}" wire:navigate class="inline-flex items-center py-1.5 text-sm hover:text-teal-400 transition">Anggota</a></li>
                        <li><a href="{{ route('perizinan.form') }}" wire:navigate class="inline-flex items-center py-1.5 text-sm hover:text-teal-400 transition">Perizinan</a></li>
                        <li><a href="{{ route('perizinan.cek') }}" wire:navigate class="inline-flex items-center py-1.5 text-sm hover:text-teal-400 transition">Cek Status Perizinan</a></li>
                        <li><a href="{{ route('relawan.index') }}" wire:navigate class="inline-flex items-center py-1.5 text-sm hover:text-teal-400 transition">Relawan</a></li>
                        <li><a href="{{ route('mitra.index') }}" wire:navigate class="inline-flex items-center py-1.5 text-sm hover:text-teal-400 transition">Mitra</a></li>
                    </ul>
                </div>

                {{-- Contact --}}
                <div>
                    <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-4">Kontak</h4>
                    <ul class="space-y-2.5">
                        @if($profile?->alamat)
                            <li class="flex items-start gap-2 text-sm py-1">
                                <span class="material-symbols-outlined text-[18px]! text-teal-400 mt-0.5 shrink-0">location_on</span>
                                <span>{{ $profile->alamat }}</span>
                            </li>
                        @endif
                        @if($profile?->email)
                            <li class="flex items-center gap-2 text-sm">
                                <span class="material-symbols-outlined text-[18px]! text-teal-400 shrink-0">mail</span>
                                <a href="mailto:{{ $profile->email }}" class="inline-flex items-center py-1.5 hover:text-teal-400 transition break-all">{{ $profile->email }}</a>
                            </li>
                        @endif
                        @if($profile?->telepon)
                            <li class="flex items-center gap-2 text-sm py-1">
                                <span class="material-symbols-outlined text-[18px]! text-teal-400 shrink-0">call</span>
                                <span>{{ $profile->telepon }}</span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="border-t border-gray-800">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-5 flex flex-col md:flex-row justify-between items-center gap-3 text-center md:text-left">
                <p class="text-xs text-gray-500">&copy; {{ date('Y') }} {{ $profile?->nama_organisasi ?? 'Yayasan Seribu Satu Cita' }}. All rights reserved.</p>
                <p class="text-xs text-gray-500 flex items-center gap-1">Made with <span class="material-symbols-outlined text-[14px]! text-red-500">favorite</span> for a better Indonesia</p>
            </div>
        </div>
    </footer>

    {{-- ═══════════ MOBILE BOTTOM QUICK NAV (Phones < 768px) ═══════════ --}}
    <nav aria-label="Navigasi cepat mobile"
         class="md:hidden fixed bottom-0 inset-x-0 z-50 bg-white/95 backdrop-blur-md border-t border-gray-200 shadow-[0_-4px_20px_rgba(0,0,0,0.06)] pb-[env(safe-area-inset-bottom)]">
        <div class="grid grid-cols-5 h-16">
            <a href="{{ route('home') }}" wire:navigate class="flex flex-col items-center justify-center gap-0.5 text-[11px] font-semibold transition {{ request()->routeIs('home') ? 'text-teal-600' : 'text-gray-500 active:text-teal-600' }}">
                <span class="material-symbols-outlined text-[22px]!">home</span>
                <span>Beranda</span>
            </a>
            <a href="{{ route('berita.index') }}" wire:navigate class="flex flex-col items-center justify-center gap-0.5 text-[11px] font-semibold transition {{ request()->routeIs('berita.*', 'kegiatan.*') ? 'text-teal-600' : 'text-gray-500 active:text-teal-600' }}">
                <span class="material-symbols-outlined text-[22px]!">newspaper</span>
                <span>Berita</span>
            </a>
            @if($isDonasiActive)
                <a href="{{ route('donasi.index') }}" wire:navigate class="flex flex-col items-center justify-center gap-0.5 text-[11px] font-semibold transition {{ request()->routeIs('donasi.*') ? 'text-teal-600' : 'text-gray-500 active:text-teal-600' }}">
                    <span class="material-symbols-outlined text-[22px]!">volunteer_activism</span>
                    <span>Donasi</span>
                </a>
            @else
                <a href="{{ route('relawan.index') }}" wire:navigate class="flex flex-col items-center justify-center gap-0.5 text-[11px] font-semibold transition {{ request()->routeIs('relawan.*') ? 'text-teal-600' : 'text-gray-500 active:text-teal-600' }}">
                    <span class="material-symbols-outlined text-[22px]!">diversity_3</span>
                    <span>Relawan</span>
                </a>
            @endif
            <a href="{{ route('perizinan.form') }}" wire:navigate class="flex flex-col items-center justify-center gap-0.5 text-[11px] font-semibold transition {{ request()->routeIs('perizinan.*') ? 'text-teal-600' : 'text-gray-500 active:text-teal-600' }}">
                <span class="material-symbols-outlined text-[22px]!">description</span>
                <span>Perizinan</span>
            </a>
            <button type="button" @click="mobileOpen = !mobileOpen"
                    class="flex flex-col items-center justify-center gap-0.5 text-[11px] font-semibold transition cursor-pointer"
                    :class="mobileOpen ? 'text-teal-600' : 'text-gray-500 active:text-teal-600'">
                <span class="material-symbols-outlined text-[22px]!" x-text="mobileOpen ? 'close' : 'menu'">menu</span>
                <span x-text="mobileOpen ? 'Tutup' : 'Lainnya'">Lainnya</span>
            </button>
        </div>
    </nav>

    @livewireScripts
</body>
</html>
