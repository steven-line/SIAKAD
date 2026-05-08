<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        Schema::defaultStringLength(191); // 🔥 FIX ERROR MYSQL
        Gate::define('admin', function(User $user){
            return $user->isAdmin() ? Response::allow() : Response::denyAsNotFound();
        }); 
        Gate::define('kaprodi', function(User $user){
            return $user->isKaprodi() ? Response::allow() : Response::denyAsNotFound();
        });

        Gate::define('mahasiswa', function(User $user){
            return $user->isMahasiswa() ? Response::allow() : Response::denyAsNotFound();
        });


        Gate::define('dosen_wali', function(User $user){
            return $user->isDosen() ? Response::allow() : Response::denyAsNotFound();
        });
        
    }
}
