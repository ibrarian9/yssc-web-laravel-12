<div>
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-extrabold text-gray-800">Program Donasi</h2>
            <p class="text-sm text-gray-500">Kelola program donasi milik Anda</p>
        </div>
        <button wire:click="create" class="px-4 py-2.5 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-bold rounded-xl text-sm hover:from-emerald-700 hover:to-emerald-800 shadow-lg transition-all flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px]!">add</span>Buat Program
        </button>
    </div>

    {{-- Program List --}}
    <div class="space-y-4">
        @forelse($programs as $program)
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 flex items-center gap-5">
                <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-100 shrink-0">
                    @if($program->thumbnail)
                        <img src="{{ Storage::url($program->thumbnail) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-emerald-100 flex items-center justify-center"><span class="material-symbols-outlined text-emerald-500">volunteer_activism</span></div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="font-bold text-gray-800 truncate">{{ $program->judul }}</h4>
                    <div class="flex items-center gap-3 mt-1 text-xs text-gray-400">
                        <span>Target: Rp {{ number_format($program->target_nominal, 0, ',', '.') }}</span>
                        <span>Terkumpul: Rp {{ number_format($program->terkumpul_nominal, 0, ',', '.') }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $program->status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ ucfirst($program->status) }}
                    </span>
                    <button wire:click="toggleStatus({{ $program->id }})" class="p-2 rounded-lg transition {{ $program->status === 'aktif' ? 'text-green-600 bg-green-50' : 'text-gray-400 bg-gray-50' }}" title="Toggle status">
                        <span class="material-symbols-outlined text-[18px]!">{{ $program->status === 'aktif' ? 'toggle_on' : 'toggle_off' }}</span>
                    </button>
                    <button wire:click="edit({{ $program->id }})" class="p-2 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition">
                        <span class="material-symbols-outlined text-[18px]!">edit</span>
                    </button>
                </div>
            </div>
        @empty
            <div class="text-center py-16 bg-white rounded-xl border border-gray-100">
                <span class="material-symbols-outlined text-[48px]! text-gray-300">volunteer_activism</span>
                <p class="text-gray-400 mt-2">Belum ada program. Buat program pertama Anda!</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">{{ $programs->links() }}</div>

    {{-- Form Modal --}}
    @if($showForm)
        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-4" wire:click.self="$set('showForm', false)">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800">{{ $editId ? 'Edit' : 'Buat' }} Program Donasi</h3>
                    <button wire:click="$set('showForm', false)" class="p-1 hover:bg-gray-100 rounded-lg"><span class="material-symbols-outlined text-[20px]!">close</span></button>
                </div>
                <form wire:submit="save" class="px-6 py-5 space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Judul Program *</label>
                        <input type="text" wire:model="judul" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('judul') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Deskripsi *</label>
                        <textarea wire:model="deskripsi" rows="4" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 resize-none"></textarea>
                        @error('deskripsi') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Target Nominal *</label>
                            <input type="number" wire:model="targetNominal" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            @error('targetNominal') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Tanggal Selesai</label>
                            <input type="date" wire:model="tanggalSelesai" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Thumbnail {{ $editId ? '' : '*' }}</label>
                        <input type="file" wire:model="thumbnail" accept="image/*" class="w-full text-sm file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-emerald-700 file:font-semibold">
                        @error('thumbnail') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="w-full py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-bold rounded-xl hover:from-emerald-700 hover:to-emerald-800 shadow-lg transition-all">
                        {{ $editId ? 'Simpan Perubahan' : 'Buat Program' }}
                    </button>
                </form>
            </div>
        </div>
    @endif
</div>
