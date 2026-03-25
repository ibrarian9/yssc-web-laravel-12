-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 25 Mar 2026 pada 08.12
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yssc-web-Laravel`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `log_name` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `subject_type` varchar(255) DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `causer_type` varchar(255) DEFAULT NULL,
  `causer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `batch_uuid` char(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `activity_log`
--

INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(1, 'default', 'Berita deleted', 'App\\Models\\Berita', 'deleted', 16, 'App\\Models\\User', 1, '{\"old\":{\"judul\":\"bagus\",\"status\":\"published\",\"tipe\":\"berita\",\"is_approved\":true}}', NULL, '2026-03-23 22:19:32', '2026-03-23 22:19:32'),
(2, 'default', 'Berita deleted', 'App\\Models\\Berita', 'deleted', 16, 'App\\Models\\User', 1, '{\"old\":{\"judul\":\"bagus\",\"status\":\"published\",\"tipe\":\"berita\",\"is_approved\":true}}', NULL, '2026-03-23 22:37:34', '2026-03-23 22:37:34'),
(3, 'default', 'Program Donasi updated', 'App\\Models\\ProgramDonasi', 'updated', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"status\":\"draft\"},\"old\":{\"status\":\"aktif\"}}', NULL, '2026-03-23 23:41:49', '2026-03-23 23:41:49'),
(4, 'default', 'Program Donasi updated', 'App\\Models\\ProgramDonasi', 'updated', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"status\":\"aktif\"},\"old\":{\"status\":\"draft\"}}', NULL, '2026-03-23 23:42:01', '2026-03-23 23:42:01'),
(5, 'default', 'Program Donasi updated', 'App\\Models\\ProgramDonasi', 'updated', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"target_nominal\":\"50000000.00\"},\"old\":{\"target_nominal\":\"500000000.00\"}}', NULL, '2026-03-23 23:49:10', '2026-03-23 23:49:10'),
(6, 'default', 'Program Donasi updated', 'App\\Models\\ProgramDonasi', 'updated', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"target_nominal\":\"5000000.00\"},\"old\":{\"target_nominal\":\"50000000.00\"}}', NULL, '2026-03-23 23:49:15', '2026-03-23 23:49:15'),
(7, 'default', 'Program Donasi updated', 'App\\Models\\ProgramDonasi', 'updated', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"target_nominal\":\"50000000.00\"},\"old\":{\"target_nominal\":\"5000000.00\"}}', NULL, '2026-03-24 00:01:34', '2026-03-24 00:01:34'),
(8, 'default', 'Program Donasi updated', 'App\\Models\\ProgramDonasi', 'updated', 1, NULL, NULL, '{\"attributes\":[],\"old\":[]}', NULL, '2026-03-24 00:14:38', '2026-03-24 00:14:38'),
(9, 'default', 'Program Donasi updated', 'App\\Models\\ProgramDonasi', 'updated', 2, NULL, NULL, '{\"attributes\":[],\"old\":[]}', NULL, '2026-03-24 00:14:38', '2026-03-24 00:14:38'),
(10, 'default', 'Program Donasi updated', 'App\\Models\\ProgramDonasi', 'updated', 3, NULL, NULL, '{\"attributes\":[],\"old\":[]}', NULL, '2026-03-24 00:14:38', '2026-03-24 00:14:38'),
(11, 'default', 'Program Donasi updated', 'App\\Models\\ProgramDonasi', 'updated', 4, NULL, NULL, '{\"attributes\":[],\"old\":[]}', NULL, '2026-03-24 00:14:38', '2026-03-24 00:14:38'),
(12, 'default', 'Berita updated', 'App\\Models\\Berita', 'updated', 10, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2026-03-24 00:16:01', '2026-03-24 00:16:01'),
(13, 'default', 'Berita updated', 'App\\Models\\Berita', 'updated', 1, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2026-03-24 00:16:04', '2026-03-24 00:16:04'),
(14, 'default', 'Mitra \"PT Testing Mitra Baru\" created', 'App\\Models\\Mitra', 'created', 2, NULL, NULL, '{\"attributes\":{\"nama_perusahaan\":\"PT Testing Mitra Baru\",\"status\":\"pending\",\"jenis_mitra\":\"perusahaan\"}}', NULL, '2026-03-24 19:29:02', '2026-03-24 19:29:02'),
(15, 'default', 'User \"PT Testing Mitra Baru\" created', 'App\\Models\\User', 'created', 12, NULL, NULL, '{\"attributes\":{\"name\":\"PT Testing Mitra Baru\",\"email\":\"testmitra@example.com\",\"role\":\"mitra\",\"is_active\":true}}', NULL, '2026-03-24 20:13:36', '2026-03-24 20:13:36'),
(16, 'default', 'Mitra \"PT Testing Mitra Baru\" updated', 'App\\Models\\Mitra', 'updated', 2, NULL, NULL, '{\"attributes\":{\"status\":\"approved\"},\"old\":{\"status\":\"pending\"}}', NULL, '2026-03-24 20:13:36', '2026-03-24 20:13:36'),
(17, 'default', 'Mitra \"PT Testing Mitra Baru\" updated', 'App\\Models\\Mitra', 'updated', 2, 'App\\Models\\User', 1, '{\"attributes\":{\"status\":\"rejected\"},\"old\":{\"status\":\"approved\"}}', NULL, '2026-03-24 20:54:41', '2026-03-24 20:54:41'),
(18, 'default', 'User \"PT Testing Mitra Baru\" updated', 'App\\Models\\User', 'updated', 12, 'App\\Models\\User', 1, '{\"attributes\":{\"is_active\":false},\"old\":{\"is_active\":true}}', NULL, '2026-03-24 20:54:41', '2026-03-24 20:54:41'),
(19, 'default', 'Mitra \"PT Testing Mitra Baru\" updated', 'App\\Models\\Mitra', 'updated', 2, 'App\\Models\\User', 1, '{\"attributes\":{\"status\":\"approved\"},\"old\":{\"status\":\"rejected\"}}', NULL, '2026-03-24 21:14:29', '2026-03-24 21:14:29'),
(20, 'default', 'User \"PT Testing Mitra Baru\" updated', 'App\\Models\\User', 'updated', 12, 'App\\Models\\User', 1, '{\"attributes\":{\"is_active\":true},\"old\":{\"is_active\":false}}', NULL, '2026-03-24 21:14:29', '2026-03-24 21:14:29'),
(21, 'default', 'Perizinan \"Kerjasama Program Edukasi Anak\" created', 'App\\Models\\Perizinan', 'created', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"judul_permohonan\":\"Kerjasama Program Edukasi Anak\",\"status\":\"pending\",\"nama_pemohon\":\"Budi Santoso\"}}', NULL, '2026-03-24 21:47:40', '2026-03-24 21:47:40'),
(22, 'default', 'Perizinan \"Kerjasama Program Edukasi Anak\" updated', 'App\\Models\\Perizinan', 'updated', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"status\":\"approved\"},\"old\":{\"status\":\"pending\"}}', NULL, '2026-03-24 22:07:13', '2026-03-24 22:07:13'),
(23, 'default', 'Perizinan \"Kerjasama Program Edukasi Anak\" created', 'App\\Models\\Perizinan', 'created', 2, 'App\\Models\\User', 1, '{\"attributes\":{\"judul_permohonan\":\"Kerjasama Program Edukasi Anak\",\"status\":\"pending\",\"nama_pemohon\":\"test\"}}', NULL, '2026-03-24 22:08:08', '2026-03-24 22:08:08'),
(24, 'default', 'Perizinan \"Izin Kegiatan Bakti Sosial\" created', 'App\\Models\\Perizinan', 'created', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"judul_permohonan\":\"Izin Kegiatan Bakti Sosial\",\"status\":\"pending\",\"nama_pemohon\":\"Ahmad Fauzi\"}}', NULL, '2026-03-24 22:28:01', '2026-03-24 22:28:01'),
(25, 'default', 'Perizinan \"Izin Kegiatan Bakti Sosial\" deleted', 'App\\Models\\Perizinan', 'deleted', 3, 'App\\Models\\User', 1, '{\"old\":{\"judul_permohonan\":\"Izin Kegiatan Bakti Sosial\",\"status\":\"pending\",\"nama_pemohon\":\"Ahmad Fauzi\"}}', NULL, '2026-03-24 22:31:41', '2026-03-24 22:31:41'),
(26, 'default', 'Perizinan \"Kerjasama Program Edukasi Anak\" updated', 'App\\Models\\Perizinan', 'updated', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"status\":\"selesai\"},\"old\":{\"status\":\"approved\"}}', NULL, '2026-03-24 22:43:19', '2026-03-24 22:43:19'),
(27, 'default', 'Berita updated', 'App\\Models\\Berita', 'updated', 2, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2026-03-24 22:58:07', '2026-03-24 22:58:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggota_devisi`
--

CREATE TABLE `anggota_devisi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `divisi_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `periode_mulai` date DEFAULT NULL,
  `periode_selesai` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `anggota_devisi`
--

INSERT INTO `anggota_devisi` (`id`, `divisi_id`, `nama`, `jabatan`, `foto`, `bio`, `linkedin`, `instagram`, `email`, `periode_mulai`, `periode_selesai`, `is_active`, `urutan`, `created_at`, `updated_at`) VALUES
(1, 1, 'Muhammad Rizki', 'Ketua Divisi Humas', NULL, NULL, NULL, NULL, NULL, '2024-01-01', NULL, 1, 1, '2026-03-14 02:00:27', '2026-03-23 22:57:14'),
(2, 1, 'Anisa Putri', 'Koordinator Media Sosial', NULL, NULL, NULL, NULL, NULL, '2024-01-01', NULL, 1, 2, '2026-03-14 02:00:27', '2026-03-14 02:00:27'),
(3, 1, 'Fajar Nugroho', 'Staf Desain Grafis', NULL, NULL, NULL, NULL, NULL, '2024-01-01', NULL, 1, 3, '2026-03-14 02:00:27', '2026-03-14 02:00:27'),
(4, 1, 'Lina Marlina', 'Staf Hubungan Media', NULL, NULL, NULL, NULL, NULL, '2024-01-01', NULL, 1, 4, '2026-03-14 02:00:27', '2026-03-14 02:00:27'),
(5, 2, 'Rendi Pratama', 'Ketua Divisi Program', NULL, NULL, NULL, NULL, NULL, '2024-01-01', NULL, 1, 1, '2026-03-14 02:00:27', '2026-03-14 02:00:27'),
(6, 2, 'Nurul Hidayah', 'Koordinator Program Edukasi', NULL, NULL, NULL, NULL, NULL, '2024-01-01', NULL, 1, 2, '2026-03-14 02:00:27', '2026-03-14 02:00:27'),
(7, 2, 'Hendra Saputra', 'Koordinator Program Sosial', NULL, NULL, NULL, NULL, NULL, '2024-01-01', NULL, 1, 3, '2026-03-14 02:00:27', '2026-03-14 02:00:27'),
(8, 2, 'Yuni Astuti', 'Staf Evaluasi Program', NULL, NULL, NULL, NULL, NULL, '2024-01-01', NULL, 1, 4, '2026-03-14 02:00:27', '2026-03-14 02:00:27'),
(9, 2, 'Dimas Aditya', 'Staf Lapangan', NULL, NULL, NULL, NULL, NULL, '2024-01-01', NULL, 1, 5, '2026-03-14 02:00:27', '2026-03-14 02:00:27'),
(10, 3, 'Siska Dewi', 'Ketua Divisi Keuangan', NULL, NULL, NULL, NULL, NULL, '2024-01-01', NULL, 1, 1, '2026-03-14 02:00:27', '2026-03-14 02:00:27'),
(11, 3, 'Andi Wijaya', 'Staf Pembukuan', NULL, NULL, NULL, NULL, NULL, '2024-01-01', NULL, 1, 2, '2026-03-14 02:00:27', '2026-03-14 02:00:27'),
(12, 3, 'Ratna Sari', 'Staf Administrasi', NULL, NULL, NULL, NULL, NULL, '2024-01-01', NULL, 1, 3, '2026-03-14 02:00:27', '2026-03-14 02:00:27'),
(13, 4, 'Bayu Pratama', 'Ketua Divisi IT', NULL, NULL, NULL, NULL, NULL, '2024-01-01', NULL, 1, 1, '2026-03-14 02:00:27', '2026-03-14 02:00:27'),
(14, 4, 'Eka Rahmawati', 'Web Developer', NULL, NULL, NULL, NULL, NULL, '2024-01-01', NULL, 1, 2, '2026-03-14 02:00:27', '2026-03-14 02:00:27'),
(15, 4, 'Gilang Ramadhan', 'System Administrator', NULL, NULL, NULL, NULL, NULL, '2024-01-01', NULL, 1, 3, '2026-03-14 02:00:27', '2026-03-14 02:00:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `berita`
--

CREATE TABLE `berita` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `konten` longtext NOT NULL,
  `excerpt` varchar(300) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `kategori_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `tipe` varchar(255) NOT NULL DEFAULT 'berita',
  `status` varchar(255) NOT NULL DEFAULT 'draft',
  `is_approved` tinyint(1) NOT NULL DEFAULT 1,
  `approved_at` timestamp NULL DEFAULT NULL,
  `tanggal_kegiatan` date DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `views` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `berita`
--

INSERT INTO `berita` (`id`, `judul`, `slug`, `konten`, `excerpt`, `thumbnail`, `kategori_id`, `user_id`, `tipe`, `status`, `is_approved`, `approved_at`, `tanggal_kegiatan`, `lokasi`, `views`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Aksi Cinta Anak Negeri 2025 Sukses Digelar', 'aksi-cinta-anak-negeri-2025-sukses-digelar', '<p>Program Aksi Cinta Anak Negeri 2025 telah berhasil dilaksanakan di 5 kota besar di Indonesia. Kegiatan ini melibatkan lebih dari 200 relawan yang memberikan pendidikan gratis kepada anak-anak dari keluarga kurang mampu.</p><p>Dalam program ini, para relawan mengajarkan berbagai mata pelajaran termasuk Matematika, Bahasa Inggris, dan keterampilan digital. Selain itu, juga diadakan kegiatan kreatif seperti menggambar, musik, dan olahraga.</p><p>Program ini mendapatkan dukungan penuh dari Dinas Pendidikan setempat dan akan dilanjutkan pada tahun berikutnya dengan target yang lebih besar.</p>', 'Program Aksi Cinta Anak Negeri 2025 telah berhasil dilaksanakan di 5 kota besar di Indonesia. Kegiatan ini melibatkan lebih dari 200 relawan yang memberikan pen...', 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=800', 1, 1, 'kegiatan', 'published', 1, NULL, '2025-11-07', 'Pekanbaru, Riau', 419, '2026-03-14 02:00:27', '2026-03-24 00:16:04', NULL),
(2, 'Bantuan Keberlangsungan Hidup untuk Keluarga Prasejahtera', 'bantuan-keberlangsungan-hidup-untuk-keluarga-prasejahtera', '<p>Yayasan Seribu Satu Cita kembali menyalurkan bantuan berupa paket sembako dan kebutuhan pokok kepada 150 keluarga prasejahtera di wilayah Kampar, Riau.</p><p>Bantuan ini disalurkan langsung oleh para relawan yayasan yang turun ke lapangan untuk memastikan bantuan tepat sasaran. Selain sembako, yayasan juga memberikan konsultasi kesehatan gratis bekerja sama dengan tenaga medis lokal.</p>', 'Yayasan Seribu Satu Cita kembali menyalurkan bantuan berupa paket sembako dan kebutuhan pokok kepada 150 keluarga prasejahtera di wilayah Kampar, Riau.Bantuan i...', 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=800', 2, 1, 'berita', 'published', 1, NULL, NULL, NULL, 354, '2026-03-14 02:00:27', '2026-03-24 22:58:07', NULL),
(3, 'Beasiswa Permata Cita 2025 Dibuka untuk Mahasiswa', 'beasiswa-permata-cita-2025-dibuka-untuk-mahasiswa', '<p>Yayasan Seribu Satu Cita membuka pendaftaran Beasiswa Permata Cita 2025 untuk mahasiswa berprestasi dari keluarga kurang mampu. Beasiswa ini mencakup biaya kuliah, uang saku bulanan, dan pendampingan akademik.</p><p>Tahun ini, yayasan menargetkan 50 penerima beasiswa dari berbagai perguruan tinggi di Indonesia. Pendaftaran dibuka mulai 1 Mei hingga 30 Juni 2025.</p>', 'Yayasan Seribu Satu Cita membuka pendaftaran Beasiswa Permata Cita 2025 untuk mahasiswa berprestasi dari keluarga kurang mampu. Beasiswa ini mencakup biaya kuli...', 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=800', 3, 2, 'berita', 'published', 1, NULL, NULL, NULL, 214, '2026-03-14 02:00:27', '2026-03-14 02:00:27', NULL),
(4, 'Workshop Digital Marketing untuk UMKM Desa', 'workshop-digital-marketing-untuk-umkm-desa', '<p>Dalam rangka mendukung pemberdayaan ekonomi masyarakat desa, Yayasan Seribu Satu Cita menyelenggarakan Workshop Digital Marketing untuk pelaku UMKM di Kabupaten Siak, Riau.</p><p>Workshop ini diikuti oleh 40 peserta dari berbagai desa yang belajar tentang pemasaran digital, penggunaan media sosial untuk bisnis, dan fotografi produk. Para peserta juga diajarkan cara membuat toko online.</p>', 'Dalam rangka mendukung pemberdayaan ekonomi masyarakat desa, Yayasan Seribu Satu Cita menyelenggarakan Workshop Digital Marketing untuk pelaku UMKM di Kabupaten...', 'https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=800', 1, 2, 'kegiatan', 'published', 1, NULL, '2025-09-15', 'Siak, Riau', 300, '2026-03-14 02:00:27', '2026-03-14 02:38:32', NULL),
(5, 'Penanaman 1000 Pohon di Bantaran Sungai Siak', 'penanaman-1000-pohon-di-bantaran-sungai-siak', '<p>Yayasan Seribu Satu Cita bersama masyarakat setempat dan mahasiswa dari berbagai universitas melakukan penanaman 1000 pohon di bantaran Sungai Siak sebagai upaya pelestarian lingkungan.</p><p>Kegiatan yang diikuti oleh 300 relawan ini bertujuan untuk mengurangi erosi bantaran sungai dan meningkatkan kualitas air sungai yang menjadi sumber kehidupan masyarakat sekitar.</p>', 'Yayasan Seribu Satu Cita bersama masyarakat setempat dan mahasiswa dari berbagai universitas melakukan penanaman 1000 pohon di bantaran Sungai Siak sebagai upay...', 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=800', 4, 1, 'kegiatan', 'published', 1, NULL, '2025-08-17', 'Pekanbaru, Riau', 245, '2026-03-14 02:00:27', '2026-03-14 02:00:27', NULL),
(6, 'Penggalangan Dana untuk Korban Bencana Banjir', 'penggalangan-dana-untuk-korban-bencana-banjir', '<p>Merespons bencana banjir yang melanda beberapa kabupaten di Riau, Yayasan Seribu Satu Cita segera membuka posko penggalangan dana darurat untuk membantu korban bencana.</p><p>Dana yang terkumpul akan digunakan untuk menyediakan kebutuhan darurat seperti makanan, air bersih, obat-obatan, dan tempat penampungan sementara bagi warga terdampak.</p>', 'Merespons bencana banjir yang melanda beberapa kabupaten di Riau, Yayasan Seribu Satu Cita segera membuka posko penggalangan dana darurat untuk membantu korban...', 'https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?q=80&w=800', 2, 1, 'berita', 'published', 1, NULL, NULL, NULL, 12, '2026-03-14 02:00:27', '2026-03-14 02:00:27', NULL),
(7, 'Pemeriksaan Kesehatan Gratis untuk Lansia', 'pemeriksaan-kesehatan-gratis-untuk-lansia', '<p>Yayasan Seribu Satu Cita bekerja sama dengan Puskesmas setempat mengadakan pemeriksaan kesehatan gratis khusus untuk warga lansia di Kelurahan Sail, Pekanbaru.</p><p>Pemeriksaan meliputi cek tekanan darah, gula darah, kolesterol, dan konsultasi dengan dokter umum. Sebanyak 120 lansia mengikuti kegiatan ini.</p>', 'Yayasan Seribu Satu Cita bekerja sama dengan Puskesmas setempat mengadakan pemeriksaan kesehatan gratis khusus untuk warga lansia di Kelurahan Sail, Pekanbaru.P...', 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?q=80&w=800', 5, 2, 'kegiatan', 'published', 1, NULL, '2025-07-20', 'Pekanbaru, Riau', 61, '2026-03-14 02:00:27', '2026-03-14 02:00:27', NULL),
(8, 'Yayasan Seribu Satu Cita Raih Penghargaan Organisasi Terbaik', 'yayasan-seribu-satu-cita-raih-penghargaan-organisasi-terbaik', '<p>Yayasan Seribu Satu Cita meraih penghargaan sebagai Organisasi Sosial Terbaik tingkat Provinsi Riau tahun 2025. Penghargaan ini diberikan oleh Gubernur Riau atas kontribusi luar biasa dalam bidang pendidikan dan pemberdayaan masyarakat.</p><p>Penghargaan ini menjadi motivasi bagi seluruh anggota yayasan untuk terus meningkatkan kualitas program dan layanan kepada masyarakat.</p>', 'Yayasan Seribu Satu Cita meraih penghargaan sebagai Organisasi Sosial Terbaik tingkat Provinsi Riau tahun 2025. Penghargaan ini diberikan oleh Gubernur Riau ata...', 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=800', 2, 1, 'berita', 'published', 1, NULL, NULL, NULL, 248, '2026-03-14 02:00:27', '2026-03-14 02:00:27', NULL),
(9, 'Program Literasi Digital untuk Siswa SD dan SMP', 'program-literasi-digital-untuk-siswa-sd-dan-smp', '<p>Menyikapi pentingnya literasi digital di era modern, Yayasan Seribu Satu Cita meluncurkan program Literasi Digital untuk siswa SD dan SMP di Pekanbaru.</p><p>Program ini mengajarkan penggunaan komputer dasar, keamanan internet, dan etika bermedia sosial. Program ini akan berjalan selama 6 bulan dengan target 500 siswa.</p>', 'Menyikapi pentingnya literasi digital di era modern, Yayasan Seribu Satu Cita meluncurkan program Literasi Digital untuk siswa SD dan SMP di Pekanbaru.Program i...', 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?q=80&w=800', 1, 2, 'berita', 'published', 1, NULL, NULL, NULL, 323, '2026-03-14 02:00:27', '2026-03-14 02:00:27', NULL),
(10, 'Bakti Sosial Ramadan: Berbagi Kebahagiaan', 'bakti-sosial-ramadan-berbagi-kebahagiaan', '<p>Menyambut bulan suci Ramadan, Yayasan Seribu Satu Cita menyelenggarakan bakti sosial berupa pembagian paket Ramadan kepada 200 keluarga dhuafa di Pekanbaru dan sekitarnya.</p><p>Paket Ramadan berisi sembako, sarung, mukena, dan Al-Quran. Kegiatan ini juga diisi dengan buka puasa bersama anak yatim.</p>', 'Menyambut bulan suci Ramadan, Yayasan Seribu Satu Cita menyelenggarakan bakti sosial berupa pembagian paket Ramadan kepada 200 keluarga dhuafa di Pekanbaru dan...', 'https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?q=80&w=800', 2, 1, 'kegiatan', 'published', 1, NULL, '2025-03-15', 'Pekanbaru, Riau', 223, '2026-03-14 02:00:27', '2026-03-24 00:16:01', NULL),
(11, 'Pelatihan Keterampilan Menjahit untuk Ibu Rumah Tangga', 'pelatihan-keterampilan-menjahit-untuk-ibu-rumah-tangga', '<p>Dalam upaya pemberdayaan ekonomi keluarga, yayasan mengadakan pelatihan keterampilan menjahit gratis untuk ibu rumah tangga di Kecamatan Tampan, Pekanbaru.</p><p>Pelatihan ini berlangsung selama 3 bulan dan diikuti oleh 25 peserta. Para peserta mendapatkan peralatan menjahit gratis setelah menyelesaikan pelatihan.</p>', 'Dalam upaya pemberdayaan ekonomi keluarga, yayasan mengadakan pelatihan keterampilan menjahit gratis untuk ibu rumah tangga di Kecamatan Tampan, Pekanbaru.Pelat...', 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=800', 3, 2, 'berita', 'published', 1, NULL, NULL, NULL, 274, '2026-03-14 02:00:27', '2026-03-14 02:00:27', NULL),
(12, 'Kampanye Kebersihan Lingkungan Sekolah', 'kampanye-kebersihan-lingkungan-sekolah', '<p>Yayasan Seribu Satu Cita melaksanakan kampanye kebersihan lingkungan sekolah di 10 SD di Pekanbaru. Kegiatan ini meliputi pelatihan memilah sampah, pembuatan kompos, dan penghijauan lingkungan sekolah.</p>', 'Yayasan Seribu Satu Cita melaksanakan kampanye kebersihan lingkungan sekolah di 10 SD di Pekanbaru. Kegiatan ini meliputi pelatihan memilah sampah, pembuatan ko...', 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=800', 4, 1, 'kegiatan', 'published', 1, NULL, '2025-06-05', 'Pekanbaru, Riau', 406, '2026-03-14 02:00:27', '2026-03-14 02:00:27', NULL),
(13, 'Donor Darah Massal Peringati Hari Kesehatan Nasional', 'donor-darah-massal-peringati-hari-kesehatan-nasional', '<p>Memperingati Hari Kesehatan Nasional, Yayasan Seribu Satu Cita bekerja sama dengan PMI Kota Pekanbaru mengadakan kegiatan donor darah massal yang diikuti oleh 150 pendonor.</p>', 'Memperingati Hari Kesehatan Nasional, Yayasan Seribu Satu Cita bekerja sama dengan PMI Kota Pekanbaru mengadakan kegiatan donor darah massal yang diikuti oleh 1...', 'https://images.unsplash.com/photo-1615461066841-6116e61058f4?q=80&w=800', 5, 2, 'kegiatan', 'published', 1, NULL, '2025-11-12', 'Pekanbaru, Riau', 162, '2026-03-14 02:00:27', '2026-03-14 02:00:27', NULL),
(14, 'Laporan Tahunan 2024: Capaian dan Rencana Kerja', 'laporan-tahunan-2024-capaian-dan-rencana-kerja', '<p>Yayasan Seribu Satu Cita merilis laporan tahunan 2024 yang mencatat berbagai pencapaian signifikan. Pada tahun 2024, yayasan berhasil menjangkau lebih dari 3000 penerima manfaat melalui berbagai program.</p>', 'Yayasan Seribu Satu Cita merilis laporan tahunan 2024 yang mencatat berbagai pencapaian signifikan. Pada tahun 2024, yayasan berhasil menjangkau lebih dari 3000...', 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=800', 2, 1, 'berita', 'published', 1, NULL, NULL, NULL, 280, '2026-03-14 02:00:27', '2026-03-14 02:00:27', NULL),
(15, 'Rencana Program 2026 (Draft)', 'rencana-program-2026-draft', '<p>Draft rencana program tahun 2026 sedang dalam tahap penyusunan. Beberapa program unggulan yang direncanakan meliputi perluasan beasiswa, program wirausaha muda, dan klinik kesehatan keliling.</p>', 'Draft rencana program tahun 2026 sedang dalam tahap penyusunan. Beberapa program unggulan yang direncanakan meliputi perluasan beasiswa, program wirausaha muda,...', 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?q=80&w=800', 2, 1, 'berita', 'draft', 1, NULL, NULL, NULL, 475, '2026-03-14 02:00:27', '2026-03-14 02:00:27', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('yayasan-seribu-satu-cita-cache-356a192b7913b04c54574d18c28d46e6395428ab', 'i:1;', 1774408624),
('yayasan-seribu-satu-cita-cache-356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1774408624;', 1774408624),
('yayasan-seribu-satu-cita-cache-5c785c036466adea360111aa28563bfd556b5fba', 'i:1;', 1774409326),
('yayasan-seribu-satu-cita-cache-5c785c036466adea360111aa28563bfd556b5fba:timer', 'i:1774409326;', 1774409326);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `divisi`
--

CREATE TABLE `divisi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `divisi`
--

INSERT INTO `divisi` (`id`, `nama`, `deskripsi`, `urutan`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Hubungan Masyarakat', 'Divisi yang bertanggung jawab atas komunikasi publik, media relations, dan branding organisasi.', 1, 1, '2026-03-14 02:00:27', '2026-03-14 02:00:27'),
(2, 'Program & Kegiatan', 'Divisi yang merancang, mengelola, dan mengevaluasi seluruh program dan kegiatan yayasan.', 2, 1, '2026-03-14 02:00:27', '2026-03-14 02:00:27'),
(3, 'Keuangan & Administrasi', 'Divisi yang mengelola keuangan, pelaporan, dan administrasi organisasi secara transparan.', 3, 1, '2026-03-14 02:00:27', '2026-03-14 02:00:27'),
(4, 'Teknologi Informasi', 'Divisi yang mengelola infrastruktur teknologi, website, dan sistem informasi organisasi.', 4, 1, '2026-03-14 02:00:27', '2026-03-14 02:00:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokumen_legal`
--

CREATE TABLE `dokumen_legal` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nomor` varchar(255) DEFAULT NULL,
  `tanggal_terbit` date DEFAULT NULL,
  `jenis` varchar(255) NOT NULL DEFAULT 'lainnya',
  `file_path` varchar(255) DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `donasi`
--

CREATE TABLE `donasi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `program_donasi_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nama_donatur` varchar(255) NOT NULL,
  `email_donatur` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `nominal` decimal(15,2) NOT NULL,
  `pesan` text DEFAULT NULL,
  `is_anonim` tinyint(1) NOT NULL DEFAULT 0,
  `metode_pembayaran` varchar(255) DEFAULT NULL,
  `status_pembayaran` varchar(255) NOT NULL DEFAULT 'pending',
  `kode_unik` varchar(255) NOT NULL,
  `bukti_transfer` varchar(255) DEFAULT NULL,
  `midtrans_order_id` varchar(255) DEFAULT NULL,
  `midtrans_snap_token` varchar(255) DEFAULT NULL,
  `midtrans_payment_type` varchar(255) DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `donasi`
--

INSERT INTO `donasi` (`id`, `program_donasi_id`, `user_id`, `nama_donatur`, `email_donatur`, `phone`, `nominal`, `pesan`, `is_anonim`, `metode_pembayaran`, `status_pembayaran`, `kode_unik`, `bukti_transfer`, `midtrans_order_id`, `midtrans_snap_token`, `midtrans_payment_type`, `paid_at`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, 'Ramlah Wati', 'ramlah.wati@example.com', '083977108707', 2000000.00, NULL, 1, 'qris', 'success', 'DON-EXUCIUOL-1773478827', NULL, NULL, NULL, NULL, NULL, '2025-09-16 02:00:27', '2026-03-14 02:00:27'),
(2, 4, NULL, 'Asma Lestari', 'asma.lestari@example.com', '082906397503', 5000000.00, NULL, 0, 'e-wallet', 'success', 'DON-4OVJ2QGZ-1773478827', NULL, NULL, NULL, NULL, NULL, '2026-03-10 02:00:27', '2026-03-14 02:00:27'),
(3, 1, NULL, 'Zainab Putri', 'zainab.putri@example.com', '086181371999', 250000.00, 'Semoga bermanfaat dan berkah selalu.', 0, 'transfer_bank', 'failed', 'DON-ND1JSQCF-1773478827', NULL, NULL, NULL, NULL, NULL, '2026-01-31 02:00:27', '2026-03-14 02:00:27'),
(4, 2, NULL, 'Hamza Rizqi', 'hamza.rizqi@example.com', '083251961897', 2000000.00, NULL, 0, 'transfer_bank', 'success', 'DON-RHLGGDRG-1773478827', NULL, NULL, NULL, NULL, NULL, '2026-03-02 02:00:27', '2026-03-14 02:00:27'),
(5, 1, NULL, 'Aisyah Dewi', 'aisyah.dewi@example.com', '088057720482', 250000.00, NULL, 0, 'e-wallet', 'success', 'DON-VYFYUFMA-1773478827', NULL, NULL, NULL, NULL, NULL, '2025-12-22 02:00:27', '2026-03-14 02:00:27'),
(6, 3, NULL, 'Ismail Putra', 'ismail.putra@example.com', '086926244332', 250000.00, 'Semoga bermanfaat dan berkah selalu.', 0, 'qris', 'failed', 'DON-A6T6WDYL-1773478827', NULL, NULL, NULL, NULL, NULL, '2026-02-25 02:00:27', '2026-03-14 02:00:27'),
(7, 3, 6, 'Asma Lestari', 'asma.lestari@example.com', '087104053713', 150000.00, 'Semoga bermanfaat dan berkah selalu.', 0, 'e-wallet', 'failed', 'DON-HJLAGJ2S-1773478827', NULL, NULL, NULL, NULL, NULL, '2025-10-23 02:00:27', '2026-03-14 02:00:27'),
(8, 2, NULL, 'Aisyah Dewi', 'aisyah.dewi@example.com', '085126644829', 150000.00, 'Semoga bermanfaat dan berkah selalu.', 0, 'transfer_bank', 'success', 'DON-XZNURQVC-1773478827', NULL, NULL, NULL, NULL, NULL, '2025-11-15 02:00:27', '2026-03-14 02:00:27'),
(9, 3, NULL, 'Maryam Sari', 'maryam.sari@example.com', '085183280092', 250000.00, 'Semoga bermanfaat dan berkah selalu.', 0, 'e-wallet', 'pending', 'DON-BKCB03C7-1773478827', NULL, NULL, NULL, NULL, NULL, '2025-11-13 02:00:27', '2026-03-14 02:00:27'),
(10, 2, 5, 'Idris Pratama', 'idris.pratama@example.com', '081651478111', 250000.00, NULL, 0, 'qris', 'success', 'DON-TOVRUJMT-1773478827', NULL, NULL, NULL, NULL, NULL, '2025-12-01 02:00:27', '2026-03-14 02:00:27'),
(11, 1, NULL, 'Yusuf Hakim', 'yusuf.hakim@example.com', '087061265380', 75000.00, 'Semoga bermanfaat dan berkah selalu.', 0, 'e-wallet', 'success', 'DON-Z0TI8FP9-1773478827', NULL, NULL, NULL, NULL, NULL, '2025-10-09 02:00:27', '2026-03-14 02:00:27'),
(12, 1, 8, 'Hafsa Rahma', 'hafsa.rahma@example.com', '086537331070', 25000.00, 'Semoga bermanfaat dan berkah selalu.', 0, 'transfer_bank', 'failed', 'DON-XKARV4KD-1773478827', NULL, NULL, NULL, NULL, NULL, '2026-01-04 02:00:27', '2026-03-14 02:00:27'),
(13, 2, NULL, 'Hafsa Rahma', 'hafsa.rahma@example.com', '082795726543', 1000000.00, 'Semoga bermanfaat dan berkah selalu.', 1, 'transfer_bank', 'success', 'DON-IR7BYNTF-1773478827', NULL, NULL, NULL, NULL, NULL, '2025-11-19 02:00:27', '2026-03-14 02:00:27'),
(14, 3, 6, 'Fatimah Zahra', 'fatimah.zahra@example.com', '081463588786', 50000.00, NULL, 0, 'transfer_bank', 'pending', 'DON-WXX6ILZP-1773478827', NULL, NULL, NULL, NULL, NULL, '2025-11-04 02:00:27', '2026-03-14 02:00:27'),
(15, 3, 8, 'Ruqayyah Indah', 'ruqayyah.indah@example.com', '083089653177', 250000.00, 'Semoga bermanfaat dan berkah selalu.', 0, 'qris', 'success', 'DON-OTAYPAPK-1773478827', NULL, NULL, NULL, NULL, NULL, '2025-12-05 02:00:27', '2026-03-14 02:00:27'),
(16, 3, NULL, 'Idris Pratama', 'idris.pratama@example.com', '087270672301', 50000.00, 'Semoga bermanfaat dan berkah selalu.', 0, 'qris', 'success', 'DON-SFRXVD1Q-1773478827', NULL, NULL, NULL, NULL, NULL, '2026-02-26 02:00:27', '2026-03-14 02:00:27'),
(17, 2, NULL, 'Fatimah Zahra', 'fatimah.zahra@example.com', '088493532561', 50000.00, 'Semoga bermanfaat dan berkah selalu.', 0, 'transfer_bank', 'pending', 'DON-R7DDVVQB-1773478827', NULL, NULL, NULL, NULL, NULL, '2025-10-11 02:00:27', '2026-03-14 02:00:27'),
(18, 4, NULL, 'Ramlah Wati', 'ramlah.wati@example.com', '088606684040', 50000.00, NULL, 0, 'transfer_bank', 'success', 'DON-ASLPSQUZ-1773478827', NULL, NULL, NULL, NULL, NULL, '2025-10-20 02:00:27', '2026-03-14 02:00:27'),
(19, 4, NULL, 'Hafsa Rahma', 'hafsa.rahma@example.com', '089930296913', 750000.00, 'Semoga bermanfaat dan berkah selalu.', 0, 'transfer_bank', 'success', 'DON-3EFREXMV-1773478827', NULL, NULL, NULL, NULL, NULL, '2026-01-04 02:00:27', '2026-03-14 02:00:27'),
(20, 3, 8, 'Maryam Sari', 'maryam.sari@example.com', '085168580459', 50000.00, 'Semoga bermanfaat dan berkah selalu.', 0, 'qris', 'success', 'DON-CO3VSSSU-1773478827', NULL, NULL, NULL, NULL, NULL, '2025-12-22 02:00:27', '2026-03-14 02:00:27'),
(21, 1, 7, 'Maryam Sari', 'maryam.sari@example.com', '088933631049', 50000.00, 'Semoga bermanfaat dan berkah selalu.', 0, 'qris', 'failed', 'DON-KFIENG7D-1773478827', NULL, NULL, NULL, NULL, NULL, '2026-01-12 02:00:27', '2026-03-14 02:00:27'),
(22, 2, 4, 'Idris Pratama', 'idris.pratama@example.com', '088555530520', 50000.00, 'Semoga bermanfaat dan berkah selalu.', 1, 'transfer_bank', 'success', 'DON-QKFYEBVV-1773478827', NULL, NULL, NULL, NULL, NULL, '2026-02-09 02:00:27', '2026-03-14 02:00:27'),
(23, 2, NULL, 'Ramlah Wati', 'ramlah.wati@example.com', '083879294201', 75000.00, NULL, 0, 'e-wallet', 'success', 'DON-NPQ8VS9S-1773478827', NULL, NULL, NULL, NULL, NULL, '2025-10-27 02:00:27', '2026-03-14 02:00:27'),
(24, 4, NULL, 'Asma Lestari', 'asma.lestari@example.com', '087792631579', 25000.00, NULL, 0, 'qris', 'success', 'DON-X6O5XYDX-1773478827', NULL, NULL, NULL, NULL, NULL, '2026-01-13 02:00:27', '2026-03-14 02:00:27'),
(25, 4, NULL, 'Hasan Basri', 'hasan.basri@example.com', '088629606250', 5000000.00, 'Semoga bermanfaat dan berkah selalu.', 0, 'e-wallet', 'success', 'DON-9Y5UL3BM-1773478827', NULL, NULL, NULL, NULL, NULL, '2025-11-30 02:00:27', '2026-03-14 02:00:27'),
(26, 2, 7, 'Maryam Sari', 'maryam.sari@example.com', '089606297502', 2000000.00, 'Semoga bermanfaat dan berkah selalu.', 0, 'transfer_bank', 'success', 'DON-GZAJXN3U-1773478827', NULL, NULL, NULL, NULL, NULL, '2025-10-31 02:00:27', '2026-03-14 02:00:27'),
(27, 3, NULL, 'Hamza Rizqi', 'hamza.rizqi@example.com', '085331387260', 2000000.00, NULL, 0, 'e-wallet', 'failed', 'DON-SUMBDOVG-1773478827', NULL, NULL, NULL, NULL, NULL, '2026-01-04 02:00:27', '2026-03-14 02:00:27'),
(28, 2, NULL, 'Hamza Rizqi', 'hamza.rizqi@example.com', '081093449776', 2000000.00, 'Semoga bermanfaat dan berkah selalu.', 0, 'qris', 'success', 'DON-5SJW3XEV-1773478827', NULL, NULL, NULL, NULL, NULL, '2025-11-29 02:00:27', '2026-03-14 02:00:27'),
(29, 4, NULL, 'Asma Lestari', 'asma.lestari@example.com', '081232050579', 25000.00, NULL, 0, 'transfer_bank', 'failed', 'DON-PT9BVJEG-1773478827', NULL, NULL, NULL, NULL, NULL, '2026-03-10 02:00:27', '2026-03-14 02:00:27'),
(30, 1, NULL, 'Asma Lestari', 'asma.lestari@example.com', '087385652530', 250000.00, 'Semoga bermanfaat dan berkah selalu.', 0, 'transfer_bank', 'success', 'DON-0UZLUM3D-1773478827', NULL, NULL, NULL, NULL, NULL, '2025-10-22 02:00:27', '2026-03-14 02:00:27'),
(31, 3, 7, 'Sulaiman Akbar', 'sulaiman.akbar@example.com', '085222924874', 500000.00, NULL, 0, 'e-wallet', 'success', 'DON-Y49F2LKL-1773478827', NULL, NULL, NULL, NULL, NULL, '2025-12-14 02:00:27', '2026-03-14 02:00:27'),
(32, 1, 5, 'Hafsa Rahma', 'hafsa.rahma@example.com', '084858123558', 5000000.00, 'Semoga bermanfaat dan berkah selalu.', 0, 'e-wallet', 'success', 'DON-I1VHXE5T-1773478827', NULL, NULL, NULL, NULL, NULL, '2026-02-15 02:00:27', '2026-03-14 02:00:27'),
(33, 3, 4, 'Ismail Putra', 'ismail.putra@example.com', '086876060712', 1000000.00, NULL, 0, 'transfer_bank', 'pending', 'DON-G2UNFPUV-1773478827', NULL, NULL, NULL, NULL, NULL, '2026-02-10 02:00:27', '2026-03-14 02:00:27'),
(34, 2, 8, 'Sarah Amira', 'sarah.amira@example.com', '088461148011', 500000.00, NULL, 0, 'transfer_bank', 'pending', 'DON-EMOXDHWY-1773478827', NULL, NULL, NULL, NULL, NULL, '2026-02-24 02:00:27', '2026-03-14 02:00:27'),
(35, 4, 4, 'Umar Faruq', 'umar.faruq@example.com', '087626696007', 2000000.00, NULL, 0, 'transfer_bank', 'success', 'DON-A4UZHYC2-1773478827', NULL, NULL, NULL, NULL, NULL, '2026-02-10 02:00:27', '2026-03-14 02:00:27'),
(36, 2, 5, 'Ali Imran', 'ali.imran@example.com', '081648938108', 1000000.00, 'Semoga bermanfaat dan berkah selalu.', 0, 'e-wallet', 'pending', 'DON-Q3KDWZQL-1773478827', NULL, NULL, NULL, NULL, NULL, '2025-12-19 02:00:27', '2026-03-14 02:00:27'),
(37, 1, NULL, 'Umar Faruq', 'umar.faruq@example.com', '086912370732', 750000.00, 'Semoga bermanfaat dan berkah selalu.', 0, 'transfer_bank', 'success', 'DON-X5X2EDEP-1773478827', NULL, NULL, NULL, NULL, NULL, '2026-03-09 02:00:27', '2026-03-14 02:00:27'),
(38, 1, 5, 'Ruqayyah Indah', 'ruqayyah.indah@example.com', '086657592295', 200000.00, NULL, 0, 'qris', 'success', 'DON-E8FMAJJN-1773478827', NULL, NULL, NULL, NULL, NULL, '2025-11-18 02:00:27', '2026-03-14 02:00:27'),
(39, 2, 8, 'Maryam Sari', 'maryam.sari@example.com', '081133516102', 25000.00, 'Semoga bermanfaat dan berkah selalu.', 0, 'qris', 'success', 'DON-R4UTXJKP-1773478827', NULL, NULL, NULL, NULL, NULL, '2025-11-10 02:00:27', '2026-03-14 02:00:27'),
(40, 1, NULL, 'Khadijah Nur', 'khadijah.nur@example.com', '084866888612', 1000000.00, 'Semoga bermanfaat dan berkah selalu.', 1, 'e-wallet', 'success', 'DON-QPY3VXW2-1773478827', NULL, NULL, NULL, NULL, NULL, '2026-02-02 02:00:27', '2026-03-14 02:00:27'),
(41, 1, NULL, 'Sulaiman Akbar', 'sulaiman.akbar@example.com', '087637145078', 500000.00, NULL, 0, 'transfer_bank', 'success', 'DON-C8GKUFMT-1773478827', NULL, NULL, NULL, NULL, NULL, '2026-01-20 02:00:27', '2026-03-14 02:00:27'),
(42, 4, 6, 'Sulaiman Akbar', 'sulaiman.akbar@example.com', '081576521903', 5000000.00, 'Semoga bermanfaat dan berkah selalu.', 1, 'qris', 'success', 'DON-K25KWKPZ-1773478827', NULL, NULL, NULL, NULL, NULL, '2025-11-09 02:00:27', '2026-03-14 02:00:27'),
(43, 3, 6, 'Ali Imran', 'ali.imran@example.com', '085175908385', 500000.00, NULL, 0, 'e-wallet', 'pending', 'DON-7DILG22G-1773478827', NULL, NULL, NULL, NULL, NULL, '2025-11-23 02:00:27', '2026-03-14 02:00:27'),
(44, 4, 6, 'Yusuf Hakim', 'yusuf.hakim@example.com', '087421752584', 50000.00, 'Semoga bermanfaat dan berkah selalu.', 0, 'transfer_bank', 'success', 'DON-PUFOBY7I-1773478827', NULL, NULL, NULL, NULL, NULL, '2026-01-28 02:00:27', '2026-03-14 02:00:27'),
(45, 3, NULL, 'Ismail Putra', 'ismail.putra@example.com', '089237177566', 5000000.00, NULL, 0, 'qris', 'success', 'DON-LPFH5WVQ-1773478827', NULL, NULL, NULL, NULL, NULL, '2026-03-11 02:00:27', '2026-03-14 02:00:27'),
(46, 4, 7, 'Ali Imran', 'ali.imran@example.com', '086339307204', 250000.00, 'Semoga bermanfaat dan berkah selalu.', 0, 'e-wallet', 'success', 'DON-APHSWBSQ-1773478827', NULL, NULL, NULL, NULL, NULL, '2026-02-13 02:00:27', '2026-03-14 02:00:27'),
(47, 3, 6, 'Hafsa Rahma', 'hafsa.rahma@example.com', '089331921196', 250000.00, 'Semoga bermanfaat dan berkah selalu.', 0, 'e-wallet', 'success', 'DON-CBSCT2SQ-1773478827', NULL, NULL, NULL, NULL, NULL, '2026-01-01 02:00:27', '2026-03-14 02:00:27'),
(48, 2, 7, 'Fatimah Zahra', 'fatimah.zahra@example.com', '084038852380', 5000000.00, 'Semoga bermanfaat dan berkah selalu.', 0, 'transfer_bank', 'success', 'DON-ZDPUDJBA-1773478827', NULL, NULL, NULL, NULL, NULL, '2026-01-31 02:00:27', '2026-03-14 02:00:27'),
(49, 1, 4, 'Hafsa Rahma', 'hafsa.rahma@example.com', '084988848908', 100000.00, 'Semoga bermanfaat dan berkah selalu.', 0, 'qris', 'success', 'DON-BFUSJCQ5-1773478827', NULL, NULL, NULL, NULL, NULL, '2026-02-20 02:00:27', '2026-03-14 02:00:27'),
(50, 2, NULL, 'Fatimah Zahra', 'fatimah.zahra@example.com', '081796958693', 5000000.00, NULL, 1, 'e-wallet', 'pending', 'DON-NBVP6CDT-1773478827', NULL, NULL, NULL, NULL, NULL, '2026-01-22 02:00:27', '2026-03-14 02:00:27'),
(51, 1, NULL, 'Test Donatur', 'test@example.com', '', 200000.00, '', 0, 'midtrans', 'failed', 'DON-GOF0ZWH0-1773605445', NULL, NULL, NULL, NULL, NULL, '2026-03-15 13:10:45', '2026-03-15 13:10:45'),
(52, 1, NULL, 'Test Donatur', 'test@example.com', '', 200000.00, '', 0, 'midtrans', 'failed', 'DON-9B5JSOV6-1773605608', NULL, NULL, NULL, NULL, NULL, '2026-03-15 13:13:28', '2026-03-15 13:13:28'),
(53, 1, NULL, 'Test Donatur', 'test@example.com', '', 200000.00, '', 0, 'midtrans', 'failed', 'DON-ZZMIUC9R-1773605635', NULL, NULL, NULL, NULL, NULL, '2026-03-15 13:13:55', '2026-03-15 13:13:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `warna` varchar(255) NOT NULL DEFAULT '#14b8a6',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id`, `nama`, `slug`, `warna`, `created_at`, `updated_at`) VALUES
(1, 'Pendidikan', 'pendidikan', '#0d9488', '2026-03-14 02:00:27', '2026-03-14 02:00:27'),
(2, 'Sosial', 'sosial', '#f97316', '2026-03-14 02:00:27', '2026-03-14 02:00:27'),
(3, 'Kepemudaan', 'kepemudaan', '#8b5cf6', '2026-03-14 02:00:27', '2026-03-14 02:00:27'),
(4, 'Lingkungan', 'lingkungan', '#22c55e', '2026-03-14 02:00:27', '2026-03-14 02:00:27'),
(5, 'Kesehatan', 'kesehatan', '#ef4444', '2026-03-14 02:00:27', '2026-03-14 02:00:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_02_000001_create_profile_table', 1),
(5, '2024_01_02_000002_create_dokumen_legal_table', 1),
(6, '2024_01_02_000003_create_divisi_table', 1),
(7, '2024_01_02_000004_create_anggota_devisi_table', 1),
(8, '2024_01_02_000005_create_kategori_table', 1),
(9, '2024_01_02_000006_create_berita_table', 1),
(10, '2024_01_02_000007_create_sliders_table', 1),
(11, '2024_01_02_000008_create_program_donasi_table', 1),
(12, '2024_01_02_000009_create_donasi_table', 1),
(13, '2024_01_02_000010_create_perizinan_table', 1),
(14, '2026_03_15_200524_add_midtrans_columns_to_donasi_table', 2),
(15, '2026_03_15_211131_create_mitra_table', 3),
(16, '2026_03_16_231215_add_mitra_role_fields_to_mitra_table', 4),
(17, '2026_03_16_231423_add_mitra_id_to_program_donasi_table', 5),
(18, '2026_03_24_090000_add_approval_columns_to_berita_and_program_donasi', 6),
(19, '2026_03_24_024450_create_activity_log_table', 7),
(20, '2026_03_24_024451_add_event_column_to_activity_log_table', 7),
(21, '2026_03_24_024452_add_batch_uuid_column_to_activity_log_table', 7),
(22, '2026_03_25_070111_normalize_perizinan_status_values', 8);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mitra`
--

CREATE TABLE `mitra` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `jenis_mitra` varchar(255) NOT NULL,
  `nama_perusahaan` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telepon` varchar(255) NOT NULL,
  `npwp` varchar(255) NOT NULL,
  `dokumen_npwp` varchar(255) NOT NULL,
  `dokumen_legalitas` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `catatan_admin` text DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `mitra`
--

INSERT INTO `mitra` (`id`, `user_id`, `jenis_mitra`, `nama_perusahaan`, `email`, `telepon`, `npwp`, `dokumen_npwp`, `dokumen_legalitas`, `logo`, `deskripsi`, `status`, `catatan_admin`, `approved_at`, `created_at`, `updated_at`) VALUES
(1, 10, 'perusahaan', 'PT Mitra Sejahtera', 'mitra@yssc.com', '081234567890', '12.345.678.9-012.000', 'dummy/npwp.pdf', 'dummy/legalitas.pdf', NULL, NULL, 'approved', NULL, '2026-03-23 21:58:00', '2026-03-23 21:58:00', '2026-03-23 21:58:00'),
(2, 12, 'perusahaan', 'PT Testing Mitra Baru', 'testmitra@example.com', '081234567890', '12.345.678.9-012.345', 'mitra/npwp/HXN664ansRqPBCv1yi8ZdksFRmp1omhfA5ACO4DE.jpg', 'mitra/legalitas/WZoWDoB0c1w0WQK5hIJzrQagSmH7JgFxpCZSU0ee.pdf', NULL, NULL, 'approved', NULL, '2026-03-24 20:13:36', '2026-03-24 19:29:01', '2026-03-24 21:14:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `perizinan`
--

CREATE TABLE `perizinan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nama_pemohon` varchar(255) NOT NULL,
  `email_pemohon` varchar(255) NOT NULL,
  `phone_pemohon` varchar(255) DEFAULT NULL,
  `jenis_izin` varchar(255) NOT NULL DEFAULT 'lainnya',
  `judul_permohonan` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `dokumen_pendukung` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`dokumen_pendukung`)),
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `catatan_admin` text DEFAULT NULL,
  `tanggal_permohonan` date NOT NULL,
  `tanggal_proses` date DEFAULT NULL,
  `processed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `perizinan`
--

INSERT INTO `perizinan` (`id`, `user_id`, `nama_pemohon`, `email_pemohon`, `phone_pemohon`, `jenis_izin`, `judul_permohonan`, `deskripsi`, `dokumen_pendukung`, `status`, `catatan_admin`, `tanggal_permohonan`, `tanggal_proses`, `processed_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Budi Santoso', 'budi.santoso@gmail.com', '08123456789', 'kerjasama', 'Kerjasama Program Edukasi Anak', 'Permohonan kerjasama untuk program edukasi anak di wilayah Jakarta Selatan', '[]', 'selesai', NULL, '2026-03-25', '2026-03-25', 1, '2026-03-24 21:47:40', '2026-03-24 22:43:19'),
(2, 1, 'test', 'test@gmail.com', '08123456789', 'kegiatan', 'Kerjasama Program Edukasi Anak', 'manta', '[\"perizinan\\/dokumen\\/DnB5uZ2cUQCBfyoMk97fnno0Kcg5JbMBj8IfDegc.pdf\"]', 'pending', NULL, '2026-03-25', NULL, NULL, '2026-03-24 22:08:08', '2026-03-24 22:08:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `profile`
--

CREATE TABLE `profile` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_organisasi` varchar(255) NOT NULL,
  `tagline` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `visi` text DEFAULT NULL,
  `misi` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`misi`)),
  `sejarah` text DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telepon` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `foto_kantor` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `profile`
--

INSERT INTO `profile` (`id`, `nama_organisasi`, `tagline`, `deskripsi`, `visi`, `misi`, `sejarah`, `alamat`, `email`, `telepon`, `website`, `facebook`, `instagram`, `twitter`, `youtube`, `logo`, `foto_kantor`, `created_at`, `updated_at`) VALUES
(1, 'Yayasan Seribu Satu Cita', 'Tumbuhkan anak dengan ilmu, sayapnya akan terbang bebas di dunia', 'Yayasan Seribu Satu Cita adalah organisasi nirlaba yang berfokus pada peningkatan kualitas pendidikan, pemberdayaan pemuda, dan aksi sosial untuk masyarakat kurang mampu di Indonesia. Didirikan dengan semangat kebersamaan dan kepedulian, kami berkomitmen untuk menciptakan dampak positif yang berkelanjutan.', 'Menjadi yayasan terdepan dalam menciptakan generasi muda Indonesia yang berdaya saing, berintegritas, dan peduli terhadap sesama melalui pendidikan dan pemberdayaan masyarakat.', '[\"Menyelenggarakan program pendidikan berkualitas bagi anak-anak kurang mampu\",\"Memberdayakan pemuda Indonesia melalui pelatihan keterampilan dan kepemimpinan\",\"Melaksanakan kegiatan sosial yang berdampak langsung pada masyarakat\",\"Membangun jaringan relawan yang kuat dan profesional di seluruh Indonesia\",\"Mengelola dana donasi secara transparan dan akuntabel\"]', '<p>Yayasan Seribu Satu Cita didirikan pada tahun 2018 oleh sekelompok anak muda yang memiliki visi bersama untuk meningkatkan kualitas pendidikan di Indonesia. Bermula dari kegiatan mengajar di daerah terpencil Riau, organisasi ini terus berkembang dan kini telah memiliki lebih dari 900 relawan aktif yang tersebar di berbagai kota.</p><p>Pada tahun 2020, yayasan ini resmi berbadan hukum dan mulai menjalankan program-program yang lebih terstruktur, termasuk program beasiswa, pelatihan keterampilan digital, dan bantuan sosial untuk keluarga prasejahtera.</p><p>Hingga saat ini, Yayasan Seribu Satu Cita telah memberikan manfaat kepada lebih dari 10.000 penerima manfaat di seluruh Indonesia.</p>', 'Jl. Sudirman No. 123, Pekanbaru, Riau 28111', 'info@seribusatucita.org', '(0761) 123-4567', 'https://seribusatucita.org', 'https://facebook.com/seribusatucita', 'https://instagram.com/seribusatucita', 'https://twitter.com/seribusatucita', 'https://youtube.com/@seribusatucita', 'profil/zI1sQBhjvJv7Zx6byYyFKBQJzouZy7opfJXIyG3h.png', NULL, '2026-03-14 02:00:27', '2026-03-23 23:38:36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `program_donasi`
--

CREATE TABLE `program_donasi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mitra_id` bigint(20) UNSIGNED DEFAULT NULL,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `deskripsi` longtext NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `target_nominal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `terkumpul_nominal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'draft',
  `is_approved` tinyint(1) NOT NULL DEFAULT 1,
  `approved_at` timestamp NULL DEFAULT NULL,
  `is_mendesak` tinyint(1) NOT NULL DEFAULT 0,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `program_donasi`
--

INSERT INTO `program_donasi` (`id`, `mitra_id`, `judul`, `slug`, `deskripsi`, `thumbnail`, `target_nominal`, `terkumpul_nominal`, `tanggal_mulai`, `tanggal_selesai`, `status`, `is_approved`, `approved_at`, `is_mendesak`, `urutan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 'Beasiswa Permata Cita 2025', 'beasiswa-permata-cita-2025', '<p>Program beasiswa untuk mahasiswa berprestasi dari keluarga kurang mampu. Beasiswa mencakup biaya kuliah penuh, uang saku bulanan Rp 1.000.000, dan pendampingan akademik selama masa studi.</p><p>Target penerima: 50 mahasiswa dari berbagai perguruan tinggi di Indonesia.</p>', 'https://images.unsplash.com/photo-1523050854058-8df90110c476?q=80&w=800', 50000000.00, 8125000.00, '2025-01-01', '2025-12-31', 'aktif', 1, NULL, 0, 1, '2026-03-14 02:00:27', '2026-03-24 00:14:38', NULL),
(2, NULL, 'Bantuan Darurat Bencana Banjir Riau', 'bantuan-darurat-bencana-banjir-riau', '<p>Penggalangan dana darurat untuk korban bencana banjir yang melanda beberapa kabupaten di Riau. Dana akan digunakan untuk kebutuhan darurat: makanan, air bersih, obat-obatan, dan tempat penampungan.</p><p>Situasi sangat mendesak, ribuan warga membutuhkan bantuan segera.</p>', 'https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?q=80&w=800', 200000000.00, 14550000.00, '2025-10-01', '2025-12-31', 'aktif', 1, NULL, 1, 2, '2026-03-14 02:00:27', '2026-03-24 00:14:38', NULL),
(3, NULL, 'Rumah Belajar Desa Terpencil', 'rumah-belajar-desa-terpencil', '<p>Pembangunan rumah belajar di 3 desa terpencil di Kabupaten Kampar, Riau. Rumah belajar ini akan menjadi pusat kegiatan belajar bagi anak-anak yang tidak memiliki akses ke sekolah formal.</p><p>Fasilitas: ruang belajar, perpustakaan mini, komputer, dan area bermain.</p>', 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?q=80&w=800', 300000000.00, 6100000.00, '2025-06-01', '2026-06-01', 'aktif', 1, NULL, 0, 3, '2026-03-14 02:00:27', '2026-03-24 00:14:38', NULL),
(4, NULL, 'Klinik Kesehatan Keliling', 'klinik-kesehatan-keliling', '<p>Program kesehatan berupa klinik keliling yang menjangkau daerah-daerah terpencil di Riau. Menyediakan pemeriksaan kesehatan gratis, obat-obatan, dan edukasi kesehatan untuk masyarakat.</p><p>Target: 12 kunjungan ke 12 desa dalam setahun.</p>', 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?q=80&w=800', 150000000.00, 18125000.00, '2025-03-01', '2026-03-01', 'aktif', 1, NULL, 0, 4, '2026-03-14 02:00:27', '2026-03-24 00:14:38', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('bppInoSq3AKKuWkLMuEVrkuh9w2pNnbjfVTeqCdU', 1, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVFdscm1BRk1EdlJHMzdEVDJPQlF5Z1RQalZHOWdLMEtIZURTYzE4SiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZXJpemluYW4iO3M6NToicm91dGUiO3M6MTQ6InBlcml6aW5hbi5mb3JtIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1774413840),
('eGR1YZFKSZ5rS7qFLrJqMSWHZpycGYcTvY8bb9ed', 1, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidjhTcnRQcXdxUGVDa0lLQ3VIeXpmcldnRm9iNktsN1JDMWlXMnUxZyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8wLjAuMC4wOjgwMDAiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1774422666),
('iZfofxvU29pJYnwn3HtSzpd0wT9ErwGlAbHEhh3f', 1, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiR2J5NFF6NlljRWhiend3OVExdE5rRDdBWUpoc1hPazYwSDdIWXpxWSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1774410026);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `tombol_teks` varchar(255) DEFAULT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sliders`
--

INSERT INTO `sliders` (`id`, `judul`, `deskripsi`, `gambar`, `link`, `tombol_teks`, `urutan`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Seribu Satu Cita Foundation', 'Tumbuhkan anak dengan ilmu, sayapnya akan terbang bebas di dunia. Berikanlah cahaya pendidikan, untuk membentuk masa depan yang tak terbatas.', 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=2070', '/donasi', 'Donasi Sekarang', 1, 1, '2026-03-14 02:00:27', '2026-03-14 02:00:27'),
(2, 'Program Beasiswa Permata Cita', 'Wujudkan mimpi anak bangsa melalui pendidikan berkualitas. Daftarkan dirimu sekarang dan raih beasiswa untuk masa depan yang lebih cerah.', 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=2070', '/berita', 'Lihat Kegiatan', 2, 1, '2026-03-14 02:00:27', '2026-03-14 02:00:27'),
(3, 'Bergabung Menjadi Relawan', 'Jadilah bagian dari perubahan. Bergabunglah bersama lebih dari 900 relawan kami untuk menciptakan dampak positif bagi masyarakat.', 'https://images.unsplash.com/photo-1559027615-cd4628902d4a?q=80&w=2070', '/register', 'Gabung Sekarang', 3, 1, '2026-03-14 02:00:27', '2026-03-14 02:00:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'guest',
  `avatar` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `avatar`, `phone`, `is_active`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Super Admin', 'superadmin@yssc.org', '2026-03-14 02:00:26', '$2y$12$bg2Dh/tF9p9fOGQPmtpHoOriM.UWKefU6XmMSrENXdJ.MyzE3LHTq', 'superadmin', NULL, '081234567890', 1, NULL, '2026-03-14 02:00:26', '2026-03-14 02:00:26', NULL),
(2, 'Admin Satu', 'admin1@yssc.org', '2026-03-14 02:00:26', '$2y$12$rmz8T8KdDnmLrBlHx42JB.2Yqh5ZgGQoNdnPDO/4/0rtBJXS9ltEK', 'admin', NULL, '081234567891', 1, NULL, '2026-03-14 02:00:26', '2026-03-14 02:00:26', NULL),
(3, 'Admin Dua', 'admin2@yssc.org', '2026-03-14 02:00:26', '$2y$12$iA9i972etkiUXLOSdL.hLO1m5ZCRMr.v0RiULCV930MbqXrSUM9BG', 'admin', NULL, '081234567892', 1, NULL, '2026-03-14 02:00:26', '2026-03-14 02:00:26', NULL),
(4, 'Budi Santoso', 'budi@example.com', '2026-03-14 02:00:26', '$2y$12$57u6R6YxXIY922C5mXX5gO4aug0JAGVlcrY9Zw3z3ZsbffDYcj1cS', 'member', NULL, NULL, 1, NULL, '2026-03-14 02:00:26', '2026-03-14 02:00:26', NULL),
(5, 'Siti Rahayu', 'siti@example.com', '2026-03-14 02:00:26', '$2y$12$O4oPSDhgJRYJx6a48lhv0O0NVHB5LGXllHhiMZ4XhNZ4QZlTEO8gu', 'member', NULL, NULL, 1, NULL, '2026-03-14 02:00:26', '2026-03-14 02:00:26', NULL),
(6, 'Ahmad Fauzi', 'ahmad@example.com', '2026-03-14 02:00:27', '$2y$12$rpqR5Dqe8wMf./fwHJd.NOfLeo.9VqTAi7duwAttupxURopq/4VMC', 'member', NULL, NULL, 1, NULL, '2026-03-14 02:00:27', '2026-03-14 02:00:27', NULL),
(7, 'Dewi Lestari', 'dewi@example.com', '2026-03-14 02:00:27', '$2y$12$93BgK.kx141Vcq0pzfo7xuHN0DemOToFC1Stm.XssfGC5s8HSQNHq', 'member', NULL, NULL, 1, NULL, '2026-03-14 02:00:27', '2026-03-14 02:00:27', NULL),
(8, 'Rina Wulandari', 'rina@example.com', '2026-03-14 02:00:27', '$2y$12$CDO0eyJ.MvYxqlkUZ8wmH.9Vo2xyYvV/mCkUCkuSAFaypGxM.q7tq', 'member', NULL, NULL, 1, NULL, '2026-03-14 02:00:27', '2026-03-14 02:00:27', NULL),
(9, 'Admin Test', 'admin@yssc.com', NULL, '$2y$12$dsqwwhucQwmXe2xlG6bkl.MkEZQf/gfxsTBFIVcMFLWNCuVvnr4Ha', 'guest', NULL, NULL, 1, NULL, '2026-03-14 02:50:20', '2026-03-14 02:50:20', NULL),
(10, 'PT Mitra Sejahtera', 'mitra@yssc.com', '2026-03-23 22:17:26', '$2y$12$3LyJ/zSKrNCK6WXi4uROoubcNRMVcCZ7utX9gnfUVCiBl6ShYRwJa', 'mitra', NULL, NULL, 1, NULL, '2026-03-23 21:54:08', '2026-03-23 22:17:26', NULL),
(12, 'PT Testing Mitra Baru', 'testmitra@example.com', NULL, '$2y$12$jV82kifBT8gntuHZRpDtJuxoromHDLd7f9Zuydb8jH2bmsIFpoS82', 'mitra', NULL, NULL, 1, NULL, '2026-03-24 20:13:36', '2026-03-24 21:14:29', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject_type`,`subject_id`),
  ADD KEY `causer` (`causer_type`,`causer_id`),
  ADD KEY `activity_log_log_name_index` (`log_name`);

--
-- Indeks untuk tabel `anggota_devisi`
--
ALTER TABLE `anggota_devisi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `anggota_devisi_divisi_id_foreign` (`divisi_id`);

--
-- Indeks untuk tabel `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `berita_slug_unique` (`slug`),
  ADD KEY `berita_kategori_id_foreign` (`kategori_id`),
  ADD KEY `berita_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `dokumen_legal`
--
ALTER TABLE `dokumen_legal`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `donasi`
--
ALTER TABLE `donasi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `donasi_kode_unik_unique` (`kode_unik`),
  ADD UNIQUE KEY `donasi_midtrans_order_id_unique` (`midtrans_order_id`),
  ADD KEY `donasi_program_donasi_id_foreign` (`program_donasi_id`),
  ADD KEY `donasi_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kategori_slug_unique` (`slug`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mitra`
--
ALTER TABLE `mitra`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mitra_email_unique` (`email`),
  ADD KEY `mitra_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `perizinan`
--
ALTER TABLE `perizinan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `perizinan_user_id_foreign` (`user_id`),
  ADD KEY `perizinan_processed_by_foreign` (`processed_by`);

--
-- Indeks untuk tabel `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `program_donasi`
--
ALTER TABLE `program_donasi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `program_donasi_slug_unique` (`slug`),
  ADD KEY `program_donasi_mitra_id_foreign` (`mitra_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `anggota_devisi`
--
ALTER TABLE `anggota_devisi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `berita`
--
ALTER TABLE `berita`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `dokumen_legal`
--
ALTER TABLE `dokumen_legal`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `donasi`
--
ALTER TABLE `donasi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `mitra`
--
ALTER TABLE `mitra`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `perizinan`
--
ALTER TABLE `perizinan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `profile`
--
ALTER TABLE `profile`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `program_donasi`
--
ALTER TABLE `program_donasi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `anggota_devisi`
--
ALTER TABLE `anggota_devisi`
  ADD CONSTRAINT `anggota_devisi_divisi_id_foreign` FOREIGN KEY (`divisi_id`) REFERENCES `divisi` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `berita`
--
ALTER TABLE `berita`
  ADD CONSTRAINT `berita_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `berita_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `donasi`
--
ALTER TABLE `donasi`
  ADD CONSTRAINT `donasi_program_donasi_id_foreign` FOREIGN KEY (`program_donasi_id`) REFERENCES `program_donasi` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `donasi_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `mitra`
--
ALTER TABLE `mitra`
  ADD CONSTRAINT `mitra_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `perizinan`
--
ALTER TABLE `perizinan`
  ADD CONSTRAINT `perizinan_processed_by_foreign` FOREIGN KEY (`processed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `perizinan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `program_donasi`
--
ALTER TABLE `program_donasi`
  ADD CONSTRAINT `program_donasi_mitra_id_foreign` FOREIGN KEY (`mitra_id`) REFERENCES `mitra` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
