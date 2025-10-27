<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentPostulacionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Ruta de dashboard universal que redirige según el rol en sesión
Route::get('/dashboard', function () {
    $u = session('usuario');
    if ($u && ($u['tipoa'] ?? '0') === '1') {
        return redirect('/admin');
    }
    if ($u && ($u['tipoe'] ?? '0') === '1') {
        return redirect('/estudiante');
    }
    return redirect()->route('login');
})->name('dashboard');

Route::get('/admin', [DashboardController::class, 'admin'])
    ->middleware(['sqlauth', 'admin'])
    ->name('admin.dashboard');

// Rutas de Administración (agrupadas con prefijo y nombre 'admin.')
Route::middleware(['sqlauth','admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(base_path('routes/admin.php'));

Route::get('/estudiante', [DashboardController::class, 'estudiante'])
    ->middleware(['sqlauth', 'estudiante'])
    ->name('estudiante.dashboard');

// Rutas de Estudiante - Postulación
Route::middleware(['sqlauth','estudiante'])->prefix('estudiante')->name('estudiante.')->group(function () {
    Route::prefix('postulacion')->name('postulacion.')->group(function () {
        Route::get('index', [StudentPostulacionController::class, 'index'])->name('index');
        Route::get('create', [StudentPostulacionController::class, 'create'])->name('create');
        Route::post('store', [StudentPostulacionController::class, 'store'])->name('store');
        // Estudiante NO puede editar ni cancelar postulaciones, solo verlas
        // Route::get('edit/{id}', [StudentPostulacionController::class, 'edit'])->name('edit');
        // Route::put('edit/{id}', [StudentPostulacionController::class, 'update'])->name('update');
        // Route::post('cancel/{id}', [StudentPostulacionController::class, 'cancel'])->name('cancel');
    });
    Route::prefix('documento')->name('documento.')->group(function () {
        Route::get('index', [\App\Http\Controllers\StudentDocumentoController::class, 'index'])->name('index');
        Route::get('create', [\App\Http\Controllers\StudentDocumentoController::class, 'create'])->name('create');
        Route::post('store', [\App\Http\Controllers\StudentDocumentoController::class, 'store'])->name('store');
        Route::get('edit/{id}', [\App\Http\Controllers\StudentDocumentoController::class, 'edit'])->name('edit');
        Route::put('edit/{id}', [\App\Http\Controllers\StudentDocumentoController::class, 'update'])->name('update');
        // Route::post('disable/{id}', [\App\Http\Controllers\StudentDocumentoController::class, 'disable'])->name('disable'); // Deshabilitado: solo admin puede deshabilitar
        Route::get('requisitos/{idpostulacion}', [\App\Http\Controllers\StudentDocumentoController::class, 'requisitosByPostulacion'])->name('requisitos');
    });
    Route::prefix('historial')->name('historial.')->group(function () {
        Route::get('index', [\App\Http\Controllers\StudentHistorialEstadoController::class, 'index'])->name('index');
    });
    Route::prefix('convocatoria')->name('convocatoria.')->group(function () {
        Route::get('index', [\App\Http\Controllers\StudentConvocatoriaController::class, 'index'])->name('index');
        Route::get('show/{id}', [\App\Http\Controllers\StudentConvocatoriaController::class, 'show'])->name('show');
    });
    Route::prefix('perfil')->name('perfil.')->group(function () {
        Route::get('index', [\App\Http\Controllers\StudentPerfilController::class, 'index'])->name('index');
        Route::put('correo', [\App\Http\Controllers\StudentPerfilController::class, 'updateCorreo'])->name('correo');
        Route::put('password', [\App\Http\Controllers\StudentPerfilController::class, 'updatePassword'])->name('password');
    });
});

// SQL-only custom auth (USUARIO table)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

