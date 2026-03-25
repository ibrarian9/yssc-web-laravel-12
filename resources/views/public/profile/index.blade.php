<x-layouts.public>
    <x-slot:title>Profil — Yayasan Seribu Satu Cita</x-slot:title>
    <x-slot:metaDescription>Profil, visi misi, dan informasi lengkap Yayasan Seribu Satu Cita.</x-slot:metaDescription>

    {{-- Hero --}}
    <section class="relative bg-gradient-to-br from-gray-900 via-gray-800 to-teal-900 py-20 md:py-28 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 left-10 w-72 h-72 rounded-full bg-teal-400 blur-[100px]"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 rounded-full bg-amber-400 blur-[120px]"></div>
        </div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <span class="inline-block px-4 py-1.5 bg-teal-500/20 text-teal-300 text-xs font-bold uppercase tracking-widest rounded-full mb-5 border border-teal-500/30">Tentang Kami</span>
            <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-5 leading-tight">{{ $profile?->nama_organisasi ?? 'Profil Organisasi' }}</h1>
            <p class="text-gray-300 text-lg md:text-xl max-w-3xl mx-auto leading-relaxed">{{ $profile?->tagline ?? 'Bersama membangun masa depan yang lebih baik' }}</p>
        </div>
    </section>

    @if($profile)
    {{-- Deskripsi with accent --}}
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">
            <div class="relative">
                <div class="absolute -left-4 top-0 bottom-0 w-1 bg-gradient-to-b from-teal-500 to-teal-300 rounded-full hidden md:block"></div>
                <p class="text-gray-600 text-lg md:text-xl leading-relaxed md:pl-8 text-center md:text-left">{{ $profile->deskripsi }}</p>
            </div>
        </div>
    </section>

    {{-- Visi & Misi --}}
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
            <div class="text-center mb-12">
                <span class="inline-block px-4 py-1.5 bg-teal-50 text-teal-700 text-xs font-bold uppercase tracking-widest rounded-full mb-3">Visi & Misi</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-800">Arah & Tujuan Kami</h2>
            </div>
            <div class="grid md:grid-cols-2 gap-8">
                {{-- Visi --}}
                <div class="relative bg-white rounded-2xl p-8 shadow-sm border border-gray-100 group hover:shadow-lg transition-all duration-300">
                    <div class="absolute -top-5 left-8">
                        <div class="w-10 h-10 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg shadow-teal-500/30">
                            <span class="material-symbols-outlined text-[20px]! text-white">visibility</span>
                        </div>
                    </div>
                    <h2 class="text-2xl font-extrabold text-gray-800 mb-4 mt-3">Visi</h2>
                    <p class="text-gray-600 leading-relaxed text-lg italic border-l-4 border-teal-400 pl-4">{{ $profile->visi }}</p>
                </div>
                {{-- Misi --}}
                <div class="relative bg-white rounded-2xl p-8 shadow-sm border border-gray-100 group hover:shadow-lg transition-all duration-300">
                    <div class="absolute -top-5 left-8">
                        <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center shadow-lg shadow-amber-500/30">
                            <span class="material-symbols-outlined text-[20px]! text-white">flag</span>
                        </div>
                    </div>
                    <h2 class="text-2xl font-extrabold text-gray-800 mb-4 mt-3">Misi</h2>
                    @if($profile->misi)
                        <ul class="space-y-3">
                            @foreach($profile->misi as $i => $misi)
                                <li class="flex items-start gap-3 text-gray-600">
                                    <span class="flex-shrink-0 w-7 h-7 bg-teal-50 rounded-lg flex items-center justify-center text-teal-600 text-xs font-bold mt-0.5">{{ $i + 1 }}</span>
                                    <span class="leading-relaxed">{{ $misi }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Tim Kami --}}
    @if($teamMembers->count() > 0)
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
            <div class="text-center mb-12">
                <span class="inline-block px-4 py-1.5 bg-blue-50 text-blue-700 text-xs font-bold uppercase tracking-widest rounded-full mb-3">Tim Kami</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-800 mb-3">Orang-Orang di Balik Aksi</h2>
                <p class="text-gray-500 max-w-lg mx-auto">Tim berdedikasi yang bekerja keras untuk mewujudkan misi sosial yayasan</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-6 md:gap-8">
                @foreach($teamMembers as $member)
                    <div class="group text-center">
                        <div class="relative mx-auto w-36 h-36 md:w-44 md:h-44 mb-5">
                            <div class="absolute inset-0 bg-gradient-to-br from-teal-400 to-teal-600 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500 scale-110 blur-lg"></div>
                            <div class="relative w-full h-full rounded-full overflow-hidden ring-4 ring-gray-100 group-hover:ring-teal-200 transition-all duration-500 shadow-lg">
                                @if($member->foto)
                                    <img src="{{ Storage::url($member->foto) }}" alt="{{ $member->nama }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-teal-400 to-teal-600 text-white text-4xl font-bold">
                                        {{ substr($member->nama, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <h4 class="font-bold text-gray-800 text-lg group-hover:text-teal-600 transition-colors">{{ $member->nama }}</h4>
                        <p class="text-sm text-teal-600 font-semibold">{{ $member->jabatan }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $member->divisi->nama }}</p>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-10">
                <a href="{{ route('anggota.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 hover:bg-teal-50 text-gray-700 hover:text-teal-700 font-bold rounded-xl transition-all">
                    <span class="material-symbols-outlined text-[18px]!">groups</span>
                    Lihat Semua Anggota & Divisi
                    <span class="material-symbols-outlined text-[16px]!">arrow_forward</span>
                </a>
            </div>
        </div>
    </section>
    @endif

    {{-- Sejarah Timeline --}}
    @if($profile->sejarah)
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">
            <div class="text-center mb-12">
                <span class="inline-block px-4 py-1.5 bg-amber-50 text-amber-700 text-xs font-bold uppercase tracking-widest rounded-full mb-3">Sejarah</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-800">Perjalanan Kami</h2>
            </div>
            <div class="relative">
                {{-- Timeline line --}}
                <div class="absolute left-6 md:left-1/2 top-0 bottom-0 w-0.5 bg-gradient-to-b from-teal-400 via-teal-500 to-amber-400 md:-translate-x-0.5"></div>
                <div class="relative bg-white rounded-2xl p-8 md:p-10 shadow-sm border border-gray-100 ml-12 md:ml-0">
                    {{-- Timeline dot --}}
                    <div class="absolute -left-[30px] md:left-1/2 md:-translate-x-1/2 -top-3 w-6 h-6 bg-teal-500 rounded-full border-4 border-white shadow-lg"></div>
                    <div class="prose prose-lg max-w-none prose-p:text-gray-600 prose-headings:text-gray-800 prose-strong:text-teal-700">
                        {!! $profile->sejarah !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- Dokumen Legal --}}
    @if($dokumen->count() > 0)
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
            <div class="text-center mb-12">
                <span class="inline-block px-4 py-1.5 bg-blue-50 text-blue-700 text-xs font-bold uppercase tracking-widest rounded-full mb-3">Legalitas</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-800">Dokumen Resmi</h2>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($dokumen as $doc)
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 hover:shadow-lg hover:border-teal-200 transition-all duration-300 group">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mb-4 shadow-lg shadow-blue-500/20 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-white text-[24px]!">description</span>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-1">{{ $doc->nama }}</h4>
                        @if($doc->nomor)<p class="text-sm text-gray-500 mb-1">No: {{ $doc->nomor }}</p>@endif
                        @if($doc->tanggal_terbit)<p class="text-xs text-gray-400">{{ $doc->tanggal_terbit->translatedFormat('d F Y') }}</p>@endif
                        @if($doc->file_path)
                            <a href="{{ Storage::url($doc->file_path) }}" target="_blank"
                               class="inline-flex items-center gap-1.5 mt-4 px-4 py-2 bg-white rounded-lg text-sm text-teal-600 font-semibold hover:bg-teal-50 border border-gray-200 transition">
                                <span class="material-symbols-outlined text-[16px]!">download</span> Unduh
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Mitra Kami --}}
    @if($mitraApproved->count() > 0)
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
            <div class="text-center mb-12">
                <span class="inline-block px-4 py-1.5 bg-teal-50 text-teal-700 text-xs font-bold uppercase tracking-widest rounded-full mb-3">Mitra</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-800 mb-3">Mitra & Partner Kami</h2>
                <p class="text-gray-500 max-w-lg mx-auto">Organisasi dan perusahaan yang berkolaborasi bersama kami</p>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($mitraApproved as $mitra)
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 text-center hover:shadow-lg hover:border-teal-200 transition-all duration-300 group">
                        @if($mitra->logo)
                            <img src="{{ Storage::url($mitra->logo) }}" alt="{{ $mitra->nama_perusahaan }}" class="w-20 h-20 mx-auto mb-4 object-contain rounded-xl">
                        @else
                            <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-teal-400 to-teal-600 rounded-xl flex items-center justify-center text-white text-2xl font-bold shadow-lg group-hover:scale-110 transition-transform">
                                {{ substr($mitra->nama_perusahaan, 0, 2) }}
                            </div>
                        @endif
                        <h4 class="font-bold text-gray-800 text-sm">{{ $mitra->nama_perusahaan }}</h4>
                        <span class="inline-block mt-1 px-2 py-0.5 bg-gray-100 text-gray-500 rounded text-[10px] font-bold uppercase">{{ $mitra->jenis_mitra->label() }}</span>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-10">
                <a href="{{ route('mitra.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-600 to-teal-700 text-white font-bold rounded-xl hover:from-teal-700 hover:to-teal-800 shadow-lg shadow-teal-500/20 transition-all">
                    <span class="material-symbols-outlined text-[18px]!">handshake</span>
                    Jadilah Mitra Kami
                </a>
            </div>
        </div>
    </section>
    @endif

    {{-- Kontak --}}
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-800">Hubungi Kami</h2>
            </div>
            <div class="grid sm:grid-cols-3 gap-6 text-center">
                @if($profile->alamat)
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100/50 rounded-2xl p-6 border border-gray-100 hover:shadow-lg transition group">
                        <div class="w-12 h-12 mx-auto mb-4 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-white text-[24px]!">location_on</span>
                        </div>
                        <p class="text-sm text-gray-600">{{ $profile->alamat }}</p>
                    </div>
                @endif
                @if($profile->email)
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100/50 rounded-2xl p-6 border border-gray-100 hover:shadow-lg transition group">
                        <div class="w-12 h-12 mx-auto mb-4 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-white text-[24px]!">mail</span>
                        </div>
                        <a href="mailto:{{ $profile->email }}" class="text-sm text-teal-600 font-semibold hover:underline">{{ $profile->email }}</a>
                    </div>
                @endif
                @if($profile->telepon)
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100/50 rounded-2xl p-6 border border-gray-100 hover:shadow-lg transition group">
                        <div class="w-12 h-12 mx-auto mb-4 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-white text-[24px]!">call</span>
                        </div>
                        <p class="text-sm text-gray-600 font-semibold">{{ $profile->telepon }}</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
    @endif
</x-layouts.public>
