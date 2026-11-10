<?php

namespace Database\Seeders;

use App\Models\Relawan;
use Illuminate\Database\Seeder;

class RelawanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Budi Santoso',
                'email' => 'budi.santoso@example.com',
                'telepon' => '08123456789',
                'alamat' => 'Jl. Sudirman No. 123, Pekanbaru',
                'tanggal_lahir' => '2005-12-09',
                'pekerjaan' => 'Mahasiswa',
                'motivasi' => 'Saya ingin berkontribusi untuk pendidikan anak-anak Indonesia dan membantu masyarakat yang membutuhkan.',
                'keahlian' => 'Mengajar, Desain Grafis',
                'status' => 'pending',
                'catatan_admin' => null,
                'approved_at' => null,
            ],
            [
                'nama' => 'Siti Nur Aisyah, S.Pd.',
                'email' => 'siti.aisyah@example.com',
                'telepon' => '082198765432',
                'alamat' => 'Jl. Tuanku Tambusai No. 88, Pekanbaru',
                'tanggal_lahir' => '1998-04-18',
                'pekerjaan' => 'Guru / Tenaga Pendidik',
                'motivasi' => 'Terpanggil untuk mengajar literasi dan membaca bagi adik-adik prasejahtera di sanggar belajar yayasan.',
                'keahlian' => 'Literasi Anak, Seni Tari, Storytelling',
                'status' => 'approved',
                'catatan_admin' => 'Wawancara telah dilaksanakan. Memiliki komitmen tinggi dan pengalaman mengajar.',
                'approved_at' => now()->subWeeks(1),
            ],
            [
                'nama' => 'Dimas Arya Pratama',
                'email' => 'dimas.arya@example.com',
                'telepon' => '081377889911',
                'alamat' => 'Jl. HR. Soebrantas Km. 12, Panam, Pekanbaru',
                'tanggal_lahir' => '2002-09-25',
                'pekerjaan' => 'Mahasiswa Teknik Informatika',
                'motivasi' => 'Ingin membantu yayasan dalam dokumentasi acara lapangan, fotografi, dan pengelolaan konten kegiatan relawan.',
                'keahlian' => 'Fotografi, Videografi, Dokumentasi Lapangan',
                'status' => 'approved',
                'catatan_admin' => 'Disetujui untuk bergabung di tim media dan dokumentasi yayasan.',
                'approved_at' => now()->subDays(4),
            ],
        ];

        foreach ($data as $item) {
            Relawan::firstOrCreate(
                ['email' => $item['email']],
                $item
            );
        }
    }
}

