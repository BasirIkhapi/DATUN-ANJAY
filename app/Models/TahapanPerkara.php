<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahapanPerkara extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi secara massal.
     * Sesuaikan dengan kolom yang ada di migrasi tahapan_perkaras.
     */
    protected $fillable = [
        'perkara_id',
        'nama_tahapan',
        'tanggal',
        'keterangan',
    ];

    /**
     * Relasi balik ke Perkara.
     * Satu catatan tahapan dimiliki oleh satu perkara.
     */
    public function perkara()
    {
        return $this->belongsTo(Perkara::class, 'perkara_id');
    }
}
