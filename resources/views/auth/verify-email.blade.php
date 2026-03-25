<x-layouts.public>
    <x-slot:title>Verifikasi Email — YSSC</x-slot:title>
    <section class="min-h-[80vh] flex items-center py-16 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="max-w-md mx-auto bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                <span class="material-symbols-outlined text-[64px]! text-teal-500 mb-4">mark_email_read</span>
                <h1 class="text-2xl font-extrabold text-gray-800 mb-3">Verifikasi Email Anda</h1>
                <p class="text-gray-500 text-sm mb-6">Kami telah mengirimkan link verifikasi ke email Anda. Silakan cek inbox atau folder spam.</p>
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="w-full py-3 bg-teal-600 text-white font-bold rounded-xl hover:bg-teal-700 transition">
                        Kirim Ulang Link Verifikasi
                    </button>
                </form>
            </div>
        </div>
    </section>
</x-layouts.public>
