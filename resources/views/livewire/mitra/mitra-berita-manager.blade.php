<div>
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-extrabold text-gray-800">Berita & Kegiatan</h2>
            <p class="text-sm text-gray-500">Posting berita dan kegiatan atas nama perusahaan Anda</p>
        </div>
        <button wire:click="create" class="px-4 py-2.5 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-bold rounded-xl text-sm hover:from-emerald-700 hover:to-emerald-800 shadow-lg transition-all flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px]!">add</span>Buat Berita
        </button>
    </div>

    {{-- List --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50/80 border-b border-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-wider text-gray-500">Judul</th>
                    <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-wider text-gray-500">Jenis</th>
                    <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-wider text-gray-500">Kategori</th>
                    <th class="px-4 py-3 text-center text-[10px] font-bold uppercase tracking-wider text-gray-500">Status</th>
                    <th class="px-4 py-3 text-center text-[10px] font-bold uppercase tracking-wider text-gray-500">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($beritaList as $b)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg overflow-hidden bg-gray-100 shrink-0">
                                    @if($b->thumbnail)<img src="{{ Storage::url($b->thumbnail) }}" class="w-full h-full object-cover">@else<div class="w-full h-full bg-emerald-50 flex items-center justify-center"><span class="material-symbols-outlined text-emerald-400 text-[16px]!">newspaper</span></div>@endif
                                </div>
                                <span class="font-semibold text-gray-800 truncate max-w-[200px]">{{ $b->judul }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3"><span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded text-[10px] font-bold uppercase">{{ $b->jenis }}</span></td>
                        <td class="px-4 py-3 text-xs text-gray-500">{{ $b->kategori?->nama }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $b->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $b->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <button wire:click="edit({{ $b->id }})" class="p-1.5 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition">
                                <span class="material-symbols-outlined text-[18px]!">edit</span>
                            </button>
                            <button wire:click="deleteBerita({{ $b->id }})" wire:confirm="Hapus berita ini?" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                                <span class="material-symbols-outlined text-[18px]!">delete</span>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-12 text-center text-gray-400">Belum ada berita. Buat publikasi pertama Anda!</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t border-gray-100">{{ $beritaList->links() }}</div>
    </div>

    {{-- Form Modal --}}
    @if($showForm)
        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-4" wire:click.self="$set('showForm', false)">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800">{{ $editId ? 'Edit' : 'Buat' }} Berita</h3>
                    <button wire:click="$set('showForm', false)" class="p-1 hover:bg-gray-100 rounded-lg"><span class="material-symbols-outlined text-[20px]!">close</span></button>
                </div>
                <form wire:submit="save" class="px-6 py-5 space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Judul *</label>
                        <input type="text" wire:model="judul" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500">
                        @error('judul') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Jenis *</label>
                            <select wire:model="jenis" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 bg-white">
                                <option value="berita">Berita</option>
                                <option value="kegiatan">Kegiatan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Kategori *</label>
                            <select wire:model="kategoriId" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 bg-white">
                                <option value="">Pilih...</option>
                                @foreach($kategoriOptions as $kat)
                                    <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                                @endforeach
                            </select>
                            @error('kategoriId') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Konten *</label>
                        <textarea wire:model="konten" rows="6" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 resize-none"></textarea>
                        @error('konten') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Thumbnail {{ $editId ? '' : '*' }}</label>
                        <input type="file" wire:model="thumbnail" accept="image/*" class="w-full text-sm file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-emerald-700 file:font-semibold">
                        @error('thumbnail') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <label class="flex items-center gap-2"><input type="checkbox" wire:model="isPublished" class="rounded text-emerald-600 focus:ring-emerald-500"><span class="text-sm text-gray-600">Publish langsung</span></label>
                    <button type="submit" class="w-full py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-bold rounded-xl hover:from-emerald-700 hover:to-emerald-800 shadow-lg transition-all">
                        {{ $editId ? 'Simpan' : 'Publish Berita' }}
                    </button>
                </form>
            </div>
        </div>
    @endif
</div>
