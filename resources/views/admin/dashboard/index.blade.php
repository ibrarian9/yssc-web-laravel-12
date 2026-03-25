<x-layouts.admin>
    <x-slot:header>Dashboard</x-slot:header>
    <x-slot:title>Dashboard</x-slot:title>

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <x-admin.stat-card title="Total Pengguna" :value="number_format($stats['total_users'])" icon="people" color="blue" />
        <x-admin.stat-card title="Donasi Bulan Ini" :value="'Rp ' . number_format($stats['donasi_bulan_ini'], 0, ',', '.')" icon="payments" color="teal" />
        <x-admin.stat-card title="Berita Published" :value="number_format($stats['berita_published'])" icon="newspaper" color="purple" />
        <x-admin.stat-card title="Perizinan Pending" :value="number_format($stats['perizinan_pending'])" icon="pending_actions" color="orange" />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Recent Donations --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 lg:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-gray-800">Donasi Terbaru</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs text-gray-400 uppercase tracking-wider border-b border-gray-50">
                            <th class="pb-3 pr-4">Donatur</th>
                            <th class="pb-3 pr-4">Program</th>
                            <th class="pb-3 pr-4">Nominal</th>
                            <th class="pb-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($donasiTerbaru as $d)
                            <tr>
                                <td class="py-3 pr-4">
                                    <p class="font-medium text-gray-700">{{ $d->nama_donatur }}</p>
                                    <p class="text-xs text-gray-400">{{ $d->created_at->diffForHumans() }}</p>
                                </td>
                                <td class="py-3 pr-4 text-gray-500">{{ Str::limit($d->program->judul ?? '-', 25) }}</td>
                                <td class="py-3 pr-4 font-semibold text-gray-800">Rp {{ number_format($d->nominal, 0, ',', '.') }}</td>
                                <td class="py-3">
                                    @php
                                        $sc = ['success' => 'bg-green-100 text-green-700', 'pending' => 'bg-yellow-100 text-yellow-700', 'failed' => 'bg-red-100 text-red-700'];
                                    @endphp
                                    <span class="px-2 py-0.5 rounded-full text-xs font-bold {{ $sc[$d->status_pembayaran] ?? '' }}">
                                        {{ ucfirst($d->status_pembayaran) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pending Permits --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h3 class="font-bold text-gray-800 mb-4">Perizinan Menunggu</h3>
            @if($perizinanPending->count() > 0)
                <div class="space-y-3">
                    @foreach($perizinanPending as $p)
                        <div class="bg-gray-50 rounded-lg p-3">
                            <p class="text-sm font-semibold text-gray-700">{{ $p->judul_permohonan }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $p->nama_pemohon }} · {{ $p->tanggal_permohonan->diffForHumans() }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-400 text-center py-6">Tidak ada perizinan pending.</p>
            @endif
        </div>
    </div>

    {{-- Recent News --}}
    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <h3 class="font-bold text-gray-800 mb-4">Berita Terbaru</h3>
        <div class="space-y-3">
            @foreach($beritaTerbaru as $b)
                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                    <div class="w-12 h-12 bg-gray-200 rounded-lg overflow-hidden shrink-0">
                        <img src="{{ $b->thumbnail }}" class="w-full h-full object-cover" alt="">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-700 truncate">{{ $b->judul }}</p>
                        <p class="text-xs text-gray-400">{{ $b->penulis->name ?? 'Admin' }} · {{ $b->created_at->diffForHumans() }}</p>
                    </div>
                    @php $bs = ['published' => 'bg-green-100 text-green-700', 'draft' => 'bg-gray-200 text-gray-600']; @endphp
                    <span class="px-2 py-0.5 rounded-full text-xs font-bold {{ $bs[$b->status] ?? '' }}">{{ ucfirst($b->status) }}</span>
                </div>
            @endforeach
        </div>
    </div>
</x-layouts.admin>
