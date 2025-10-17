<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipoBecaController extends Controller
{
    public function index()
    {
        $rows = DB::select('SELECT idtipobeca, nombre, descripcion FROM TIPOBECA ORDER BY idtipobeca DESC');
        return view('admin.tipobeca.index', compact('rows'));
    }

    public function create()
    {
        return view('admin.tipobeca.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required|string|max:500',
        ]);

        // La versión actual en BD de sp_InsertarTipoBeca recibe (nombre, descripcion)
        DB::statement('EXEC sp_InsertarTipoBeca ?, ?', [
            $data['nombre'],
            $data['descripcion'],
        ]);

        return redirect()->route('admin.tipobeca.index')->with('status', 'Tipo de beca creado');
    }

    public function edit(int $id)
    {
        $row = DB::selectOne('SELECT idtipobeca, nombre, descripcion FROM TIPOBECA WHERE idtipobeca = ?', [$id]);
        if (!$row) { abort(404); }
        return view('admin.tipobeca.edit', compact('row'));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required|string|max:500',
        ]);

        DB::statement('EXEC sp_ActualizarTipoBeca ?, ?, ?', [
            $id,
            $data['nombre'],
            $data['descripcion'],
        ]);

        return redirect()->route('admin.tipobeca.index')->with('status', 'Tipo de beca actualizado');
    }

    public function disable(int $id)
    {
        // No hay campo estado; intentamos eliminación física si no está referenciado
        $refs = DB::selectOne('SELECT (
            SELECT COUNT(*) FROM CONVOCATORIA WHERE idtipobeca = ?
        ) + (
            SELECT COUNT(*) FROM REQUISITO WHERE idtipobeca = ?
        ) AS refs', [$id, $id]);
        if ($refs && $refs->refs > 0) {
            return redirect()->route('admin.tipobeca.index')->withErrors(['general' => 'No se puede deshabilitar/eliminar: está referenciado por convocatorias o requisitos.']);
        }
        DB::delete('DELETE FROM TIPOBECA WHERE idtipobeca = ?', [$id]);
        return redirect()->route('admin.tipobeca.index')->with('status', 'Tipo de beca eliminado');
    }
}
