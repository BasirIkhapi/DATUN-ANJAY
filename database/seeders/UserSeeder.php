<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Jalankan database seeder untuk membuat akun awal.
     */
    public function run(): void
    {
        // Membuat akun Admin
        User::create([
            'name' => 'Basir Ikhapi',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Membuat akun Pimpinan
        User::create([
            'name' => 'Kasi Datun',
            'email' => 'pimpinan@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'pimpinan',
        ]);
    }
}