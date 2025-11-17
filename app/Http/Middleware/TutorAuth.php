<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TutorAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $usuario = session('usuario');

        // Verificar que el usuario esté autenticado y sea tutor
        if (!$usuario || !isset($usuario['tipot']) || $usuario['tipot'] !== '1') {
            return redirect()->route('login')->with('error', 'Acceso denegado. Solo tutores pueden acceder a esta sección.');
        }

        return $next($request);
    }
}
