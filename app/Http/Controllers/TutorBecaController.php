<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TutorBecaController extends Controller
{
    /**
     * Mostrar todas las becas de los hijos del tutor
     */
    public function index(Request $request)
    {
        $usuario = session('usuario');
        $ci = $usuario['ci'] ?? null;

        if (!$ci) {
            return redirect()->route('login')->with('error', 'Sesión no válida');
        }

        // Filtros
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

            // Consulta base para becas
            $query = "
                SELECT 
                    i.ci,
                    p.nombre + ' ' + p.apellido as estudiante,
                    p.codestudiante,
                    b.codbeca,
                    b.nombrebeca as beca,
                    b.porcentaje,
                    g.detalleges as gestion,
                    g.idgestion,
                    n.descripcion as nivel,
                    c.descripcion as curso,
                    i.fecharegis as fechainscripcion,
                    i.observaciones as observacion_inscripcion
                FROM inscripcion i
                INNER JOIN persona p ON i.ci = p.ci
                INNER JOIN beca b ON i.codbeca = b.codbeca
                INNER JOIN gestion g ON i.idgestion = g.idgestion
                INNER JOIN nivel n ON i.idnivel = n.idnivel
                INNER JOIN curso c ON i.idcurso = c.idcurso AND i.idnivel = c.idnivel
                WHERE i.citutor = ? AND i.codbeca IS NOT NULL
            ";

            $params = [$ci];

            // Aplicar filtros
            if ($filtroHijo !== 'todos') {
                $query .= " AND i.ci = ?";
                $params[] = $filtroHijo;
            }

            if ($filtroGestion !== 'todas') {
                $query .= " AND g.idgestion = ?";
                $params[] = $filtroGestion;
            }

            $query .= " ORDER BY g.idgestion DESC, p.nombre, p.apellido";

            $becas = DB::select($query, $params);

            // Estadísticas
            $estadisticas = DB::selectOne("
                SELECT 
                    COUNT(DISTINCT i.ci) as total_hijos_con_beca,
                    COUNT(*) as total_becas_asignadas,
                    AVG(CAST(b.porcentaje AS FLOAT)) as promedio_descuento,
                    MAX(b.porcentaje) as mayor_descuento
                FROM inscripcion i
                INNER JOIN beca b ON i.codbeca = b.codbeca
                WHERE i.citutor = ? AND i.codbeca IS NOT NULL
            ", [$ci]);

            // Resumen por tipo de beca
            $resumenBecas = DB::select("
                SELECT 
                    b.nombrebeca as beca,
                    b.porcentaje,
                    COUNT(*) as cantidad,
                    COUNT(DISTINCT i.ci) as estudiantes
                FROM inscripcion i
                INNER JOIN beca b ON i.codbeca = b.codbeca
                WHERE i.citutor = ?
                GROUP BY b.nombrebeca, b.porcentaje
                ORDER BY b.porcentaje DESC
            ", [$ci]);

            return view('tutor.beca.index', compact(
                'becas',
                'estadisticas',
                'resumenBecas',
                'hijos',
                'gestiones',
                'filtroHijo',
                'filtroGestion'
            ));
        } catch (\Exception $e) {
            return view('tutor.beca.index', [
                'becas' => [],
                'estadisticas' => (object)[
                    'total_hijos_con_beca' => 0,
                    'total_becas_asignadas' => 0,
                    'promedio_descuento' => 0,
                    'mayor_descuento' => 0
                ],
                'resumenBecas' => [],
                'hijos' => [],
                'gestiones' => [],
                'filtroHijo' => 'todos',
                'filtroGestion' => 'todas'
            ])->with('error', 'Error al cargar las becas: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar detalle de una beca específica
     */
    public function show($codbeca)
    {
        $usuario = session('usuario');
        $ciTutor = $usuario['ci'] ?? null;

        if (!$ciTutor) {
            return redirect()->route('login')->with('error', 'Sesión no válida');
        }

        try {
            // Obtener información de la beca
            $beca = DB::selectOne("
                SELECT 
                    b.codbeca,
                    b.nombrebeca as descripcion,
                    b.porcentaje
                FROM beca b
                WHERE b.codbeca = ?
            ", [$codbeca]);

            if (!$beca) {
                return redirect()->route('tutor.beca.index')
                    ->with('error', 'Beca no encontrada');
            }

            // Obtener hijos con esta beca
            $hijosConBeca = DB::select("
                SELECT 
                    i.ci,
                    p.nombre + ' ' + p.apellido as estudiante,
                    p.codestudiante,
                    g.detalleges as gestion,
                    n.descripcion as nivel,
                    c.descripcion as curso,
                    i.fecharegis as fechainscripcion,
                    i.observaciones as observacion
                FROM inscripcion i
                INNER JOIN persona p ON i.ci = p.ci
                INNER JOIN gestion g ON i.idgestion = g.idgestion
                INNER JOIN nivel n ON i.idnivel = n.idnivel
                INNER JOIN curso c ON i.idcurso = c.idcurso AND i.idnivel = c.idnivel
                WHERE i.citutor = ? AND i.codbeca = ?
                ORDER BY g.idgestion DESC, p.nombre, p.apellido
            ", [$ciTutor, $codbeca]);

            if (count($hijosConBeca) === 0) {
                return redirect()->route('tutor.beca.index')
                    ->with('error', 'Ninguno de tus hijos tiene esta beca asignada');
            }

            return view('tutor.beca.show', compact('beca', 'hijosConBeca'));
        } catch (\Exception $e) {
            return redirect()->route('tutor.beca.index')
                ->with('error', 'Error al cargar el detalle: ' . $e->getMessage());
        }
    }
}
