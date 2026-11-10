<div>
    {{-- Alerts --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3 text-sm font-medium text-green-700">
            <span class="material-symbols-outlined text-[20px]!">check_circle</span>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3 text-sm font-medium text-red-700">
            <span class="material-symbols-outlined text-[20px]!">error</span>
            {{ session('error') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-extrabold text-gray-800">Manajemen Mitra</h2>
            <p class="text-sm text-gray-500">Kelola data mitra kerja sama dan pendaftaran kemitraan</p>
        </div>
        <div class="flex items-center gap-3">
            @if($pendingCount > 0)
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-100 text-amber-700 rounded-full text-xs font-bold border border-amber-200">
                    <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span>
                    {{ $pendingCount }} Menunggu Persetujuan
                </span>
            @endif
            <button wire:click="create"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white font-bold text-sm rounded-xl shadow-lg shadow-teal-500/20 transition cursor-pointer">
                <span class="material-symbols-outlined text-[18px]!">domain_add</span>
                Tambah Mitra
            </button>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-2xl p-5 shadow-md border border-gray-100 mb-8 flex flex-col lg:flex-row gap-4 items-stretch">
        <div class="flex-1 relative">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]!">search</span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama perusahaan, email, telepon, NPWP..."
                class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-base focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 bg-gray-50/30 focus:bg-white">
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <select wire:model.live="filterStatus"
                class="min-w-[160px] px-4 py-3 border border-gray-200 rounded-xl text-sm font-medium text-gray-600 focus:ring-2 focus:ring-teal-500 bg-white cursor-pointer hover:border-teal-300 transition-colors">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50/80 border-b border-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Perusahaan / Mitra</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Jenis</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">NPWP</th>
                        <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wider text-gray-500">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Terdaftar</th>
                        <th class="px-4 py-3 text-right text-xs font-bold uppercase tracking-wider text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($mitraList as $m)
                        <tr class="hover:bg-gray-50/50 transition {{ $m->status === 'pending' ? 'bg-amber-50/20' : '' }}">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    @if($m->logo)
                                        <img src="{{ asset('storage/' . $m->logo) }}" class="w-10 h-10 rounded-xl object-contain border border-gray-200 bg-white p-1 shrink-0" alt="">
                                    @else
                                        <div class="w-10 h-10 rounded-xl bg-teal-100 flex items-center justify-center text-teal-700 font-bold text-sm shrink-0">
                                            {{ strtoupper(substr($m->nama_perusahaan, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-semibold text-gray-800">{{ $m->nama_perusahaan }}</div>
                                        <div class="text-xs text-gray-400">{{ $m->email }} · {{ $m->telepon }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2.5 py-0.5 bg-gray-100 text-gray-700 rounded-md text-xs font-semibold">
                                    {{ $m->jenis_mitra->label() }}
                                </span>
                            </td>
                            <td class="px-4 py-3 font-mono text-xs text-gray-600">{{ $m->npwp ?: '—' }}</td>
                            <td class="px-4 py-3 text-center">
                                @php
                                    $sc = [
                                        'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                                        'approved' => 'bg-green-100 text-green-700 border-green-200',
                                        'rejected' => 'bg-red-100 text-red-700 border-red-200',
                                    ];
                                    $mitraIcon = match($m->status) {
                                        'pending' => 'schedule',
                                        'approved' => 'check_circle',
                                        'rejected' => 'cancel',
                                        default => 'help_outline',
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold uppercase border {{ $sc[$m->status] ?? 'bg-gray-100 text-gray-600' }}">
                                    <span class="material-symbols-outlined text-[13px]!">{{ $mitraIcon }}</span>
                                    {{ $m->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-xs text-gray-400 whitespace-nowrap">{{ $m->created_at->format('d/m/Y') }}</td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-1">
                                    <button wire:click="openDetail({{ $m->id }})" class="p-1.5 rounded-lg hover:bg-teal-50 text-teal-600 transition" title="Lihat Detail & Dokumen">
                                        <span class="material-symbols-outlined text-[18px]!">visibility</span>
                                    </button>
                                    <button wire:click="edit({{ $m->id }})" class="p-1.5 rounded-lg hover:bg-blue-50 text-blue-600 transition" title="Edit Data Mitra">
                                        <span class="material-symbols-outlined text-[18px]!">edit</span>
                                    </button>
                                    <button wire:click="confirmDelete({{ $m->id }})" class="p-1.5 rounded-lg hover:bg-red-50 text-red-500 transition" title="Hapus Mitra">
                                        <span class="material-symbols-outlined text-[18px]!">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-gray-400">
                                <span class="material-symbols-outlined text-4xl mb-2 text-gray-300">handshake</span>
                                <p class="text-sm">Tidak ada data mitra ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($mitraList->hasPages())
            <div class="p-4 border-t border-gray-100">{{ $mitraList->links() }}</div>
        @endif
    </div>

    {{-- Form Modal (Tambah / Edit Mitra) --}}
    @if($showFormModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="$set('showFormModal', false)"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden animate-in fade-in duration-200">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-teal-600">{{ $isEditing ? 'edit_note' : 'domain_add' }}</span>
                    <h3 class="text-lg font-bold text-gray-800">{{ $isEditing ? 'Edit Data Mitra' : 'Tambah Mitra Baru' }}</h3>
                </div>
                <button wire:click="$set('showFormModal', false)" class="p-1 rounded-lg hover:bg-gray-200 text-gray-400">
                    <span class="material-symbols-outlined text-[20px]!">close</span>
                </button>
            </div>

            <form wire:submit="save" class="p-6 space-y-4 max-h-[80vh] overflow-y-auto">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Jenis Kemitraan *</label>
                        <select wire:model="jenis_mitra" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 bg-white">
                            @foreach($jenisOptions as $j)
                                <option value="{{ $j->value }}">{{ $j->label() }}</option>
                            @endforeach
                        </select>
                        @error('jenis_mitra') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Perusahaan / Organisasi *</label>
                        <input type="text" wire:model="nama_perusahaan" placeholder="PT Contoh Kebaikan"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                        @error('nama_perusahaan') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Email Mitra *</label>
                        <input type="email" wire:model="email" placeholder="mitra@perusahaan.com"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                        @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Telepon / PIC *</label>
                        <input type="text" wire:model="telepon" placeholder="08xxxxxxxxxx"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                        @error('telepon') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor NPWP</label>
                        <input type="text" wire:model="npwp" placeholder="00.000.000.0-000.000"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                        @error('npwp') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Singkat Profil Mitra</label>
                    <textarea wire:model="deskripsi" rows="2" placeholder="Profil singkat profil bisnis atau kemitraan..."
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 resize-none"></textarea>
                    @error('deskripsi') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Uploads --}}
                <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 space-y-3">
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-600">Logo & Dokumen Pendukung</p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Logo Mitra</label>
                            @if($logo)
                                <img src="{{ $logo->temporaryUrl() }}" class="w-10 h-10 rounded-lg object-contain border mb-1">
                            @elseif($existingLogo)
                                <img src="{{ asset('storage/' . $existingLogo) }}" class="w-10 h-10 rounded-lg object-contain border mb-1">
                            @endif
                            <input type="file" wire:model="logo" accept="image/*" class="w-full text-xs file:mr-2 file:py-1 file:px-2 file:rounded-md file:border-0 file:bg-teal-50 file:text-teal-700 file:font-semibold">
                            @error('logo') <p class="text-xs text-red-500 mt-0.5">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">File NPWP (PDF/Gambar)</label>
                            @if($existingDokumenNpwp)
                                <span class="inline-flex items-center gap-1 text-[11px] text-teal-600 font-medium mb-1">
                                    <span class="material-symbols-outlined text-[14px]!">check_circle</span> Dokumen ada
                                </span>
                            @endif
                            <input type="file" wire:model="dokumen_npwp" class="w-full text-xs file:mr-2 file:py-1 file:px-2 file:rounded-md file:border-0 file:bg-teal-50 file:text-teal-700 file:font-semibold">
                            @error('dokumen_npwp') <p class="text-xs text-red-500 mt-0.5">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Legalitas (Akta/NIB)</label>
                            @if($existingDokumenLegalitas)
                                <span class="inline-flex items-center gap-1 text-[11px] text-teal-600 font-medium mb-1">
                                    <span class="material-symbols-outlined text-[14px]!">check_circle</span> Dokumen ada
                                </span>
                            @endif
                            <input type="file" wire:model="dokumen_legalitas" class="w-full text-xs file:mr-2 file:py-1 file:px-2 file:rounded-md file:border-0 file:bg-teal-50 file:text-teal-700 file:font-semibold">
                            @error('dokumen_legalitas') <p class="text-xs text-red-500 mt-0.5">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Status & User Account --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Status Kemitraan *</label>
                        <select wire:model="status" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 bg-white">
                            <option value="approved">Disetujui (Approved)</option>
                            <option value="pending">Menunggu (Pending)</option>
                            <option value="rejected">Ditolak (Rejected)</option>
                        </select>
                        @error('status') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Catatan Admin (Opsional)</label>
                        <input type="text" wire:model="formCatatanAdmin" placeholder="Catatan internal pengurus..."
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                    </div>
                </div>

                @if(!$isEditing)
                <div class="p-4 bg-teal-50/50 rounded-xl border border-teal-100 space-y-3">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" wire:model.live="createUserAccount" class="rounded border-gray-300 text-teal-600 focus:ring-teal-500">
                        <span class="text-sm font-semibold text-teal-900">Buat Akun Login Mitra Secara Otomatis</span>
                    </label>

                    @if($createUserAccount)
                    <div class="pt-2">
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Password Akun (Kosongkan untuk generate acak)</label>
                        <input type="password" wire:model="userPassword" placeholder="Minimal 8 karakter"
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 bg-white">
                        @error('userPassword') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    @endif
                </div>
                @endif

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" wire:click="$set('showFormModal', false)"
                        class="px-5 py-2.5 border border-gray-200 text-gray-600 font-semibold rounded-xl text-sm hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-xl text-sm shadow-md shadow-teal-500/20 transition cursor-pointer">
                        {{ $isEditing ? 'Simpan Perubahan' : 'Tambahkan Mitra' }}
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
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-teal-600">business</span>
                        <h3 class="text-lg font-bold text-gray-800">Detail Mitra</h3>
                    </div>
                    <button wire:click="closeDetail" class="p-1 rounded-lg hover:bg-gray-200 text-gray-400">
                        <span class="material-symbols-outlined text-[20px]!">close</span>
                    </button>
                </div>

                <div class="p-6 space-y-4 max-h-[80vh] overflow-y-auto">
                    <div class="flex items-center gap-4">
                        @if($selected->logo)
                            <img src="{{ asset('storage/' . $selected->logo) }}" class="w-16 h-16 rounded-2xl object-contain border p-1 bg-white" alt="">
                        @else
                            <div class="w-16 h-16 rounded-2xl bg-teal-100 flex items-center justify-center text-teal-700 font-bold text-2xl">
                                {{ strtoupper(substr($selected->nama_perusahaan, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <h4 class="text-lg font-bold text-gray-800">{{ $selected->nama_perusahaan }}</h4>
                            <p class="text-sm text-gray-500">{{ $selected->email }}</p>
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                {{ $selected->jenis_mitra->label() }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 text-xs bg-gray-50 rounded-xl p-3 border border-gray-100">
                        <div>
                            <p class="text-gray-400 uppercase font-bold text-[10px]">Nomor Telepon</p>
                            <p class="font-semibold text-gray-700">{{ $selected->telepon }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 uppercase font-bold text-[10px]">NPWP</p>
                            <p class="font-mono text-gray-700">{{ $selected->npwp ?: '—' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 uppercase font-bold text-[10px]">Akun User Terhubung</p>
                            <p class="font-semibold text-gray-700">{{ $selected->user?->name ?? 'Belum ada akun' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 uppercase font-bold text-[10px]">Status</p>
                            <span class="font-bold uppercase text-[10px] {{ $selected->status === 'approved' ? 'text-green-600' : ($selected->status === 'pending' ? 'text-amber-600' : 'text-red-600') }}">
                                {{ $selected->status }}
                            </span>
                        </div>
                    </div>

                    @if($selected->deskripsi)
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Deskripsi</p>
                        <p class="text-sm text-gray-700 bg-gray-50 rounded-xl p-3">{{ $selected->deskripsi }}</p>
                    </div>
                    @endif

                    {{-- Download Documents --}}
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Dokumen Legalitas & Verifikasi</p>
                        <div class="space-y-2">
                            @if($selected->dokumen_npwp)
                                <a href="{{ route('admin.mitra.dokumen', [$selected, 'npwp']) }}" target="_blank"
                                    class="flex items-center justify-between p-3 border border-gray-200 rounded-xl hover:bg-gray-50 text-sm text-teal-700 font-medium">
                                    <span class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[18px]!">description</span>
                                        Dokumen NPWP
                                    </span>
                                    <span class="material-symbols-outlined text-[18px]!">download</span>
                                </a>
                            @else
                                <p class="text-xs text-gray-400 italic">Dokumen NPWP belum diunggah.</p>
                            @endif

                            @if($selected->dokumen_legalitas)
                                <a href="{{ route('admin.mitra.dokumen', [$selected, 'legalitas']) }}" target="_blank"
                                    class="flex items-center justify-between p-3 border border-gray-200 rounded-xl hover:bg-gray-50 text-sm text-teal-700 font-medium">
                                    <span class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[18px]!">verified</span>
                                        Dokumen Legalitas (Akta / NIB)
                                    </span>
                                    <span class="material-symbols-outlined text-[18px]!">download</span>
                                </a>
                            @else
                                <p class="text-xs text-gray-400 italic">Dokumen Legalitas belum diunggah.</p>
                            @endif
                        </div>
                    </div>

                    {{-- Approval Action if pending --}}
                    @if($selected->status === 'pending')
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1">Catatan Admin</label>
                            <textarea wire:model="catatanAdmin" rows="2" placeholder="Catatan untuk mitra..."
                                class="w-full px-4 py-2 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 resize-none"></textarea>
                        </div>
                        <div class="flex gap-2 pt-2">
                            <button wire:click="approve" class="flex-1 py-2.5 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl text-sm transition">
                                Setujui Mitra
                            </button>
                            <button wire:click="reject" class="flex-1 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl text-sm transition">
                                Tolak Mitra
                            </button>
                        </div>
                    @else
                        <div class="flex gap-2 pt-2 border-t border-gray-100">
                            @if($selected->status === 'approved')
                                <button wire:click="changeStatus('rejected')" class="flex-1 py-2 border border-red-200 text-red-600 hover:bg-red-50 font-semibold rounded-xl text-sm transition">
                                    Nonaktifkan Mitra
                                </button>
                            @else
                                <button wire:click="changeStatus('approved')" class="flex-1 py-2 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl text-sm transition">
                                    Aktifkan Mitra
                                </button>
                            @endif
                        </div>
                    @endif
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
            <h4 class="text-lg font-bold text-gray-800 mb-2">Hapus Data Mitra?</h4>
            <p class="text-sm text-gray-500 mb-6">Data mitra dan dokumennya akan dihapus dari sistem. Lanjutkan?</p>
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
