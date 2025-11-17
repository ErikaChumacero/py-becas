<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TutorDashboardController extends Controller
{
    public function index()
    {
        $usuario = session('usuario');
        $ci = $usuario['ci'] ?? null;

        if (!$ci) {
            return redirect()->route('login')->with('error', 'Sesión no válida');
        }

        try {
            // Estadísticas generales (solo de los hijos del tutor)
            $stats = DB::selectOne("
                SELECT 
                    (SELECT COUNT(DISTINCT i.ci) 
                     FROM inscripcion i 
                     WHERE i.citutor = ?) as total_hijos,
                    (SELECT COUNT(*) 
                     FROM mensualidad m 
                     INNER JOIN inscripcion i ON m.ci = i.ci AND m.idcurso = i.idcurso AND m.idnivel = i.idnivel 
                     WHERE i.citutor = ?) as total_mensualidades,
                    (SELECT COUNT(DISTINCT i.ci) 
                     FROM inscripcion i 
                     WHERE i.citutor = ? AND i.codbeca IS NOT NULL) as total_becas,
                    (SELECT COUNT(DISTINCT i.idgestion) 
                     FROM inscripcion i 
                     WHERE i.citutor = ?) as total_gestiones
            ", [$ci, $ci, $ci, $ci]);

            // Hijos inscritos
            $hijos = DB::select("
                SELECT 
                    p.ci,
                    p.nombre,
                    p.apellido,
                    p.codestudiante,
                    g.detalleges as gestion_actual,
                    n.descripcion as nivel,
                    c.descripcion as curso,
                    CASE WHEN i.codbeca IS NOT NULL THEN 'Sí' ELSE 'No' END as tiene_beca
                FROM persona p
                INNER JOIN inscripcion i ON p.ci = i.ci
                INNER JOIN gestion g ON i.idgestion = g.idgestion
                INNER JOIN nivel n ON i.idnivel = n.idnivel
                INNER JOIN curso c ON i.idcurso = c.idcurso AND i.idnivel = c.idnivel
                WHERE i.citutor = ? AND p.tipoe = '1' AND g.estado = '1'
                ORDER BY p.nombre, p.apellido
            ", [$ci]);

            // Últimas mensualidades
            $ultimasMensualidades = DB::select("
                SELECT TOP 5
                    m.idmensualidad,
                    p.nombre + ' ' + p.apellido AS estudiante,
                    dm.descripcion AS mes,
                    dm.montototal AS monto,
                    m.fechamen,
                    m.tipopago
                FROM mensualidad m
                INNER JOIN detallemensualidad dm ON m.iddetallemensualidad = dm.iddetallemensualidad
                INNER JOIN persona p ON m.ci = p.ci
                INNER JOIN inscripcion i ON m.ci = i.ci AND m.idcurso = i.idcurso AND m.idnivel = i.idnivel
                WHERE i.citutor = ?
                ORDER BY m.fechamen DESC
            ", [$ci]);

            return view('tutor.dashboard', compact('stats', 'hijos', 'ultimasMensualidades'));
        } catch (\Exception $e) {
            return view('tutor.dashboard', [
                'stats' => (object)[
                    'total_hijos' => 0,
                    'total_mensualidades' => 0,
                    'total_becas' => 0,
                    'total_gestiones' => 0
                ],
                'hijos' => [],
                'ultimasMensualidades' => []
            ])->with('error', 'Error al cargar las estadísticas: ' . $e->getMessage());
        }
    }
}
