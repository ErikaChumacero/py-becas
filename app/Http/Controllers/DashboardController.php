<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function admin()
    {
        // Estadísticas generales para admin del colegio
        $stats = DB::selectOne(<<<SQL
            SELECT 
                (SELECT COUNT(*) FROM gestion WHERE estado = '1') AS gestiones_activas,
                (SELECT COUNT(*) FROM inscripcion) AS total_inscripciones,
                (SELECT COUNT(*) FROM persona WHERE tipoe = '1') AS total_estudiantes,
                (SELECT COUNT(*) FROM persona WHERE tipom = '1') AS total_maestros
        SQL);

        return view('admin.dashboard', compact('stats'));
    }

    public function estudiante()
    {
        $ci = session('usuario.ci');
        
        // Obtener información del estudiante
        $estudiante = DB::selectOne(<<<SQL
            SELECT 
                p.ci,
                p.nombre,
                p.apellido,
                p.codestudiante,
                (SELECT COUNT(*) FROM inscripcion WHERE ci = p.ci) AS total_inscripciones,
                (SELECT COUNT(*) FROM mensualidad m 
                 INNER JOIN inscripcion i ON m.ci = i.ci AND m.idcurso = i.idcurso AND m.idnivel = i.idnivel
                 WHERE i.ci = p.ci) AS total_mensualidades
            FROM persona p
            WHERE p.ci = ?
        SQL, [$ci]);

        return view('estudiante.dashboard', compact('estudiante'));
    }
}
