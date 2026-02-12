<?php

namespace Database\Seeders;

use App\Models\Jaksa;
use App\Models\Perkara;
use Illuminate\Database\Seeder;

class PerkaraSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ID jaksa pertama yang ada di database
        $jaksa = Jaksa::first();

        if ($jaksa) {
            Perkara::create([
                'jaksa_id'      => $jaksa->id,
                'nomor_perkara' => '01/Pdt.G/2026/PN Bjm',
                'penggugat'     => 'PT. Maju Mundur Sentosa',
                'tergugat'      => 'Pemerintah Kota Banjarmasin',
                'jenis_perkara' => 'Perdata',
                'tanggal_masuk' => now(),
                'status_akhir'  => 'Proses',
            ]);

            Perkara::create([
                'jaksa_id'      => $jaksa->id,
                'nomor_perkara' => '12/G/2026/PTUN.BJM',
                'penggugat'     => 'H. Abdurrahman',
                'tergugat'      => 'Badan Pertanahan Nasional',
                'jenis_perkara' => 'Tata Usaha Negara',
                'tanggal_masuk' => now()->subDays(5),
                'status_akhir'  => 'Proses',
            ]);
        }
    }
}
