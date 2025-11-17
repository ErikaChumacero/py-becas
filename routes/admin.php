<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ConvocatoriaController;
// use App\Http\Controllers\CarreraController; // Controlador no existe
// use App\Http\Controllers\SemestreController; // Controlador no existe
use App\Http\Controllers\PostulacionController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\HistorialEstadoController;
use App\Http\Controllers\TipoBecaController;
use App\Http\Controllers\RequisitoController;
use App\Http\Controllers\AdminPerfilController;
use App\Http\Controllers\GestionController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\NivelController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\BecaController;
use App\Http\Controllers\MensualidadController;
use App\Http\Controllers\MaestroMaterController;
use App\Http\Controllers\DetalleMensualidadController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'admin'])->name('dashboard');

// Perfil del Administrador
Route::prefix('perfil')->name('perfil.')->group(function () {
    Route::get('index', [AdminPerfilController::class, 'index'])->name('index');
    Route::put('correo', [AdminPerfilController::class, 'updateCorreo'])->name('correo');
    Route::put('password', [AdminPerfilController::class, 'updatePassword'])->name('password');
});


// Persona
Route::prefix('persona')->group(function () {
    Route::get('index', [PersonaController::class, 'index'])->name('persona.index');
    Route::get('create', [PersonaController::class, 'create'])->name('persona.create');
    Route::post('store', [PersonaController::class, 'store'])->name('persona.store');
    Route::get('edit/{id}', [PersonaController::class, 'edit'])->name('persona.edit');
    Route::put('edit/{id}', [PersonaController::class, 'update'])->name('persona.update');
    Route::delete('index/{id}', [PersonaController::class, 'destroy'])->name('persona.destroy');
});

// Carrera - DESHABILITADO (Controlador no existe)
// Route::prefix('carrera')->group(function () {
//     Route::get('index', [CarreraController::class, 'index'])->name('carrera.index');
//     Route::get('create', [CarreraController::class, 'create'])->name('carrera.create');
//     Route::post('store', [CarreraController::class, 'store'])->name('carrera.store');
//     Route::get('edit/{idcarrera}', [CarreraController::class, 'edit'])->name('carrera.edit');
//     Route::put('edit/{idcarrera}', [CarreraController::class, 'update'])->name('carrera.update');
// });

// Convocatoria
Route::prefix('convocatoria')->group(function () {
    Route::get('index', [ConvocatoriaController::class, 'index'])->name('convocatoria.index');
    Route::get('create', [ConvocatoriaController::class, 'create'])->name('convocatoria.create');
    Route::post('store', [ConvocatoriaController::class, 'store'])->name('convocatoria.store');
    Route::get('edit/{idconvocatoria}', [ConvocatoriaController::class, 'edit'])->name('convocatoria.edit');
    Route::put('edit/{idconvocatoria}', [ConvocatoriaController::class, 'update'])->name('convocatoria.update');
    Route::post('disable/{idconvocatoria}', [ConvocatoriaController::class, 'disable'])->name('convocatoria.disable');
});

// Semestre - DESHABILITADO (Controlador no existe)
// Route::prefix('semestre')->group(function () {
//     Route::get('index', [SemestreController::class, 'index'])->name('semestre.index');
//     Route::get('create', [SemestreController::class, 'create'])->name('semestre.create');
//     Route::post('store', [SemestreController::class, 'store'])->name('semestre.store');
//     Route::get('edit/{id}', [SemestreController::class, 'edit'])->name('semestre.edit');
//     Route::put('edit/{id}', [SemestreController::class, 'update'])->name('semestre.update');
// });

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

// Gestión
Route::prefix('gestion')->group(function () {
    Route::get('index', [GestionController::class, 'index'])->name('gestion.index');
    Route::get('create', [GestionController::class, 'create'])->name('gestion.create');
    Route::post('store', [GestionController::class, 'store'])->name('gestion.store');
    Route::get('edit/{id}', [GestionController::class, 'edit'])->name('gestion.edit');
    Route::put('edit/{id}', [GestionController::class, 'update'])->name('gestion.update');
    // Acciones de estado
    Route::post('abrir/{id}', [GestionController::class, 'abrir'])->name('gestion.abrir');
    Route::post('cerrar/{id}', [GestionController::class, 'cerrar'])->name('gestion.cerrar');
    Route::post('cerrar-vencidas', [GestionController::class, 'cerrarVencidas'])->name('gestion.cerrarvencidas');
});

// Materia
Route::prefix('materia')->group(function () {
    Route::get('index', [MateriaController::class, 'index'])->name('materia.index');
    Route::get('create', [MateriaController::class, 'create'])->name('materia.create');
    Route::post('store', [MateriaController::class, 'store'])->name('materia.store');
    Route::get('edit/{id}', [MateriaController::class, 'edit'])->name('materia.edit');
    Route::put('edit/{id}', [MateriaController::class, 'update'])->name('materia.update');
});

