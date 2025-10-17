<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EstudianteAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $usuario = $request->session()->get('usuario');
        if (!$usuario) {
            return redirect()->route('login');
        }
        if (($usuario['tipoe'] ?? '0') !== '1') {
            return redirect()->route('dashboard');
        }
        return $next($request);
    }
}
