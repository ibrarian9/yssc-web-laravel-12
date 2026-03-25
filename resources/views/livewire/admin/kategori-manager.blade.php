<div>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div><h2 class="text-2xl font-extrabold text-gray-800">Kategori</h2><p class="text-sm text-gray-500">Kelola kategori berita & kegiatan</p></div>
        <button wire:click="create" class="inline-flex items-center gap-2 px-5 py-2.5 bg-teal-600 text-white font-bold text-sm rounded-xl hover:bg-teal-700 shadow-lg shadow-teal-500/20 transition">
            <span class="material-symbols-outlined text-[18px]!">add</span> Tambah
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
        <table class="w-full text-sm min-w-[500px]">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr class="text-left text-xs text-gray-500 uppercase tracking-wider">
                    <th class="px-4 py-3">Warna</th><th class="px-4 py-3">Nama</th><th class="px-4 py-3">Slug</th><th class="px-4 py-3">Jumlah Berita</th><th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($items as $item)
                    <tr class="hover:bg-gray-50/50">
                        <td class="px-4 py-3"><span class="w-6 h-6 rounded-full inline-block" style="background-color: {{ $item->warna }}"></span></td>
                        <td class="px-4 py-3 font-semibold text-gray-800">{{ $item->nama }}</td>
                        <td class="px-4 py-3 text-gray-400">{{ $item->slug }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $item->berita_count }}</td>
                        <td class="px-4 py-3"><div class="flex justify-end gap-1">
                            <button wire:click="edit({{ $item->id }})" class="p-1.5 rounded-lg hover:bg-blue-50 text-blue-600"><span class="material-symbols-outlined text-[18px]!">edit</span></button>
                            <button wire:click="confirmDelete({{ $item->id }})" class="p-1.5 rounded-lg hover:bg-red-50 text-red-500"><span class="material-symbols-outlined text-[18px]!">delete</span></button>
                        </div></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-10 text-center text-gray-400">Belum ada kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>

    @if($showForm)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="$set('showForm', false)"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-800">{{ $isEditing ? 'Edit' : 'Tambah' }} Kategori</h3>
                <button wire:click="$set('showForm', false)" class="p-1 rounded-lg hover:bg-gray-100"><span class="material-symbols-outlined text-gray-400">close</span></button>
            </div>
            <form wire:submit="save" class="p-6 space-y-4">
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Nama *</label>
                    <input type="text" wire:model="nama" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                    @error('nama') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror</div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
                    <input type="text" wire:model="deskripsi" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Warna Badge</label>
                    <div class="flex items-center gap-3"><input type="color" wire:model="warna" class="w-10 h-10 rounded-lg border-0 cursor-pointer"><span class="text-sm text-gray-500">{{ $warna }}</span></div></div>
                <div class="flex justify-end gap-3 pt-3 border-t border-gray-100">
                    <button type="button" wire:click="$set('showForm', false)" class="px-5 py-2.5 border border-gray-200 text-gray-600 font-semibold rounded-xl hover:bg-gray-50 text-sm">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-teal-600 text-white font-bold rounded-xl hover:bg-teal-700 text-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    @if($showDeleteConfirm)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="$set('showDeleteConfirm', false)"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center">
            <span class="material-symbols-outlined text-[48px]! text-red-400 mb-3">warning</span>
            <h3 class="text-lg font-bold text-gray-800 mb-2">Hapus Kategori?</h3>
            <p class="text-sm text-gray-500 mb-6">Berita terkait tidak akan dihapus.</p>
            <div class="flex gap-3">
                <button wire:click="$set('showDeleteConfirm', false)" class="flex-1 py-2.5 border border-gray-200 text-gray-600 font-semibold rounded-xl text-sm">Batal</button>
                <button wire:click="delete" class="flex-1 py-2.5 bg-red-500 text-white font-bold rounded-xl text-sm">Hapus</button>
            </div>
        </div>
    </div>
    @endif
</div>
