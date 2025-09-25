<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Role;
use App\Models\Estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller {
    public function showRegistrationForm() {
        $roles = Role::all();
        return view('auth.register', compact('roles'));
    }

    public function register(Request $request) {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:usuarios',
            'password' => 'required|string|min:8|confirmed',
            'rol_id' => 'required|exists:roles,id_rol',
        ]);

        // Crear usuario
        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'contrasena' => Hash::make($request->password),
            'rol_id' => $request->rol_id,
            'estado_id' => 1, // Estado "Activo" por defecto
        ]);


        // 🔥 CAMBIO: En lugar de loguearse automáticamente, redirigir al login con mensaje
        return redirect()->route('register')->with([
            'registro_exitoso' => true,
            'usuario_nombre' => $usuario->nombre,
            'usuario_email' => $usuario->email
        ]);



        /*
        // Loguear automáticamente
        Auth::login($usuario);

        // Redireccionar según rol
        return (new LoginController())->redirectByRole($usuario);
        */
    }
}