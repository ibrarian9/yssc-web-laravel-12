<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@yssc.org',
            'password' => bcrypt('password'),
            'role' => UserRole::SuperAdmin,
            'phone' => '081234567890',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Admin Satu',
            'email' => 'admin1@yssc.org',
            'password' => bcrypt('password'),
            'role' => UserRole::Admin,
            'phone' => '081234567891',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Admin Dua',
            'email' => 'admin2@yssc.org',
            'password' => bcrypt('password'),
            'role' => UserRole::Admin,
            'phone' => '081234567892',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $members = [
            ['name' => 'Budi Santoso', 'email' => 'budi@example.com'],
            ['name' => 'Siti Rahayu', 'email' => 'siti@example.com'],
            ['name' => 'Ahmad Fauzi', 'email' => 'ahmad@example.com'],
            ['name' => 'Dewi Lestari', 'email' => 'dewi@example.com'],
            ['name' => 'Rina Wulandari', 'email' => 'rina@example.com'],
        ];

        foreach ($members as $m) {
            User::create([
                'name' => $m['name'],
                'email' => $m['email'],
                'password' => bcrypt('password'),
                'role' => UserRole::Member,
                'is_active' => true,
                'email_verified_at' => now(),
            ]);
        }
    }
}
