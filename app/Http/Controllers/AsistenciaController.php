<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Clase;
use App\Models\Usuario;
use App\Models\Estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AsistenciaController extends Controller
{
    public function index(Request $request)
    {
        $profesorId = Auth::user()->id_usuario;
        
        // Construir la query base filtrando por profesor
        $query = Asistencia::with(['clase.curso', 'estudiante', 'estado'])
            ->whereHas('clase.curso', function($q) use ($profesorId) {
                $q->where('profesor_id', $profesorId);
            });
        
        // Si viene un curso específico, filtrar por ese curso
        if ($request->has('curso') && $request->curso) {
            $query->whereHas('clase', function($q) use ($request) {
                $q->where('curso_id', $request->curso);
            });
        }
        
        $asistencias = $query->orderBy('id_asistencia', 'desc')->paginate(15);
        
        return view('asistencias.index', compact('asistencias'));
    }

    public function create(Request $request)
    {
        $profesorId = Auth::user()->id_usuario;
        
        // Obtener clases del profesor autenticado
        $clases = Clase::with(['curso'])
            ->whereHas('curso', function($query) use ($profesorId) {
                $query->where('profesor_id', $profesorId);
            })
            ->orderBy('fecha', 'desc')
            ->get();
        
        // Si viene un curso específico desde la URL
        $cursoId = $request->get('curso');
        if ($cursoId) {
            $clases = $clases->where('curso.id_curso', $cursoId);
        }
        
        // Inicialmente sin estudiantes (se cargarán por AJAX)
        $estudiantes = collect();
        
        // Obtener todos los estados de asistencia disponibles
        $estados = Estado::whereHas('tipoEstado', function($query) {
            $query->where('nombre_tipo_estado', 'Asistencia');
        })->get();
        
        return view('asistencias.create', compact('clases', 'estudiantes', 'estados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'clase_id' => 'required|exists:clases,id_clase',
            'estudiante_id' => 'required|exists:usuarios,id_usuario',
            'estado_id' => 'required|exists:estados,id_estado',
        ]);
        
        // Verificar que la clase pertenezca al profesor autenticado
        $clase = Clase::whereHas('curso', function($query) {
            $query->where('profesor_id', Auth::user()->id_usuario);
        })->find($request->clase_id);
        
        if (!$clase) {
            return back()->withErrors(['clase_id' => 'No tiene permisos para registrar asistencia en esta clase.']);
        }
        
        // Verificar si ya existe un registro
        $existeAsistencia = Asistencia::where('clase_id', $request->clase_id)
            ->where('estudiante_id', $request->estudiante_id)
            ->first();
        
        if ($existeAsistencia) {
            return back()->withErrors(['estudiante_id' => 'Ya existe un registro de asistencia para este estudiante en esta clase.']);
        }
        
        // Si se envía estado_id directamente, usarlo; si no, mapear desde asistio por compatibilidad
        $estadoId = $request->estado_id;
        if (!$estadoId && $request->has('asistio')) {
            // Mapear valores numéricos a IDs de estado para compatibilidad
            $estadoMap = [
                0 => 22, // No Asistió
                1 => 21, // Asistió  
                2 => 23, // Llegó Tarde
            ];
            $estadoId = $estadoMap[$request->asistio];
        }
        
        Asistencia::create([
            'clase_id' => $request->clase_id,
            'estudiante_id' => $request->estudiante_id,
            'estado_id' => $estadoId,
        ]);
        
        return back()->with('success', 'Asistencia registrada correctamente.');
    }

    public function show(Asistencia $asistencia)
    {
        return view('asistencias.show', compact('asistencia'));
    }

    public function edit(Asistencia $asistencia)
    {
        $profesorId = Auth::user()->id_usuario;
        
        // Cargar las relaciones necesarias
        $asistencia->load(['estado', 'clase.curso', 'estudiante']);
        
        // Verificar que la asistencia pertenezca a una clase del profesor
        $clases = Clase::with(['curso'])
            ->whereHas('curso', function($query) use ($profesorId) {
                $query->where('profesor_id', $profesorId);
            })
            ->orderBy('fecha', 'desc')
            ->get();
        
        // Obtener estudiantes del curso de la clase seleccionada
        $estudiantes = collect();
        if ($asistencia->clase) {
            $estudiantes = Usuario::whereHas('matriculas', function($query) use ($asistencia) {
                $query->where('curso_id', $asistencia->clase->curso->id_curso);
            })
            ->whereHas('rol', function($query) {
                $query->where('nombre_rol', 'Estudiante');
            })
            ->orderBy('nombre')
            ->orderBy('apellido')
            ->get();
        }

        // Obtener todos los estados de asistencia disponibles
        $estados = Estado::whereHas('tipoEstado', function($query) {
            $query->where('nombre_tipo_estado', 'Asistencia');
        })->get();
        
        return view('asistencias.create', compact('asistencia', 'clases', 'estudiantes', 'estados'));
    }

    public function update(Request $request, Asistencia $asistencia)
    {
        $request->validate([
            'clase_id' => 'required|exists:clases,id_clase',
            'estudiante_id' => 'required|exists:usuarios,id_usuario',
            'estado_id' => 'required|exists:estados,id_estado',
        ]);
        
        $asistencia->update([
            'clase_id' => $request->clase_id,
            'estudiante_id' => $request->estudiante_id,
            'estado_id' => $request->estado_id,
        ]);
        
        return redirect()->route('asistencias.index')->with('success', 'Asistencia actualizada correctamente.');
    }

    public function destroy(Asistencia $asistencia)
    {
        $asistencia->delete();
        return redirect()->route('asistencias.index')->with('success', 'Asistencia eliminada correctamente.');
    }

    // Método específico para que los estudiantes vean sus asistencias
    public function misAsistencias()
    {
        $estudiante_id = Auth::user()->id_usuario;
        
        $asistencias = Asistencia::with(['clase', 'estudiante'])
            ->where('estudiante_id', $estudiante_id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('asistencias.estudiante', compact('asistencias'));
    }

    // Mostrar formulario de registro masivo por clase
    public function registrarMasivo(Request $request)
    {
        $profesorId = Auth::user()->id_usuario;
        
        // Obtener clases del profesor autenticado
        $clases = Clase::with(['curso'])
            ->whereHas('curso', function($query) use ($profesorId) {
                $query->where('profesor_id', $profesorId);
            })
            ->orderBy('fecha', 'desc')
            ->get();
        
        $estudiantes = collect();
        $claseSeleccionada = null;
        
        // Si viene un curso específico desde la URL
        $cursoId = $request->get('curso');
        if ($cursoId) {
            $clases = $clases->where('curso.id_curso', $cursoId);
        }
        
        if ($request->has('clase_id') && $request->clase_id) {
            $claseSeleccionada = Clase::with(['curso'])
                ->whereHas('curso', function($query) use ($profesorId) {
                    $query->where('profesor_id', $profesorId);
                })
                ->find($request->clase_id);
            
            if ($claseSeleccionada && $claseSeleccionada->curso) {
                // Obtener estudiantes matriculados en el curso de esta clase
                $estudiantes = Usuario::whereHas('matriculas', function($query) use ($claseSeleccionada) {
                    $query->where('curso_id', $claseSeleccionada->curso->id_curso);
                })
                ->whereHas('rol', function($query) {
                    $query->where('nombre_rol', 'Estudiante');
                })
                ->orderBy('nombre')
                ->orderBy('apellido')
                ->get();
                
                // Verificar asistencias ya registradas y guardar el estado actual
                foreach ($estudiantes as $estudiante) {
                    $asistenciaExistente = Asistencia::where('clase_id', $claseSeleccionada->id_clase)
                        ->where('estudiante_id', $estudiante->id_usuario)
                        ->first();
                    
                    // Mapear IDs de estado a valores numéricos para la vista
                    $estadoMap = [
                        21 => 1, // Presente
                        22 => 0, // Ausente  
                        23 => 2, // Tardanza
                        24 => 0, // Justificado (por defecto como ausente en la vista)
                    ];
                    
                    // Agregar información de asistencia al estudiante
                    $estudiante->asistencia_registrada = $asistenciaExistente ? true : false;
                    $estudiante->estado_asistencia = $asistenciaExistente 
                        ? ($estadoMap[$asistenciaExistente->estado_id] ?? 1) 
                        : null;
                    $estudiante->id_asistencia = $asistenciaExistente ? $asistenciaExistente->id_asistencia : null;
                }
            }
        }
        
        return view('asistencias.registrar_masivo', compact('clases', 'estudiantes', 'claseSeleccionada'));
    }

    // Guardar asistencias masivas
    public function storeMasivo(Request $request)
    {
        $request->validate([
            'clase_id' => 'required|exists:clases,id_clase',
            'asistencia' => 'required|array',
            'asistencia.*' => 'required|in:0,1,2', // 0=Ausente, 1=Presente, 2=Tardanza
        ]);

        $clase_id = $request->clase_id;
        $asistencias = $request->asistencia;
        $registrosCreados = 0;
        $registrosActualizados = 0;

        // Mapear valores numéricos a IDs de estado
        $estadoMap = [
            0 => 22, // Ausente
            1 => 21, // Presente
            2 => 23, // Tardanza
        ];

        foreach ($asistencias as $estudiante_id => $valorAsistencia) {
            $estado_id = $estadoMap[$valorAsistencia];
            
            // Verificar si ya existe un registro para esta combinación
            $existeRegistro = Asistencia::where('clase_id', $clase_id)
                ->where('estudiante_id', $estudiante_id)
                ->first();

            if ($existeRegistro) {
                // Actualizar registro existente
                $existeRegistro->update([
                    'estado_id' => $estado_id,
                ]);
                $registrosActualizados++;
            } else {
                // Crear nuevo registro
                Asistencia::create([
                    'clase_id' => $clase_id,
                    'estudiante_id' => $estudiante_id,
                    'estado_id' => $estado_id,
                ]);
                $registrosCreados++;
            }
        }

        $mensaje = "Asistencias procesadas correctamente.";
        if ($registrosCreados > 0) {
            $mensaje .= " {$registrosCreados} nuevas asistencias registradas.";
        }
        if ($registrosActualizados > 0) {
            $mensaje .= " {$registrosActualizados} asistencias actualizadas.";
        }

        return redirect()->route('asistencias.index')
            ->with('success', $mensaje);
    }

    // Método para obtener estudiantes de una clase por AJAX
    public function getEstudiantesPorClase(Request $request)
    {
        $claseId = $request->get('clase_id');
        
        if (!$claseId) {
            return response()->json([]);
        }
        
        // Obtener la clase y verificar que pertenezca al profesor autenticado
        $clase = Clase::with(['curso'])
            ->whereHas('curso', function($query) {
                $query->where('profesor_id', Auth::user()->id_usuario);
            })
            ->find($claseId);
        
        if (!$clase) {
            return response()->json([]);
        }
        
        // Obtener estudiantes matriculados en el curso de esta clase
        $estudiantes = Usuario::whereHas('matriculas', function($query) use ($clase) {
            $query->where('curso_id', $clase->curso->id_curso);
        })
        ->whereHas('rol', function($query) {
            $query->where('nombre_rol', 'Estudiante');
        })
        ->select('id_usuario', 'nombre', 'apellido')
        ->orderBy('nombre')
        ->orderBy('apellido')
        ->get()
        ->map(function($estudiante) {
            return [
                'id' => $estudiante->id_usuario,
                'nombre' => $estudiante->nombre . ' ' . $estudiante->apellido
            ];
        });
        
        return response()->json($estudiantes);
    }
}