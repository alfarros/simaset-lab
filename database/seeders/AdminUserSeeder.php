<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // <-- 1. Import model User
use Illuminate\Support\Facades\Hash; // <-- 2. Import Hash untuk password

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek dulu apakah user admin sudah ada, agar tidak duplikat
        if (!User::where('email', 'admin@simaset.com')->exists()) {
            User::create([
                'name' => 'Admin Lab',
                'email' => 'admin@simaset.com', // Ganti email jika perlu
                'password' => Hash::make('password'), // GANTI 'password' dengan password yang aman!
                'role' => 'admin', // <-- 3. Set role menjadi admin
            ]);

            $this->command->info('Admin user created successfully!'); // Pesan sukses
        } else {
             $this->command->info('Admin user already exists.'); // Pesan jika sudah ada
        }
    }
}