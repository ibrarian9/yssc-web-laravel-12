<x-layouts.public>
    <x-slot:title>Ubah Password</x-slot:title>

    <div class="min-h-[70vh] flex items-center justify-center py-16 px-4">
        <div class="w-full max-w-md">
            {{-- Warning Banner --}}
            <div class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-2xl flex items-start gap-3">
                <span class="material-symbols-outlined text-amber-500 text-[24px]! mt-0.5 shrink-0">lock_reset</span>
                <div>
                    <p class="font-bold text-amber-800 text-sm">Ganti Password Diperlukan</p>
                    <p class="text-xs text-amber-600 mt-1">Demi keamanan akun Anda, silakan ganti password yang diberikan melalui email dengan password baru pilihan Anda.</p>
                </div>
            </div>

            {{-- Form Card --}}
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 bg-gradient-to-r from-teal-600 to-teal-700 text-center">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-3">
                        <span class="material-symbols-outlined text-white text-[32px]!">shield_lock</span>
                    </div>
                    <h2 class="text-xl font-bold text-white">Ubah Password</h2>
                    <p class="text-teal-100 text-sm mt-1">Buat password baru yang aman</p>
                </div>

                <form method="POST" action="{{ route('password.force-change') }}" class="p-8 space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password Saat Ini</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]!">lock</span>
                            <input type="password" name="current_password" required autofocus
                                   class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                   placeholder="Masukkan password dari email">
                        </div>
                        @error('current_password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password Baru</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]!">lock_open</span>
                            <input type="password" name="password" required
                                   class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                   placeholder="Minimal 8 karakter">
                        </div>
                        @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]!">verified_user</span>
                            <input type="password" name="password_confirmation" required
                                   class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                   placeholder="Ulangi password baru">
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full py-3 bg-gradient-to-r from-teal-600 to-teal-700 text-white font-bold rounded-xl hover:from-teal-700 hover:to-teal-800 shadow-lg transition-all text-sm">
                        Ubah Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.public>
