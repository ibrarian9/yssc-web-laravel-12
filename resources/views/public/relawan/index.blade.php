<x-layouts.public>
    <x-slot:title>Relawan — Yayasan Seribu Satu Cita</x-slot:title>

    {{-- Hero --}}
    <x-public.page-hero page="relawan" badge="Relawan Kami" default-title="Bergabunglah Bersama Kami" default-subtitle="Jadilah bagian dari perubahan positif bagi pendidikan dan kesejahteraan anak-anak Indonesia">
        <div class="mt-8">
            <a href="{{ route('relawan.form') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-yellow-400 text-gray-900 font-bold rounded-full hover:bg-yellow-300 shadow-xl shadow-yellow-400/30 hover:scale-105 transition-all text-lg">
                <span class="material-symbols-outlined">person_add</span> Daftar Jadi Relawan
            </a>
        </div>
    </x-public.page-hero>

    {{-- Volunteer List --}}
    <section class="py-16 lg:py-20 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            @if($relawan->count() > 0)
                <div class="text-center mb-12">
                    <span class="inline-block px-4 py-1.5 bg-teal-50 text-teal-700 text-xs font-bold uppercase tracking-widest rounded-full mb-3">Tim Relawan</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-800">Relawan Aktif Kami</h2>
                    <p class="text-gray-500 mt-3 max-w-xl mx-auto">Mereka yang telah bergabung dan berkontribusi bersama yayasan</p>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5 max-w-6xl mx-auto">
                    @foreach($relawan as $r)
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all group border border-gray-100">
                            <div class="aspect-square overflow-hidden bg-gray-100">
                                @if($r->foto)
                                    <img src="{{ asset('storage/' . $r->foto) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="{{ $r->nama }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-teal-100 to-emerald-100">
                                        <span class="material-symbols-outlined text-teal-300 text-[64px]!">person</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4 text-center">
                                <h3 class="font-bold text-gray-800 group-hover:text-teal-700 transition truncate">{{ $r->nama }}</h3>
                                @if($r->keahlian)
                                    <p class="text-xs text-teal-600 font-medium mt-1">{{ $r->keahlian }}</p>
                                @endif
                                @if($r->pekerjaan)
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $r->pekerjaan }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($relawan->hasPages())
                    <div class="mt-10">{{ $relawan->links() }}</div>
                @endif
            @else
                <div class="text-center py-16">
                    <span class="material-symbols-outlined text-[64px]! text-gray-300 mb-4">group_add</span>
                    <h3 class="text-xl font-bold text-gray-600 mb-2">Belum Ada Relawan Terdaftar</h3>
                    <p class="text-gray-400 mb-6">Jadilah yang pertama bergabung sebagai relawan!</p>
                    <a href="{{ route('relawan.form') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-600 to-teal-700 text-white font-bold rounded-full hover:from-teal-700 hover:to-teal-800 shadow-lg transition-all">
                        <span class="material-symbols-outlined text-[18px]!">person_add</span> Daftar Sekarang
                    </a>
                </div>
            @endif
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto bg-gradient-to-r from-teal-600 to-emerald-600 rounded-3xl p-10 md:p-14 text-center relative overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none"><polygon points="100,0 0,100 100,100" fill="currentColor" class="text-black"/></svg>
                </div>
                <div class="relative z-10">
                    <span class="material-symbols-outlined text-white/30 text-[80px]! mb-4">favorite</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-4">Siap Berkontribusi?</h2>
                    <p class="text-teal-100 text-lg max-w-xl mx-auto mb-8">Setiap kebaikan yang Anda berikan akan memberikan dampak nyata bagi masyarakat.</p>
                    <a href="{{ route('relawan.form') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-yellow-400 text-gray-900 font-bold rounded-full hover:bg-yellow-300 shadow-xl hover:scale-105 transition-all text-lg">
                        <span class="material-symbols-outlined">volunteer_activism</span> Daftar Relawan
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>
