<div>
    {{-- Filters --}}
    <div class="mb-8 space-y-4">
        {{-- Tabs --}}
        <div class="flex flex-wrap gap-2">
            <button wire:click="setTipe('')"
                class="px-5 py-2 rounded-full text-sm font-semibold transition-all
                           {{ $tipe === '' ? 'bg-teal-600 text-white shadow-md' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                Semua
            </button>
            <button wire:click="setTipe('berita')"
                class="px-5 py-2 rounded-full text-sm font-semibold transition-all
                           {{ $tipe === 'berita' ? 'bg-teal-600 text-white shadow-md' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                Berita
            </button>
            <button wire:click="setTipe('kegiatan')"
                class="px-5 py-2 rounded-full text-sm font-semibold transition-all
                           {{ $tipe === 'kegiatan' ? 'bg-amber-500 text-white shadow-md' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                Kegiatan
            </button>
        </div>

        {{-- Search & Filter row --}}
        <div class="flex flex-col lg:flex-row gap-4 items-stretch mb-8">

            {{-- Search Input Area (Dibuat Timbul) --}}
            <div class="flex-1 relative group">
                <span
                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[22px]! group-focus-within:text-teal-600 transition-colors duration-200">
                    search
                </span>

                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari berita atau kegiatan..."
                    class="w-full pl-12 pr-4 py-3.5 bg-white border-0 rounded-2xl text-base shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.12)] focus:ring-4 focus:ring-teal-500/10 focus:shadow-teal-500/5 transition-all duration-300 placeholder:text-gray-400">

                {{-- Loading Indicator kecil agar lebih interaktif --}}
                <div wire:loading wire:target="search" class="absolute right-4 top-1/2 -translate-y-1/2">
                    <div class="w-4 h-4 border-2 border-teal-500 border-t-transparent rounded-full animate-spin"></div>
                </div>
            </div>

            {{-- Filter Group (Diselaraskan tingginya) --}}
            <div class="flex flex-col sm:flex-row gap-3">
                <select wire:model.live="kategoriId"
                    class="px-5 py-3.5 border-0 bg-white rounded-2xl text-sm font-medium shadow-[0_8px_30px_rgb(0,0,0,0.04)] focus:ring-4 focus:ring-teal-500/10 cursor-pointer hover:bg-gray-50 transition-all">
                    <option value="">Kategori</option>
                    @foreach($kategoriList as $kat)
                    <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                    @endforeach
                </select>

                <select wire:model.live="sort"
                    class="px-5 py-3.5 border-0 bg-white rounded-2xl text-sm font-medium shadow-[0_8px_30px_rgb(0,0,0,0.04)] focus:ring-4 focus:ring-teal-500/10 cursor-pointer hover:bg-gray-50 transition-all">
                    <option value="terbaru">Terbaru</option>
                    <option value="terpopuler">Terpopuler</option>
                    <option value="terlama">Terlama</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Loading --}}
    <div wire:loading class="text-center py-8">
        <div class="inline-flex items-center gap-2 text-teal-600">
            <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none" />
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
            </svg>
            Memuat...
        </div>
    </div>

    {{-- Grid --}}
    <div wire:loading.remove>
        @if($items->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($items as $berita)
            <x-public.card-berita :berita="$berita" />
            @endforeach
        </div>

        <div class="mt-10">
            {{ $items->links() }}
        </div>
        @else
        <div class="text-center py-16">
            <span class="material-symbols-outlined text-[64px]! text-gray-300 mb-4">article</span>
            <h3 class="text-xl font-bold text-gray-400 mb-2">Tidak ada hasil</h3>
            <p class="text-gray-400">Coba ubah filter atau kata kunci pencarian Anda.</p>
        </div>
        @endif
    </div>
</div>