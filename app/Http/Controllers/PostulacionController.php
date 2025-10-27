<?php

namespace App\Http\Controllers;

use App\Helpers\ErrorHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostulacionController extends Controller
{
    public function index()
    {
        try {
            $rows = DB::select(<<<SQL
                SELECT 
                    p.idpostulacion,
                    p.fechapostulacion,
                    p.estado,
                    p.idconvocatoria,
                    p.idcarrera,
                    p.ci,
                    p.idsemestre,
                    (per.nombre + ' ' + per.apellido) AS estudiante,
                    c.nombre AS carrera,
                    cv.titulo AS convocatoria,
                    (s.periodo + '/' + CAST(s.año AS VARCHAR)) AS semestre
                FROM POSTULACION p
                INNER JOIN PERSONA per ON per.ci = p.ci
                INNER JOIN CARRERA c ON c.idcarrera = p.idcarrera
                INNER JOIN CONVOCATORIA cv ON cv.idconvocatoria = p.idconvocatoria
                INNER JOIN SEMESTRE s ON s.idsemestre = p.idsemestre
                ORDER BY p.fechapostulacion DESC, p.idpostulacion DESC
            SQL);
            return view('admin.postulacion.index', compact('rows'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al cargar las postulaciones. Por favor, contacte al administrador.']);
        }
    }

    public function create()
    {
        $personas = DB::select("SELECT ci, (nombre + ' ' + apellido) AS nombre FROM PERSONA ORDER BY nombre, apellido");
        $convocatorias = DB::select('SELECT idconvocatoria, titulo FROM CONVOCATORIA WHERE estado = ? ORDER BY idconvocatoria DESC', ['1']);
        $carreras = DB::select('SELECT idcarrera, nombre FROM CARRERA ORDER BY nombre');
        $semestres = DB::select('SELECT idsemestre, descripcion FROM SEMESTRE ORDER BY idsemestre DESC');
        return view('admin.postulacion.create', compact('personas','convocatorias','carreras','semestres'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ci' => 'required|string|max:10',
            'idconvocatoria' => 'required|integer',
            'idcarrera' => 'required|integer',
            'idsemestre' => 'required|integer',
        ]);

        // Validaciones de negocio (Reglas 5 y 6)
        // 1) Validar elegibilidad de postulación
        try {
            DB::statement('EXEC sp_ValidarPostulacion ?, ?', [
                $data['ci'], $data['idconvocatoria']
            ]);
            // 2) Unicidad por estudiante/convocatoria
            DB::statement('EXEC sp_ValidarUnicidadPostulacion ?, ?', [
                $data['ci'], $data['idconvocatoria']
            ]);
        } catch (\Throwable $e) {
            return back()->withErrors([
                'general' => ErrorHelper::cleanSqlError($e->getMessage()),
            ])->withInput();
        }

        // Nueva firma del SP: ID identity, fecha y estado definidos internamente
        DB::statement('EXEC sp_InsertarPostulacion ?, ?, ?, ?', [
            $data['idconvocatoria'],
            $data['idcarrera'],
            $data['ci'],
            $data['idsemestre'],
        ]);

        return redirect()->route('admin.postulacion.index')->with('status', 'Postulación creada');
    }

    public function edit(int $id)
    {
        $row = DB::selectOne('SELECT idpostulacion, fechapostulacion, estado, idconvocatoria, idcarrera, ci, idsemestre FROM POSTULACION WHERE idpostulacion = ?', [$id]);
        if (!$row) { abort(404); }
        $personas = DB::select("SELECT ci, (nombre + ' ' + apellido) AS nombre FROM PERSONA ORDER BY nombre, apellido");
        $convocatorias = DB::select('SELECT idconvocatoria, titulo FROM CONVOCATORIA ORDER BY idconvocatoria DESC');
        $carreras = DB::select('SELECT idcarrera, nombre FROM CARRERA ORDER BY nombre');
        $semestres = DB::select('SELECT idsemestre, descripcion FROM SEMESTRE ORDER BY idsemestre DESC');
        return view('admin.postulacion.edit', compact('row','personas','convocatorias','carreras','semestres'));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'idpostulacion' => 'required|integer',
            'ci' => 'required|string|max:10',
            'idconvocatoria' => 'required|integer',
            'idcarrera' => 'required|integer',
            'idsemestre' => 'required|integer',
            'estado' => 'required|string|size:1|in:1,2,3,4',
        ]);

        DB::statement('EXEC sp_ActualizarPostulacion ?, ?, ?, ?, ?, ?', [
            $data['idpostulacion'],
            $data['estado'],
            $data['idconvocatoria'],
            $data['idcarrera'],
            $data['ci'],
            $data['idsemestre'],
        ]);

        return redirect()->route('admin.postulacion.index')->with('status', 'Postulación actualizada');
    }

    public function disable(int $id)
    {
        // Manejo por estados: usar un estado válido por CHECK. Marcamos como '4' (Rechazada)
        DB::statement('EXEC sp_ActualizarEstadoPostulacion ?, ?', [
            $id, '4'
        ]);
        return redirect()->route('admin.postulacion.index')->with('status', 'Postulación rechazada');
    }
}
