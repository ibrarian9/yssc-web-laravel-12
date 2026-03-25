<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = [
            ['nama' => 'Pendidikan', 'slug' => 'pendidikan', 'warna' => '#0d9488'],
            ['nama' => 'Sosial', 'slug' => 'sosial', 'warna' => '#f97316'],
            ['nama' => 'Kepemudaan', 'slug' => 'kepemudaan', 'warna' => '#8b5cf6'],
            ['nama' => 'Lingkungan', 'slug' => 'lingkungan', 'warna' => '#22c55e'],
            ['nama' => 'Kesehatan', 'slug' => 'kesehatan', 'warna' => '#ef4444'],
        ];

        foreach ($kategori as $k) {
            Kategori::create($k);
        }
    }
}
