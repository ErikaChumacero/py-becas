<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SecretariaInscripcionController extends Controller
{
    /**
     * Mostrar listado de inscripciones
     */
    public function index(Request $request)
    {
        $gestion = $request->get('gestion', null);
        
        // Obtener inscripciones con información completa
        $query = "
            SELECT 
                i.*,
                p.nombre as estudiante_nombre,
                p.apellido as estudiante_apellido,
                t.nombre as tutor_nombre,
                t.apellido as tutor_apellido,
                g.detalleges as gestion,
                n.descripcion as nivel,
                c.descripcion as curso,
                b.porcentaje as beca_porcentaje,
                b.codbeca
            FROM inscripcion i
            INNER JOIN persona p ON i.ci = p.ci
            INNER JOIN persona t ON i.citutor = t.ci
            INNER JOIN gestion g ON i.idgestion = g.idgestion
            INNER JOIN nivel n ON i.idnivel = n.idnivel
            INNER JOIN curso c ON i.idcurso = c.idcurso AND i.idnivel = c.idnivel
            LEFT JOIN beca b ON b.codbeca = i.codbeca
        ";
        
        if ($gestion) {
            $query .= " WHERE g.detalleges = ?";
            $inscripciones = DB::select($query . " ORDER BY i.fecharegis DESC", [$gestion]);
        } else {
            $inscripciones = DB::select($query . " ORDER BY i.fecharegis DESC");
        }
        
        // Obtener gestiones disponibles para filtro
        $gestiones = DB::select("SELECT DISTINCT detalleges as gestion FROM gestion ORDER BY detalleges DESC");
        
        return view('secretaria.inscripcion.index', compact('inscripciones', 'gestiones', 'gestion'));
    }

    /**
     * Mostrar formulario para crear nueva inscripción
     */
    public function create()
    {
        // Obtener estudiantes
        $estudiantes = DB::select("SELECT ci, nombre, apellido, codestudiante FROM persona WHERE tipoe = '1' ORDER BY nombre, apellido");
        
        // Obtener tutores
        $tutores = DB::select("SELECT ci, nombre, apellido FROM persona WHERE tipot = '1' ORDER BY nombre, apellido");
        
        // Obtener SOLO gestiones activas
        $gestiones = DB::select("SELECT * FROM gestion WHERE estado = '1' ORDER BY detalleges DESC");
        
        // Obtener niveles
        $niveles = DB::select("SELECT * FROM nivel ORDER BY descripcion");
        
        // Obtener todos los cursos (se filtrarán por JavaScript según nivel)
        $cursos = DB::select("SELECT * FROM curso ORDER BY idnivel, descripcion");
        
        // Obtener becas registradas
        $becas = DB::select("SELECT * FROM beca ORDER BY porcentaje DESC");
        
        return view('secretaria.inscripcion.create', compact('estudiantes', 'tutores', 'gestiones', 'niveles', 'cursos', 'becas'));
    }

    /**
     * Guardar nueva inscripción
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'ci' => 'required|string|max:10|exists:persona,ci',
            'citutor' => 'required|string|max:10|exists:persona,ci',
            'idgestion' => 'required|integer|exists:gestion,idgestion',
            'idnivel' => 'required|integer|exists:nivel,idnivel',
            'idcurso' => 'required|integer|exists:curso,idcurso',
            'observaciones' => 'nullable|string|max:200',
            'codbeca' => 'nullable|integer|exists:beca,codbeca',
        ]);

        // Validar que el tutor no sea el mismo estudiante
        if ($data['ci'] === $data['citutor']) {
            return back()->withInput()->with('error', 'El tutor no puede ser el mismo estudiante');
        }

        // Validar inscripción única por gestión (verificación directa)
        $existe = DB::selectOne("
            SELECT COUNT(*) as total 
            FROM inscripcion 
            WHERE ci = ? AND idgestion = ?
        ", [$data['ci'], $data['idgestion']]);
        
        if ($existe && $existe->total > 0) {
            return back()->withInput()->with('error', 'El estudiante ya tiene una inscripción en esta gestión');
        }

        try {
            // Log de datos antes de insertar
            \Log::info('=== INICIANDO REGISTRO DE INSCRIPCIÓN ===');
            \Log::info('Datos recibidos:', [
                'ci' => $data['ci'],
                'idcurso' => $data['idcurso'],
                'idnivel' => $data['idnivel'],
                'citutor' => $data['citutor'],
                'idgestion' => $data['idgestion'],
                'codbeca' => $data['codbeca'] ?? 'Sin beca'
            ]);
            
            // Verificar datos del curso y nivel
            $cursoInfo = DB::selectOne("SELECT c.descripcion as curso, n.descripcion as nivel 
                                        FROM curso c 
                                        INNER JOIN nivel n ON c.idnivel = n.idnivel 
                                        WHERE c.idcurso = ? AND c.idnivel = ?", 
                                        [$data['idcurso'], $data['idnivel']]);
            
            if (!$cursoInfo) {
                \Log::error('ERROR: Curso no pertenece al nivel seleccionado', [
                    'idcurso' => $data['idcurso'],
                    'idnivel' => $data['idnivel']
                ]);
                return back()->withInput()->with('error', 'El curso seleccionado no pertenece al nivel indicado');
            }
            
            \Log::info('Curso verificado:', [
                'curso' => $cursoInfo->curso,
                'nivel' => $cursoInfo->nivel
            ]);
            
            // Insertar inscripción con beca si fue seleccionada
            DB::statement('EXEC sp_InsertarInscripcion ?, ?, ?, ?, ?, ?, ?, ?', [
                $data['ci'],
                $data['idcurso'],
                $data['idnivel'],
                $data['observaciones'] ?? null,
                now()->format('Y-m-d'),
                $data['citutor'],
                $data['idgestion'],
                $data['codbeca'] ?? null,
            ]);

            \Log::info('✓ INSCRIPCIÓN REGISTRADA EXITOSAMENTE', [
                'ci' => $data['ci'],
                'curso' => $cursoInfo->curso,
                'nivel' => $cursoInfo->nivel
            ]);

            // Mensaje de éxito
            $mensaje = '✓ Inscripción registrada exitosamente para ' . $cursoInfo->nivel . ' - ' . $cursoInfo->curso;
            if (!empty($data['codbeca'])) {
                $beca = DB::selectOne("SELECT porcentaje FROM beca WHERE codbeca = ?", [$data['codbeca']]);
                if ($beca) {
                    $mensaje .= ' con beca del ' . $beca->porcentaje . '%';
                }
            }

            return redirect()->route('secretaria.inscripcion.index')->with('success', $mensaje);
        } catch (\Exception $e) {
            \Log::error('❌ ERROR AL INSERTAR INSCRIPCIÓN', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $data
            ]);
            return back()->withInput()->with('error', 'Error al registrar inscripción: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar formulario para editar inscripción
     */
    public function edit($ci, $idcurso, $idnivel)
    {
        // Obtener inscripción
        $inscripcion = DB::selectOne("
            SELECT 
                i.*,
                p.nombre as estudiante_nombre,
                p.apellido as estudiante_apellido,
                g.detalleges as gestion,
                n.descripcion as nivel,
                c.descripcion as curso
            FROM inscripcion i
            INNER JOIN persona p ON i.ci = p.ci
            INNER JOIN gestion g ON i.idgestion = g.idgestion
            INNER JOIN nivel n ON i.idnivel = n.idnivel
            INNER JOIN curso c ON i.idcurso = c.idcurso AND i.idnivel = c.idnivel
            WHERE i.ci = ? AND i.idcurso = ? AND i.idnivel = ?
        ", [$ci, $idcurso, $idnivel]);

        if (!$inscripcion) {
            return redirect()->route('secretaria.inscripcion.index')->with('error', 'Inscripción no encontrada');
        }

        // Obtener tutores
        $tutores = DB::select("SELECT ci, nombre, apellido FROM persona WHERE tipot = '1' ORDER BY nombre, apellido");
        
        // Obtener beca actual si existe
        $beca = null;
        if ($inscripcion->codbeca) {
            $beca = DB::selectOne("SELECT * FROM beca WHERE codbeca = ?", [$inscripcion->codbeca]);
        }

        return view('secretaria.inscripcion.edit', compact('inscripcion', 'tutores', 'beca'));
    }

    /**
     * Actualizar inscripción
     */
    public function update(Request $request, $ci, $idcurso, $idnivel)
    {
        $data = $request->validate([
            'citutor' => 'required|string|max:10|exists:persona,ci',
            'observaciones' => 'nullable|string|max:200',
            'porcentaje_beca' => 'nullable|integer|min:0|max:100',
        ]);

        try {
            // Obtener datos actuales de la inscripción
            $inscripcion = DB::selectOne("SELECT * FROM inscripcion WHERE ci = ? AND idcurso = ? AND idnivel = ?", [$ci, $idcurso, $idnivel]);
            
            if (!$inscripcion) {
                return redirect()->route('secretaria.inscripcion.index')->with('error', 'Inscripción no encontrada');
            }

            // Actualizar inscripción
            DB::statement('EXEC sp_ActualizarInscripcion ?, ?, ?, ?, ?, ?, ?, ?', [
                $inscripcion->ci,
                $inscripcion->idcurso,
                $inscripcion->idnivel,
                $data['observaciones'] ?? null,
                $inscripcion->fecharegis,
                $data['citutor'],
                $inscripcion->idgestion,
                $inscripcion->codbeca,
            ]);

            // Gestionar beca
            $becaActual = null;
            if ($inscripcion->codbeca) {
                $becaActual = DB::selectOne("SELECT * FROM beca WHERE codbeca = ?", [$inscripcion->codbeca]);
            }
            
            if (isset($data['porcentaje_beca']) && $data['porcentaje_beca'] > 0) {
                if ($becaActual) {
                    // Actualizar beca existente (codbeca, nombrebeca, tipobeca, porcentaje)
                    DB::statement('EXEC sp_ActualizarBeca ?, ?, ?, ?', [
                        $becaActual->codbeca,
                        'Beca ' . $data['porcentaje_beca'] . '%',
                        '1',
                        $data['porcentaje_beca'],
                    ]);
                } else {
                    // Crear nueva beca (nombrebeca, tipobeca, porcentaje)
                    DB::statement('EXEC sp_InsertarBeca ?, ?, ?', [
                        'Beca ' . $data['porcentaje_beca'] . '%',
                        '1',
                        $data['porcentaje_beca'],
                    ]);
                    
                    // Obtener el código de beca recién creado y actualizar inscripción
                    $beca = DB::selectOne("SELECT TOP 1 codbeca FROM beca ORDER BY codbeca DESC");
                    if ($beca) {
                        DB::statement("
                            UPDATE inscripcion 
                            SET codbeca = ? 
                            WHERE ci = ? AND idcurso = ? AND idnivel = ?
                        ", [$beca->codbeca, $ci, $idcurso, $idnivel]);
                    }
                }
            } elseif ($becaActual && (!isset($data['porcentaje_beca']) || $data['porcentaje_beca'] == 0)) {
                // Quitar beca: eliminar registro y actualizar inscripción
                DB::statement("DELETE FROM beca WHERE codbeca = ?", [$becaActual->codbeca]);
                DB::statement("
                    UPDATE inscripcion 
                    SET codbeca = NULL 
                    WHERE ci = ? AND idcurso = ? AND idnivel = ?
                ", [$ci, $idcurso, $idnivel]);
            }

            return redirect()->route('secretaria.inscripcion.index')
                ->with('success', 'Inscripción actualizada exitosamente');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error al actualizar inscripción: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar inscripción
     */
    public function destroy($ci, $idcurso, $idnivel)
    {
        try {
            // Verificar si la inscripción existe
            $inscripcion = DB::selectOne("
                SELECT * FROM inscripcion 
                WHERE ci = ? AND idcurso = ? AND idnivel = ?
            ", [$ci, $idcurso, $idnivel]);

            if (!$inscripcion) {
                return redirect()->route('secretaria.inscripcion.index')
                    ->with('error', 'Inscripción no encontrada');
            }

            // Log antes de eliminar
            \Log::info('Eliminando inscripción', [
                'ci' => $ci,
                'idcurso' => $idcurso,
                'idnivel' => $idnivel
            ]);

            // Eliminar la inscripción
            DB::statement("
                DELETE FROM inscripcion 
                WHERE ci = ? AND idcurso = ? AND idnivel = ?
            ", [$ci, $idcurso, $idnivel]);

            \Log::info('Inscripción eliminada exitosamente', ['ci' => $ci]);

            return redirect()->route('secretaria.inscripcion.index')
                ->with('success', '✓ Inscripción eliminada exitosamente');
        } catch (\Exception $e) {
            \Log::error('Error al eliminar inscripción', [
                'error' => $e->getMessage(),
                'ci' => $ci,
                'idcurso' => $idcurso,
                'idnivel' => $idnivel
            ]);
            return redirect()->route('secretaria.inscripcion.index')
                ->with('error', 'Error al eliminar inscripción: ' . $e->getMessage());
        }
    }

    /**
     * Obtener tutor del estudiante (AJAX)
     */
    public function getTutor($ci)
    {
        $tutor = DB::selectOne("
            SELECT TOP 1 p.ci, p.nombre, p.apellido 
            FROM inscripcion i 
            INNER JOIN persona p ON i.citutor = p.ci 
            WHERE i.ci = ?
            ORDER BY i.fecharegis DESC
        ", [$ci]);

        return response()->json([
            'success' => true,
            'tutor' => $tutor
        ]);
    }
}
