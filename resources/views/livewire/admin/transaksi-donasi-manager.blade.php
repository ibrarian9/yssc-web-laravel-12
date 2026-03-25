<div>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-extrabold text-gray-800">Transaksi Donasi</h2>
            <p class="text-sm text-gray-500">Riwayat semua transaksi donasi & status Midtrans</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-2xl p-5 shadow-md border border-gray-100 mb-8 flex flex-col lg:flex-row gap-4 items-stretch">
        <div class="flex-1 relative">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]!">search</span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari donatur, email, kode, order ID..."
                class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-base focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 bg-gray-50/30 focus:bg-white">
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <select wire:model.live="filterStatus"
                class="min-w-[140px] px-4 py-3 border border-gray-200 rounded-xl text-sm font-medium text-gray-600 focus:ring-2 focus:ring-teal-500 bg-white cursor-pointer hover:border-teal-300 transition-colors">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="success">Success</option>
                <option value="failed">Failed</option>
                <option value="expired">Expired</option>
            </select>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50/80 border-b border-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-wider text-gray-500">Donatur</th>
                        <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-wider text-gray-500">Program</th>
                        <th class="px-4 py-3 text-right text-[10px] font-bold uppercase tracking-wider text-gray-500">Nominal</th>
                        <th class="px-4 py-3 text-center text-[10px] font-bold uppercase tracking-wider text-gray-500">Status</th>
                        <th class="px-4 py-3 text-center text-[10px] font-bold uppercase tracking-wider text-gray-500">Metode</th>
                        <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-wider text-gray-500">Tanggal</th>
                        <th class="px-4 py-3 text-center text-[10px] font-bold uppercase tracking-wider text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($donasi as $d)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-4 py-3">
                                <div class="font-semibold text-gray-800">{{ $d->nama_tampil }}</div>
                                <div class="text-[11px] text-gray-400">{{ $d->email_donatur }}</div>
                            </td>
                            <td class="px-4 py-3 text-gray-600 max-w-[180px] truncate">{{ $d->program?->judul ?? '-' }}</td>
                            <td class="px-4 py-3 text-right font-bold text-gray-800">Rp {{ number_format($d->nominal, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-center">
                                @php
                                    $statusColors = [
                                        'success' => 'bg-green-100 text-green-700',
                                        'pending' => 'bg-amber-100 text-amber-700',
                                        'failed' => 'bg-red-100 text-red-700',
                                        'expired' => 'bg-gray-100 text-gray-600',
                                        'refunded' => 'bg-purple-100 text-purple-700',
                                    ];
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $statusColors[$d->status_pembayaran] ?? 'bg-gray-100 text-gray-600' }}">
                                    {{ $d->status_pembayaran }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center text-gray-500 text-xs">{{ $d->midtrans_payment_type ?? $d->metode_pembayaran ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-400 text-xs">{{ $d->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3 text-center">
                                <button wire:click="openDetail({{ $d->id }})" class="p-1.5 text-gray-400 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition">
                                    <span class="material-symbols-outlined text-[18px]!">visibility</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-4 py-12 text-center text-gray-400">Belum ada transaksi donasi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-gray-100">{{ $donasi->links() }}</div>
    </div>

    {{-- Detail Modal --}}
    @if($showDetail && $selected)
        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-4" wire:click.self="closeDetail">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800">Detail Transaksi</h3>
                    <button wire:click="closeDetail" class="p-1 hover:bg-gray-100 rounded-lg"><span class="material-symbols-outlined text-[20px]!">close</span></button>
                </div>
                <div class="px-6 py-5 space-y-4">
                    {{-- Status banner --}}
                    <div class="flex items-center gap-3 p-3 rounded-xl {{ str_contains($statusColors[$selected->status_pembayaran] ?? '', 'green') ? 'bg-green-50' : (str_contains($statusColors[$selected->status_pembayaran] ?? '', 'amber') ? 'bg-amber-50' : 'bg-red-50') }}">
                        <span class="material-symbols-outlined text-[24px]! {{ $selected->status_pembayaran === 'success' ? 'text-green-600' : ($selected->status_pembayaran === 'pending' ? 'text-amber-600' : 'text-red-600') }}">
                            {{ $selected->status_pembayaran === 'success' ? 'check_circle' : ($selected->status_pembayaran === 'pending' ? 'schedule' : 'cancel') }}
                        </span>
                        <div>
                            <p class="font-bold text-sm uppercase">{{ $selected->status_pembayaran }}</p>
                            @if($selected->paid_at)<p class="text-[11px] text-gray-500">Dibayar: {{ $selected->paid_at->format('d M Y H:i') }}</p>@endif
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div><p class="text-[10px] uppercase font-bold text-gray-400 mb-0.5">Kode</p><p class="font-mono text-xs text-gray-800">{{ $selected->kode_unik }}</p></div>
                        <div><p class="text-[10px] uppercase font-bold text-gray-400 mb-0.5">Nominal</p><p class="font-bold text-gray-800 text-lg">Rp {{ number_format($selected->nominal, 0, ',', '.') }}</p></div>
                        <div><p class="text-[10px] uppercase font-bold text-gray-400 mb-0.5">Donatur</p><p class="text-gray-800">{{ $selected->nama_donatur }}</p></div>
                        <div><p class="text-[10px] uppercase font-bold text-gray-400 mb-0.5">Email</p><p class="text-gray-800">{{ $selected->email_donatur }}</p></div>
                        <div><p class="text-[10px] uppercase font-bold text-gray-400 mb-0.5">Program</p><p class="text-gray-800">{{ $selected->program?->judul ?? '-' }}</p></div>
                        <div><p class="text-[10px] uppercase font-bold text-gray-400 mb-0.5">Metode</p><p class="text-gray-800">{{ $selected->midtrans_payment_type ?? $selected->metode_pembayaran ?? '-' }}</p></div>
                    </div>

                    @if($selected->midtrans_order_id)
                        <div class="mt-2 p-3 bg-gray-50 rounded-xl">
                            <p class="text-[10px] uppercase font-bold text-gray-400 mb-1">Midtrans Order ID</p>
                            <p class="font-mono text-xs text-gray-700 break-all">{{ $selected->midtrans_order_id }}</p>
                        </div>
                    @endif

                    @if($selected->pesan)
                        <div><p class="text-[10px] uppercase font-bold text-gray-400 mb-1">Pesan</p><p class="text-sm text-gray-600 italic">"{{ $selected->pesan }}"</p></div>
                    @endif

                    <div class="text-[11px] text-gray-400">
                        Dibuat: {{ $selected->created_at->format('d M Y H:i:s') }}
                        @if($selected->is_anonim) · <span class="text-amber-600 font-semibold">Donasi Anonim</span> @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
