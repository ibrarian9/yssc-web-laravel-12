<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ProfileSeeder::class,
            DivisiSeeder::class,
            AnggotaSeeder::class,
            KategoriSeeder::class,
            BeritaSeeder::class,
            SliderSeeder::class,
            ProgramDonasiSeeder::class,
            DonasiSeeder::class,
        ]);
    }
}
