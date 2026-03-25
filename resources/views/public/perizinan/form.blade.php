<x-layouts.public>
    <x-slot:title>Perizinan — Yayasan Seribu Satu Cita</x-slot:title>

    {{-- Hero Section --}}
    <section class="relative bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 py-20 md:py-28 overflow-hidden">
        {{-- Decorative elements --}}
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 right-20 w-72 h-72 bg-teal-400 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 left-20 w-48 h-48 bg-emerald-400 rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div
                class="inline-flex items-center gap-2 px-4 py-2 bg-teal-500/20 border border-teal-500/30 rounded-full mb-6">
                <span class="material-symbols-outlined text-teal-400 text-[18px]!">assignment</span>
                <span class="text-teal-300 text-sm font-semibold">Layanan Online</span>
            </div>
            <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-4">Permohonan Perizinan</h1>
            <p class="text-gray-400 text-lg max-w-2xl mx-auto leading-relaxed">Ajukan permohonan kerja sama, izin
                kegiatan, atau surat rekomendasi dari Yayasan Seribu Satu Cita secara online.</p>
        </div>
    </section>

    <section class="py-12 lg:py-16 -mt-10 relative z-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-3xl">

            {{-- Success Alert --}}
            @if(session('success'))
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-2xl p-6 md:p-8 mb-8 shadow-sm"
                x-data x-init="window.scrollTo({top: 0, behavior: 'smooth'})">
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-green-600 text-[36px]!">check_circle</span>
                    </div>
                    <h3 class="text-xl font-bold text-green-800 mb-2">Permohonan Berhasil Dikirim! 🎉</h3>
                    <p class="text-sm text-green-600 mb-4 max-w-md">{{ session('success') }}</p>

                    <div class="bg-white rounded-xl p-4 border border-green-100 w-full max-w-md mb-4">
                        <h4 class="text-sm font-bold text-gray-700 mb-3">Langkah selanjutnya:</h4>
                        <div class="space-y-3 text-left">
                            <div class="flex items-start gap-3">
                                <div
                                    class="w-7 h-7 bg-teal-100 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                                    <span class="text-teal-700 text-xs font-bold">1</span>
                                </div>
                                <p class="text-sm text-gray-600">Tim kami akan <strong>mereview permohonan</strong> Anda
                                    dalam 1-3 hari kerja</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <div
                                    class="w-7 h-7 bg-teal-100 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                                    <span class="text-teal-700 text-xs font-bold">2</span>
                                </div>
                                <p class="text-sm text-gray-600">Anda dapat <strong>mengecek status</strong> permohonan
                                    kapan saja melalui halaman cek status</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <div
                                    class="w-7 h-7 bg-teal-100 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                                    <span class="text-teal-700 text-xs font-bold">3</span>
                                </div>
                                <p class="text-sm text-gray-600">Admin akan <strong>memberikan catatan</strong> jika ada
                                    hal yang perlu ditindaklanjuti</p>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('perizinan.cek') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-600 to-teal-700 text-white font-bold rounded-xl hover:from-teal-700 hover:to-teal-800 shadow-lg transition-all text-sm">
                        <span class="material-symbols-outlined text-[18px]!">search</span>
                        Cek Status Permohonan
                    </a>
                </div>
            </div>
            @endif

            {{-- Info Cards --}}
            <div class="grid sm:grid-cols-2 gap-4 mb-8">
                <div
                    class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-teal-100 rounded-xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-teal-600 text-[22px]!">event_available</span>
                        </div>
                        <h4 class="font-bold text-gray-800 text-sm">Izin Kegiatan</h4>
                    </div>
                    <p class="text-xs text-gray-500 leading-relaxed">Menyelenggarakan kegiatan atas nama atau bekerja
                        sama dengan yayasan</p>
                </div>
                <div
                    class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-blue-600 text-[22px]!">handshake</span>
                        </div>
                        <h4 class="font-bold text-gray-800 text-sm">Kerjasama</h4>
                    </div>
                    <p class="text-xs text-gray-500 leading-relaxed">Pengajuan kerja sama program, sponsorship, atau
                        kolaborasi</p>
                </div>
                <div
                    class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-amber-600 text-[22px]!">description</span>
                        </div>
                        <h4 class="font-bold text-gray-800 text-sm">Surat Rekomendasi</h4>
                    </div>
                    <p class="text-xs text-gray-500 leading-relaxed">Permintaan surat rekomendasi resmi dari yayasan</p>
                </div>
                <div
                    class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-purple-600 text-[22px]!">more_horiz</span>
                        </div>
                        <h4 class="font-bold text-gray-800 text-sm">Lainnya</h4>
                    </div>
                    <p class="text-xs text-gray-500 leading-relaxed">Permohonan lain yang berkaitan dengan yayasan</p>
                </div>
            </div>

            {{-- Form --}}
            <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-gray-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-teal-100 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-teal-600 text-[22px]!">edit_document</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800">Formulir Permohonan</h3>
                        <p class="text-xs text-gray-400">Isi semua kolom yang bertanda *</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('perizinan.submit') }}" enctype="multipart/form-data"
                    class="space-y-5">
                    @csrf
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Pemohon *</label>
                            <input type="text" name="nama_pemohon" value="{{ old('nama_pemohon') }}" required
                                placeholder="Nama lengkap pemohon"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            @error('nama_pemohon') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Email *</label>
                            <input type="email" name="email_pemohon" value="{{ old('email_pemohon') }}" required
                                placeholder="email@contoh.com"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            @error('email_pemohon') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">No. HP</label>
                            <input type="text" name="phone_pemohon" value="{{ old('phone_pemohon') }}"
                                placeholder="08xx-xxxx-xxxx"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Jenis Izin *</label>
                            <select name="jenis_izin" required
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                <option value="">Pilih jenis</option>
                                <option value="kegiatan" {{ old('jenis_izin')==='kegiatan' ? 'selected' : '' }}>Izin
                                    Kegiatan</option>
                                <option value="kerjasama" {{ old('jenis_izin')==='kerjasama' ? 'selected' : '' }}>
                                    Kerjasama</option>
                                <option value="rekomendasi" {{ old('jenis_izin')==='rekomendasi' ? 'selected' : '' }}>
                                    Surat Rekomendasi</option>
                                <option value="lainnya" {{ old('jenis_izin')==='lainnya' ? 'selected' : '' }}>Lainnya
                                </option>
                            </select>
                            @error('jenis_izin') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Permohonan *</label>
                        <input type="text" name="judul_permohonan" value="{{ old('judul_permohonan') }}" required
                            placeholder="Contoh: Kerjasama Program Edukasi Anak"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        @error('judul_permohonan') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi *</label>
                        <textarea name="deskripsi" rows="4" required
                            placeholder="Jelaskan tujuan dan detail permohonan Anda..."
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 resize-none">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Dokumen Pendukung</label>

                        <label for="file-upload"
                            class="group relative border-2 border-dashed border-gray-200 rounded-xl p-8 text-center hover:border-teal-400 hover:bg-teal-50/30 transition-all cursor-pointer block">

                            <span
                                class="material-symbols-outlined text-gray-300 group-hover:text-teal-500 text-[48px]! mb-3 transition-colors">
                                cloud_upload
                            </span>

                            <p class="text-sm font-medium text-gray-600 mb-1">Klik untuk memilih
                            </p>
                            <p class="text-xs text-gray-400">PDF, DOC, JPG, PNG (Maks 5MB per file)</p>

                            <input id="file-upload" type="file" name="dokumen_pendukung[]" multiple class="hidden">
                        </label>

                        <div id="file-list" class="mt-2 space-y-2"></div>
                    </div>
                    <button type="submit"
                        class="w-full py-3.5 bg-gradient-to-r from-teal-600 to-teal-700 text-white font-bold rounded-xl hover:from-teal-700 hover:to-teal-800 shadow-lg transition-all flex items-center justify-center gap-2 text-base">
                        <span class="material-symbols-outlined text-[20px]!">send</span>
                        Kirim Permohonan
                    </button>
                </form>
            </div>

            {{-- Check Status CTA --}}
            <div
                class="mt-8 bg-gradient-to-r from-gray-50 to-teal-50 rounded-2xl p-6 border border-gray-100 flex flex-col sm:flex-row items-center gap-4">
                <div class="w-12 h-12 bg-teal-100 rounded-xl flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-teal-600 text-[24px]!">manage_search</span>
                </div>
                <div class="text-center sm:text-left flex-1">
                    <h4 class="font-bold text-gray-800">Sudah pernah mengajukan?</h4>
                    <p class="text-sm text-gray-500">Cek status permohonan Anda dengan memasukkan email</p>
                </div>
                <a href="{{ route('perizinan.cek') }}"
                    class="px-6 py-2.5 bg-white text-teal-700 font-bold rounded-xl border border-teal-200 hover:bg-teal-50 transition text-sm whitespace-nowrap">
                    Cek Status →
                </a>
            </div>
        </div>
    </section>
</x-layouts.public>