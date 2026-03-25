<div>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div><h2 class="text-2xl font-extrabold text-gray-800">Pengguna</h2><p class="text-sm text-gray-500">Kelola akun pengguna dan peran</p></div>
    </div>

    <div class="bg-white rounded-2xl p-5 shadow-md border border-gray-100 mb-8 flex flex-col lg:flex-row gap-4 items-stretch">
        <div class="flex-1 relative">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]!">search</span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama atau email..."
                class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-base focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 bg-gray-50/30 focus:bg-white">
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <select wire:model.live="roleFilter"
                class="min-w-[140px] px-4 py-3 border border-gray-200 rounded-xl text-sm font-medium text-gray-600 focus:ring-2 focus:ring-teal-500 bg-white cursor-pointer hover:border-teal-300 transition-colors">
                <option value="">Semua Role</option>
                @foreach(App\Enums\UserRole::cases() as $r)
                    <option value="{{ $r->value }}">{{ $r->label() }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr class="text-left text-xs text-gray-500 uppercase tracking-wider">
                        <th class="px-4 py-3">User</th><th class="px-4 py-3">Role</th><th class="px-4 py-3">Status</th><th class="px-4 py-3">Verified</th><th class="px-4 py-3">Bergabung</th><th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 bg-teal-100 rounded-full flex items-center justify-center shrink-0"><span class="text-teal-700 font-bold text-sm">{{ substr($user->name, 0, 1) }}</span></div>
                                    <div><p class="font-semibold text-gray-800">{{ $user->name }}</p><p class="text-xs text-gray-400">{{ $user->email }}</p></div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                @php $rc = ['superadmin' => 'bg-red-100 text-red-700', 'admin' => 'bg-purple-100 text-purple-700', 'member' => 'bg-blue-100 text-blue-700', 'guest' => 'bg-gray-200 text-gray-600']; @endphp
                                <span class="px-2 py-0.5 rounded-full text-xs font-bold {{ $rc[$user->role->value] ?? '' }}">{{ $user->role->label() }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <button wire:click="toggleActive({{ $user->id }})" class="px-2 py-0.5 rounded-full text-xs font-bold cursor-pointer {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}" {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                    {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </td>
                            <td class="px-4 py-3">
                                @if($user->email_verified_at)
                                    <span class="material-symbols-outlined text-green-500 text-[18px]!">verified</span>
                                @else
                                    <span class="material-symbols-outlined text-gray-300 text-[18px]!">cancel</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-400 text-xs">{{ $user->created_at->format('d/m/Y') }}</td>
                            <td class="px-4 py-3"><div class="flex justify-end"><button wire:click="edit({{ $user->id }})" class="p-1.5 rounded-lg hover:bg-blue-50 text-blue-600"><span class="material-symbols-outlined text-[18px]!">edit</span></button></div></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-10 text-center text-gray-400">Belum ada user.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages()) <div class="p-4 border-t border-gray-100">{{ $users->links() }}</div> @endif
    </div>

    @if($showForm)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="$set('showForm', false)"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-800">Edit User</h3>
                <button wire:click="$set('showForm', false)" class="p-1 rounded-lg hover:bg-gray-100"><span class="material-symbols-outlined text-gray-400">close</span></button>
            </div>
            <form wire:submit="save" class="p-6 space-y-4">
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Nama</label><input type="text" wire:model="name" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">@error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror</div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Email</label><input type="email" wire:model="email" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">@error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror</div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Role</label>
                    <select wire:model="role" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                        @foreach(App\Enums\UserRole::cases() as $r) <option value="{{ $r->value }}">{{ $r->label() }}</option> @endforeach
                    </select></div>
                <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" wire:model="is_active" class="rounded border-gray-300 text-teal-600"><span class="text-sm text-gray-600">Akun Aktif</span></label>
                <div class="flex justify-end gap-3 pt-3 border-t border-gray-100">
                    <button type="button" wire:click="$set('showForm', false)" class="px-5 py-2.5 border border-gray-200 text-gray-600 font-semibold rounded-xl text-sm">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-teal-600 text-white font-bold rounded-xl text-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
