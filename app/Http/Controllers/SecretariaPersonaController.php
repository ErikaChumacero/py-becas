<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SecretariaPersonaController extends Controller
{
    /**
     * Mostrar listado de estudiantes y tutores con búsqueda y paginación
     */
    public function index(Request $request)
    {
        $tipo = $request->get('tipo', 'estudiantes');
        $buscar = $request->get('buscar', '');
        $page = $request->get('page', 1);
        $perPage = 5;
        $offset = ($page - 1) * $perPage;
        
        // Construir WHERE para búsqueda
        $whereSearch = '';
        $params = [];
        
        if ($buscar) {
            $whereSearch = " AND (p.ci LIKE ? OR p.nombre LIKE ? OR p.apellido LIKE ?)";
            $searchTerm = "%{$buscar}%";
            $params = [$searchTerm, $searchTerm, $searchTerm];
        }
        
        if ($tipo === 'estudiantes') {
            // Contar total de estudiantes
            $totalQuery = "SELECT COUNT(DISTINCT p.ci) as total 
                          FROM persona p 
                          WHERE p.tipoe = '1' {$whereSearch}";
            $total = DB::selectOne($totalQuery, $params)->total;
            
            // Consulta para estudiantes con información de su tutor (con paginación)
            $query = "SELECT DISTINCT
                        p.ci, p.nombre, p.apellido, p.correo, p.telefono, p.sexo, 
                        p.fecharegistro, p.tipoe, p.tipot, p.codestudiante,
                        t.ci as tutor_ci, t.nombre as tutor_nombre, t.apellido as tutor_apellido,
                        t.telefono as tutor_telefono
                    FROM persona p
                    LEFT JOIN inscripcion i ON p.ci = i.ci
                    LEFT JOIN persona t ON i.citutor = t.ci
                    WHERE p.tipoe = '1' {$whereSearch}
                    ORDER BY p.fecharegistro DESC
                    OFFSET {$offset} ROWS FETCH NEXT {$perPage} ROWS ONLY";
            
            $personas = DB::select($query, $params);
            
        } elseif ($tipo === 'tutores') {
            // Contar total de tutores
            $totalQuery = "SELECT COUNT(DISTINCT p.ci) as total 
                          FROM persona p 
                          WHERE p.tipot = '1' {$whereSearch}";
            $total = DB::selectOne($totalQuery, $params)->total;
            
            // Consulta para tutores con cantidad de hijos (con paginación)
            $query = "SELECT 
                        p.ci, p.nombre, p.apellido, p.correo, p.telefono, p.sexo, 
                        p.fecharegistro, p.tipoe, p.tipot,
                        COUNT(DISTINCT i.ci) as total_hijos
                    FROM persona p
                    LEFT JOIN inscripcion i ON p.ci = i.citutor
                    WHERE p.tipot = '1' {$whereSearch}
                    GROUP BY p.ci, p.nombre, p.apellido, p.correo, p.telefono, p.sexo, p.fecharegistro, p.tipoe, p.tipot
                    ORDER BY p.fecharegistro DESC
                    OFFSET {$offset} ROWS FETCH NEXT {$perPage} ROWS ONLY";
            
            $personas = DB::select($query, $params);
        } else {
            $total = 0;
            $personas = [];
        }
        
        // Calcular paginación
        $lastPage = ceil($total / $perPage);
        $from = $total > 0 ? $offset + 1 : 0;
        $to = min($offset + $perPage, $total);
        
        $pagination = [
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => $lastPage,
            'from' => $from,
            'to' => $to,
        ];
        
        return view('secretaria.persona.index', compact('personas', 'tipo', 'buscar', 'pagination'));
    }

    /**
     * Mostrar formulario para crear nuevo estudiante
     */
    public function create()
    {
        // Obtener lista de tutores disponibles para vincular
        $tutores = DB::select("SELECT ci, nombre, apellido, correo FROM persona WHERE tipot = '1' ORDER BY nombre, apellido");
        
        return view('secretaria.persona.create', compact('tutores'));
    }

    /**
     * Guardar nueva persona (estudiante O tutor)
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'ci' => 'required|string|max:10|unique:persona,ci',
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:15',
            'sexo' => 'required|in:M,F',
            'citutor' => 'nullable|string|max:10|exists:persona,ci',
            'tipo_persona' => 'required|in:estudiante,tutor',
        ]);

        // Validar que si es estudiante, debe tener tutor
        if ($data['tipo_persona'] === 'estudiante' && empty($data['citutor'])) {
            return back()->withInput()->withErrors(['citutor' => 'Un estudiante debe tener un tutor asignado']);
        }

        try {
            // Determinar tipos según selección
            $tipoe = $data['tipo_persona'] === 'estudiante' ? '1' : '0';
            $tipot = $data['tipo_persona'] === 'tutor' ? '1' : '0';

            // 1. GENERAR CÓDIGO DE ESTUDIANTE AUTOMÁTICO (solo si es estudiante)
            $codestudiante = null;
            if ($tipoe === '1') {
                $ultimoCodigo = DB::selectOne("SELECT TOP 1 codestudiante FROM persona WHERE tipoe = '1' AND codestudiante IS NOT NULL ORDER BY codestudiante DESC");
                if ($ultimoCodigo && $ultimoCodigo->codestudiante) {
                    $numero = intval(substr($ultimoCodigo->codestudiante, 4)) + 1;
                } else {
                    $numero = 1;
                }
                $codestudiante = 'EST-' . str_pad($numero, 4, '0', STR_PAD_LEFT);
            }

            // 2. GENERAR CORREO AUTOMÁTICO ÚNICO
            $nombreLimpio = strtolower(trim($data['nombre']));
            $apellidoLimpio = strtolower(trim($data['apellido']));
            $correoBase = $nombreLimpio . '.' . $apellidoLimpio . '@escuelacristiana.edu.bo';
            
            // Verificar si el correo ya existe
            $correo = $correoBase;
            $contador = 2;
            while (DB::selectOne("SELECT ci FROM persona WHERE correo = ?", [$correo])) {
                $correo = $nombreLimpio . '.' . $apellidoLimpio . $contador . '@escuelacristiana.edu.bo';
                $contador++;
            }

            // 3. CONTRASEÑA AUTOMÁTICA = CI
            $contrasena = $data['ci'];

            // Solo los tutores son usuarios (tienen acceso al sistema)
            $tipou = $tipot; // Si es tutor (tipot='1'), entonces es usuario (tipou='1')
            
            // Insertar persona usando procedimiento almacenado
            DB::statement('EXEC sp_InsertarPersona ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?', [
                $data['ci'],
                $data['nombre'],
                $data['apellido'],
                $correo,
                $data['telefono'] ?? null,
                $data['sexo'],
                $contrasena,
                now()->format('Y-m-d'),
                $tipou, // tipou (solo tutores son usuarios)
                $tipoe, // tipoe
                $tipot, // tipot
                '0', // tipom
                '0', // tipoa
                '0', // tipos
                $codestudiante,
                null, // codmaestro
            ]);

            // Si es estudiante, crear registro en inscripcion para vincular con tutor
            if ($tipoe === '1' && !empty($data['citutor'])) {
                // Obtener la gestión activa actual
                $gestionActiva = DB::selectOne("SELECT TOP 1 idgestion FROM gestion WHERE estado = '1' ORDER BY fechaapertura DESC");
                
                if ($gestionActiva) {
                    // Insertar inscripción básica para vincular estudiante con tutor
                    // Nota: Los campos de nivel, curso, etc. se completarán cuando se haga la inscripción formal
                    DB::statement("
                        INSERT INTO inscripcion (ci, citutor, idgestion, fecharegis, idnivel, idcurso, codbeca)
                        VALUES (?, ?, ?, GETDATE(), 1, 1, NULL)
                    ", [
                        $data['ci'],
                        $data['citutor'],
                        $gestionActiva->idgestion
                    ]);
                }
            }

            // Limpiar caché de consultas
            DB::statement("DBCC FREEPROCCACHE");
            
            // Mensaje de éxito según el tipo
            $mensaje = $data['tipo_persona'] === 'estudiante' 
                ? "✓ Estudiante registrado exitosamente. Código: {$codestudiante} | Correo: {$correo} | Contraseña: {$contrasena}" 
                : "✓ Tutor registrado exitosamente. Correo: {$correo} | Contraseña: {$contrasena}";

            return redirect()->route('secretaria.persona.index', ['tipo' => $data['tipo_persona'] === 'estudiante' ? 'estudiantes' : 'tutores', '_' => time()])
                ->with('success', $mensaje);
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Error al registrar persona: ' . $e->getMessage()]);
        }
    }

    /**
     * Mostrar información completa del estudiante
     */
    public function show($ci)
    {
        // Obtener datos del estudiante
        $estudiante = DB::selectOne("SELECT * FROM persona WHERE ci = ? AND tipoe = '1'", [$ci]);
        
        if (!$estudiante) {
            return redirect()->route('secretaria.persona.index')->with('error', 'Estudiante no encontrado');
        }

        // Obtener tutor actual
        $tutor = DB::selectOne("
            SELECT TOP 1 p.* 
            FROM inscripcion i 
            INNER JOIN persona p ON i.citutor = p.ci 
            WHERE i.ci = ?
            ORDER BY i.fecharegis DESC
        ", [$ci]);

        // Obtener inscripciones con información completa
        $inscripciones = DB::select("
            SELECT 
                i.*,
                g.detalleges as gestion,
                g.fechaapertura as gestion_inicio,
                g.fechacierre as gestion_fin,
                n.descripcion as nivel,
                c.descripcion as curso
            FROM inscripcion i
            INNER JOIN gestion g ON i.idgestion = g.idgestion
            INNER JOIN nivel n ON i.idnivel = n.idnivel
            INNER JOIN curso c ON i.idcurso = c.idcurso AND i.idnivel = c.idnivel
            WHERE i.ci = ?
            ORDER BY g.detalleges DESC, i.fecharegis DESC
        ", [$ci]);

        // Obtener mensualidades pagadas
        $mensualidades = DB::select("
            SELECT 
                m.idmensualidad,
                m.fechamen,
                m.observacion,
                m.tipopago,
                dm.descripcion as mes,
                dm.montototal as monto,
                dm.iddetallemensualidad,
                g.detalleges as gestion,
                g.idgestion,
                n.descripcion as nivel,
                c.descripcion as curso
            FROM mensualidad m
            INNER JOIN detallemensualidad dm ON m.iddetallemensualidad = dm.iddetallemensualidad
            INNER JOIN inscripcion i ON m.ci = i.ci AND m.idcurso = i.idcurso AND m.idnivel = i.idnivel
            INNER JOIN gestion g ON i.idgestion = g.idgestion
            INNER JOIN nivel n ON m.idnivel = n.idnivel
            INNER JOIN curso c ON m.idcurso = c.idcurso AND m.idnivel = c.idnivel
            WHERE m.ci = ?
            ORDER BY g.detalleges DESC, m.fechamen DESC
        ", [$ci]);

        // Obtener mensualidades pendientes por gestión
        // Genera una lista de N meses según cantidadmesualidades
        $mensualidadesPendientes = DB::select("
            WITH InscripcionReciente AS (
                SELECT 
                    i.ci,
                    i.idgestion,
                    i.idcurso,
                    i.idnivel,
                    ROW_NUMBER() OVER (PARTITION BY i.ci, i.idgestion ORDER BY i.fecharegis DESC) as rn
                FROM inscripcion i
                WHERE i.ci = ?
            ),
            DetalleUnico AS (
                -- Tomar solo UN detallemensualidad por gestión (el primero)
                SELECT 
                    dm.iddetallemensualidad,
                    dm.descripcion,
                    dm.monto,
                    dm.montototal,
                    dm.descuento,
                    dm.cantidadmesualidades,
                    dm.idgestion,
                    ROW_NUMBER() OVER (PARTITION BY dm.idgestion ORDER BY dm.iddetallemensualidad) as rn_detalle
                FROM detallemensualidad dm
                WHERE dm.estado = '1'
            ),
            PagosRealizados AS (
                -- Contar cuántos pagos se han realizado por gestión
                SELECT 
                    ir.ci,
                    ir.idgestion,
                    COUNT(m.idmensualidad) as total_pagados
                FROM InscripcionReciente ir
                LEFT JOIN mensualidad m ON m.ci = ir.ci 
                    AND m.idcurso = ir.idcurso 
                    AND m.idnivel = ir.idnivel
                LEFT JOIN detallemensualidad dm ON m.iddetallemensualidad = dm.iddetallemensualidad
                WHERE ir.rn = 1
                AND (dm.idgestion = ir.idgestion OR dm.idgestion IS NULL)
                GROUP BY ir.ci, ir.idgestion
            ),
            NumerosMensualidades AS (
                -- Generar números del 1 al máximo de cantidadmesualidades
                SELECT TOP 12 ROW_NUMBER() OVER (ORDER BY (SELECT NULL)) as numero_mes
                FROM sys.objects
            ),
            MensualidadesGeneradas AS (
                SELECT 
                    ir.ci,
                    ir.idgestion,
                    ir.idcurso,
                    ir.idnivel,
                    g.detalleges as gestion,
                    du.iddetallemensualidad,
                    CAST(nm.numero_mes AS VARCHAR) as mes,
                    du.monto,
                    du.montototal,
                    du.descuento,
                    du.cantidadmesualidades,
                    nm.numero_mes,
                    CASE 
                        WHEN nm.numero_mes <= ISNULL(pr.total_pagados, 0) THEN 1 
                        ELSE 0 
                    END as pagado
                FROM InscripcionReciente ir
                INNER JOIN gestion g ON ir.idgestion = g.idgestion
                INNER JOIN DetalleUnico du ON du.idgestion = g.idgestion AND du.rn_detalle = 1
                LEFT JOIN PagosRealizados pr ON pr.ci = ir.ci AND pr.idgestion = ir.idgestion
                CROSS JOIN NumerosMensualidades nm
                WHERE ir.rn = 1
                AND nm.numero_mes <= du.cantidadmesualidades
            )
            SELECT * FROM MensualidadesGeneradas
            ORDER BY gestion DESC, numero_mes
        ", [$ci]);

        // Obtener becas activas
        $becas = DB::select("
            SELECT 
                b.*,
                g.detalleges as gestion
            FROM beca b
            INNER JOIN inscripcion i ON b.codbeca = i.codbeca
            INNER JOIN gestion g ON i.idgestion = g.idgestion
            WHERE i.ci = ?
            ORDER BY g.detalleges DESC
        ", [$ci]);

        return view('secretaria.persona.show', compact('estudiante', 'tutor', 'inscripciones', 'mensualidades', 'mensualidadesPendientes', 'becas'));
    }

    /**
     * Mostrar formulario para editar estudiante
     */
    public function edit($ci)
    {
        $persona = DB::selectOne("SELECT * FROM persona WHERE ci = ?", [$ci]);
        
        if (!$persona) {
            return redirect()->route('secretaria.persona.index')->with('error', 'Persona no encontrada');
        }

        // Obtener tutores disponibles
        $tutores = DB::select("SELECT ci, nombre, apellido, correo FROM persona WHERE tipot = '1' ORDER BY nombre, apellido");
        
        // Obtener tutor actual del estudiante (desde la inscripción más reciente)
        $tutorActual = DB::selectOne("
            SELECT TOP 1 p.ci, p.nombre, p.apellido 
            FROM inscripcion i 
            INNER JOIN persona p ON i.citutor = p.ci 
            WHERE i.ci = ?
            ORDER BY i.fecharegis DESC
        ", [$ci]);

        return view('secretaria.persona.edit', compact('persona', 'tutores', 'tutorActual'));
    }

    /**
     * Actualizar datos de la persona (NO permite cambiar correo ni código)
     */
    public function update(Request $request, $ci)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:15',
            'sexo' => 'required|in:M,F',
            'citutor' => 'nullable|string|max:10|exists:persona,ci',
        ]);

        try {
            // Obtener datos actuales
            $persona = DB::selectOne("SELECT * FROM persona WHERE ci = ?", [$ci]);
            
            if (!$persona) {
                return redirect()->route('secretaria.persona.index')->with('error', 'Persona no encontrada');
            }

            // Validar tutor si es estudiante
            if ($persona->tipoe === '1' && empty($data['citutor'])) {
                return back()->withInput()->withErrors(['citutor' => 'Un estudiante debe tener un tutor asignado']);
            }

            // Iniciar transacción
            DB::beginTransaction();

            // Actualizar datos de la persona (mantiene correo, código y contraseña)
            $affected = DB::update("
                UPDATE persona 
                SET nombre = ?, 
                    apellido = ?, 
                    telefono = ?, 
                    sexo = ?
                WHERE ci = ?
            ", [
                $data['nombre'],
                $data['apellido'],
                $data['telefono'] ?? null,
                $data['sexo'],
                $ci
            ]);

            // Log para debug
            \Log::info("Actualización persona - Filas afectadas: {$affected}", [
                'ci' => $ci,
                'nombre' => $data['nombre'],
                'apellido' => $data['apellido'],
                'telefono' => $data['telefono'],
                'sexo' => $data['sexo']
            ]);

            // Actualizar tutor en todas las inscripciones del estudiante (si aplica)
            if ($persona->tipoe === '1' && !empty($data['citutor'])) {
                // Verificar si el estudiante tiene inscripciones
                $tieneInscripcion = DB::selectOne("SELECT COUNT(*) as total FROM inscripcion WHERE ci = ?", [$ci])->total;
                
                if ($tieneInscripcion > 0) {
                    // Si tiene inscripciones, actualizar el tutor
                    $affectedInscripcion = DB::update("UPDATE inscripcion SET citutor = ? WHERE ci = ?", [$data['citutor'], $ci]);
                    \Log::info("Actualización tutor - Filas afectadas: {$affectedInscripcion}", [
                        'ci' => $ci,
                        'citutor' => $data['citutor']
                    ]);
                } else {
                    // Si NO tiene inscripciones, crear una inscripción básica para vincular con el tutor
                    $gestionActiva = DB::selectOne("SELECT TOP 1 idgestion FROM gestion WHERE estado = '1' ORDER BY fechaapertura DESC");
                    
                    if ($gestionActiva) {
                        DB::statement("
                            INSERT INTO inscripcion (ci, citutor, idgestion, fecharegis, idnivel, idcurso, codbeca)
                            VALUES (?, ?, ?, GETDATE(), 1, 1, NULL)
                        ", [
                            $ci,
                            $data['citutor'],
                            $gestionActiva->idgestion
                        ]);
                        \Log::info("Inscripción creada para vincular estudiante con tutor", [
                            'ci' => $ci,
                            'citutor' => $data['citutor']
                        ]);
                    }
                }
            }

            // Confirmar transacción
            DB::commit();
            
            $tipoRedirect = $persona->tipoe === '1' ? 'estudiantes' : 'tutores';
            return redirect()->route('secretaria.persona.index', ['tipo' => $tipoRedirect])
                ->with('success', '✓ Datos actualizados exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Error al actualizar persona: " . $e->getMessage(), [
                'ci' => $ci,
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withInput()->withErrors(['error' => 'Error al actualizar: ' . $e->getMessage()]);
        }
    }

    /**
     * Restablecer contraseña al CI
     */
    public function restablecer($ci)
    {
        try {
            // Obtener persona
            $persona = DB::selectOne("SELECT * FROM persona WHERE ci = ?", [$ci]);
            
            if (!$persona) {
                return redirect()->route('secretaria.persona.index')->with('error', 'Persona no encontrada');
            }

            // Restablecer contraseña = CI
            DB::update("UPDATE persona SET contrasena = ? WHERE ci = ?", [$ci, $ci]);
            
            // Limpiar caché de consultas
            DB::statement("DBCC FREEPROCCACHE");
            
            $tipoRedirect = $persona->tipoe === '1' ? 'estudiantes' : 'tutores';
            return redirect()->route('secretaria.persona.index', ['tipo' => $tipoRedirect, '_' => time()])
                ->with('success', "✓ Contraseña restablecida exitosamente. Nueva contraseña: {$ci}");
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al restablecer contraseña: ' . $e->getMessage()]);
        }
    }

    /**
     * Mostrar formulario para vincular tutor con estudiante
     */
    public function vincular($ci)
    {
        $estudiante = DB::selectOne("SELECT ci, nombre, apellido, correo FROM persona WHERE ci = ? AND tipoe = '1'", [$ci]);
        
        if (!$estudiante) {
            return redirect()->route('secretaria.persona.index')->with('error', 'Estudiante no encontrado');
        }

        // Obtener tutores disponibles
        $tutores = DB::select("SELECT ci, nombre, apellido, correo, telefono FROM persona WHERE tipot = '1' ORDER BY nombre, apellido");
        
        // Obtener inscripciones actuales del estudiante con sus tutores
        $inscripciones = DB::select("
            SELECT i.*, g.detalleges as gestion, c.descripcion as curso, n.descripcion as nivel,
                   p.nombre as tutor_nombre, p.apellido as tutor_apellido
            FROM inscripcion i
            INNER JOIN gestion g ON i.idgestion = g.idgestion
            INNER JOIN curso c ON i.idcurso = c.idcurso
            INNER JOIN nivel n ON i.idnivel = n.idnivel
            LEFT JOIN persona p ON i.citutor = p.ci
            WHERE i.ci = ?
            ORDER BY i.fecharegis DESC
        ", [$ci]);

        return view('secretaria.persona.vincular', compact('estudiante', 'tutores', 'inscripciones'));
    }

    /**
     * Crear nuevo tutor desde el formulario de vinculación
     */
    public function crearTutor(Request $request)
    {
        $data = $request->validate([
            'ci' => 'required|string|max:10|unique:persona,ci',
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'correo' => 'nullable|email|max:100',
            'telefono' => 'nullable|string|max:15',
            'sexo' => 'required|in:M,F',
            'contrasena' => 'required|string|min:6',
        ]);

        try {
            // Insertar tutor usando procedimiento almacenado
            DB::statement('EXEC sp_InsertarPersona ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?', [
                $data['ci'],
                $data['nombre'],
                $data['apellido'],
                $data['correo'] ?? null,
                $data['telefono'] ?? null,
                $data['sexo'],
                $data['contrasena'], // En producción, usar Hash::make()
                now()->format('Y-m-d'),
                '0', // tipou
                '0', // tipoe
                '1', // tipot (tutor)
                '0', // tipom
                '0', // tipoa
                '0', // tipos
                null, // codestudiante
                null, // codmaestro
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tutor creado exitosamente',
                'tutor' => [
                    'ci' => $data['ci'],
                    'nombre' => $data['nombre'],
                    'apellido' => $data['apellido'],
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear tutor: ' . $e->getMessage()
            ], 500);
        }
    }
}
