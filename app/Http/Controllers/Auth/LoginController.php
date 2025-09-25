<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class LoginController extends Controller {
    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Buscar usuario por email
        $usuario = Usuario::where('email', $request->email)->first();

        if ($usuario && Hash::check($request->password, $usuario->contrasena)) {
            // Verificar si el usuario está activo
            if (!$usuario->isActivo()) {
                return back()->withErrors([
                    'email' => 'Tu cuenta está inactiva. Contacta al administrador.',
                ]);
            }

            // Loguear usuario
            Auth::login($usuario, $request->filled('remember'));

            // Redireccionar según rol
            return $this->redirectByRole($usuario);
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

    public function logout(Request $request) {
        Auth::logout();
        
        // Invalidar sesión
        $request->session()->invalidate();
        
        // Regenerar token CSRF
        $request->session()->regenerateToken();
        
        // Limpiar cookies relacionadas con la sesión
        $request->session()->flush();
        
        // 🔥 CAMBIO: Usar bandera específica para SweetAlert en lugar del mensaje normal
        return redirect('/login')
            ->with('logout_exitoso', true)
            ->withHeaders([
                'Cache-Control' => 'no-cache, no-store, max-age=0, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => 'Fri, 01 Jan 1990 00:00:00 GMT'
            ]
        );
    }

    public function redirectByRole($usuario) {
        $roleName = $usuario->rol->nombre_rol;

        switch ($roleName) {
            case 'Administrador':
                return redirect()->route('admin.dashboard');
            case 'Profesor':
                return redirect()->route('profesor.dashboard');
            case 'Estudiante':
                return redirect()->route('estudiante.dashboard');
            case 'Coordinador':
                return redirect()->route('coordinador.dashboard');
            case 'Secretario':
                return redirect()->route('secretario.dashboard');
            default:
                return redirect()->route('dashboard.general');
        }
    }
}