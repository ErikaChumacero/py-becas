<?php

namespace App\Http\Controllers;

use App\Helpers\ErrorHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConvocatoriaController extends Controller
{
    public function index()
    {
        $rows = DB::select('SELECT c.idconvocatoria, c.titulo, c.descripcion, c.fechainicio, c.fechafin, c.estado, c.idtipobeca, t.nombre AS tipobeca_nombre FROM CONVOCATORIA c LEFT JOIN TIPOBECA t ON c.idtipobeca = t.idtipobeca ORDER BY c.idconvocatoria DESC');
        return view('admin.convocatoria.index', compact('rows'));
    }

    public function create()
    {
        $tipos = DB::select('SELECT idtipobeca, nombre FROM TIPOBECA ORDER BY nombre');
        return view('admin.convocatoria.create', compact('tipos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:100',
            'descripcion' => 'required|string|max:500',
            'fechainicio' => 'required|date',
            'fechafin' => 'required|date',
            'estado' => 'required|in:0,1',
            'idtipobeca' => 'required|integer',
        ]);

        try {
            // Validación de negocio: fechas
            DB::statement('EXEC sp_ValidarFechasConvocatoria ?, ?', [
                $data['fechainicio'],
                $data['fechafin'],
            ]);

            DB::insert('INSERT INTO CONVOCATORIA (titulo, descripcion, fechainicio, fechafin, estado, idtipobeca) VALUES (?, ?, ?, ?, ?, ?)', [
                $data['titulo'],
                $data['descripcion'],
                $data['fechainicio'],
                $data['fechafin'],
                $data['estado'],
                $data['idtipobeca'],
            ]);
        } catch (\Throwable $e) {
            return back()->withErrors(['general' => ErrorHelper::cleanSqlError($e->getMessage())])->withInput();
        }

        return redirect()->route('admin.convocatoria.index')->with('status', 'Convocatoria creada correctamente');
    }

    public function edit(int $id)
    {
        $row = DB::selectOne('SELECT idconvocatoria, titulo, descripcion, fechainicio, fechafin, estado, idtipobeca FROM CONVOCATORIA WHERE idconvocatoria = ?', [$id]);
        if (!$row) {
            abort(404);
        }
        $tipos = DB::select('SELECT idtipobeca, nombre FROM TIPOBECA ORDER BY nombre');
        return view('admin.convocatoria.edit', compact('row', 'tipos'));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:100',
            'descripcion' => 'required|string|max:500',
            'fechainicio' => 'required|date',
            'fechafin' => 'required|date',
            'estado' => 'required|in:0,1',
            'idtipobeca' => 'required|integer',
        ]);

        try {
            DB::statement('EXEC sp_ValidarFechasConvocatoria ?, ?', [
                $data['fechainicio'],
                $data['fechafin'],
            ]);

            DB::update('UPDATE CONVOCATORIA SET titulo = ?, descripcion = ?, fechainicio = ?, fechafin = ?, estado = ?, idtipobeca = ? WHERE idconvocatoria = ?', [
                $data['titulo'],
                $data['descripcion'],
                $data['fechainicio'],
                $data['fechafin'],
                $data['estado'],
                $data['idtipobeca'],
                $id,
            ]);
        } catch (\Throwable $e) {
            return back()->withErrors(['general' => ErrorHelper::cleanSqlError($e->getMessage())])->withInput();
        }

        return redirect()->route('admin.convocatoria.index')->with('status', 'Convocatoria actualizada');
    }

    public function disable(int $id)
    {
        DB::update('UPDATE CONVOCATORIA SET estado = ? WHERE idconvocatoria = ?', ['0', $id]);
        // Disparadores gestionan cierre automático
        return redirect()->route('admin.convocatoria.index')->with('status', 'Convocatoria deshabilitada');
    }
}
