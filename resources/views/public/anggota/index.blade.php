<x-layouts.public>
    <x-slot:title>Anggota & Pengurus — Yayasan Seribu Satu Cita</x-slot:title>
    <x-slot:metaDescription>Kenali tim dan pengurus yang menggerakkan Yayasan Seribu Satu Cita.</x-slot:metaDescription>

    {{-- Hero --}}
    <x-public.page-hero page="anggota" badge="Tim Kami" default-title="Anggota & Pengurus" default-subtitle="Orang-orang berdedikasi yang bekerja di balik layar untuk mewujudkan misi sosial yayasan kami">
        {{-- Stats --}}
        <div class="flex justify-center gap-8 mt-10">
            @php $totalMembers = $divisi->sum(fn($d) => $d->anggotaAktif->count()); @endphp
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-extrabold text-teal-400">{{ $totalMembers }}</div>
                <div class="text-xs text-gray-300 uppercase tracking-wider mt-1">Anggota Aktif</div>
            </div>
            <div class="w-px bg-white/20"></div>
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-extrabold text-amber-400">{{ $divisi->count() }}</div>
                <div class="text-xs text-gray-300 uppercase tracking-wider mt-1">Divisi</div>
            </div>
        </div>
    </x-public.page-hero>

    {{-- Divisi Tabs + Content --}}
    <section class="py-12 lg:py-16 bg-gray-50" x-data="{ activeTab: {{ $divisi->first()?->id ?? 0 }} }">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
            {{-- Tabs --}}
            <div class="flex flex-wrap justify-center gap-2 mb-12">
                @foreach($divisi as $div)
                    <button @click="activeTab = {{ $div->id }}"
                            class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300"
                            :class="activeTab === {{ $div->id }}
                                ? 'bg-gradient-to-r from-teal-600 to-teal-700 text-white shadow-lg shadow-teal-500/25 scale-105'
                                : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200 hover:border-teal-300'">
                        {{ $div->nama }}
                        <span class="inline-flex items-center justify-center ml-1.5 w-5 h-5 text-[10px] rounded-full"
                              :class="activeTab === {{ $div->id }} ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-500'">{{ $div->anggotaAktif->count() }}</span>
                    </button>
                @endforeach
            </div>

            {{-- Content per divisi --}}
            @foreach($divisi as $div)
                <div x-show="activeTab === {{ $div->id }}"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0">

                    @if($div->deskripsi)
                        <div class="text-center max-w-2xl mx-auto mb-10">
                            <p class="text-gray-500 leading-relaxed">{{ $div->deskripsi }}</p>
                        </div>
                    @endif

                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 md:gap-6">
                        @foreach($div->anggotaAktif as $anggota)
                            <x-public.card-anggota :anggota="$anggota" />
                        @endforeach
                    </div>

                    @if($div->anggotaAktif->count() === 0)
                        <div class="text-center py-20">
                            <div class="w-20 h-20 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                                <span class="material-symbols-outlined text-[40px]! text-gray-300">group_off</span>
                            </div>
                            <p class="text-gray-400 font-medium">Belum ada anggota di divisi ini.</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-16 bg-gradient-to-r from-teal-700 to-teal-600 text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl md:text-3xl font-extrabold mb-4">Ingin Bergabung dengan Tim Kami?</h2>
            <p class="text-teal-100 max-w-lg mx-auto mb-8">Kami selalu mencari individu yang berdedikasi dan bersemangat untuk membuat perubahan sosial.</p>
            <a href="{{ route('mitra.index') }}" class="inline-flex items-center gap-2 px-8 py-3.5 bg-white text-teal-700 font-bold rounded-xl hover:bg-teal-50 shadow-lg transition-all">
                <span class="material-symbols-outlined text-[18px]!">handshake</span>
                Jadilah Mitra Kami
            </a>
        </div>
    </section>
</x-layouts.public>
