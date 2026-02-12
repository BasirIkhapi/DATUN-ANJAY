<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tahapan extends Model
{
    use HasFactory;

    protected $table = 'tahapan_perkaras';

    protected $fillable = [
        'perkara_id',
        'nama_tahapan', // PERBAIKAN: Hapus huruf 's' di belakangnya
        'tanggal_tahapan',
        'keterangan',
        'file_tahapan',
    ];

    public function perkara()
    {
        return $this->belongsTo(Perkara::class, 'perkara_id');
    }
}
