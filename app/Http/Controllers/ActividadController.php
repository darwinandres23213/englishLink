<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Curso;
use App\Models\EntregaActividad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ActividadController extends Controller {
    public function index(Request $request) {
        $user = Auth::user();
        
        if ($user->isProfesor()) {
            // Query base para actividades del profesor
            $query = Actividad::whereHas('curso', function($q) use ($user) {
                $q->where('profesor_id', $user->id_usuario);
            })->with(['curso.nivel', 'entregas']);
            
            // Obtener cursos del profesor para el filtro
            $cursos = $user->cursosComoProfesor()->with('nivel')->get();
        } else {
            // Administradores ven todas las actividades
            $query = Actividad::with(['curso.nivel', 'entregas', 'profesor']);
            $cursos = Curso::with('nivel')->get();
        }

        // Aplicar filtros
        
        // Filtro por búsqueda
        if ($request->filled('buscar')) {
            $query->where(function($q) use ($request) {
                $q->where('titulo', 'like', '%' . $request->buscar . '%')
                  ->orWhere('descripcion', 'like', '%' . $request->buscar . '%');
            });
        }

        // Filtro por curso
        if ($request->filled('curso_id')) {
            $query->where('curso_id', $request->curso_id);
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            switch ($request->estado) {
                case 'activa':
                    $query->where('activa', true)->where('fecha_vencimiento', '>', now());
                    break;
                case 'inactiva':
                    $query->where('activa', false);
                    break;
                case 'vencida':
                    $query->where('fecha_vencimiento', '<=', now());
                    break;
            }
        }

        // Filtro por fechas
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_vencimiento', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_vencimiento', '<=', $request->fecha_hasta);
        }

        // Ordenar y paginar
        $actividades = $query->orderBy('id_actividad', 'desc')
            ->paginate(7);
        
        return view('actividades.index', compact('actividades', 'cursos'));
    }




    public function create() {
        $user = Auth::user();
        
        if ($user->isProfesor()) {
            // Solo cursos que enseña este profesor
            $cursos = $user->cursosComoProfesor;
        } else {
            // Administradores pueden crear actividades para cualquier curso
            $cursos = Curso::all();
        }
        
        return view('actividades.create', compact('cursos'));
    }




    public function store(Request $request) {
        $request->validate([
            'curso_id' => 'required|exists:cursos,id_curso',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'instrucciones' => 'nullable|string',
            'fecha_vencimiento' => 'required|date|after:now',
            'calificacion_maxima' => 'required|numeric|min:1|max:5',
            'tipo_entrega' => 'required|in:archivo,texto,ambos'
        ]);

        $user = Auth::user();
        
        // Verificar que el profesor pueda crear actividades para este curso
        if ($user->isProfesor() && !$user->esProfesorDeCurso($request->curso_id)) {
            return redirect()->back()->with('error', 'No tienes permisos para crear actividades en este curso.');
        }

        // Convertir la fecha de vencimiento al timezone configurado en la aplicación
        $fechaVencimiento = \Carbon\Carbon::parse($request->fecha_vencimiento)->setTimezone(config('app.timezone'));

        $actividad = Actividad::create([
            'curso_id' => $request->curso_id,
            'profesor_id' => $user->id_usuario,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'instrucciones' => $request->instrucciones,
            'fecha_asignacion' => now(),
            'fecha_vencimiento' => $fechaVencimiento,
            'calificacion_maxima' => $request->calificacion_maxima,
            'tipo_entrega' => $request->tipo_entrega,
            'activa' => $request->has('activa') ? 1 : 0
        ]);

        // Crear registros de entrega vacíos para todos los estudiantes matriculados
        $curso = Curso::find($request->curso_id);
        foreach ($curso->estudiantes as $estudiante) {
            EntregaActividad::create([
                'actividad_id' => $actividad->id_actividad,
                'estudiante_id' => $estudiante->id_usuario,
                'estado' => 'sin_entregar'
            ]);
        }

        return redirect()->route('actividades.index')->with('success', 'Actividad creada correctamente y asignada a todos los estudiantes del curso.');
    }




    public function show(Actividad $actividad) {
        $actividad->load(['curso', 'profesor', 'entregas.estudiante']);
        
        $user = Auth::user();
        
        // Verificar permisos
        if ($user->isProfesor() && !$user->esProfesorDeCurso($actividad->curso_id)) {
            abort(403, 'No tienes permisos para ver esta actividad.');
        }

        return view('actividades.show', compact('actividad'));
    }




    public function edit(Actividad $actividad) {
        $user = Auth::user();
        
        // Verificar permisos
        if ($user->isProfesor() && $actividad->profesor_id !== $user->id_usuario) {
            abort(403, 'No tienes permisos para editar esta actividad.');
        }

        if ($user->isProfesor()) {
            $cursos = $user->cursosComoProfesor;
        } else {
            $cursos = Curso::all();
        }
        
        return view('actividades.create', compact('actividad', 'cursos'));
    }




    public function update(Request $request, Actividad $actividad) {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'instrucciones' => 'nullable|string',
            'fecha_vencimiento' => 'required|date',
            'calificacion_maxima' => 'required|numeric|min:1|max:5',
            'tipo_entrega' => 'required|in:archivo,texto,ambos'
        ]);

        $user = Auth::user();
        
        // Verificar permisos
        if ($user->isProfesor() && $actividad->profesor_id !== $user->id_usuario) {
            abort(403, 'No tienes permisos para editar esta actividad.');
        }

        // Convertir la fecha de vencimiento al timezone configurado en la aplicación
        $fechaVencimiento = \Carbon\Carbon::parse($request->fecha_vencimiento)->setTimezone(config('app.timezone'));

        $actividad->update([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'instrucciones' => $request->instrucciones,
            'fecha_vencimiento' => $fechaVencimiento,
            'calificacion_maxima' => $request->calificacion_maxima,
            'tipo_entrega' => $request->tipo_entrega,
            'activa' => $request->has('activa') ? 1 : 0
        ]);

        return redirect()->route('actividades.show', $actividad)->with('success', 'Actividad actualizada correctamente.');
    }




    public function destroy(Actividad $actividad) {
        $user = Auth::user();
        
        // Verificar permisos
        if ($user->isProfesor() && $actividad->profesor_id !== $user->id_usuario) {
            abort(403, 'No tienes permisos para eliminar esta actividad.');
        }

        $actividad->delete();
        return redirect()->route('actividades.index')->with('success', 'Actividad eliminada correctamente.');
    }




    // Vista para calificar entregas
    public function calificar(Actividad $actividad) {
        $user = Auth::user();
        
        // Verificar permisos
        if ($user->isProfesor() && $actividad->profesor_id !== $user->id_usuario) {
            abort(403, 'No tienes permisos para calificar esta actividad.');
        }

        $entregas = $actividad->entregas()->with('estudiante')->get();
        
        return view('actividades.calificar', compact('actividad', 'entregas'));
    }
}
