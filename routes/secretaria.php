<?php

use App\Http\Controllers\SecretariaDashboardController;
use App\Http\Controllers\SecretariaPerfilController;
use App\Http\Controllers\SecretariaPersonaController;
use App\Http\Controllers\SecretariaInscripcionController;
use App\Http\Controllers\SecretariaMensualidadController;
use App\Http\Controllers\SecretariaBecaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas de Secretaría
|--------------------------------------------------------------------------
|
| Panel INDEPENDIENTE para el rol de Secretaría
| Los módulos se irán agregando uno por uno con controladores específicos
| y permisos adecuados para el rol de secretaria
|
*/

// Dashboard de Secretaría
Route::get('/dashboard', [SecretariaDashboardController::class, 'index'])->name('dashboard');

// Perfil de Secretaría
Route::prefix('perfil')->name('perfil.')->group(function () {
    Route::get('/', [SecretariaPerfilController::class, 'index'])->name('index');
    Route::put('/correo', [SecretariaPerfilController::class, 'updateCorreo'])->name('correo');
    Route::put('/password', [SecretariaPerfilController::class, 'updatePassword'])->name('password');
});

// ============================================
// MÓDULOS DE SECRETARÍA
// ============================================

// Módulo de Personas (Estudiantes y Tutores)
Route::prefix('persona')->name('persona.')->group(function () {
    Route::get('/', [SecretariaPersonaController::class, 'index'])->name('index');
    Route::get('/create', [SecretariaPersonaController::class, 'create'])->name('create');
    Route::post('/', [SecretariaPersonaController::class, 'store'])->name('store');
    Route::get('/{ci}/show', [SecretariaPersonaController::class, 'show'])->name('show');
    Route::get('/{ci}/edit', [SecretariaPersonaController::class, 'edit'])->name('edit');
    Route::put('/{ci}', [SecretariaPersonaController::class, 'update'])->name('update');
    Route::post('/{ci}/restablecer', [SecretariaPersonaController::class, 'restablecer'])->name('restablecer');
    Route::get('/{ci}/vincular', [SecretariaPersonaController::class, 'vincular'])->name('vincular');
    Route::post('/tutor/crear', [SecretariaPersonaController::class, 'crearTutor'])->name('tutor.crear');
});

// Módulo de Inscripciones
Route::prefix('inscripcion')->name('inscripcion.')->group(function () {
    Route::get('/', [SecretariaInscripcionController::class, 'index'])->name('index');
    Route::get('/create', [SecretariaInscripcionController::class, 'create'])->name('create');
    Route::post('/', [SecretariaInscripcionController::class, 'store'])->name('store');
    Route::get('/{ci}/{idcurso}/{idnivel}/edit', [SecretariaInscripcionController::class, 'edit'])->name('edit');
    Route::put('/{ci}/{idcurso}/{idnivel}', [SecretariaInscripcionController::class, 'update'])->name('update');
    Route::delete('/{ci}/{idcurso}/{idnivel}', [SecretariaInscripcionController::class, 'destroy'])->name('destroy');
    Route::get('/tutor/{ci}', [SecretariaInscripcionController::class, 'getTutor'])->name('getTutor');
});

// Módulo de Mensualidades
Route::prefix('mensualidad')->name('mensualidad.')->group(function () {
    Route::get('/', [SecretariaMensualidadController::class, 'index'])->name('index');
    Route::get('/create', [SecretariaMensualidadController::class, 'create'])->name('create');
    Route::post('/', [SecretariaMensualidadController::class, 'store'])->name('store');
    Route::get('/{id}', [SecretariaMensualidadController::class, 'show'])->name('show');
    Route::put('/{id}/observacion', [SecretariaMensualidadController::class, 'updateObservacion'])->name('observacion');
    Route::get('/inscripcion/{ci}', [SecretariaMensualidadController::class, 'getInscripcion'])->name('getInscripcion');
    Route::post('/calcular-monto', [SecretariaMensualidadController::class, 'calcularMonto'])->name('calcularMonto');
});

// Módulo de Becas
Route::prefix('beca')->name('beca.')->group(function () {
    Route::get('/', [SecretariaBecaController::class, 'index'])->name('index');
    Route::get('/create', [SecretariaBecaController::class, 'create'])->name('create');
    Route::post('/', [SecretariaBecaController::class, 'store'])->name('store');
    Route::get('/automaticas', [SecretariaBecaController::class, 'automaticas'])->name('automaticas');
    Route::post('/ejecutar-automaticas', [SecretariaBecaController::class, 'ejecutarAutomaticas'])->name('ejecutarAutomaticas');
    Route::post('/quitar', [SecretariaBecaController::class, 'quitar'])->name('quitar');
    Route::get('/{codbeca}', [SecretariaBecaController::class, 'show'])->name('show');
});

// TODO: Agregar más módulos según necesidades
