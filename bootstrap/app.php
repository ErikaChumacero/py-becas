<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web', 'sqlauth', 'admin')
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
            
            Route::middleware('web', 'sqlauth', 'secretaria')
                ->prefix('secretaria')
                ->name('secretaria.')
                ->group(base_path('routes/secretaria.php'));
            
            Route::middleware('web', 'sqlauth', 'tutor')
                ->prefix('tutor')
                ->name('tutor.')
                ->group(base_path('routes/tutor.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'sqlauth' => \App\Http\Middleware\SqlAuth::class,
            'admin' => \App\Http\Middleware\AdminAuth::class,
            'estudiante' => \App\Http\Middleware\EstudianteAuth::class,
            'secretaria' => \App\Http\Middleware\SecretariaAuth::class,
            'tutor' => \App\Http\Middleware\TutorAuth::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
