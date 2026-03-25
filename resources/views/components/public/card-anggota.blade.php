@props(['anggota'])

<div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-500 border border-gray-100 overflow-hidden group">
    {{-- Photo --}}
    <div class="relative aspect-square overflow-hidden bg-gray-100">
        @if($anggota->foto)
            <img src="{{ asset('storage/'. $anggota->foto) }}" alt="{{ $anggota->nama }}"
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
        @else
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-teal-400 via-teal-500 to-teal-600 text-white text-5xl font-bold">
                {{ substr($anggota->nama, 0, 1) }}
            </div>
        @endif
        {{-- Gradient overlay on hover --}}
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-gray-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

        {{-- Social links overlay --}}
        @if($anggota->linkedin || $anggota->instagram || $anggota->email)
            <div class="absolute bottom-3 left-0 right-0 flex justify-center gap-2 opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-500">
                @if($anggota->linkedin)
                    <a href="{{ $anggota->linkedin }}" target="_blank" class="w-9 h-9 bg-white/90 backdrop-blur-sm hover:bg-teal-500 hover:text-white rounded-full flex items-center justify-center transition text-gray-700 shadow-lg">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                @endif
                @if($anggota->instagram)
                    <a href="{{ $anggota->instagram }}" target="_blank" class="w-9 h-9 bg-white/90 backdrop-blur-sm hover:bg-teal-500 hover:text-white rounded-full flex items-center justify-center transition text-gray-700 shadow-lg">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                @endif
                @if($anggota->email)
                    <a href="mailto:{{ $anggota->email }}" class="w-9 h-9 bg-white/90 backdrop-blur-sm hover:bg-teal-500 hover:text-white rounded-full flex items-center justify-center transition text-gray-700 shadow-lg">
                        <span class="material-symbols-outlined text-[16px]!">mail</span>
                    </a>
                @endif
            </div>
        @endif
    </div>

    {{-- Info --}}
    <div class="p-5">
        <h4 class="font-bold text-gray-800 text-base mb-0.5 group-hover:text-teal-600 transition-colors">{{ $anggota->nama }}</h4>
        <p class="text-sm text-teal-600 font-semibold">{{ $anggota->jabatan }}</p>
        <p class="text-xs text-gray-400 mt-0.5">{{ $anggota->divisi->nama }}</p>
    </div>
</div>
