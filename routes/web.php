<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PerkaraController;
use App\Http\Controllers\JaksaController;
use App\Http\Controllers\MonitoringController; // Jika kamu memisah monitoring ke controller sendiri
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - SIM-DATUN KEJAKSAAN
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
    
    // Rute Cetak Rekapitulasi (Tombol Merah di Dashboard)
    Route::get('/dashboard/rekap', [DashboardController::class, 'cetakRekap'])->name('admin.perkara.rekap');

    
    // --- MANAJEMEN PERKARA ---
    Route::get('/perkara/create', [PerkaraController::class, 'create'])->name('perkara.create');
    Route::post('/perkara/store', [PerkaraController::class, 'store'])->name('perkara.store');
    Route::delete('/perkara/{id}', [PerkaraController::class, 'destroy'])->name('perkara.destroy');
    
    // PERBAIKAN: Menggunakan PATCH untuk update status ke Selesai
    Route::patch('/perkara/{id}/status', [PerkaraController::class, 'updateStatus'])->name('perkara.updateStatus');

    
    // --- MONITORING & TAHAPAN PERKARA ---
    // Sinkronisasi dengan tombol monitor di dashboard
    Route::get('/perkara/monitoring/{id}', [PerkaraController::class, 'monitoring'])->name('perkara.monitoring');
    
    // Menyimpan tahapan sidang baru
    // Catatan: Jika kamu menggunakan PerkaraController untuk storeTahapan, ganti MonitoringController menjadi PerkaraController
    Route::post('/perkara/tahapan', [MonitoringController::class, 'storeTahapan'])->name('tahapan.store');
    
    // Pastikan diarahkan ke MonitoringController
    Route::get('/perkara/monitoring/{id}/cetak', [MonitoringController::class, 'cetakPDF'])->name('perkara.cetak');

    
    // --- LAPORAN PDF STATISTIK & ARSIP ---
    Route::get('/perkara/statistik', [PerkaraController::class, 'cetakStatistik'])->name('perkara.statistik');
    Route::get('/perkara/arsip', [PerkaraController::class, 'cetakArsip'])->name('perkara.arsip');


    // --- MANAJEMEN JAKSA (JPN) ---
    Route::get('/jaksa', [JaksaController::class, 'index'])->name('jaksa.index');
    Route::get('/jaksa/create', [JaksaController::class, 'create'])->name('jaksa.create');
    Route::post('/jaksa/store', [JaksaController::class, 'store'])->name('jaksa.store');
    Route::get('/jaksa/cetak', [JaksaController::class, 'cetakJaksa'])->name('jaksa.cetak');
    Route::delete('/jaksa/{id}', [JaksaController::class, 'destroy'])->name('jaksa.destroy');


    // --- PROFIL USER ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';