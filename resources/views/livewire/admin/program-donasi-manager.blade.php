<div>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div><h2 class="text-2xl font-extrabold text-gray-800">Program Donasi</h2><p class="text-sm text-gray-500">Kelola program penggalangan dana</p></div>
        <button wire:click="create" class="inline-flex items-center gap-2 px-5 py-2.5 bg-teal-600 text-white font-bold text-sm rounded-xl hover:bg-teal-700 shadow-lg shadow-teal-500/20 transition"><span class="material-symbols-outlined text-[18px]!">add</span> Tambah</button>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100"><tr class="text-left text-xs text-gray-500 uppercase tracking-wider">
                    <th class="px-4 py-3">Program</th><th class="px-4 py-3">Target</th><th class="px-4 py-3">Terkumpul</th><th class="px-4 py-3">Donatur</th><th class="px-4 py-3">Status</th><th class="px-4 py-3 text-right">Aksi</th>
                </tr></thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($items as $item)
                        @php $pct = $item->target_nominal > 0 ? min(100, round(($item->total_donasi / $item->target_nominal) * 100)) : 0; @endphp
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-4 py-3"><p class="font-semibold text-gray-800 max-w-[200px] truncate">{{ $item->judul }}</p>@if($item->is_mendesak)<span class="text-xs text-red-500 font-bold">🔥 Mendesak</span>@endif</td>
                            <td class="px-4 py-3 text-gray-600">Rp {{ number_format($item->target_nominal, 0, ',', '.') }}</td>
                            <td class="px-4 py-3"><div class="flex items-center gap-2"><div class="w-20 bg-gray-100 rounded-full h-2"><div class="h-full rounded-full bg-teal-500" style="width:{{ $pct }}%"></div></div><span class="text-xs text-gray-500">{{ $pct }}%</span></div></td>
                            <td class="px-4 py-3 text-gray-500">{{ $item->donasi_count }}</td>
                            <td class="px-4 py-3">
                                @php $sc = ['aktif' => 'bg-green-100 text-green-700', 'draft' => 'bg-gray-200 text-gray-600', 'selesai' => 'bg-blue-100 text-blue-700']; @endphp
                                <span class="px-2 py-0.5 rounded-full text-xs font-bold {{ $sc[$item->status] ?? '' }}">{{ ucfirst($item->status) }}</span></td>
                            <td class="px-4 py-3"><div class="flex justify-end gap-1">
                                <button wire:click="edit({{ $item->id }})" class="p-1.5 rounded-lg hover:bg-blue-50 text-blue-600"><span class="material-symbols-outlined text-[18px]!">edit</span></button>
                                <button wire:click="confirmDelete({{ $item->id }})" class="p-1.5 rounded-lg hover:bg-red-50 text-red-500"><span class="material-symbols-outlined text-[18px]!">delete</span></button>
                            </div></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-10 text-center text-gray-400">Belum ada program.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($items->hasPages()) <div class="p-4 border-t border-gray-100">{{ $items->links() }}</div> @endif
    </div>

    @if($showForm)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="$set('showForm', false)"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-800">{{ $isEditing ? 'Edit' : 'Tambah' }} Program Donasi</h3>
                <button wire:click="$set('showForm', false)" class="p-1 rounded-lg hover:bg-gray-100">
                    <span class="material-symbols-outlined text-gray-400">close</span>
                </button>
            </div>
            <form wire:submit="save" class="p-6 space-y-5">
                {{-- Judul --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Program <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="judul" placeholder="Contoh: Beasiswa Anak Yatim 2026"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                    @error('judul') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Target Nominal + Status --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div x-data="{
                        raw: @entangle('target_nominal'),
                        formatted: '',
                        init() {
                            this.formatted = this.raw ? Number(this.raw).toLocaleString('id-ID') : '';
                        },
                        format(e) {
                            let val = e.target.value.replace(/\D/g, '');
                            this.raw = val ? parseInt(val) : 0;
                            this.formatted = val ? parseInt(val).toLocaleString('id-ID') : '';
                        }
                    }">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Target Nominal <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-400">Rp</span>
                            <input type="text" x-model="formatted" @input="format($event)"
                                placeholder="1.000.000" inputmode="numeric"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                        </div>
                        @error('target_nominal') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                        <select wire:model="status"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                            <option value="draft">📝 Draft</option>
                            <option value="aktif">✅ Aktif</option>
                            <option value="selesai">🏁 Selesai</option>
                        </select>
                    </div>
                </div>

                {{-- Tanggal Mulai + Selesai --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Mulai</label>
                        <input type="date" wire:model="tanggal_mulai"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Selesai</label>
                        <input type="date" wire:model="tanggal_selesai"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                    </div>
                </div>

                {{-- Mendesak toggle --}}
                <div class="flex items-center gap-3 p-3 bg-red-50/50 rounded-xl border border-red-100">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" wire:model.live="is_mendesak"
                            class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                        <span class="text-sm font-medium text-gray-700">🔥 Tandai sebagai program mendesak</span>
                    </label>
                </div>

                {{-- Thumbnail --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Thumbnail <span class="text-xs text-gray-400 font-normal">(maks. 2MB)</span></label>
                    <input type="file" wire:model="newThumbnail" accept="image/*"
                        class="w-full text-sm file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-teal-50 file:text-teal-700 file:font-semibold hover:file:bg-teal-100">
                    @error('newThumbnail') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    @if($newThumbnail)
                        <img src="{{ $newThumbnail->temporaryUrl() }}" class="mt-2 h-20 rounded-lg object-cover" alt="Preview">
                    @endif
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi <span class="text-red-500">*</span></label>
                    <textarea wire:model="deskripsi" rows="5" placeholder="Jelaskan detail program donasi ini..."
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 resize-y"></textarea>
                    @error('deskripsi') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Actions --}}
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" wire:click="$set('showForm', false)"
                        class="px-5 py-2.5 border border-gray-200 text-gray-600 font-semibold rounded-xl hover:bg-gray-50 text-sm transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-teal-600 text-white font-bold rounded-xl hover:bg-teal-700 text-sm shadow-lg shadow-teal-500/20 transition">
                        {{ $isEditing ? 'Simpan Perubahan' : 'Tambah Program' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    @if($showDeleteConfirm)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4"><div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="$set('showDeleteConfirm', false)"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center"><span class="material-symbols-outlined text-[48px]! text-red-400 mb-3">warning</span><h3 class="text-lg font-bold text-gray-800 mb-2">Hapus Program?</h3><p class="text-sm text-gray-500 mb-4">Donasi terkait akan tetap ada.</p><div class="flex gap-3"><button wire:click="$set('showDeleteConfirm', false)" class="flex-1 py-2.5 border border-gray-200 text-gray-600 font-semibold rounded-xl text-sm">Batal</button><button wire:click="delete" class="flex-1 py-2.5 bg-red-500 text-white font-bold rounded-xl text-sm">Hapus</button></div></div>
    </div>
    @endif
</div>
