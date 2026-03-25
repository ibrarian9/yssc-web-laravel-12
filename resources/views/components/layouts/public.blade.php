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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Midtrans Snap.js --}}
    <script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
            data-client-key="{{ config('midtrans.client_key') }}"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50 font-sans text-gray-800 antialiased">

    {{-- ═══════════ NAVBAR ═══════════ --}}
    <nav class="bg-white/95 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50 transition-all duration-300" x-data="{ mobileOpen: false }">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 md:h-20">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 group shrink-0">
                    <img src="{{ ($profile ?? null)?->logo ? asset('storage/' . $profile->logo) : asset('assets/logo.png') }}"
                         alt="Logo YSSC"
                         class="h-10 md:h-12 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                </a>

                {{-- Desktop Menu --}}
                <div class="hidden lg:flex items-center gap-1">
                    @php
                        $navItems = [
                            ['label' => 'Beranda', 'route' => 'home'],
                            ['label' => 'Berita', 'route' => 'berita.index'],
                            ['label' => 'Kegiatan', 'route' => 'kegiatan.index'],
                            ['label' => 'Profil', 'route' => 'profil.index'],
                            ['label' => 'Anggota', 'route' => 'anggota.index'],
                            ['label' => 'Donasi', 'route' => 'donasi.index'],
                            ['label' => 'Perizinan', 'route' => 'perizinan.form'],
                            ['label' => 'Mitra', 'route' => 'mitra.index'],
                        ];
                    @endphp

                    @foreach ($navItems as $item)
                        <a href="{{ route($item['route']) }}"
                           class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200
                                  {{ request()->routeIs($item['route'] . '*') ? 'text-teal-700 bg-teal-50' : 'text-gray-600 hover:text-teal-700 hover:bg-gray-50' }}">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>

                {{-- Desktop Auth --}}
                <div class="hidden lg:flex items-center gap-3">
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-50 transition">
                                <div class="w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center">
                                    <span class="text-teal-700 font-bold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-700">{{ auth()->user()->name }}</span>
                                <span class="material-symbols-outlined text-[18px]! text-gray-400 transition-transform" :class="open && 'rotate-180'">expand_more</span>
                            </button>

                            <div x-show="open" @click.away="open = false" x-transition
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-1 z-50">
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                                        <span class="material-symbols-outlined text-[18px]!">dashboard</span> Panel Admin
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

                {{-- Mobile Hamburger --}}
                <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition">
                    <span class="material-symbols-outlined text-[28px]!" x-text="mobileOpen ? 'close' : 'menu'">menu</span>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
             class="lg:hidden border-t border-gray-100 bg-white">
            <div class="container mx-auto px-4 py-4 space-y-1">
                @foreach ($navItems as $item)
                    <a href="{{ route($item['route']) }}"
                       class="block px-4 py-3 rounded-lg text-sm font-semibold transition
                              {{ request()->routeIs($item['route'] . '*') ? 'text-teal-700 bg-teal-50' : 'text-gray-600 hover:bg-gray-50' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach

                <hr class="my-3 border-gray-100">

                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 rounded-lg text-sm font-semibold text-gray-600 hover:bg-gray-50">Panel Admin</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-3 rounded-lg text-sm font-semibold text-red-600 hover:bg-red-50">Keluar</button>
                    </form>
                @else
                    <div class="flex gap-3 pt-2">
                        <a href="{{ route('login') }}" class="flex-1 text-center px-4 py-3 border border-gray-200 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50">Masuk</a>
                        <a href="{{ route('register') }}" class="flex-1 text-center px-4 py-3 bg-teal-600 rounded-lg text-sm font-bold text-white hover:bg-teal-700">Daftar</a>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    {{-- ═══════════ FLASH MESSAGES ═══════════ --}}
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

    {{-- ═══════════ MAIN CONTENT ═══════════ --}}
    <main>
        {{ $slot }}
    </main>

    {{-- ═══════════ FOOTER ═══════════ --}}
    @php $profile = \App\Models\Profile::first(); @endphp
    <footer class="bg-gray-900 text-gray-300">
        {{-- Top section --}}
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                {{-- Brand --}}
                <div class="lg:col-span-1">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 mb-4">
                        <img src="{{ $profile?->logo ? asset('storage/' . $profile->logo) : asset('assets/logo.png') }}" alt="Logo YSSC" class="h-12 w-auto brightness-200">
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
                    <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-5">Menu</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('home') }}" class="text-sm hover:text-teal-400 transition">Beranda</a></li>
                        <li><a href="{{ route('berita.index') }}" class="text-sm hover:text-teal-400 transition">Berita</a></li>
                        <li><a href="{{ route('kegiatan.index') }}" class="text-sm hover:text-teal-400 transition">Kegiatan</a></li>
                        <li><a href="{{ route('profil.index') }}" class="text-sm hover:text-teal-400 transition">Profil</a></li>
                        <li><a href="{{ route('donasi.index') }}" class="text-sm hover:text-teal-400 transition">Donasi</a></li>
                    </ul>
                </div>

                {{-- Other Links --}}
                <div>
                    <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-5">Lainnya</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('anggota.index') }}" class="text-sm hover:text-teal-400 transition">Anggota</a></li>
                        <li><a href="{{ route('perizinan.form') }}" class="text-sm hover:text-teal-400 transition">Perizinan</a></li>
                        <li><a href="{{ route('perizinan.cek') }}" class="text-sm hover:text-teal-400 transition">Cek Status Perizinan</a></li>
                    </ul>
                </div>

                {{-- Contact --}}
                <div>
                    <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-5">Kontak</h4>
                    <ul class="space-y-3">
                        @if($profile?->alamat)
                            <li class="flex items-start gap-2 text-sm">
                                <span class="material-symbols-outlined text-[18px]! text-teal-400 mt-0.5">location_on</span>
                                {{ $profile->alamat }}
                            </li>
                        @endif
                        @if($profile?->email)
                            <li class="flex items-center gap-2 text-sm">
                                <span class="material-symbols-outlined text-[18px]! text-teal-400">mail</span>
                                <a href="mailto:{{ $profile->email }}" class="hover:text-teal-400 transition">{{ $profile->email }}</a>
                            </li>
                        @endif
                        @if($profile?->telepon)
                            <li class="flex items-center gap-2 text-sm">
                                <span class="material-symbols-outlined text-[18px]! text-teal-400">call</span>
                                {{ $profile->telepon }}
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="border-t border-gray-800">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-5 flex flex-col md:flex-row justify-between items-center gap-3">
                <p class="text-xs text-gray-500">&copy; {{ date('Y') }} {{ $profile?->nama_organisasi ?? 'Yayasan Seribu Satu Cita' }}. All rights reserved.</p>
                <p class="text-xs text-gray-500">Made with ❤️ for a better Indonesia</p>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