// Nivel
Route::prefix('nivel')->group(function () {
    Route::get('index', [NivelController::class, 'index'])->name('nivel.index');
    Route::get('create', [NivelController::class, 'create'])->name('nivel.create');
    Route::post('store', [NivelController::class, 'store'])->name('nivel.store');
    Route::get('edit/{id}', [NivelController::class, 'edit'])->name('nivel.edit');
    Route::put('edit/{id}', [NivelController::class, 'update'])->name('nivel.update');
});

// Curso (dentro de Nivel - relación de composición)
Route::prefix('nivel/{idnivel}/curso')->group(function () {
    Route::get('index', [CursoController::class, 'index'])->name('curso.index');
    Route::get('create', [CursoController::class, 'create'])->name('curso.create');
    Route::post('store', [CursoController::class, 'store'])->name('curso.store');
    Route::get('edit/{idcurso}', [CursoController::class, 'edit'])->name('curso.edit');
    Route::put('edit/{idcurso}', [CursoController::class, 'update'])->name('curso.update');
});

// Inscripción
Route::prefix('inscripcion')->group(function () {
    Route::get('index', [InscripcionController::class, 'index'])->name('inscripcion.index');
    Route::get('create', [InscripcionController::class, 'create'])->name('inscripcion.create');
    Route::post('store', [InscripcionController::class, 'store'])->name('inscripcion.store');
    Route::get('edit/{ci}/{idcurso}/{idnivel}', [InscripcionController::class, 'edit'])->name('inscripcion.edit');
    Route::put('edit/{ci}/{idcurso}/{idnivel}', [InscripcionController::class, 'update'])->name('inscripcion.update');
    Route::post('quitar-beca/{ci}/{idgestion}', [InscripcionController::class, 'quitarBeca'])->name('inscripcion.quitarbeca');
});

// Beca
Route::prefix('beca')->group(function () {
    Route::get('index', [BecaController::class, 'index'])->name('beca.index');
    Route::get('create', [BecaController::class, 'create'])->name('beca.create');
    Route::post('store', [BecaController::class, 'store'])->name('beca.store');
    Route::get('edit/{id}', [BecaController::class, 'edit'])->name('beca.edit');
    Route::put('edit/{id}', [BecaController::class, 'update'])->name('beca.update');
    Route::post('ejecutar-automaticas', [BecaController::class, 'ejecutarBecasAutomaticas'])->name('beca.automaticas');
});

// Detalle Mensualidad
Route::prefix('detallemensualidad')->group(function () {
    Route::get('index', [DetalleMensualidadController::class, 'index'])->name('detallemensualidad.index');
    Route::get('create', [DetalleMensualidadController::class, 'create'])->name('detallemensualidad.create');
    Route::post('store', [DetalleMensualidadController::class, 'store'])->name('detallemensualidad.store');
    Route::get('edit/{id}', [DetalleMensualidadController::class, 'edit'])->name('detallemensualidad.edit');
    Route::put('edit/{id}', [DetalleMensualidadController::class, 'update'])->name('detallemensualidad.update');
});

// Mensualidad
Route::prefix('mensualidad')->group(function () {
    Route::get('index', [MensualidadController::class, 'index'])->name('mensualidad.index');
    Route::get('create', [MensualidadController::class, 'create'])->name('mensualidad.create');
    Route::post('store', [MensualidadController::class, 'store'])->name('mensualidad.store');
    Route::get('show/{id}', [MensualidadController::class, 'show'])->name('mensualidad.show');
    Route::get('edit/{id}', [MensualidadController::class, 'edit'])->name('mensualidad.edit');
    Route::put('edit/{id}', [MensualidadController::class, 'update'])->name('mensualidad.update');
    Route::delete('destroy/{id}', [MensualidadController::class, 'destroy'])->name('mensualidad.destroy');
});

// MaestroMater (Asignación de Materias a Maestros)
Route::prefix('maestromater')->group(function () {
    Route::get('index', [MaestroMaterController::class, 'index'])->name('maestromater.index');
    Route::get('create', [MaestroMaterController::class, 'create'])->name('maestromater.create');
    Route::post('store', [MaestroMaterController::class, 'store'])->name('maestromater.store');
    Route::get('edit/{ci}/{idmateria}', [MaestroMaterController::class, 'edit'])->name('maestromater.edit');
    Route::put('edit/{ci}/{idmateria}', [MaestroMaterController::class, 'update'])->name('maestromater.update');
    Route::delete('destroy/{ci}/{idmateria}', [MaestroMaterController::class, 'destroy'])->name('maestromater.destroy');
    // API para obtener materias por curso/nivel (AJAX)
    Route::get('materias/{idcurso}/{idnivel}', [MaestroMaterController::class, 'getMateriasByCurso']);
});

