@props(['program'])

@php
    $terkumpul = $program->donasiSuccess()->sum('nominal');
    $persentase = $program->target_nominal > 0 ? min(100, round(($terkumpul / $program->target_nominal) * 100, 1)) : 0;
    $sisaHari = $program->tanggal_selesai ? (int) max(0, now()->diffInDays($program->tanggal_selesai, false)) : null;
    $jumlahDonatur = $program->donasiSuccess()->count();
@endphp

<div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group border border-gray-100 flex flex-col">
    <div class="overflow-hidden h-48 relative">
        <img src="{{ str_starts_with($program->thumbnail, 'http') ? $program->thumbnail : asset('storage/'. $program->thumbnail) }}"
             class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
             alt="{{ $program->judul }}" loading="lazy">
        @if($program->is_mendesak)
            <span class="absolute top-3 left-3 px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-md bg-red-500 text-white animate-pulse">
                🔥 Mendesak
            </span>
        @endif
    </div>
    <div class="p-5 flex-1 flex flex-col">
        <h3 class="text-base font-bold text-gray-800 leading-snug mb-2 line-clamp-2 group-hover:text-teal-700 transition">
            {{ $program->judul }}
        </h3>
        <p class="text-sm text-gray-500 line-clamp-2 mb-4">{{ Str::limit(strip_tags($program->deskripsi), 100) }}</p>

        {{-- Progress --}}
        <div class="mt-auto">
            <div class="flex justify-between text-xs mb-1.5">
                <span class="font-bold text-teal-600">Rp {{ number_format($terkumpul, 0, ',', '.') }}</span>
                <span class="font-semibold text-gray-400">{{ $persentase }}%</span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-2.5 mb-3 overflow-hidden">
                <div class="h-full rounded-full transition-all duration-1000 {{ $program->is_mendesak ? 'bg-gradient-to-r from-red-400 to-red-500' : 'bg-gradient-to-r from-teal-400 to-teal-600' }}"
                     style="width: {{ $persentase }}%"></div>
            </div>
            <div class="flex justify-between text-xs text-gray-400 mb-4">
                <span>Target: Rp {{ number_format($program->target_nominal, 0, ',', '.') }}</span>
            </div>

            <div class="flex items-center justify-between text-xs text-gray-400 mb-4">
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]!">group</span>
                    {{ $jumlahDonatur }} donatur
                </div>
                @if($sisaHari !== null)
                    <div class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]!">schedule</span>
                        Sisa {{ $sisaHari }} hari
                    </div>
                @endif
            </div>

            <a href="{{ route('donasi.show', $program->slug) }}"
               class="block w-full text-center py-2.5 bg-linear-to-r from-teal-600 to-teal-700 text-white text-sm font-bold rounded-xl hover:from-teal-700 hover:to-teal-800 shadow-md shadow-teal-500/20 transition-all hover:shadow-lg hover:scale-[1.02]">
                Donasi Sekarang
            </a>
        </div>
    </div>
</div>
