<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonaController extends Controller
{
    public function create()
    {
        return view('admin.persona.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ci' => 'required|string|max:10',
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'telefono' => 'required|string|max:8',
            'sexo' => 'required|in:M,F',
            'correo' => 'required|email|max:255',
            'tipou' => 'nullable|boolean',
            'tipoa' => 'nullable|boolean',
            'tipoe' => 'nullable|boolean',
            'contrasena' => 'required|string|max:255',
            'codigo' => 'nullable|string|max:20',
            'nroregistro' => 'nullable|string|max:20',
        ]);

        // Normalizar flags a '1'/'0'
        $tipou = $request->boolean('tipou') ? '1' : '0';
        $tipoa = $request->boolean('tipoa') ? '1' : '0';
        $tipoe = $request->boolean('tipoe') ? '1' : '0';

        // Evitar duplicado por PK
        $exists = DB::selectOne('SELECT 1 FROM PERSONA WHERE ci = ?', [$data['ci']]);
        if ($exists) {
            return back()->withErrors(['ci' => 'CI ya registrado'])->withInput();
        }

        // SP: sp_InsertarPersona
        // Orden según 4.procedimientos almacenados.sql:
        // @ci, @nombre, @apellido, @telefono, @sexo, @correo, @tipou, @tipoa, @tipoe, @contrasena, @codigo, @nroregistro
        DB::statement(
            'EXEC sp_InsertarPersona ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?',
            [
                $data['ci'],
                $data['nombre'],
                $data['apellido'],
                $data['telefono'],
                $data['sexo'],
                $data['correo'],
                $tipou,
                $tipoa,
                $tipoe,
                $data['contrasena'],
                $data['codigo'] ?? null,
                $data['nroregistro'] ?? null,
            ]
        );

        return redirect()->route('admin.persona.index')->with('success', 'Persona creada');
    }


    public function index(Request $request)
    {
        $tipo = $request->query('tipo', 'todos'); // 'todos', 'estudiantes', 'administradores'
        
        $query = 'SELECT ci, nombre, apellido, telefono, sexo, correo, tipou, tipoa, tipoe, codigo, nroregistro FROM PERSONA';
        
        // Aplicar filtro según el tipo
        if ($tipo === 'estudiantes') {
            $query .= ' WHERE tipoe = \'1\'';
        } elseif ($tipo === 'administradores') {
            $query .= ' WHERE tipoa = \'1\'';
        }
        
        $query .= ' ORDER BY nombre, apellido';
        
        $personas = DB::select($query);
        return view('admin.persona.index', compact('personas', 'tipo'));
    }


    public function edit($id)
    {
        $persona = DB::selectOne('SELECT TOP 1 ci, nombre, apellido, telefono, sexo, correo, tipou, tipoa, tipoe, contrasena, codigo, nroregistro FROM PERSONA WHERE ci = ?', [$id]);
        if (!$persona) {
            return redirect()->route('admin.persona.index')->with('error', 'Registro no encontrado.');
        }
        return view('admin.persona.edit', compact('persona'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'telefono' => 'required|string|max:8',
            'sexo' => 'required|in:M,F',
            'correo' => 'required|email|max:255',
            'tipou' => 'nullable|boolean',
            'tipoa' => 'nullable|boolean',
            'tipoe' => 'nullable|boolean',
            'contrasena' => 'required|string|max:255',
            'codigo' => 'nullable|string|max:20',
            'nroregistro' => 'nullable|string|max:20',
        ]);

        $tipou = $request->boolean('tipou') ? '1' : '0';
        $tipoa = $request->boolean('tipoa') ? '1' : '0';
        $tipoe = $request->boolean('tipoe') ? '1' : '0';

        // SP: sp_ActualizarPersona
        // @ci, @nombre, @apellido, @telefono, @sexo, @correo, @tipou, @tipoa, @tipoe, @contrasena, @codigo, @nroregistro
        DB::statement(
            'EXEC sp_ActualizarPersona ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?',
            [
                $id,
                $data['nombre'],
                $data['apellido'],
                $data['telefono'],
                $data['sexo'],
                $data['correo'],
                $tipou,
                $tipoa,
                $tipoe,
                $data['contrasena'],
                $data['codigo'] ?? null,
                $data['nroregistro'] ?? null,
            ]
        );
        return redirect()->route('admin.persona.index')->with('success', 'Persona actualizada exitosamente.');
    }
}
