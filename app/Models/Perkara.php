<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Perkara extends Model
{
    use HasFactory;

    /**
     * Mass Assignment.
     * Disesuaikan untuk menampung data dari Admin (registrasi) 
     * dan Staff (verifikasi & e-doc).
     */
    protected $fillable = [
        'nomor_perkara',
        'jaksa_id',
        'penggugat',
        'tergugat',
        'jenis_perkara',
        'tanggal_masuk',
        'status_akhir',
        'file_skk',
        'is_verified',
        'alasan_penolakan', // Tambahkan ini
        'file_putusan'
    ];

    /**
     * POIN 4: Otomatisasi Cek Stagnansi
     * Menghitung jumlah hari sejak update terakhir.
     */
    public function getHariStagnanAttribute()
    {
        // Perkara Selesai tidak dihitung stagnansinya
        if ($this->status_akhir === 'Selesai') {
            return 0;
        }

        // Ambil tanggal update terakhir dari tahapan (tanggal_tahapan)
        // Jika belum ada tahapan, gunakan tanggal_masuk perkara
        $lastUpdate = $this->tahapans->max('tanggal_tahapan') ?? $this->tanggal_masuk;

        return Carbon::parse($lastUpdate)->diffInDays(now());
    }

    /**
     * Mengecek apakah perkara macet > 14 hari tanpa update.
     */
    public function getIsStagnanAttribute()
    {
        return $this->hari_stagnan > 14 && $this->status_akhir === 'Proses';
    }

    /**
     * Relasi ke model Jaksa (JPN).
     */
    public function jaksa()
    {
        return $this->belongsTo(Jaksa::class);
    }

    /**
     * POIN 3: Relasi ke Tahapan (Kronologis)
     */
    public function tahapans()
    {
        return $this->hasMany(Tahapan::class, 'perkara_id');
    }

    /**
     * POIN 5: Menghitung Total Durasi Penanganan (Untuk Akurasi Laporan)
     */
    public function getDurasiTotalAttribute()
    {
        $awal = Carbon::parse($this->tanggal_masuk);

        // Jika sudah selesai, hitung sampai tanggal update terakhir (tahapan putusan)
        // Jika masih proses, hitung sampai hari ini
        $akhir = $this->status_akhir === 'Selesai'
            ? Carbon::parse($this->tahapans->max('tanggal_tahapan') ?? $this->updated_at)
            : now();

        return $awal->diffInDays($akhir);
    }
}
