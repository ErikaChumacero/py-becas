<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TutorMensualidadController extends Controller
{
    /**
     * Mostrar todas las mensualidades de los hijos del tutor
     */
    public function index(Request $request)
    {
        $usuario = session('usuario');
        $ci = $usuario['ci'] ?? null;

        if (!$ci) {
            return redirect()->route('login')->with('error', 'Sesión no válida');
        }

        // Filtros
        $filtroEstado = $request->get('estado', 'todas'); // todas, pagadas, pendientes
        $filtroHijo = $request->get('hijo', 'todos');
        $filtroGestion = $request->get('gestion', 'todas');

        try {
            // Obtener hijos del tutor para el filtro
            $hijos = DB::select("
                SELECT DISTINCT p.ci, p.nombre, p.apellido
                FROM persona p
                INNER JOIN inscripcion i ON p.ci = i.ci
                WHERE i.citutor = ? AND p.tipoe = '1'
                ORDER BY p.nombre, p.apellido
            ", [$ci]);

            // Obtener gestiones disponibles
            $gestiones = DB::select("
                SELECT DISTINCT g.idgestion, g.detalleges
                FROM gestion g
                INNER JOIN inscripcion i ON g.idgestion = i.idgestion
                WHERE i.citutor = ?
                ORDER BY g.idgestion DESC
            ", [$ci]);

            // Consulta base para mensualidades pagadas
            $queryPagadas = "
                SELECT 
                    m.idmensualidad,
                    m.ci,
                    p.nombre + ' ' + p.apellido as estudiante,
                    p.codestudiante,
                    m.fechamen,
                    m.observacion,
                    m.tipopago,
                    dm.descripcion as mes,
                    dm.montototal as monto,
                    g.detalleges as gestion,
                    g.idgestion,
                    n.descripcion as nivel,
                    c.descripcion as curso,
                    'PAGADA' as estado
                FROM mensualidad m
                INNER JOIN detallemensualidad dm ON m.iddetallemensualidad = dm.iddetallemensualidad
                INNER JOIN persona p ON m.ci = p.ci
                INNER JOIN inscripcion i ON m.ci = i.ci AND m.idcurso = i.idcurso AND m.idnivel = i.idnivel
                INNER JOIN gestion g ON i.idgestion = g.idgestion
                INNER JOIN nivel n ON m.idnivel = n.idnivel
                INNER JOIN curso c ON m.idcurso = c.idcurso AND m.idnivel = c.idnivel
                WHERE i.citutor = ?
            ";

            // Consulta para mensualidades pendientes (meses sin pagar)
            $queryPendientes = "
                SELECT 
                    NULL as idmensualidad,
                    i.ci,
                    p.nombre + ' ' + p.apellido as estudiante,
                    p.codestudiante,
                    NULL as fechamen,
                    'Pago pendiente' as observacion,
                    NULL as tipopago,
                    dm.descripcion as mes,
                    dm.montototal as monto,
                    g.detalleges as gestion,
                    g.idgestion,
                    n.descripcion as nivel,
                    c.descripcion as curso,
                    'PENDIENTE' as estado
                FROM inscripcion i
                INNER JOIN persona p ON i.ci = p.ci
                INNER JOIN gestion g ON i.idgestion = g.idgestion
                INNER JOIN nivel n ON i.idnivel = n.idnivel
                INNER JOIN curso c ON i.idcurso = c.idcurso AND i.idnivel = c.idnivel
                CROSS JOIN detallemensualidad dm
                WHERE i.citutor = ?
                AND g.estado = '1'
                AND NOT EXISTS (
                    SELECT 1 FROM mensualidad m2
                    WHERE m2.ci = i.ci 
                    AND m2.idcurso = i.idcurso 
                    AND m2.idnivel = i.idnivel
                    AND m2.iddetallemensualidad = dm.iddetallemensualidad
                )
            ";

            $params = [$ci];
            $paramsPendientes = [$ci];

            // Aplicar filtros
            if ($filtroHijo !== 'todos') {
                $queryPagadas .= " AND m.ci = ?";
                $queryPendientes .= " AND i.ci = ?";
                $params[] = $filtroHijo;
                $paramsPendientes[] = $filtroHijo;
            }

            if ($filtroGestion !== 'todas') {
                $queryPagadas .= " AND g.idgestion = ?";
                $queryPendientes .= " AND g.idgestion = ?";
                $params[] = $filtroGestion;
                $paramsPendientes[] = $filtroGestion;
            }

            // Obtener mensualidades según filtro de estado
            $mensualidades = [];
            
            if ($filtroEstado === 'todas' || $filtroEstado === 'pagadas') {
                $pagadas = DB::select($queryPagadas . " ORDER BY m.fechamen DESC", $params);
                $mensualidades = array_merge($mensualidades, $pagadas);
            }

            if ($filtroEstado === 'todas' || $filtroEstado === 'pendientes') {
                $pendientes = DB::select($queryPendientes . " ORDER BY dm.iddetallemensualidad", $paramsPendientes);
                $mensualidades = array_merge($mensualidades, $pendientes);
            }

            // Estadísticas
            $estadisticas = DB::selectOne("
                SELECT 
                    COUNT(DISTINCT m.idmensualidad) as total_pagadas,
                    ISNULL(SUM(dm.montototal), 0) as total_pagado,
                    (SELECT COUNT(*) 
                     FROM inscripcion i2
                     INNER JOIN gestion g2 ON i2.idgestion = g2.idgestion
                     CROSS JOIN detallemensualidad dm2
                     WHERE i2.citutor = ? AND g2.estado = '1'
                     AND NOT EXISTS (
                         SELECT 1 FROM mensualidad m3
                         WHERE m3.ci = i2.ci 
                         AND m3.idcurso = i2.idcurso 
                         AND m3.idnivel = i2.idnivel
                         AND m3.iddetallemensualidad = dm2.iddetallemensualidad
                     )) as total_pendientes
                FROM mensualidad m
                INNER JOIN detallemensualidad dm ON m.iddetallemensualidad = dm.iddetallemensualidad
                INNER JOIN inscripcion i ON m.ci = i.ci AND m.idcurso = i.idcurso AND m.idnivel = i.idnivel
                WHERE i.citutor = ?
            ", [$ci, $ci]);

            return view('tutor.mensualidad.index', compact(
                'mensualidades',
                'estadisticas',
                'hijos',
                'gestiones',
                'filtroEstado',
                'filtroHijo',
                'filtroGestion'
            ));
        } catch (\Exception $e) {
            return view('tutor.mensualidad.index', [
                'mensualidades' => [],
                'estadisticas' => (object)[
                    'total_pagadas' => 0,
                    'total_pagado' => 0,
                    'total_pendientes' => 0
                ],
                'hijos' => [],
                'gestiones' => [],
                'filtroEstado' => 'todas',
                'filtroHijo' => 'todos',
                'filtroGestion' => 'todas'
            ])->with('error', 'Error al cargar las mensualidades: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar detalle de una mensualidad específica
     */
    public function show($id)
    {
        $usuario = session('usuario');
        $ciTutor = $usuario['ci'] ?? null;

        if (!$ciTutor) {
            return redirect()->route('login')->with('error', 'Sesión no válida');
        }

        try {
            // Obtener mensualidad con verificación de que pertenece a un hijo del tutor
            $mensualidad = DB::selectOne("
                SELECT 
                    m.idmensualidad,
                    m.ci,
                    p.nombre + ' ' + p.apellido as estudiante,
                    p.codestudiante,
                    m.fechamen,
                    m.observacion,
                    m.tipopago,
                    dm.descripcion as mes,
                    dm.montototal as monto,
                    dm.iddetallemensualidad,
                    g.detalleges as gestion,
                    n.descripcion as nivel,
                    c.descripcion as curso,
                    i.fecharegis as fechainscripcion,
                    b.nombrebeca as beca,
                    b.porcentaje as porcentaje_beca
                FROM mensualidad m
                INNER JOIN detallemensualidad dm ON m.iddetallemensualidad = dm.iddetallemensualidad
                INNER JOIN persona p ON m.ci = p.ci
                INNER JOIN inscripcion i ON m.ci = i.ci AND m.idcurso = i.idcurso AND m.idnivel = i.idnivel
                INNER JOIN gestion g ON i.idgestion = g.idgestion
                INNER JOIN nivel n ON m.idnivel = n.idnivel
                INNER JOIN curso c ON m.idcurso = c.idcurso AND m.idnivel = c.idnivel
                LEFT JOIN beca b ON i.codbeca = b.codbeca
                WHERE m.idmensualidad = ? AND i.citutor = ?
            ", [$id, $ciTutor]);

            if (!$mensualidad) {
                return redirect()->route('tutor.mensualidad.index')
                    ->with('error', 'Mensualidad no encontrada o no tienes permiso para verla');
            }

            return view('tutor.mensualidad.show', compact('mensualidad'));
        } catch (\Exception $e) {
            return redirect()->route('tutor.mensualidad.index')
                ->with('error', 'Error al cargar el detalle: ' . $e->getMessage());
        }
    }
}
