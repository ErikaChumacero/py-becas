<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

// Obtener una persona de prueba
$persona = DB::selectOne("SELECT TOP 1 * FROM persona WHERE tipoe = '1'");

if ($persona) {
    echo "=== PERSONA ANTES DEL UPDATE ===\n";
    echo "CI: {$persona->ci}\n";
    echo "Nombre: {$persona->nombre}\n";
    echo "Apellido: {$persona->apellido}\n";
    echo "Teléfono: {$persona->telefono}\n";
    echo "Sexo: {$persona->sexo}\n\n";

    // Intentar actualizar
    echo "=== EJECUTANDO UPDATE ===\n";
    $affected = DB::update("
        UPDATE persona 
        SET nombre = ?, 
            apellido = ?, 
            telefono = ?, 
            sexo = ?
        WHERE ci = ?
    ", [
        'PRUEBA_NOMBRE',
        'PRUEBA_APELLIDO',
        '99999999',
        $persona->sexo,
        $persona->ci
    ]);

    echo "Filas afectadas: {$affected}\n\n";

    // Verificar cambios
    $personaActualizada = DB::selectOne("SELECT * FROM persona WHERE ci = ?", [$persona->ci]);
    
    echo "=== PERSONA DESPUÉS DEL UPDATE ===\n";
    echo "CI: {$personaActualizada->ci}\n";
    echo "Nombre: {$personaActualizada->nombre}\n";
    echo "Apellido: {$personaActualizada->apellido}\n";
    echo "Teléfono: {$personaActualizada->telefono}\n";
    echo "Sexo: {$personaActualizada->sexo}\n\n";

    // Restaurar valores originales
    echo "=== RESTAURANDO VALORES ORIGINALES ===\n";
    DB::update("
        UPDATE persona 
        SET nombre = ?, 
            apellido = ?, 
            telefono = ?
        WHERE ci = ?
    ", [
        $persona->nombre,
        $persona->apellido,
        $persona->telefono,
        $persona->ci
    ]);
    echo "Valores restaurados.\n";
} else {
    echo "No se encontró ninguna persona para probar.\n";
}
