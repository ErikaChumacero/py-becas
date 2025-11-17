<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GestionController extends Controller
{
    public function create()
    {
        return view('admin.gestion.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'detalleges' => 'required|string|max:100',
            'observacion' => 'nullable|string|max:200',
            'fechaapertura' => 'required|date',
            'fechacierre' => 'required|date|after:fechaapertura',
            'estado' => 'required|boolean',
        ]);

        // Validar que no haya otra gestión activa en el mismo período
        $conflicto = DB::selectOne(
            "SELECT 1 FROM gestion 
             WHERE estado = '1' 
             AND (
                 (fechaapertura <= ? AND fechacierre >= ?) OR
                 (fechaapertura <= ? AND fechacierre >= ?) OR
                 (fechaapertura >= ? AND fechacierre <= ?)
             )",
            [
                $data['fechaapertura'], $data['fechaapertura'],
                $data['fechacierre'], $data['fechacierre'],
                $data['fechaapertura'], $data['fechacierre']
            ]
        );

        if ($conflicto && $request->boolean('estado')) {
            return back()->withErrors(['fechaapertura' => 'Ya existe una gestión activa en este período'])->withInput();
        }

        // Determinar estado automáticamente si la fecha de cierre ya pasó
        $fechaCierre = new \DateTime($data['fechacierre']);
        $hoy = new \DateTime();
        $estado = ($fechaCierre < $hoy) ? '0' : ($request->boolean('estado') ? '1' : '0');

        try {
            // SP: sp_InsertarGestion (@detalleges, @observacion, @fechaapertura, @fechacierre, @estado)
            // El trigger des_FECHASGESTION validará que fechacierre > fechaapertura
            DB::statement(
                'EXEC sp_InsertarGestion ?, ?, ?, ?, ?',
                [
                    $data['detalleges'],
                    $data['observacion'],
                    $data['fechaapertura'],
                    $data['fechacierre'],
                    $estado,
                ]
            );

            $mensaje = ($estado === '0' && $fechaCierre < $hoy) 
                ? 'Gestión creada como inactiva (fecha de cierre ya pasó)' 
                : 'Gestión creada exitosamente';

            return redirect()->route('admin.gestion.index')->with('success', $mensaje);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al crear la gestión: ' . $e->getMessage()])->withInput();
        }
    }


    public function index(Request $request)
    {
        $filtro = $request->query('filtro', 'activas'); // 'activas', 'inactivas', 'todas'
        
        // Primero, actualizar automáticamente las gestiones vencidas
        DB::statement(
            "UPDATE gestion SET estado = '0' WHERE fechacierre < GETDATE() AND estado = '1'"
        );
        
        $query = 'SELECT idgestion, detalleges, observacion, fechaapertura, fechacierre, estado FROM gestion';
        
        // Aplicar filtro según el estado
        if ($filtro === 'activas') {
            $query .= ' WHERE estado = \'1\'';
        } elseif ($filtro === 'inactivas') {
            $query .= ' WHERE estado = \'0\'';
        }
        // Si es 'todas', no agregar WHERE
        
        $query .= ' ORDER BY idgestion DESC';
        
        $gestiones = DB::select($query);
        return view('admin.gestion.index', compact('gestiones', 'filtro'));
    }


    public function edit($id)
    {
        $gestion = DB::selectOne(
            'SELECT idgestion, detalleges, observacion, fechaapertura, fechacierre, estado 
             FROM gestion 
             WHERE idgestion = ?', 
            [$id]
        );
        
        if (!$gestion) {
            return redirect()->route('admin.gestion.index')->with('error', 'Gestión no encontrada.');
        }
        
        return view('admin.gestion.edit', compact('gestion'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'detalleges' => 'required|string|max:100',
            'observacion' => 'nullable|string|max:200',
            'fechaapertura' => 'required|date',
            'fechacierre' => 'required|date|after:fechaapertura',
            'estado' => 'required|boolean',
        ]);

        // Validar que no haya otra gestión activa en el mismo período (excepto esta)
        $conflicto = DB::selectOne(
            "SELECT 1 FROM gestion 
             WHERE idgestion != ? AND estado = '1' 
             AND (
                 (fechaapertura <= ? AND fechacierre >= ?) OR
                 (fechaapertura <= ? AND fechacierre >= ?) OR
                 (fechaapertura >= ? AND fechacierre <= ?)
             )",
            [
                $id,
                $data['fechaapertura'], $data['fechaapertura'],
                $data['fechacierre'], $data['fechacierre'],
                $data['fechaapertura'], $data['fechacierre']
            ]
        );

        if ($conflicto && $request->boolean('estado')) {
            return back()->withErrors(['fechaapertura' => 'Ya existe otra gestión activa en este período'])->withInput();
        }

        // Determinar estado automáticamente si la fecha de cierre ya pasó
        $fechaCierre = new \DateTime($data['fechacierre']);
        $hoy = new \DateTime();
        $estado = ($fechaCierre < $hoy) ? '0' : ($request->boolean('estado') ? '1' : '0');

        try {
            // SP: sp_ActualizarGestion (@idgestion, @detalleges, @observacion, @fechaapertura, @fechacierre, @estado)
            // El trigger des_FECHASGESTION validará que fechacierre > fechaapertura
            DB::statement(
                'EXEC sp_ActualizarGestion ?, ?, ?, ?, ?, ?',
                [
                    $id,
                    $data['detalleges'],
                    $data['observacion'],
                    $data['fechaapertura'],
                    $data['fechacierre'],
                    $estado,
                ]
            );

            $mensaje = ($estado === '0' && $fechaCierre < $hoy) 
                ? 'Gestión actualizada como inactiva (fecha de cierre ya pasó)' 
                : 'Gestión actualizada exitosamente';
            
            return redirect()->route('admin.gestion.index')->with('success', $mensaje);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al actualizar la gestión: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Abrir una gestión (cambiar estado a activo)
     */
    public function abrir($id)
    {
        try {
            // Verificar que la gestión existe
            $gestion = DB::selectOne('SELECT idgestion, detalleges, estado FROM gestion WHERE idgestion = ?', [$id]);
            
            if (!$gestion) {
                return redirect()->route('admin.gestion.index')->with('error', 'Gestión no encontrada');
            }

            // Verificar si ya está activa
            if ($gestion->estado === '1') {
                return redirect()->route('admin.gestion.index')->with('info', 'La gestión ya está activa');
            }

            // Ejecutar SP para abrir gestión
            DB::statement('EXEC sp_AbrirGestion ?', [$id]);

            return redirect()->route('admin.gestion.index')
                ->with('success', 'Gestión "' . $gestion->detalleges . '" abierta exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('admin.gestion.index')
                ->with('error', 'Error al abrir la gestión: ' . $e->getMessage());
        }
    }

    /**
     * Cerrar una gestión (cambiar estado a inactivo)
     */
    public function cerrar($id)
    {
        try {
            // Verificar que la gestión existe
            $gestion = DB::selectOne('SELECT idgestion, detalleges, estado FROM gestion WHERE idgestion = ?', [$id]);
            
            if (!$gestion) {
                return redirect()->route('admin.gestion.index')->with('error', 'Gestión no encontrada');
            }

            // Verificar si ya está cerrada
            if ($gestion->estado === '0') {
                return redirect()->route('admin.gestion.index')->with('info', 'La gestión ya está cerrada');
            }

            // Ejecutar SP para cerrar gestión
            DB::statement('EXEC sp_CerrarGestion ?', [$id]);

            return redirect()->route('admin.gestion.index')
                ->with('success', 'Gestión "' . $gestion->detalleges . '" cerrada exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('admin.gestion.index')
                ->with('error', 'Error al cerrar la gestión: ' . $e->getMessage());
        }
    }

    /**
     * Cerrar automáticamente todas las gestiones vencidas
     */
    public function cerrarVencidas()
    {
        try {
            // Ejecutar SP para cerrar gestiones vencidas
            $result = DB::select('EXEC sp_CerrarGestionesVencidas');
            
            $cantidad = $result[0]->GestionesCerradas ?? 0;
            
            if ($cantidad > 0) {
                return redirect()->route('admin.gestion.index')
                    ->with('success', "Se cerraron $cantidad gestión(es) vencida(s) automáticamente");
            } else {
                return redirect()->route('admin.gestion.index')
                    ->with('info', 'No hay gestiones vencidas para cerrar');
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.gestion.index')
                ->with('error', 'Error al cerrar gestiones vencidas: ' . $e->getMessage());
        }
    }
}
