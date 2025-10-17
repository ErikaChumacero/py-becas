<?php

use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ConvocatoriaController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\SemestreController;
use App\Http\Controllers\PostulacionController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\HistorialEstadoController;
use App\Http\Controllers\TipoBecaController;
use App\Http\Controllers\RequisitoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.dashboard');
})->name('dashboard');


// Persona
Route::prefix('persona')->group(function () {
    Route::get('index', [PersonaController::class, 'index'])->name('persona.index');
    Route::get('create', [PersonaController::class, 'create'])->name('persona.create');
    Route::post('store', [PersonaController::class, 'store'])->name('persona.store');
    Route::get('edit/{id}', [PersonaController::class, 'edit'])->name('persona.edit');
    Route::put('edit/{id}', [PersonaController::class, 'update'])->name('persona.update');
    Route::delete('index/{id}', [PersonaController::class, 'destroy'])->name('persona.destroy');
});

// Carrera
Route::prefix('carrera')->group(function () {
    Route::get('index', [CarreraController::class, 'index'])->name('carrera.index');
    Route::get('create', [CarreraController::class, 'create'])->name('carrera.create');
    Route::post('store', [CarreraController::class, 'store'])->name('carrera.store');
    Route::get('edit/{idcarrera}', [CarreraController::class, 'edit'])->name('carrera.edit');
    Route::put('edit/{idcarrera}', [CarreraController::class, 'update'])->name('carrera.update');
});

// Convocatoria
Route::prefix('convocatoria')->group(function () {
    Route::get('index', [ConvocatoriaController::class, 'index'])->name('convocatoria.index');
    Route::get('create', [ConvocatoriaController::class, 'create'])->name('convocatoria.create');
    Route::post('store', [ConvocatoriaController::class, 'store'])->name('convocatoria.store');
    Route::get('edit/{idconvocatoria}', [ConvocatoriaController::class, 'edit'])->name('convocatoria.edit');
    Route::put('edit/{idconvocatoria}', [ConvocatoriaController::class, 'update'])->name('convocatoria.update');
    Route::post('disable/{idconvocatoria}', [ConvocatoriaController::class, 'disable'])->name('convocatoria.disable');
});

// Semestre
Route::prefix('semestre')->group(function () {
    Route::get('index', [SemestreController::class, 'index'])->name('semestre.index');
    Route::get('create', [SemestreController::class, 'create'])->name('semestre.create');
    Route::post('store', [SemestreController::class, 'store'])->name('semestre.store');
    Route::get('edit/{id}', [SemestreController::class, 'edit'])->name('semestre.edit');
    Route::put('edit/{id}', [SemestreController::class, 'update'])->name('semestre.update');
});

// Postulación
Route::prefix('postulacion')->group(function () {
    Route::get('index', [PostulacionController::class, 'index'])->name('postulacion.index');
    Route::get('create', [PostulacionController::class, 'create'])->name('postulacion.create');
    Route::post('store', [PostulacionController::class, 'store'])->name('postulacion.store');
    Route::get('edit/{id}', [PostulacionController::class, 'edit'])->name('postulacion.edit');
    Route::put('edit/{id}', [PostulacionController::class, 'update'])->name('postulacion.update');
});


// Documento
Route::prefix('documento')->group(function () {
    Route::get('index', [DocumentoController::class, 'index'])->name('documento.index');
    Route::get('create', [DocumentoController::class, 'create'])->name('documento.create');
    Route::post('store', [DocumentoController::class, 'store'])->name('documento.store');
    Route::get('edit/{id}', [DocumentoController::class, 'edit'])->name('documento.edit');
    Route::put('edit/{id}', [DocumentoController::class, 'update'])->name('documento.update');
    Route::post('disable/{id}', [DocumentoController::class, 'disable'])->name('documento.disable');
});

// Historial de Estado
Route::prefix('historial')->group(function () {
    Route::get('index', [HistorialEstadoController::class, 'index'])->name('historial.index');
    Route::get('create', [HistorialEstadoController::class, 'create'])->name('historial.create');
    Route::post('store', [HistorialEstadoController::class, 'store'])->name('historial.store');
    Route::get('edit/{id}', [HistorialEstadoController::class, 'edit'])->name('historial.edit');
    Route::put('edit/{id}', [HistorialEstadoController::class, 'update'])->name('historial.update');
    Route::post('disable/{id}', [HistorialEstadoController::class, 'disable'])->name('historial.disable');
});

// Tipo de Beca
Route::prefix('tipobeca')->group(function () {
    Route::get('index', [TipoBecaController::class, 'index'])->name('tipobeca.index');
    Route::get('create', [TipoBecaController::class, 'create'])->name('tipobeca.create');
    Route::post('store', [TipoBecaController::class, 'store'])->name('tipobeca.store');
    Route::get('edit/{id}', [TipoBecaController::class, 'edit'])->name('tipobeca.edit');
    Route::put('edit/{id}', [TipoBecaController::class, 'update'])->name('tipobeca.update');
});

// Requisito
Route::prefix('requisito')->group(function () {
    Route::get('index', [RequisitoController::class, 'index'])->name('requisito.index');
    Route::get('create', [RequisitoController::class, 'create'])->name('requisito.create');
    Route::post('store', [RequisitoController::class, 'store'])->name('requisito.store');
    Route::get('edit/{id}', [RequisitoController::class, 'edit'])->name('requisito.edit');
    Route::put('edit/{id}', [RequisitoController::class, 'update'])->name('requisito.update');
    Route::post('disable/{id}', [RequisitoController::class, 'disable'])->name('requisito.disable');
});

