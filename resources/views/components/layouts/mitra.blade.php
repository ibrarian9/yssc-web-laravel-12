<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Mitra Panel' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="h-full bg-gray-50 font-sans">
    <div class="flex h-full">
        {{-- Sidebar --}}
        <aside class="w-56 bg-gradient-to-b from-emerald-900 via-emerald-800 to-emerald-900 text-white flex flex-col shrink-0">
            <div class="px-5 py-5 border-b border-emerald-700/50">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-emerald-500/30 rounded-lg flex items-center justify-center">
                        <span class="material-symbols-outlined text-[20px]! text-emerald-300">handshake</span>
                    </div>
                    <div>
                        <div class="text-sm font-extrabold">Mitra Panel</div>
                        <div class="text-[10px] text-emerald-400 uppercase tracking-wider">Dashboard</div>
                    </div>
                </div>
            </div>

            <nav class="px-3 py-4 space-y-1 flex-1 overflow-y-auto">
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
                            <span class="text-[10px] font-bold text-emerald-500 uppercase tracking-widest">{{ $item['label'] }}</span>
                        </div>
                    @else
                        @php $isActive = request()->routeIs($item['prefix'] ?? $item['route']); @endphp
                        <a href="{{ route($item['route']) }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all {{ $isActive ? 'bg-emerald-500/20 text-white font-bold' : 'text-emerald-300 hover:bg-emerald-700/30 hover:text-white' }}">
                            <span class="material-symbols-outlined text-[20px]! {{ $isActive ? 'text-emerald-400' : '' }}">{{ $item['icon'] }}</span>
                            {{ $item['label'] }}
                        </a>
                    @endif
                @endforeach
            </nav>

            {{-- Footer --}}
            <div class="px-3 py-4 border-t border-emerald-700/50">
                <a href="{{ route('home') }}" class="flex items-center gap-2 px-3 py-2 text-xs text-emerald-400 hover:text-white transition rounded-lg hover:bg-emerald-700/30">
                    <span class="material-symbols-outlined text-[16px]!">open_in_new</span>Lihat Website
                </a>
            </div>
        </aside>

        {{-- Main --}}
        <div class="flex-1 flex flex-col min-h-0">
            {{-- Header --}}
            <header class="bg-white shadow-sm border-b border-gray-100 px-6 py-3 flex items-center justify-between shrink-0">
                <h1 class="text-lg font-bold text-gray-800">{{ $header ?? 'Dashboard' }}</h1>
                <div class="flex items-center gap-3">
                    @auth
                        <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                        <div class="w-8 h-8 bg-emerald-600 text-white rounded-full flex items-center justify-center text-xs font-bold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="text-xs text-gray-400 hover:text-red-500 transition">Logout</button>
                        </form>
                    @endauth
                </div>
            </header>

            {{-- Content --}}
            <main class="flex-1 overflow-y-auto p-6">
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
