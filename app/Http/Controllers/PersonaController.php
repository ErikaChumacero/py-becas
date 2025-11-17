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
            'telefono' => 'required|string|max:15',
            'sexo' => 'required|in:M,F',
            'tipou' => 'nullable|boolean',
            'tipoe' => 'nullable|boolean',
            'tipot' => 'nullable|boolean',
            'tipom' => 'nullable|boolean',
            'tipoa' => 'nullable|boolean',
            'tipos' => 'nullable|boolean',
        ], [
            'ci.required' => 'El CI es obligatorio',
            'ci.max' => 'El CI no puede exceder 10 caracteres',
            'nombre.required' => 'El nombre es obligatorio',
            'apellido.required' => 'El apellido es obligatorio',
            'telefono.required' => 'El teléfono es obligatorio',
            'sexo.required' => 'El sexo es obligatorio',
        ]);

        // Generar correo único automáticamente
        $correo = $this->generarCorreoUnico($data['nombre'], $data['apellido']);

        // Normalizar flags a '1'/'0'
        $tipoe = $request->boolean('tipoe') ? '1' : '0';
        $tipot = $request->boolean('tipot') ? '1' : '0';
        $tipom = $request->boolean('tipom') ? '1' : '0';
        $tipoa = $request->boolean('tipoa') ? '1' : '0';
        $tipos = $request->boolean('tipos') ? '1' : '0';

        // Usuario SOLO para Admin, Secretaria o Tutor
        if ($tipoa === '1' || $tipos === '1' || $tipot === '1') {
            $tipou = '1';
            // Generar contraseña SOLO para usuarios (admin, secretaria, tutor)
            $contrasena = $data['ci'];
        } else {
            $tipou = '0';
            // Para estudiantes y maestros, usar el CI como contraseña por defecto
            $contrasena = $data['ci'];
        }

        // VALIDAR REGLAS DE ROLES
        // Regla 1: Un estudiante NO puede ser tutor
        if ($tipoe === '1' && $tipot === '1') {
            return back()->withErrors(['error' => 'Un estudiante no puede ser tutor'])->withInput();
        }

        // Regla 2: Un admin NO puede ser estudiante
        if ($tipoa === '1' && $tipoe === '1') {
            return back()->withErrors(['error' => 'Un administrador no puede ser estudiante'])->withInput();
        }

        // Evitar duplicado por PK
        $exists = DB::selectOne('SELECT 1 FROM persona WHERE ci = ?', [$data['ci']]);
        if ($exists) {
            return back()->withErrors(['ci' => 'CI ya registrado'])->withInput();
        }

        // SP: sp_InsertarPersona
        // @ci, @nombre, @apellido, @correo, @telefono, @sexo, @contrasena, @fecharegistro, @tipou, @tipoe, @tipot, @tipom, @tipoa, @tipos, @codestudiante, @codmaestro
        try {
            // Usar PDO directamente para manejar NULL correctamente
            $pdo = DB::connection()->getPdo();
            $stmt = $pdo->prepare('EXEC sp_InsertarPersona ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?');
            
            $stmt->bindValue(1, $data['ci']);
            $stmt->bindValue(2, $data['nombre']);
            $stmt->bindValue(3, $data['apellido']);
            $stmt->bindValue(4, $correo); // Correo generado automáticamente
            $stmt->bindValue(5, $data['telefono']);
            $stmt->bindValue(6, $data['sexo']);
            $stmt->bindValue(7, $contrasena); // Siempre tiene un valor (CI)
            $stmt->bindValue(8, now()->format('Y-m-d'));
            $stmt->bindValue(9, $tipou);
            $stmt->bindValue(10, $tipoe);
            $stmt->bindValue(11, $tipot);
            $stmt->bindValue(12, $tipom);
            $stmt->bindValue(13, $tipoa);
            $stmt->bindValue(14, $tipos);
            $stmt->bindValue(15, null, \PDO::PARAM_NULL);
            $stmt->bindValue(16, null, \PDO::PARAM_NULL);
            
            $stmt->execute();
        } catch (\Exception $e) {
            // Log del error técnico para el desarrollador
            \Log::error('Error al insertar persona: ' . $e->getMessage(), [
                'ci' => $data['ci'],
                'nombre' => $data['nombre'],
                'apellido' => $data['apellido'],
                'trace' => $e->getTraceAsString()
            ]);
            
            // TEMPORAL: Mostrar error completo para debugging
            return back()->withErrors(['error' => 'Error: ' . $e->getMessage()])->withInput();
            
            // Mensaje amigable para el usuario (descomentar después de arreglar)
            // return back()->withErrors(['error' => 'No se pudo registrar la persona. Por favor, verifica los datos e intenta nuevamente.'])->withInput();
        }

        return redirect()->route('admin.persona.index')->with('success', 'Persona creada exitosamente');
    }


    public function index(Request $request)
    {
        $tipo = $request->query('tipo', 'todos');
        $buscar = $request->query('buscar', '');
        $perPage = 5; // Mostrar 5 personas por página
        $page = $request->query('page', 1);
        $offset = ($page - 1) * $perPage;
        
        // Construir query base
        $whereConditions = [];
        $params = [];
        
        // Filtro por tipo
        if ($tipo === 'estudiantes') {
            $whereConditions[] = 'tipoe = \'1\'';
        } elseif ($tipo === 'maestros') {
            $whereConditions[] = 'tipom = \'1\'';
        } elseif ($tipo === 'tutores') {
            $whereConditions[] = 'tipot = \'1\'';
        } elseif ($tipo === 'administradores') {
            $whereConditions[] = 'tipoa = \'1\'';
        } elseif ($tipo === 'secretarias') {
            $whereConditions[] = 'tipos = \'1\'';
        }
        
        // Filtro por búsqueda (CI, nombre o apellido)
        if (!empty($buscar)) {
            $whereConditions[] = '(ci LIKE ? OR nombre LIKE ? OR apellido LIKE ?)';
            $searchTerm = '%' . $buscar . '%';
            $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm]);
        }
        
        // Construir WHERE clause
        $whereClause = '';
        if (!empty($whereConditions)) {
            $whereClause = ' WHERE ' . implode(' AND ', $whereConditions);
        }
        
        // Contar total de registros
        $countQuery = 'SELECT COUNT(*) as total FROM persona' . $whereClause;
        $totalResult = DB::selectOne($countQuery, $params);
        $total = $totalResult->total;
        
        // Query con paginación
        $query = 'SELECT ci, nombre, apellido, correo, telefono, sexo, fecharegistro, tipou, tipoe, tipot, tipom, tipoa, tipos, codestudiante, codmaestro 
                  FROM persona' . $whereClause . ' 
                  ORDER BY fecharegistro DESC, nombre, apellido
                  OFFSET ? ROWS FETCH NEXT ? ROWS ONLY';
        
        $params[] = $offset;
        $params[] = $perPage;
        
        $personas = DB::select($query, $params);
        
        // Calcular información de paginación
        $lastPage = ceil($total / $perPage);
        $pagination = [
            'current_page' => $page,
            'last_page' => $lastPage,
            'per_page' => $perPage,
            'total' => $total,
            'from' => $offset + 1,
            'to' => min($offset + $perPage, $total),
        ];
        
        return view('admin.persona.index', compact('personas', 'tipo', 'buscar', 'pagination'));
    }


    public function edit($id)
    {
        $persona = DB::selectOne('SELECT TOP 1 ci, nombre, apellido, correo, telefono, sexo, contrasena, fecharegistro, tipou, tipoe, tipot, tipom, tipoa, tipos, codestudiante, codmaestro FROM persona WHERE ci = ?', [$id]);
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
            'correo' => 'required|email|max:100',
            'telefono' => 'required|string|max:15',
            'sexo' => 'required|in:M,F',
            'contrasena' => 'nullable|string|max:50',
            'tipou' => 'nullable|boolean',
            'tipoe' => 'nullable|boolean',
            'tipot' => 'nullable|boolean',
            'tipom' => 'nullable|boolean',
            'tipoa' => 'nullable|boolean',
            'tipos' => 'nullable|boolean',
            'codestudiante' => 'nullable|string|max:10',
            'codmaestro' => 'nullable|string|max:10',
        ], [
            'nombre.required' => 'El nombre es obligatorio',
            'apellido.required' => 'El apellido es obligatorio',
            'correo.required' => 'El correo es obligatorio',
            'correo.email' => 'El correo debe ser válido',
            'telefono.required' => 'El teléfono es obligatorio',
            'sexo.required' => 'El sexo es obligatorio',
        ]);

        $tipoe = $request->boolean('tipoe') ? '1' : '0';
        $tipot = $request->boolean('tipot') ? '1' : '0';
        $tipom = $request->boolean('tipom') ? '1' : '0';
        $tipoa = $request->boolean('tipoa') ? '1' : '0';
        $tipos = $request->boolean('tipos') ? '1' : '0';

        // Obtener persona actual para verificar cambios
        $personaActual = DB::selectOne('SELECT tipou, contrasena, ci FROM persona WHERE ci = ?', [$id]);

        // Usuario SOLO para Admin, Secretaria o Tutor
        if ($tipoa === '1' || $tipos === '1' || $tipot === '1') {
            $tipou = '1';
            // Si cambió a usuario y no tenía contraseña, generar una
            if ($personaActual->tipou === '0' && empty($personaActual->contrasena)) {
                $contrasena = $personaActual->ci;
            } else {
                $contrasena = $data['contrasena'] ?? $personaActual->contrasena;
            }
        } else {
            $tipou = '0';
            // Para no usuarios, usar una contraseña vacía o el CI
            $contrasena = $personaActual->ci;
        }

        // VALIDAR REGLAS DE ROLES
        // Regla 1: Un estudiante NO puede ser tutor
        if ($tipoe === '1' && $tipot === '1') {
            return back()->withErrors(['error' => 'Un estudiante no puede ser tutor'])->withInput();
        }

        // Regla 2: Un admin NO puede ser estudiante
        if ($tipoa === '1' && $tipoe === '1') {
            return back()->withErrors(['error' => 'Un administrador no puede ser estudiante'])->withInput();
        }

        // Obtener fecharegistro actual
        $persona = DB::selectOne('SELECT fecharegistro FROM persona WHERE ci = ?', [$id]);

        // SP: sp_ActualizarPersona
        // @ci, @nombre, @apellido, @correo, @telefono, @sexo, @contrasena, @fecharegistro, @tipou, @tipoe, @tipot, @tipom, @tipoa, @tipos, @codestudiante, @codmaestro
        try {
            // Usar PDO directamente para manejar NULL correctamente
            $pdo = DB::connection()->getPdo();
            $stmt = $pdo->prepare('EXEC sp_ActualizarPersona ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?');
            
            $stmt->bindValue(1, $id);
            $stmt->bindValue(2, $data['nombre']);
            $stmt->bindValue(3, $data['apellido']);
            $stmt->bindValue(4, $data['correo']);
            $stmt->bindValue(5, $data['telefono']);
            $stmt->bindValue(6, $data['sexo']);
            $stmt->bindValue(7, $contrasena); // Siempre tiene un valor (nunca NULL)
            $stmt->bindValue(8, $persona->fecharegistro);
            $stmt->bindValue(9, $tipou);
            $stmt->bindValue(10, $tipoe);
            $stmt->bindValue(11, $tipot);
            $stmt->bindValue(12, $tipom);
            $stmt->bindValue(13, $tipoa);
            $stmt->bindValue(14, $tipos);
            
            // Códigos opcionales
            if (!empty($data['codestudiante'])) {
                $stmt->bindValue(15, $data['codestudiante']);
            } else {
                $stmt->bindValue(15, null, \PDO::PARAM_NULL);
            }
            
            if (!empty($data['codmaestro'])) {
                $stmt->bindValue(16, $data['codmaestro']);
            } else {
                $stmt->bindValue(16, null, \PDO::PARAM_NULL);
            }
            
            $stmt->execute();
        } catch (\Exception $e) {
            // Log del error técnico para el desarrollador
            \Log::error('Error al actualizar persona: ' . $e->getMessage(), [
                'ci' => $id,
                'nombre' => $data['nombre'],
                'apellido' => $data['apellido'],
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Mensaje amigable para el usuario
            return back()->withErrors(['error' => 'No se pudo actualizar la persona. Error: ' . $e->getMessage()])->withInput();
        }
        return redirect()->route('admin.persona.index')->with('success', 'Persona actualizada exitosamente.');
    }

    /**
     * Genera un correo único basado en nombre y apellido
     * Formato: nombre.apellido@escuelacristiana.edu.bo
     * Si existe, agrega número: nombre.apellido2@escuelacristiana.edu.bo
     */
    private function generarCorreoUnico($nombre, $apellido)
    {
        // Limpiar y normalizar nombre y apellido
        $nombre = $this->limpiarTexto($nombre);
        $apellido = $this->limpiarTexto($apellido);
        
        // Formato base del correo
        $dominio = '@escuelacristiana.edu.bo';
        $correoBase = strtolower($nombre . '.' . $apellido);
        $correo = $correoBase . $dominio;
        
        // Verificar si el correo ya existe
        $contador = 1;
        while (DB::selectOne('SELECT 1 FROM persona WHERE correo = ?', [$correo])) {
            $contador++;
            $correo = $correoBase . $contador . $dominio;
        }
        
        return $correo;
    }

    /**
     * Limpia el texto removiendo acentos, espacios y caracteres especiales
     */
    private function limpiarTexto($texto)
    {
        // Convertir a minúsculas
        $texto = mb_strtolower($texto, 'UTF-8');
        
        // Remover acentos
        $acentos = ['á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 
                    'ñ' => 'n', 'ü' => 'u', 'à' => 'a', 'è' => 'e', 'ì' => 'i', 
                    'ò' => 'o', 'ù' => 'u'];
        $texto = strtr($texto, $acentos);
        
        // Remover espacios y caracteres especiales, solo dejar letras y números
        $texto = preg_replace('/[^a-z0-9]/', '', $texto);
        
        return $texto;
    }
}
