<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetalleMensualidadController extends Controller
{
    public function index(Request $request)
    {
        $filtroGestion = $request->query('gestion', 'todos');
        $filtroEstado = $request->query('estado', 'todos');
        $filtroNivel = $request->query('nivel', 'todos');
        
        $query = 'SELECT dm.iddetallemensualidad, dm.descripcion, dm.estado, dm.monto, 
                         dm.montototal, dm.nodescuento, dm.descuento, dm.cantidadmesualidades,
                         dm.idgestion, g.detalleges AS gestion_nombre,
                         COUNT(m.idmensualidad) AS total_mensualidades
                  FROM detallemensualidad dm
                  INNER JOIN gestion g ON dm.idgestion = g.idgestion
                  LEFT JOIN mensualidad m ON dm.iddetallemensualidad = m.iddetallemensualidad
                  WHERE 1=1';
        
        if ($filtroGestion !== 'todos') {
            $query .= ' AND dm.idgestion = ' . (int)$filtroGestion;
        }
        
        if ($filtroEstado !== 'todos') {
            $query .= ' AND dm.estado = \'' . $filtroEstado . '\'';
        }
        
        if ($filtroNivel !== 'todos') {
            $query .= ' AND dm.descripcion LIKE \'%' . $filtroNivel . '%\'';
        }
        
        $query .= ' GROUP BY dm.iddetallemensualidad, dm.descripcion, dm.estado, dm.monto, 
                            dm.montototal, dm.nodescuento, dm.descuento, dm.cantidadmesualidades,
                            dm.idgestion, g.detalleges
                    ORDER BY dm.idgestion DESC, dm.iddetallemensualidad DESC';
        
        $detalles = DB::select($query);
        
        $gestiones = DB::select('SELECT idgestion, detalleges FROM gestion ORDER BY idgestion DESC');
        $niveles = DB::select('SELECT idnivel, descripcion FROM nivel ORDER BY idnivel');
        
        return view('admin.detallemensualidad.index', compact('detalles', 'gestiones', 'niveles', 'filtroGestion', 'filtroEstado', 'filtroNivel'));
    }

    public function create()
    {
        $gestiones = DB::select(
            "SELECT idgestion, detalleges, fechaapertura, fechacierre, estado
             FROM gestion
             WHERE estado = '1'
             ORDER BY idgestion DESC"
        );
        
        return view('admin.detallemensualidad.create', compact('gestiones'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'descripcion' => 'required|string|max:100',
            'estado' => 'required|in:0,1',
            'monto' => 'required|numeric|min:0',
            'nodescuento' => 'required|in:0,1',
            'descuento' => 'nullable|integer|min:0|max:100',
            'cantidadmesualidades' => 'required|integer|min:1',
            'idgestion' => 'required|integer|exists:gestion,idgestion',
        ], [
            'descripcion.required' => 'La descripción es obligatoria',
            'descripcion.max' => 'La descripción no puede exceder 100 caracteres',
            'estado.required' => 'El estado es obligatorio',
            'estado.in' => 'El estado debe ser 0 o 1',
            'monto.required' => 'El monto es obligatorio',
            'monto.numeric' => 'El monto debe ser un número',
            'monto.min' => 'El monto no puede ser negativo',
            'nodescuento.required' => 'Debe indicar si aplica descuento',
            'nodescuento.in' => 'El campo descuento debe ser 0 o 1',
            'descuento.integer' => 'El descuento debe ser un número entero',
            'descuento.min' => 'El descuento no puede ser negativo',
            'descuento.max' => 'El descuento no puede ser mayor a 100',
            'cantidadmesualidades.required' => 'La cantidad de cuotas es obligatoria',
            'cantidadmesualidades.integer' => 'La cantidad de cuotas debe ser un número entero',
            'cantidadmesualidades.min' => 'Debe haber al menos 1 cuota',
            'idgestion.required' => 'La gestión es obligatoria',
            'idgestion.exists' => 'La gestión seleccionada no existe',
        ]);

        // Calcular montototal
        $monto = (float)$data['monto'];
        $descuento = isset($data['descuento']) ? (int)$data['descuento'] : 0;
        $montototal = $monto - ($monto * $descuento / 100);

        try {
            DB::statement(
                'EXEC sp_InsertarDetalleMensualidad ?, ?, ?, ?, ?, ?, ?, ?',
                [
                    $data['descripcion'],
                    $data['estado'],
                    $monto,
                    $montototal,
                    $data['nodescuento'],
                    $descuento,
                    $data['cantidadmesualidades'],
                    $data['idgestion']
                ]
            );

            return redirect()->route('admin.detallemensualidad.index')
                ->with('success', 'Detalle de mensualidad creado exitosamente');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al crear: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        $detalle = DB::selectOne(
            'SELECT dm.*, g.detalleges AS gestion_nombre
             FROM detallemensualidad dm
             INNER JOIN gestion g ON dm.idgestion = g.idgestion
             WHERE dm.iddetallemensualidad = ?',
            [$id]
        );
        
        if (!$detalle) {
            return redirect()->route('admin.detallemensualidad.index')
                ->with('error', 'Detalle no encontrado');
        }

        $gestiones = DB::select('SELECT idgestion, detalleges FROM gestion ORDER BY idgestion DESC');
        
        $mensualidades = DB::select(
            'SELECT COUNT(*) AS total FROM mensualidad WHERE iddetallemensualidad = ?',
            [$id]
        );
        $totalMensualidades = $mensualidades[0]->total ?? 0;
        
        return view('admin.detallemensualidad.edit', compact('detalle', 'gestiones', 'totalMensualidades'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'descripcion' => 'required|string|max:100',
            'estado' => 'required|in:0,1',
            'monto' => 'required|numeric|min:0',
            'nodescuento' => 'required|in:0,1',
            'descuento' => 'nullable|integer|min:0|max:100',
            'cantidadmesualidades' => 'required|integer|min:1',
            'idgestion' => 'required|integer|exists:gestion,idgestion',
        ], [
            'descripcion.required' => 'La descripción es obligatoria',
            'descripcion.max' => 'La descripción no puede exceder 100 caracteres',
            'estado.required' => 'El estado es obligatorio',
            'estado.in' => 'El estado debe ser 0 o 1',
            'monto.required' => 'El monto es obligatorio',
            'monto.numeric' => 'El monto debe ser un número',
            'monto.min' => 'El monto no puede ser negativo',
            'nodescuento.required' => 'Debe indicar si aplica descuento',
            'nodescuento.in' => 'El campo descuento debe ser 0 o 1',
            'descuento.integer' => 'El descuento debe ser un número entero',
            'descuento.min' => 'El descuento no puede ser negativo',
            'descuento.max' => 'El descuento no puede ser mayor a 100',
            'cantidadmesualidades.required' => 'La cantidad de cuotas es obligatoria',
            'cantidadmesualidades.integer' => 'La cantidad de cuotas debe ser un número entero',
            'cantidadmesualidades.min' => 'Debe haber al menos 1 cuota',
            'idgestion.required' => 'La gestión es obligatoria',
            'idgestion.exists' => 'La gestión seleccionada no existe',
        ]);

        // Calcular montototal
        $monto = (float)$data['monto'];
        $descuento = isset($data['descuento']) ? (int)$data['descuento'] : 0;
        $montototal = $monto - ($monto * $descuento / 100);

        try {
            DB::statement(
                'EXEC sp_ActualizarDetalleMensualidad ?, ?, ?, ?, ?, ?, ?, ?, ?',
                [
                    $id,
                    $data['descripcion'],
                    $data['estado'],
                    $monto,
                    $montototal,
                    $data['nodescuento'],
                    $descuento,
                    $data['cantidadmesualidades'],
                    $data['idgestion']
                ]
            );

            return redirect()->route('admin.detallemensualidad.index')
                ->with('success', 'Detalle actualizado exitosamente');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al actualizar: ' . $e->getMessage()])->withInput();
        }
    }
}
