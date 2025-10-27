<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequisitoController extends Controller
{
    public function index(Request $request)
    {
        $idtipobeca = $request->query('idtipobeca', 'todos'); // 'todos' o ID del tipo de beca
        
        $query = <<<SQL
            SELECT r.idrequisito,
                   r.descripcion,
                   r.obligatorio,
                   r.idtipobeca,
                   t.nombre AS tipobeca
            FROM REQUISITO r
            INNER JOIN TIPOBECA t ON t.idtipobeca = r.idtipobeca
        SQL;
        
        // Aplicar filtro si se seleccionó un tipo de beca específico
        if ($idtipobeca !== 'todos') {
            $query .= " WHERE r.idtipobeca = " . intval($idtipobeca);
        }
        
        // Ordenar por tipo de beca y luego por obligatorio (primero los obligatorios)
        $query .= " ORDER BY t.nombre, r.obligatorio DESC, r.descripcion";
        
        $rows = DB::select($query);
        
        // Obtener todos los tipos de beca para el filtro
        $tiposbeca = DB::select('SELECT idtipobeca, nombre FROM TIPOBECA ORDER BY nombre');
        
        return view('admin.requisito.index', compact('rows', 'tiposbeca', 'idtipobeca'));
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

        // sp_InsertarRequisito espera 3 parámetros (sin ID, es IDENTITY)
        DB::statement('EXEC sp_InsertarRequisito ?, ?, ?', [
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
