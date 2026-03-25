<?php

namespace Database\Seeders;

use App\Models\Donasi;
use Illuminate\Database\Seeder;

class DonasiSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Hasan Basri', 'Fatimah Zahra', 'Umar Faruq', 'Khadijah Nur', 'Ali Imran',
            'Zainab Putri', 'Ibrahim Malik', 'Maryam Sari', 'Yusuf Hakim', 'Aisyah Dewi',
            'Hamza Rizqi', 'Sarah Amira', 'Ismail Putra', 'Hafsa Rahma', 'Sulaiman Akbar',
            'Ruqayyah Indah', 'Idris Pratama', 'Asma Lestari', 'Nuh Firmansyah', 'Ramlah Wati',
        ];

        $nominals = [25000, 50000, 75000, 100000, 150000, 200000, 250000, 500000, 750000, 1000000, 2000000, 5000000];
        $statuses = ['success', 'success', 'success', 'success', 'pending', 'failed'];
        $methods = ['transfer_bank', 'e-wallet', 'transfer_bank', 'qris'];

        for ($i = 0; $i < 50; $i++) {
            $name = $names[array_rand($names)];
            $nominal = $nominals[array_rand($nominals)];
            $status = $statuses[array_rand($statuses)];

            Donasi::create([
                'program_donasi_id' => rand(1, 4),
                'user_id' => rand(0, 1) ? rand(4, 8) : null,
                'nama_donatur' => $name,
                'email_donatur' => strtolower(str_replace(' ', '.', $name)) . '@example.com',
                'phone' => '08' . rand(1000000000, 9999999999),
                'nominal' => $nominal,
                'pesan' => rand(0, 1) ? 'Semoga bermanfaat dan berkah selalu.' : null,
                'is_anonim' => rand(0, 4) === 0,
                'metode_pembayaran' => $methods[array_rand($methods)],
                'status_pembayaran' => $status,
                'created_at' => now()->subDays(rand(1, 180)),
            ]);
        }
    }
}
