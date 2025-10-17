<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class StudentConvocatoriaController extends Controller
{
    public function index()
    {
        $rows = DB::select(<<<SQL
            SELECT c.idconvocatoria,
                   c.titulo,
                   c.descripcion,
                   c.fechainicio,
                   c.fechafin,
                   c.estado,
                   tb.nombre AS tipobeca
            FROM CONVOCATORIA c
            INNER JOIN TIPOBECA tb ON tb.idtipobeca = c.idtipobeca
            WHERE c.estado = '1'
            ORDER BY c.fechainicio DESC, c.idconvocatoria DESC
        SQL);
        return view('estudiante.convocatoria.index', compact('rows'));
    }

    public function show(int $id)
    {
        $row = DB::selectOne(<<<SQL
            SELECT c.idconvocatoria,
                   c.titulo,
                   c.descripcion,
                   c.fechainicio,
                   c.fechafin,
                   c.estado,
                   c.idtipobeca,
                   tb.nombre AS tipobeca
            FROM CONVOCATORIA c
            INNER JOIN TIPOBECA tb ON tb.idtipobeca = c.idtipobeca
            WHERE c.idconvocatoria = ?
        SQL, [$id]);
        if (!$row) { abort(404); }
        $requisitos = DB::select('SELECT idrequisito, descripcion, obligatorio FROM REQUISITO WHERE idtipobeca = ? ORDER BY idrequisito', [$row->idtipobeca]);
        return view('estudiante.convocatoria.show', compact('row','requisitos'));
    }
}
