<?php

namespace Database\Seeders;

use App\Models\Perizinan;
use App\Models\User;
use Illuminate\Database\Seeder;

class PerizinanSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::whereIn('role', ['admin', 'superadmin'])->first();

        $data = [
            [
                'nama_pemohon' => 'Dr. Hendra Gunawan, M.Pd.',
                'email_pemohon' => 'hendra.gunawan@example.com',
                'phone_pemohon' => '081234567893',
                'jenis_izin' => 'kegiatan',
                'judul_permohonan' => 'Izin Penyelenggaraan Workshop Pendidikan Karakter & Literasi Digital',
                'deskripsi' => 'Permohonan izin pelaksanaan kegiatan workshop literasi digital dan pelatihan budi pekerti bagi anak-anak usia sekolah dasar di wilayah Pekanbaru dan sekitarnya.',
                'dokumen_pendukung' => ['proposal_workshop_literasi.pdf', 'surat_pengantar_dinas.pdf'],
                'status' => 'diproses',
                'catatan_admin' => 'Dokumen proposal telah diterima dan sedang dalam tahap verifikasi jadwal aula kegiatan.',
                'tanggal_permohonan' => now()->subDays(5)->toDateString(),
                'tanggal_proses' => now()->subDays(2)->toDateString(),
                'processed_by' => $admin?->id,
            ],
            [
                'nama_pemohon' => 'Komunitas Sahabat Anak Riau',
                'email_pemohon' => 'sahabatanak.riau@example.org',
                'phone_pemohon' => '082155566778',
                'jenis_izin' => 'kerjasama',
                'judul_permohonan' => 'Kerja Sama Program Pembagian Buku dan Alat Tulis Sekolah',
                'deskripsi' => 'Pengajuan kolaborasi penyaluran donasi 500 paket alat tulis dan modul pembelajaran mandiri untuk daerah 3T di Provinsi Riau.',
                'dokumen_pendukung' => ['draft_mou_kerjasama.pdf'],
                'status' => 'selesai',
                'catatan_admin' => 'MoU kerja sama telah disetujui dan ditandatangani oleh pimpinan yayasan.',
                'tanggal_permohonan' => now()->subDays(14)->toDateString(),
                'tanggal_proses' => now()->subDays(10)->toDateString(),
                'processed_by' => $admin?->id,
            ],
            [
                'nama_pemohon' => 'Rahmat Hidayat',
                'email_pemohon' => 'rahmat.hidayat@example.com',
                'phone_pemohon' => '085277889900',
                'jenis_izin' => 'rekomendasi',
                'judul_permohonan' => 'Surat Rekomendasi Kegiatan Riset Sosial Dampak Beasiswa',
                'deskripsi' => 'Permohonan penerbitan surat rekomendasi dari yayasan untuk keperluan penelitian tesis dampak bantuan beasiswa terhadap angka putus sekolah.',
                'dokumen_pendukung' => ['surat_pengantar_kampus.pdf'],
                'status' => 'pending',
                'catatan_admin' => null,
                'tanggal_permohonan' => now()->subDays(1)->toDateString(),
                'tanggal_proses' => null,
                'processed_by' => null,
            ],
        ];

        foreach ($data as $item) {
            Perizinan::firstOrCreate(
                ['email_pemohon' => $item['email_pemohon'], 'judul_permohonan' => $item['judul_permohonan']],
                $item
            );
        }
    }
}

