<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat Akun Admin (NIP: 12345)
        User::create([
            'name'     => 'Admin Kasi Datun',
            'nip'      => '12345',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // Membuat Akun Staff (NIP: 67890)
        User::create([
            'name'     => 'Staff Operator',
            'nip'      => '67890',
            'password' => Hash::make('password'),
            'role'     => 'staff',
        ]);
    }
}
