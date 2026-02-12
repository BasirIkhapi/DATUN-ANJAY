<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PerkaraController;
use App\Http\Controllers\JaksaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Models\ActivityLog;

// Halaman awal aplikasi
Route::get('/', function () {
    return view('welcome');
});

// Grup yang wajib Login (Authenticated)
Route::middleware(['auth'])->group(function () {

    // --- DASHBOARD (Akses Semua Role) ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- 1. MANAJEMEN PERKARA ---
    Route::prefix('perkara')->group(function () {
        // Monitoring Utama (Semua Role bisa lihat)
        Route::get('/', [PerkaraController::class, 'index'])->name('perkara.index');
        Route::get('/show/{id}', [PerkaraController::class, 'show'])->name('perkara.show');

        // AKSES KHUSUS STAFF: HANYA VERIFIKASI (VALIDATOR)
        Route::middleware(['can:access-staff'])->group(function () {
            // Staff memverifikasi (PATCH) hasil input Admin
            Route::patch('/verifikasi/{id}', [PerkaraController::class, 'verifikasi'])->name('perkara.verifikasi');
        });

        // AKSES KHUSUS ADMIN: REGISTRASI & OPERASIONAL PROGRES (OPERATOR)
        Route::middleware(['can:access-admin'])->group(function () {
            Route::get('/create', [PerkaraController::class, 'create'])->name('perkara.create');
            Route::post('/store', [PerkaraController::class, 'store'])->name('perkara.store');

            // Admin mengunggah/memperbarui berkas SKK
            Route::post('/upload-skk/{id}', [PerkaraController::class, 'uploadSKK'])->name('perkara.upload-skk');

            // Admin menginput progres sidang (Pindahan otoritas dari Staff)
            Route::post('/store-tahapan', [PerkaraController::class, 'storeTahapan'])->name('perkara.storeTahapan');

            Route::get('/edit/{id}', [PerkaraController::class, 'edit'])->name('perkara.edit');
            Route::patch('/update/{id}', [PerkaraController::class, 'update'])->name('perkara.update');
            Route::delete('/destroy/{id}', [PerkaraController::class, 'destroy'])->name('perkara.destroy');
        });

        // PRINTING INDIVIDUAL (Akses Staff & Admin)
        Route::get('/cetak-detail/{id}', [PerkaraController::class, 'cetakDetail'])->name('perkara.cetakDetail');
        Route::get('/cetak-label/{id}', [PerkaraController::class, 'cetakLabel'])->name('perkara.cetakLabel');
    });

    // --- 2. PUSAT DATA & ARSIP ---
    Route::prefix('arsip')->group(function () {
        // View Utama Arsip (Bisa diakses Staff & Admin)
        Route::get('/', [PerkaraController::class, 'pusatArsip'])->name('perkara.arsip.index');

        // LAPORAN REKAP (Akses Staff & Admin)
        Route::get('/rekap-arsip', [PerkaraController::class, 'cetakArsip'])->name('perkara.arsip.cetakArsip');

        // LAPORAN STRATEGIS (Eksklusif Admin / Kasi)
        Route::middleware(['can:access-admin'])->group(function () {
            Route::get('/stagnansi', [PerkaraController::class, 'cetakStagnansi'])->name('perkara.arsip.stagnansi');
            Route::get('/kinerja', [PerkaraController::class, 'cetakKinerja'])->name('perkara.arsip.kinerja');
            Route::get('/durasi', [PerkaraController::class, 'cetakDurasi'])->name('perkara.arsip.durasi');
            Route::get('/statistik', [PerkaraController::class, 'cetakStatistik'])->name('perkara.arsip.statistik');
        });
    });

    // --- 3. KONTROL DATA MASTER (Khusus Admin) ---
    Route::middleware(['can:access-admin'])->group(function () {
        // DATA JAKSA
        Route::get('/jaksa', [JaksaController::class, 'index'])->name('jaksa.index');
        Route::post('/jaksa', [JaksaController::class, 'store'])->name('jaksa.store');
        Route::delete('/jaksa/{id}', [JaksaController::class, 'destroy'])->name('jaksa.destroy');
        Route::get('/jaksa/cetak', [JaksaController::class, 'cetak'])->name('jaksa.cetak');

        // MANAJEMEN USER
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

        // LOG AUDIT
        Route::get('/logs', function () {
            $logs = ActivityLog::with('user')->latest()->paginate(20);
            return view('admin.logs.index', compact('logs'));
        })->name('logs.index');
    });

    // --- 4. PROFILE ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
