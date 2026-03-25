<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        Profile::create([
            'nama_organisasi' => 'Yayasan Seribu Satu Cita',
            'tagline' => 'Tumbuhkan anak dengan ilmu, sayapnya akan terbang bebas di dunia',
            'deskripsi' => 'Yayasan Seribu Satu Cita adalah organisasi nirlaba yang berfokus pada peningkatan kualitas pendidikan, pemberdayaan pemuda, dan aksi sosial untuk masyarakat kurang mampu di Indonesia. Didirikan dengan semangat kebersamaan dan kepedulian, kami berkomitmen untuk menciptakan dampak positif yang berkelanjutan.',
            'visi' => 'Menjadi yayasan terdepan dalam menciptakan generasi muda Indonesia yang berdaya saing, berintegritas, dan peduli terhadap sesama melalui pendidikan dan pemberdayaan masyarakat.',
            'misi' => [
                'Menyelenggarakan program pendidikan berkualitas bagi anak-anak kurang mampu',
                'Memberdayakan pemuda Indonesia melalui pelatihan keterampilan dan kepemimpinan',
                'Melaksanakan kegiatan sosial yang berdampak langsung pada masyarakat',
                'Membangun jaringan relawan yang kuat dan profesional di seluruh Indonesia',
                'Mengelola dana donasi secara transparan dan akuntabel',
            ],
            'sejarah' => '<p>Yayasan Seribu Satu Cita didirikan pada tahun 2018 oleh sekelompok anak muda yang memiliki visi bersama untuk meningkatkan kualitas pendidikan di Indonesia. Bermula dari kegiatan mengajar di daerah terpencil Riau, organisasi ini terus berkembang dan kini telah memiliki lebih dari 900 relawan aktif yang tersebar di berbagai kota.</p><p>Pada tahun 2020, yayasan ini resmi berbadan hukum dan mulai menjalankan program-program yang lebih terstruktur, termasuk program beasiswa, pelatihan keterampilan digital, dan bantuan sosial untuk keluarga prasejahtera.</p><p>Hingga saat ini, Yayasan Seribu Satu Cita telah memberikan manfaat kepada lebih dari 10.000 penerima manfaat di seluruh Indonesia.</p>',
            'alamat' => 'Jl. Sudirman No. 123, Pekanbaru, Riau 28111',
            'email' => 'info@seribusatucita.org',
            'telepon' => '(0761) 123-4567',
            'website' => 'https://seribusatucita.org',
            'facebook' => 'https://facebook.com/seribusatucita',
            'instagram' => 'https://instagram.com/seribusatucita',
            'twitter' => 'https://twitter.com/seribusatucita',
            'youtube' => 'https://youtube.com/@seribusatucita',
        ]);
    }
}
