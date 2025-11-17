<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaestroMaterController extends Controller
{
    public function index(Request $request)
    {
        $filtroMaestro = $request->query('maestro', '');
        $filtroGestion = $request->query('gestion', 'todos');
        $filtroCurso = $request->query('curso', 'todos');
        
        // Query base con joins
        $query = 'SELECT mm.ci, mm.idmateria, mm.fecharegis, mm.observacion, mm.asesor,
                         mm.idgestion, mm.idcurso, mm.idnivel,
                         p.nombre + \' \' + p.apellido AS maestro_nombre,
                         p.codmaestro,
                         m.sigla AS materia_sigla,
                         m.descripcion AS materia_descripcion,
                         c.descripcion AS curso_nombre,
                         n.descripcion AS nivel_nombre,
                         g.detalleges AS gestion_nombre
                  FROM maestromater mm
                  INNER JOIN persona p ON mm.ci = p.ci
                  INNER JOIN materia m ON mm.idmateria = m.idmateria
                  INNER JOIN curso c ON mm.idcurso = c.idcurso AND mm.idnivel = c.idnivel
                  INNER JOIN nivel n ON mm.idnivel = n.idnivel
                  INNER JOIN gestion g ON mm.idgestion = g.idgestion
                  WHERE p.tipom = \'1\'';
        
        // Aplicar filtros
        if (!empty($filtroMaestro)) {
            $query .= ' AND (p.nombre LIKE \'%' . $filtroMaestro . '%\' OR p.apellido LIKE \'%' . $filtroMaestro . '%\' OR mm.ci LIKE \'%' . $filtroMaestro . '%\')';
        }
        
        if ($filtroGestion !== 'todos') {
            $query .= ' AND mm.idgestion = ' . (int)$filtroGestion;
        }
        
        if ($filtroCurso !== 'todos') {
            $parts = explode('_', $filtroCurso);
            if (count($parts) == 2) {
                $query .= ' AND mm.idcurso = ' . (int)$parts[0] . ' AND mm.idnivel = ' . (int)$parts[1];
            }
        }
        
        $query .= ' ORDER BY p.apellido, p.nombre, m.sigla';
        
        $asignaciones = DB::select($query);
        
        // Obtener gestiones y cursos para filtros
        $gestiones = DB::select('SELECT idgestion, detalleges FROM gestion ORDER BY idgestion DESC');
        $cursos = DB::select('SELECT c.idcurso, c.idnivel, c.descripcion AS curso_nombre, n.descripcion AS nivel_nombre 
                              FROM curso c 
                              INNER JOIN nivel n ON c.idnivel = n.idnivel 
                              ORDER BY n.idnivel, c.idcurso');
        
        return view('admin.maestromater.index', compact('asignaciones', 'gestiones', 'cursos', 'filtroMaestro', 'filtroGestion', 'filtroCurso'));
    }

    public function create()
    {
        // Obtener maestros (tipom='1')
        $maestros = DB::select(
            "SELECT ci, nombre, apellido, codmaestro
             FROM persona
             WHERE tipom = '1'
             ORDER BY apellido, nombre"
        );
        
        // Obtener gestiones activas
        $gestiones = DB::select(
            "SELECT idgestion, detalleges, fechaapertura, fechacierre, estado
             FROM gestion
             WHERE estado = '1'
             ORDER BY idgestion DESC"
        );
        
        // Obtener niveles
        $niveles = DB::select('SELECT idnivel, descripcion FROM nivel ORDER BY idnivel');
        
        // Obtener todos los cursos
        $cursos = DB::select(
            'SELECT c.idcurso, c.idnivel, c.descripcion AS curso_nombre, n.descripcion AS nivel_nombre
             FROM curso c
             INNER JOIN nivel n ON c.idnivel = n.idnivel
             ORDER BY n.idnivel, c.idcurso'
        );
        
        return view('admin.maestromater.create', compact('maestros', 'gestiones', 'niveles', 'cursos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ci' => 'required|string|max:10',
            'idmateria' => 'required|integer',
            'idcurso' => 'required|integer',
            'idnivel' => 'required|integer',
            'idgestion' => 'required|integer',
            'fecharegis' => 'required|date',
            'asesor' => 'required|string|max:1|in:0,1',
            'observacion' => 'nullable|string|max:200',
        ]);

        // Validar que el maestro existe y tiene tipom='1'
        $maestro = DB::selectOne(
            "SELECT ci, tipom FROM persona WHERE ci = ? AND tipom = '1'",
            [$data['ci']]
        );

        if (!$maestro) {
            return back()->withErrors(['ci' => 'La persona seleccionada no es un maestro'])->withInput();
        }

        // Validar que la materia existe y pertenece al curso/nivel
        $materia = DB::selectOne(
            'SELECT idmateria FROM materia WHERE idmateria = ? AND idcurso = ? AND idnivel = ?',
            [$data['idmateria'], $data['idcurso'], $data['idnivel']]
        );

        if (!$materia) {
            return back()->withErrors(['idmateria' => 'La materia no pertenece al curso/nivel seleccionado'])->withInput();
        }

        // Validar que el curso/nivel existe
        $curso = DB::selectOne(
            'SELECT 1 FROM curso WHERE idcurso = ? AND idnivel = ?',
            [$data['idcurso'], $data['idnivel']]
        );

        if (!$curso) {
            return back()->withErrors(['idcurso' => 'El curso/nivel no existe'])->withInput();
        }

        // Validar que la gestión existe y está activa
        $gestion = DB::selectOne(
            "SELECT estado FROM gestion WHERE idgestion = ? AND estado = '1'",
            [$data['idgestion']]
        );

        if (!$gestion) {
            return back()->withErrors(['idgestion' => 'La gestión no existe o no está activa'])->withInput();
        }

        // Validar que no existe duplicado (ci + idmateria)
        $exists = DB::selectOne(
            'SELECT 1 FROM maestromater WHERE ci = ? AND idmateria = ?',
            [$data['ci'], $data['idmateria']]
        );

        if ($exists) {
            return back()->withErrors(['error' => 'Este maestro ya tiene asignada esta materia'])->withInput();
        }

        try {
            // Usar SP optimizado: sp_AsignarMateria
            DB::statement(
                'EXEC sp_AsignarMateria ?, ?, ?, ?, ?',
                [
                    $data['ci'],
                    $data['idmateria'],
                    $data['idgestion'],
                    $data['idcurso'],
                    $data['idnivel']
                ]
            );

            return redirect()->route('admin.maestromater.index')->with('success', 'Materia asignada exitosamente');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al asignar la materia: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit($ci, $idmateria)
    {
        // Obtener la asignación
        $asignacion = DB::selectOne(
            'SELECT mm.ci, mm.idmateria, mm.fecharegis, mm.observacion, mm.asesor,
                    mm.idgestion, mm.idcurso, mm.idnivel,
                    p.nombre + \' \' + p.apellido AS maestro_nombre,
                    p.codmaestro,
                    m.sigla AS materia_sigla,
                    m.descripcion AS materia_descripcion,
                    c.descripcion AS curso_nombre,
                    n.descripcion AS nivel_nombre
             FROM maestromater mm
             INNER JOIN persona p ON mm.ci = p.ci
             INNER JOIN materia m ON mm.idmateria = m.idmateria
             INNER JOIN curso c ON mm.idcurso = c.idcurso AND mm.idnivel = c.idnivel
             INNER JOIN nivel n ON mm.idnivel = n.idnivel
             WHERE mm.ci = ? AND mm.idmateria = ?',
            [$ci, $idmateria]
        );

        if (!$asignacion) {
            return redirect()->route('admin.maestromater.index')->with('error', 'Asignación no encontrada');
        }

        // Obtener gestiones
        $gestiones = DB::select('SELECT idgestion, detalleges FROM gestion ORDER BY idgestion DESC');

        return view('admin.maestromater.edit', compact('asignacion', 'gestiones'));
    }

    public function update(Request $request, $ci, $idmateria)
    {
        $data = $request->validate([
            'fecharegis' => 'required|date',
            'idgestion' => 'required|integer',
            'asesor' => 'required|string|max:1|in:0,1',
            'observacion' => 'nullable|string|max:200',
        ]);

        // Obtener la asignación actual
        $asignacion = DB::selectOne(
            'SELECT ci, idmateria, idcurso, idnivel FROM maestromater WHERE ci = ? AND idmateria = ?',
            [$ci, $idmateria]
        );

        if (!$asignacion) {
            return redirect()->route('admin.maestromater.index')->with('error', 'Asignación no encontrada');
        }

        // Validar que la gestión existe
        $gestion = DB::selectOne(
            'SELECT 1 FROM gestion WHERE idgestion = ?',
            [$data['idgestion']]
        );

        if (!$gestion) {
            return back()->withErrors(['idgestion' => 'La gestión no existe'])->withInput();
        }

        try {
            // SP: sp_ActualizarMaestroMater
            DB::statement(
                'EXEC sp_ActualizarMaestroMater ?, ?, ?, ?, ?, ?, ?, ?',
                [
                    $ci,
                    $idmateria,
                    $data['fecharegis'],
                    $data['observacion'],
                    $data['idgestion'],
                    $asignacion->idcurso,
                    $asignacion->idnivel,
                    $data['asesor']
                ]
            );

            return redirect()->route('admin.maestromater.index')->with('success', 'Asignación actualizada exitosamente');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al actualizar la asignación: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy($ci, $idmateria)
    {
        try {
            // Usar SP optimizado: sp_QuitarMateria
            DB::statement('EXEC sp_QuitarMateria ?, ?', [$ci, $idmateria]);
            return redirect()->route('admin.maestromater.index')->with('success', 'Asignación eliminada exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('admin.maestromater.index')->with('error', 'Error al eliminar la asignación: ' . $e->getMessage());
        }
    }

    // API para obtener materias por curso/nivel (AJAX)
    public function getMateriasByCurso($idcurso, $idnivel)
    {
        $materias = DB::select(
            'SELECT idmateria, sigla, descripcion 
             FROM materia 
             WHERE idcurso = ? AND idnivel = ?
             ORDER BY sigla',
            [$idcurso, $idnivel]
        );

        return response()->json($materias);
    }
}
