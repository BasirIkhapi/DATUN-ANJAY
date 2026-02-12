<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Jalankan database seeds.
     * Menggunakan NIP sebagai identitas login sesuai migrasi terbaru.
     */
    public function run(): void
    {
        // 1. Akun ADMIN (Menggunakan NIP)
        User::create([
            'name' => 'Basir Admin',
            'nip' => '19900101001', // Contoh NIP untuk Admin
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Akun STAFF
        // Catatan: Pastikan di migrasi users, Enum role sudah menyertakan 'staff'
        User::create([
            'name' => 'Staff Datun',
            'nip' => '19900101002', // Contoh NIP untuk Staff
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);

        // 3. Akun PIMPINAN
        User::create([
            'name' => 'Kajari Banjarmasin',
            'nip' => '19900101003', // Contoh NIP untuk Pimpinan
            'password' => Hash::make('password'),
            'role' => 'pimpinan',
        ]);
    }
}
