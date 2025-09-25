<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    public function adminDashboard()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }
        
        return view('dashboards.admin');
    }

    public function profesorDashboard()
    {
        if (!Auth::user()->isProfesor()) {
            abort(403);
        }
        
        return view('dashboards.profesor');
    }

    public function estudianteDashboard()
    {
        if (!Auth::user()->isEstudiante()) {
            abort(403);
        }
        
        $user = Auth::user();
        
        // Obtener estadísticas de entregas del estudiante
        $todasLasEntregas = \App\Models\EntregaActividad::where('estudiante_id', $user->id_usuario)->get();
        $estadisticas = [
            'total' => $todasLasEntregas->count(),
            'entregadas' => $todasLasEntregas->whereNotNull('fecha_entrega')->count(),
            'pendientes' => $todasLasEntregas->whereNull('fecha_entrega')->count(),
            'calificadas' => $todasLasEntregas->whereNotNull('calificacion_obtenida')->count(),
        ];
        
        return view('dashboards.estudiante', compact('estadisticas'));
    }

    public function coordinadorDashboard()
    {
        if (!Auth::user()->hasRole('Coordinador')) {
            abort(403);
        }
        
        return view('dashboards.coordinador');
    }

    public function secretarioDashboard()
    {
        if (!Auth::user()->hasRole('Secretario')) {
            abort(403);
        }
        
        return view('dashboards.secretario');
    }

    public function generalDashboard()
    {
        return view('dashboards.general');
    }
}