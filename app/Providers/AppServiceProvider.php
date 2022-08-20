<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('admin', function () {
            $user = auth()->user();
            return $user && $user->role == 'admin';
        });
        Blade::if('owner', function () {
            $user = auth()->user();
            return $user && $user->role == 'owner';
        });
        Blade::if('manager', function () {
            $user = auth()->user();
            return $user && ($user->role == 'admin'||$user->role == 'owner');
        });
    }
}
