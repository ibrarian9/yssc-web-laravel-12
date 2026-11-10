<x-layouts.public>
    <x-slot:title>Donasi — Yayasan Seribu Satu Cita</x-slot:title>

    {{-- Hero --}}
    <x-public.page-hero page="donasi" default-title="Program Donasi" default-subtitle="Setiap kontribusi Anda bermakna besar bagi mereka yang membutuhkan">
        @if($isDonasiActive ?? true)
            <div class="inline-flex items-center gap-3 bg-white/10 backdrop-blur-sm rounded-2xl px-8 py-5 border border-white/20 mt-6">
                <span class="material-symbols-outlined text-yellow-400 text-[36px]!">payments</span>
                <div class="text-left">
                    <p class="text-teal-100 text-xs font-semibold uppercase tracking-wider">Total Donasi Terkumpul</p>
                    <p class="text-3xl md:text-4xl font-black text-white"
                       x-data="{ val: 0, target: {{ (int)$totalDonasi }} }"
                       x-init="let s=Math.ceil(target/80); let i=setInterval(()=>{val+=s; if(val>=target){val=target;clearInterval(i);}},16);"
                       x-text="'Rp ' + val.toLocaleString('id-ID')">
                        Rp {{ number_format($totalDonasi, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        @endif
    </x-public.page-hero>

    {{-- Programs / Disabled Notice --}}
    <section class="py-12 lg:py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
            @if(!($isDonasiActive ?? true))
                <div class="max-w-2xl mx-auto text-center bg-white rounded-3xl p-8 md:p-12 shadow-sm border border-gray-100">
                    <div class="w-20 h-20 bg-amber-50 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-5 border border-amber-100">
                        <span class="material-symbols-outlined text-[40px]!">pause_circle</span>
                    </div>
                    <h2 class="text-2xl font-extrabold text-gray-800 mb-3">Layanan Donasi Sedang Dinonaktifkan Sementara</h2>
                    <p class="text-gray-500 text-sm md:text-base leading-relaxed mb-8">
                        Saat ini fitur donasi online sedang dinonaktifkan sementara oleh pengelola yayasan. Anda tetap dapat mengikuti berbagai informasi program sosial dan kegiatan kami melalui halaman berita dan kegiatan.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ route('home') }}" wire:navigate class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-teal-500/20 transition">
                            <span class="material-symbols-outlined text-[18px]!">home</span>
                            Kembali ke Beranda
                        </a>
                        <a href="{{ route('kegiatan.index') }}" wire:navigate class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-sm rounded-xl transition">
                            <span class="material-symbols-outlined text-[18px]!">event</span>
                            Lihat Kegiatan Kami
                        </a>
                    </div>
                </div>
            @else
                @php
                    $programs = $programs ?? \App\Models\ProgramDonasi::where('status', '!=', 'draft')
                        ->withSum(['donasi as total_terkumpul' => fn($q) => $q->where('status_pembayaran', 'success')], 'nominal')
                        ->withCount(['donasi as donatur_count' => fn($q) => $q->where('status_pembayaran', 'success')])
                        ->ordered()
                        ->get();
                @endphp

                @if($programs->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($programs as $program)
                            <x-public.card-donasi :program="$program" />
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16">
                        <span class="material-symbols-outlined text-[64px]! text-gray-300">volunteer_activism</span>
                        <h3 class="text-xl font-bold text-gray-400 mt-4">Belum ada program donasi</h3>
                    </div>
                @endif
            @endif
        </div>
    </section>
</x-layouts.public>
