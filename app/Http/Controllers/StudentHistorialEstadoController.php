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
        
        $idpostulacion = request('idpostulacion');
        $postulacion = null;
        $rows = [];
        
        if ($idpostulacion) {
            // Verificar que la postulación pertenece al estudiante
            $postulacion = DB::selectOne('SELECT p.idpostulacion, cv.titulo AS convocatoria FROM POSTULACION p INNER JOIN CONVOCATORIA cv ON cv.idconvocatoria = p.idconvocatoria WHERE p.idpostulacion = ? AND p.ci = ?', [$idpostulacion, $ci]);
            
            if (!$postulacion) {
                abort(404, 'Postulación no encontrada');
            }
            
            // Obtener historial de la postulación específica
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
                WHERE p.ci = ? AND h.idpostulacion = ?
                ORDER BY h.fechacambio DESC, h.idhistorialestado DESC
            SQL, [$ci, $idpostulacion]);
        } else {
            // Mostrar historial de todas las postulaciones del estudiante
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
        }
        
        return view('estudiante.historial.index', compact('rows', 'postulacion'));
    }
}
