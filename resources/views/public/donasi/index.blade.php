<x-layouts.public>
    <x-slot:title>Donasi — Yayasan Seribu Satu Cita</x-slot:title>

    {{-- Hero --}}
    <section class="bg-gradient-to-br from-teal-800 via-teal-700 to-emerald-700 py-16 md:py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-5">
            <svg class="w-full h-full" viewBox="0 0 100 100"><circle cx="80" cy="20" r="30" fill="currentColor"/><circle cx="20" cy="80" r="40" fill="currentColor"/></svg>
        </div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-4">Program Donasi</h1>
            <p class="text-teal-100 text-lg mb-8 max-w-xl mx-auto">Setiap kontribusi Anda bermakna besar bagi mereka yang membutuhkan</p>
            <div class="inline-flex items-center gap-3 bg-white/10 backdrop-blur-sm rounded-2xl px-8 py-5 border border-white/20">
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
        </div>
    </section>

    {{-- Programs --}}
    <section class="py-12 lg:py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
            @php
                $programs = \App\Models\ProgramDonasi::where('status', '!=', 'draft')->ordered()->get();
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
        </div>
    </section>
</x-layouts.public>
