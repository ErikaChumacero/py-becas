<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InscripcionController extends Controller
{
    public function index(Request $request)
    {
        $filtroGestion = $request->query('gestion', 'todos');
        $filtroNivel = $request->query('nivel', 'todos');
        
        // Query base con joins
        $query = 'SELECT i.ci, i.idcurso, i.idnivel, i.observaciones, i.fecharegis, i.citutor, i.idgestion, i.codbeca,
                         p.nombre + \' \' + p.apellido AS estudiante_nombre,
                         c.descripcion AS curso_nombre,
                         n.descripcion AS nivel_nombre,
                         g.detalleges AS gestion_nombre,
                         t.nombre + \' \' + t.apellido AS tutor_nombre
                  FROM inscripcion i
                  INNER JOIN persona p ON i.ci = p.ci
                  INNER JOIN curso c ON i.idcurso = c.idcurso AND i.idnivel = c.idnivel
                  INNER JOIN nivel n ON i.idnivel = n.idnivel
                  INNER JOIN gestion g ON i.idgestion = g.idgestion
                  INNER JOIN persona t ON i.citutor = t.ci
                  WHERE 1=1';
        
        // Aplicar filtros
        if ($filtroGestion !== 'todos') {
            $query .= ' AND i.idgestion = ' . (int)$filtroGestion;
        }
        
        if ($filtroNivel !== 'todos') {
            $query .= ' AND i.idnivel = ' . (int)$filtroNivel;
        }
        
        $query .= ' ORDER BY i.fecharegis DESC, p.apellido, p.nombre';
        
        $inscripciones = DB::select($query);
        
        // Obtener gestiones y niveles para filtros
        $gestiones = DB::select('SELECT idgestion, detalleges FROM gestion ORDER BY idgestion DESC');
        $niveles = DB::select('SELECT idnivel, descripcion FROM nivel ORDER BY idnivel');
        
        return view('admin.inscripcion.index', compact('inscripciones', 'gestiones', 'niveles', 'filtroGestion', 'filtroNivel'));
    }

    public function create()
    {
        // Obtener estudiantes (tipoe='1')
        $estudiantes = DB::select(
            "SELECT ci, nombre, apellido, codestudiante 
             FROM persona 
             WHERE tipoe = '1' 
             ORDER BY apellido, nombre"
        );
        
        // Obtener tutores (tipot='1')
        $tutores = DB::select(
            "SELECT ci, nombre, apellido 
             FROM persona 
             WHERE tipot = '1'
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
        
        // Obtener todos los cursos agrupados por nivel
        $cursos = collect(DB::select(
            'SELECT idcurso, idnivel, descripcion 
             FROM curso 
             ORDER BY idnivel, idcurso'
        ));
        
        // Obtener becas disponibles
        $becas = DB::select('SELECT codbeca, nombrebeca, tipobeca, porcentaje FROM beca ORDER BY nombrebeca');
        
        return view('admin.inscripcion.create', compact('estudiantes', 'tutores', 'gestiones', 'niveles', 'cursos', 'becas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ci' => 'required|string|max:10',
            'idcurso' => 'required|integer',
            'idnivel' => 'required|integer',
            'observaciones' => 'nullable|string|max:200',
            'fecharegis' => 'required|date',
            'citutor' => 'required|string|max:10',
            'idgestion' => 'required|integer',
            'codbeca' => 'nullable|integer',
        ]);

        // Validar que el estudiante existe y es estudiante
        $estudiante = DB::selectOne(
            "SELECT 1 FROM persona WHERE ci = ? AND tipoe = '1'",
            [$data['ci']]
        );
        if (!$estudiante) {
            return back()->withErrors(['ci' => 'El CI no corresponde a un estudiante registrado'])->withInput();
        }

        // Validar que el tutor existe
        $tutor = DB::selectOne('SELECT 1 FROM persona WHERE ci = ?', [$data['citutor']]);
        if (!$tutor) {
            return back()->withErrors(['citutor' => 'El CI del tutor no existe'])->withInput();
        }

        // Validar que la gestión existe y está activa
        $gestion = DB::selectOne(
            "SELECT 1 FROM gestion WHERE idgestion = ? AND estado = '1'",
            [$data['idgestion']]
        );
        if (!$gestion) {
            return back()->withErrors(['idgestion' => 'La gestión seleccionada no está activa'])->withInput();
        }

        // Validar que el curso pertenece al nivel
        $curso = DB::selectOne(
            'SELECT 1 FROM curso WHERE idcurso = ? AND idnivel = ?',
            [$data['idcurso'], $data['idnivel']]
        );
        if (!$curso) {
            return back()->withErrors(['idcurso' => 'El curso no pertenece al nivel seleccionado'])->withInput();
        }

        // Validar que el tutor no sea el mismo estudiante
        if ($data['ci'] === $data['citutor']) {
            return back()->withErrors(['citutor' => 'El tutor no puede ser el mismo estudiante'])->withInput();
        }

        // Validar inscripción única por gestión usando SP
        try {
            DB::statement('EXEC sp_ValidarInscripcionUnica ?, ?', [$data['ci'], $data['idgestion']]);
        } catch (\Exception $e) {
            // Si el SP lanza error, significa que ya existe inscripción
            return back()->withErrors(['ci' => 'El estudiante ya tiene una inscripción en esta gestión'])->withInput();
        }

        // Validar que no exista inscripción duplicada (PK: ci, idcurso, idnivel)
        $exists = DB::selectOne(
            'SELECT 1 FROM inscripcion WHERE ci = ? AND idcurso = ? AND idnivel = ?',
            [$data['ci'], $data['idcurso'], $data['idnivel']]
        );
        if ($exists) {
            return back()->withErrors(['ci' => 'El estudiante ya está inscrito en este curso'])->withInput();
        }

        try {
            // SP: sp_InsertarInscripcion (@ci, @idcurso, @idnivel, @observaciones, @fecharegis, @citutor, @idgestion, @codbeca)
            DB::statement(
                'EXEC sp_InsertarInscripcion ?, ?, ?, ?, ?, ?, ?, ?',
                [
                    $data['ci'],
                    $data['idcurso'],
                    $data['idnivel'],
                    $data['observaciones'], // Si es NULL, el trigger lo cambia a 'Inscripción Regular'
                    $data['fecharegis'],
                    $data['citutor'],
                    $data['idgestion'],
                    $data['codbeca']
                ]
            );

            return redirect()->route('admin.inscripcion.index')->with('success', 'Inscripción creada exitosamente');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al crear la inscripción: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit($ci, $idcurso, $idnivel)
    {
        // Obtener la inscripción
        $inscripcion = DB::selectOne(
            'SELECT i.ci, i.idcurso, i.idnivel, i.observaciones, i.fecharegis, i.citutor, i.idgestion, i.codbeca,
                    p.nombre + \' \' + p.apellido AS estudiante_nombre,
                    c.descripcion AS curso_nombre,
                    n.descripcion AS nivel_nombre
             FROM inscripcion i
             INNER JOIN persona p ON i.ci = p.ci
             INNER JOIN curso c ON i.idcurso = c.idcurso AND i.idnivel = c.idnivel
             INNER JOIN nivel n ON i.idnivel = n.idnivel
             WHERE i.ci = ? AND i.idcurso = ? AND i.idnivel = ?',
            [$ci, $idcurso, $idnivel]
        );

        if (!$inscripcion) {
            return redirect()->route('admin.inscripcion.index')->with('error', 'Inscripción no encontrada');
        }

        // Obtener tutores (tipot='1')
        $tutores = DB::select(
            "SELECT ci, nombre, apellido 
             FROM persona 
             WHERE tipot = '1'
             ORDER BY apellido, nombre"
        );
        
        // Obtener gestiones
        $gestiones = DB::select('SELECT idgestion, detalleges FROM gestion ORDER BY idgestion DESC');
        
        // Obtener becas disponibles
        $becas = DB::select('SELECT codbeca, nombrebeca, tipobeca, porcentaje FROM beca ORDER BY nombrebeca');

        return view('admin.inscripcion.edit', compact('inscripcion', 'tutores', 'gestiones', 'becas'));
    }

    public function update(Request $request, $ci, $idcurso, $idnivel)
    {
        $data = $request->validate([
            'observaciones' => 'nullable|string|max:200',
            'fecharegis' => 'required|date',
            'citutor' => 'required|string|max:10',
            'idgestion' => 'required|integer',
            'codbeca' => 'nullable|integer',
        ]);

        // Validar que el tutor existe
        $tutor = DB::selectOne('SELECT 1 FROM persona WHERE ci = ?', [$data['citutor']]);
        if (!$tutor) {
            return back()->withErrors(['citutor' => 'El CI del tutor no existe'])->withInput();
        }

        // Validar que la gestión existe
        $gestion = DB::selectOne('SELECT 1 FROM gestion WHERE idgestion = ?', [$data['idgestion']]);
        if (!$gestion) {
            return back()->withErrors(['idgestion' => 'La gestión seleccionada no existe'])->withInput();
        }

        try {
            // SP: sp_ActualizarInscripcion (@ci, @idcurso, @idnivel, @observaciones, @fecharegis, @citutor, @idgestion, @codbeca)
            DB::statement(
                'EXEC sp_ActualizarInscripcion ?, ?, ?, ?, ?, ?, ?, ?',
                [
                    $ci,
                    $idcurso,
                    $idnivel,
                    $data['observaciones'],
                    $data['fecharegis'],
                    $data['citutor'],
                    $data['idgestion'],
                    $data['codbeca']
                ]
            );

            return redirect()->route('admin.inscripcion.index')->with('success', 'Inscripción actualizada exitosamente');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al actualizar la inscripción: ' . $e->getMessage()])->withInput();
        }
    }

    public function quitarBeca($ci, $idgestion)
    {
        try {
            $inscripcion = DB::selectOne(
                'SELECT i.ci, i.codbeca, p.nombre, p.apellido, g.detalleges 
                 FROM inscripcion i
                 INNER JOIN persona p ON i.ci = p.ci
                 INNER JOIN gestion g ON i.idgestion = g.idgestion
                 WHERE i.ci = ? AND i.idgestion = ?',
                [$ci, $idgestion]
            );

            if (!$inscripcion) {
                return redirect()->route('admin.inscripcion.index')->with('error', 'Inscripción no encontrada');
            }

            if (!$inscripcion->codbeca) {
                return redirect()->route('admin.inscripcion.index')->with('info', 'El estudiante no tiene beca asignada');
            }

            DB::statement('EXEC sp_QuitarBeca ?, ?', [$ci, $idgestion]);

            return redirect()->route('admin.inscripcion.index')
                ->with('success', 'Beca removida exitosamente de ' . $inscripcion->nombre . ' ' . $inscripcion->apellido);
        } catch (\Exception $e) {
            return redirect()->route('admin.inscripcion.index')
                ->with('error', 'Error al quitar beca: ' . $e->getMessage());
        }
    }
}
