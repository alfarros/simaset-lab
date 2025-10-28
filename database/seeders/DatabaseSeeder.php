<?php

namespace Database\Seeders;

// ...
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 👇 PANGGIL SEEDER ADMIN DI SINI 👇
        $this->call(AdminUserSeeder::class); 

        // Panggil seeder aset (jika ada)
        $this->call(AssetSeeder::class); 
    }
}