<?php

namespace Database\Seeders;

use App\Models\Perkara;
use App\Models\TahapanPerkara;
use Illuminate\Database\Seeder;

class TahapanPerkaraSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil perkara pertama (PT. Maju Mundur Sentosa)
        $perkara = Perkara::first();

        if ($perkara) {
            // Tambahkan Riwayat Tahapan
            TahapanPerkara::create([
                'perkara_id' => $perkara->id,
                'nama_tahapan' => 'Pendaftaran Gugatan',
                'tanggal' => now()->subDays(10),
                'keterangan' => 'Berkas gugatan telah didaftarkan ke PN Banjarmasin.',
            ]);

            TahapanPerkara::create([
                'perkara_id' => $perkara->id,
                'nama_tahapan' => 'Sidang Pertama',
                'tanggal' => now()->subDays(3),
                'keterangan' => 'Agenda pemeriksaan identitas para pihak.',
            ]);
        }
    }
}
