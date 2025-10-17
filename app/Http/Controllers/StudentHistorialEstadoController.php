<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class StudentHistorialEstadoController extends Controller
{
    private function currentStudentCi(): ?string
    {
        $u = session('usuario');
        return $u['ci'] ?? null;
    }

    public function index()
    {
        $ci = $this->currentStudentCi();
        if (!$ci) { abort(403); }
        $rows = DB::select(<<<SQL
            SELECT h.idhistorialestado,
                   h.estadoanterior,
                   h.estadonuevo,
                   h.fechacambio,
                   h.idpostulacion,
                   cv.titulo AS convocatoria
            FROM HISTORIALESTADO h
            INNER JOIN POSTULACION p ON p.idpostulacion = h.idpostulacion
            INNER JOIN CONVOCATORIA cv ON cv.idconvocatoria = p.idconvocatoria
            WHERE p.ci = ?
            ORDER BY h.fechacambio DESC, h.idhistorialestado DESC
        SQL, [$ci]);
        return view('estudiante.historial.index', compact('rows'));
    }
}
