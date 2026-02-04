<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // SEEDER UNTUK ADMIN
        User::create([
            'name'     => 'Basir Ikhapi',
            'nip'      => '123456789', // Ganti email menjadi NIP di sini
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // SEEDER UNTUK PIMPINAN
        User::create([
            'name'     => 'Pimpinan Datun',
            'nip'      => '987654321', // Gunakan NIP unik
            'password' => Hash::make('password'),
            'role'     => 'pimpinan',
        ]);
    }
}