<x-layouts.public>
    <x-slot:title>Cek Status Perizinan — Yayasan Seribu Satu Cita</x-slot:title>

    {{-- Hero Section --}}
    <section class="relative bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 py-20 md:py-28 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 right-20 w-72 h-72 bg-teal-400 rounded-full blur-3xl"></div>
        </div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-teal-500/20 border border-teal-500/30 rounded-full mb-6">
                <span class="material-symbols-outlined text-teal-400 text-[18px]!">manage_search</span>
                <span class="text-teal-300 text-sm font-semibold">Tracking Permohonan</span>
            </div>
            <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-4">Cek Status Permohonan</h1>
            <p class="text-gray-400 text-lg max-w-xl mx-auto">Masukkan email Anda untuk melihat status permohonan perizinan</p>
        </div>
    </section>

    <section class="py-12 lg:py-16 -mt-10 relative z-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-3xl">
            {{-- Search Form --}}
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 mb-8">
                <form method="GET" action="{{ route('perizinan.cek') }}" class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1 relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]!">email</span>
                        <input type="email" name="email" value="{{ request('email') }}" placeholder="Masukkan email yang digunakan saat mengajukan permohonan" required
                               class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    </div>
                    <button type="submit" class="px-8 py-3 bg-gradient-to-r from-teal-600 to-teal-700 text-white font-bold rounded-xl hover:from-teal-700 hover:to-teal-800 shadow-lg transition-all flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[18px]!">search</span>
                        Cek
                    </button>
                </form>
            </div>

            @if($perizinan !== null)
                @if($perizinan->count() > 0)
                    <div class="space-y-4">
                        <p class="text-sm text-gray-500 font-medium">Ditemukan {{ $perizinan->count() }} permohonan</p>
                        @foreach($perizinan as $p)
                            @php
                                $statusConfig = [
                                    'pending' => ['bg' => 'bg-yellow-50 border-yellow-200', 'badge' => 'bg-yellow-100 text-yellow-700', 'icon' => 'hourglass_top', 'label' => 'Menunggu'],
                                    'diproses' => ['bg' => 'bg-blue-50 border-blue-200', 'badge' => 'bg-blue-100 text-blue-700', 'icon' => 'pending', 'label' => 'Diproses'],
                                    'selesai' => ['bg' => 'bg-green-50 border-green-200', 'badge' => 'bg-green-100 text-green-700', 'icon' => 'check_circle', 'label' => 'Selesai'],
                                    'ditolak' => ['bg' => 'bg-red-50 border-red-200', 'badge' => 'bg-red-100 text-red-700', 'icon' => 'cancel', 'label' => 'Ditolak'],
                                ];
                                $st = $statusConfig[$p->status] ?? $statusConfig['pending'];
                            @endphp
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                                {{-- Status Bar --}}
                                <div class="flex items-center justify-between px-6 py-3 {{ $st['bg'] }} border-b">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined {{ explode(' ', $st['badge'])[1] }} text-[18px]!">{{ $st['icon'] }}</span>
                                        <span class="text-sm font-bold {{ explode(' ', $st['badge'])[1] }}">{{ $st['label'] }}</span>
                                    </div>
                                    <span class="text-xs text-gray-400">{{ $p->tanggal_permohonan->translatedFormat('d M Y') }}</span>
                                </div>

                                <div class="px-6 py-4">
                                    <h3 class="font-bold text-gray-800 text-lg mb-1">{{ $p->judul_permohonan }}</h3>
                                    <p class="text-sm text-gray-500 mb-3 capitalize">{{ $p->jenis_izin }} · {{ $p->nama_pemohon }}</p>

                                    @if($p->deskripsi)
                                        <p class="text-sm text-gray-500 line-clamp-2 mb-3">{{ $p->deskripsi }}</p>
                                    @endif

                                    @if($p->catatan_admin)
                                        <div class="bg-gradient-to-r from-amber-50 to-yellow-50 rounded-xl p-4 border border-amber-100">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="material-symbols-outlined text-amber-600 text-[16px]!">comment</span>
                                                <p class="text-xs font-bold text-amber-700">Catatan dari Admin</p>
                                            </div>
                                            <p class="text-sm text-amber-800">{{ $p->catatan_admin }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-2xl p-10 shadow-sm border border-gray-100 text-center">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="material-symbols-outlined text-[40px]! text-gray-300">search_off</span>
                        </div>
                        <h3 class="font-bold text-gray-600 mb-1">Tidak Ditemukan</h3>
                        <p class="text-gray-400 text-sm">Tidak ada permohonan dengan email tersebut.</p>
                    </div>
                @endif
            @endif

            {{-- Back to form --}}
            <div class="mt-8 text-center">
                <a href="{{ route('perizinan.form') }}" class="inline-flex items-center gap-2 text-sm text-teal-600 font-semibold hover:text-teal-700 transition">
                    <span class="material-symbols-outlined text-[16px]!">arrow_back</span>
                    Kembali ke Formulir Perizinan
                </a>
            </div>
        </div>
    </section>
</x-layouts.public>
