<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\Curso;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClaseController extends Controller
{
    public function index(Request $request)
    {
        /** @var Usuario $user */
        $user = Auth::user();
        
        // Filtrar clases solo de los cursos que imparte el profesor
        $query = Clase::with(['curso.nivel'])
            ->whereHas('curso', function($q) use ($user) {
                if ($user->isProfesor()) {
                    $q->where('profesor_id', $user->id_usuario);
                }
                // Si es admin, no aplicar filtro (ve todas las clases)
            });
        
        // Filtro por búsqueda (tema)
        if ($request->filled('buscar')) {
            $query->where('tema', 'like', '%' . $request->buscar . '%');
        }
        
        // Filtro por curso
        if ($request->filled('curso_id')) {
            $query->where('curso_id', $request->curso_id);
        }
        
        // Filtro por rango de fechas
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha', '>=', $request->fecha_desde);
        }
        
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha', '<=', $request->fecha_hasta);
        }
        
        // Filtro por estado
        if ($request->filled('estado')) {
            $hoy = now()->startOfDay();
            switch ($request->estado) {
                case 'hoy':
                    $query->whereDate('fecha', $hoy);
                    break;
                case 'programada':
                    $query->whereDate('fecha', '>', $hoy);
                    break;
                case 'completada':
                    $query->whereDate('fecha', '<', $hoy);
                    break;
            }
        }
        
        $clases = $query->orderBy('fecha', 'desc')->paginate(10);
        
        // Mantener parámetros de filtro en la paginación
        $clases->appends($request->except('page'));
        
        // Obtener solo los cursos que imparte el profesor para el filtro
        if ($user->isProfesor()) {
            $cursos = Curso::with('nivel')->where('profesor_id', $user->id_usuario)->get();
        } else {
            // Si es admin, mostrar todos los cursos
            $cursos = Curso::with('nivel')->get();
        }
        
        return view('clases.index', compact('clases', 'cursos'));
    }

    public function create()
    {
        /** @var Usuario $user */
        $user = Auth::user();
        
        // Solo mostrar cursos que imparte el profesor
        if ($user->isProfesor()) {
            $cursos = Curso::with('nivel')->where('profesor_id', $user->id_usuario)->get();
        } else {
            // Si es admin, mostrar todos los cursos
            $cursos = Curso::with('nivel')->get();
        }
        
        return view('clases.create', compact('cursos'));
    }

    public function store(Request $request)
    {
        /** @var Usuario $user */
        $user = Auth::user();
        
        $request->validate([
            'curso_id' => 'required|exists:cursos,id_curso',
            'fecha' => 'required|date|after_or_equal:today',
            'tema' => 'required|string|max:255|min:5',
            'material' => 'required|string|min:10',
        ]);
        
        // Si es profesor, verificar que pueda crear clases para este curso
        if ($user->isProfesor()) {
            $cursoPermitido = Curso::where('id_curso', $request->curso_id)
                ->where('profesor_id', $user->id_usuario)
                ->exists();
            
            if (!$cursoPermitido) {
                return redirect()->back()->with('error', 'No tienes permisos para crear clases en este curso.');
            }
        }
        
        $clase = Clase::create($request->all());
        
        // Si viene desde asistencias, redirigir de vuelta
        if ($request->has('from_asistencia')) {
            return redirect()->route('asistencias.create', ['curso' => $clase->curso_id])
                ->with('success', 'Clase creada correctamente. Ya puede tomar asistencia.');
        }
        
        return redirect()->route('clases.index')->with('success', 'Clase creada correctamente.');
    }

    public function show(Clase $clase)
    {
        return view('clases.show', compact('clase'));
    }

    public function edit(Clase $clase)
    {
        /** @var Usuario $user */
        $user = Auth::user();
        
        // Verificar que el profesor solo pueda editar clases de sus cursos
        if ($user->isProfesor() && $clase->curso->profesor_id !== $user->id_usuario) {
            abort(403, 'No tienes permisos para editar esta clase.');
        }
        
        // Solo mostrar cursos que imparte el profesor
        if ($user->isProfesor()) {
            $cursos = Curso::with('nivel')->where('profesor_id', $user->id_usuario)->get();
        } else {
            // Si es admin, mostrar todos los cursos
            $cursos = Curso::with('nivel')->get();
        }
        
        return view('clases.create', compact('clase', 'cursos'));
    }

    public function update(Request $request, Clase $clase)
    {
        /** @var Usuario $user */
        $user = Auth::user();
        
        // Verificar que el profesor solo pueda actualizar clases de sus cursos
        if ($user->isProfesor() && $clase->curso->profesor_id !== $user->id_usuario) {
            abort(403, 'No tienes permisos para actualizar esta clase.');
        }
        
        $request->validate([
            'curso_id' => 'required|exists:cursos,id_curso',
            'fecha' => 'required|date',
            'tema' => 'required|string|max:255',
            'material' => 'required|string|min:10',
        ]);
        
        // Si es profesor, verificar que no pueda cambiar el curso a uno que no imparte
        if ($user->isProfesor() && $request->curso_id != $clase->curso_id) {
            $cursoPermitido = Curso::where('id_curso', $request->curso_id)
                ->where('profesor_id', $user->id_usuario)
                ->exists();
            
            if (!$cursoPermitido) {
                return redirect()->back()->with('error', 'No tienes permisos para asignar esta clase a ese curso.');
            }
        }
        
        $clase->update($request->all());
        return redirect()->route('clases.index')->with('success', 'Clase actualizada correctamente.');
    }

    public function destroy(Clase $clase)
    {
        $clase->delete();
        return redirect()->route('clases.index')->with('success', 'Clase eliminada correctamente.');
    }




    /**
     * Mostrar las clases que imparte el profesor autenticado
     */
    public function misClases()
    {
        /** @var Usuario $user */
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Debe iniciar sesión.');
        }
        
        // Obtener los cursos que imparte este profesor directamente
        $cursosDelProfesor = Curso::where('profesor_id', $user->id_usuario)
            ->with(['nivel', 'matriculas.estudiante'])
            ->get();

        // Obtener estadísticas
        $totalCursos = $cursosDelProfesor->count();
        $totalEstudiantes = $cursosDelProfesor->sum(function($curso) {
            return $curso->matriculas->count();
        });

        return view('profesor.mis-clases', compact('cursosDelProfesor', 'totalCursos', 'totalEstudiantes'));
    }

    /**
     * Vista detallada de un curso específico para el profesor
     */
    public function verCurso($cursoId)
    {
        /** @var Usuario $user */
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Debe iniciar sesión.');
        }
        
        // Obtener el curso y verificar que pertenece al profesor
        $curso = Curso::where('id_curso', $cursoId)
            ->where('profesor_id', $user->id_usuario)
            ->with([
                'nivel', 
                'horario',
                'matriculas.estudiante',
                'actividades' => function($query) {
                    $query->orderBy('fecha_vencimiento', 'desc');
                },
                'actividades.entregas.estudiante'
            ])
            ->first();
            
        if (!$curso) {
            return redirect()->route('profesor.mis-clases')
                ->with('error', 'No tienes acceso a este curso.');
        }
        
        // Estadísticas del curso
        $totalEstudiantes = $curso->matriculas->count();
        $totalActividades = $curso->actividades->count();
        $actividadesVencidas = $curso->actividades->filter(function($actividad) {
            return $actividad->fecha_vencimiento < now();
        })->count();
        
        // Actividades ordenadas: activas primero, luego vencidas
        $actividadesRecientes = $curso->actividades->sortBy(function($actividad) {
            // Las activas (fecha_vencimiento >= now()) tendrán prioridad 0
            // Las vencidas (fecha_vencimiento < now()) tendrán prioridad 1
            $esVencida = $actividad->fecha_vencimiento < now() ? 1 : 0;
            // Ordenar por prioridad y luego por fecha de vencimiento
            return [$esVencida, $actividad->fecha_vencimiento];
        });
        
        // Entregas pendientes de calificar (solo las que ya fueron enviadas por estudiantes)
        $entregasPendientes = collect();
        foreach ($curso->actividades as $actividad) {
            // Solo entregas que tienen estado 'entregado' y no tienen calificación
            $entregas = $actividad->entregas->where('estado', 'entregado')->where('calificacion', null);
            $entregasPendientes = $entregasPendientes->merge($entregas);
        }
        $totalEntregasPendientes = $entregasPendientes->count();
        
        // Estudiantes con mejor rendimiento (lógica corregida)
        $estudiantesRendimiento = $curso->matriculas->map(function($matricula) use ($curso) {
            $estudiante = $matricula->estudiante;
            $totalActividades = $curso->actividades->count();
            
            // Obtener todas las entregas del estudiante para este curso
            $entregas = collect();
            foreach ($curso->actividades as $actividad) {
                $entregasEstudiante = $actividad->entregas->where('estudiante_id', $estudiante->id_usuario);
                $entregas = $entregas->merge($entregasEstudiante);
            }
            
            // Separar por estados
            $entregasRealizadas = $entregas->whereIn('estado', ['entregado', 'calificado']); // Entregas que hizo
            $entregasCalificadas = $entregas->where('estado', 'calificado')->whereNotNull('calificacion'); // Solo las calificadas
            $entregasPendientes = $entregas->where('estado', 'entregado')->whereNull('calificacion'); // Entregadas pero sin calificar
            
            // Calcular promedio: promedio de las calificaciones obtenidas (sobre 5.0)
            // Si hay actividades sin calificar (no entregadas o pendientes), NO afectan el promedio
            // Solo se promedian las notas de actividades que ya tienen calificación
            $promedioNota = $entregasCalificadas->count() > 0 ? 
                $entregasCalificadas->avg('calificacion') : 0;
                
            // Porcentaje para colores: (promedio/5.0) * 100
            $porcentajeRendimiento = $promedioNota > 0 ? ($promedioNota / 5.0) * 100 : 0;
                
            return [
                'estudiante' => $estudiante,
                'total_actividades' => $totalActividades,
                'entregas_realizadas' => $entregasRealizadas->count(), // Cuántas entregó
                'entregas_calificadas' => $entregasCalificadas->count(), // Cuántas están calificadas
                'entregas_pendientes' => $entregasPendientes->count(), // Entregadas pero sin calificar
                'sin_entregar' => $totalActividades - $entregasRealizadas->count(), // No entregadas
                'promedio' => round($promedioNota, 2), // Promedio sobre 5.0
                'porcentaje' => round($porcentajeRendimiento, 1) // Porcentaje para colores
            ];
        })->sortByDesc('promedio')->take(10);
        
        return view('profesor.curso-detalle', compact(
            'curso',
            'totalEstudiantes',
            'totalActividades', 
            'actividadesVencidas',
            'actividadesRecientes',
            'totalEntregasPendientes',
            'entregasPendientes',
            'estudiantesRendimiento'
        ));
    }
}