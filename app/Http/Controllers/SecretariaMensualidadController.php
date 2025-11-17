<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SecretariaMensualidadController extends Controller
{
    /**
     * Mostrar listado de mensualidades
     */
    public function index(Request $request)
    {
        $gestion = $request->get('gestion', null);
        $estado = $request->get('estado', null);
        
        // Consulta base
        $query = "
            SELECT 
                m.*,
                p.nombre as estudiante_nombre,
                p.apellido as estudiante_apellido,
                p.codestudiante,
                g.detalleges as gestion,
                n.descripcion as nivel,
                c.descripcion as curso,
                dm.descripcion as detalle_descripcion,
                dm.monto,
                dm.montototal,
                dm.descuento,
                b.porcentaje as beca_porcentaje,
                CASE 
                    WHEN m.tipopago = 'E' THEN 'Efectivo'
                    WHEN m.tipopago = 'Q' THEN 'QR'
                    ELSE 'Otro'
                END as tipo_pago_texto
            FROM mensualidad m
            INNER JOIN persona p ON m.ci = p.ci
            INNER JOIN inscripcion i ON m.ci = i.ci AND m.idcurso = i.idcurso AND m.idnivel = i.idnivel
            INNER JOIN gestion g ON i.idgestion = g.idgestion
            INNER JOIN nivel n ON m.idnivel = n.idnivel
            INNER JOIN curso c ON m.idcurso = c.idcurso AND m.idnivel = c.idnivel
            INNER JOIN detallemensualidad dm ON m.iddetallemensualidad = dm.iddetallemensualidad
            LEFT JOIN beca b ON b.codbeca = i.codbeca
        ";
        
        $conditions = [];
        $params = [];
        
        if ($gestion) {
            $conditions[] = "g.detalleges = ?";
            $params[] = $gestion;
        }
        
        if ($estado) {
            $conditions[] = "dm.estado = ?";
            $params[] = $estado;
        }
        
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }
        
        $query .= " ORDER BY m.fechamen DESC";
        
        $mensualidades = DB::select($query, $params);
        
        // Obtener gestiones para filtro
        $gestiones = DB::select("SELECT DISTINCT detalleges as gestion FROM gestion ORDER BY detalleges DESC");
        
        // Calcular estadísticas
        $totalMensualidades = count($mensualidades);
        $totalMonto = array_sum(array_map(fn($m) => $m->montototal, $mensualidades));
        $totalDescuentos = array_sum(array_map(fn($m) => ($m->monto - $m->montototal), $mensualidades));
        
        return view('secretaria.mensualidad.index', compact(
            'mensualidades', 
            'gestiones', 
            'gestion', 
            'estado',
            'totalMensualidades',
            'totalMonto',
            'totalDescuentos'
        ));
    }

    /**
     * Mostrar formulario para registrar pago
     */
    public function create()
    {
        // Obtener estudiantes con inscripción activa
        $estudiantes = DB::select("
            SELECT DISTINCT
                p.ci,
                p.nombre,
                p.apellido,
                p.codestudiante
            FROM persona p
            INNER JOIN inscripcion i ON p.ci = i.ci
            WHERE p.tipoe = '1'
            ORDER BY p.nombre, p.apellido
        ");
        
        // Obtener detalles de mensualidad disponibles
        $detalles = DB::select("
            SELECT 
                dm.*,
                g.detalleges as gestion
            FROM detallemensualidad dm
            INNER JOIN gestion g ON dm.idgestion = g.idgestion
            WHERE dm.estado = '1'
            ORDER BY g.detalleges DESC, dm.descripcion
        ");
        
        return view('secretaria.mensualidad.create', compact('estudiantes', 'detalles'));
    }

    /**
     * Guardar nuevo pago de mensualidad
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'ci' => 'required|string|max:10|exists:persona,ci',
            'idcurso' => 'required|integer|exists:curso,idcurso',
            'idnivel' => 'required|integer|exists:nivel,idnivel',
            'iddetallemensualidad' => 'required|integer|exists:detallemensualidad,iddetallemensualidad',
            'tipopago' => 'required|in:E,Q',
            'observacion' => 'nullable|string|max:200',
        ]);

        try {
            \Log::info('=== INICIANDO REGISTRO DE PAGO ===');
            \Log::info('Datos recibidos:', $data);

            // Verificar que el estudiante tenga inscripción activa
            $inscripcion = DB::selectOne("
                SELECT i.*, p.nombre, p.apellido, p.codestudiante
                FROM inscripcion i
                INNER JOIN persona p ON i.ci = p.ci
                WHERE i.ci = ? AND i.idcurso = ? AND i.idnivel = ?
            ", [$data['ci'], $data['idcurso'], $data['idnivel']]);
            
            if (!$inscripcion) {
                \Log::error('Inscripción no encontrada', $data);
                return back()->withInput()->with('error', 'El estudiante no tiene inscripción activa en ese curso y nivel');
            }

            \Log::info('Inscripción encontrada:', [
                'estudiante' => $inscripcion->nombre . ' ' . $inscripcion->apellido,
                'codigo' => $inscripcion->codestudiante
            ]);

            // Obtener detalle de mensualidad
            $detalle = DB::selectOne("SELECT * FROM detallemensualidad WHERE iddetallemensualidad = ?", [$data['iddetallemensualidad']]);
            
            // Insertar mensualidad
            DB::statement('EXEC sp_InsertarMensualidad ?, ?, ?, ?, ?, ?, ?', [
                now()->format('Y-m-d'),
                $data['observacion'] ?? 'Pago registrado',
                $data['tipopago'],
                $data['iddetallemensualidad'],
                $data['ci'],
                $data['idcurso'],
                $data['idnivel'],
            ]);

            \Log::info('Mensualidad insertada exitosamente');

            // Construir mensaje de éxito
            $tipoPagoTexto = $data['tipopago'] == 'E' ? 'Efectivo' : 'QR';
            $mensaje = '✓ Pago registrado exitosamente';
            $mensaje .= ' - Estudiante: ' . $inscripcion->nombre . ' ' . $inscripcion->apellido;
            $mensaje .= ' - Concepto: ' . $detalle->descripcion;
            $mensaje .= ' - Tipo de pago: ' . $tipoPagoTexto;

            // Si el estudiante tiene beca, agregar al mensaje
            if ($inscripcion->codbeca) {
                $beca = DB::selectOne("SELECT * FROM beca WHERE codbeca = ?", [$inscripcion->codbeca]);
                
                if ($beca && $beca->porcentaje > 0) {
                    $mensaje .= ' - Beca aplicada: ' . $beca->porcentaje . '%';
                    \Log::info('Beca aplicada: ' . $beca->porcentaje . '%');
                }
            }

            \Log::info('✓ PAGO REGISTRADO EXITOSAMENTE');

            return redirect()->route('secretaria.mensualidad.index')
                ->with('success', $mensaje);
        } catch (\Exception $e) {
            \Log::error('❌ ERROR AL REGISTRAR PAGO', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $data
            ]);
            return back()->withInput()->with('error', 'Error al registrar pago: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar detalle de mensualidad
     */
    public function show($id)
    {
        $mensualidad = DB::selectOne("
            SELECT 
                m.*,
                p.nombre as estudiante_nombre,
                p.apellido as estudiante_apellido,
                p.codestudiante,
                p.correo as estudiante_correo,
                p.telefono as estudiante_telefono,
                g.detalleges as gestion,
                g.fechaapertura as gestion_inicio,
                g.fechacierre as gestion_fin,
                n.descripcion as nivel,
                c.descripcion as curso,
                dm.descripcion as detalle_descripcion,
                dm.monto,
                dm.montototal,
                dm.descuento,
                dm.nodescuento,
                b.porcentaje as beca_porcentaje,
                b.nombrebeca,
                CASE 
                    WHEN m.tipopago = '1' THEN 'Efectivo'
                    WHEN m.tipopago = '2' THEN 'Tarjeta'
                    WHEN m.tipopago = '3' THEN 'Transferencia'
                    ELSE 'Otro'
                END as tipo_pago_texto
            FROM mensualidad m
            INNER JOIN persona p ON m.ci = p.ci
            INNER JOIN inscripcion i ON m.ci = i.ci AND m.idcurso = i.idcurso AND m.idnivel = i.idnivel
            INNER JOIN gestion g ON i.idgestion = g.idgestion
            INNER JOIN nivel n ON m.idnivel = n.idnivel
            INNER JOIN curso c ON m.idcurso = c.idcurso AND m.idnivel = c.idnivel
            INNER JOIN detallemensualidad dm ON m.iddetallemensualidad = dm.iddetallemensualidad
            LEFT JOIN beca b ON b.codbeca = i.codbeca
            WHERE m.idmensualidad = ?
        ", [$id]);

        if (!$mensualidad) {
            return redirect()->route('secretaria.mensualidad.index')->with('error', 'Mensualidad no encontrada');
        }

        return view('secretaria.mensualidad.show', compact('mensualidad'));
    }

    /**
     * Actualizar observación de mensualidad
     */
    public function updateObservacion(Request $request, $id)
    {
        $request->validate([
            'observacion' => 'nullable|string|max:200',
        ]);

        try {
            DB::statement("UPDATE mensualidad SET observacion = ? WHERE idmensualidad = ?", [
                $request->observacion,
                $id
            ]);

            return redirect()->route('secretaria.mensualidad.show', $id)
                ->with('success', 'Observación actualizada correctamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar observación: ' . $e->getMessage());
        }
    }

    /**
     * Obtener inscripción del estudiante (AJAX)
     */
    public function getInscripcion($ci)
    {
        $inscripciones = DB::select("
            SELECT 
                i.*,
                g.detalleges as gestion,
                n.descripcion as nivel,
                c.descripcion as curso,
                b.porcentaje as beca_porcentaje
            FROM inscripcion i
            INNER JOIN gestion g ON i.idgestion = g.idgestion
            INNER JOIN nivel n ON i.idnivel = n.idnivel
            INNER JOIN curso c ON i.idcurso = c.idcurso AND i.idnivel = c.idnivel
            LEFT JOIN beca b ON b.codbeca = i.codbeca
            WHERE i.ci = ?
            ORDER BY g.detalleges DESC
        ", [$ci]);

        return response()->json($inscripciones);
    }

    /**
     * Calcular monto con descuentos (AJAX)
     */
    public function calcularMonto(Request $request)
    {
        $iddetalle = $request->get('iddetalle');
        $ci = $request->get('ci');
        $idcurso = $request->get('idcurso');
        $idnivel = $request->get('idnivel');

        // Obtener detalle de mensualidad
        $detalle = DB::selectOne("SELECT * FROM detallemensualidad WHERE iddetallemensualidad = ?", [$iddetalle]);
        
        if (!$detalle) {
            return response()->json(['error' => 'Detalle no encontrado'], 404);
        }

        $montoBase = $detalle->monto;
        $descuentoBase = $detalle->descuento;
        $montoConDescuento = $montoBase - ($montoBase * $descuentoBase / 100);

        // Verificar si tiene beca
        $beca = null;
        if ($ci && $idcurso && $idnivel) {
            $inscripcion = DB::selectOne("
                SELECT i.*, b.porcentaje as beca_porcentaje 
                FROM inscripcion i
                LEFT JOIN beca b ON b.codbeca = i.codbeca
                WHERE i.ci = ? AND i.idcurso = ? AND i.idnivel = ?
            ", [$ci, $idcurso, $idnivel]);
            
            if ($inscripcion && $inscripcion->beca_porcentaje > 0) {
                $beca = $inscripcion->beca_porcentaje;
                // Aplicar beca sobre el monto ya con descuento
                if ($detalle->nodescuento == '0') { // Si permite descuento adicional
                    $montoConDescuento = $montoConDescuento - ($montoConDescuento * $beca / 100);
                }
            }
        }

        return response()->json([
            'monto_base' => $montoBase,
            'descuento_base' => $descuentoBase,
            'beca_porcentaje' => $beca,
            'monto_final' => $montoConDescuento,
            'permite_descuento' => $detalle->nodescuento == '0',
        ]);
    }
}
