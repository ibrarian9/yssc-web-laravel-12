<x-layouts.public>
    <x-slot:title>Daftar Relawan — Yayasan Seribu Satu Cita</x-slot:title>

    <section class="py-16 lg:py-20 bg-gray-50 min-h-[80vh]">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mx-auto">
                {{-- Header --}}
                <div class="text-center mb-10">
                    <span class="inline-block px-4 py-1.5 bg-teal-50 text-teal-700 text-xs font-bold uppercase tracking-widest rounded-full mb-3">Pendaftaran</span>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 mb-2">Daftar Relawan</h1>
                    <p class="text-gray-500">Isi formulir di bawah untuk bergabung sebagai relawan Yayasan Seribu Satu Cita</p>
                </div>

                {{-- Success Message --}}
                @if(session('success'))
                    <div class="mb-8 p-5 bg-green-50 border border-green-200 rounded-2xl flex items-start gap-3">
                        <span class="material-symbols-outlined text-green-500 text-[24px]! mt-0.5 shrink-0">check_circle</span>
                        <div>
                            <p class="font-bold text-green-800 text-sm">Pendaftaran Berhasil!</p>
                            <p class="text-xs text-green-600 mt-1">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                {{-- Form Card --}}
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="px-8 py-5 bg-gradient-to-r from-teal-600 to-teal-700 flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-[24px]!">person_add</span>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-white">Formulir Pendaftaran</h2>
                            <p class="text-teal-100 text-xs">Semua kolom bertanda <span class="text-yellow-300">*</span> wajib diisi</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('relawan.submit') }}" enctype="multipart/form-data" class="p-8 space-y-5">
                        @csrf

                        {{-- Nama --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]!">person</span>
                                <input type="text" name="nama" value="{{ old('nama') }}" required
                                       class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                       placeholder="Masukkan nama lengkap">
                            </div>
                            @error('nama') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Email & Telepon --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]!">mail</span>
                                    <input type="email" name="email" value="{{ old('email') }}" required
                                           class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                           placeholder="email@contoh.com">
                                </div>
                                @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">No. Telepon <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]!">phone</span>
                                    <input type="text" name="telepon" value="{{ old('telepon') }}" required
                                           class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                           placeholder="08xxxxxxxxxx">
                                </div>
                                @error('telepon') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- Tanggal Lahir & Pekerjaan --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Lahir</label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]!">calendar_month</span>
                                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                                           class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                </div>
                                @error('tanggal_lahir') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Pekerjaan</label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]!">work</span>
                                    <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}"
                                           class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                           placeholder="Mahasiswa, Guru, dll.">
                                </div>
                                @error('pekerjaan') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- Keahlian --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Keahlian / Skill</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]!">star</span>
                                <input type="text" name="keahlian" value="{{ old('keahlian') }}"
                                       class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                       placeholder="Desain grafis, mengajar, fotografi, dll.">
                            </div>
                            @error('keahlian') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Alamat --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat</label>
                            <textarea name="alamat" rows="2" class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 resize-none"
                                      placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                            @error('alamat') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Motivasi --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Motivasi Menjadi Relawan <span class="text-red-500">*</span></label>
                            <textarea name="motivasi" rows="4" required minlength="20"
                                      class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 resize-none"
                                      placeholder="Ceritakan alasan Anda ingin menjadi relawan (minimal 20 karakter)">{{ old('motivasi') }}</textarea>
                            @error('motivasi') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Foto --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Foto Profil</label>
                            <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 text-center hover:border-teal-400 transition">
                                <span class="material-symbols-outlined text-gray-300 text-[36px]! mb-1">add_a_photo</span>
                                <input type="file" name="foto" accept="image/jpg,image/jpeg,image/png,image/webp"
                                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                                <p class="text-[10px] text-gray-400 mt-1">JPG, PNG, atau WebP. Maksimal 2MB</p>
                            </div>
                            @error('foto') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Submit --}}
                        <button type="submit"
                                class="w-full py-3.5 bg-gradient-to-r from-teal-600 to-teal-700 text-white font-bold rounded-xl hover:from-teal-700 hover:to-teal-800 shadow-lg shadow-teal-500/20 transition-all text-sm flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-[20px]!">send</span> Kirim Pendaftaran
                        </button>
                    </form>
                </div>

                {{-- Info --}}
                <div class="mt-6 p-4 bg-blue-50 border border-blue-100 rounded-xl flex items-start gap-3">
                    <span class="material-symbols-outlined text-blue-400 text-[20px]! mt-0.5 shrink-0">info</span>
                    <p class="text-xs text-blue-600 leading-relaxed">Setelah mendaftar, tim kami akan meninjau data Anda dalam 1-3 hari kerja. Anda akan mendapat konfirmasi melalui email.</p>
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>
