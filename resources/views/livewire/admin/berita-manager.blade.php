<div>
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-extrabold text-gray-800">Berita & Kegiatan</h2>
            <p class="text-sm text-gray-500">Kelola konten berita dan kegiatan</p>
        </div>
        <button wire:click="create"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-teal-600 text-white font-bold text-sm rounded-xl hover:bg-teal-700 shadow-lg shadow-teal-500/20 transition">
            <span class="material-symbols-outlined text-[18px]!">add</span> Tambah Baru
        </button>
    </div>

    {{-- Filters --}}
    <div
        class="bg-white rounded-2xl p-5 shadow-md border border-gray-100 mb-8 flex flex-col lg:flex-row gap-4 items-stretch">

        <div class="flex-1 relative">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]!">
                search
            </span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari berita atau kegiatan..."
                class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-base focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 bg-gray-50/30 focus:bg-white">
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <select wire:model.live="tipeFilter"
                class="min-w-[140px] px-4 py-3 border border-gray-200 rounded-xl text-sm font-medium text-gray-600 focus:ring-2 focus:ring-teal-500 bg-white cursor-pointer hover:border-teal-300 transition-colors">
                <option value="">Semua Tipe</option>
                <option value="berita">Berita</option>
                <option value="kegiatan">Kegiatan</option>
            </select>

            <select wire:model.live="statusFilter"
                class="min-w-[140px] px-4 py-3 border border-gray-200 rounded-xl text-sm font-medium text-gray-600 focus:ring-2 focus:ring-teal-500 bg-white cursor-pointer hover:border-teal-300 transition-colors">
                <option value="">Semua Status</option>
                <option value="published">Published</option>
                <option value="draft">Draft</option>
            </select>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr class="text-left text-xs text-gray-500 uppercase tracking-wider">
                        <th class="px-4 py-3">Judul</th>
                        <th class="px-4 py-3">Tipe</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Views</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($items as $item)
                    <tr class="hover:bg-gray-50/50">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                @if($item->thumbnail)
                                <img src="{{ $item->thumbnail }}" class="w-12 h-10 rounded-lg object-cover shrink-0"
                                    alt="">
                                @else
                                <div class="w-12 h-10 bg-gray-100 rounded-lg flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-gray-400 text-[18px]!">image</span>
                                </div>
                                @endif
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-800 truncate max-w-50">{{ $item->judul }}</p>
                                    <p class="text-xs text-gray-400">{{ $item->penulis->name ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span
                                class="px-2 py-0.5 rounded-full text-xs font-bold {{ $item->tipe === 'berita' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ ucfirst($item->tipe) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-500">{{ $item->kategori?->nama ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <button wire:click="toggleStatus({{ $item->id }})"
                                class="px-2 py-0.5 rounded-full text-xs font-bold cursor-pointer hover:opacity-80 transition {{ $item->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600' }}">
                                {{ ucfirst($item->status) }}
                            </button>
                        </td>
                        <td class="px-4 py-3 text-gray-500">{{ number_format($item->views) }}</td>
                        <td class="px-4 py-3 text-gray-400 text-xs">{{ $item->created_at->format('d/m/Y') }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-1">
                                <button wire:click="edit({{ $item->id }})"
                                    class="p-1.5 rounded-lg hover:bg-blue-50 text-blue-600 transition" title="Edit">
                                    <span class="material-symbols-outlined text-[18px]!">edit</span>
                                </button>
                                <button wire:click="confirmDelete({{ $item->id }})"
                                    class="p-1.5 rounded-lg hover:bg-red-50 text-red-500 transition" title="Hapus">
                                    <span class="material-symbols-outlined text-[18px]!">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-10 text-center text-gray-400">Belum ada data.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($items->hasPages())
        <div class="p-4 border-t border-gray-100">{{ $items->links() }}</div>
        @endif
    </div>

    {{-- Form Modal --}}
    @if($showForm)
    <div class="fixed inset-0 z-50 overflow-y-auto" x-data x-init="$el.querySelector('input[name=judul]')?.focus()">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="$set('showForm', false)"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-y-auto">
                <div
                    class="flex items-center justify-between px-6 py-4 border-b border-gray-100 sticky top-0 bg-white z-10">
                    <h3 class="text-lg font-bold text-gray-800">{{ $isEditing ? 'Edit' : 'Tambah' }} Berita/Kegiatan
                    </h3>
                    <button wire:click="$set('showForm', false)" class="p-1 rounded-lg hover:bg-gray-100"><span
                            class="material-symbols-outlined text-gray-400">close</span></button>
                </div>
                <form wire:submit="save" class="p-6 space-y-5">
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Judul *</label>
                            <input type="text" name="judul" wire:model="judul"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            @error('judul') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tipe *</label>
                            <select wire:model="tipe"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                                <option value="berita">Berita</option>
                                <option value="kegiatan">Kegiatan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori</label>
                            <select wire:model="kategori_id"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                                <option value="">Tanpa Kategori</option>
                                @foreach($kategoriList as $kat)
                                <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                            <select wire:model="status"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Lokasi</label>
                            <input type="text" wire:model="lokasi"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                placeholder="Opsional">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Kegiatan</label>
                            <input type="date" wire:model="tanggal_kegiatan"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Thumbnail</label>
                            <input type="file" wire:model="newThumbnail" accept="image/*"
                                class="w-full text-sm file:mr-3 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:bg-teal-50 file:text-teal-700 file:font-semibold file:text-sm">
                            @if($thumbnail && !$newThumbnail)
                            <p class="text-xs text-gray-400 mt-1">File saat ini tersedia</p>
                            @endif
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Konten *</label>
                            <textarea wire:model="konten" rows="10"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 resize-y"
                                placeholder="Tulis konten..."></textarea>
                            @error('konten') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <button type="button" wire:click="$set('showForm', false)"
                            class="px-5 py-2.5 border border-gray-200 text-gray-600 font-semibold rounded-xl hover:bg-gray-50 text-sm transition">Batal</button>
                        <button type="submit"
                            class="px-5 py-2.5 bg-teal-600 text-white font-bold rounded-xl hover:bg-teal-700 shadow-lg text-sm transition"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove>{{ $isEditing ? 'Simpan Perubahan' : 'Simpan' }}</span>
                            <span wire:loading>Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    {{-- Delete Confirm --}}
    @if($showDeleteConfirm)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="$set('showDeleteConfirm', false)"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center">
            <span class="material-symbols-outlined text-[48px]! text-red-400 mb-3">warning</span>
            <h3 class="text-lg font-bold text-gray-800 mb-2">Hapus Berita?</h3>
            <p class="text-sm text-gray-500 mb-6">Data yang dihapus dapat dipulihkan dari arsip.</p>
            <div class="flex gap-3">
                <button wire:click="$set('showDeleteConfirm', false)"
                    class="flex-1 py-2.5 border border-gray-200 text-gray-600 font-semibold rounded-xl hover:bg-gray-50 text-sm">Batal</button>
                <button wire:click="delete"
                    class="flex-1 py-2.5 bg-red-500 text-white font-bold rounded-xl hover:bg-red-600 text-sm">Hapus</button>
            </div>
        </div>
    </div>
    @endif
</div>