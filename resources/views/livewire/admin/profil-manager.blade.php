<div>
    {{-- Alerts --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl flex items-center justify-between gap-3 text-sm font-medium text-green-800 shadow-sm animate-in fade-in">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-green-600 text-[24px]!">verified</span>
                <span>{{ session('success') }}</span>
            </div>
            <a href="{{ route('profil.index') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-600 text-white rounded-lg text-xs font-bold hover:bg-green-700 transition">
                <span>Lihat di Website</span>
                <span class="material-symbols-outlined text-[14px]!">open_in_new</span>
            </a>
        </div>
    @endif

    {{-- Top Action Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-extrabold text-gray-800">Profil Organisasi</h2>
            <p class="text-sm text-gray-500">Kelola identitas, visi misi, kontak, dan informasi publik yayasan</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('profil.index') }}" target="_blank"
                class="inline-flex items-center gap-1.5 px-4 py-2.5 border border-gray-200 text-gray-600 hover:bg-gray-50 font-semibold rounded-xl text-sm transition">
                <span class="material-symbols-outlined text-[18px]!">visibility</span>
                Buka Website
            </a>
            <button wire:click="save" wire:loading.attr="disabled"
                class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white font-bold rounded-xl text-sm shadow-lg shadow-teal-500/20 transition cursor-pointer">
                <span wire:loading.remove class="material-symbols-outlined text-[18px]!">save</span>
                <span wire:loading.remove>Simpan Profil</span>
                <span wire:loading class="inline-flex items-center gap-2">
                    <span class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                    Menyimpan...
                </span>
            </button>
        </div>
    </div>

    {{-- Beginner Guide Banner --}}
    <div class="mb-6 bg-gradient-to-r from-teal-50 via-emerald-50 to-teal-50 border border-teal-200/80 rounded-2xl p-4 sm:p-5 flex items-start gap-4 shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-teal-500 text-white flex items-center justify-center shrink-0 shadow-md shadow-teal-500/20">
            <span class="material-symbols-outlined text-[22px]!">lightbulb</span>
        </div>
        <div class="flex-1 text-sm text-gray-700">
            <p class="font-bold text-gray-900 mb-0.5">Panduan Pengisian untuk Pengelola:</p>
            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                Pilih tab di bawah untuk mengatur informasi yayasan. Setiap teks dan logo yang Anda ubah di sini akan langsung ditampilkan secara rapi pada halaman publik dan footer website.
            </p>
        </div>
    </div>

    {{-- Tabs Navigation --}}
    <div class="bg-white rounded-2xl p-2 shadow-sm border border-gray-100 mb-6 flex flex-wrap gap-2">
        <button type="button" wire:click="setTab('identitas')"
            class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition cursor-pointer {{ $activeTab === 'identitas' ? 'bg-teal-600 text-white shadow-md shadow-teal-500/20' : 'text-gray-600 hover:bg-gray-50' }}">
            <span class="material-symbols-outlined text-[18px]!">corporate_fare</span>
            1. Identitas & Logo
        </button>
        <button type="button" wire:click="setTab('visi_misi')"
            class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition cursor-pointer {{ $activeTab === 'visi_misi' ? 'bg-teal-600 text-white shadow-md shadow-teal-500/20' : 'text-gray-600 hover:bg-gray-50' }}">
            <span class="material-symbols-outlined text-[18px]!">target</span>
            2. Visi & Misi
        </button>
        <button type="button" wire:click="setTab('sejarah')"
            class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition cursor-pointer {{ $activeTab === 'sejarah' ? 'bg-teal-600 text-white shadow-md shadow-teal-500/20' : 'text-gray-600 hover:bg-gray-50' }}">
            <span class="material-symbols-outlined text-[18px]!">auto_stories</span>
            3. Sejarah & Cerita
        </button>
        <button type="button" wire:click="setTab('kontak_sosmed')"
            class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition cursor-pointer {{ $activeTab === 'kontak_sosmed' ? 'bg-teal-600 text-white shadow-md shadow-teal-500/20' : 'text-gray-600 hover:bg-gray-50' }}">
            <span class="material-symbols-outlined text-[18px]!">contact_phone</span>
            4. Kontak & Medsos
        </button>
        <button type="button" wire:click="setTab('pratinjau')"
            class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition cursor-pointer {{ $activeTab === 'pratinjau' ? 'bg-teal-600 text-white shadow-md shadow-teal-500/20' : 'text-gray-600 hover:bg-gray-50' }}">
            <span class="material-symbols-outlined text-[18px]!">preview</span>
            5. Pratinjau Tampilan
        </button>
    </div>

    {{-- Main Form Card --}}
    <form wire:submit="save" class="space-y-6">

        {{-- TAB 1: IDENTITAS & LOGO --}}
        @if($activeTab === 'identitas')
        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-gray-100 space-y-6 animate-in fade-in duration-150">
            <div class="border-b border-gray-100 pb-4">
                <h3 class="text-lg font-bold text-gray-800">Nama & Logo Yayasan</h3>
                <p class="text-xs text-gray-500">Nama resmi organisasi yang tampil di navigasi, header, dan sertifikat</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Organisasi / Yayasan *</label>
                    <input type="text" wire:model="nama_organisasi" placeholder="cth: Yayasan Seribu Satu Cita"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 font-medium">
                    <p class="text-[11px] text-gray-400 mt-1">Nama ini digunakan di navbar, footer, dan meta title browser.</p>
                    @error('nama_organisasi') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tagline / Slogan</label>
                    <input type="text" wire:model="tagline" placeholder="cth: Bersama Membangun Masa Depan yang Lebih Baik"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    <p class="text-[11px] text-gray-400 mt-1">Slogan singkat yang menarik di bawah nama yayasan pada banner utama.</p>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Singkat Yayasan</label>
                <textarea wire:model="deskripsi" rows="3" placeholder="Tuliskan 2-3 kalimat penjelasan tentang apa yang diperjuangkan oleh yayasan..."
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 resize-none leading-relaxed"></textarea>
                <p class="text-[11px] text-gray-400 mt-1">Muncul di halaman profil utama tepat di bawah banner selamat datang.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-gray-100">
                {{-- Upload Logo --}}
                <div class="p-5 bg-gray-50/70 rounded-2xl border border-gray-200/80">
                    <div class="flex items-center justify-between mb-3">
                        <label class="text-sm font-bold text-gray-700">Logo Yayasan</label>
                        <span class="text-[11px] text-gray-400">PNG/JPG (Maks. 2MB)</span>
                    </div>

                    <div class="flex items-center gap-4 mb-4">
                        @if($newLogo)
                            <div class="relative">
                                <img src="{{ $newLogo->temporaryUrl() }}" class="w-20 h-20 rounded-2xl object-contain bg-white border-2 border-teal-500 p-1 shadow-sm">
                                <span class="absolute -top-2 -right-2 px-1.5 py-0.5 bg-teal-600 text-white text-[9px] font-bold rounded-full">Baru</span>
                            </div>
                        @elseif($currentLogo)
                            <div class="relative">
                                <img src="{{ asset('storage/' . $currentLogo) }}" class="w-20 h-20 rounded-2xl object-contain bg-white border border-gray-200 p-1 shadow-sm">
                            </div>
                        @else
                            <div class="w-20 h-20 rounded-2xl bg-gray-200 flex flex-col items-center justify-center text-gray-400 border border-dashed border-gray-300">
                                <span class="material-symbols-outlined text-2xl">image</span>
                                <span class="text-[9px]">Belum ada</span>
                            </div>
                        @endif

                        <div class="flex-1 space-y-2">
                            <input type="file" wire:model="newLogo" accept="image/*"
                                class="w-full text-xs file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:bg-teal-600 file:text-white file:font-bold hover:file:bg-teal-700 cursor-pointer">
                            @if($currentLogo || $newLogo)
                                <button type="button" wire:click="removeLogo" class="text-xs text-red-500 hover:text-red-700 font-semibold flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]!">delete</span>
                                    Hapus Logo Saat Ini
                                </button>
                            @endif
                        </div>
                    </div>
                    <p class="text-[11px] text-gray-500">Rekomendasi: Logo berlatar transparan (PNG) rasio 1:1 agar terlihat bagus di navbar.</p>
                    @error('newLogo') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Upload Foto Kantor --}}
                <div class="p-5 bg-gray-50/70 rounded-2xl border border-gray-200/80">
                    <div class="flex items-center justify-between mb-3">
                        <label class="text-sm font-bold text-gray-700">Foto Gedung / Kantor</label>
                        <span class="text-[11px] text-gray-400">JPG/PNG (Maks. 4MB)</span>
                    </div>

                    <div class="flex items-center gap-4 mb-4">
                        @if($newFotoKantor)
                            <div class="relative">
                                <img src="{{ $newFotoKantor->temporaryUrl() }}" class="w-20 h-20 rounded-2xl object-cover bg-white border-2 border-teal-500 p-0.5 shadow-sm">
                                <span class="absolute -top-2 -right-2 px-1.5 py-0.5 bg-teal-600 text-white text-[9px] font-bold rounded-full">Baru</span>
                            </div>
                        @elseif($currentFotoKantor)
                            <div class="relative">
                                <img src="{{ asset('storage/' . $currentFotoKantor) }}" class="w-20 h-20 rounded-2xl object-cover bg-white border border-gray-200 shadow-sm">
                            </div>
                        @else
                            <div class="w-20 h-20 rounded-2xl bg-gray-200 flex flex-col items-center justify-center text-gray-400 border border-dashed border-gray-300">
                                <span class="material-symbols-outlined text-2xl">apartment</span>
                                <span class="text-[9px]">Belum ada</span>
                            </div>
                        @endif

                        <div class="flex-1 space-y-2">
                            <input type="file" wire:model="newFotoKantor" accept="image/*"
                                class="w-full text-xs file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:bg-teal-600 file:text-white file:font-bold hover:file:bg-teal-700 cursor-pointer">
                            @if($currentFotoKantor || $newFotoKantor)
                                <button type="button" wire:click="removeFotoKantor" class="text-xs text-red-500 hover:text-red-700 font-semibold flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]!">delete</span>
                                    Hapus Foto Kantor
                                </button>
                            @endif
                        </div>
                    </div>
                    <p class="text-[11px] text-gray-500">Foto dokumentasi kantor yayasan atau kegiatan sekretariat.</p>
                    @error('newFotoKantor') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
        @endif

        {{-- TAB 2: VISI & MISI --}}
        @if($activeTab === 'visi_misi')
        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-gray-100 space-y-6 animate-in fade-in duration-150">
            <div class="border-b border-gray-100 pb-4">
                <h3 class="text-lg font-bold text-gray-800">Arah & Tujuan Yayasan</h3>
                <p class="text-xs text-gray-500">Tuliskan cita-cita jangka panjang (Visi) dan langkah nyata yang dilakukan (Misi)</p>
            </div>

            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[16px]!">visibility</span>
                    </span>
                    <label class="text-sm font-bold text-gray-800">Visi Utama Organisasi</label>
                </div>
                <textarea wire:model="visi" rows="3" placeholder="cth: Menjadi lembaga filantropi terpercaya yang menginspirasi kemandirian dan kebahagiaan anak-anak Indonesia."
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 resize-none leading-relaxed"></textarea>
                <p class="text-[11px] text-gray-400 mt-1">Visi adalah tujuan besar atau impian yang ingin dicapai yayasan di masa depan.</p>
            </div>

            <div class="pt-4 border-t border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[16px]!">flag</span>
                        </span>
                        <div>
                            <label class="text-sm font-bold text-gray-800">Poin-Poin Misi</label>
                            <p class="text-xs text-gray-400">Langkah-langkah strategis untuk mencapai visi di atas</p>
                        </div>
                    </div>
                    <button type="button" wire:click="addMisi"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-teal-50 text-teal-700 hover:bg-teal-100 font-bold rounded-xl text-xs transition cursor-pointer">
                        <span class="material-symbols-outlined text-[16px]!">add</span>
                        Tambah Poin Misi
                    </button>
                </div>

                <div class="space-y-3">
                    @foreach($misi as $idx => $m)
                        <div class="flex items-center gap-3 p-3 bg-gray-50/80 rounded-xl border border-gray-200/80 focus-within:border-teal-500 focus-within:bg-white transition">
                            <span class="w-7 h-7 bg-teal-600 text-white rounded-lg flex items-center justify-center text-xs font-bold shrink-0">
                                {{ $idx + 1 }}
                            </span>
                            <input type="text" wire:model="misi.{{ $idx }}" placeholder="cth: Menyelenggarakan beasiswa pendidikan bagi keluarga pra-sejahtera..."
                                class="flex-1 bg-transparent border-0 text-sm text-gray-800 focus:ring-0 p-0">
                            @if(count($misi) > 1)
                                <button type="button" wire:click="removeMisi({{ $idx }})" class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition" title="Hapus poin ini">
                                    <span class="material-symbols-outlined text-[18px]!">delete</span>
                                </button>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    <button type="button" wire:click="addMisi" class="text-xs font-bold text-teal-600 hover:text-teal-700 flex items-center gap-1 cursor-pointer">
                        <span class="material-symbols-outlined text-[16px]!">add_circle</span>
                        Klik di sini untuk menambah poin misi berikutnya
                    </button>
                </div>
            </div>
        </div>
        @endif

        {{-- TAB 3: SEJARAH & CERITA --}}
        @if($activeTab === 'sejarah')
        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-gray-100 space-y-6 animate-in fade-in duration-150">
            <div class="border-b border-gray-100 pb-4">
                <h3 class="text-lg font-bold text-gray-800">Cerita & Sejarah Berdirinya Yayasan</h3>
                <p class="text-xs text-gray-500">Ceritakan latar belakang, awal mula pendirian, atau nilai-nilai yang melandasi yayasan</p>
            </div>

            <div class="p-4 bg-teal-50/60 rounded-xl border border-teal-100 flex items-start gap-3">
                <span class="material-symbols-outlined text-teal-600 text-[20px]! mt-0.5">info</span>
                <div class="text-xs text-gray-600 leading-relaxed">
                    <strong class="text-teal-900">Petunjuk Menulis:</strong> Anda tidak perlu memahami kode HTML. Cukup tuliskan kisah pendirian yayasan seperti mengetik cerita biasa di Word. Gunakan tombol <strong>Enter</strong> untuk membuat paragraf baru.
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Kisah Sejarah Yayasan</label>
                <textarea wire:model="sejarah" rows="10" placeholder="Tuliskan kisah berdirinya yayasan di sini...&#10;&#10;Contoh:&#10;Yayasan Seribu Satu Cita didirikan pada tahun ... oleh sekelompok pemuda yang peduli dengan pendidikan anak-anak di daerah pelosok..."
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 leading-relaxed font-sans"></textarea>
            </div>
        </div>
        @endif

        {{-- TAB 4: KONTAK & MEDIA SOSIAL --}}
        @if($activeTab === 'kontak_sosmed')
        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-gray-100 space-y-6 animate-in fade-in duration-150">
            <div class="border-b border-gray-100 pb-4">
                <h3 class="text-lg font-bold text-gray-800">Kontak Resmi & Media Sosial</h3>
                <p class="text-xs text-gray-500">Informasi agar donatur, mitra, dan masyarakat umum dapat menghubungi yayasan</p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Lengkap Kantor / Sekretariat</label>
                <textarea wire:model="alamat" rows="2" placeholder="Jl. Contoh Alamat No. 123, Kelurahan, Kecamatan, Kota, Provinsi, Kode Pos"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 resize-none"></textarea>
                <p class="text-[11px] text-gray-400 mt-1">Alamat ini akan ditampilkan di halaman kontak dan kartu informasi footer.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Email Resmi</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]!">mail</span>
                        <input type="email" wire:model="email" placeholder="halo@seribusatucita.org"
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Telepon / WhatsApp</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]!">phone</span>
                        <input type="text" wire:model="telepon" placeholder="08123456789 atau (021) 123456"
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100">
                <h4 class="text-sm font-bold text-gray-800 mb-3">Tautan Website & Akun Media Sosial</h4>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Website Resmi</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]!">language</span>
                            <input type="text" wire:model="website" placeholder="https://www.seribusatucita.org"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Instagram Yayasan</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]!">photo_camera</span>
                            <input type="text" wire:model="instagram" placeholder="https://instagram.com/username atau @username"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Halaman Facebook</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]!">public</span>
                            <input type="text" wire:model="facebook" placeholder="https://facebook.com/nama.yayasan"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Kanal YouTube</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]!">smart_display</span>
                            <input type="text" wire:model="youtube" placeholder="https://youtube.com/@namachannel"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- TAB 5: PRATINJAU TAMPILAN --}}
        @if($activeTab === 'pratinjau')
        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-gray-100 space-y-6 animate-in fade-in duration-150">
            <div class="border-b border-gray-100 pb-4 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Pratinjau Langsung Halaman Publik</h3>
                    <p class="text-xs text-gray-500">Simulasi bagaimana pengunjung melihat profil yayasan Anda</p>
                </div>
                <span class="px-3 py-1 bg-teal-50 text-teal-700 text-xs font-bold rounded-full border border-teal-200">
                    Live Preview
                </span>
            </div>

            {{-- Mock Public Hero --}}
            <div class="rounded-2xl overflow-hidden shadow-lg border border-gray-800">
                <div class="bg-gradient-to-br from-gray-900 via-gray-800 to-teal-900 py-12 px-6 text-center text-white relative">
                    <span class="inline-block px-3 py-1 bg-teal-500/20 text-teal-300 text-[10px] font-bold uppercase tracking-widest rounded-full mb-3 border border-teal-500/30">
                        Tentang Kami
                    </span>
                    <h1 class="text-2xl sm:text-4xl font-extrabold mb-3">
                        {{ $nama_organisasi ?: 'Nama Yayasan Anda' }}
                    </h1>
                    <p class="text-gray-300 text-sm sm:text-base max-w-xl mx-auto italic">
                        {{ $tagline ?: 'Tagline yayasan Anda akan tampil di sini...' }}
                    </p>
                </div>

                {{-- Mock Body --}}
                <div class="bg-white p-6 space-y-6">
                    @if($deskripsi)
                        <div class="border-l-4 border-teal-500 pl-4 py-1 text-gray-600 text-sm leading-relaxed">
                            {{ $deskripsi }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Visi --}}
                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                            <h4 class="font-extrabold text-teal-700 text-base mb-2 flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]!">visibility</span>
                                Visi
                            </h4>
                            <p class="text-gray-600 text-xs sm:text-sm not-italic leading-relaxed">
                                {{ $visi ?: 'Belum mengisi visi organisasi.' }}
                            </p>
                        </div>

                        {{-- Misi --}}
                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                            <h4 class="font-extrabold text-teal-700 text-base mb-2 flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]!">flag</span>
                                Misi
                            </h4>
                            <ul class="space-y-2">
                                @forelse(array_filter($misi) as $i => $item)
                                    <li class="flex items-start gap-2 text-xs sm:text-sm text-gray-600">
                                        <span class="w-5 h-5 bg-teal-100 text-teal-700 rounded text-[10px] font-bold flex items-center justify-center shrink-0 mt-0.5">
                                            {{ $i + 1 }}
                                        </span>
                                        <span>{{ $item }}</span>
                                    </li>
                                @empty
                                    <li class="text-xs text-gray-400 italic">Belum ada poin misi.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    {{-- Kontak Card --}}
                    <div class="p-4 bg-teal-50/50 rounded-xl border border-teal-100 text-xs text-gray-700 flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-teal-600 text-[18px]!">location_on</span>
                            <span>{{ $alamat ?: 'Alamat belum diatur' }}</span>
                        </div>
                        <div class="flex items-center gap-4">
                            @if($telepon)
                                <span class="flex items-center gap-1 font-semibold text-teal-800">
                                    <span class="material-symbols-outlined text-[16px]!">call</span> {{ $telepon }}
                                </span>
                            @endif
                            @if($email)
                                <span class="flex items-center gap-1 font-semibold text-teal-800">
                                    <span class="material-symbols-outlined text-[16px]!">mail</span> {{ $email }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Bottom Sticky / Floating Save Bar --}}
        <div class="flex items-center justify-between p-4 bg-white rounded-2xl shadow-sm border border-gray-100">
            <span class="text-xs text-gray-500">
                Pastikan data yang Anda isi sudah benar sebelum menekan tombol simpan.
            </span>
            <button type="submit" wire:loading.attr="disabled"
                class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white font-bold rounded-xl text-sm shadow-lg shadow-teal-500/20 transition cursor-pointer">
                <span wire:loading.remove class="material-symbols-outlined text-[18px]!">save</span>
                <span wire:loading.remove>Simpan Profil Organisasi</span>
                <span wire:loading class="inline-flex items-center gap-2">
                    <span class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                    Menyimpan...
                </span>
            </button>
        </div>
    </form>
</div>
