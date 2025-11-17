<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SecretariaBecaController extends Controller
{
    /**
     * Mostrar listado de becas
     */
    public function index(Request $request)
    {
        $gestion = $request->get('gestion', null);
        $tipo = $request->get('tipo', null);
        
        // Consulta base
        $query = "
            SELECT 
                b.*,
                i.ci,
                p.nombre as estudiante_nombre,
                p.apellido as estudiante_apellido,
                p.codestudiante,
                g.detalleges as gestion,
                n.descripcion as nivel,
                c.descripcion as curso,
                i.observaciones,
                CASE 
                    WHEN b.tipobeca = '1' THEN 'Mérito Académico'
                    WHEN b.tipobeca = '2' THEN 'Familiar'
                    WHEN b.tipobeca = '3' THEN 'Económica'
                    ELSE 'Otra'
                END as tipo_beca_texto
            FROM beca b
            INNER JOIN inscripcion i ON b.codbeca = i.codbeca
            INNER JOIN persona p ON i.ci = p.ci
            INNER JOIN gestion g ON i.idgestion = g.idgestion
            INNER JOIN nivel n ON i.idnivel = n.idnivel
            INNER JOIN curso c ON i.idcurso = c.idcurso AND i.idnivel = c.idnivel
        ";
        
        $conditions = [];
        $params = [];
        
        if ($gestion) {
            $conditions[] = "g.detalleges = ?";
            $params[] = $gestion;
        }
        
        if ($tipo) {
            $conditions[] = "b.tipobeca = ?";
            $params[] = $tipo;
        }
        
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }
        
        $query .= " ORDER BY g.detalleges DESC, b.porcentaje DESC";
        
        $becas = DB::select($query, $params);
        
        // Obtener gestiones para filtro
        $gestiones = DB::select("SELECT DISTINCT detalleges as gestion FROM gestion ORDER BY detalleges DESC");
        
        // Calcular estadísticas
        $totalBecas = count($becas);
        $totalBecas100 = count(array_filter($becas, fn($b) => $b->porcentaje == 100));
        $promedioDescuento = $totalBecas > 0 ? array_sum(array_map(fn($b) => $b->porcentaje, $becas)) / $totalBecas : 0;
        
        return view('secretaria.beca.index', compact(
            'becas', 
            'gestiones', 
            'gestion', 
            'tipo',
            'totalBecas',
            'totalBecas100',
            'promedioDescuento'
        ));
    }

    /**
     * Mostrar formulario para asignar beca manual
     */
    public function create()
    {
        // Obtener estudiantes con inscripción activa sin beca
        $estudiantes = DB::select("
            SELECT 
                i.ci,
                p.nombre,
                p.apellido,
                p.codestudiante,
                g.detalleges as gestion,
                n.descripcion as nivel,
                c.descripcion as curso,
                i.idcurso,
                i.idnivel,
                i.idgestion
            FROM inscripcion i
            INNER JOIN persona p ON i.ci = p.ci
            INNER JOIN gestion g ON i.idgestion = g.idgestion
            INNER JOIN nivel n ON i.idnivel = n.idnivel
            INNER JOIN curso c ON i.idcurso = c.idcurso AND i.idnivel = c.idnivel
            WHERE p.tipoe = '1' 
              AND i.codbeca IS NULL
            ORDER BY g.detalleges DESC, p.nombre, p.apellido
        ");
        
        return view('secretaria.beca.create', compact('estudiantes'));
    }

    /**
     * Asignar beca manual
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'ci' => 'required|string|max:10|exists:persona,ci',
            'idcurso' => 'required|integer',
            'idnivel' => 'required|integer',
            'idgestion' => 'required|integer',
            'nombrebeca' => 'required|string|max:100',
            'tipobeca' => 'required|in:1,2,3',
            'porcentaje' => 'required|integer|min:1|max:100',
            'observacion' => 'nullable|string|max:200',
        ]);

        try {
            DB::beginTransaction();
            
            // Verificar que la inscripción no tenga beca
            $inscripcion = DB::selectOne("
                SELECT * FROM inscripcion 
                WHERE ci = ? AND idcurso = ? AND idnivel = ? AND idgestion = ?
            ", [$data['ci'], $data['idcurso'], $data['idnivel'], $data['idgestion']]);
            
            if (!$inscripcion) {
                return back()->withInput()->with('error', 'Inscripción no encontrada');
            }
            
            if ($inscripcion->codbeca) {
                return back()->withInput()->with('error', 'El estudiante ya tiene una beca asignada');
            }
            
            // Crear beca
            DB::statement('EXEC sp_InsertarBeca ?, ?, ?', [
                $data['nombrebeca'],
                $data['tipobeca'],
                $data['porcentaje'],
            ]);
            
            // Obtener el código de beca recién creado
            $beca = DB::selectOne("SELECT TOP 1 codbeca FROM beca ORDER BY codbeca DESC");
            
            if ($beca) {
                // Actualizar inscripción con la beca
                DB::statement("
                    UPDATE inscripcion 
                    SET codbeca = ?, observaciones = ?
                    WHERE ci = ? AND idcurso = ? AND idnivel = ? AND idgestion = ?
                ", [
                    $beca->codbeca, 
                    $data['observacion'] ?? 'Beca asignada manualmente',
                    $data['ci'],
                    $data['idcurso'],
                    $data['idnivel'],
                    $data['idgestion']
                ]);
            }
            
            DB::commit();
            
            return redirect()->route('secretaria.beca.index')
                ->with('success', 'Beca asignada exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error al asignar beca: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar vista para ejecutar becas automáticas
     */
    public function automaticas()
    {
        // Obtener gestiones disponibles
        $gestiones = DB::select("SELECT * FROM gestion ORDER BY detalleges DESC");
        
        return view('secretaria.beca.automaticas', compact('gestiones'));
    }

    /**
     * Ejecutar becas automáticas
     */
    public function ejecutarAutomaticas(Request $request)
    {
        $data = $request->validate([
            'idgestion' => 'required|integer|exists:gestion,idgestion',
        ]);

        try {
            // Ejecutar procedimiento de becas automáticas
            $resultado = DB::select('EXEC sp_EjecutarBecasAutomaticas ?', [$data['idgestion']]);
            
            if (!empty($resultado)) {
                $res = $resultado[0];
                return redirect()->route('secretaria.beca.index')
                    ->with('success', $res->Mensaje . '. Total: ' . $res->TotalBecas . ' becas (' . 
                           $res->BecasMejorEstudiante . ' mejor estudiante, ' . 
                           $res->BecasTercerHijo . ' tercer hijo)');
            }
            
            return redirect()->route('secretaria.beca.index')
                ->with('success', 'Becas automáticas ejecutadas');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al ejecutar becas automáticas: ' . $e->getMessage());
        }
    }

    /**
     * Quitar beca de un estudiante
     */
    public function quitar(Request $request)
    {
        $data = $request->validate([
            'ci' => 'required|string|max:10',
            'idcurso' => 'required|integer',
            'idnivel' => 'required|integer',
            'idgestion' => 'required|integer',
        ]);

        try {
            DB::beginTransaction();
            
            // Obtener inscripción
            $inscripcion = DB::selectOne("
                SELECT * FROM inscripcion 
                WHERE ci = ? AND idcurso = ? AND idnivel = ? AND idgestion = ?
            ", [$data['ci'], $data['idcurso'], $data['idnivel'], $data['idgestion']]);
            
            if (!$inscripcion || !$inscripcion->codbeca) {
                return back()->with('error', 'El estudiante no tiene beca asignada');
            }
            
            // Eliminar beca
            DB::statement("DELETE FROM beca WHERE codbeca = ?", [$inscripcion->codbeca]);
            
            // Actualizar inscripción
            DB::statement("
                UPDATE inscripcion 
                SET codbeca = NULL, observaciones = 'Beca removida'
                WHERE ci = ? AND idcurso = ? AND idnivel = ? AND idgestion = ?
            ", [$data['ci'], $data['idcurso'], $data['idnivel'], $data['idgestion']]);
            
            DB::commit();
            
            return redirect()->route('secretaria.beca.index')
                ->with('success', 'Beca removida exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al quitar beca: ' . $e->getMessage());
        }
    }

    /**
     * Ver detalle de beca
     */
    public function show($codbeca)
    {
        $beca = DB::selectOne("
            SELECT 
                b.*,
                i.ci,
                i.observaciones,
                p.nombre as estudiante_nombre,
                p.apellido as estudiante_apellido,
                p.codestudiante,
                p.correo as estudiante_correo,
                p.telefono as estudiante_telefono,
                g.detalleges as gestion,
                g.fechaapertura,
                g.fechacierre,
                n.descripcion as nivel,
                c.descripcion as curso,
                t.nombre as tutor_nombre,
                t.apellido as tutor_apellido,
                CASE 
                    WHEN b.tipobeca = '1' THEN 'Mérito Académico'
                    WHEN b.tipobeca = '2' THEN 'Familiar'
                    WHEN b.tipobeca = '3' THEN 'Económica'
                    ELSE 'Otra'
                END as tipo_beca_texto
            FROM beca b
            INNER JOIN inscripcion i ON b.codbeca = i.codbeca
            INNER JOIN persona p ON i.ci = p.ci
            INNER JOIN persona t ON i.citutor = t.ci
            INNER JOIN gestion g ON i.idgestion = g.idgestion
            INNER JOIN nivel n ON i.idnivel = n.idnivel
            INNER JOIN curso c ON i.idcurso = c.idcurso AND i.idnivel = c.idnivel
            WHERE b.codbeca = ?
        ", [$codbeca]);

        if (!$beca) {
            return redirect()->route('secretaria.beca.index')->with('error', 'Beca no encontrada');
        }

        return view('secretaria.beca.show', compact('beca'));
    }
}
