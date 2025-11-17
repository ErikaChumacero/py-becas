<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TutorHijoController extends Controller
{
    /**
     * Mostrar lista de hijos del tutor
     */
    public function index()
    {
        $usuario = session('usuario');
        $ci = $usuario['ci'] ?? null;

        if (!$ci) {
            return redirect()->route('login')->with('error', 'Sesión no válida');
        }

        try {
            // Obtener todos los hijos del tutor con su información de inscripción
            $hijos = DB::select("
                SELECT DISTINCT
                    p.ci,
                    p.nombre,
                    p.apellido,
                    p.codestudiante,
                    p.sexo,
                    p.correo,
                    p.telefono,
                    p.fecharegistro,
                    COUNT(DISTINCT i.idgestion) as total_gestiones,
                    COUNT(DISTINCT m.idmensualidad) as total_mensualidades,
                    (SELECT TOP 1 g.detalleges 
                     FROM inscripcion i2 
                     INNER JOIN gestion g ON i2.idgestion = g.idgestion 
                     WHERE i2.ci = p.ci AND g.estado = '1'
                     ORDER BY g.idgestion DESC) as gestion_actual,
                    (SELECT TOP 1 n.descripcion 
                     FROM inscripcion i2 
                     INNER JOIN nivel n ON i2.idnivel = n.idnivel
                     INNER JOIN gestion g ON i2.idgestion = g.idgestion
                     WHERE i2.ci = p.ci AND g.estado = '1'
                     ORDER BY g.idgestion DESC) as nivel_actual,
                    (SELECT TOP 1 c.descripcion 
                     FROM inscripcion i2 
                     INNER JOIN curso c ON i2.idcurso = c.idcurso AND i2.idnivel = c.idnivel
                     INNER JOIN gestion g ON i2.idgestion = g.idgestion
                     WHERE i2.ci = p.ci AND g.estado = '1'
                     ORDER BY g.idgestion DESC) as curso_actual,
                    (SELECT TOP 1 b.nombrebeca 
                     FROM inscripcion i2 
                     INNER JOIN beca b ON i2.codbeca = b.codbeca
                     INNER JOIN gestion g ON i2.idgestion = g.idgestion
                     WHERE i2.ci = p.ci AND g.estado = '1'
                     ORDER BY g.idgestion DESC) as beca_actual,
                    (SELECT TOP 1 b.porcentaje 
                     FROM inscripcion i2 
                     INNER JOIN beca b ON i2.codbeca = b.codbeca
                     INNER JOIN gestion g ON i2.idgestion = g.idgestion
                     WHERE i2.ci = p.ci AND g.estado = '1'
                     ORDER BY g.idgestion DESC) as porcentaje_beca
                FROM persona p
                INNER JOIN inscripcion i ON p.ci = i.ci
                LEFT JOIN mensualidad m ON p.ci = m.ci
                WHERE i.citutor = ? AND p.tipoe = '1'
                GROUP BY p.ci, p.nombre, p.apellido, p.codestudiante, p.sexo, p.correo, p.telefono, p.fecharegistro
                ORDER BY p.nombre, p.apellido
            ", [$ci]);

            return view('tutor.hijos.index', compact('hijos'));
        } catch (\Exception $e) {
            return view('tutor.hijos.index', ['hijos' => []])
                ->with('error', 'Error al cargar la información: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar detalle de un hijo específico
     */
    public function show($ci)
    {
        $usuario = session('usuario');
        $ciTutor = $usuario['ci'] ?? null;

        if (!$ciTutor) {
            return redirect()->route('login')->with('error', 'Sesión no válida');
        }

        try {
            // Verificar que el estudiante sea hijo del tutor
            $verificacion = DB::selectOne("
                SELECT COUNT(*) as es_hijo
                FROM inscripcion
                WHERE ci = ? AND citutor = ?
            ", [$ci, $ciTutor]);

            if (!$verificacion || $verificacion->es_hijo == 0) {
                return redirect()->route('tutor.hijos.index')
                    ->with('error', 'No tienes permiso para ver este estudiante');
            }

            // Obtener información del hijo
            $hijo = DB::selectOne("
                SELECT 
                    p.ci,
                    p.nombre,
                    p.apellido,
                    p.codestudiante,
                    p.sexo,
                    p.correo,
                    p.telefono,
                    p.fecharegistro
                FROM persona p
                WHERE p.ci = ? AND p.tipoe = '1'
            ", [$ci]);

            if (!$hijo) {
                return redirect()->route('tutor.hijos.index')
                    ->with('error', 'Estudiante no encontrado');
            }

            // Obtener inscripciones del hijo
            $inscripciones = DB::select("
                SELECT 
                    i.ci,
                    i.idcurso,
                    i.idnivel,
                    i.idgestion,
                    g.detalleges as gestion,
                    n.descripcion as nivel,
                    c.descripcion as curso,
                    i.fecharegis as fechainscripcion,
                    i.observaciones as observacion,
                    b.nombrebeca as beca,
                    b.porcentaje as porcentaje_beca,
                    b.codbeca
                FROM inscripcion i
                INNER JOIN gestion g ON i.idgestion = g.idgestion
                INNER JOIN nivel n ON i.idnivel = n.idnivel
                INNER JOIN curso c ON i.idcurso = c.idcurso AND i.idnivel = c.idnivel
                LEFT JOIN beca b ON i.codbeca = b.codbeca
                WHERE i.ci = ?
                ORDER BY g.idgestion DESC, i.fecharegis DESC
            ", [$ci]);

            // Obtener mensualidades del hijo
            $mensualidades = DB::select("
                SELECT 
                    m.idmensualidad,
                    m.fechamen,
                    m.observacion,
                    m.tipopago,
                    dm.descripcion as mes,
                    dm.montototal as monto,
                    g.detalleges as gestion,
                    n.descripcion as nivel,
                    c.descripcion as curso
                FROM mensualidad m
                INNER JOIN detallemensualidad dm ON m.iddetallemensualidad = dm.iddetallemensualidad
                INNER JOIN inscripcion i ON m.ci = i.ci AND m.idcurso = i.idcurso AND m.idnivel = i.idnivel
                INNER JOIN gestion g ON i.idgestion = g.idgestion
                INNER JOIN nivel n ON m.idnivel = n.idnivel
                INNER JOIN curso c ON m.idcurso = c.idcurso AND m.idnivel = c.idnivel
                WHERE m.ci = ?
                ORDER BY m.fechamen DESC
            ", [$ci]);

            // Estadísticas del hijo
            $estadisticas = DB::selectOne("
                SELECT 
                    COUNT(DISTINCT i.idgestion) as total_gestiones,
                    COUNT(DISTINCT m.idmensualidad) as total_mensualidades,
                    ISNULL(SUM(dm.montototal), 0) as total_pagado,
                    (SELECT COUNT(*) FROM inscripcion WHERE ci = ? AND codbeca IS NOT NULL) as tiene_becas
                FROM inscripcion i
                LEFT JOIN mensualidad m ON i.ci = m.ci AND i.idcurso = m.idcurso AND i.idnivel = m.idnivel
                LEFT JOIN detallemensualidad dm ON m.iddetallemensualidad = dm.iddetallemensualidad
                WHERE i.ci = ?
            ", [$ci, $ci]);

            return view('tutor.hijos.show', compact('hijo', 'inscripciones', 'mensualidades', 'estadisticas'));
        } catch (\Exception $e) {
            return redirect()->route('tutor.hijos.index')
                ->with('error', 'Error al cargar el detalle: ' . $e->getMessage());
        }
    }
}
