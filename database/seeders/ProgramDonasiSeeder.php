<?php

namespace Database\Seeders;

use App\Models\ProgramDonasi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProgramDonasiSeeder extends Seeder
{
    public function run(): void
    {
        $programs = [
            [
                'judul' => 'Beasiswa Permata Cita 2025',
                'deskripsi' => '<p>Program beasiswa untuk mahasiswa berprestasi dari keluarga kurang mampu. Beasiswa mencakup biaya kuliah penuh, uang saku bulanan Rp 1.000.000, dan pendampingan akademik selama masa studi.</p><p>Target penerima: 50 mahasiswa dari berbagai perguruan tinggi di Indonesia.</p>',
                'target_nominal' => 500000000,
                'terkumpul_nominal' => 387500000,
                'tanggal_mulai' => '2025-01-01',
                'tanggal_selesai' => '2025-12-31',
                'status' => 'aktif',
                'is_mendesak' => false,
                'urutan' => 1,
                'thumbnail' => 'https://images.unsplash.com/photo-1523050854058-8df90110c476?q=80&w=800',
            ],
            [
                'judul' => 'Bantuan Darurat Bencana Banjir Riau',
                'deskripsi' => '<p>Penggalangan dana darurat untuk korban bencana banjir yang melanda beberapa kabupaten di Riau. Dana akan digunakan untuk kebutuhan darurat: makanan, air bersih, obat-obatan, dan tempat penampungan.</p><p>Situasi sangat mendesak, ribuan warga membutuhkan bantuan segera.</p>',
                'target_nominal' => 200000000,
                'terkumpul_nominal' => 156000000,
                'tanggal_mulai' => '2025-10-01',
                'tanggal_selesai' => '2025-12-31',
                'status' => 'aktif',
                'is_mendesak' => true,
                'urutan' => 2,
                'thumbnail' => 'https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?q=80&w=800',
            ],
            [
                'judul' => 'Rumah Belajar Desa Terpencil',
                'deskripsi' => '<p>Pembangunan rumah belajar di 3 desa terpencil di Kabupaten Kampar, Riau. Rumah belajar ini akan menjadi pusat kegiatan belajar bagi anak-anak yang tidak memiliki akses ke sekolah formal.</p><p>Fasilitas: ruang belajar, perpustakaan mini, komputer, dan area bermain.</p>',
                'target_nominal' => 300000000,
                'terkumpul_nominal' => 89000000,
                'tanggal_mulai' => '2025-06-01',
                'tanggal_selesai' => '2026-06-01',
                'status' => 'aktif',
                'is_mendesak' => false,
                'urutan' => 3,
                'thumbnail' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?q=80&w=800',
            ],
            [
                'judul' => 'Klinik Kesehatan Keliling',
                'deskripsi' => '<p>Program kesehatan berupa klinik keliling yang menjangkau daerah-daerah terpencil di Riau. Menyediakan pemeriksaan kesehatan gratis, obat-obatan, dan edukasi kesehatan untuk masyarakat.</p><p>Target: 12 kunjungan ke 12 desa dalam setahun.</p>',
                'target_nominal' => 150000000,
                'terkumpul_nominal' => 42000000,
                'tanggal_mulai' => '2025-03-01',
                'tanggal_selesai' => '2026-03-01',
                'status' => 'aktif',
                'is_mendesak' => false,
                'urutan' => 4,
                'thumbnail' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?q=80&w=800',
            ],
        ];

        foreach ($programs as $p) {
            ProgramDonasi::create(array_merge($p, [
                'slug' => Str::slug($p['judul']),
            ]));
        }
    }
}
