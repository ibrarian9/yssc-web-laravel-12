@props(['berita'])

<article class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group border border-gray-100">
    <div class="overflow-hidden h-48 sm:h-52 relative">
        <img src="{{ str_starts_with($berita->thumbnail, 'http') ? $berita->thumbnail : asset('storage/'. $berita->thumbnail) }}"
             class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
             alt="{{ $berita->judul }}" loading="lazy">
        @if($berita->kategori)
            <span class="absolute top-3 left-3 px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-md text-white"
                  style="background-color: {{ $berita->kategori->warna }}">
                {{ $berita->kategori->nama }}
            </span>
        @endif
        @if($berita->tipe === 'kegiatan')
            <span class="absolute top-3 right-3 px-2 py-1 text-[10px] font-bold uppercase tracking-wider rounded-md bg-amber-500 text-white">
                Kegiatan
            </span>
        @endif
    </div>
    <div class="p-5">
        <h3 class="text-base font-bold text-gray-800 leading-snug mb-3 line-clamp-2 group-hover:text-teal-700 transition">
            {{ $berita->judul }}
        </h3>
        <p class="text-sm text-gray-500 line-clamp-2 mb-4">{{ Str::limit(strip_tags($berita->konten), 120) }}</p>
        <div class="flex justify-between items-center text-xs text-gray-400 font-medium">
            <div class="flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]!">calendar_today</span>
                {{ $berita->created_at->translatedFormat('d M Y') }}
            </div>
            @if($berita->lokasi)
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]!">location_on</span>
                    {{ $berita->lokasi }}
                </div>
            @endif
        </div>
        <a href="{{ route($berita->tipe === 'kegiatan' ? 'kegiatan.show' : 'berita.show', $berita->slug) }}"
           class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-teal-600 hover:text-teal-800 transition group/link">
            Baca Selengkapnya
            <span class="material-symbols-outlined text-[16px]! group-hover/link:translate-x-1 transition-transform">arrow_forward</span>
        </a>
    </div>
</article>
