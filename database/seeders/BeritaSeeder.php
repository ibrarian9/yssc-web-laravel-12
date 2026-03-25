<?php

namespace Database\Seeders;

use App\Models\Berita;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        $berita = [
            [
                'judul' => 'Aksi Cinta Anak Negeri 2025 Sukses Digelar',
                'konten' => '<p>Program Aksi Cinta Anak Negeri 2025 telah berhasil dilaksanakan di 5 kota besar di Indonesia. Kegiatan ini melibatkan lebih dari 200 relawan yang memberikan pendidikan gratis kepada anak-anak dari keluarga kurang mampu.</p><p>Dalam program ini, para relawan mengajarkan berbagai mata pelajaran termasuk Matematika, Bahasa Inggris, dan keterampilan digital. Selain itu, juga diadakan kegiatan kreatif seperti menggambar, musik, dan olahraga.</p><p>Program ini mendapatkan dukungan penuh dari Dinas Pendidikan setempat dan akan dilanjutkan pada tahun berikutnya dengan target yang lebih besar.</p>',
                'kategori_id' => 1, 'user_id' => 1, 'tipe' => 'kegiatan', 'status' => 'published',
                'tanggal_kegiatan' => '2025-11-07', 'lokasi' => 'Pekanbaru, Riau',
                'thumbnail' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=800',
            ],
            [
                'judul' => 'Bantuan Keberlangsungan Hidup untuk Keluarga Prasejahtera',
                'konten' => '<p>Yayasan Seribu Satu Cita kembali menyalurkan bantuan berupa paket sembako dan kebutuhan pokok kepada 150 keluarga prasejahtera di wilayah Kampar, Riau.</p><p>Bantuan ini disalurkan langsung oleh para relawan yayasan yang turun ke lapangan untuk memastikan bantuan tepat sasaran. Selain sembako, yayasan juga memberikan konsultasi kesehatan gratis bekerja sama dengan tenaga medis lokal.</p>',
                'kategori_id' => 2, 'user_id' => 1, 'tipe' => 'berita', 'status' => 'published',
                'thumbnail' => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=800',
            ],
            [
                'judul' => 'Beasiswa Permata Cita 2025 Dibuka untuk Mahasiswa',
                'konten' => '<p>Yayasan Seribu Satu Cita membuka pendaftaran Beasiswa Permata Cita 2025 untuk mahasiswa berprestasi dari keluarga kurang mampu. Beasiswa ini mencakup biaya kuliah, uang saku bulanan, dan pendampingan akademik.</p><p>Tahun ini, yayasan menargetkan 50 penerima beasiswa dari berbagai perguruan tinggi di Indonesia. Pendaftaran dibuka mulai 1 Mei hingga 30 Juni 2025.</p>',
                'kategori_id' => 3, 'user_id' => 2, 'tipe' => 'berita', 'status' => 'published',
                'thumbnail' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=800',
            ],
            [
                'judul' => 'Workshop Digital Marketing untuk UMKM Desa',
                'konten' => '<p>Dalam rangka mendukung pemberdayaan ekonomi masyarakat desa, Yayasan Seribu Satu Cita menyelenggarakan Workshop Digital Marketing untuk pelaku UMKM di Kabupaten Siak, Riau.</p><p>Workshop ini diikuti oleh 40 peserta dari berbagai desa yang belajar tentang pemasaran digital, penggunaan media sosial untuk bisnis, dan fotografi produk. Para peserta juga diajarkan cara membuat toko online.</p>',
                'kategori_id' => 1, 'user_id' => 2, 'tipe' => 'kegiatan', 'status' => 'published',
                'tanggal_kegiatan' => '2025-09-15', 'lokasi' => 'Siak, Riau',
                'thumbnail' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=800',
            ],
            [
                'judul' => 'Penanaman 1000 Pohon di Bantaran Sungai Siak',
                'konten' => '<p>Yayasan Seribu Satu Cita bersama masyarakat setempat dan mahasiswa dari berbagai universitas melakukan penanaman 1000 pohon di bantaran Sungai Siak sebagai upaya pelestarian lingkungan.</p><p>Kegiatan yang diikuti oleh 300 relawan ini bertujuan untuk mengurangi erosi bantaran sungai dan meningkatkan kualitas air sungai yang menjadi sumber kehidupan masyarakat sekitar.</p>',
                'kategori_id' => 4, 'user_id' => 1, 'tipe' => 'kegiatan', 'status' => 'published',
                'tanggal_kegiatan' => '2025-08-17', 'lokasi' => 'Pekanbaru, Riau',
                'thumbnail' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=800',
            ],
            [
                'judul' => 'Penggalangan Dana untuk Korban Bencana Banjir',
                'konten' => '<p>Merespons bencana banjir yang melanda beberapa kabupaten di Riau, Yayasan Seribu Satu Cita segera membuka posko penggalangan dana darurat untuk membantu korban bencana.</p><p>Dana yang terkumpul akan digunakan untuk menyediakan kebutuhan darurat seperti makanan, air bersih, obat-obatan, dan tempat penampungan sementara bagi warga terdampak.</p>',
                'kategori_id' => 2, 'user_id' => 1, 'tipe' => 'berita', 'status' => 'published',
                'thumbnail' => 'https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?q=80&w=800',
            ],
            [
                'judul' => 'Pemeriksaan Kesehatan Gratis untuk Lansia',
                'konten' => '<p>Yayasan Seribu Satu Cita bekerja sama dengan Puskesmas setempat mengadakan pemeriksaan kesehatan gratis khusus untuk warga lansia di Kelurahan Sail, Pekanbaru.</p><p>Pemeriksaan meliputi cek tekanan darah, gula darah, kolesterol, dan konsultasi dengan dokter umum. Sebanyak 120 lansia mengikuti kegiatan ini.</p>',
                'kategori_id' => 5, 'user_id' => 2, 'tipe' => 'kegiatan', 'status' => 'published',
                'tanggal_kegiatan' => '2025-07-20', 'lokasi' => 'Pekanbaru, Riau',
                'thumbnail' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?q=80&w=800',
            ],
            [
                'judul' => 'Yayasan Seribu Satu Cita Raih Penghargaan Organisasi Terbaik',
                'konten' => '<p>Yayasan Seribu Satu Cita meraih penghargaan sebagai Organisasi Sosial Terbaik tingkat Provinsi Riau tahun 2025. Penghargaan ini diberikan oleh Gubernur Riau atas kontribusi luar biasa dalam bidang pendidikan dan pemberdayaan masyarakat.</p><p>Penghargaan ini menjadi motivasi bagi seluruh anggota yayasan untuk terus meningkatkan kualitas program dan layanan kepada masyarakat.</p>',
                'kategori_id' => 2, 'user_id' => 1, 'tipe' => 'berita', 'status' => 'published',
                'thumbnail' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=800',
            ],
            [
                'judul' => 'Program Literasi Digital untuk Siswa SD dan SMP',
                'konten' => '<p>Menyikapi pentingnya literasi digital di era modern, Yayasan Seribu Satu Cita meluncurkan program Literasi Digital untuk siswa SD dan SMP di Pekanbaru.</p><p>Program ini mengajarkan penggunaan komputer dasar, keamanan internet, dan etika bermedia sosial. Program ini akan berjalan selama 6 bulan dengan target 500 siswa.</p>',
                'kategori_id' => 1, 'user_id' => 2, 'tipe' => 'berita', 'status' => 'published',
                'thumbnail' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?q=80&w=800',
            ],
            [
                'judul' => 'Bakti Sosial Ramadan: Berbagi Kebahagiaan',
                'konten' => '<p>Menyambut bulan suci Ramadan, Yayasan Seribu Satu Cita menyelenggarakan bakti sosial berupa pembagian paket Ramadan kepada 200 keluarga dhuafa di Pekanbaru dan sekitarnya.</p><p>Paket Ramadan berisi sembako, sarung, mukena, dan Al-Quran. Kegiatan ini juga diisi dengan buka puasa bersama anak yatim.</p>',
                'kategori_id' => 2, 'user_id' => 1, 'tipe' => 'kegiatan', 'status' => 'published',
                'tanggal_kegiatan' => '2025-03-15', 'lokasi' => 'Pekanbaru, Riau',
                'thumbnail' => 'https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?q=80&w=800',
            ],
            [
                'judul' => 'Pelatihan Keterampilan Menjahit untuk Ibu Rumah Tangga',
                'konten' => '<p>Dalam upaya pemberdayaan ekonomi keluarga, yayasan mengadakan pelatihan keterampilan menjahit gratis untuk ibu rumah tangga di Kecamatan Tampan, Pekanbaru.</p><p>Pelatihan ini berlangsung selama 3 bulan dan diikuti oleh 25 peserta. Para peserta mendapatkan peralatan menjahit gratis setelah menyelesaikan pelatihan.</p>',
                'kategori_id' => 3, 'user_id' => 2, 'tipe' => 'berita', 'status' => 'published',
                'thumbnail' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=800',
            ],
            [
                'judul' => 'Kampanye Kebersihan Lingkungan Sekolah',
                'konten' => '<p>Yayasan Seribu Satu Cita melaksanakan kampanye kebersihan lingkungan sekolah di 10 SD di Pekanbaru. Kegiatan ini meliputi pelatihan memilah sampah, pembuatan kompos, dan penghijauan lingkungan sekolah.</p>',
                'kategori_id' => 4, 'user_id' => 1, 'tipe' => 'kegiatan', 'status' => 'published',
                'tanggal_kegiatan' => '2025-06-05', 'lokasi' => 'Pekanbaru, Riau',
                'thumbnail' => 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=800',
            ],
            [
                'judul' => 'Donor Darah Massal Peringati Hari Kesehatan Nasional',
                'konten' => '<p>Memperingati Hari Kesehatan Nasional, Yayasan Seribu Satu Cita bekerja sama dengan PMI Kota Pekanbaru mengadakan kegiatan donor darah massal yang diikuti oleh 150 pendonor.</p>',
                'kategori_id' => 5, 'user_id' => 2, 'tipe' => 'kegiatan', 'status' => 'published',
                'tanggal_kegiatan' => '2025-11-12', 'lokasi' => 'Pekanbaru, Riau',
                'thumbnail' => 'https://images.unsplash.com/photo-1615461066841-6116e61058f4?q=80&w=800',
            ],
            [
                'judul' => 'Laporan Tahunan 2024: Capaian dan Rencana Kerja',
                'konten' => '<p>Yayasan Seribu Satu Cita merilis laporan tahunan 2024 yang mencatat berbagai pencapaian signifikan. Pada tahun 2024, yayasan berhasil menjangkau lebih dari 3000 penerima manfaat melalui berbagai program.</p>',
                'kategori_id' => 2, 'user_id' => 1, 'tipe' => 'berita', 'status' => 'published',
                'thumbnail' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=800',
            ],
            [
                'judul' => 'Rencana Program 2026 (Draft)',
                'konten' => '<p>Draft rencana program tahun 2026 sedang dalam tahap penyusunan. Beberapa program unggulan yang direncanakan meliputi perluasan beasiswa, program wirausaha muda, dan klinik kesehatan keliling.</p>',
                'kategori_id' => 2, 'user_id' => 1, 'tipe' => 'berita', 'status' => 'draft',
                'thumbnail' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?q=80&w=800',
            ],
        ];

        foreach ($berita as $b) {
            $data = array_merge($b, [
                'slug' => Str::slug($b['judul']),
                'excerpt' => Str::limit(strip_tags($b['konten']), 160),
                'views' => rand(10, 500),
            ]);

            if (!isset($data['tanggal_kegiatan'])) {
                $data['tanggal_kegiatan'] = null;
            }
            if (!isset($data['lokasi'])) {
                $data['lokasi'] = null;
            }

            Berita::create($data);
        }
    }
}
