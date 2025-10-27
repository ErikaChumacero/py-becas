<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistorialEstadoController extends Controller
{
    public function index()
    {
        $rows = DB::select(<<<SQL
            SELECT h.idhistorialestado,
                   h.estadoanterior,
                   h.estadonuevo,
                   h.fechacambio,
                   h.idpostulacion,
                   p.estado AS estado_postulacion,
                   (per.nombre + ' ' + per.apellido) AS estudiante,
                   cv.titulo AS convocatoria
            FROM HISTORIALESTADO h
            INNER JOIN POSTULACION p ON p.idpostulacion = h.idpostulacion
            INNER JOIN PERSONA per ON per.ci = p.ci
            INNER JOIN CONVOCATORIA cv ON cv.idconvocatoria = p.idconvocatoria
            ORDER BY h.fechacambio DESC, h.idhistorialestado DESC
        SQL);
        return view('admin.historial.index', compact('rows'));
    }

    public function create()
    {
        $postulaciones = DB::select(<<<SQL
            SELECT p.idpostulacion,
                   (per.nombre + ' ' + per.apellido) + ' - ' + cv.titulo AS etiqueta,
                   p.estado
            FROM POSTULACION p
            INNER JOIN PERSONA per ON per.ci = p.ci
            INNER JOIN CONVOCATORIA cv ON cv.idconvocatoria = p.idconvocatoria
            ORDER BY p.idpostulacion DESC
        SQL);
        return view('admin.historial.create', compact('postulaciones'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'idpostulacion' => 'required|integer',
            'estadoanterior' => 'required|string|size:1',
            'estadonuevo' => 'required|string|size:1',
            'fechacambio' => 'required|date',
        ]);

        // El ID es IDENTITY, no se debe enviar
        DB::statement('EXEC sp_InsertarHistorialEstado ?, ?, ?, ?', [
            $data['estadoanterior'],
            $data['estadonuevo'],
            $data['fechacambio'],
            $data['idpostulacion'],
        ]);

        return redirect()->route('admin.historial.index')->with('status', 'Historial creado');
    }

    public function edit(int $id)
    {
        $row = DB::selectOne('SELECT idhistorialestado, estadoanterior, estadonuevo, fechacambio, idpostulacion FROM HISTORIALESTADO WHERE idhistorialestado = ?', [$id]);
        if (!$row) { abort(404); }
        $postulaciones = DB::select(<<<SQL
            SELECT p.idpostulacion,
                   (per.nombre + ' ' + per.apellido) + ' - ' + cv.titulo AS etiqueta,
                   p.estado
            FROM POSTULACION p
            INNER JOIN PERSONA per ON per.ci = p.ci
            INNER JOIN CONVOCATORIA cv ON cv.idconvocatoria = p.idconvocatoria
            ORDER BY p.idpostulacion DESC
        SQL);
        return view('admin.historial.edit', compact('row','postulaciones'));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'idpostulacion' => 'required|integer',
            'estadoanterior' => 'required|string|size:1',
            'estadonuevo' => 'required|string|size:1',
            'fechacambio' => 'required|date',
        ]);

        DB::statement('EXEC sp_ActualizarHistorialEstado ?, ?, ?, ?, ?', [
            $id,
            $data['estadoanterior'],
            $data['estadonuevo'],
            $data['fechacambio'],
            $data['idpostulacion'],
        ]);

        return redirect()->route('admin.historial.index')->with('status', 'Historial actualizado');
    }

    public function disable(int $id)
    {
        // No hay campo de estado propio; interpretamos deshabilitar como establecer 'estadonuevo' en '0'
        DB::update('UPDATE HISTORIALESTADO SET estadonuevo = ? WHERE idhistorialestado = ?', ['0', $id]);
        return redirect()->route('admin.historial.index')->with('status', 'Historial deshabilitado');
    }
}
