<div>
    {{-- Alerts --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3 text-sm font-medium text-green-800 shadow-sm animate-in fade-in">
            <span class="material-symbols-outlined text-green-600 text-[22px]!">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-extrabold text-gray-800">Hero Section Menu Pengunjung</h2>
            <p class="text-sm text-gray-500">Kelola gambar latar banner atas, judul, dan teks di setiap menu halaman publik</p>
        </div>
    </div>

    {{-- Tips Banner --}}
    <div class="mb-8 bg-gradient-to-r from-teal-50 via-emerald-50 to-teal-50 border border-teal-200/80 rounded-2xl p-5 flex items-start gap-4 shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-teal-600 text-white flex items-center justify-center shrink-0 shadow-md shadow-teal-500/20">
            <span class="material-symbols-outlined text-[22px]!">lightbulb</span>
        </div>
        <div class="flex-1 text-sm text-gray-700">
            <p class="font-bold text-gray-900 mb-1">Panduan Gambar Hero Banner:</p>
            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                Setiap menu publik (Berita, Kegiatan, Profil, Anggota, Donasi, Relawan, Mitra, Perizinan) memiliki banner besar di bagian atas. Anda dapat mengunggah foto bertema yayasan untuk masing-masing menu. Jika gambar tidak diunggah, halaman otomatis menggunakan latar belakang warna gradasi bawaan yang tetap elegan.
            </p>
        </div>
    </div>

    {{-- Grid Menu Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($heroes as $hero)
            @php
                $hasImg = !empty($hero->gambar);
                $pageIcon = match($hero->page_key) {
                    'berita' => 'newspaper',
                    'kegiatan' => 'event',
                    'profil' => 'business',
                    'anggota' => 'groups',
                    'donasi' => 'volunteer_activism',
                    'mitra' => 'handshake',
                    'relawan' => 'diversity_3',
                    'perizinan' => 'description',
                    default => 'web',
                };
            @endphp
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition flex flex-col group">
                {{-- Preview Banner --}}
                <div class="relative h-44 bg-gradient-to-br from-gray-900 via-gray-800 to-teal-900 overflow-hidden flex items-center justify-center text-center p-4">
                    @if($hasImg)
                        <img src="{{ asset('storage/' . $hero->gambar) }}" alt="{{ $hero->page_name }}" class="absolute inset-0 w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black" style="opacity: {{ ($hero->overlay_opacity ?? 60) / 100 }};"></div>
                    @else
                        <div class="absolute inset-0 opacity-20">
                            <div class="absolute top-2 left-2 w-32 h-32 rounded-full bg-teal-400 blur-2xl"></div>
                            <div class="absolute bottom-2 right-2 w-32 h-32 rounded-full bg-amber-400 blur-2xl"></div>
                        </div>
                    @endif

                    <div class="relative z-10 text-white px-3">
                        <div class="w-8 h-8 rounded-lg bg-white/20 backdrop-blur-md flex items-center justify-center mx-auto mb-2 text-white">
                            <span class="material-symbols-outlined text-[18px]!">{{ $pageIcon }}</span>
                        </div>
                        <h4 class="font-bold text-sm sm:text-base line-clamp-1 drop-shadow-sm text-white">
                            {{ $hero->judul ?: $hero->page_name }}
                        </h4>
                        @if($hero->subjudul)
                            <p class="text-[11px] text-gray-200 line-clamp-2 mt-1 max-w-xs mx-auto drop-shadow-sm">
                                {{ $hero->subjudul }}
                            </p>
                        @endif
                    </div>

                    {{-- Top Badges --}}
                    <div class="absolute top-3 left-3 z-20 flex items-center gap-1.5">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-white/90 text-gray-800 shadow-sm backdrop-blur-sm">
                            Menu: {{ $hero->page_name }}
                        </span>
                    </div>

                    <div class="absolute top-3 right-3 z-20">
                        @if($hasImg)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-teal-600/90 text-white shadow-sm backdrop-blur-sm">
                                <span class="material-symbols-outlined text-[12px]!">image</span> Foto Kustom
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-gray-900/70 text-gray-300 shadow-sm backdrop-blur-sm">
                                Default Gradasi
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Card Details --}}
                <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                    <div>
                        <div class="flex items-center justify-between text-xs text-gray-500 mb-2">
                            <span class="font-mono text-[11px]">/{{ $hero->page_key }}</span>
                            <span class="text-[11px] text-gray-400">Overlay: {{ $hero->overlay_opacity }}%</span>
                        </div>
                        <p class="text-xs text-gray-600 line-clamp-2 leading-relaxed">
                            {{ $hero->subjudul ?: 'Belum ada subjudul khusus. Menampilkan subjudul bawaan sistem.' }}
                        </p>
                    </div>

                    <div class="pt-3 border-t border-gray-100 flex items-center justify-between gap-2">
                        @if($hero->route_name && Route::has($hero->route_name))
                            <a href="{{ route($hero->route_name) }}" target="_blank"
                               class="inline-flex items-center gap-1 text-xs text-gray-500 hover:text-teal-600 transition" title="Buka Halaman Publik">
                                <span class="material-symbols-outlined text-[16px]!">open_in_new</span>
                                <span>Lihat Halaman</span>
                            </a>
                        @else
                            <span></span>
                        @endif

                        <button wire:click="edit({{ $hero->id }})"
                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-teal-50 text-teal-700 hover:bg-teal-100 font-bold rounded-xl text-xs transition cursor-pointer">
                            <span class="material-symbols-outlined text-[16px]!">edit</span>
                            Atur Hero
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Edit Modal --}}
    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="$set('showModal', false)"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-xl max-h-[90vh] overflow-y-auto animate-in fade-in duration-200">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-teal-600">wallpaper</span>
                    <h3 class="text-lg font-bold text-gray-800">Atur Hero Menu: {{ $page_name }}</h3>
                </div>
                <button wire:click="$set('showModal', false)" class="p-1 rounded-lg hover:bg-gray-200 text-gray-400">
                    <span class="material-symbols-outlined text-[20px]!">close</span>
                </button>
            </div>

            <form wire:submit="save" class="p-6 space-y-5">
                {{-- Live Preview Box Inside Modal --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Simulasi Tampilan Banner</label>
                    <div class="relative h-44 rounded-2xl overflow-hidden bg-gradient-to-br from-gray-900 via-gray-800 to-teal-900 flex items-center justify-center text-center p-6 text-white border border-gray-200 shadow-inner">
                        @if($newGambar)
                            <img src="{{ $newGambar->temporaryUrl() }}" class="absolute inset-0 w-full h-full object-cover">
                        @elseif($existingGambar)
                            <img src="{{ asset('storage/' . $existingGambar) }}" class="absolute inset-0 w-full h-full object-cover">
                        @endif

                        <div class="absolute inset-0 bg-black" style="opacity: {{ $overlay_opacity / 100 }};"></div>

                        <div class="relative z-10 max-w-md">
                            <h4 class="text-xl sm:text-2xl font-extrabold mb-1 drop-shadow-md text-white">
                                {{ $judul ?: $page_name }}
                            </h4>
                            <p class="text-xs text-gray-200 line-clamp-2 drop-shadow-md">
                                {{ $subjudul ?: 'Subjudul hero section akan tampil di bawah judul utama...' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Upload Gambar Hero --}}
                <div class="p-4 bg-gray-50 rounded-2xl border border-gray-200/80 space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="text-sm font-bold text-gray-800">Foto Latar Belakang (Hero Image)</label>
                        <span class="text-xs text-gray-400">Maks. 5MB (JPG/PNG/WEBP)</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <input type="file" wire:model="newGambar" accept="image/*"
                            class="flex-1 text-xs file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-teal-600 file:text-white file:font-bold hover:file:bg-teal-700 cursor-pointer">
                        @if($existingGambar || $newGambar)
                            <button type="button" wire:click="removeGambar({{ $selectedId }})"
                                class="px-3 py-2 text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 rounded-xl transition flex items-center gap-1 shrink-0">
                                <span class="material-symbols-outlined text-[16px]!">delete</span>
                                Hapus Foto
                            </button>
                        @endif
                    </div>
                    <p class="text-[11px] text-gray-500">
                        Rekomendasi ukuran: <strong>1920 × 600 pixel</strong> (orientasi lanskap melebar).
                    </p>
                    @error('newGambar') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Tingkat Kepekatan Overlay --}}
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="text-sm font-semibold text-gray-700">Tingkat Kegelapan Latar (Overlay Darkening): <strong class="text-teal-700">{{ $overlay_opacity }}%</strong></label>
                    </div>
                    <input type="range" wire:model.live="overlay_opacity" min="10" max="90" step="5"
                        class="w-full accent-teal-600 cursor-pointer">
                    <div class="flex justify-between text-[10px] text-gray-400 mt-1">
                        <span>10% (Terang / Foto Jelas)</span>
                        <span>50% (Sedang)</span>
                        <span>90% (Sangat Gelap / Teks Menonjol)</span>
                    </div>
                </div>

                {{-- Judul & Subjudul --}}
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Banner Halaman *</label>
                        <input type="text" wire:model="judul" placeholder="cth: Berita & Informasi"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                        @error('judul') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Subjudul / Deskripsi Singkat</label>
                        <textarea wire:model="subjudul" rows="2" placeholder="Deskripsi singkat yang tampil di bawah judul..."
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 resize-none"></textarea>
                        @error('subjudul') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Active Switch --}}
                <div class="pt-2 border-t border-gray-100">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" wire:model="is_active" class="rounded border-gray-300 text-teal-600 focus:ring-teal-500">
                        <span class="text-sm font-medium text-gray-700">Gunakan Pengaturan Hero Kustom Ini</span>
                    </label>
                </div>

                {{-- Buttons --}}
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" wire:click="$set('showModal', false)"
                        class="px-5 py-2.5 border border-gray-200 text-gray-600 font-semibold rounded-xl text-sm hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-xl text-sm shadow-md shadow-teal-500/20 transition cursor-pointer">
                        Simpan Hero Section
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>

