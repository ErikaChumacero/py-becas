<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BecaController extends Controller
{
    public function index()
    {
        // Obtener todas las becas con conteo de inscripciones
        $becas = DB::select(
            'SELECT b.codbeca, b.nombrebeca, b.tipobeca, b.porcentaje,
                    COUNT(i.ci) AS total_estudiantes
             FROM beca b
             LEFT JOIN inscripcion i ON b.codbeca = i.codbeca
             GROUP BY b.codbeca, b.nombrebeca, b.tipobeca, b.porcentaje
             ORDER BY b.codbeca'
        );
        
        return view('admin.beca.index', compact('becas'));
    }

    public function create()
    {
        return view('admin.beca.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombrebeca' => 'required|string|max:100',
            'tipobeca' => 'required|string|max:1|in:C,P', // C=Completa, P=Parcial
            'porcentaje' => 'required|integer|min:1|max:100',
        ]);

        // Validar que el nombre de beca no esté duplicado
        $exists = DB::selectOne(
            'SELECT 1 FROM beca WHERE nombrebeca = ?',
            [$data['nombrebeca']]
        );
        if ($exists) {
            return back()->withErrors(['nombrebeca' => 'Ya existe una beca con este nombre'])->withInput();
        }

        // Validar lógica de negocio
        if ($data['tipobeca'] === 'C' && $data['porcentaje'] != 100) {
            return back()->withErrors(['porcentaje' => 'Una beca completa debe tener 100% de descuento'])->withInput();
        }

        if ($data['tipobeca'] === 'P' && $data['porcentaje'] >= 100) {
            return back()->withErrors(['porcentaje' => 'Una beca parcial debe tener menos de 100% de descuento'])->withInput();
        }

        try {
            // SP: sp_InsertarBeca (@nombrebeca, @tipobeca, @porcentaje)
            DB::statement(
                'EXEC sp_InsertarBeca ?, ?, ?',
                [
                    $data['nombrebeca'],
                    $data['tipobeca'],
                    $data['porcentaje']
                ]
            );

            return redirect()->route('admin.beca.index')->with('success', 'Beca creada exitosamente');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al crear la beca: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        $beca = DB::selectOne(
            'SELECT codbeca, nombrebeca, tipobeca, porcentaje FROM beca WHERE codbeca = ?',
            [$id]
        );
        
        if (!$beca) {
            return redirect()->route('admin.beca.index')->with('error', 'Beca no encontrada');
        }

        // Obtener información de dependencias
        $estudiantes = DB::select(
            'SELECT COUNT(*) AS total FROM inscripcion WHERE codbeca = ?',
            [$id]
        );
        $totalEstudiantes = $estudiantes[0]->total ?? 0;
        
        return view('admin.beca.edit', compact('beca', 'totalEstudiantes'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nombrebeca' => 'required|string|max:100',
            'tipobeca' => 'required|string|max:1|in:C,P',
            'porcentaje' => 'required|integer|min:1|max:100',
        ]);

        // Validar que el nombre no esté duplicado (excepto para esta beca)
        $exists = DB::selectOne(
            'SELECT 1 FROM beca WHERE nombrebeca = ? AND codbeca != ?',
            [$data['nombrebeca'], $id]
        );
        if ($exists) {
            return back()->withErrors(['nombrebeca' => 'Ya existe otra beca con este nombre'])->withInput();
        }

        // Validar lógica de negocio
        if ($data['tipobeca'] === 'C' && $data['porcentaje'] != 100) {
            return back()->withErrors(['porcentaje' => 'Una beca completa debe tener 100% de descuento'])->withInput();
        }

        if ($data['tipobeca'] === 'P' && $data['porcentaje'] >= 100) {
            return back()->withErrors(['porcentaje' => 'Una beca parcial debe tener menos de 100% de descuento'])->withInput();
        }

        try {
            // SP: sp_ActualizarBeca (@codbeca, @nombrebeca, @tipobeca, @porcentaje)
            DB::statement(
                'EXEC sp_ActualizarBeca ?, ?, ?, ?',
                [
                    $id,
                    $data['nombrebeca'],
                    $data['tipobeca'],
                    $data['porcentaje']
                ]
            );

            return redirect()->route('admin.beca.index')->with('success', 'Beca actualizada exitosamente');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al actualizar la beca: ' . $e->getMessage()])->withInput();
        }
    }

    public function ejecutarBecasAutomaticas(Request $request)
    {
        $data = $request->validate([
            'idgestion' => 'required|integer|exists:gestion,idgestion',
        ]);

        try {
            $result = DB::select('EXEC sp_EjecutarBecasAutomaticas ?', [$data['idgestion']]);
            
            if (!empty($result)) {
                $total = $result[0]->TotalBecas ?? 0;
                $mejorEstudiante = $result[0]->BecasMejorEstudiante ?? 0;
                $tercerHijo = $result[0]->BecasTercerHijo ?? 0;
                
                $mensaje = "Becas automáticas ejecutadas: Total: $total | Mejor Estudiante: $mejorEstudiante | Tercer Hijo: $tercerHijo";
                
                return redirect()->route('admin.beca.index')->with('success', $mensaje);
            }
            
            return redirect()->route('admin.beca.index')->with('info', 'No se asignaron becas automáticas');
        } catch (\Exception $e) {
            return redirect()->route('admin.beca.index')
                ->with('error', 'Error al ejecutar becas automáticas: ' . $e->getMessage());
        }
    }
}
