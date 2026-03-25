<div>
    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3 text-sm font-medium text-green-700">
            <span class="material-symbols-outlined text-[20px]!">check_circle</span> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3 text-sm font-medium text-red-700">
            <span class="material-symbols-outlined text-[20px]!">error</span> {{ session('error') }}
        </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div><h2 class="text-2xl font-extrabold text-gray-800">Anggota & Divisi</h2><p class="text-sm text-gray-500">Kelola anggota organisasi dan divisi</p></div>
    </div>

    {{-- Tabs --}}
    <div class="flex gap-2 mb-6">
        <button wire:click="$set('activeTab', 'anggota')"
                class="px-5 py-2.5 rounded-xl text-sm font-semibold transition {{ $activeTab === 'anggota' ? 'bg-teal-600 text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
            <span class="material-symbols-outlined text-[16px]! mr-1 align-middle">group</span> Anggota
        </button>
        <button wire:click="$set('activeTab', 'divisi')"
                class="px-5 py-2.5 rounded-xl text-sm font-semibold transition {{ $activeTab === 'divisi' ? 'bg-teal-600 text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
            <span class="material-symbols-outlined text-[16px]! mr-1 align-middle">account_tree</span> Divisi
        </button>
    </div>

    {{-- ═════════════════ ANGGOTA TAB ═══════════════════ --}}
    @if($activeTab === 'anggota')
        <div class="bg-white rounded-2xl p-5 shadow-md border border-gray-100 mb-8 flex flex-col lg:flex-row gap-4 items-stretch">
            <div class="flex-1 relative">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]!">search</span>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama, jabatan..."
                       class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-base focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all bg-gray-50/30 focus:bg-white">
            </div>
            <div class="flex gap-3">
                <select wire:model.live="filterDivisi" class="min-w-[160px] px-4 py-3 border border-gray-200 rounded-xl text-sm font-medium text-gray-600 focus:ring-2 focus:ring-teal-500 bg-white">
                    <option value="">Semua Divisi</option>
                    @foreach($divisiOptions as $d)
                        <option value="{{ $d->id }}">{{ $d->nama }}</option>
                    @endforeach
                </select>
                <button wire:click="createAnggota" class="px-5 py-3 bg-teal-600 text-white font-bold rounded-xl hover:bg-teal-700 transition flex items-center gap-2 whitespace-nowrap">
                    <span class="material-symbols-outlined text-[18px]!">add</span> Tambah Anggota
                </button>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100"><tr class="text-left text-xs text-gray-500 uppercase tracking-wider">
                        <th class="px-4 py-3">Anggota</th>
                        <th class="px-4 py-3">Jabatan</th>
                        <th class="px-4 py-3">Divisi</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr></thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($anggotaList as $a)
                            <tr class="hover:bg-gray-50/50">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        @if($a->foto)
                                            <img src="{{ asset('storage/' . $a->foto) }}" class="w-10 h-10 rounded-full object-cover border border-gray-200">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center">
                                                <span class="material-symbols-outlined text-teal-600 text-[18px]!">person</span>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $a->nama }}</p>
                                            @if($a->email)<p class="text-xs text-gray-400">{{ $a->email }}</p>@endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-gray-600">{{ $a->jabatan }}</td>
                                <td class="px-4 py-3"><span class="px-2 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700">{{ $a->divisi?->nama ?? '-' }}</span></td>
                                <td class="px-4 py-3">
                                    <button wire:click="toggleAnggota({{ $a->id }})" class="px-2 py-0.5 rounded-full text-xs font-bold cursor-pointer {{ $a->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                        {{ $a->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </button>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-end gap-1">
                                        <button wire:click="editAnggota({{ $a->id }})" class="p-1.5 rounded-lg hover:bg-blue-50 text-blue-600" title="Edit">
                                            <span class="material-symbols-outlined text-[18px]!">edit</span>
                                        </button>
                                        <button type="button"
                                                @click="Swal.fire({title:'Hapus Anggota?',text:'{{ $a->nama }} akan dihapus.',icon:'warning',showCancelButton:true,confirmButtonColor:'#dc2626',confirmButtonText:'Ya, Hapus',cancelButtonText:'Batal'}).then(r=>{if(r.isConfirmed)$wire.deleteAnggota({{ $a->id }})})"
                                                class="p-1.5 rounded-lg hover:bg-red-50 text-red-400 hover:text-red-600" title="Hapus">
                                            <span class="material-symbols-outlined text-[18px]!">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-10 text-center text-gray-400">Belum ada anggota.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($anggotaList->hasPages()) <div class="p-4 border-t border-gray-100">{{ $anggotaList->links() }}</div> @endif
        </div>

        {{-- Anggota Form Modal --}}
        @if($showAnggotaForm)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="$set('showAnggotaForm', false)"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">{{ $editAnggotaId ? 'Edit' : 'Tambah' }} Anggota</h3>
                    <button wire:click="$set('showAnggotaForm', false)" class="p-1 rounded-lg hover:bg-gray-100"><span class="material-symbols-outlined text-gray-400">close</span></button>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama *</label>
                            <input type="text" wire:model="nama" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                            @error('nama') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Jabatan *</label>
                            <input type="text" wire:model="jabatan" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                            @error('jabatan') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Divisi *</label>
                        <select wire:model="divisiId" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                            <option value="">Pilih Divisi</option>
                            @foreach($divisiOptions as $d)
                                <option value="{{ $d->id }}">{{ $d->nama }}</option>
                            @endforeach
                        </select>
                        @error('divisiId') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Bio</label>
                        <textarea wire:model="bio" rows="3" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 resize-none"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                            <input type="email" wire:model="email" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Foto</label>
                            <input type="file" wire:model="foto" accept="image/*" class="w-full text-sm file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-teal-50 file:text-teal-700 file:font-semibold file:text-sm">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">LinkedIn</label>
                            <input type="text" wire:model="linkedin" placeholder="URL LinkedIn" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Instagram</label>
                            <input type="text" wire:model="instagram" placeholder="@username" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Periode Mulai</label>
                            <input type="date" wire:model="periodeMulai" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Periode Selesai</label>
                            <input type="date" wire:model="periodeSelesai" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Urutan</label>
                            <input type="number" wire:model="urutan" min="0" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                        </div>
                        <div class="flex items-end pb-1">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" wire:model="isActive" class="w-4 h-4 rounded border-gray-300 text-teal-600 focus:ring-teal-500">
                                <span class="text-sm font-semibold text-gray-700">Aktif</span>
                            </label>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 pt-3 border-t border-gray-100">
                        <button wire:click="$set('showAnggotaForm', false)" class="px-5 py-2.5 border border-gray-200 text-gray-600 font-semibold rounded-xl text-sm hover:bg-gray-50">Batal</button>
                        <button wire:click="saveAnggota" class="px-5 py-2.5 bg-teal-600 text-white font-bold rounded-xl text-sm hover:bg-teal-700 shadow-lg">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endif

    {{-- ═════════════════ DIVISI TAB ═══════════════════ --}}
    @if($activeTab === 'divisi')
        <div class="flex justify-end mb-6">
            <button wire:click="createDivisi" class="px-5 py-3 bg-teal-600 text-white font-bold rounded-xl hover:bg-teal-700 transition flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]!">add</span> Tambah Divisi
            </button>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($divisiList as $d)
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h4 class="font-bold text-gray-800">{{ $d->nama }}</h4>
                            <p class="text-xs text-gray-400">{{ $d->anggota_count }} anggota</p>
                        </div>
                        <span class="px-2 py-0.5 rounded-full text-xs font-bold {{ $d->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $d->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                    @if($d->deskripsi)
                        <p class="text-sm text-gray-500 mb-3 line-clamp-2">{{ $d->deskripsi }}</p>
                    @endif
                    <div class="flex justify-end gap-1 pt-3 border-t border-gray-100">
                        <button wire:click="editDivisi({{ $d->id }})" class="p-1.5 rounded-lg hover:bg-blue-50 text-blue-600">
                            <span class="material-symbols-outlined text-[18px]!">edit</span>
                        </button>
                        <button type="button"
                                @click="Swal.fire({title:'Hapus Divisi?',text:'{{ $d->nama }} akan dihapus. Pastikan tidak ada anggota di divisi ini.',icon:'warning',showCancelButton:true,confirmButtonColor:'#dc2626',confirmButtonText:'Ya, Hapus',cancelButtonText:'Batal'}).then(r=>{if(r.isConfirmed)$wire.deleteDivisi({{ $d->id }})})"
                                class="p-1.5 rounded-lg hover:bg-red-50 text-red-400 hover:text-red-600">
                            <span class="material-symbols-outlined text-[18px]!">delete</span>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-10 text-gray-400">Belum ada divisi.</div>
            @endforelse
        </div>

        {{-- Divisi Form Modal --}}
        @if($showDivisiForm)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="$set('showDivisiForm', false)"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">{{ $editDivisiId ? 'Edit' : 'Tambah' }} Divisi</h3>
                    <button wire:click="$set('showDivisiForm', false)" class="p-1 rounded-lg hover:bg-gray-100"><span class="material-symbols-outlined text-gray-400">close</span></button>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Divisi *</label>
                        <input type="text" wire:model="namaDivisi" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                        @error('namaDivisi') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
                        <textarea wire:model="deskripsiDivisi" rows="3" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 resize-none"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Urutan</label>
                            <input type="number" wire:model="urutanDivisi" min="0" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                        </div>
                        <div class="flex items-end pb-1">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" wire:model="isDivisiActive" class="w-4 h-4 rounded border-gray-300 text-teal-600 focus:ring-teal-500">
                                <span class="text-sm font-semibold text-gray-700">Aktif</span>
                            </label>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 pt-3 border-t border-gray-100">
                        <button wire:click="$set('showDivisiForm', false)" class="px-5 py-2.5 border border-gray-200 text-gray-600 font-semibold rounded-xl text-sm hover:bg-gray-50">Batal</button>
                        <button wire:click="saveDivisi" class="px-5 py-2.5 bg-teal-600 text-white font-bold rounded-xl text-sm hover:bg-teal-700 shadow-lg">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endif
</div>
