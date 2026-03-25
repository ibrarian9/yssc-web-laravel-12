<x-layouts.public>
    <x-slot:title>Reset Password — YSSC</x-slot:title>
    <section class="min-h-[80vh] flex items-center py-16 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-md mx-auto">
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-extrabold text-gray-800">Reset Password</h1>
                </div>
                <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-gray-100">
                    <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email', $email) }}" required
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Password Baru</label>
                            <input type="password" name="password" required
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" required
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        </div>
                        <button type="submit" class="w-full py-3 bg-gradient-to-r from-teal-600 to-teal-700 text-white font-bold rounded-xl shadow-lg transition-all">
                            Reset Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>
