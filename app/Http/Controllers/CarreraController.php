<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarreraController extends Controller
{
    public function index()
    {
        $rows = DB::select('SELECT idcarrera, plancarrera, codigo, nombre FROM CARRERA ORDER BY idcarrera DESC');
        return view('admin.carrera.index', compact('rows'));
    }

    public function create()
    {
        return view('admin.carrera.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'plancarrera' => 'required|string|max:50',
            'codigo' => 'required|string|max:20',
            'nombre' => 'required|string|max:100',
        ]);

        // La tabla CARRERA usa identity en idcarrera, se inserta sin ID explícito
        DB::insert('INSERT INTO CARRERA (plancarrera, codigo, nombre) VALUES (?, ?, ?)', [
            $data['plancarrera'], $data['codigo'], $data['nombre'],
        ]);

        return redirect()->route('admin.carrera.index')->with('status', 'Registro exitoso');
    }

    public function edit(int $idcarrera)
    {
        $row = DB::selectOne('SELECT idcarrera, plancarrera, codigo, nombre FROM CARRERA WHERE idcarrera = ?', [$idcarrera]);
        if (!$row) { abort(404); }
        return view('admin.carrera.edit', compact('row'));
    }

    public function update(Request $request, int $idcarrera)
    {
        $data = $request->validate([
            'plancarrera' => 'required|string|max:50',
            'codigo' => 'required|string|max:20',
            'nombre' => 'required|string|max:100',
        ]);

        // Usar SP definido en BD para actualizar
        DB::statement('EXEC sp_ActualizarCarrera ?, ?, ?, ?', [
            $idcarrera,
            $data['plancarrera'],
            $data['codigo'],
            $data['nombre'],
        ]);

        return redirect()->route('admin.carrera.index')->with('status', 'Registro exitoso');
    }

}

