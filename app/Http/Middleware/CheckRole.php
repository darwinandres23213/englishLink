<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CheckRole {

    public function handle(Request $request, Closure $next, ...$roles) {

        if (!Auth::check()) {
    
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Verificar si el usuario tiene uno de los roles permitidos
        foreach ($roles as $role) {
    
            if ($this->hasRole($user, $role)) {
                return $next($request);
            }
        }

        // Si no tiene permiso, redirigir al dashboard apropiado con mensaje de error
        return redirect($user->getDashboardRoute())
            ->with('error', 'No tienes permisos para acceder a esta sección.');
    }

    private function hasRole($user, $role) {
        
        switch ($role) {
            case 'admin':
                return $user->isAdmin();
            case 'profesor':
                return $user->isProfesor();
            case 'estudiante':
                return $user->isEstudiante();
            case 'coordinador':
                return $user->hasRole('Coordinador');
            case 'secretario':
                return $user->hasRole('Secretario');
            default:
                return false;
        }
    }
}
