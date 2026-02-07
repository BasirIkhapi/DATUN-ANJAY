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

// Halaman Utama (Welcome)
Route::get('/', function () {
    return view('welcome');
});

// Grup Route yang Membutuhkan Login (Auth)
Route::middleware(['auth', 'verified'])->group(function () {

    // --- 1. DASHBOARD UTAMA ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/rekap', [DashboardController::class, 'cetakRekap'])->name('admin.perkara.rekap');

    // --- 2. MENU PANTAUAN PERKARA (PINDAHAN DARI DASHBOARD) ---
    Route::prefix('perkara')->group(function () {
        // Halaman Utama Pantauan Perkara
        Route::get('/monitoring', [PerkaraController::class, 'index'])->name('perkara.index');

        // Detail & Timeline Individu
        Route::get('/monitoring/{id}', [PerkaraController::class, 'show'])->name('perkara.show');

        // Form Tambah Perkara Baru
        Route::get('/create', [PerkaraController::class, 'create'])->name('perkara.create');
        Route::post('/store', [PerkaraController::class, 'store'])->name('perkara.store');

        // Update Status, Tahapan (Timeline), & Hapus Data
        Route::patch('/{id}/status', [PerkaraController::class, 'updateStatus'])->name('perkara.updateStatus');
        Route::post('/tahapan', [PerkaraController::class, 'storeTahapan'])->name('perkara.storeTahapan');
        Route::delete('/{id}', [PerkaraController::class, 'destroy'])->name('perkara.destroy');

        // FITUR CETAK & LAPORAN
        Route::get('/monitoring/{id}/cetak', [PerkaraController::class, 'cetakDetail'])->name('perkara.cetakDetail');
        Route::get('/cetak-periode', [PerkaraController::class, 'cetakPeriode'])->name('perkara.cetakPeriode');
        Route::get('/statistik/cetak', [PerkaraController::class, 'cetakStatistik'])->name('perkara.statistik');
        Route::get('/arsip/cetak', [PerkaraController::class, 'cetakArsip'])->name('perkara.arsip');
    });

    // --- 3. MANAJEMEN JAKSA (JPN) ---
    Route::prefix('jaksa')->group(function () {
        Route::get('/', [JaksaController::class, 'index'])->name('jaksa.index');
        Route::post('/store', [JaksaController::class, 'store'])->name('jaksa.store');
        Route::get('/cetak', [JaksaController::class, 'cetakJaksa'])->name('jaksa.cetak');
        Route::delete('/{id}', [JaksaController::class, 'destroy'])->name('jaksa.destroy');
    });

    // --- 4. PROFIL USER ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
