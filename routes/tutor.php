<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TutorPerfilController;
use App\Http\Controllers\TutorDashboardController;
use App\Http\Controllers\TutorHijoController;
use App\Http\Controllers\TutorMensualidadController;
use App\Http\Controllers\TutorBecaController;

/*
|--------------------------------------------------------------------------
| Rutas del Tutor
|--------------------------------------------------------------------------
| Los middlewares 'web', 'sqlauth' y 'tutor' ya están aplicados en bootstrap/app.php
*/

// Redirigir /tutor a /tutor/dashboard
Route::get('/', function () {
    return redirect()->route('tutor.dashboard');
});

// Dashboard
Route::get('/dashboard', [TutorDashboardController::class, 'index'])->name('dashboard');

// Perfil
Route::prefix('perfil')->name('perfil.')->group(function () {
    Route::get('/', [TutorPerfilController::class, 'index'])->name('index');
    Route::put('/correo', [TutorPerfilController::class, 'updateCorreo'])->name('correo');
    Route::put('/password', [TutorPerfilController::class, 'updatePassword'])->name('password');
});

// Módulo de Hijos
Route::prefix('hijos')->name('hijos.')->group(function () {
    Route::get('/', [TutorHijoController::class, 'index'])->name('index');
    Route::get('/{ci}', [TutorHijoController::class, 'show'])->name('show');
});

// Módulo de Mensualidades
Route::prefix('mensualidad')->name('mensualidad.')->group(function () {
    Route::get('/', [TutorMensualidadController::class, 'index'])->name('index');
    Route::get('/{id}', [TutorMensualidadController::class, 'show'])->name('show');
});

// Módulo de Becas
Route::prefix('beca')->name('beca.')->group(function () {
    Route::get('/', [TutorBecaController::class, 'index'])->name('index');
    Route::get('/{codbeca}', [TutorBecaController::class, 'show'])->name('show');
});
