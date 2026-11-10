<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// modul 6
use Illuminate\Support\Facades\Gate;
use App\Models\User;
// end modul 6

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
    // modul 6
    public function boot(): void
    {
        // Gate: Hanya user dengan role 'admin' atau 'petugas' yang diizinkan mengelola buku
        Gate::define('kelola-buku', function (User $user) {
            return $user->hasRole(['admin', 'petugas']);
        });
    }
    // end modul 6
}
