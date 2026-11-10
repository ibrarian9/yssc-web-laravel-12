<?php

namespace Database\Seeders;

use App\Enums\JenisMitra;
use App\Enums\UserRole;
use App\Models\Mitra;
use App\Models\User;
use Illuminate\Database\Seeder;

class MitraSeeder extends Seeder
{
    public function run(): void
    {
        // Opsional: Buat akun user untuk mitra jika belum ada
        $mitraUser = User::firstOrCreate(
            ['email' => 'mitra.danapendidikan@example.com'],
            [
                'name' => 'PT Cita Sejahtera Mandiri',
                'password' => bcrypt('password'),
                'role' => UserRole::Mitra,
                'phone' => '0215558899',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $data = [
            [
                'user_id' => $mitraUser->id,
                'jenis_mitra' => JenisMitra::Perusahaan,
                'nama_perusahaan' => 'PT Cita Sejahtera Mandiri',
                'email' => 'mitra.danapendidikan@example.com',
                'telepon' => '021-5558899',
                'npwp' => '01.234.567.8-012.000',
                'deskripsi' => 'Mitra korporasi penyedia program CSR pendidikan berkala untuk renovasi fasilitas belajar dan penyediaan perlengkapan sekolah di daerah pelosok.',
                'status' => 'approved',
                'catatan_admin' => 'Kemitraan resmi aktif. Berkas legalitas dan NPWP telah terverifikasi lengkap.',
                'approved_at' => now()->subWeeks(2),
            ],
            [
                'user_id' => null,
                'jenis_mitra' => JenisMitra::Lembaga,
                'nama_perusahaan' => 'Yayasan Cahaya Generasi Emas',
                'email' => 'info@cahayagenerasi.org',
                'telepon' => '0761-443322',
                'npwp' => '02.345.678.9-023.000',
                'deskripsi' => 'Lembaga nirlaba yang berfokus pada pendampingan psikologis, nutrisi anak prasejahtera, dan pelatihan guru di wilayah Riau.',
                'status' => 'pending',
                'catatan_admin' => null,
                'approved_at' => null,
            ],
            [
                'user_id' => null,
                'jenis_mitra' => JenisMitra::Perorangan,
                'nama_perusahaan' => 'Klinik Dr. Farhan Pratama',
                'email' => 'farhan.csr@example.com',
                'telepon' => '081122334455',
                'npwp' => '03.456.789.0-034.000',
                'deskripsi' => 'Penyedia layanan pemeriksaan kesehatan gratis dan penyuluhan gizi bagi anak-anak binaan yayasan.',
                'status' => 'approved',
                'catatan_admin' => 'Kerja sama layanan bakti kesehatan berkala setiap 3 bulan disetujui.',
                'approved_at' => now()->subMonth(),
            ],
        ];

        foreach ($data as $item) {
            Mitra::firstOrCreate(
                ['email' => $item['email']],
                $item
            );
        }
    }
}

