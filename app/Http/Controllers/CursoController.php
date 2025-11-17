<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CursoController extends Controller
{
    // Mostrar cursos de un nivel específico
    public function index($idnivel)
    {
        // Verificar que el nivel existe
        $nivel = DB::selectOne('SELECT idnivel, descripcion FROM nivel WHERE idnivel = ?', [$idnivel]);
        
        if (!$nivel) {
            return redirect()->route('admin.nivel.index')->with('error', 'Nivel no encontrado');
        }

        // Obtener cursos del nivel con estadísticas
        $cursos = DB::select(
            'SELECT c.idcurso, c.idnivel, c.descripcion,
                    COUNT(DISTINCT m.idmateria) AS total_materias,
                    COUNT(DISTINCT i.ci) AS total_estudiantes
             FROM curso c
             LEFT JOIN materia m ON c.idcurso = m.idcurso AND c.idnivel = m.idnivel
             LEFT JOIN inscripcion i ON c.idcurso = i.idcurso AND c.idnivel = i.idnivel
             WHERE c.idnivel = ?
             GROUP BY c.idcurso, c.idnivel, c.descripcion
             ORDER BY c.idcurso',
            [$idnivel]
        );

        return view('admin.curso.index', compact('nivel', 'cursos'));
    }

    // Formulario para crear curso dentro de un nivel
    public function create($idnivel)
    {
        // Verificar que el nivel existe
        $nivel = DB::selectOne('SELECT idnivel, descripcion FROM nivel WHERE idnivel = ?', [$idnivel]);
        
        if (!$nivel) {
            return redirect()->route('admin.nivel.index')->with('error', 'Nivel no encontrado');
        }

        return view('admin.curso.create', compact('nivel'));
    }

    // Guardar nuevo curso
    public function store(Request $request, $idnivel)
    {
        $data = $request->validate([
            'descripcion' => 'required|string|max:100',
        ]);

        // Verificar que el nivel existe
        $nivel = DB::selectOne('SELECT idnivel FROM nivel WHERE idnivel = ?', [$idnivel]);
        if (!$nivel) {
            return redirect()->route('admin.nivel.index')->with('error', 'Nivel no encontrado');
        }

        // Validar que no exista un curso con la misma descripción en este nivel
        $exists = DB::selectOne(
            'SELECT 1 FROM curso WHERE idnivel = ? AND descripcion = ?',
            [$idnivel, $data['descripcion']]
        );

        if ($exists) {
            return back()->withErrors(['descripcion' => 'Ya existe un curso con esta descripción en este nivel'])->withInput();
        }

        try {
            // SP: sp_InsertarCurso (@idnivel, @descripcion)
            DB::statement('EXEC sp_InsertarCurso ?, ?', [$idnivel, $data['descripcion']]);

            return redirect()->route('admin.curso.index', $idnivel)->with('success', 'Curso creado exitosamente');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al crear el curso: ' . $e->getMessage()])->withInput();
        }
    }

    // Formulario para editar curso
    public function edit($idnivel, $idcurso)
    {
        // Obtener el curso con su nivel
        $curso = DB::selectOne(
            'SELECT c.idcurso, c.idnivel, c.descripcion, n.descripcion AS nivel_nombre
             FROM curso c
             INNER JOIN nivel n ON c.idnivel = n.idnivel
             WHERE c.idcurso = ? AND c.idnivel = ?',
            [$idcurso, $idnivel]
        );

        if (!$curso) {
            return redirect()->route('admin.nivel.index')->with('error', 'Curso no encontrado');
        }

        // Obtener información de dependencias
        $materias = DB::select(
            'SELECT COUNT(*) AS total FROM materia WHERE idcurso = ? AND idnivel = ?',
            [$idcurso, $idnivel]
        );
        $totalMaterias = $materias[0]->total ?? 0;

        $estudiantes = DB::select(
            'SELECT COUNT(*) AS total FROM inscripcion WHERE idcurso = ? AND idnivel = ?',
            [$idcurso, $idnivel]
        );
        $totalEstudiantes = $estudiantes[0]->total ?? 0;

        return view('admin.curso.edit', compact('curso', 'totalMaterias', 'totalEstudiantes'));
    }

    // Actualizar curso
    public function update(Request $request, $idnivel, $idcurso)
    {
        $data = $request->validate([
            'descripcion' => 'required|string|max:100',
        ]);

        // Validar que no exista otro curso con la misma descripción en este nivel
        $exists = DB::selectOne(
            'SELECT 1 FROM curso WHERE idnivel = ? AND descripcion = ? AND idcurso != ?',
            [$idnivel, $data['descripcion'], $idcurso]
        );

        if ($exists) {
            return back()->withErrors(['descripcion' => 'Ya existe otro curso con esta descripción en este nivel'])->withInput();
        }

        try {
            // SP: sp_ActualizarCurso (@idcurso, @idnivel, @descripcion)
            DB::statement('EXEC sp_ActualizarCurso ?, ?, ?', [$idcurso, $idnivel, $data['descripcion']]);

            return redirect()->route('admin.curso.index', $idnivel)->with('success', 'Curso actualizado exitosamente');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al actualizar el curso: ' . $e->getMessage()])->withInput();
        }
    }
}
