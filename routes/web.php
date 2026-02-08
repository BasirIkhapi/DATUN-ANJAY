<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PerkaraController;
use App\Http\Controllers\JaksaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - SIM-DATUN KEJAKSAAN NEGERI BANJARMASIN
|--------------------------------------------------------------------------
*/

// Halaman Utama (Landing Page)
Route::get('/', function () {
    return view('welcome');
});

// Grup Route yang Membutuhkan Login (Auth) & Verifikasi Email
Route::middleware(['auth', 'verified'])->group(function () {

    // --- 1. DASHBOARD UTAMA ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- 2. MENU PANTAUAN PERKARA (Operasional Harian) ---
    Route::prefix('perkara')->group(function () {
        // Halaman Utama Tabel Pantauan
        Route::get('/monitoring', [PerkaraController::class, 'index'])->name('perkara.index');

        // Form & Proses Registrasi (Sekarang via Modal)
        Route::post('/store', [PerkaraController::class, 'store'])->name('perkara.store');

        // Proses Input Progres/Tahapan (Via Modal)
        // Mendukung logic toggle 'set_selesai' di Controller
        Route::post('/tahapan', [PerkaraController::class, 'storeTahapan'])->name('perkara.storeTahapan');

        // Aksi Update Status Manual & Hapus Data
        Route::patch('/{id}/status', [PerkaraController::class, 'updateStatus'])->name('perkara.updateStatus');
        Route::delete('/{id}', [PerkaraController::class, 'destroy'])->name('perkara.destroy');

        // Detail Individu
        Route::get('/monitoring/{id}', [PerkaraController::class, 'show'])->name('perkara.show');
    });

    // --- 3. PUSAT DATA & ARSIP (Dokumentasi & 4 Laporan Analitis) ---
    Route::prefix('arsip')->group(function () {
        // Halaman Utama Pusat Arsip
        Route::get('/', [PerkaraController::class, 'pusatArsip'])->name('perkara.arsip.index');

        // [A] CETAK STANDAR (Output Data Mentah)
        Route::get('/{id}/cetak-detail', [PerkaraController::class, 'cetakDetail'])->name('perkara.cetakDetail');
        Route::get('/cetak-rekapitulasi', [DashboardController::class, 'cetakRekap'])->name('admin.perkara.rekap');
        Route::get('/cetak-periode', [PerkaraController::class, 'cetakPeriode'])->name('perkara.cetakPeriode');
        Route::get('/cetak-statistik', [PerkaraController::class, 'cetakStatistik'])->name('perkara.statistik');

        // [B] CETAK ANALITIS (Output Hasil Pengolahan & Business Intelligence)
        // 1. Laporan Kinerja JPN (Rasio Keberhasilan)
        Route::get('/cetak-kinerja-jpn', [PerkaraController::class, 'cetakKinerjaJPN'])->name('perkara.arsip.kinerja');

        // 2. Laporan Durasi Penanganan (Aging Report - Kecepatan Kerja)
        Route::get('/cetak-durasi', [PerkaraController::class, 'cetakDurasi'])->name('perkara.arsip.durasi');

        // 3. Laporan Evaluasi Stagnansi (Hambatan/Macet > 14 Hari)
        Route::get('/cetak-stagnansi', [PerkaraController::class, 'cetakStagnansi'])->name('perkara.arsip.stagnansi');

        // 4. Rekap Arsip Selesai (Daftar Seluruh Perkara Inkracht) - CARD HITAM
        Route::get('/cetak-arsip-selesai', [PerkaraController::class, 'cetakArsip'])->name('perkara.arsip.cetakArsip');
    });

    // --- 4. MANAJEMEN DATA JAKSA (JPN) ---
    Route::prefix('jaksa')->group(function () {
        Route::get('/', [JaksaController::class, 'index'])->name('jaksa.index');
        Route::post('/store', [JaksaController::class, 'store'])->name('jaksa.store');
        Route::get('/cetak', [JaksaController::class, 'cetakJaksa'])->name('jaksa.cetak');
        Route::delete('/{id}', [JaksaController::class, 'destroy'])->name('jaksa.destroy');
    });

    // --- 5. PENGATURAN PROFIL ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
