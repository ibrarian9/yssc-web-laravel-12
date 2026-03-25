<x-layouts.public>
    <x-slot:title>Lupa Password — YSSC</x-slot:title>
    <section class="min-h-[80vh] flex items-center py-16 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-md mx-auto">
                <div class="text-center mb-8">
                    @php $authLogo = \App\Models\Profile::first(); @endphp
                    <a href="{{ route('home') }}"><img src="{{ $authLogo?->logo ? asset('storage/' . $authLogo->logo) : asset('assets/logo.png') }}" alt="Logo" class="h-14 mx-auto mb-4"></a>
                    <h1 class="text-2xl font-extrabold text-gray-800">Lupa Password</h1>
                    <p class="text-gray-500 text-sm mt-1">Masukkan email Anda untuk menerima link reset password.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-gray-100">
                    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <button type="submit" class="w-full py-3 bg-gradient-to-r from-teal-600 to-teal-700 text-white font-bold rounded-xl hover:from-teal-700 hover:to-teal-800 shadow-lg transition-all">
                            Kirim Link Reset
                        </button>
                    </form>
                    <p class="text-center mt-4"><a href="{{ route('login') }}" class="text-sm text-teal-600 font-semibold hover:underline">← Kembali ke Login</a></p>
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>
