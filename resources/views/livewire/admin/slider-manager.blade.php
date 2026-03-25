<div>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div><h2 class="text-2xl font-extrabold text-gray-800">Slider Home</h2><p class="text-sm text-gray-500">Kelola slider halaman utama</p></div>
        <button wire:click="create" class="inline-flex items-center gap-2 px-5 py-2.5 bg-teal-600 text-white font-bold text-sm rounded-xl hover:bg-teal-700 shadow-lg shadow-teal-500/20 transition">
            <span class="material-symbols-outlined text-[18px]!">add</span> Tambah
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($items as $item)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden {{ !$item->is_active ? 'opacity-60' : '' }}">
                <div class="h-40 overflow-hidden relative">
                    <img src="{{ $item->gambar }}" class="w-full h-full object-cover" alt="{{ $item->judul }}">
                    <div class="absolute top-2 right-2 flex gap-1">
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $item->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $item->is_active ? 'Active' : 'Inactive' }}</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-gray-800/70 text-white">#{{ $item->urutan }}</span>
                    </div>
                </div>
                <div class="p-4">
                    <h4 class="font-bold text-gray-800 text-sm mb-1 truncate">{{ $item->judul }}</h4>
                    <p class="text-xs text-gray-400 line-clamp-1">{{ $item->deskripsi }}</p>
                    <div class="flex gap-1 mt-3">
                        <button wire:click="edit({{ $item->id }})" class="flex-1 py-1.5 text-xs font-semibold text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition">Edit</button>
                        <button wire:click="toggleActive({{ $item->id }})" class="flex-1 py-1.5 text-xs font-semibold text-amber-600 bg-amber-50 rounded-lg hover:bg-amber-100 transition">{{ $item->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                        <button wire:click="confirmDelete({{ $item->id }})" class="py-1.5 px-2 text-xs text-red-500 bg-red-50 rounded-lg hover:bg-red-100 transition"><span class="material-symbols-outlined text-[16px]!">delete</span></button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16 text-gray-400">
                <span class="material-symbols-outlined text-[48px]!">view_carousel</span><p class="mt-2">Belum ada slider.</p>
            </div>
        @endforelse
    </div>

    @if($showForm)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="$set('showForm', false)"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100"><h3 class="text-lg font-bold text-gray-800">{{ $isEditing ? 'Edit' : 'Tambah' }} Slider</h3><button wire:click="$set('showForm', false)" class="p-1 rounded-lg hover:bg-gray-100"><span class="material-symbols-outlined text-gray-400">close</span></button></div>
            <form wire:submit="save" class="p-6 space-y-4">
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Judul *</label><input type="text" wire:model="judul" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">@error('judul')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label><textarea wire:model="deskripsi" rows="2" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 resize-none"></textarea></div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block text-sm font-semibold text-gray-700 mb-1">Link</label><input type="text" wire:model="link" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500" placeholder="URL tujuan"></div>
                    <div><label class="block text-sm font-semibold text-gray-700 mb-1">Teks Tombol</label><input type="text" wire:model="tombol_teks" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500"></div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block text-sm font-semibold text-gray-700 mb-1">Urutan</label><input type="number" wire:model="urutan" min="0" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500"></div>
                    <div class="flex items-end pb-1"><label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" wire:model="is_active" class="rounded border-gray-300 text-teal-600"><span class="text-sm text-gray-600">Aktif</span></label></div>
                </div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Gambar {{ $isEditing ? '' : '*' }}</label><input type="file" wire:model="newGambar" accept="image/*" class="w-full text-sm file:mr-3 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:bg-teal-50 file:text-teal-700 file:font-semibold">@error('newGambar')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror</div>
                <div class="flex justify-end gap-3 pt-3 border-t border-gray-100">
                    <button type="button" wire:click="$set('showForm', false)" class="px-5 py-2.5 border border-gray-200 text-gray-600 font-semibold rounded-xl text-sm">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-teal-600 text-white font-bold rounded-xl text-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    @if($showDeleteConfirm)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4"><div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="$set('showDeleteConfirm', false)"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center"><span class="material-symbols-outlined text-[48px]! text-red-400 mb-3">warning</span><h3 class="text-lg font-bold text-gray-800 mb-2">Hapus Slider?</h3><div class="flex gap-3 mt-4"><button wire:click="$set('showDeleteConfirm', false)" class="flex-1 py-2.5 border border-gray-200 text-gray-600 font-semibold rounded-xl text-sm">Batal</button><button wire:click="delete" class="flex-1 py-2.5 bg-red-500 text-white font-bold rounded-xl text-sm">Hapus</button></div></div>
    </div>
    @endif
</div>
