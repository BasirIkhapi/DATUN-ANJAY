<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi secara massal.
     * NIP dan Role sudah masuk sesuai kebutuhan sistem SIM-DATUN.
     */
    protected $fillable = [
        'name',
        'nip',
        'password',
        'role',
    ];

    /**
     * Atribut yang disembunyikan saat serialisasi (keamanan).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting atribut.
     * Kita tetap simpan email_verified_at jika suatu saat kolom email diaktifkan lagi.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * HELPER: Cek Role Admin
     * Digunakan di Controller atau Middleware: if(auth()->user()->isAdmin())
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * HELPER: Cek Role Staff
     */
    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }
}
