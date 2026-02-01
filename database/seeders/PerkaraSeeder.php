<?php

namespace Database\Seeders;

use App\Models\Perkara;
use App\Models\Jaksa;
use Illuminate\Database\Seeder;

class PerkaraSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil Jaksa pertama dari database
        $jaksa = Jaksa::first();

        if ($jaksa) {
            $perkaras = [
                [
                    'nomor_perkara' => '01/Pdt.G/2026/PN Bjm',
                    'jaksa_id' => $jaksa->id,
                    'penggugat' => 'PT. Sawit Makmur',
                    'tergugat' => 'Pemerintah Kota Banjarmasin',
                    'jenis_perkara' => 'Perdata',
                    'tanggal_masuk' => '2026-01-10',
                    'status_akhir' => 'Proses',
                ],
                [
                    'nomor_perkara' => '02/G/2026/PTUN.BJM',
                    'jaksa_id' => $jaksa->id,
                    'penggugat' => 'Yayasan Pendidikan Bangsa',
                    'tergugat' => 'Dinas Pendidikan',
                    'jenis_perkara' => 'Tata Usaha Negara',
                    'tanggal_masuk' => '2026-01-15',
                    'status_akhir' => 'Proses',
                ],
            ];

            foreach ($perkaras as $perkara) {
                Perkara::updateOrCreate(['nomor_perkara' => $perkara['nomor_perkara']], $perkara);
            }
        }
    }
}