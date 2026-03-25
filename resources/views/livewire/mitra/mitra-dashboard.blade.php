<div>
    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-[20px]! text-emerald-600">volunteer_activism</span>
                </div>
                <span class="text-sm text-gray-500">Program Donasi</span>
            </div>
            <p class="text-3xl font-extrabold text-gray-800">{{ $totalPrograms }}</p>
        </div>
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-[20px]! text-amber-600">payments</span>
                </div>
                <span class="text-sm text-gray-500">Total Donasi</span>
            </div>
            <p class="text-3xl font-extrabold text-gray-800">Rp {{ number_format($totalDonasi, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-[20px]! text-blue-600">people</span>
                </div>
                <span class="text-sm text-gray-500">Total Donatur</span>
            </div>
            <p class="text-3xl font-extrabold text-gray-800">{{ $totalDonatur }}</p>
        </div>
    </div>

    {{-- Mitra Info --}}
    @if($mitra)
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm mb-8">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-[20px]! text-emerald-600">business</span>
                Info Mitra
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                <div><p class="text-[10px] uppercase font-bold text-gray-400 mb-0.5">Perusahaan</p><p class="text-gray-800 font-semibold">{{ $mitra->nama_perusahaan }}</p></div>
                <div><p class="text-[10px] uppercase font-bold text-gray-400 mb-0.5">Jenis</p><p class="text-gray-800">{{ $mitra->jenis_mitra->label() }}</p></div>
                <div><p class="text-[10px] uppercase font-bold text-gray-400 mb-0.5">Email</p><p class="text-gray-800">{{ $mitra->email }}</p></div>
                <div><p class="text-[10px] uppercase font-bold text-gray-400 mb-0.5">Status</p><span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-[10px] font-bold">APPROVED</span></div>
            </div>
        </div>
    @endif

    {{-- Recent Donations --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-bold text-gray-800">Donasi Terbaru</h3>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($recentDonations as $d)
                <div class="px-6 py-3 flex items-center justify-between">
                    <div>
                        <p class="font-semibold text-gray-800 text-sm">{{ $d->nama_donatur ?? 'Anonim' }}</p>
                        <p class="text-xs text-gray-400">{{ $d->programDonasi?->judul }} · {{ $d->created_at->diffForHumans() }}</p>
                    </div>
                    <span class="text-sm font-bold text-emerald-600">Rp {{ number_format($d->nominal, 0, ',', '.') }}</span>
                </div>
            @empty
                <div class="px-6 py-8 text-center text-gray-400 text-sm">Belum ada donasi masuk.</div>
            @endforelse
        </div>
    </div>
</div>
