<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function admin()
    {
        // Estadísticas generales para admin
        $stats = DB::selectOne(<<<SQL
            SELECT 
                (SELECT COUNT(*) FROM CONVOCATORIA WHERE fechainicio <= GETDATE() AND fechafin >= GETDATE()) AS convocatorias_activas,
                (SELECT COUNT(*) FROM POSTULACION WHERE estado = '1') AS postulaciones_pendientes,
                (SELECT COUNT(*) FROM POSTULACION WHERE estado = '2') AS postulaciones_revision,
                (SELECT COUNT(*) FROM PERSONA WHERE tipoe = '1') AS total_estudiantes
        SQL);

        return view('admin.dashboard', compact('stats'));
    }

    public function estudiante()
    {
        // Obtener becas disponibles (con convocatorias activas)
        $becas = DB::select(<<<SQL
            SELECT 
                tb.idtipobeca,
                tb.nombre AS nombre_beca,
                tb.descripcion,
                COUNT(DISTINCT c.idconvocatoria) AS convocatorias_activas,
                MIN(c.fechainicio) AS fecha_inicio,
                MAX(c.fechafin) AS fecha_fin
            FROM TIPOBECA tb
            INNER JOIN CONVOCATORIA c ON c.idtipobeca = tb.idtipobeca 
                AND c.fechainicio <= GETDATE() 
                AND c.fechafin >= GETDATE()
            GROUP BY tb.idtipobeca, tb.nombre, tb.descripcion
            ORDER BY tb.nombre
        SQL);

        return view('estudiante.dashboard', compact('becas'));
    }
}
