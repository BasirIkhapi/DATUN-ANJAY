<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tahapan extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'perkara_id', 
        'nama_tahapan', 
        'tanggal_tahapan', 
        'keterangan'
    ];

    /**
     * RELASI: Setiap Tahapan dimiliki oleh satu Perkara
     */
    public function perkara()
    {
        return $this->belongsTo(Perkara::class);
    }
}