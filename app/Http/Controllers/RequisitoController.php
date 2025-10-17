<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequisitoController extends Controller
{
    public function index()
    {
        $rows = DB::select(<<<SQL
            SELECT r.idrequisito,
                   r.descripcion,
                   r.obligatorio,
                   r.idtipobeca,
                   t.nombre AS tipobeca
            FROM REQUISITO r
            INNER JOIN TIPOBECA t ON t.idtipobeca = r.idtipobeca
            ORDER BY r.idrequisito DESC
        SQL);
        return view('admin.requisito.index', compact('rows'));
    }

    public function create()
    {
        $tipos = DB::select('SELECT idtipobeca, nombre FROM TIPOBECA ORDER BY nombre');
        return view('admin.requisito.create', compact('tipos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'descripcion' => 'required|string|max:500',
            'obligatorio' => 'required|string|size:1',
            'idtipobeca' => 'required|integer',
        ]);

        $next = DB::selectOne('SELECT ISNULL(MAX(idrequisito),0)+1 AS nextid FROM REQUISITO');
        $id = $next ? $next->nextid : 1;

        DB::statement('EXEC sp_InsertarRequisito ?, ?, ?, ?', [
            $id,
            $data['descripcion'],
            $data['obligatorio'],
            $data['idtipobeca'],
        ]);

        return redirect()->route('admin.requisito.index')->with('status', 'Requisito creado');
    }

    public function edit(int $id)
    {
        $row = DB::selectOne('SELECT idrequisito, descripcion, obligatorio, idtipobeca FROM REQUISITO WHERE idrequisito = ?', [$id]);
        if (!$row) { abort(404); }
        $tipos = DB::select('SELECT idtipobeca, nombre FROM TIPOBECA ORDER BY nombre');
        return view('admin.requisito.edit', compact('row','tipos'));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'descripcion' => 'required|string|max:500',
            'obligatorio' => 'required|string|size:1',
            'idtipobeca' => 'required|integer',
        ]);

        DB::statement('EXEC sp_ActualizarRequisito ?, ?, ?, ?', [
            $id,
            $data['descripcion'],
            $data['obligatorio'],
            $data['idtipobeca'],
        ]);

        return redirect()->route('admin.requisito.index')->with('status', 'Requisito actualizado');
    }

    public function disable(int $id)
    {
        // Manejo por estados: considerar 'obligatorio' como estado (1 activo, 0 deshabilitado)
        DB::update('UPDATE REQUISITO SET obligatorio = ? WHERE idrequisito = ?', ['0', $id]);
        return redirect()->route('admin.requisito.index')->with('status', 'Requisito deshabilitado');
    }
}
