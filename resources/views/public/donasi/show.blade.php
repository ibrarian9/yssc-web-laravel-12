<x-layouts.public>
    <x-slot:title>{{ $program->judul }} — Donasi</x-slot:title>

    @php
        $terkumpul = $program->donasiSuccess()->sum('nominal');
        $persentase = $program->target_nominal > 0 ? min(100, round(($terkumpul / $program->target_nominal) * 100, 1)) : 0;
        $sisaHari = $program->tanggal_selesai ? max(0, now()->diffInDays($program->tanggal_selesai, false)) : null;
        $jumlahDonatur = $program->donasiSuccess()->count();
    @endphp

    {{-- Hero --}}
    <div class="relative h-64 md:h-80 overflow-hidden">
        <img src="{{ $program->thumbnail ?? 'https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?q=80&w=1600' }}"
             class="w-full h-full object-cover" alt="{{ $program->judul }}">
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
    </div>

    <section class="py-10 lg:py-14">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
            <div class="flex flex-col lg:flex-row gap-10">
                {{-- Main --}}
                <div class="lg:w-2/3">
                    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-6">
                        <a href="{{ route('home') }}" class="hover:text-teal-600 transition">Beranda</a>
                        <span class="material-symbols-outlined text-[14px]!">chevron_right</span>
                        <a href="{{ route('donasi.index') }}" class="hover:text-teal-600 transition">Donasi</a>
                        <span class="material-symbols-outlined text-[14px]!">chevron_right</span>
                        <span class="text-gray-600">{{ Str::limit($program->judul, 40) }}</span>
                    </nav>

                    @if($program->is_mendesak)
                        <div class="bg-red-50 border border-red-100 rounded-xl p-3 mb-4 flex items-center gap-2 text-red-700 text-sm font-semibold">
                            <span class="material-symbols-outlined text-[18px]!">warning</span> Program ini bersifat mendesak!
                        </div>
                    @endif

                    <h1 class="text-2xl md:text-4xl font-extrabold text-gray-800 leading-tight mb-6">{{ $program->judul }}</h1>

                    <div class="prose prose-lg max-w-none prose-p:text-gray-600 mb-10">
                        {!! $program->deskripsi !!}
                    </div>

                    {{-- Recent donors --}}
                    @if($donasiTerbaru->count() > 0)
                        <div class="border-t border-gray-100 pt-8">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Donatur Terbaru</h3>
                            <div class="space-y-3">
                                @foreach($donasiTerbaru as $d)
                                    <div class="flex items-center gap-3 bg-gray-50 rounded-xl p-3">
                                        <div class="w-10 h-10 bg-teal-100 rounded-full flex items-center justify-center shrink-0">
                                            <span class="text-teal-700 font-bold text-sm">{{ substr($d->nama_tampil, 0, 1) }}</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-700">{{ $d->nama_tampil }}</p>
                                            <p class="text-xs text-gray-400">{{ $d->created_at->diffForHumans() }}</p>
                                        </div>
                                        <p class="text-sm font-bold text-teal-600 shrink-0">Rp {{ number_format($d->nominal, 0, ',', '.') }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Sticky sidebar --}}
                <div class="lg:w-1/3">
                    <div class="lg:sticky lg:top-24 space-y-4">
                        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                            <div class="mb-4">
                                <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1">Terkumpul</p>
                                <p class="text-2xl font-black text-teal-600">Rp {{ number_format($terkumpul, 0, ',', '.') }}</p>
                            </div>

                            <div class="w-full bg-gray-100 rounded-full h-3 mb-2 overflow-hidden">
                                <div class="h-full rounded-full bg-gradient-to-r from-teal-400 to-teal-600 transition-all" style="width: {{ $persentase }}%"></div>
                            </div>
                            <div class="flex justify-between text-xs text-gray-400 mb-4">
                                <span>{{ $persentase }}%</span>
                                <span>Target: Rp {{ number_format($program->target_nominal, 0, ',', '.') }}</span>
                            </div>

                            <div class="grid grid-cols-2 gap-3 mb-6">
                                <div class="bg-gray-50 rounded-xl p-3 text-center">
                                    <p class="text-lg font-bold text-gray-800">{{ $jumlahDonatur }}</p>
                                    <p class="text-xs text-gray-400">Donatur</p>
                                </div>
                                @if($sisaHari !== null)
                                    <div class="bg-gray-50 rounded-xl p-3 text-center">
                                        <p class="text-lg font-bold text-gray-800">{{ $sisaHari }}</p>
                                        <p class="text-xs text-gray-400">Hari Lagi</p>
                                    </div>
                                @endif
                            </div>

                            {{-- Quick donate --}}
                            <livewire:public-pages.donasi-form :programId="$program->id" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>
