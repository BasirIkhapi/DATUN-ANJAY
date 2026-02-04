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
    // Menampilkan statistik perkara dan tabel pantauan real-time
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Rute Cetak Rekapitulasi Umum (Mendukung Filter Tanggal)
    Route::get('/dashboard/rekap', [DashboardController::class, 'cetakRekap'])->name('admin.perkara.rekap');

    // --- MANAJEMEN PERKARA & MONITORING ---
    // 1. Halaman Index: Menampilkan Tabel Daftar Semua Perkara
    Route::get('/perkara/monitoring', [PerkaraController::class, 'index'])->name('perkara.index');
    
    // 2. Halaman Show: Menampilkan Detail & Timeline Individu
    Route::get('/perkara/monitoring/{id}', [PerkaraController::class, 'show'])->name('perkara.show');

    // 3. FITUR CETAK PROGRES: Perbaikan nama route agar tidak error
    Route::get('/perkara/monitoring/{id}/cetak', [PerkaraController::class, 'cetakDetail'])->name('perkara.cetakDetail');

    // 4. Tambah Data Perkara Baru
    Route::get('/perkara/create', [PerkaraController::class, 'create'])->name('perkara.create');
    Route::post('/perkara/store', [PerkaraController::class, 'store'])->name('perkara.store');
    
    // 5. Update Status ke Selesai & Hapus Data
    Route::patch('/perkara/{id}/status', [PerkaraController::class, 'updateStatus'])->name('perkara.updateStatus');
    Route::delete('/perkara/{id}', [PerkaraController::class, 'destroy'])->name('perkara.destroy');

    // --- TAHAPAN PERKARA (TIMELINE) ---
    // Untuk menyimpan input sidang baru di halaman detail perkara
    Route::post('/perkara/tahapan', [PerkaraController::class, 'storeTahapan'])->name('perkara.storeTahapan');

    // --- LAPORAN & ARSIP MASAL (Format PDF Resmi) ---
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

require __DIR__.'/auth.php';