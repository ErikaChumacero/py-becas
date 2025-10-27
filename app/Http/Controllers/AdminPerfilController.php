<?php

namespace App\Http\Controllers;

use App\Helpers\ErrorHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminPerfilController extends Controller
{
    private function currentAdminCi(): ?string
    {
        $u = session('usuario');
        return $u['ci'] ?? null;
    }

    public function index()
    {
        $ci = $this->currentAdminCi();
        if (!$ci) { abort(403); }

        try {
            // Obtener información del administrador
            $admin = DB::selectOne(<<<SQL
                SELECT 
                    ci,
                    nombre,
                    apellido,
                    correo,
                    telefono,
                    sexo,
                    tipou,
                    tipoe,
                    tipoa
                FROM PERSONA
                WHERE ci = ?
            SQL, [$ci]);

            if (!$admin) { 
                return redirect()->route('admin.dashboard')
                    ->with('error', 'No se pudo cargar la información del perfil.');
            }

            return view('admin.perfil.index', compact('admin'));
        } catch (\Throwable $e) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Ocurrió un error al cargar tu perfil. Por favor, intenta nuevamente.');
        }
    }

    public function updateCorreo(Request $request)
    {
        $ci = $this->currentAdminCi();
        if (!$ci) { abort(403); }

        $data = $request->validate([
            'correo' => 'required|email|max:100',
        ], [
            'correo.required' => 'El correo electrónico es obligatorio.',
            'correo.email' => 'Ingresa un correo electrónico válido.',
            'correo.max' => 'El correo no puede tener más de 100 caracteres.',
        ]);

        try {
            // Verificar que el correo no esté en uso por otro usuario
            $existe = DB::selectOne(
                'SELECT ci FROM PERSONA WHERE correo = ? AND ci != ?',
                [$data['correo'], $ci]
            );

            if ($existe) {
                return back()->withErrors(['correo' => 'Este correo ya está en uso por otro usuario.'])->withInput();
            }

            // Actualizar correo
            DB::update(
                'UPDATE PERSONA SET correo = ? WHERE ci = ?',
                [$data['correo'], $ci]
            );

            // Actualizar sesión
            $usuario = session('usuario');
            $usuario['correo'] = $data['correo'];
            session(['usuario' => $usuario]);

            return back()->with('success_correo', '✓ Correo electrónico actualizado exitosamente.');
        } catch (\Throwable $e) {
            return back()->withErrors(['correo' => 'Error al actualizar el correo. Intenta nuevamente.'])->withInput();
        }
    }

    public function updatePassword(Request $request)
    {
        $ci = $this->currentAdminCi();
        if (!$ci) { abort(403); }

        $data = $request->validate([
            'password_actual' => 'required',
            'password_nuevo' => 'required|min:6|max:50',
            'password_confirmacion' => 'required|same:password_nuevo',
        ], [
            'password_actual.required' => 'La contraseña actual es obligatoria.',
            'password_nuevo.required' => 'La nueva contraseña es obligatoria.',
            'password_nuevo.min' => 'La nueva contraseña debe tener al menos 6 caracteres.',
            'password_nuevo.max' => 'La nueva contraseña no puede tener más de 50 caracteres.',
            'password_confirmacion.required' => 'Debes confirmar la nueva contraseña.',
            'password_confirmacion.same' => 'Las contraseñas no coinciden.',
        ]);

        try {
            // Verificar contraseña actual
            $usuario = DB::selectOne('SELECT contrasena FROM PERSONA WHERE ci = ?', [$ci]);
            
            if (!$usuario) {
                return back()->withErrors(['password_actual' => 'Usuario no encontrado.']);
            }

            // Verificar que la contraseña actual sea correcta (comparación texto plano)
            if ($usuario->contrasena !== $data['password_actual']) {
                return back()->withErrors(['password_actual' => 'La contraseña actual es incorrecta.']);
            }

            // Verificar que la nueva contraseña sea diferente
            if ($usuario->contrasena === $data['password_nuevo']) {
                return back()->withErrors(['password_nuevo' => 'La nueva contraseña debe ser diferente a la actual.']);
            }

            // Actualizar contraseña en texto plano (sin encriptación)
            DB::update('UPDATE PERSONA SET contrasena = ? WHERE ci = ?', [
                $data['password_nuevo'],
                $ci
            ]);

            return back()->with('success_password', '✓ Contraseña actualizada exitosamente. Por seguridad, te recomendamos cerrar sesión e iniciar nuevamente.');
        } catch (\Throwable $e) {
            return back()->withErrors(['password_actual' => 'Error al cambiar la contraseña. Por favor, contacte al administrador.']);
        }
    }
}
