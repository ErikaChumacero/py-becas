<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLogin()
    {
        // Si ya está logueado, ir al dashboard
        if (session()->has('usuario')) {
            return redirect('/admin');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'correo' => 'required|email',
            'contrasena' => 'required|string',
        ]);

        // Autenticación contra tabla PERSONA (columna 'contrasena')
        // 
        $row = DB::selectOne('SELECT TOP 1 ci, nombre, apellido, correo, contrasena AS password, tipou, tipoa, tipoe FROM PERSONA WHERE correo = ?', [
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
        ]]);
        $request->session()->regenerate();

        // Redirección por roles: administrador (tipoa) o estudiante (tipoe)
        $tipoa = $row->tipoa ?? null;
        $tipoe = $row->tipoe ?? null;
        if ($tipoa === '1') {
            return redirect('/admin');
        }
        if ($tipoe === '1') {
            return redirect('/estudiante');
        }

        // Fallback
        return redirect('/');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('usuario');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
