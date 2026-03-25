<?php

namespace Database\Seeders;

use App\Models\AnggotaDevisi;
use Illuminate\Database\Seeder;

class AnggotaSeeder extends Seeder
{
    public function run(): void
    {
        $anggota = [
            // Divisi 1 - Humas
            ['divisi_id' => 1, 'nama' => 'Muhammad Rizki', 'jabatan' => 'Ketua Divisi Humas', 'urutan' => 1],
            ['divisi_id' => 1, 'nama' => 'Anisa Putri', 'jabatan' => 'Koordinator Media Sosial', 'urutan' => 2],
            ['divisi_id' => 1, 'nama' => 'Fajar Nugroho', 'jabatan' => 'Staf Desain Grafis', 'urutan' => 3],
            ['divisi_id' => 1, 'nama' => 'Lina Marlina', 'jabatan' => 'Staf Hubungan Media', 'urutan' => 4],

            // Divisi 2 - Program
            ['divisi_id' => 2, 'nama' => 'Rendi Pratama', 'jabatan' => 'Ketua Divisi Program', 'urutan' => 1],
            ['divisi_id' => 2, 'nama' => 'Nurul Hidayah', 'jabatan' => 'Koordinator Program Edukasi', 'urutan' => 2],
            ['divisi_id' => 2, 'nama' => 'Hendra Saputra', 'jabatan' => 'Koordinator Program Sosial', 'urutan' => 3],
            ['divisi_id' => 2, 'nama' => 'Yuni Astuti', 'jabatan' => 'Staf Evaluasi Program', 'urutan' => 4],
            ['divisi_id' => 2, 'nama' => 'Dimas Aditya', 'jabatan' => 'Staf Lapangan', 'urutan' => 5],

            // Divisi 3 - Keuangan
            ['divisi_id' => 3, 'nama' => 'Siska Dewi', 'jabatan' => 'Ketua Divisi Keuangan', 'urutan' => 1],
            ['divisi_id' => 3, 'nama' => 'Andi Wijaya', 'jabatan' => 'Staf Pembukuan', 'urutan' => 2],
            ['divisi_id' => 3, 'nama' => 'Ratna Sari', 'jabatan' => 'Staf Administrasi', 'urutan' => 3],

            // Divisi 4 - IT
            ['divisi_id' => 4, 'nama' => 'Bayu Pratama', 'jabatan' => 'Ketua Divisi IT', 'urutan' => 1],
            ['divisi_id' => 4, 'nama' => 'Eka Rahmawati', 'jabatan' => 'Web Developer', 'urutan' => 2],
            ['divisi_id' => 4, 'nama' => 'Gilang Ramadhan', 'jabatan' => 'System Administrator', 'urutan' => 3],
        ];

        foreach ($anggota as $a) {
            AnggotaDevisi::create(array_merge($a, [
                'is_active' => true,
                'periode_mulai' => '2024-01-01',
            ]));
        }
    }
}
