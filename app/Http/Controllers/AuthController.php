<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLogin()
    {
        // Si ya está logueado, redirigir según rol
        if (session()->has('usuario')) {
            $usuario = session('usuario');
            
            if (($usuario['tipoa'] ?? '0') === '1') {
                return redirect('/admin');
            }
            if (($usuario['tipos'] ?? '0') === '1') {
                return redirect('/secretaria');
            }
            if (($usuario['tipot'] ?? '0') === '1') {
                return redirect('/tutor');
            }
            if (($usuario['tipoe'] ?? '0') === '1') {
                return redirect('/estudiante');
            }
            
            // Si tiene sesión pero sin rol válido, cerrar sesión
            session()->forget('usuario');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'correo' => 'required|email',
            'contrasena' => 'required|string',
        ]);

        // Autenticación contra tabla persona (columna 'contrasena')
        $row = DB::selectOne('SELECT TOP 1 ci, nombre, apellido, correo, contrasena AS password, tipou, tipoa, tipoe, tipot, tipos FROM persona WHERE correo = ?', [
            $validated['correo'],
        ]);

        if (!$row) {
            return back()->withErrors(['correo' => 'Credenciales inválidas'])->withInput();
        }

        // Comparación directa (Todos los datos son usados de sql server )
        if ($row->password !== $validated['contrasena']) {
            return back()->withErrors(['contrasena' => 'Credenciales inválidas'])->withInput();
        }

        // Guardar en sesión (solo los campos necesarios) y regenerar ID de sesión
        session(['usuario' => [
            'ci' => $row->ci,
            'nombre' => $row->nombre ?? null,
            'apellido' => $row->apellido ?? null,
            'correo' => $row->correo,
            'tipou' => $row->tipou ?? null,
            'tipoa' => $row->tipoa ?? null,
            'tipoe' => $row->tipoe ?? null,
            'tipot' => $row->tipot ?? null,
            'tipos' => $row->tipos ?? null,
        ]]);
        $request->session()->regenerate();

        // Redirección por roles
        $tipoa = $row->tipoa ?? null;
        $tipos = $row->tipos ?? null;
        $tipoe = $row->tipoe ?? null;
        $tipot = $row->tipot ?? null;
        
        if ($tipoa === '1') {
            return redirect('/admin');
        }
        
        if ($tipos === '1') {
            return redirect('/secretaria');
        }
        
        if ($tipot === '1') {
            return redirect('/tutor');
        }
        
        if ($tipoe === '1') {
            return redirect('/estudiante');
        }

        // Si no tiene ningún rol válido, cerrar sesión y mostrar error
        $request->session()->forget('usuario');
        return back()->withErrors(['correo' => 'No tienes permisos para acceder al sistema'])->withInput();
    }

    public function logout(Request $request)
    {
        $request->session()->forget('usuario');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
