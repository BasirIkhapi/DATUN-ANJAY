<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jaksa extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi secara massal.
     * Pastikan nama kolom ini sama persis dengan migration (nip, nama_jaksa, pangkat_golongan).
     */
    protected $fillable = [
        'nip',
        'nama_jaksa',
        'pangkat_golongan',
    ];

    /**
     * Relasi ke Model Perkara (One-to-Many).
     * Digunakan untuk menghitung beban kerja: $jaksa->perkaras->count()
     */
    public function perkaras(): HasMany
    {
        // 'jaksa_id' adalah kolom di tabel perkaras yang menyimpan ID dari tabel jaksas
        return $this->hasMany(Perkara::class, 'jaksa_id');
    }

    /**
     * Helper: Mendapatkan inisial nama untuk avatar di tabel.
     * Contoh: "Ahmad" menjadi "A"
     */
    public function getInisialAttribute(): string
    {
        return strtoupper(substr($this->nama_jaksa, 0, 1));
    }
}
