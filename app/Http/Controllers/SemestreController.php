<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SemestreController extends Controller
{
    public function index()
    {
        $rows = DB::select('SELECT idsemestre, [año] AS anio, periodo, descripcion FROM SEMESTRE ORDER BY idsemestre DESC');
        return view('admin.semestre.index', compact('rows'));
    }

    public function create()
    {
        return view('admin.semestre.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'anio' => 'required|integer',
            'periodo' => 'required|string|max:20',
            'descripcion' => 'required|string|max:100',
        ]);

        DB::insert('INSERT INTO SEMESTRE ([año], periodo, descripcion) VALUES (?, ?, ?)', [
            $data['anio'], $data['periodo'], $data['descripcion'],
        ]);

        return redirect()->route('admin.semestre.index')->with('status', 'Semestre creado correctamente');
    }

    public function edit(int $id)
    {
        $row = DB::selectOne('SELECT idsemestre, [año] AS anio, periodo, descripcion FROM SEMESTRE WHERE idsemestre = ?', [$id]);
        if (!$row) { abort(404); }
        return view('admin.semestre.edit', compact('row'));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'anio' => 'required|integer',
            'periodo' => 'required|string|max:20',
            'descripcion' => 'required|string|max:100',
        ]);

        // Usar SP de actualización
        DB::statement('EXEC sp_ActualizarSemestre ?, ?, ?, ?', [
            $id,
            $data['anio'],
            $data['periodo'],
            $data['descripcion'],
        ]);

        return redirect()->route('admin.semestre.index')->with('status', 'Semestre actualizado');
    }

    // Nota: SEMESTRE no maneja campo de estado; si requieres deshabilitar, habría que agregar columna y reglas.
}
