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

    // --- DASHBOARD UTAMA ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute Cetak Rekapitulasi Umum dari Dashboard
    Route::get('/dashboard/rekap', [DashboardController::class, 'cetakRekap'])->name('admin.perkara.rekap');

    // --- MANAJEMEN PERKARA & MONITORING ---
    // 1. Halaman Index: Menampilkan Tabel Daftar Semua Perkara
    Route::get('/perkara/monitoring', [PerkaraController::class, 'index'])->name('perkara.index');

    // 2. Halaman Show: Menampilkan Detail & Timeline Individu
    Route::get('/perkara/monitoring/{id}', [PerkaraController::class, 'show'])->name('perkara.show');

    // 3. FITUR CETAK (Penting untuk Role Pimpinan)
    // Rute untuk cetak detail satu perkara
    Route::get('/perkara/monitoring/{id}/cetak', [PerkaraController::class, 'cetakDetail'])->name('perkara.cetakDetail');

    // PERBAIKAN: Menambahkan route cetakPeriode yang tadi Error
    Route::get('/perkara/cetak-periode', [PerkaraController::class, 'cetakPeriode'])->name('perkara.cetakPeriode');

    // 4. Tambah Data Perkara Baru
    Route::get('/perkara/create', [PerkaraController::class, 'create'])->name('perkara.create');
    Route::post('/perkara/store', [PerkaraController::class, 'store'])->name('perkara.store');

    // 5. Update Status & Hapus Data
    Route::patch('/perkara/{id}/status', [PerkaraController::class, 'updateStatus'])->name('perkara.updateStatus');
    Route::delete('/perkara/{id}', [PerkaraController::class, 'destroy'])->name('perkara.destroy');

    // --- TAHAPAN PERKARA (TIMELINE) ---
    Route::post('/perkara/tahapan', [PerkaraController::class, 'storeTahapan'])->name('perkara.storeTahapan');

    // --- LAPORAN STATISTIK & ARSIP ---
    Route::get('/perkara/statistik/cetak', [PerkaraController::class, 'cetakStatistik'])->name('perkara.statistik');
    Route::get('/perkara/arsip/cetak', [PerkaraController::class, 'cetakArsip'])->name('perkara.arsip');

    // --- MANAJEMEN JAKSA (JPN) ---
    Route::get('/jaksa', [JaksaController::class, 'index'])->name('jaksa.index');
    Route::post('/jaksa/store', [JaksaController::class, 'store'])->name('jaksa.store');
    Route::get('/jaksa/cetak', [JaksaController::class, 'cetakJaksa'])->name('jaksa.cetak');
    Route::delete('/jaksa/{id}', [JaksaController::class, 'destroy'])->name('jaksa.destroy');

    // --- PROFIL USER ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
