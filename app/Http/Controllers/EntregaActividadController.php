<?php

namespace App\Http\Controllers;

use App\Models\EntregaActividad;
use App\Models\Actividad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class EntregaActividadController extends Controller
{
    // Vista para que el estudiante vea sus actividades
    public function misActividades()
    {
        $user = Auth::user();
        
        if (!$user->isEstudiante()) {
            abort(403, 'Solo los estudiantes pueden acceder a esta sección.');
        }

        // Filtrar actividades: activas O inactivas con entrega realizada
        $entregas = EntregaActividad::where('estudiante_id', $user->id_usuario)
            ->whereHas('actividad', function($query) use ($user) {
                $query->where(function($subQuery) use ($user) {
                    $subQuery->where('activa', 1) // Actividades activas
                             ->orWhereExists(function($existsQuery) use ($user) {
                                 $existsQuery->select('id_entrega')
                                           ->from('entregas_actividades')
                                           ->whereColumn('entregas_actividades.actividad_id', 'actividades.id_actividad')
                                           ->where('entregas_actividades.estudiante_id', $user->id_usuario)
                                           ->whereNotNull('fecha_entrega'); // Solo si ya entregó
                             });
                });
            })
            ->with(['actividad.curso', 'actividad.profesor'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Calcular estadísticas: solo actividades activas para estadísticas generales
        $todasLasEntregas = EntregaActividad::where('estudiante_id', $user->id_usuario)
            ->whereHas('actividad', function($query) {
                $query->where('activa', 1);
            })
            ->get();
        $estadisticas = [
            'total' => $todasLasEntregas->count(),
            'entregadas' => $todasLasEntregas->whereNotNull('fecha_entrega')->count(),
            'pendientes' => $todasLasEntregas->whereNull('fecha_entrega')->count(),
            'calificadas' => $todasLasEntregas->whereNotNull('calificacion_obtenida')->count(),
        ];

        // Obtener cursos en los que está matriculado el estudiante para el filtro
        $cursos = $user->cursosComoEstudiante;

        return view('estudiante.mis-actividades', compact('entregas', 'estadisticas', 'cursos'));
    }

    // Mostrar actividad específica para el estudiante
    public function show(EntregaActividad $entrega)
    {
        $user = Auth::user();
        
        // Verificar que el estudiante pueda ver esta entrega
        if ($user->isEstudiante() && $entrega->estudiante_id !== $user->id_usuario) {
            abort(403, 'No tienes permisos para ver esta entrega.');
        }

        $entrega->load(['actividad.curso', 'actividad.profesor']);
        
        // Obtener la actividad para la vista
        $actividad = $entrega->actividad;
        
        // Verificar que la actividad esté activa para estudiantes O que ya hayan entregado
        if ($user->isEstudiante() && !$actividad->activa && !$entrega->fecha_entrega) {
            return redirect()->route('estudiante.mis-actividades')
                ->with('error', 'Esta actividad no está disponible actualmente.');
        }
        
        return view('estudiante.actividad-detalle', compact('entrega', 'actividad'));
    }

    // Actualizar entrega del estudiante
    public function update(Request $request, EntregaActividad $entrega)
    {
        $user = Auth::user();
        
        // Verificar permisos
        if ($user->isEstudiante() && $entrega->estudiante_id !== $user->id_usuario) {
            abort(403, 'No tienes permisos para modificar esta entrega.');
        }

        // Verificar que la actividad esté activa para entregas (no permitir nuevas entregas en actividades inactivas)
        if ($user->isEstudiante() && !$entrega->actividad->activa) {
            return redirect()->route('estudiante.actividad.show', $entrega)
                ->with('error', 'Esta actividad está pausada y no acepta entregas actualmente.');
        }

        // Verificar que la actividad no esté vencida (opcional - puedes permitir entregas tardías)
        if ($entrega->actividad->estaVencida() && $entrega->estado === 'sin_entregar') {
            return redirect()->back()->with('warning', 'La fecha de entrega ha vencido. Tu entrega será marcada como tardía.');
        }

        $rules = [];
        $data = [];

        // Validar según el tipo de entrega
        switch ($entrega->actividad->tipo_entrega) {
            case 'texto':
                $rules['respuesta_texto'] = 'required|string';
                break;
            case 'archivo':
                $rules['archivo'] = 'required|file|mimes:pdf,doc,docx,txt,jpg,jpeg,png,zip,rar|max:10240'; // 10MB max
                break;
            case 'ambos':
                $rules['respuesta_texto'] = 'required|string';
                $rules['archivo'] = 'required|file|mimes:pdf,doc,docx,txt,jpg,jpeg,png,zip,rar|max:10240';
                break;
        }

        // Debug: Verificar qué datos llegan
        Log::info('Datos recibidos en entrega:', [
            'respuesta_texto' => $request->get('respuesta_texto'),
            'has_file' => $request->hasFile('archivo'),
            'all_data' => $request->all(),
            'files' => $request->file(),
            'tipo_entrega' => $entrega->actividad->tipo_entrega
        ]);

        try {
            $request->validate($rules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Error de validación en entrega:', [
                'errors' => $e->errors(),
                'rules' => $rules
            ]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        // Guardar respuesta de texto
        if ($request->has('respuesta_texto') && !empty($request->respuesta_texto)) {
            $data['respuesta_texto'] = $request->respuesta_texto;
        }

        // Guardar archivo
        if ($request->hasFile('archivo')) {
            Log::info('Archivo detectado para subir');
            
            // Eliminar archivo anterior si existe
            if ($entrega->archivo_entrega && Storage::exists($entrega->archivo_entrega)) {
                Storage::delete($entrega->archivo_entrega);
            }

            $archivo = $request->file('archivo');
            $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
            $rutaArchivo = $archivo->storeAs('entregas_actividades', $nombreArchivo, 'public');
            $data['archivo_entrega'] = $rutaArchivo;
            
            Log::info('Archivo guardado:', ['ruta' => $rutaArchivo]);
        } else {
            Log::info('No se detectó archivo en la request');
        }

        // Actualizar datos de entrega
        $data['fecha_entrega'] = now();
        $data['estado'] = $entrega->actividad->estaVencida() ? 'tardio' : 'entregado';

        $entrega->update($data);

        return redirect()->route('estudiante.actividad.show', $entrega)
            ->with('success', 'Tu respuesta ha sido enviada correctamente.');
    }

    // Ver entregas de estudiantes para profesores
    public function verEntregas($actividadId)
    {
        $user = Auth::user();
        
        if (!($user->isAdmin() || $user->isProfesor())) {
            abort(403, 'No tienes permisos para ver entregas.');
        }

        $actividad = Actividad::with('curso')->findOrFail($actividadId);
        
        // Solo el profesor de la actividad puede ver las entregas (admin puede ver todas)
        if ($user->isProfesor() && $actividad->profesor_id !== $user->id_usuario) {
            abort(403, 'No tienes permisos para ver las entregas de esta actividad.');
        }

        $entregas = EntregaActividad::with(['estudiante', 'actividad'])
            ->where('actividad_id', $actividadId)
            ->orderBy('fecha_entrega', 'desc')
            ->get();

        // Estadísticas
        $estadisticas = [
            'total' => $entregas->count(),
            'entregadas' => $entregas->where('fecha_entrega', '!=', null)->where('calificacion_obtenida', null)->count(),
            'pendientes' => $entregas->where('fecha_entrega', null)->count(),
            'calificadas' => $entregas->where('calificacion_obtenida', '!=', null)->count(),
            'tardias' => $entregas->filter(function($entrega) {
                return $entrega->fecha_entrega && 
                       $entrega->fecha_entrega > $entrega->actividad->fecha_vencimiento;
            })->count()
        ];

        return view('profesor.entregas.index', compact('actividad', 'entregas', 'estadisticas'));
    }

    // Calificar entrega (para profesores)
    public function calificar(Request $request, EntregaActividad $entrega)
    {
        $user = Auth::user();

        // Verificar permisos
        if (!($user->isAdmin() || $user->isProfesor())) {
            abort(403, 'No tienes permisos para calificar entregas.');
        }

        if ($user->isProfesor() && $entrega->actividad->profesor_id !== $user->id_usuario) {
            abort(403, 'No puedes calificar entregas de actividades que no son tuyas.');
        }

        $request->validate([
            'calificacion_obtenida' => 'required|numeric|min:0|max:' . $entrega->actividad->calificacion_maxima,
            'retroalimentacion_profesor' => 'nullable|string|max:1000'
        ]);

        $entrega->update([
            'calificacion_obtenida' => $request->calificacion_obtenida,
            'retroalimentacion_profesor' => $request->retroalimentacion_profesor,
            'fecha_calificacion' => now(),
            'calificado_por' => $user->id_usuario,
            'estado' => 'calificado'
        ]);

        return redirect()->back()->with('success', 'Entrega calificada correctamente.');
    }

    // Descargar archivo de entrega
    public function descargarArchivo(EntregaActividad $entrega)
    {
        $user = Auth::user();

        // Verificar permisos
        if (!($user->isAdmin() || $user->isProfesor() || $user->isEstudiante())) {
            abort(403, 'No tienes permisos para descargar archivos.');
        }

        // Estudiantes solo pueden descargar sus propios archivos
        if ($user->isEstudiante() && $entrega->estudiante_id !== $user->id_usuario) {
            abort(403, 'No puedes descargar archivos de otros estudiantes.');
        }

        // Profesores solo pueden descargar archivos de sus actividades
        if ($user->isProfesor() && $entrega->actividad->profesor_id !== $user->id_usuario) {
            abort(403, 'No puedes descargar archivos de actividades que no son tuyas.');
        }

        // Verificar que existe el archivo en la entrega
        if (!$entrega->archivo_entrega) {
            abort(404, 'Esta entrega no tiene archivo adjunto.');
        }

        try {
            $rutaArchivo = $entrega->archivo_entrega;
            $rutaCompleta = storage_path('app/public/' . $rutaArchivo);
            
            if (!file_exists($rutaCompleta)) {
                Log::error('Archivo de entrega no encontrado', [
                    'entrega_id' => $entrega->id_entrega,
                    'archivo_entrega' => $rutaArchivo,
                    'ruta_completa' => $rutaCompleta,
                    'usuario_id' => $user->id_usuario
                ]);
                
                abort(404, 'El archivo no se encuentra en el servidor.');
            }

            $nombreOriginal = basename($rutaArchivo);
            
            // Configurar headers manualmente para evitar conflictos con middleware
            $headers = [
                'Content-Type' => 'application/octet-stream',
                'Content-Disposition' => 'attachment; filename="' . $nombreOriginal . '"',
                'Content-Length' => filesize($rutaCompleta),
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ];
            
            return response()->download($rutaCompleta, $nombreOriginal, $headers);
            
        } catch (\Exception $e) {
            Log::error('Error al descargar archivo', [
                'entrega_id' => $entrega->id_entrega,
                'error' => $e->getMessage(),
                'archivo' => $entrega->archivo_entrega,
                'usuario_id' => $user->id_usuario
            ]);
            
            abort(500, 'Error interno al descargar el archivo. Contacta al administrador.');
        }
    }
}
