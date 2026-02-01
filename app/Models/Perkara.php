<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perkara extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan di database
     */
    protected $table = 'perkaras';

    /**
     * Menonaktifkan proteksi mass assignment
     * Dengan guarded kosong, semua kolom (nomor_perkara, jaksa_id, dll) 
     * akan diizinkan masuk ke database tanpa kecuali.
     */
    protected $guarded = [];

    /**
     * RELASI: Satu Perkara memiliki banyak Tahapan (Timeline)
     * Digunakan untuk menampilkan progres perkara di halaman Monitoring
     */
    public function tahapans()
    {
        return $this->hasMany(Tahapan::class, 'perkara_id')->orderBy('tanggal_tahapan', 'asc');
    }

    /**
     * RELASI: Satu Perkara ditangani oleh satu Jaksa (JPN)
     * Menghubungkan kolom jaksa_id ke tabel jaksas agar nama Jaksa muncul di Dashboard
     */
    public function jaksa()
    {
        return $this->belongsTo(Jaksa::class, 'jaksa_id');
    }
}