<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * DEFINISI OTORITAS: ADMIN (KASI)
         * Mengizinkan akses ke Master Data Jaksa, Manajemen User, dan Registrasi Perkara.
         */
        Gate::define('access-admin', function (User $user) {
            return $user->role === 'admin';
        });

        /**
         * DEFINISI OTORITAS: STAFF
         * Mengizinkan akses ke Operasional Monitoring (Update Progres, Upload SKK).
         */
        Gate::define('access-staff', function (User $user) {
            return $user->role === 'staff';
        });
    }
}
