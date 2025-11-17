<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MensualidadController extends Controller
{
    public function index(Request $request)
    {
        $filtroEstudiante = $request->query('estudiante', '');
        $filtroGestion = $request->query('gestion', 'todos');
        $filtroEstado = $request->query('estado', 'todos');
        
        // Query base - Muestra el monto base del detalle y la beca del estudiante
        $query = 'SELECT m.idmensualidad, m.fechamen, m.observacion, m.tipopago, m.ci, m.idcurso, m.idnivel,
                         p.nombre + \' \' + p.apellido AS estudiante_nombre,
                         c.descripcion AS curso_nombre,
                         n.descripcion AS nivel_nombre,
                         d.iddetallemensualidad, 
                         m.observacion AS detalle_descripcion,
                         d.monto AS monto_base,
                         ISNULL(b.porcentaje, 0) AS descuento_beca,
                         b.nombrebeca,
                         d.estado,
                         d.idgestion,
                         g.detalleges AS gestion_nombre
                  FROM mensualidad m
                  INNER JOIN persona p ON m.ci = p.ci
                  INNER JOIN curso c ON m.idcurso = c.idcurso AND m.idnivel = c.idnivel
                  INNER JOIN nivel n ON m.idnivel = n.idnivel
                  INNER JOIN detallemensualidad d ON m.iddetallemensualidad = d.iddetallemensualidad
                  INNER JOIN gestion g ON d.idgestion = g.idgestion
                  LEFT JOIN inscripcion i ON m.ci = i.ci AND m.idcurso = i.idcurso AND m.idnivel = i.idnivel
                  LEFT JOIN beca b ON i.codbeca = b.codbeca
                  WHERE 1=1';
        
        // Aplicar filtros
        if (!empty($filtroEstudiante)) {
            $query .= ' AND (p.nombre LIKE \'%' . $filtroEstudiante . '%\' OR p.apellido LIKE \'%' . $filtroEstudiante . '%\' OR m.ci LIKE \'%' . $filtroEstudiante . '%\')';
        }
        
        if ($filtroGestion !== 'todos') {
            $query .= ' AND d.idgestion = ' . (int)$filtroGestion;
        }
        
        if ($filtroEstado !== 'todos') {
            $query .= ' AND d.estado = \'' . $filtroEstado . '\'';
        }
        
        $query .= ' ORDER BY m.fechamen DESC, p.apellido, p.nombre';
        
        $mensualidades = DB::select($query);
        
        // Obtener gestiones para filtro
        $gestiones = DB::select('SELECT idgestion, detalleges FROM gestion ORDER BY idgestion DESC');
        
        return view('admin.mensualidad.index', compact('mensualidades', 'gestiones', 'filtroEstudiante', 'filtroGestion', 'filtroEstado'));
    }

    public function create()
    {
        // Obtener estudiantes inscritos con su información de beca
        // El monto se obtiene del detallemensualidad según el nivel
        $inscripciones = DB::select(
            "SELECT i.ci, i.idcurso, i.idnivel, i.codbeca, i.idgestion,
                    p.nombre + ' ' + p.apellido AS estudiante_nombre,
                    p.codestudiante,
                    c.descripcion AS curso_nombre,
                    n.descripcion AS nivel_nombre,
                    g.detalleges AS gestion_nombre,
                    b.porcentaje AS descuento_beca,
                    b.nombrebeca,
                    -- Obtener el monto del detalle que corresponde a este nivel
                    (SELECT TOP 1 dm.monto 
                     FROM detallemensualidad dm 
                     WHERE dm.idgestion = i.idgestion 
                     AND dm.estado = '1'
                     AND (
                         (i.idnivel = 1 AND dm.descripcion LIKE '%Inicial%') OR
                         (i.idnivel = 2 AND dm.descripcion LIKE '%Primaria%') OR
                         (i.idnivel = 3 AND dm.descripcion LIKE '%Secundaria%')
                     )
                    ) AS monto_base
             FROM inscripcion i
             INNER JOIN persona p ON i.ci = p.ci
             INNER JOIN curso c ON i.idcurso = c.idcurso AND i.idnivel = c.idnivel
             INNER JOIN nivel n ON i.idnivel = n.idnivel
             INNER JOIN gestion g ON i.idgestion = g.idgestion
             LEFT JOIN beca b ON i.codbeca = b.codbeca
             WHERE p.tipoe = '1'
             ORDER BY p.apellido, p.nombre"
        );
        
        // Obtener gestiones activas
        $gestiones = DB::select('SELECT idgestion, detalleges FROM gestion WHERE estado = \'1\' ORDER BY idgestion DESC');
        
        return view('admin.mensualidad.create', compact('inscripciones', 'gestiones'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ci' => 'required|string|max:10',
            'idcurso' => 'required|integer',
            'idnivel' => 'required|integer',
            'fechamen' => 'required|date',
            'tipopago' => 'nullable|string|max:1|in:E,Q',
            'observacion' => 'nullable|string|max:200',
            'descripcion_detalle' => 'required|string|max:100',
            'monto' => 'required|numeric|min:0',
        ]);

        // Validar que el estudiante está inscrito
        $inscripcion = DB::selectOne(
            'SELECT i.ci, i.codbeca, b.porcentaje AS descuento_beca
             FROM inscripcion i
             LEFT JOIN beca b ON i.codbeca = b.codbeca
             WHERE i.ci = ? AND i.idcurso = ? AND i.idnivel = ?',
            [$data['ci'], $data['idcurso'], $data['idnivel']]
        );

        if (!$inscripcion) {
            return back()->withErrors(['ci' => 'El estudiante no está inscrito en este curso'])->withInput();
        }

        // Obtener la gestión de la inscripción
        $inscripcionGestion = DB::selectOne(
            'SELECT idgestion FROM inscripcion WHERE ci = ? AND idcurso = ? AND idnivel = ?',
            [$data['ci'], $data['idcurso'], $data['idnivel']]
        );

        // Buscar el detallemensualidad existente para este nivel y gestión
        // Usa el idnivel para encontrar el detalle correcto
        $detalleMensualidad = DB::selectOne(
            'SELECT iddetallemensualidad, monto 
             FROM detallemensualidad 
             WHERE idgestion = ? 
             AND estado = \'1\'
             AND (
                 (? = 1 AND descripcion LIKE \'%Inicial%\') OR
                 (? = 2 AND descripcion LIKE \'%Primaria%\') OR
                 (? = 3 AND descripcion LIKE \'%Secundaria%\')
             )',
            [$inscripcionGestion->idgestion, $data['idnivel'], $data['idnivel'], $data['idnivel']]
        );

        if (!$detalleMensualidad) {
            return back()->withErrors(['error' => 'No se encontró el detalle de mensualidad para este nivel y gestión. Por favor, configure primero el detalle de mensualidad.'])->withInput();
        }

        // Validar que no exista un pago duplicado del mismo mes para este estudiante en esta gestión
        $pagoExistente = DB::selectOne(
            'SELECT m.idmensualidad 
             FROM mensualidad m
             INNER JOIN detallemensualidad d ON m.iddetallemensualidad = d.iddetallemensualidad
             WHERE m.ci = ? 
             AND m.idcurso = ? 
             AND m.idnivel = ?
             AND d.idgestion = ?
             AND m.observacion = ?',
            [$data['ci'], $data['idcurso'], $data['idnivel'], $inscripcionGestion->idgestion, $data['observacion'] ?? 'Pago de ' . $data['descripcion_detalle']]
        );

        if ($pagoExistente) {
            return back()->withErrors(['error' => 'Ya existe un pago registrado para este mes (' . $data['descripcion_detalle'] . ') en esta gestión. No se puede registrar el mismo pago dos veces.'])->withInput();
        }

        try {
            // Insertar Mensualidad usando el detalle existente
            DB::statement(
                'EXEC sp_InsertarMensualidad ?, ?, ?, ?, ?, ?, ?',
                [
                    $data['fechamen'],
                    $data['observacion'] ?? 'Pago de ' . $data['descripcion_detalle'],
                    $data['tipopago'],
                    $detalleMensualidad->iddetallemensualidad,
                    $data['ci'],
                    $data['idcurso'],
                    $data['idnivel']
                ]
            );

            return redirect()->route('admin.mensualidad.index')->with('success', 'Pago de mensualidad registrado exitosamente');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al registrar el pago: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        // Obtener la mensualidad con toda su información
        $mensualidad = DB::selectOne(
            'SELECT m.idmensualidad, m.fechamen, m.observacion, m.tipopago, m.ci, m.idcurso, m.idnivel,
                    p.nombre + \' \' + p.apellido AS estudiante_nombre,
                    c.descripcion AS curso_nombre,
                    n.descripcion AS nivel_nombre,
                    d.iddetallemensualidad, d.descripcion AS detalle_descripcion,
                    d.monto, d.descuento, d.montototal, d.estado, d.nodescuento,
                    d.cantidadmesualidades, d.idgestion,
                    g.detalleges AS gestion_nombre
             FROM mensualidad m
             INNER JOIN persona p ON m.ci = p.ci
             INNER JOIN curso c ON m.idcurso = c.idcurso AND m.idnivel = c.idnivel
             INNER JOIN nivel n ON m.idnivel = n.idnivel
             INNER JOIN detallemensualidad d ON m.iddetallemensualidad = d.iddetallemensualidad
             INNER JOIN gestion g ON d.idgestion = g.idgestion
             WHERE m.idmensualidad = ?',
            [$id]
        );

        if (!$mensualidad) {
            return redirect()->route('admin.mensualidad.index')->with('error', 'Mensualidad no encontrada');
        }

        // Obtener gestiones para el select
        $gestiones = DB::select('SELECT idgestion, detalleges FROM gestion ORDER BY idgestion DESC');

        return view('admin.mensualidad.edit', compact('mensualidad', 'gestiones'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'fechamen' => 'required|date',
            'tipopago' => 'required|string|max:1|in:E,Q',
            'observacion' => 'nullable|string|max:200',
            'descripcion_detalle' => 'required|string|max:100',
            'monto' => 'required|numeric|min:0',
            'estado' => 'required|string|max:1|in:0,1',
            'nodescuento' => 'required|string|max:1|in:0,1',
            'descuento' => 'required|integer|min:0|max:100',
            'cantidadmesualidades' => 'required|integer|min:1',
            'idgestion' => 'required|integer',
        ]);

        // Obtener la mensualidad actual
        $mensualidad = DB::selectOne(
            'SELECT iddetallemensualidad, ci, idcurso, idnivel FROM mensualidad WHERE idmensualidad = ?',
            [$id]
        );

        if (!$mensualidad) {
            return redirect()->route('admin.mensualidad.index')->with('error', 'Mensualidad no encontrada');
        }

        try {
            DB::beginTransaction();

            // 1. Actualizar DetalleMensualidad
            // SP: sp_ActualizarDetalleMensualidad (@iddetallemensualidad, @descripcion, @estado, @monto, @montototal, @nodescuento, @descuento, @cantidadmesualidades, @idgestion)
            DB::statement(
                'EXEC sp_ActualizarDetalleMensualidad ?, ?, ?, ?, ?, ?, ?, ?, ?',
                [
                    $mensualidad->iddetallemensualidad,
                    $data['descripcion_detalle'],
                    $data['estado'],
                    $data['monto'],
                    0, // montototal se recalcula automáticamente por trigger
                    $data['nodescuento'],
                    $data['descuento'],
                    $data['cantidadmesualidades'],
                    $data['idgestion']
                ]
            );

            // 2. Actualizar Mensualidad
            DB::statement(
                'EXEC sp_ActualizarMensualidad ?, ?, ?, ?, ?, ?, ?, ?',
                [
                    $id,
                    $data['fechamen'],
                    $data['observacion'],
                    $data['tipopago'],
                    $mensualidad->iddetallemensualidad,
                    $mensualidad->ci,
                    $mensualidad->idcurso,
                    $mensualidad->idnivel
                ]
            );

            DB::commit();

            return redirect()->route('admin.mensualidad.index')->with('success', 'Mensualidad actualizada exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al actualizar la mensualidad: ' . $e->getMessage()])->withInput();
        }
    }

    public function show($id)
    {
        // Obtener información completa de la mensualidad
        $mensualidad = DB::selectOne(
            'SELECT m.idmensualidad, m.fechamen, m.observacion, m.tipopago, m.ci, m.idcurso, m.idnivel,
                    p.nombre + \' \' + p.apellido AS estudiante_nombre,
                    p.codestudiante,
                    c.descripcion AS curso_nombre,
                    n.descripcion AS nivel_nombre,
                    d.iddetallemensualidad, d.descripcion AS detalle_descripcion,
                    d.monto, d.descuento, d.montototal, d.estado, d.nodescuento,
                    d.cantidadmesualidades, d.idgestion,
                    i.codbeca,
                    b.nombrebeca,
                    g.detalleges AS gestion_nombre
             FROM mensualidad m
             INNER JOIN persona p ON m.ci = p.ci
             INNER JOIN curso c ON m.idcurso = c.idcurso AND m.idnivel = c.idnivel
             INNER JOIN nivel n ON m.idnivel = n.idnivel
             INNER JOIN detallemensualidad d ON m.iddetallemensualidad = d.iddetallemensualidad
             INNER JOIN gestion g ON d.idgestion = g.idgestion
             INNER JOIN inscripcion i ON m.ci = i.ci AND m.idcurso = i.idcurso AND m.idnivel = i.idnivel
             LEFT JOIN beca b ON i.codbeca = b.codbeca
             WHERE m.idmensualidad = ?',
            [$id]
        );

        if (!$mensualidad) {
            return redirect()->route('admin.mensualidad.index')->with('error', 'Mensualidad no encontrada');
        }

        return view('admin.mensualidad.show', compact('mensualidad'));
    }

    public function destroy($id)
    {
        try {
            // Verificar que la mensualidad existe
            $mensualidad = DB::selectOne(
                'SELECT m.idmensualidad, m.ci, p.nombre + \' \' + p.apellido AS estudiante_nombre, m.observacion
                 FROM mensualidad m
                 INNER JOIN persona p ON m.ci = p.ci
                 WHERE m.idmensualidad = ?',
                [$id]
            );

            if (!$mensualidad) {
                return redirect()->route('admin.mensualidad.index')->with('error', 'Pago no encontrado');
            }

            // Eliminar la mensualidad
            DB::statement('DELETE FROM mensualidad WHERE idmensualidad = ?', [$id]);

            return redirect()->route('admin.mensualidad.index')
                ->with('success', 'Pago eliminado exitosamente: ' . $mensualidad->estudiante_nombre . ' - ' . $mensualidad->observacion);
        } catch (\Exception $e) {
            return redirect()->route('admin.mensualidad.index')
                ->with('error', 'Error al eliminar el pago: ' . $e->getMessage());
        }
    }
}
