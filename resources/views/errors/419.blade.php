<x-layouts.public>
    <x-slot:title>419 — Sesi Kadaluarsa</x-slot:title>

    <section class="min-h-[70vh] flex items-center justify-center py-20 px-4">
        <div class="text-center max-w-lg">
            <div class="relative mb-8">
                <div class="text-[160px] font-extrabold leading-none bg-gradient-to-br from-purple-400 to-purple-600 bg-clip-text text-transparent select-none">419</div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[80px]! text-purple-200/50 animate-pulse">timer_off</span>
                </div>
            </div>

            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800 mb-3">Sesi Kadaluarsa</h1>
            <p class="text-gray-500 mb-8 leading-relaxed">
                Sesi Anda telah berakhir. Silakan muat ulang halaman dan coba lagi.
            </p>

            <button onclick="window.location.reload()"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-600 to-teal-700 text-white font-bold rounded-xl hover:from-teal-700 hover:to-teal-800 shadow-lg shadow-teal-500/20 transition-all">
                <span class="material-symbols-outlined text-[18px]!">refresh</span>
                Muat Ulang
            </button>
        </div>
    </section>
</x-layouts.public>
