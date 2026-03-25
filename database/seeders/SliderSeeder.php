<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    public function run(): void
    {
        $sliders = [
            [
                'judul' => 'Seribu Satu Cita Foundation',
                'deskripsi' => 'Tumbuhkan anak dengan ilmu, sayapnya akan terbang bebas di dunia. Berikanlah cahaya pendidikan, untuk membentuk masa depan yang tak terbatas.',
                'gambar' => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=2070',
                'link' => '/donasi',
                'tombol_teks' => 'Donasi Sekarang',
                'urutan' => 1,
            ],
            [
                'judul' => 'Program Beasiswa Permata Cita',
                'deskripsi' => 'Wujudkan mimpi anak bangsa melalui pendidikan berkualitas. Daftarkan dirimu sekarang dan raih beasiswa untuk masa depan yang lebih cerah.',
                'gambar' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=2070',
                'link' => '/berita',
                'tombol_teks' => 'Lihat Kegiatan',
                'urutan' => 2,
            ],
            [
                'judul' => 'Bergabung Menjadi Relawan',
                'deskripsi' => 'Jadilah bagian dari perubahan. Bergabunglah bersama lebih dari 900 relawan kami untuk menciptakan dampak positif bagi masyarakat.',
                'gambar' => 'https://images.unsplash.com/photo-1559027615-cd4628902d4a?q=80&w=2070',
                'link' => '/register',
                'tombol_teks' => 'Gabung Sekarang',
                'urutan' => 3,
            ],
        ];

        foreach ($sliders as $s) {
            Slider::create($s);
        }
    }
}
