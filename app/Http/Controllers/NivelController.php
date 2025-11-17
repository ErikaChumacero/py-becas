<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NivelController extends Controller
{
    public function index(Request $request)
    {
        // Obtener todos los niveles con conteo de cursos
        $niveles = DB::select(
            'SELECT n.idnivel, n.descripcion,
                    COUNT(DISTINCT c.idcurso) AS total_cursos,
                    COUNT(DISTINCT m.idmateria) AS total_materias
             FROM nivel n
             LEFT JOIN curso c ON n.idnivel = c.idnivel
             LEFT JOIN materia m ON n.idnivel = m.idnivel
             GROUP BY n.idnivel, n.descripcion
             ORDER BY n.idnivel'
        );
        
        return view('admin.nivel.index', compact('niveles'));
    }

    public function create()
    {
        return view('admin.nivel.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'descripcion' => 'required|string|max:100',
        ]);

        // Validar que la descripción no esté duplicada
        $exists = DB::selectOne(
            'SELECT 1 FROM nivel WHERE descripcion = ?',
            [$data['descripcion']]
        );

        if ($exists) {
            return back()->withErrors(['descripcion' => 'Ya existe un nivel con esta descripción'])->withInput();
        }

        try {
            // SP: sp_InsertarNivel (@descripcion)
            DB::statement('EXEC sp_InsertarNivel ?', [$data['descripcion']]);

            return redirect()->route('admin.nivel.index')->with('success', 'Nivel creado exitosamente');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al crear el nivel: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        $nivel = DB::selectOne(
            'SELECT idnivel, descripcion FROM nivel WHERE idnivel = ?',
            [$id]
        );

        if (!$nivel) {
            return redirect()->route('admin.nivel.index')->with('error', 'Nivel no encontrado');
        }

        // Obtener información de dependencias
        $cursos = DB::select(
            'SELECT COUNT(*) AS total FROM curso WHERE idnivel = ?',
            [$id]
        );
        $totalCursos = $cursos[0]->total ?? 0;

        $materias = DB::select(
            'SELECT COUNT(*) AS total FROM materia WHERE idnivel = ?',
            [$id]
        );
        $totalMaterias = $materias[0]->total ?? 0;

        return view('admin.nivel.edit', compact('nivel', 'totalCursos', 'totalMaterias'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'descripcion' => 'required|string|max:100',
        ]);

        // Validar que la descripción no esté duplicada (excepto el actual)
        $exists = DB::selectOne(
            'SELECT 1 FROM nivel WHERE descripcion = ? AND idnivel != ?',
            [$data['descripcion'], $id]
        );

        if ($exists) {
            return back()->withErrors(['descripcion' => 'Ya existe otro nivel con esta descripción'])->withInput();
        }

        try {
            // SP: sp_ActualizarNivel (@idnivel, @descripcion)
            DB::statement('EXEC sp_ActualizarNivel ?, ?', [$id, $data['descripcion']]);

            return redirect()->route('admin.nivel.index')->with('success', 'Nivel actualizado exitosamente');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al actualizar el nivel: ' . $e->getMessage()])->withInput();
        }
    }
}
