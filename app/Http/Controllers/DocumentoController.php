<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    public function index()
    {
        $rows = DB::select(<<<SQL
            SELECT d.iddocumento,
                   d.tipodocumento,
                   d.rutaarchivo,
                   d.validado,
                   d.idpostulacion,
                   d.idrequisito,
                   p.ci,
                   (per.nombre + ' ' + per.apellido) AS estudiante,
                   c.nombre AS carrera,
                   cv.titulo AS convocatoria,
                   r.descripcion AS requisito
            FROM DOCUMENTO d
            INNER JOIN POSTULACION p ON p.idpostulacion = d.idpostulacion
            INNER JOIN PERSONA per ON per.ci = p.ci
            INNER JOIN CARRERA c ON c.idcarrera = p.idcarrera
            INNER JOIN CONVOCATORIA cv ON cv.idconvocatoria = p.idconvocatoria
            INNER JOIN REQUISITO r ON r.idrequisito = d.idrequisito
            ORDER BY d.iddocumento DESC
        SQL);
        return view('admin.documento.index', compact('rows'));
    }

    public function create()
    {
        $postulaciones = DB::select(<<<SQL
            SELECT p.idpostulacion,
                   (per.nombre + ' ' + per.apellido) + ' - ' + cv.titulo AS etiqueta
            FROM POSTULACION p
            INNER JOIN PERSONA per ON per.ci = p.ci
            INNER JOIN CONVOCATORIA cv ON cv.idconvocatoria = p.idconvocatoria
            ORDER BY p.idpostulacion DESC
        SQL);
        $requisitos = DB::select('SELECT idrequisito, descripcion FROM REQUISITO ORDER BY idrequisito DESC');
        return view('admin.documento.create', compact('postulaciones','requisitos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tipodocumento' => 'required|string|max:50',
            'archivo' => 'required|file|mimes:pdf|max:20480',
            'validado' => 'required|string|size:1',
            'idpostulacion' => 'required|integer',
            'idrequisito' => 'required|integer',
        ]);

        // Verificar que no exista ya un documento para este requisito en esta postulación
        $existente = DB::selectOne(
            'SELECT iddocumento FROM DOCUMENTO WHERE idpostulacion = ? AND idrequisito = ?',
            [$data['idpostulacion'], $data['idrequisito']]
        );
        if ($existente) {
            return back()->withErrors(['general' => 'Ya existe un documento para este requisito en esta postulación.'])->withInput();
        }

        // Subir archivo al DISCO 'public' y obtener URL pública /storage/...
        $storedPath = $request->file('archivo')->store('documentos', 'public'); // documentos/archivo.pdf
        $publicUrl = Storage::disk('public')->url($storedPath); // /storage/documentos/archivo.pdf

        // Firma real del SP en BD: sin iddocumento (identity). Enviar 5 parámetros.
        DB::statement('EXEC sp_InsertarDocumento ?, ?, ?, ?, ?', [
            $data['tipodocumento'],
            $publicUrl,
            $data['validado'],
            $data['idpostulacion'],
            $data['idrequisito'],
        ]);
        return redirect()->route('admin.documento.index')->with('status', 'Documento creado');
    }

    public function edit(int $id)
    {
        $row = DB::selectOne('SELECT iddocumento, tipodocumento, rutaarchivo, validado, idpostulacion, idrequisito FROM DOCUMENTO WHERE iddocumento = ?', [$id]);
        if (!$row) { abort(404); }
        $postulaciones = DB::select(<<<SQL
            SELECT p.idpostulacion,
                   (per.nombre + ' ' + per.apellido) + ' - ' + cv.titulo AS etiqueta
            FROM POSTULACION p
            INNER JOIN PERSONA per ON per.ci = p.ci
            INNER JOIN CONVOCATORIA cv ON cv.idconvocatoria = p.idconvocatoria
            ORDER BY p.idpostulacion DESC
        SQL);
        $requisitos = DB::select('SELECT idrequisito, descripcion FROM REQUISITO ORDER BY idrequisito DESC');
        return view('admin.documento.edit', compact('row','postulaciones','requisitos'));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'tipodocumento' => 'required|string|max:50',
            'archivo' => 'nullable|file|mimes:pdf|max:20480',
            'validado' => 'required|string|size:1',
            'idpostulacion' => 'required|integer',
            'idrequisito' => 'required|integer',
        ]);

        // Obtener actuales para conservar si no hay archivo nuevo
        $current = DB::selectOne('SELECT rutaarchivo FROM DOCUMENTO WHERE iddocumento = ?', [$id]);
        $rutaarchivo = $current ? $current->rutaarchivo : '';
        if ($request->hasFile('archivo')) {
            $storedPath = $request->file('archivo')->store('documentos', 'public');
            $rutaarchivo = Storage::disk('public')->url($storedPath);
        }

        DB::statement('EXEC sp_ActualizarDocumento ?, ?, ?, ?, ?, ?', [
            $id,
            $data['tipodocumento'],
            $rutaarchivo,
            $data['validado'],
            $data['idpostulacion'],
            $data['idrequisito'],
        ]);

        // Regla 5: Revalidar requisitos obligatorios
        DB::statement('EXEC sp_VerificarRequisitosObligatorios ?', [ $data['idpostulacion'] ]);

        return redirect()->route('admin.documento.index')->with('status', 'Documento actualizado');
    }

    public function disable(int $id)
    {
        // Manejo por estado: marcar no validado (0)
        $doc = DB::selectOne('SELECT idpostulacion FROM DOCUMENTO WHERE iddocumento = ?', [$id]);
        DB::update('UPDATE DOCUMENTO SET validado = ? WHERE iddocumento = ?', ['0', $id]);
        if ($doc) {
            DB::statement('EXEC sp_VerificarRequisitosObligatorios ?', [ $doc->idpostulacion ]);
        }
        return redirect()->route('admin.documento.index')->with('status', 'Documento deshabilitado');
    }
}
