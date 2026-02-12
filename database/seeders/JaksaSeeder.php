<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jaksa; // Pastikan model ini terpanggil dengan benar

class JaksaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nip' => '198501012010121001',
                'nama_jaksa' => 'Budi Santoso, S.H., M.H.',
                'pangkat_golongan' => 'Jaksa Madya / IV.a'
            ],
            [
                'nip' => '199005122015031002',
                'nama_jaksa' => 'Siti Aminah, S.H.',
                'pangkat_golongan' => 'Jaksa Pratama / III.c'
            ],
        ];

        foreach ($data as $item) {
            // Menggunakan updateOrCreate agar tidak duplikat jika seeder dijalankan ulang
            Jaksa::updateOrCreate(
                ['nip' => $item['nip']],
                $item
            );
        }
    }
}
