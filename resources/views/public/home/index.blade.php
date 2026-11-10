<x-layouts.public>
    <x-slot:title>Beranda — Yayasan Seribu Satu Cita</x-slot:title>
    @php $isDonasiActive = $profile?->is_donasi_enabled ?? true; @endphp

    {{-- ═══════════ HERO SLIDER ═══════════ --}}
    <header class="relative min-h-[500px] sm:min-h-[580px] lg:min-h-[82dvh] py-14 pb-20 sm:py-20 flex items-center overflow-hidden"
        x-data="{
            current: 0,
            total: {{ $sliders->count() }},
            autoplay: null,
            touchStartX: 0,
            init() {
                this.startAutoplay();
            },
            startAutoplay() {
                this.autoplay = setInterval(() => this.next(), 6000);
            },
            resetAutoplay() {
                clearInterval(this.autoplay);
                this.startAutoplay();
            },
            next() { if (this.total > 0) this.current = (this.current + 1) % this.total; },
            prev() { if (this.total > 0) this.current = (this.current - 1 + this.total) % this.total; },
            goTo(i) { this.current = i; this.resetAutoplay(); },
            handleTouchEnd(endX) {
                const diff = this.touchStartX - endX;
                if (Math.abs(diff) > 45) {
                    if (diff > 0) this.next(); else this.prev();
                    this.resetAutoplay();
                }
            }
        }"
        @touchstart.passive="touchStartX = $event.changedTouches[0].screenX"
        @touchend.passive="handleTouchEnd($event.changedTouches[0].screenX)">
        {{-- Stacked slides — all in DOM, opacity-based cross-fade --}}
        @foreach($sliders as $index => $slider)
            <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                 :class="current === {{ $index }} ? 'opacity-100 z-[1]' : 'opacity-0 z-0'">
                <img src="{{ $slider->gambar }}"
                     class="w-full h-full object-cover transition-transform duration-[8000ms] ease-out"
                     :class="current === {{ $index }} ? 'scale-110' : 'scale-100'"
                     alt="{{ $slider->judul }}"
                     @if($index === 0) fetchpriority="high" @else loading="lazy" @endif>
                <div class="absolute inset-0 bg-gradient-to-r from-black/75 via-black/45 to-black/15"></div>
            </div>
        @endforeach

        {{-- Text content — cross-fade with slight upward motion --}}
        <div class="container mx-auto px-5 sm:px-16 md:px-20 lg:px-24 relative z-10 text-white">
            <div class="max-w-2xl relative">
                @foreach($sliders as $index => $slider)
                    <div class="transition-all duration-700 ease-out"
                         :class="current === {{ $index }}
                             ? 'opacity-100 translate-y-0 relative'
                             : 'opacity-0 translate-y-4 absolute inset-0 pointer-events-none'">
                        <h1 class="text-3xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold leading-tight tracking-tight mb-4">
                            {{ $slider->judul }}
                        </h1>
                        <p class="text-sm sm:text-lg md:text-xl font-light leading-relaxed border-l-4 border-yellow-400 pl-4 sm:pl-5 py-1.5 sm:py-2 mb-6 sm:mb-8 opacity-90">
                            {{ $slider->deskripsi }}
                        </p>
                        @if($slider->link && ($isDonasiActive || !str_contains($slider->link, '/donasi')))
                            <a href="{{ $slider->link }}" @if(str_starts_with($slider->link, '/')) wire:navigate.hover @endif
                               class="inline-flex items-center gap-3 min-h-[44px] bg-gradient-to-r from-yellow-400 to-yellow-500 text-gray-900 font-bold px-6 sm:px-8 py-3 sm:py-3.5 rounded-full hover:from-yellow-500 hover:to-yellow-600 transition-all shadow-lg shadow-yellow-400/30 hover:shadow-xl hover:scale-105 group text-sm sm:text-base">
                                <span>{{ $slider->tombol_teks ?? 'Explore' }}</span>
                                <span class="material-symbols-outlined text-[18px]! group-hover:translate-x-1 transition-transform">arrow_forward</span>
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Navigation dots with accessible touch hit-boxes --}}
        <div class="absolute bottom-10 sm:bottom-8 left-1/2 -translate-x-1/2 z-10 flex items-center gap-1">
            @foreach($sliders as $index => $slider)
                <button type="button" @click="goTo({{ $index }})"
                        class="p-2 flex items-center justify-center cursor-pointer"
                        aria-label="Slide {{ $index + 1 }}">
                    <span class="relative block h-2.5 rounded-full transition-all duration-500 overflow-hidden"
                          :class="current === {{ $index }} ? 'w-9 bg-yellow-400/30' : 'w-2.5 bg-white/40 hover:bg-white/60'">
                        <span class="absolute inset-0 rounded-full bg-yellow-400 origin-left transition-transform duration-500"
                              :class="current === {{ $index }} ? 'scale-x-100' : 'scale-x-0'"></span>
                    </span>
                </button>
            @endforeach
        </div>

        {{-- Side Arrow buttons (Tablet & Desktop, hidden on narrow phones so text never overlaps; swipeable on phones) --}}
        <button type="button" @click="prev(); resetAutoplay()" aria-label="Slide Sebelumnya"
                class="hidden sm:flex absolute left-4 md:left-6 top-1/2 -translate-y-1/2 z-10 w-11 h-11 md:w-12 md:h-12 bg-white/10 hover:bg-white/25 backdrop-blur-md rounded-full items-center justify-center text-white transition-all duration-300 hover:scale-110 border border-white/10 cursor-pointer">
            <span class="material-symbols-outlined text-[22px]!">chevron_left</span>
        </button>
        <button type="button" @click="next(); resetAutoplay()" aria-label="Slide Berikutnya"
                class="hidden sm:flex absolute right-4 md:right-6 top-1/2 -translate-y-1/2 z-10 w-11 h-11 md:w-12 md:h-12 bg-white/10 hover:bg-white/25 backdrop-blur-md rounded-full items-center justify-center text-white transition-all duration-300 hover:scale-110 border border-white/10 cursor-pointer">
            <span class="material-symbols-outlined text-[22px]!">chevron_right</span>
        </button>
    </header>

    {{-- ═══════════ STATS BAR ═══════════ --}}
    <section class="relative -mt-8 z-20 mb-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-5xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-4">
                @if($isDonasiActive)
                    <x-public.stat-counter :value="$stats['total_donatur']" label="Total Donatur" icon="volunteer_activism" />
                    <x-public.stat-counter :value="$stats['total_donasi']" label="Donasi Terkumpul" icon="payments" prefix="Rp " />
                @else
                    <x-public.stat-counter :value="$stats['relawan_aktif']" label="Relawan Aktif" icon="diversity_3" />
                    <x-public.stat-counter :value="$stats['mitra_aktif']" label="Mitra Aktif" icon="handshake" />
                @endif
                <x-public.stat-counter :value="$stats['kegiatan_selesai']" label="Kegiatan" icon="event_available" />
                <x-public.stat-counter :value="$stats['anggota_aktif']" label="Anggota Aktif" icon="groups" />
            </div>
        </div>
    </section>

    {{-- ═══════════ PROGRAM DONASI UNGGULAN ═══════════ --}}
    @if($isDonasiActive && $programDonasi->count() > 0)
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
                <a href="{{ route('donasi.index') }}" wire:navigate.hover class="inline-flex items-center gap-2 px-6 py-3 border-2 border-teal-600 text-teal-600 font-bold rounded-full hover:bg-teal-600 hover:text-white transition-all">
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
                <a href="{{ route('berita.index') }}" wire:navigate.hover class="inline-flex items-center gap-2 px-6 py-3 border-2 border-gray-300 text-gray-600 font-bold rounded-full hover:bg-gray-800 hover:text-white hover:border-gray-800 transition-all">
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
                         class="rounded-2xl shadow-xl w-full object-cover h-80 lg:h-[400px]" alt="Tentang Kami" loading="lazy" decoding="async">
                </div>
                <div class="lg:w-1/2">
                    <span class="inline-block px-4 py-1.5 bg-teal-50 text-teal-700 text-xs font-bold uppercase tracking-widest rounded-full mb-4">Tentang Kami</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-800 mb-4">{{ $profile->nama_organisasi }}</h2>
                    <p class="text-gray-500 leading-relaxed mb-6">{{ Str::limit($profile->deskripsi, 300) }}</p>
                    <div class="space-y-3 mb-8">
                        <h4 class="font-bold text-gray-700">Visi Kami:</h4>
                        <p class="text-sm text-gray-600 not-italic leading-relaxed">{{ Str::limit($profile->visi, 200) }}</p>
                    </div>
                    <a href="{{ route('profil.index') }}" wire:navigate.hover class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-600 to-teal-700 text-white font-bold rounded-full hover:from-teal-700 hover:to-teal-800 shadow-lg shadow-teal-500/20 hover:shadow-xl hover:scale-[1.02] transition-all">
                        Selengkapnya
                        <span class="material-symbols-outlined text-[18px]!">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ═══════════ CTA ═══════════ --}}
    <section class="py-16 lg:py-20 bg-gradient-to-r from-teal-700 via-teal-600 to-emerald-600 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <polygon points="0,100 100,0 100,100" fill="currentColor" class="text-black"/>
            </svg>
        </div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-4">Jadilah Bagian dari Perubahan</h2>
            <p class="text-teal-100 text-lg max-w-2xl mx-auto mb-8">
                {{ $isDonasiActive ? 'Setiap donasi Anda, sekecil apapun, akan memberikan dampak besar bagi pendidikan dan masa depan anak-anak Indonesia.' : 'Bergabunglah bersama kami untuk menciptakan dampak positif bagi pendidikan dan masa depan anak-anak Indonesia.' }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @if($isDonasiActive)
                    <a href="{{ route('donasi.index') }}" wire:navigate.hover class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-yellow-400 text-gray-900 font-bold rounded-full hover:bg-yellow-300 shadow-xl shadow-yellow-400/30 hover:scale-105 transition-all text-lg">
                        <span class="material-symbols-outlined">favorite</span> Donasi Sekarang
                    </a>
                @endif
                <a href="{{ route('relawan.index') }}" wire:navigate.hover class="inline-flex items-center justify-center gap-2 px-8 py-4 {{ $isDonasiActive ? 'bg-white/10 backdrop-blur-sm text-white hover:bg-white/20 border border-white/20' : 'bg-yellow-400 text-gray-900 hover:bg-yellow-300 shadow-xl shadow-yellow-400/30 hover:scale-105' }} font-bold rounded-full transition-all text-lg">
                    <span class="material-symbols-outlined">group_add</span> Gabung Relawan
                </a>
            </div>
        </div>
    </section>

</x-layouts.public>
