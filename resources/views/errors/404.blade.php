<x-layouts.public>
    <x-slot:title>404 — Halaman Tidak Ditemukan</x-slot:title>

    <section class="min-h-[70vh] flex items-center justify-center py-20 px-4">
        <div class="text-center max-w-lg">
            {{-- Illustration --}}
            <div class="relative mb-8">
                <div class="text-[160px] font-extrabold leading-none bg-gradient-to-br from-teal-400 to-teal-700 bg-clip-text text-transparent select-none">404</div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[80px]! text-teal-200/50 animate-pulse">explore_off</span>
                </div>
            </div>

            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800 mb-3">Halaman Tidak Ditemukan</h1>
            <p class="text-gray-500 mb-8 leading-relaxed">
                Maaf, halaman yang Anda cari tidak tersedia atau telah dipindahkan.
                Silakan kembali ke beranda atau gunakan menu navigasi.
            </p>

            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('home') }}"
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-600 to-teal-700 text-white font-bold rounded-xl hover:from-teal-700 hover:to-teal-800 shadow-lg shadow-teal-500/20 transition-all hover:shadow-xl">
                    <span class="material-symbols-outlined text-[18px]!">home</span>
                    Ke Beranda
                </a>
                <a href="{{ route('donasi.index') }}"
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 border-2 border-gray-200 text-gray-600 font-bold rounded-xl hover:border-teal-400 hover:text-teal-700 transition-all">
                    <span class="material-symbols-outlined text-[18px]!">volunteer_activism</span>
                    Program Donasi
                </a>
            </div>
        </div>
    </section>
</x-layouts.public>
