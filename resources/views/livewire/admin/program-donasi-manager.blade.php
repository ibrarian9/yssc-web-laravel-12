<div>
    {{-- Alerts --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3 text-sm font-medium text-green-700">
            <span class="material-symbols-outlined text-[20px]!">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-extrabold text-gray-800">Program Donasi</h2>
            <p class="text-sm text-gray-500">Kelola status program penggalangan dana dan layanan donasi publik</p>
        </div>
        <button wire:click="create"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white font-bold text-sm rounded-xl shadow-lg shadow-teal-500/20 transition cursor-pointer">
            <span class="material-symbols-outlined text-[18px]!">add</span>
            Tambah Program
        </button>
    </div>

    {{-- ═══════════ MASTER TOGGLE MENU DONASI PUBLIK ═══════════ --}}
    <div class="mb-6 p-5 rounded-2xl border transition-all duration-300 {{ $isMenuDonasiActive ? 'bg-gradient-to-r from-teal-900 via-gray-900 to-gray-900 border-teal-700/50 text-white shadow-md' : 'bg-gradient-to-r from-amber-950 via-gray-900 to-gray-900 border-amber-700/50 text-white shadow-md' }}">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-start sm:items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 {{ $isMenuDonasiActive ? 'bg-teal-500/20 text-teal-400 border border-teal-500/30' : 'bg-amber-500/20 text-amber-400 border border-amber-500/30' }}">
                    <span class="material-symbols-outlined text-[26px]!">{{ $isMenuDonasiActive ? 'volunteer_activism' : 'block' }}</span>
                </div>
                <div>
                    <div class="flex items-center gap-2.5 flex-wrap">
                        <h3 class="text-base font-bold text-white">Status Menu Donasi Publik</h3>
                        @if($isMenuDonasiActive)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-teal-500/20 text-teal-300 border border-teal-500/40">
                                <span class="w-2 h-2 rounded-full bg-teal-400 animate-pulse"></span>
                                AKTIF DI WEBSITE
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-500/20 text-amber-300 border border-amber-500/40">
                                <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                                NON-AKTIF DI WEBSITE
                            </span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-300 mt-1">
                        @if($isMenuDonasiActive)
                            Menu donasi tampil di navigasi website dan pengunjung dapat melihat program serta menyalurkan donasi.
                        @else
                            Menu donasi disembunyikan sementara dari navigasi publik dan halaman donasi ditutup sementara.
                        @endif
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <button wire:click="toggleMenuDonasi"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition cursor-pointer shadow-md {{ $isMenuDonasiActive ? 'bg-amber-500/20 hover:bg-amber-500/30 text-amber-200 border border-amber-500/40' : 'bg-teal-500 hover:bg-teal-600 text-white shadow-teal-500/30' }}">
                    <span class="material-symbols-outlined text-[18px]!">{{ $isMenuDonasiActive ? 'power_settings_new' : 'check_circle' }}</span>
                    {{ $isMenuDonasiActive ? 'Nonaktifkan Menu Donasi' : 'Aktifkan Menu Donasi' }}
                </button>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-2xl p-5 shadow-md border border-gray-100 mb-6 flex flex-col lg:flex-row gap-4 items-stretch">
        <div class="flex-1 relative">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]!">search</span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari judul program donasi..."
                class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-base focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all bg-gray-50/30 focus:bg-white">
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <select wire:model.live="statusFilter"
                class="min-w-[180px] px-4 py-3 border border-gray-200 rounded-xl text-sm font-medium text-gray-600 focus:ring-2 focus:ring-teal-500 bg-white cursor-pointer hover:border-teal-300 transition-colors">
                <option value="">Semua Status</option>
                <option value="aktif">Aktif ({{ $totalActive }})</option>
                <option value="draft">Draft / Nonaktif ({{ $totalDraft }})</option>
                <option value="selesai">Selesai ({{ $totalSelesai }})</option>
            </select>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr class="text-left text-xs text-gray-500 uppercase tracking-wider">
                        <th class="px-4 py-3">Program</th>
                        <th class="px-4 py-3">Target Nominal</th>
                        <th class="px-4 py-3">Terkumpul</th>
                        <th class="px-4 py-3">Donatur</th>
                        <th class="px-4 py-3 text-center">Status (Klik untuk Ubah)</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($items as $item)
                        @php $pct = $item->target_nominal > 0 ? min(100, round(($item->total_donasi / $item->target_nominal) * 100)) : 0; @endphp
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    @if($item->thumbnail)
                                        @php $thumbUrl = \Illuminate\Support\Str::startsWith($item->thumbnail, ['http://', 'https://']) ? $item->thumbnail : asset('storage/' . $item->thumbnail); @endphp
                                        <img src="{{ $thumbUrl }}" class="w-12 h-12 rounded-xl object-cover shrink-0 border border-gray-100" alt="">
                                    @else
                                        <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center shrink-0 border border-teal-100 font-bold">
                                            <span class="material-symbols-outlined text-[20px]!">volunteer_activism</span>
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <p class="font-bold text-gray-800 max-w-[240px] truncate" title="{{ $item->judul }}">{{ $item->judul }}</p>
                                        @if($item->is_mendesak)
                                            <span class="inline-flex items-center gap-0.5 text-[11px] text-red-600 font-bold bg-red-50 px-2 py-0.5 rounded-md mt-0.5">
                                                <span class="material-symbols-outlined text-[13px]!">local_fire_department</span> Mendesak
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 font-semibold text-gray-700">Rp {{ number_format($item->target_nominal, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-24 bg-gray-100 rounded-full h-2 overflow-hidden">
                                        <div class="h-full rounded-full bg-teal-500 transition-all duration-300" style="width:{{ $pct }}%"></div>
                                    </div>
                                    <span class="text-xs font-semibold text-gray-600">{{ $pct }}%</span>
                                </div>
                                <span class="text-[11px] text-gray-400">Rp {{ number_format($item->total_donasi ?: 0, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-4 py-3 text-gray-600 font-medium">{{ $item->donasi_count }} donasi</td>
                            <td class="px-4 py-3 text-center">
                                @if($item->status === 'aktif')
                                    <button wire:click="toggleStatus({{ $item->id }})"
                                            title="Klik untuk menonaktifkan program ini"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-green-100 text-green-700 hover:bg-green-200 border border-green-200 shadow-xs transition cursor-pointer">
                                        <span class="w-2 h-2 rounded-full bg-green-600 animate-pulse"></span>
                                        Aktif
                                    </button>
                                @elseif($item->status === 'draft')
                                    <button wire:click="toggleStatus({{ $item->id }})"
                                            title="Klik untuk mengaktifkan program ini"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-gray-100 text-gray-600 hover:bg-teal-50 hover:text-teal-700 border border-gray-200 shadow-xs transition cursor-pointer">
                                        <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                                        Nonaktif (Draft)
                                    </button>
                                @else
                                    <button wire:click="toggleStatus({{ $item->id }})"
                                            title="Klik untuk mengaktifkan kembali program ini"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-blue-100 text-blue-700 hover:bg-blue-200 border border-blue-200 shadow-xs transition cursor-pointer">
                                        <span class="material-symbols-outlined text-[14px]!">task_alt</span>
                                        Selesai
                                    </button>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-1">
                                    <button wire:click="edit({{ $item->id }})" class="p-2 rounded-lg hover:bg-blue-50 text-blue-600 transition" title="Edit Program">
                                        <span class="material-symbols-outlined text-[18px]!">edit</span>
                                    </button>
                                    <button wire:click="confirmDelete({{ $item->id }})" class="p-2 rounded-lg hover:bg-red-50 text-red-500 transition" title="Hapus Program">
                                        <span class="material-symbols-outlined text-[18px]!">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-gray-400">
                                <span class="material-symbols-outlined text-[48px]! text-gray-300 block mb-2">volunteer_activism</span>
                                Tidak ada program donasi yang ditemukan.
                            </td>
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
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="$set('showForm', false)"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-800">{{ $isEditing ? 'Edit' : 'Tambah' }} Program Donasi</h3>
                <button wire:click="$set('showForm', false)" class="p-1 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600">
                    <span class="material-symbols-outlined">close</span>
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
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Status Publikasi</label>
                        <select wire:model="status"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                            <option value="aktif">Aktif (Tampil di Publik)</option>
                            <option value="draft">Non-aktif / Draft (Disembunyikan)</option>
                            <option value="selesai">Selesai (Target Tercapai)</option>
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
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Selesai (Opsional)</label>
                        <input type="date" wire:model="tanggal_selesai"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                    </div>
                </div>

                {{-- Mendesak toggle --}}
                <div class="flex items-center gap-3 p-3 bg-red-50/50 rounded-xl border border-red-100">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" wire:model.live="is_mendesak"
                            class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                        <span class="inline-flex items-center gap-1 text-sm font-medium text-gray-700">
                            <span class="material-symbols-outlined text-[16px]! text-red-500">local_fire_department</span>
                            Tandai sebagai program mendesak
                        </span>
                    </label>
                </div>

                {{-- Thumbnail --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Thumbnail <span class="text-xs text-gray-400 font-normal">(maks. 2MB)</span></label>
                    <input type="file" wire:model="newThumbnail" accept="image/*"
                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                    @error('newThumbnail') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Program <span class="text-red-500">*</span></label>
                    <textarea wire:model="deskripsi" rows="5" placeholder="Jelaskan tujuan dan penerima manfaat dari program ini..."
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500"></textarea>
                    @error('deskripsi') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Actions --}}
                <div class="flex justify-end gap-3 pt-3 border-t border-gray-100">
                    <button type="button" wire:click="$set('showForm', false)"
                        class="px-5 py-2.5 border border-gray-200 text-gray-600 font-semibold text-sm rounded-xl hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-teal-500/20 transition">
                        Simpan Program
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- Delete Modal --}}
    @if($showDeleteConfirm)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="$set('showDeleteConfirm', false)"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm text-center">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4 text-red-600">
                <span class="material-symbols-outlined text-[24px]!">delete</span>
            </div>
            <h3 class="text-base font-bold text-gray-800 mb-2">Hapus Program Donasi?</h3>
            <p class="text-sm text-gray-500 mb-6">Program donasi ini akan dihapus dari sistem.</p>
            <div class="flex gap-3 justify-center">
                <button wire:click="$set('showDeleteConfirm', false)" class="px-4 py-2 border border-gray-200 text-gray-600 text-sm font-semibold rounded-xl hover:bg-gray-50">Batal</button>
                <button wire:click="delete" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-red-500/20">Ya, Hapus</button>
            </div>
        </div>
    </div>
    @endif
</div>
