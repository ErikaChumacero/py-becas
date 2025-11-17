<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    $params = DB::select("
        SELECT 
            p.name AS Procedimiento,
            pm.name AS Parametro,
            t.name AS Tipo,
            pm.parameter_id AS Orden
        FROM sys.procedures p
        INNER JOIN sys.parameters pm ON p.object_id = pm.object_id
        INNER JOIN sys.types t ON pm.user_type_id = t.user_type_id
        WHERE p.name = 'sp_InsertarPersona'
        ORDER BY pm.parameter_id
    ");
    
    echo "Parámetros de sp_InsertarPersona:\n";
    echo "Total: " . count($params) . "\n\n";
    
    foreach ($params as $param) {
        echo "{$param->Orden}. {$param->Parametro} ({$param->Tipo})\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
