<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SecretariaDashboardController extends Controller
{
    public function index()
    {
        try {
            // Estadísticas para secretaría
            $stats = DB::selectOne(<<<SQL
                SELECT 
                    (SELECT COUNT(*) FROM gestion WHERE estado = '1') AS gestiones_activas,
                    (SELECT COUNT(*) FROM inscripcion) AS total_inscripciones,
                    (SELECT COUNT(*) FROM persona WHERE tipoe = '1' AND tipou = '1') AS total_estudiantes,
                    (SELECT COUNT(*) FROM mensualidad) AS total_mensualidades,
                    (SELECT COUNT(*) FROM persona WHERE tipom = '1' AND tipou = '1') AS total_maestros,
                    (SELECT COUNT(*) FROM nivel) AS total_niveles
            SQL);

            // Últimas inscripciones (últimas 5)
            $ultimasInscripciones = DB::select(<<<SQL
                SELECT TOP 5
                    i.ci,
                    i.idcurso,
                    i.idnivel,
                    p.nombre + ' ' + p.apellido AS estudiante,
                    n.descripcion AS nivel,
                    c.descripcion AS curso,
                    i.fecharegis AS fechainscripcion,
                    CASE WHEN i.codbeca IS NOT NULL THEN '1' ELSE '0' END AS estado
                FROM inscripcion i
                INNER JOIN persona p ON i.ci = p.ci
                INNER JOIN nivel n ON i.idnivel = n.idnivel
                INNER JOIN curso c ON i.idcurso = c.idcurso AND i.idnivel = c.idnivel
                ORDER BY i.fecharegis DESC
            SQL);

            // Mensualidades recientes (últimas 5)
            $mensualidadesPendientes = DB::select(<<<SQL
                SELECT TOP 5
                    m.idmensualidad,
                    p.nombre + ' ' + p.apellido AS estudiante,
                    dm.descripcion AS mes,
                    dm.montototal AS monto,
                    m.fechamen AS fechavencimiento,
                    'P' AS estado
                FROM mensualidad m
                INNER JOIN persona p ON m.ci = p.ci
                INNER JOIN detallemensualidad dm ON m.iddetallemensualidad = dm.iddetallemensualidad
                ORDER BY m.fechamen DESC
            SQL);

            return view('secretaria.dashboard', compact('stats', 'ultimasInscripciones', 'mensualidadesPendientes'));
        } catch (\Throwable $e) {
            return view('secretaria.dashboard', [
                'stats' => (object)[
                    'gestiones_activas' => 0,
                    'total_inscripciones' => 0,
                    'total_estudiantes' => 0,
                    'total_mensualidades' => 0,
                    'total_maestros' => 0,
                    'total_niveles' => 0
                ],
                'ultimasInscripciones' => [],
                'mensualidadesPendientes' => []
            ])->with('error', 'Error al cargar las estadísticas.');
        }
    }
}
