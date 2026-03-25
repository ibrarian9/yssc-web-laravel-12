<div>
    {{-- Flash Message --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3 text-sm font-medium text-green-700">
            <span class="material-symbols-outlined text-[20px]!">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div><h2 class="text-2xl font-extrabold text-gray-800">Perizinan</h2><p class="text-sm text-gray-500">Kelola permohonan perizinan</p></div>
    </div>

    <div class="bg-white rounded-2xl p-5 shadow-md border border-gray-100 mb-8 flex flex-col lg:flex-row gap-4 items-stretch">
        <div class="flex-1 relative">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]!">search</span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari pemohon, email, judul..."
                class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-base focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 bg-gray-50/30 focus:bg-white">
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <select wire:model.live="statusFilter"
                class="min-w-[140px] px-4 py-3 border border-gray-200 rounded-xl text-sm font-medium text-gray-600 focus:ring-2 focus:ring-teal-500 bg-white cursor-pointer hover:border-teal-300 transition-colors">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="diproses">Diproses</option>
                <option value="selesai">Selesai</option>
                <option value="ditolak">Ditolak</option>
            </select>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100"><tr class="text-left text-xs text-gray-500 uppercase tracking-wider">
                    <th class="px-4 py-3">Pemohon</th><th class="px-4 py-3">Jenis</th><th class="px-4 py-3">Judul</th><th class="px-4 py-3">Dokumen</th><th class="px-4 py-3">Status</th><th class="px-4 py-3">Tanggal</th><th class="px-4 py-3 text-right">Aksi</th>
                </tr></thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($items as $item)
                        @php $sc = ['pending' => 'bg-yellow-100 text-yellow-700', 'diproses' => 'bg-blue-100 text-blue-700', 'selesai' => 'bg-green-100 text-green-700', 'ditolak' => 'bg-red-100 text-red-700']; @endphp
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-4 py-3"><p class="font-semibold text-gray-800">{{ $item->nama_pemohon }}</p><p class="text-xs text-gray-400">{{ $item->email_pemohon }}</p></td>
                            <td class="px-4 py-3 text-gray-500 capitalize">{{ $item->jenis_izin }}</td>
                            <td class="px-4 py-3 text-gray-600 max-w-[200px] truncate">{{ $item->judul_permohonan }}</td>
                            <td class="px-4 py-3">
                                @if($item->dokumen_pendukung && count($item->dokumen_pendukung) > 0)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold bg-teal-50 text-teal-700">
                                        <span class="material-symbols-outlined text-[14px]!">attach_file</span>
                                        {{ count($item->dokumen_pendukung) }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-300">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3"><span class="px-2 py-0.5 rounded-full text-xs font-bold {{ $sc[$item->status] ?? 'bg-gray-100 text-gray-600' }}">{{ ucfirst($item->status) }}</span></td>
                            <td class="px-4 py-3 text-gray-400 text-xs">{{ $item->tanggal_permohonan->format('d/m/Y') }}</td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-1">
                                    <button wire:click="openDetail({{ $item->id }})" class="p-1.5 rounded-lg hover:bg-blue-50 text-blue-600" title="Lihat Detail">
                                        <span class="material-symbols-outlined text-[18px]!">visibility</span>
                                    </button>
                                    <button wire:click="confirmDelete({{ $item->id }})"
                                            class="p-1.5 rounded-lg hover:bg-red-50 text-red-400 hover:text-red-600" title="Hapus">
                                        <span class="material-symbols-outlined text-[18px]!">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-4 py-10 text-center text-gray-400">Belum ada permohonan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($items->hasPages()) <div class="p-4 border-t border-gray-100">{{ $items->links() }}</div> @endif
    </div>

    {{-- Detail Modal --}}
    @if($showDetail)
    @php $detail = App\Models\Perizinan::find($detailId); @endphp
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="$set('showDetail', false)"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-800">Detail Permohonan</h3>
                <button wire:click="$set('showDetail', false)" class="p-1 rounded-lg hover:bg-gray-100"><span class="material-symbols-outlined text-gray-400">close</span></button>
            </div>
            @if($detail)
            <div class="p-6 space-y-5">
                {{-- Status Badge --}}
                @php
                    $statusConfig = [
                        'pending' => ['bg' => 'bg-yellow-50 border-yellow-200', 'text' => 'text-yellow-700', 'icon' => 'hourglass_top', 'label' => 'Menunggu Diproses'],
                        'diproses' => ['bg' => 'bg-blue-50 border-blue-200', 'text' => 'text-blue-700', 'icon' => 'pending', 'label' => 'Sedang Diproses'],
                        'selesai' => ['bg' => 'bg-green-50 border-green-200', 'text' => 'text-green-700', 'icon' => 'check_circle', 'label' => 'Selesai'],
                        'ditolak' => ['bg' => 'bg-red-50 border-red-200', 'text' => 'text-red-700', 'icon' => 'cancel', 'label' => 'Ditolak'],
                    ];
                    $st = $statusConfig[$detail->status] ?? $statusConfig['pending'];
                @endphp
                <div class="flex items-center gap-2 px-4 py-2.5 rounded-xl border {{ $st['bg'] }}">
                    <span class="material-symbols-outlined {{ $st['text'] }} text-[20px]!">{{ $st['icon'] }}</span>
                    <span class="font-bold text-sm {{ $st['text'] }}">{{ $st['label'] }}</span>
                </div>

                {{-- Info Grid --}}
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><p class="text-[10px] uppercase font-bold text-gray-400 mb-0.5">Pemohon</p><p class="text-gray-800 font-semibold">{{ $detail->nama_pemohon }}</p></div>
                    <div><p class="text-[10px] uppercase font-bold text-gray-400 mb-0.5">Email</p><p class="text-gray-800">{{ $detail->email_pemohon }}</p></div>
                    <div><p class="text-[10px] uppercase font-bold text-gray-400 mb-0.5">No. HP</p><p class="text-gray-800">{{ $detail->phone_pemohon ?? '-' }}</p></div>
                    <div><p class="text-[10px] uppercase font-bold text-gray-400 mb-0.5">Jenis Izin</p><p class="text-gray-800 capitalize">{{ $detail->jenis_izin }}</p></div>
                    <div class="col-span-2"><p class="text-[10px] uppercase font-bold text-gray-400 mb-0.5">Tanggal Permohonan</p><p class="text-gray-800">{{ $detail->tanggal_permohonan->format('d M Y') }}</p></div>
                </div>

                {{-- Judul & Deskripsi --}}
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-[10px] uppercase font-bold text-gray-400 mb-1">Judul Permohonan</p>
                    <p class="text-gray-800 font-bold mb-3">{{ $detail->judul_permohonan }}</p>
                    <p class="text-[10px] uppercase font-bold text-gray-400 mb-1">Deskripsi</p>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $detail->deskripsi }}</p>
                </div>

                {{-- Dokumen Pendukung --}}
                @if($detail->dokumen_pendukung && count($detail->dokumen_pendukung) > 0)
                    <div>
                        <p class="text-[10px] uppercase font-bold text-gray-400 mb-2">Dokumen Pendukung ({{ count($detail->dokumen_pendukung) }})</p>
                        <div class="space-y-2">
                            @foreach($detail->dokumen_pendukung as $idx => $doc)
                                @php
                                    $ext = strtolower(pathinfo($doc, PATHINFO_EXTENSION));
                                    $iconMap = ['pdf' => 'picture_as_pdf', 'jpg' => 'image', 'jpeg' => 'image', 'png' => 'image', 'doc' => 'description', 'docx' => 'description'];
                                    $icon = $iconMap[$ext] ?? 'attachment';
                                    $colorMap = ['pdf' => 'text-red-500', 'jpg' => 'text-blue-500', 'jpeg' => 'text-blue-500', 'png' => 'text-blue-500'];
                                    $color = $colorMap[$ext] ?? 'text-gray-500';
                                @endphp
                                <a href="{{ route('admin.perizinan.dokumen', [$detail->id, $idx]) }}" target="_blank"
                                   class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl hover:bg-teal-50 transition group">
                                    <span class="material-symbols-outlined {{ $color }} text-[22px]!">{{ $icon }}</span>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-700 group-hover:text-teal-700 truncate">Dokumen {{ $idx + 1 }}</p>
                                        <p class="text-xs text-gray-400 uppercase">.{{ $ext }}</p>
                                    </div>
                                    <span class="material-symbols-outlined text-gray-400 text-[16px]! group-hover:text-teal-600">open_in_new</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-2 px-4 py-3 bg-gray-50 rounded-xl text-sm text-gray-400">
                        <span class="material-symbols-outlined text-[18px]!">folder_off</span>
                        Tidak ada dokumen pendukung
                    </div>
                @endif

                <hr class="border-gray-100">

                {{-- Update Status --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Update Status</label>
                    <select wire:model="newStatus" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                        <option value="pending">⏳ Pending</option>
                        <option value="diproses">🔄 Diproses</option>
                        <option value="selesai">✅ Selesai</option>
                        <option value="ditolak">❌ Ditolak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Catatan Admin</label>
                    <textarea wire:model="catatanAdmin" rows="3" placeholder="Tambahkan catatan untuk pemohon..."
                              class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 resize-none"></textarea>
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-between items-center pt-3 border-t border-gray-100">
                    <button wire:click="confirmDelete({{ $detail->id }})"
                            class="px-4 py-2.5 text-red-500 hover:bg-red-50 font-semibold rounded-xl text-sm flex items-center gap-1.5 transition">
                        <span class="material-symbols-outlined text-[16px]!">delete</span>
                        Hapus
                    </button>
                    <div class="flex gap-3">
                        <button wire:click="$set('showDetail', false)" class="px-5 py-2.5 border border-gray-200 text-gray-600 font-semibold rounded-xl text-sm hover:bg-gray-50 transition">Batal</button>
                        <button wire:click="updateStatus" class="px-5 py-2.5 bg-gradient-to-r from-teal-600 to-teal-700 text-white font-bold rounded-xl text-sm hover:from-teal-700 hover:to-teal-800 shadow-lg transition-all">Simpan</button>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif

    {{-- Delete Confirm Modal --}}
    @if($showDeleteConfirm)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="$set('showDeleteConfirm', false)"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center">
            <span class="material-symbols-outlined text-[48px]! text-red-400 mb-3">warning</span>
            <h3 class="text-lg font-bold text-gray-800 mb-2">Hapus Permohonan?</h3>
            <p class="text-sm text-gray-500 mb-6">Data permohonan dan dokumen terlampir akan dihapus permanen.</p>
            <div class="flex gap-3">
                <button wire:click="$set('showDeleteConfirm', false)"
                    class="flex-1 py-2.5 border border-gray-200 text-gray-600 font-semibold rounded-xl hover:bg-gray-50 text-sm">Batal</button>
                <button wire:click="deletePerizinan"
                    class="flex-1 py-2.5 bg-red-500 text-white font-bold rounded-xl hover:bg-red-600 text-sm">Hapus</button>
            </div>
        </div>
    </div>
    @endif
</div>
