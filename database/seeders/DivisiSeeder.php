<?php

namespace Database\Seeders;

use App\Models\Divisi;
use Illuminate\Database\Seeder;

class DivisiSeeder extends Seeder
{
    public function run(): void
    {
        $divisi = [
            ['nama' => 'Hubungan Masyarakat', 'deskripsi' => 'Divisi yang bertanggung jawab atas komunikasi publik, media relations, dan branding organisasi.', 'urutan' => 1],
            ['nama' => 'Program & Kegiatan', 'deskripsi' => 'Divisi yang merancang, mengelola, dan mengevaluasi seluruh program dan kegiatan yayasan.', 'urutan' => 2],
            ['nama' => 'Keuangan & Administrasi', 'deskripsi' => 'Divisi yang mengelola keuangan, pelaporan, dan administrasi organisasi secara transparan.', 'urutan' => 3],
            ['nama' => 'Teknologi Informasi', 'deskripsi' => 'Divisi yang mengelola infrastruktur teknologi, website, dan sistem informasi organisasi.', 'urutan' => 4],
        ];

        foreach ($divisi as $d) {
            Divisi::create($d);
        }
    }
}
