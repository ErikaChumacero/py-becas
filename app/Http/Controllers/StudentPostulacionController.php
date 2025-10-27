<?php

namespace App\Http\Controllers;

use App\Helpers\ErrorHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentPostulacionController extends Controller
{
    private function currentStudentCi(): ?string
    {
        $u = session('usuario');
        return $u['ci'] ?? null;
    }

    public function index()
    {
        try {
            $ci = $this->currentStudentCi();
            if (!$ci) { abort(403); }
            $rows = DB::select(<<<SQL
                SELECT 
                    p.idpostulacion,
                    p.fechapostulacion,
                    -- Obtener el último estado del historial, si no existe usar el de POSTULACION
                    ISNULL(
                        (SELECT TOP 1 estadonuevo 
                         FROM HISTORIALESTADO 
                         WHERE idpostulacion = p.idpostulacion 
                         ORDER BY fechacambio DESC, idhistorialestado DESC),
                        p.estado
                    ) AS estado,
                    p.idconvocatoria,
                    p.idcarrera,
                    p.ci,
                    p.idsemestre,
                    c.nombre AS carrera,
                    cv.titulo AS convocatoria,
                    (s.periodo + '/' + CAST(s.año AS VARCHAR)) AS semestre
                FROM POSTULACION p
                INNER JOIN CARRERA c ON c.idcarrera = p.idcarrera
                INNER JOIN CONVOCATORIA cv ON cv.idconvocatoria = p.idconvocatoria
                INNER JOIN SEMESTRE s ON s.idsemestre = p.idsemestre
                WHERE p.ci = ?
                ORDER BY p.fechapostulacion DESC, p.idpostulacion DESC
            SQL, [$ci]);
            return view('estudiante.postulacion.index', compact('rows'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al cargar las postulaciones. Por favor, contacte al administrador.']);
        }
    }

    public function create()
    {
        $ci = $this->currentStudentCi();
        if (!$ci) { abort(403); }
        $convocatorias = DB::select("SELECT idconvocatoria, titulo FROM CONVOCATORIA WHERE estado = '1' ORDER BY idconvocatoria DESC");
        $carreras = DB::select('SELECT idcarrera, nombre FROM CARRERA ORDER BY nombre');
        $semestres = DB::select('SELECT idsemestre, descripcion FROM SEMESTRE ORDER BY idsemestre DESC');
        return view('estudiante.postulacion.create', compact('convocatorias','carreras','semestres'));
    }

    public function store(Request $request)
    {
        $ci = $this->currentStudentCi();
        if (!$ci) { abort(403); }

        $data = $request->validate([
            'idconvocatoria' => 'required|integer',
            'idcarrera' => 'required|integer',
            'idsemestre' => 'required|integer',
        ]);

        // Negocio Regla 6: validaciones específicas
        try {
            DB::statement('EXEC sp_ValidarPostulacion ?, ?', [ $ci, $data['idconvocatoria'] ]);
            DB::statement('EXEC sp_ValidarUnicidadPostulacion ?, ?', [ $ci, $data['idconvocatoria'] ]);
        } catch (\Throwable $e) {
            return back()->withErrors(['general' => ErrorHelper::cleanSqlError($e->getMessage())])->withInput();
        }

        // Nueva firma del SP: fecha/estado definidos internamente, ID identity
        DB::statement('EXEC sp_InsertarPostulacion ?, ?, ?, ?', [
            $data['idconvocatoria'],
            $data['idcarrera'],
            $ci,
            $data['idsemestre'],
        ]);

        return redirect()->route('estudiante.postulacion.index')->with('status', 'Postulación registrada');
    }

    public function edit(int $id)
    {
        $ci = $this->currentStudentCi();
        if (!$ci) { abort(403); }
        $row = DB::selectOne('SELECT idpostulacion, fechapostulacion, estado, idconvocatoria, idcarrera, ci, idsemestre FROM POSTULACION WHERE idpostulacion = ? AND ci = ?', [$id, $ci]);
        if (!$row) { abort(404); }
        $convocatorias = DB::select('SELECT idconvocatoria, titulo FROM CONVOCATORIA WHERE estado = ? ORDER BY idconvocatoria DESC', ['1']);
        $carreras = DB::select('SELECT idcarrera, nombre FROM CARRERA ORDER BY nombre');
        $semestres = DB::select('SELECT idsemestre, descripcion FROM SEMESTRE ORDER BY idsemestre DESC');
        return view('estudiante.postulacion.edit', compact('row','convocatorias','carreras','semestres'));
    }

    public function update(Request $request, int $id)
    {
        $ci = $this->currentStudentCi();
        if (!$ci) { abort(403); }
        $data = $request->validate([
            'idconvocatoria' => 'required|integer',
            'idcarrera' => 'required|integer',
            'idsemestre' => 'required|integer',
        ]);

        $row = DB::selectOne('SELECT ci, estado FROM POSTULACION WHERE idpostulacion = ?', [$id]);
        if (!$row || $row->ci !== $ci) { abort(403); }

        DB::statement('EXEC sp_ActualizarPostulacion ?, ?, ?, ?, ?, ?', [
            $id,
            $row->estado, // mantener estado
            $data['idconvocatoria'],
            $data['idcarrera'],
            $ci,
            $data['idsemestre'],
        ]);

        return redirect()->route('estudiante.postulacion.index')->with('status', 'Postulación actualizada');
    }

    public function cancel(int $id)
    {
        $ci = $this->currentStudentCi();
        if (!$ci) { abort(403); }
        $row = DB::selectOne('SELECT ci FROM POSTULACION WHERE idpostulacion = ?', [$id]);
        if (!$row || $row->ci !== $ci) { abort(403); }
        DB::statement('EXEC sp_ActualizarEstadoPostulacion ?, ?', [ $id, '0' ]);
        return redirect()->route('estudiante.postulacion.index')->with('status', 'Postulación cancelada');
    }
}
