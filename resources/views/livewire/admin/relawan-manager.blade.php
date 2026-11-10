<div>
    {{-- Alerts --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3 text-sm font-medium text-green-700">
            <span class="material-symbols-outlined text-[20px]!">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-extrabold text-gray-800">Relawan</h2>
            <p class="text-sm text-gray-500">Kelola pendaftaran dan data relawan yayasan</p>
        </div>
        <div class="flex items-center gap-3">
            @if($pendingCount > 0)
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 text-amber-700 text-xs font-bold rounded-full border border-amber-200">
                    <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span>
                    {{ $pendingCount }} Pending
                </span>
            @endif
            <button wire:click="create"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white font-bold text-sm rounded-xl shadow-lg shadow-teal-500/20 transition cursor-pointer">
                <span class="material-symbols-outlined text-[18px]!">person_add</span>
                Tambah Relawan
            </button>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-2xl p-5 shadow-md border border-gray-100 mb-8 flex flex-col lg:flex-row gap-4 items-stretch">
        <div class="flex-1 relative">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]!">search</span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama, email, atau telepon..."
                   class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-base focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-gray-50/30 focus:bg-white transition">
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <select wire:model.live="filterStatus" class="min-w-[160px] px-4 py-3 border border-gray-200 rounded-xl text-sm font-medium text-gray-600 focus:ring-2 focus:ring-teal-500 bg-white cursor-pointer hover:border-teal-300 transition-colors">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="approved">Disetujui</option>
                <option value="rejected">Ditolak</option>
            </select>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr class="text-left text-xs text-gray-500 uppercase tracking-wider">
                        <th class="px-4 py-3">Relawan</th>
                        <th class="px-4 py-3">Telepon</th>
                        <th class="px-4 py-3">Keahlian</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($list as $r)
                        @php
                            $statusColors = [
                                'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                                'approved' => 'bg-green-100 text-green-700 border-green-200',
                                'rejected' => 'bg-red-100 text-red-700 border-red-200',
                            ];
                            $statusLabels = ['pending' => 'Pending', 'approved' => 'Disetujui', 'rejected' => 'Ditolak'];
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    @if($r->foto)
                                        <img src="{{ asset('storage/' . $r->foto) }}" class="w-10 h-10 rounded-full object-cover border border-gray-200 shrink-0" alt="">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center text-teal-700 font-bold text-sm shrink-0">
                                            {{ strtoupper(substr($r->nama, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $r->nama }}</p>
                                        <p class="text-xs text-gray-400">{{ $r->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $r->telepon }}</td>
                            <td class="px-4 py-3 text-gray-500 text-xs">{{ $r->keahlian ?? '—' }}</td>
                            @php
                                $relawanIcon = match($r->status) {
                                    'pending' => 'schedule',
                                    'approved' => 'check_circle',
                                    'rejected' => 'cancel',
                                    default => 'help_outline',
                                };
                            @endphp
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase border {{ $statusColors[$r->status] ?? 'bg-gray-100 text-gray-600 border-gray-200' }}">
                                    <span class="material-symbols-outlined text-[13px]!">{{ $relawanIcon }}</span>
                                    {{ $statusLabels[$r->status] ?? $r->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-xs text-gray-400 whitespace-nowrap">{{ $r->created_at->format('d/m/Y') }}</td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-1">
                                    <button wire:click="openDetail({{ $r->id }})" class="p-1.5 rounded-lg hover:bg-teal-50 text-teal-600 transition" title="Lihat Detail">
                                        <span class="material-symbols-outlined text-[18px]!">visibility</span>
                                    </button>
                                    <button wire:click="edit({{ $r->id }})" class="p-1.5 rounded-lg hover:bg-blue-50 text-blue-600 transition" title="Edit Data Relawan">
                                        <span class="material-symbols-outlined text-[18px]!">edit</span>
                                    </button>
                                    <button wire:click="confirmDelete({{ $r->id }})" class="p-1.5 rounded-lg hover:bg-red-50 text-red-500 transition" title="Hapus Data">
                                        <span class="material-symbols-outlined text-[18px]!">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-gray-400">
                                <span class="material-symbols-outlined text-4xl mb-2 text-gray-300">volunteer_activism</span>
                                <p class="text-sm">Tidak ada data relawan ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($list->hasPages())
            <div class="p-4 border-t border-gray-100">{{ $list->links() }}</div>
        @endif
    </div>

    {{-- Form Modal (Tambah / Edit Relawan) --}}
    @if($showFormModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="$set('showFormModal', false)"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden animate-in fade-in duration-200">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-teal-600">{{ $isEditing ? 'edit_note' : 'person_add' }}</span>
                    <h3 class="text-lg font-bold text-gray-800">{{ $isEditing ? 'Edit Data Relawan' : 'Tambah Relawan Baru' }}</h3>
                </div>
                <button wire:click="$set('showFormModal', false)" class="p-1 rounded-lg hover:bg-gray-200 text-gray-400">
                    <span class="material-symbols-outlined text-[20px]!">close</span>
                </button>
            </div>

            <form wire:submit="save" class="p-6 space-y-4 max-h-[80vh] overflow-y-auto">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap *</label>
                        <input type="text" wire:model="nama" placeholder="Nama relawan"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                        @error('nama') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Email *</label>
                        <input type="email" wire:model="email" placeholder="relawan@email.com"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                        @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Telepon / WhatsApp *</label>
                        <input type="text" wire:model="telepon" placeholder="08xxxxxxxxxx"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                        @error('telepon') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Lahir</label>
                        <input type="date" wire:model="tanggal_lahir"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                        @error('tanggal_lahir') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Pekerjaan</label>
                        <input type="text" wire:model="pekerjaan" placeholder="Mahasiswa, Guru, dsb."
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                        @error('pekerjaan') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Keahlian / Minat</label>
                        <input type="text" wire:model="keahlian" placeholder="Pengajaran, Medis, IT, Logistik"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                        @error('keahlian') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Domisili</label>
                    <textarea wire:model="alamat" rows="2" placeholder="Alamat lengkap domisili"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 resize-none"></textarea>
                    @error('alamat') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Motivasi Bergabung *</label>
                    <textarea wire:model="motivasi" rows="3" placeholder="Alasan atau motivasi ingin bergabung sebagai relawan..."
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 resize-none"></textarea>
                    @error('motivasi') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Status Persetujuan *</label>
                        <select wire:model="status" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 bg-white">
                            <option value="approved">Disetujui (Approved)</option>
                            <option value="pending">Menunggu (Pending)</option>
                            <option value="rejected">Ditolak (Rejected)</option>
                        </select>
                        @error('status') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Foto Profil Relawan</label>
                        <div class="flex items-center gap-3">
                            @if($foto)
                                <img src="{{ $foto->temporaryUrl() }}" class="w-12 h-12 rounded-xl object-cover border border-teal-500">
                            @elseif($existingFoto)
                                <img src="{{ asset('storage/' . $existingFoto) }}" class="w-12 h-12 rounded-xl object-cover border border-gray-200">
                            @endif
                            <input type="file" wire:model="foto" accept="image/*" class="flex-1 text-xs file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-teal-50 file:text-teal-700 file:font-semibold">
                        </div>
                        @error('foto') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Catatan Admin (Opsional)</label>
                    <input type="text" wire:model="formCatatanAdmin" placeholder="Catatan internal pengurus/admin..."
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" wire:click="$set('showFormModal', false)"
                        class="px-5 py-2.5 border border-gray-200 text-gray-600 font-semibold rounded-xl text-sm hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-xl text-sm shadow-md shadow-teal-500/20 transition cursor-pointer">
                        {{ $isEditing ? 'Simpan Perubahan' : 'Tambahkan Relawan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- Detail Modal --}}
    @if($showDetail && $selected)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="closeDetail"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden animate-in fade-in duration-200">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-lg font-bold text-gray-800">Detail Relawan</h3>
                    <button wire:click="closeDetail" class="p-1 rounded-lg hover:bg-gray-200 text-gray-400">
                        <span class="material-symbols-outlined text-[20px]!">close</span>
                    </button>
                </div>
                <div class="p-6 space-y-4 max-h-[80vh] overflow-y-auto">
                    <div class="flex items-center gap-4">
                        @if($selected->foto)
                            <img src="{{ asset('storage/' . $selected->foto) }}" class="w-16 h-16 rounded-2xl object-cover border-2 border-teal-200" alt="">
                        @else
                            <div class="w-16 h-16 rounded-2xl bg-teal-100 flex items-center justify-center text-teal-700 font-bold text-2xl">
                                {{ strtoupper(substr($selected->nama, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <h4 class="text-lg font-bold text-gray-800">{{ $selected->nama }}</h4>
                            <p class="text-sm text-gray-500">{{ $selected->email }}</p>
                            <p class="text-xs text-gray-400">{{ $selected->telepon }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 text-xs bg-gray-50 rounded-xl p-3 border border-gray-100">
                        <div>
                            <p class="text-gray-400 uppercase font-bold text-[10px]">Pekerjaan</p>
                            <p class="font-semibold text-gray-700">{{ $selected->pekerjaan ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 uppercase font-bold text-[10px]">Keahlian</p>
                            <p class="font-semibold text-gray-700">{{ $selected->keahlian ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 uppercase font-bold text-[10px]">Tgl Lahir</p>
                            <p class="font-semibold text-gray-700">{{ $selected->tanggal_lahir ? $selected->tanggal_lahir->format('d/m/Y') : '—' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 uppercase font-bold text-[10px]">Status</p>
                            <span class="font-bold uppercase text-[10px] {{ $selected->status === 'approved' ? 'text-green-600' : ($selected->status === 'pending' ? 'text-amber-600' : 'text-red-600') }}">
                                {{ $selected->status }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Alamat</p>
                        <p class="text-sm text-gray-700 bg-gray-50 rounded-xl p-3">{{ $selected->alamat ?? '—' }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Motivasi</p>
                        <p class="text-sm text-gray-700 bg-gray-50 rounded-xl p-3 leading-relaxed">{{ $selected->motivasi }}</p>
                    </div>

                    @if($selected->catatan_admin)
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Catatan Admin</p>
                            <p class="text-sm text-gray-700 bg-amber-50 border border-amber-100 rounded-xl p-3">{{ $selected->catatan_admin }}</p>
                        </div>
                    @endif

                    <div class="flex gap-2 pt-3 border-t border-gray-100">
                        @if($selected->status === 'pending')
                            <button wire:click="approve" class="flex-1 py-2.5 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl text-sm transition">
                                Setujui
                            </button>
                            <button wire:click="reject" class="flex-1 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl text-sm transition">
                                Tolak
                            </button>
                        @elseif($selected->status === 'approved')
                            <button wire:click="reject" class="flex-1 py-2.5 border border-red-200 text-red-600 hover:bg-red-50 font-bold rounded-xl text-sm transition">
                                Nonaktifkan Relawan
                            </button>
                        @else
                            <button wire:click="approve" class="flex-1 py-2.5 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl text-sm transition">
                                Setujui Kembali
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Delete Confirm Modal --}}
    @if($showDeleteConfirm)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="$set('showDeleteConfirm', false)"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center animate-in fade-in duration-200">
            <div class="w-12 h-12 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-2xl">warning</span>
            </div>
            <h4 class="text-lg font-bold text-gray-800 mb-2">Hapus Relawan?</h4>
            <p class="text-sm text-gray-500 mb-6">Data relawan ini akan dihapus permanen. Lanjutkan?</p>
            <div class="flex justify-center gap-3">
                <button type="button" wire:click="$set('showDeleteConfirm', false)"
                    class="px-4 py-2 border border-gray-200 text-gray-600 font-medium rounded-xl text-sm hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="button" wire:click="executeDelete"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl text-sm shadow-md shadow-red-500/20 transition">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
