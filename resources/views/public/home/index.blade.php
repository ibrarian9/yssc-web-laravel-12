<x-layouts.public>
    <x-slot:title>Beranda — Yayasan Seribu Satu Cita</x-slot:title>

    {{-- ═══════════ HERO SLIDER ═══════════ --}}
    <header class="relative min-h-[85vh] flex items-center overflow-hidden" x-data="{
        current: 0,
        sliders: {{ Js::from($sliders) }},
        autoplay: null,
        init() {
            this.autoplay = setInterval(() => this.next(), 5000);
        },
        next() { this.current = (this.current + 1) % this.sliders.length; },
        prev() { this.current = (this.current - 1 + this.sliders.length) % this.sliders.length; },
    }">
        {{-- Slides --}}
        @foreach($sliders as $index => $slider)
            <div x-show="current === {{ $index }}"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 scale-105"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-500"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute inset-0">
                <img src="{{ $slider->gambar }}" class="w-full h-full object-cover" alt="{{ $slider->judul }}">
                <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-transparent"></div>
            </div>
        @endforeach

        {{-- Content --}}
        <div class="container mx-auto px-6 md:px-12 lg:px-20 relative z-10 text-white">
            <div class="max-w-2xl">
                @foreach($sliders as $index => $slider)
                    <div x-show="current === {{ $index }}" x-transition.opacity.duration.500ms>
                        <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold leading-tight tracking-tight mb-4">
                            {{ $slider->judul }}
                        </h1>
                        <p class="text-base sm:text-lg md:text-xl font-light leading-relaxed border-l-4 border-yellow-400 pl-5 py-2 mb-8 opacity-90">
                            {{ $slider->deskripsi }}
                        </p>
                        @if($slider->link)
                            <a href="{{ $slider->link }}"
                               class="inline-flex items-center gap-3 bg-gradient-to-r from-yellow-400 to-yellow-500 text-gray-900 font-bold px-8 py-3.5 rounded-full hover:from-yellow-500 hover:to-yellow-600 transition-all shadow-lg shadow-yellow-400/30 hover:shadow-xl hover:scale-105 group">
                                <span>{{ $slider->tombol_teks ?? 'Explore' }}</span>
                                <span class="material-symbols-outlined text-[18px]! group-hover:translate-x-1 transition-transform">arrow_forward</span>
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Navigation dots --}}
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 flex items-center gap-3">
            @foreach($sliders as $index => $slider)
                <button @click="current = {{ $index }}"
                        class="w-3 h-3 rounded-full transition-all duration-300"
                        :class="current === {{ $index }} ? 'bg-yellow-400 scale-125' : 'bg-white/40 hover:bg-white/70'"></button>
            @endforeach
        </div>

        {{-- Arrow buttons --}}
        <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white/10 hover:bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white transition">
            <span class="material-symbols-outlined">chevron_left</span>
        </button>
        <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white/10 hover:bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white transition">
            <span class="material-symbols-outlined">chevron_right</span>
        </button>
    </header>

    {{-- ═══════════ STATS BAR ═══════════ --}}
    <section class="relative -mt-8 z-20 mb-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-5xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-4">
                <x-public.stat-counter :value="$stats['total_donatur']" label="Total Donatur" icon="volunteer_activism" suffix="+" />
                <x-public.stat-counter :value="(int)($stats['total_donasi'] / 1000000)" label="Donasi Terkumpul" icon="payments" prefix="Rp " suffix=" Jt" />
                <x-public.stat-counter :value="$stats['kegiatan_selesai']" label="Kegiatan" icon="event_available" suffix="+" />
                <x-public.stat-counter :value="$stats['anggota_aktif']" label="Anggota Aktif" icon="groups" suffix="+" />
            </div>
        </div>
    </section>

    {{-- ═══════════ PROGRAM DONASI UNGGULAN ═══════════ --}}
    @if($programDonasi->count() > 0)
    <section class="py-16 lg:py-20 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="inline-block px-4 py-1.5 bg-teal-50 text-teal-700 text-xs font-bold uppercase tracking-widest rounded-full mb-3">Program Donasi</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-800">Program Unggulan</h2>
                <p class="text-gray-500 mt-3 max-w-xl mx-auto">Bantu kami mewujudkan program-program yang berdampak positif bagi masyarakat</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
                @foreach($programDonasi as $program)
                    <x-public.card-donasi :program="$program" />
                @endforeach
            </div>
            <div class="text-center mt-10">
                <a href="{{ route('donasi.index') }}" class="inline-flex items-center gap-2 px-6 py-3 border-2 border-teal-600 text-teal-600 font-bold rounded-full hover:bg-teal-600 hover:text-white transition-all">
                    Lihat Semua Program
                    <span class="material-symbols-outlined text-[18px]!">arrow_forward</span>
                </a>
            </div>
        </div>
    </section>
    @endif

    {{-- ═══════════ BERITA & KEGIATAN TERBARU ═══════════ --}}
    @if($beritaTerbaru->count() > 0)
    <section class="py-16 lg:py-20 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="inline-block px-4 py-1.5 bg-amber-50 text-amber-700 text-xs font-bold uppercase tracking-widest rounded-full mb-3">Berita & Kegiatan</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-800">Highlight Terbaru</h2>
                <p class="text-gray-500 mt-3 max-w-xl mx-auto">Ikuti perkembangan kegiatan dan berita terbaru dari yayasan kami</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
                @foreach($beritaTerbaru as $berita)
                    <x-public.card-berita :berita="$berita" />
                @endforeach
            </div>
            <div class="text-center mt-10">
                <a href="{{ route('berita.index') }}" class="inline-flex items-center gap-2 px-6 py-3 border-2 border-gray-300 text-gray-600 font-bold rounded-full hover:bg-gray-800 hover:text-white hover:border-gray-800 transition-all">
                    Semua Berita
                    <span class="material-symbols-outlined text-[18px]!">arrow_forward</span>
                </a>
            </div>
        </div>
    </section>
    @endif

    {{-- ═══════════ TENTANG KAMI ═══════════ --}}
    @if($profile)
    <section class="py-16 lg:py-20 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto flex flex-col lg:flex-row items-center gap-12">
                <div class="lg:w-1/2">
                    <img src="https://images.unsplash.com/photo-1559027615-cd4628902d4a?q=80&w=1000"
                         class="rounded-2xl shadow-xl w-full object-cover h-80 lg:h-[400px]" alt="Tentang Kami">
                </div>
                <div class="lg:w-1/2">
                    <span class="inline-block px-4 py-1.5 bg-teal-50 text-teal-700 text-xs font-bold uppercase tracking-widest rounded-full mb-4">Tentang Kami</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-800 mb-4">{{ $profile->nama_organisasi }}</h2>
                    <p class="text-gray-500 leading-relaxed mb-6">{{ Str::limit($profile->deskripsi, 300) }}</p>
                    <div class="space-y-3 mb-8">
                        <h4 class="font-bold text-gray-700">Visi Kami:</h4>
                        <p class="text-sm text-gray-500 italic leading-relaxed">{{ Str::limit($profile->visi, 200) }}</p>
                    </div>
                    <a href="{{ route('profil.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-600 to-teal-700 text-white font-bold rounded-full hover:from-teal-700 hover:to-teal-800 shadow-lg shadow-teal-500/20 hover:shadow-xl hover:scale-[1.02] transition-all">
                        Selengkapnya
                        <span class="material-symbols-outlined text-[18px]!">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ═══════════ CTA DONASI ═══════════ --}}
    <section class="py-16 lg:py-20 bg-gradient-to-r from-teal-700 via-teal-600 to-emerald-600 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <polygon points="0,100 100,0 100,100" fill="currentColor" class="text-black"/>
            </svg>
        </div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-4">Jadilah Bagian dari Perubahan</h2>
            <p class="text-teal-100 text-lg max-w-2xl mx-auto mb-8">Setiap donasi Anda, sekecil apapun, akan memberikan dampak besar bagi pendidikan dan masa depan anak-anak Indonesia.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('donasi.index') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-yellow-400 text-gray-900 font-bold rounded-full hover:bg-yellow-300 shadow-xl shadow-yellow-400/30 hover:scale-105 transition-all text-lg">
                    <span class="material-symbols-outlined">favorite</span> Donasi Sekarang
                </a>
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white/10 backdrop-blur-sm text-white font-bold rounded-full hover:bg-white/20 border border-white/20 transition-all text-lg">
                    <span class="material-symbols-outlined">group_add</span> Gabung Relawan
                </a>
            </div>
        </div>
    </section>

</x-layouts.public>
