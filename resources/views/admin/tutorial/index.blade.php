<x-layouts.admin>
    <x-slot:title>Tutorial Admin</x-slot:title>
    <x-slot:header>Tutorial & Panduan Admin</x-slot:header>

    @php
        $guides = [
            // Konten & Tampilan
            [
                'category' => 'konten',
                'categoryLabel' => 'Konten & Tampilan',
                'icon' => 'category',
                'color' => 'bg-purple-50 text-purple-600 border-purple-100',
                'title' => '1. Kategori Berita & Kegiatan',
                'when' => 'Buat kategori lebih dulu sebelum menulis berita atau kegiatan.',
                'steps' => [
                    'Klik tombol <strong>Tambah</strong> di kanan atas.',
                    'Isi nama kategori lalu pilih warna label.',
                    'Simpan agar kategori muncul di pilihan saat membuat berita.',
                ],
                'route' => route('admin.kategori.index'),
                'keywords' => 'kategori berita label warna',
            ],
            [
                'category' => 'konten',
                'categoryLabel' => 'Konten & Tampilan',
                'icon' => 'newspaper',
                'color' => 'bg-teal-50 text-teal-600 border-teal-100',
                'title' => '2. Berita & Kegiatan',
                'when' => 'Membuat artikel berita atau laporan kegiatan baru untuk website.',
                'steps' => [
                    'Klik <strong>Tambah Baru</strong>, lalu pilih tipe <em>Berita</em> atau <em>Kegiatan</em>.',
                    'Pilih kategori, unggah foto sampul (maks. 2MB), dan tulis isi konten.',
                    'Pilih status <strong>Published</strong> agar langsung tayang, atau <strong>Draft</strong> untuk disimpan dulu.',
                ],
                'route' => route('admin.berita.index'),
                'keywords' => 'berita kegiatan artikel publish draft upload foto',
            ],
            [
                'category' => 'konten',
                'categoryLabel' => 'Konten & Tampilan',
                'icon' => 'view_carousel',
                'color' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                'title' => '3. Slider Home',
                'when' => 'Mengganti banner geser utama di halaman paling depan (Beranda).',
                'steps' => [
                    'Klik <strong>Tambah</strong> atau <strong>Edit</strong> pada kartu slider yang ada.',
                    'Isi judul, teks singkat, link tombol, dan urutan tampil (<code>#1</code> tampil pertama).',
                    'Gunakan tombol <strong>Aktifkan / Nonaktifkan</strong> di kartu untuk menyembunyikan slider sementara.',
                ],
                'route' => route('admin.sliders.index'),
                'keywords' => 'slider home beranda carousel banner depan',
            ],
            [
                'category' => 'konten',
                'categoryLabel' => 'Konten & Tampilan',
                'icon' => 'wallpaper',
                'color' => 'bg-sky-50 text-sky-600 border-sky-100',
                'title' => '4. Hero Banner Menu',
                'when' => 'Mengatur gambar latar atas pada tiap halaman publik (Profil, Berita, Relawan, dll).',
                'steps' => [
                    'Pilih halaman yang ingin diubah lalu klik <strong>Atur Hero</strong>.',
                    'Unggah gambar latar (maks. 2MB), sesuaikan judul/subjudul dan kepekatan overlay.',
                    'Simpan, lalu klik <strong>Lihat Halaman</strong> untuk mengecek hasilnya.',
                ],
                'route' => route('admin.hero-sections.index'),
                'keywords' => 'hero banner menu background gambar atas header halaman publik',
            ],

            // Profil & Pengurus
            [
                'category' => 'profil',
                'categoryLabel' => 'Profil & Pengurus',
                'icon' => 'business',
                'color' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                'title' => '5. Profil & Dokumen Organisasi',
                'when' => 'Mengubah logo yayasan, visi misi, sejarah, alamat, serta link media sosial.',
                'steps' => [
                    'Buka tab berurutan dari <strong>1. Identitas & Logo</strong> hingga <strong>4. Kontak & Medsos</strong>.',
                    'Cek hasil akhir di tab <strong>5. Pratinjau Tampilan</strong>.',
                    'Klik tombol <strong>Simpan Profil</strong> di kanan atas agar perubahan langsung tampil di website.',
                ],
                'route' => route('admin.profil.index'),
                'keywords' => 'profil logo visi misi sejarah alamat email telepon sosmed',
            ],
            [
                'category' => 'profil',
                'categoryLabel' => 'Profil & Pengurus',
                'icon' => 'groups',
                'color' => 'bg-blue-50 text-blue-600 border-blue-100',
                'title' => '6. Anggota & Divisi',
                'when' => 'Menambahkan struktur divisi dan daftar pengurus yayasan.',
                'steps' => [
                    'Buka tab <strong>Divisi</strong> lebih dulu lalu klik <strong>Tambah Divisi</strong> (misal: Pendidikan, Sosial).',
                    'Pindah ke tab <strong>Anggota</strong> dan klik <strong>Tambah Anggota</strong>.',
                    'Klik badge <em>Aktif / Nonaktif</em> di kolom Status untuk menampilkan atau menyembunyikan pengurus.',
                ],
                'route' => route('admin.anggota.index'),
                'keywords' => 'anggota divisi pengurus struktur tim',
            ],

            // Donasi
            [
                'category' => 'donasi',
                'categoryLabel' => 'Donasi',
                'icon' => 'volunteer_activism',
                'color' => 'bg-amber-50 text-amber-600 border-amber-100',
                'title' => '7. Program Donasi & Saklar Menu',
                'when' => 'Membuat penggalangan dana dan mengatur aktif/non-aktif menu donasi di website.',
                'steps' => [
                    'Gunakan kartu atas <strong>Status Menu Donasi Publik</strong> untuk menyalakan atau mematikan seluruh menu donasi di website.',
                    'Klik <strong>Tambah Program</strong> untuk membuat program donasi baru lengkap dengan target nominal.',
                    'Klik badge di kolom <strong>Status</strong> tabel (<em>Aktif</em> / <em>Nonaktif (Draft)</em>) untuk menayangkan atau menyembunyikan program tertentu.',
                ],
                'route' => route('admin.program-donasi.index'),
                'keywords' => 'program donasi aktif nonaktif saklar draft target galang dana',
            ],
            [
                'category' => 'donasi',
                'categoryLabel' => 'Donasi',
                'icon' => 'receipt_long',
                'color' => 'bg-cyan-50 text-cyan-600 border-cyan-100',
                'title' => '8. Transaksi Donasi',
                'when' => 'Memantau daftar donatur yang masuk beserta status pembayaran Midtrans.',
                'steps' => [
                    'Gunakan pencarian nama/order ID atau filter status (<em>Pending</em>, <em>Success</em>, <em>Failed</em>, <em>Expired</em>).',
                    'Klik ikon mata (<em>detail</em>) untuk melihat pesan donatur, metode bayar, dan program tujuan.',
                    'Nominal transaksi berstatus <strong>Success</strong> otomatis menambah total donasi terkumpul di website.',
                ],
                'route' => route('admin.transaksi-donasi.index'),
                'keywords' => 'transaksi donasi donatur midtrans pembayaran pending success',
            ],

            // Layanan Publik
            [
                'category' => 'layanan',
                'categoryLabel' => 'Layanan Publik',
                'icon' => 'description',
                'color' => 'bg-orange-50 text-orange-600 border-orange-100',
                'title' => '9. Perizinan',
                'when' => 'Memproses permohonan izin kegiatan/kerja sama atau menambah data perizinan.',
                'steps' => [
                    'Klik ikon mata untuk membaca deskripsi permohonan dan mengunduh dokumen lampiran.',
                    'Klik ikon edit untuk mengubah status (<em>Pending</em> → <em>Diproses</em> → <em>Selesai / Ditolak</em>).',
                    'Isi <strong>Catatan Admin</strong> agar pemohon dapat melihat perkembangan statusnya di menu publik.',
                ],
                'route' => route('admin.perizinan.index'),
                'keywords' => 'perizinan surat izin lampiran dokumen catatan status diproses selesai',
            ],
            [
                'category' => 'layanan',
                'categoryLabel' => 'Layanan Publik',
                'icon' => 'handshake',
                'color' => 'bg-lime-50 text-lime-700 border-lime-100',
                'title' => '10. Mitra',
                'when' => 'Meninjau pendaftaran mitra kerja sama atau menambahkan mitra langsung dari admin.',
                'steps' => [
                    'Klik <strong>Tambah Mitra</strong> untuk input langsung, atau cek pendaftar baru berstatus <em>Pending</em>.',
                    'Klik ikon mata untuk memeriksa profil dan dokumen NPWP/legalitas mitra.',
                    'Ubah status ke <strong>Disetujui (Approved)</strong> untuk mengaktifkan mitra (dan membuat akun login Panel Mitra bila dicentang).',
                ],
                'route' => route('admin.mitra.index'),
                'keywords' => 'mitra kerjasama npwp legalitas approved akun panel',
            ],
            [
                'category' => 'layanan',
                'categoryLabel' => 'Layanan Publik',
                'icon' => 'diversity_3',
                'color' => 'bg-rose-50 text-rose-600 border-rose-100',
                'title' => '11. Relawan',
                'when' => 'Mengelola pendaftaran relawan publik dan menambah data relawan baru.',
                'steps' => [
                    'Gunakan tombol <strong>Tambah Relawan</strong> untuk menambahkan data relawan dari admin.',
                    'Klik ikon mata untuk melihat pekerjaan, keahlian, dan motivasi pendaftar.',
                    'Ubah status menjadi <strong>Disetujui</strong> agar terhitung di statistik relawan aktif halaman Home.',
                ],
                'route' => route('admin.relawan.index'),
                'keywords' => 'relawan volunteer pendaftaran keahlian disetujui',
            ],

            // Pengguna & Sistem
            [
                'category' => 'sistem',
                'categoryLabel' => 'Pengguna & Sistem',
                'icon' => 'people',
                'color' => 'bg-slate-100 text-slate-700 border-slate-200',
                'title' => '12. Pengguna & Role Akun',
                'when' => 'Membuat akun baru untuk Admin, Mitra, atau Member serta mengatur izin akses.',
                'steps' => [
                    'Klik <strong>Tambah Pengguna</strong>, isi nama, email, password, dan pilih role (<em>Super Admin</em>, <em>Admin</em>, <em>Mitra</em>, <em>Member</em>).',
                    'Klik badge status di kolom Status untuk langsung mengaktifkan/menonaktifkan akses login user.',
                    'Gunakan filter role di bagian atas untuk mencari akun tertentu.',
                ],
                'route' => route('admin.users.index'),
                'keywords' => 'pengguna user akun role admin superadmin mitra member password',
            ],
            [
                'category' => 'sistem',
                'categoryLabel' => 'Khusus Super Admin',
                'icon' => 'history',
                'color' => 'bg-zinc-100 text-zinc-700 border-zinc-200',
                'title' => '13. Audit Log (Riwayat Sistem)',
                'when' => 'Mengecek riwayat login, logout, gagal login, serta siapa yang menambah, mengubah, atau menghapus data di sistem.',
                'steps' => [
                    'Filter aktivitas berdasarkan jenis aksi (<em>Login</em>, <em>Logout</em>, <em>Failed</em>, <em>Created</em>, <em>Updated</em>, <em>Deleted</em>) atau ketik nama pelaku/model.',
                    'Klik ikon detail di baris log untuk membandingkan data lama dan data baru serta informasi IP/perangkat.',
                ],
                'route' => route('admin.audit-log.index'),
                'keywords' => 'audit log riwayat aktivitas histori siapa ubah hapus login logout gagal',
            ],
        ];

        $isSuperAdmin = auth()->user()?->isSuperAdmin() ?? false;
        if (! $isSuperAdmin) {
            $guides = array_values(array_filter($guides, fn ($g) => $g['category'] !== 'sistem'));
        }

        $faqs = [
            [
                'q' => 'Kenapa menu Donasi tidak muncul di website publik?',
                'a' => 'Buka menu <strong>Program Donasi</strong>, lalu cek kartu paling atas bertuliskan <strong>Status Menu Donasi Publik</strong>. Jika berstatus Non-aktif, klik tombol <strong>Aktifkan Menu Donasi</strong>.',
            ],
            [
                'q' => 'Kenapa berita atau program donasi yang baru dibuat belum tampil di halaman depan?',
                'a' => 'Pastikan statusnya bukan <strong>Draft</strong>. Berita harus berstatus <strong>Published</strong>, dan Program Donasi harus berstatus <strong>Aktif</strong>.',
            ],
            [
                'q' => 'Apa syarat ukuran gambar yang aman saat upload?',
                'a' => 'Gunakan gambar berformat JPG, PNG, atau WebP dengan ukuran maksimal <strong>2MB</strong> agar upload cepat dan tidak ditolak sistem.',
            ],
            [
                'q' => 'Bagaimana cara melihat tampilan perubahan di website publik dengan cepat?',
                'a' => 'Klik tombol <strong>Lihat Website</strong> di pojok kanan atas header admin (ikon panah kotak keluar) untuk membuka halaman publik di tab baru.',
            ],
        ];
    @endphp

    <div x-data="{
        search: '',
        activeCategory: 'semua',
        openFaq: 0,
        items: {{ \Illuminate\Support\Js::from(collect($guides)->map(fn($g) => [
            'category' => $g['category'],
            'text' => strtolower($g['title'] . ' ' . $g['when'] . ' ' . $g['keywords']),
        ])->values()) }},
        matches(cat, title, when, keywords) {
            const catMatch = this.activeCategory === 'semua' || this.activeCategory === cat;
            if (!catMatch) return false;
            const q = this.search.trim().toLowerCase();
            if (!q) return true;
            return (title + ' ' + when + ' ' + keywords).toLowerCase().includes(q);
        },
        get hasAnyMatch() {
            const q = this.search.trim().toLowerCase();
            return this.items.some(i => (this.activeCategory === 'semua' || this.activeCategory === i.category) && (!q || i.text.includes(q)));
        }
    }">
        {{-- Intro & Quick Start Card --}}
        <div class="mb-8 rounded-2xl bg-gradient-to-r from-gray-900 via-gray-800 to-teal-900 text-white p-6 sm:p-8 shadow-lg">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div class="max-w-2xl">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-teal-500/20 text-teal-300 border border-teal-400/30 mb-3">
                        <span class="material-symbols-outlined text-[15px]!">menu_book</span>
                        PANDUAN RINGKAS ADMIN
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold mb-2">Cara Cepat Mengelola Website YSSC</h2>
                    <p class="text-gray-300 text-sm leading-relaxed">
                        Panduan langsung ke inti di tiap menu. Pilih topik di bawah atau langsung klik tombol <strong>Buka Menu</strong> untuk mempraktikkan.
                    </p>
                </div>

                {{-- 3 Langkah Pertama --}}
                <div class="bg-white/10 backdrop-blur-sm border border-white/15 rounded-2xl p-4 sm:p-5 lg:w-96 shrink-0">
                    <p class="text-xs font-bold uppercase tracking-wider text-yellow-300 mb-3 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px]!">bolt</span>
                        Urutan Setup Pertama Kali
                    </p>
                    <ol class="space-y-2.5 text-xs sm:text-sm text-gray-100">
                        <li class="flex items-start gap-2.5">
                            <span class="w-5 h-5 rounded-full bg-teal-500 text-white font-bold text-xs flex items-center justify-center shrink-0 mt-0.5">1</span>
                            <span>Lengkapi identitas, logo &amp; visi misi di <a href="{{ route('admin.profil.index') }}" wire:navigate.hover class="underline font-semibold text-teal-300 hover:text-white">Profil &amp; Dokumen</a>.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <span class="w-5 h-5 rounded-full bg-teal-500 text-white font-bold text-xs flex items-center justify-center shrink-0 mt-0.5">2</span>
                            <span>Pasang foto depan di <a href="{{ route('admin.sliders.index') }}" wire:navigate.hover class="underline font-semibold text-teal-300 hover:text-white">Slider Home</a> &amp; <a href="{{ route('admin.hero-sections.index') }}" wire:navigate.hover class="underline font-semibold text-teal-300 hover:text-white">Hero Banner</a>.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <span class="w-5 h-5 rounded-full bg-teal-500 text-white font-bold text-xs flex items-center justify-center shrink-0 mt-0.5">3</span>
                            <span>Mulai isi <a href="{{ route('admin.berita.index') }}" wire:navigate.hover class="underline font-semibold text-teal-300 hover:text-white">Berita</a> dan kelola <a href="{{ route('admin.program-donasi.index') }}" wire:navigate.hover class="underline font-semibold text-teal-300 hover:text-white">Program Donasi</a>.</span>
                        </li>
                    </ol>
                </div>
            </div>
        </div>

        {{-- Search & Category Filter --}}
        <div class="bg-white rounded-2xl p-4 sm:p-5 shadow-sm border border-gray-100 mb-6 space-y-4">
            <div class="relative">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]!">search</span>
                <input type="text" x-model="search" placeholder="Cari panduan cepat... (contoh: donasi, berita, mitra, gambar, status)"
                       class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-sm sm:text-base bg-gray-50/40 focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
            </div>

            <div class="flex flex-wrap gap-2">
                @php
                    $tabs = [
                        'semua' => 'Semua Menu',
                        'konten' => 'Konten & Tampilan',
                        'profil' => 'Profil & Pengurus',
                        'donasi' => 'Donasi',
                        'layanan' => 'Layanan Publik',
                    ];
                    if ($isSuperAdmin) {
                        $tabs['sistem'] = 'Pengguna & Sistem';
                    }
                @endphp
                @foreach($tabs as $key => $label)
                    <button type="button" @click="activeCategory = '{{ $key }}'"
                            class="min-h-[40px] px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition cursor-pointer"
                            :class="activeCategory === '{{ $key }}' ? 'bg-teal-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'">
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Guide Cards Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-10">
            @foreach($guides as $g)
                <div x-show="matches('{{ $g['category'] }}', '{{ addslashes($g['title']) }}', '{{ addslashes($g['when']) }}', '{{ addslashes($g['keywords']) }}')"
                     x-transition
                     class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-gray-100 hover:shadow-md hover:border-teal-200/80 transition flex flex-col">
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-xl border flex items-center justify-center shrink-0 {{ $g['color'] }}">
                                <span class="material-symbols-outlined text-[22px]!">{{ $g['icon'] }}</span>
                            </div>
                            <div>
                                <span class="text-[11px] font-bold uppercase tracking-wider text-gray-400">{{ $g['categoryLabel'] }}</span>
                                <h3 class="text-base sm:text-lg font-extrabold text-gray-800 leading-snug">{{ $g['title'] }}</h3>
                            </div>
                        </div>
                    </div>

                    <p class="text-xs sm:text-sm text-gray-600 bg-gray-50 rounded-xl px-3.5 py-2.5 border border-gray-100 mb-4">
                        <span class="font-bold text-gray-800">Fungsi:</span> {{ $g['when'] }}
                    </p>

                    <div class="space-y-2 mb-5 flex-1">
                        <p class="text-xs font-bold uppercase tracking-wider text-teal-700">Langkah Praktis:</p>
                        <ol class="space-y-2">
                            @foreach($g['steps'] as $idx => $step)
                                <li class="flex items-start gap-2.5 text-xs sm:text-sm text-gray-600 leading-relaxed">
                                    <span class="w-5 h-5 rounded-md bg-teal-50 text-teal-700 font-bold text-xs flex items-center justify-center shrink-0 mt-0.5 border border-teal-100">{{ $idx + 1 }}</span>
                                    <span>{!! $step !!}</span>
                                </li>
                            @endforeach
                        </ol>
                    </div>

                    <div class="pt-3 border-t border-gray-100 flex justify-end">
                        <a href="{{ $g['route'] }}" wire:navigate.hover
                           class="inline-flex items-center justify-center gap-1.5 min-h-[44px] px-4 py-2 rounded-xl bg-teal-50 hover:bg-teal-600 text-teal-700 hover:text-white font-bold text-xs sm:text-sm transition w-full sm:w-auto">
                            <span>Buka Menu</span>
                            <span class="material-symbols-outlined text-[18px]!">arrow_forward</span>
                        </a>
                    </div>
                </div>
            @endforeach

            <div x-show="!hasAnyMatch" class="col-span-full bg-white rounded-2xl p-10 text-center border border-gray-100 shadow-sm">
                <span class="material-symbols-outlined text-[44px]! text-gray-300 mb-2">search_off</span>
                <p class="text-sm font-bold text-gray-700 mb-1">Panduan tidak ditemukan</p>
                <p class="text-xs text-gray-400 mb-4">Coba gunakan kata kunci lain seperti "berita", "donasi", "mitra", atau "profil".</p>
                <button type="button" @click="search = ''; activeCategory = 'semua'"
                        class="min-h-[40px] px-4 py-2 rounded-xl bg-teal-600 text-white text-xs font-bold hover:bg-teal-700 transition cursor-pointer">
                    Tampilkan Semua Panduan
                </button>
            </div>
        </div>

        {{-- Role Access Overview Section --}}
        <div class="bg-white rounded-2xl p-5 sm:p-7 shadow-sm border border-gray-100 mb-6">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center border border-teal-100 shrink-0">
                    <span class="material-symbols-outlined text-[22px]!">admin_panel_settings</span>
                </div>
                <div>
                    <h3 class="text-lg font-extrabold text-gray-800">Pembagian Hak Akses (Role Sistem)</h3>
                    <p class="text-xs sm:text-sm text-gray-500">Pemisahan wewenang antara pengelola sistem inti, admin operasional, mitra, dan publik</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="rounded-xl border border-indigo-200 bg-indigo-50/50 p-4">
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-indigo-800">Super Admin</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-indigo-600 text-white">Penuh</span>
                    </div>
                    <p class="text-xs text-gray-700 leading-relaxed">
                        Mengakses seluruh <strong>15 menu admin</strong> termasuk kontrol eksklusif atas <strong>Pengguna &amp; Role</strong> serta <strong>Audit Log</strong> (riwayat login &amp; perubahan data).
                    </p>
                </div>

                <div class="rounded-xl border border-teal-200 bg-teal-50/50 p-4">
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-teal-800">Admin</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-teal-600 text-white">Operasional</span>
                    </div>
                    <p class="text-xs text-gray-700 leading-relaxed">
                        Mengelola konten &amp; operasional (Dashboard, Berita, Kategori, Profil &amp; Dokumen, Anggota, Program &amp; Transaksi Donasi, Perizinan, Mitra, Relawan, Slider, Hero Banner, Tutorial). <strong>Tidak dapat</strong> membuka Pengguna &amp; Audit Log.
                    </p>
                </div>

                <div class="rounded-xl border border-amber-200 bg-amber-50/50 p-4">
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-amber-800">Mitra</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-600 text-white">Portal Mitra</span>
                    </div>
                    <p class="text-xs text-gray-700 leading-relaxed">
                        Diarahkan khusus ke <strong>Portal Mitra</strong> (<code>/mitra-panel</code>) untuk kolaborasi program dan pemantauan terkait mitra tanpa akses panel admin.
                    </p>
                </div>

                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-gray-700">Member &amp; Guest</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-gray-600 text-white">Publik</span>
                    </div>
                    <p class="text-xs text-gray-700 leading-relaxed">
                        Mengakses halaman publik website (berita, donasi, pengajuan perizinan, pendaftaran relawan/mitra) tanpa akses panel internal.
                    </p>
                </div>
            </div>
        </div>

        {{-- FAQ Section --}}
        <div class="bg-white rounded-2xl p-5 sm:p-7 shadow-sm border border-gray-100">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-100 shrink-0">
                    <span class="material-symbols-outlined text-[22px]!">help</span>
                </div>
                <div>
                    <h3 class="text-lg font-extrabold text-gray-800">Pertanyaan Sering Ditanyakan (FAQ)</h3>
                    <p class="text-xs sm:text-sm text-gray-500">Solusi cepat jika mengalami kendala umum saat mengelola website</p>
                </div>
            </div>

            <div class="space-y-2.5">
                @foreach($faqs as $i => $faq)
                    <div class="border border-gray-100 rounded-xl overflow-hidden">
                        <button type="button" @click="openFaq = openFaq === {{ $i }} ? -1 : {{ $i }}"
                                class="w-full flex items-center justify-between gap-3 px-4 py-3.5 min-h-[48px] text-left bg-gray-50/70 hover:bg-gray-100/70 transition cursor-pointer">
                            <span class="text-sm font-bold text-gray-800">{{ $faq['q'] }}</span>
                            <span class="material-symbols-outlined text-gray-400 transition-transform duration-200 shrink-0"
                                  :class="openFaq === {{ $i }} && 'rotate-180'">expand_more</span>
                        </button>
                        <div x-show="openFaq === {{ $i }}" x-collapse class="px-4 py-3.5 text-xs sm:text-sm text-gray-600 leading-relaxed bg-white border-t border-gray-100">
                            {!! $faq['a'] !!}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.admin>
