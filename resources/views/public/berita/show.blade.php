<x-layouts.public>
    <x-slot:title>{{ $berita->judul }} — Yayasan Seribu Satu Cita</x-slot:title>
    <x-slot:metaDescription>{{ $berita->excerpt ?? Str::limit(strip_tags($berita->konten), 160) }}</x-slot:metaDescription>

    {{-- Hero Image --}}
    <div class="relative h-64 md:h-96 overflow-hidden">
        <img src="{{ $berita->thumbnail ?? 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=1600' }}"
             class="w-full h-full object-cover" alt="{{ $berita->judul }}">
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
    </div>

    <section class="py-10 lg:py-14">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
            <div class="flex flex-col lg:flex-row gap-10">
                {{-- Main content --}}
                <article class="lg:w-2/3">
                    {{-- Breadcrumb --}}
                    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-6">
                        <a href="{{ route('home') }}" class="hover:text-teal-600 transition">Beranda</a>
                        <span class="material-symbols-outlined text-[14px]!">chevron_right</span>
                        <a href="{{ route($berita->tipe === 'kegiatan' ? 'kegiatan.index' : 'berita.index') }}" class="hover:text-teal-600 transition">
                            {{ $berita->tipe === 'kegiatan' ? 'Kegiatan' : 'Berita' }}
                        </a>
                        <span class="material-symbols-outlined text-[14px]!">chevron_right</span>
                        <span class="text-gray-600 line-clamp-1">{{ Str::limit($berita->judul, 40) }}</span>
                    </nav>

                    {{-- Title --}}
                    <h1 class="text-2xl md:text-4xl font-extrabold text-gray-800 leading-tight mb-4">{{ $berita->judul }}</h1>

                    {{-- Meta --}}
                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-400 mb-8 pb-6 border-b border-gray-100">
                        @if($berita->kategori)
                            <span class="px-3 py-1 text-xs font-bold rounded-md text-white" style="background-color: {{ $berita->kategori->warna }}">
                                {{ $berita->kategori->nama }}
                            </span>
                        @endif
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]!">calendar_today</span>
                            {{ $berita->created_at->translatedFormat('d F Y') }}
                        </div>
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]!">person</span>
                            {{ $berita->penulis->name ?? 'Admin' }}
                        </div>
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]!">visibility</span>
                            {{ number_format($berita->views) }} views
                        </div>
                    </div>

                    {{-- Kegiatan Info --}}
                    @if($berita->tipe === 'kegiatan' && ($berita->tanggal_kegiatan || $berita->lokasi))
                        <div class="bg-amber-50 border border-amber-100 rounded-xl p-4 mb-8 flex flex-wrap gap-6">
                            @if($berita->tanggal_kegiatan)
                                <div class="flex items-center gap-2 text-sm">
                                    <span class="material-symbols-outlined text-amber-600 text-[20px]!">event</span>
                                    <div>
                                        <p class="text-xs text-amber-600 font-semibold">Tanggal</p>
                                        <p class="text-gray-700 font-medium">{{ $berita->tanggal_kegiatan->translatedFormat('d F Y') }}</p>
                                    </div>
                                </div>
                            @endif
                            @if($berita->lokasi)
                                <div class="flex items-center gap-2 text-sm">
                                    <span class="material-symbols-outlined text-amber-600 text-[20px]!">location_on</span>
                                    <div>
                                        <p class="text-xs text-amber-600 font-semibold">Lokasi</p>
                                        <p class="text-gray-700 font-medium">{{ $berita->lokasi }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Body --}}
                    <div class="prose prose-lg max-w-none prose-headings:text-gray-800 prose-p:text-gray-600 prose-a:text-teal-600 prose-img:rounded-xl">
                        {!! $berita->konten !!}
                    </div>

                    {{-- Share --}}
                    <div class="mt-10 pt-6 border-t border-gray-100">
                        <p class="text-sm font-semibold text-gray-500 mb-3">Bagikan:</p>
                        <div class="flex gap-2">
                            <a href="https://wa.me/?text={{ urlencode($berita->judul . ' ' . url()->current()) }}" target="_blank" class="w-10 h-10 bg-green-50 hover:bg-green-100 rounded-xl flex items-center justify-center text-green-600 transition">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            </a>
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($berita->judul) }}&url={{ urlencode(url()->current()) }}" target="_blank" class="w-10 h-10 bg-blue-50 hover:bg-blue-100 rounded-xl flex items-center justify-center text-blue-500 transition">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-10 h-10 bg-blue-50 hover:bg-blue-100 rounded-xl flex items-center justify-center text-blue-700 transition">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385h-3.047v-3.47h3.047v-2.642c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953h-1.514c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385c5.737-.9 10.125-5.864 10.125-11.854z"/></svg>
                            </a>
                        </div>
                    </div>
                </article>

                {{-- Sidebar --}}
                <aside class="lg:w-1/3 space-y-6">
                    {{-- Related articles --}}
                    @if($related->count() > 0)
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Artikel Terkait</h3>
                            <div class="space-y-4">
                                @foreach($related as $item)
                                    <a href="{{ route($item->tipe === 'kegiatan' ? 'kegiatan.show' : 'berita.show', $item->slug) }}"
                                       class="flex gap-3 group">
                                        <img src="{{ $item->thumbnail }}" class="w-20 h-16 object-cover rounded-lg shrink-0" alt="{{ $item->judul }}">
                                        <div>
                                            <h4 class="text-sm font-semibold text-gray-700 line-clamp-2 group-hover:text-teal-600 transition">{{ $item->judul }}</h4>
                                            <p class="text-xs text-gray-400 mt-1">{{ $item->created_at->translatedFormat('d M Y') }}</p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- CTA donate --}}
                    <div class="bg-gradient-to-br from-teal-600 to-teal-700 rounded-2xl p-6 text-white">
                        <h3 class="font-bold text-lg mb-2">Dukung Kegiatan Kami</h3>
                        <p class="text-teal-100 text-sm mb-4">Kontribusi Anda membantu kami menjalankan program-program yang bermanfaat.</p>
                        <a href="{{ route('donasi.index') }}" class="block text-center py-2.5 bg-yellow-400 text-gray-900 font-bold rounded-xl hover:bg-yellow-300 transition">
                            Donasi Sekarang
                        </a>
                    </div>
                </aside>
            </div>
        </div>
    </section>
</x-layouts.public>
