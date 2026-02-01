<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jaksa extends Model
{
    use HasFactory;

    // Menentukan kolom yang boleh diisi (Mass Assignment)
    // Tambahkan 'nip' dan 'nama_jaksa' sesuai kebutuhan form kamu
    protected $fillable = [
        'nip', 
        'nama_jaksa', 
        'pangkat_golongan'
    ];

    /**
     * Relasi ke Model Perkara
     * Penamaan 'perkaras' (jamak) karena satu jaksa menangani banyak perkara
     */
    public function perkaras()
    {
        // Menentukan foreign key 'jaksa_id' secara eksplisit agar relasi tidak null
        return $this->hasMany(Perkara::class, 'jaksa_id');
    }

    /**
     * Relasi Cadangan (Opsional)
     * Jika di kodingan Blade/Controller kamu terlanjur memanggil 'perkara' tanpa 's'
     */
    public function perkara()
    {
        return $this->hasMany(Perkara::class, 'jaksa_id');
    }
}