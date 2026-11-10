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
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-extrabold text-gray-800">Manajemen Pengguna</h2>
            <p class="text-sm text-gray-500">Kelola akun, role, dan hak akses pengguna sistem</p>
        </div>
        <button wire:click="create"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white font-bold text-sm rounded-xl shadow-lg shadow-teal-500/20 transition cursor-pointer">
            <span class="material-symbols-outlined text-[18px]!">person_add</span>
            Tambah Pengguna
        </button>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-2xl p-5 shadow-md border border-gray-100 mb-8 flex flex-col lg:flex-row gap-4 items-stretch">
        <div class="flex-1 relative">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]!">search</span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama, email, atau telepon..."
                class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-base focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 bg-gray-50/30 focus:bg-white">
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <select wire:model.live="roleFilter"
                class="min-w-[160px] px-4 py-3 border border-gray-200 rounded-xl text-sm font-medium text-gray-600 focus:ring-2 focus:ring-teal-500 bg-white cursor-pointer hover:border-teal-300 transition-colors">
                <option value="">Semua Role</option>
                @foreach($roles as $r)
                    <option value="{{ $r->value }}">{{ $r->label() }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr class="text-left text-xs text-gray-500 uppercase tracking-wider">
                        <th class="px-4 py-3">Pengguna</th>
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Verifikasi</th>
                        <th class="px-4 py-3">Bergabung</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-teal-100 text-teal-700 font-bold rounded-xl flex items-center justify-center shrink-0">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-400">{{ $user->email }}</p>
                                        @if($user->phone)
                                            <p class="text-[11px] text-gray-400">{{ $user->phone }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $roleBadge = match($user->role->value ?? '') {
                                        'superadmin' => 'bg-red-100 text-red-700 border-red-200',
                                        'admin' => 'bg-purple-100 text-purple-700 border-purple-200',
                                        'mitra' => 'bg-amber-100 text-amber-700 border-amber-200',
                                        'member' => 'bg-blue-100 text-blue-700 border-blue-200',
                                        default => 'bg-gray-100 text-gray-600 border-gray-200',
                                    };
                                @endphp
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $roleBadge }}">
                                    {{ $user->role->label() }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <button wire:click="toggleActive({{ $user->id }})"
                                    class="px-2.5 py-0.5 rounded-full text-xs font-bold transition cursor-pointer {{ $user->is_active ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-red-100 text-red-700 hover:bg-red-200' }}"
                                    {{ $user->id === auth()->id() ? 'disabled title=Tidak-dapat-menonaktifkan-diri-sendiri' : '' }}>
                                    {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </td>
                            <td class="px-4 py-3">
                                @if($user->email_verified_at)
                                    <span class="inline-flex items-center gap-1 text-green-600 text-xs font-semibold">
                                        <span class="material-symbols-outlined text-[16px]!">verified</span> Terverifikasi
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-gray-400 text-xs">
                                        <span class="material-symbols-outlined text-[16px]!">pending</span> Belum Verifikasi
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-400 text-xs whitespace-nowrap">
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-1">
                                    <button wire:click="edit({{ $user->id }})" class="p-1.5 rounded-lg hover:bg-blue-50 text-blue-600 transition" title="Edit Pengguna">
                                        <span class="material-symbols-outlined text-[18px]!">edit</span>
                                    </button>
                                    @if($user->id !== auth()->id())
                                        <button wire:click="confirmDelete({{ $user->id }})" class="p-1.5 rounded-lg hover:bg-red-50 text-red-500 transition" title="Hapus Pengguna">
                                            <span class="material-symbols-outlined text-[18px]!">delete</span>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-gray-400">
                                <span class="material-symbols-outlined text-4xl mb-2 text-gray-300">group_off</span>
                                <p class="text-sm">Tidak ada pengguna ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
            <div class="p-4 border-t border-gray-100">{{ $users->links() }}</div>
        @endif
    </div>

    {{-- Form Modal (Create / Edit) --}}
    @if($showForm)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="$set('showForm', false)"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden animate-in fade-in duration-200">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-teal-600">{{ $isEditing ? 'manage_accounts' : 'person_add' }}</span>
                    <h3 class="text-lg font-bold text-gray-800">{{ $isEditing ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}</h3>
                </div>
                <button wire:click="$set('showForm', false)" class="p-1 rounded-lg hover:bg-gray-200 text-gray-400">
                    <span class="material-symbols-outlined text-[20px]!">close</span>
                </button>
            </div>

            <form wire:submit="save" class="p-6 space-y-4 max-h-[80vh] overflow-y-auto">
                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap *</label>
                    <input type="text" wire:model="name" placeholder="cth: Ahmad Fauzi"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Email & Telepon --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Email *</label>
                        <input type="email" wire:model="email" placeholder="user@contoh.com"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Telepon</label>
                        <input type="text" wire:model="phone" placeholder="08xxxxxxxxxx"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        @error('phone') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Role Selection --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Role / Peran Pengguna *</label>
                    <select wire:model="role" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-white">
                        @foreach($roles as $r)
                            <option value="{{ $r->value }}">{{ $r->label() }}</option>
                        @endforeach
                    </select>
                    <p class="text-[11px] text-gray-400 mt-1">
                        Pilih peran: <strong>Super Admin / Admin</strong> untuk akses panel penuh, <strong>Mitra</strong> untuk dashboard mitra, <strong>Member</strong> untuk anggota umum.
                    </p>
                    @error('role') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Password Section --}}
                <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="text-xs font-bold uppercase tracking-wider text-gray-600">
                            {{ $isEditing ? 'Ubah Password (Opsional)' : 'Password Akun *' }}
                        </label>
                        @if($isEditing)
                            <span class="text-[11px] text-gray-400">Kosongkan jika tidak diubah</span>
                        @endif
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <input type="password" wire:model="password" placeholder="Password (min. 8 karakter)"
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 bg-white">
                            @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <input type="password" wire:model="password_confirmation" placeholder="Ulangi Password"
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 bg-white">
                        </div>
                    </div>
                </div>

                {{-- Options Checkboxes --}}
                <div class="space-y-2 pt-2 border-t border-gray-100">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" wire:model="is_active" class="rounded border-gray-300 text-teal-600 focus:ring-teal-500">
                        <span class="text-sm font-medium text-gray-700">Akun Aktif (Dapat Login)</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" wire:model="email_verified" class="rounded border-gray-300 text-teal-600 focus:ring-teal-500">
                        <span class="text-sm text-gray-600">Email Langsung Terverifikasi</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" wire:model="must_change_password" class="rounded border-gray-300 text-teal-600 focus:ring-teal-500">
                        <span class="text-sm text-gray-600">Wajib Ganti Password saat Login Pertama Kali</span>
                    </label>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" wire:click="$set('showForm', false)"
                        class="px-5 py-2.5 border border-gray-200 text-gray-600 font-semibold rounded-xl text-sm hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-xl text-sm shadow-md shadow-teal-500/20 transition cursor-pointer">
                        {{ $isEditing ? 'Simpan Perubahan' : 'Buat Pengguna' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- Delete Modal --}}
    @if($showDeleteModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="$set('showDeleteModal', false)"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center animate-in fade-in duration-200">
            <div class="w-12 h-12 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-2xl">warning</span>
            </div>
            <h4 class="text-lg font-bold text-gray-800 mb-2">Hapus Pengguna?</h4>
            <p class="text-sm text-gray-500 mb-6">Akun pengguna ini akan dihapus dari sistem. Anda yakin ingin melanjutkan?</p>
            <div class="flex justify-center gap-3">
                <button type="button" wire:click="$set('showDeleteModal', false)"
                    class="px-4 py-2 border border-gray-200 text-gray-600 font-medium rounded-xl text-sm hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="button" wire:click="deleteUser"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl text-sm shadow-md shadow-red-500/20 transition">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
