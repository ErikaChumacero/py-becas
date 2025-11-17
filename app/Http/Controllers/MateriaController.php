<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MateriaController extends Controller
{
    public function create()
    {
        // Obtener niveles y cursos para los selects
        $niveles = DB::select('SELECT idnivel, descripcion FROM nivel ORDER BY idnivel');
        $cursos = collect(DB::select('SELECT idcurso, idnivel, descripcion FROM curso ORDER BY idnivel, idcurso'));
        
        return view('admin.materia.create', compact('niveles', 'cursos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sigla' => 'required|string|max:10',
            'descripcion' => 'required|string|max:100',
            'idcurso' => 'required|integer',
            'idnivel' => 'required|integer',
        ]);

        // Evitar duplicado por sigla
        $exists = DB::selectOne('SELECT 1 FROM materia WHERE sigla = ?', [$data['sigla']]);
        if ($exists) {
            return back()->withErrors(['sigla' => 'La sigla ya está registrada'])->withInput();
        }

        // SP: sp_InsertarMateria (@sigla, @descripcion, @idcurso, @idnivel)
        DB::statement(
            'EXEC sp_InsertarMateria ?, ?, ?, ?',
            [
                $data['sigla'],
                $data['descripcion'],
                $data['idcurso'],
                $data['idnivel'],
            ]
        );

        return redirect()->route('admin.materia.index')->with('success', 'Materia creada exitosamente');
    }


    public function index(Request $request)
    {
        $filtroNivel = $request->query('nivel', 'todos'); // 'todos' o idnivel específico
        
        // Query base
        $query = 'SELECT m.idmateria, m.sigla, m.descripcion, 
                         m.idcurso, m.idnivel,
                         c.descripcion AS curso_nombre,
                         n.descripcion AS nivel_nombre
                  FROM materia m
                  INNER JOIN curso c ON m.idcurso = c.idcurso AND m.idnivel = c.idnivel
                  INNER JOIN nivel n ON m.idnivel = n.idnivel';
        
        // Aplicar filtro si no es 'todos'
        if ($filtroNivel !== 'todos') {
            $query .= ' WHERE m.idnivel = ' . (int)$filtroNivel;
        }
        
        $query .= ' ORDER BY n.idnivel, c.idcurso, m.sigla';
        
        $materias = DB::select($query);
        
        // Obtener todos los niveles para el filtro
        $niveles = DB::select('SELECT idnivel, descripcion FROM nivel ORDER BY idnivel');
        
        return view('admin.materia.index', compact('materias', 'niveles', 'filtroNivel'));
    }


    public function edit($id)
    {
        $materia = DB::selectOne(
            'SELECT idmateria, sigla, descripcion, idcurso, idnivel 
             FROM materia 
             WHERE idmateria = ?', 
            [$id]
        );
        
        if (!$materia) {
            return redirect()->route('admin.materia.index')->with('error', 'Materia no encontrada.');
        }
        
        // Obtener niveles y cursos para los selects
        $niveles = DB::select('SELECT idnivel, descripcion FROM nivel ORDER BY idnivel');
        $cursos = collect(DB::select('SELECT idcurso, idnivel, descripcion FROM curso ORDER BY idnivel, idcurso'));
        
        return view('admin.materia.edit', compact('materia', 'niveles', 'cursos'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'sigla' => 'required|string|max:10',
            'descripcion' => 'required|string|max:100',
            'idcurso' => 'required|integer',
            'idnivel' => 'required|integer',
        ]);

        // Verificar que la sigla no esté duplicada (excepto para esta materia)
        $exists = DB::selectOne(
            'SELECT 1 FROM materia WHERE sigla = ? AND idmateria != ?', 
            [$data['sigla'], $id]
        );
        if ($exists) {
            return back()->withErrors(['sigla' => 'La sigla ya está registrada'])->withInput();
        }

        // SP: sp_ActualizarMateria (@idmateria, @sigla, @descripcion, @idcurso, @idnivel)
        DB::statement(
            'EXEC sp_ActualizarMateria ?, ?, ?, ?, ?',
            [
                $id,
                $data['sigla'],
                $data['descripcion'],
                $data['idcurso'],
                $data['idnivel'],
            ]
        );
        
        return redirect()->route('admin.materia.index')->with('success', 'Materia actualizada exitosamente.');
    }
}
