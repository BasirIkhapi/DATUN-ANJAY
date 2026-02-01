<?php

namespace Database\Seeders;

use App\Models\Jaksa;
use Illuminate\Database\Seeder;

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
            Jaksa::updateOrCreate(['nip' => $item['nip']], $item);
        }
    }
}