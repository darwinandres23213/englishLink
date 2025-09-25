<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();
                $roleName = $user->rol->nombre_rol;

                switch ($roleName) {
                    case 'Administrador':
                        return redirect()->route('admin.dashboard');
                    case 'Profesor':
                        return redirect()->route('profesor.dashboard');
                    case 'Estudiante':
                        return redirect()->route('estudiante.dashboard');
                    default:
                        return redirect()->route('dashboard.general');
                }
            }
        }

        return $next($request);
    }
}