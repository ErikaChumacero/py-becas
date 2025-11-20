<?php

namespace App\Providers;

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
        // Compartir información del usuario con todas las vistas
        view()->composer('*', function ($view) {
            $usuario = session('usuario');
            $view->with('usuario', $usuario);
        });
    }
}
