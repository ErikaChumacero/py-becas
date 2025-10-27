<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StudentDocumentoController extends Controller
{
    private function currentStudentCi(): ?string
    {
        $u = session('usuario');
        return $u['ci'] ?? null;
    }

    public function index()
    {
        $ci = $this->currentStudentCi();
        if (!$ci) { abort(403); }
        $rows = DB::select(<<<SQL
            SELECT d.iddocumento,
                   d.tipodocumento,
                   d.rutaarchivo,
                   d.validado,
                   d.idpostulacion,
                   d.idrequisito,
                   r.descripcion AS requisito,
                   cv.titulo AS convocatoria
            FROM DOCUMENTO d
            INNER JOIN POSTULACION p ON p.idpostulacion = d.idpostulacion
            INNER JOIN CONVOCATORIA cv ON cv.idconvocatoria = p.idconvocatoria
            INNER JOIN REQUISITO r ON r.idrequisito = d.idrequisito
            WHERE p.ci = ?
            ORDER BY d.iddocumento DESC
        SQL, [$ci]);
        return view('estudiante.documento.index', compact('rows'));
    }

    public function create()
    {
        $ci = $this->currentStudentCi();
        if (!$ci) { abort(403); }
        $postulaciones = DB::select(<<<SQL
            SELECT p.idpostulacion,
                   (cv.titulo + ' - ' + CONVERT(varchar(10), p.fechapostulacion, 23)) AS etiqueta
            FROM POSTULACION p
            INNER JOIN CONVOCATORIA cv ON cv.idconvocatoria = p.idconvocatoria
            WHERE p.ci = ?
            ORDER BY p.idpostulacion DESC
        SQL, [$ci]);
        // Requisitos disponibles (se puede filtrar por tipobeca del la postulación elegida en la UI; aquí listamos todos y se valida en BD)
        $requisitos = DB::select('SELECT idrequisito, descripcion FROM REQUISITO ORDER BY idrequisito DESC');
        return view('estudiante.documento.create', compact('postulaciones','requisitos'));
    }

    public function store(Request $request)
    {
        $ci = $this->currentStudentCi();
        if (!$ci) { abort(403); }
        $data = $request->validate([
            'tipodocumento' => 'required|string|max:50',
            'archivo' => 'required|file|mimes:pdf|max:20480',
            'idpostulacion' => 'required|integer',
            'idrequisito' => 'required|integer',
        ]);
        // Verificar que la postulación pertenezca al estudiante
        $owner = DB::selectOne('SELECT ci FROM POSTULACION WHERE idpostulacion = ?', [$data['idpostulacion']]);
        if (!$owner || $owner->ci !== $ci) { abort(403); }

        // Verificar que no exista ya un documento para este requisito en esta postulación
        $existente = DB::selectOne(
            'SELECT iddocumento FROM DOCUMENTO WHERE idpostulacion = ? AND idrequisito = ?',
            [$data['idpostulacion'], $data['idrequisito']]
        );
        if ($existente) {
            return back()->withErrors(['general' => 'Ya has subido un documento para este requisito. Si necesitas cambiarlo, edita el documento existente.'])->withInput();
        }

        // Subir archivo al DISCO 'public' y obtener URL pública
        $storedPath = $request->file('archivo')->store('documentos', 'public');
        $publicUrl = Storage::disk('public')->url($storedPath); // /storage/documentos/...
        $validado = '0'; // El estudiante no valida, queda pendiente

        // Firma del SP: 5 parámetros (tipodocumento, rutaarchivo, validado, idpostulacion, idrequisito)
        DB::statement('EXEC sp_InsertarDocumento ?, ?, ?, ?, ?', [
            $data['tipodocumento'],
            $publicUrl,
            $validado,
            $data['idpostulacion'],
            $data['idrequisito'],
        ]);

        // Reglas: que los triggers/SPs hagan su trabajo; no marcamos validado desde estudiante
        DB::statement('EXEC sp_VerificarRequisitosObligatorios ?', [ $data['idpostulacion'] ]);

        return redirect()->route('estudiante.documento.index')->with('status', 'Documento cargado');
    }

    public function edit(int $id)
    {
        $ci = $this->currentStudentCi();
        if (!$ci) { abort(403); }
        $row = DB::selectOne(<<<SQL
            SELECT d.iddocumento, d.tipodocumento, d.rutaarchivo, d.validado, d.idpostulacion, d.idrequisito
            FROM DOCUMENTO d
            INNER JOIN POSTULACION p ON p.idpostulacion = d.idpostulacion
            WHERE d.iddocumento = ? AND p.ci = ?
        SQL, [$id, $ci]);
        if (!$row) { abort(404); }
        $postulaciones = DB::select('SELECT idpostulacion, (CONVERT(varchar(10), fechapostulacion, 23)) AS etiqueta FROM POSTULACION WHERE ci = ? ORDER BY idpostulacion DESC', [$ci]);
        $requisitos = DB::select('SELECT idrequisito, descripcion FROM REQUISITO ORDER BY idrequisito DESC');
        return view('estudiante.documento.edit', compact('row','postulaciones','requisitos'));
    }

    public function update(Request $request, int $id)
    {
        $ci = $this->currentStudentCi();
        if (!$ci) { abort(403); }
        $data = $request->validate([
            'tipodocumento' => 'required|string|max:50',
            'archivo' => 'nullable|file|mimes:pdf|max:20480',
            'idpostulacion' => 'required|integer',
            'idrequisito' => 'required|integer',
        ]);
        $row = DB::selectOne('SELECT p.ci FROM DOCUMENTO d INNER JOIN POSTULACION p ON p.idpostulacion = d.idpostulacion WHERE d.iddocumento = ?', [$id]);
        if (!$row || $row->ci !== $ci) { abort(403); }
        $currentDoc = DB::selectOne('SELECT rutaarchivo, validado FROM DOCUMENTO WHERE iddocumento = ?', [$id]);
        $current = $currentDoc;
        $rutaarchivo = $currentDoc ? $currentDoc->rutaarchivo : '';
        if ($request->hasFile('archivo')) {
            $storedPath = $request->file('archivo')->store('documentos', 'public');
            $rutaarchivo = Storage::disk('public')->url($storedPath);
        }
        $validado = $current ? $current->validado : '0';

        DB::statement('EXEC sp_ActualizarDocumento ?, ?, ?, ?, ?, ?', [
            $id,
            $data['tipodocumento'],
            $rutaarchivo,
            $validado,
            $data['idpostulacion'],
            $data['idrequisito'],
        ]);

        DB::statement('EXEC sp_VerificarRequisitosObligatorios ?', [ $data['idpostulacion'] ]);

        return redirect()->route('estudiante.documento.index')->with('status', 'Documento actualizado');
    }

    public function disable(int $id)
    {
        $ci = $this->currentStudentCi();
        if (!$ci) { abort(403); }
        $doc = DB::selectOne('SELECT d.idpostulacion, p.ci FROM DOCUMENTO d INNER JOIN POSTULACION p ON p.idpostulacion = d.idpostulacion WHERE d.iddocumento = ?', [$id]);
        if (!$doc || $doc->ci !== $ci) { abort(403); }
        // Deshabilitar para estudiante: marcar como no validado
        DB::update('UPDATE DOCUMENTO SET validado = ? WHERE iddocumento = ?', ['0', $id]);
        DB::statement('EXEC sp_VerificarRequisitosObligatorios ?', [ $doc->idpostulacion ]);
        return redirect()->route('estudiante.documento.index')->with('status', 'Documento deshabilitado');
    }

    public function requisitosByPostulacion(int $idpostulacion)
    {
        $ci = $this->currentStudentCi();
        if (!$ci) { abort(403); }
        $post = DB::selectOne(<<<SQL
            SELECT p.idpostulacion, p.ci, cv.idtipobeca
            FROM POSTULACION p
            INNER JOIN CONVOCATORIA cv ON cv.idconvocatoria = p.idconvocatoria
            WHERE p.idpostulacion = ?
        SQL, [$idpostulacion]);
        if (!$post || $post->ci !== $ci) { abort(403); }
        $requisitos = DB::select('SELECT idrequisito, descripcion, obligatorio FROM REQUISITO WHERE idtipobeca = ? ORDER BY idrequisito', [$post->idtipobeca]);
        return response()->json($requisitos);
    }
}
