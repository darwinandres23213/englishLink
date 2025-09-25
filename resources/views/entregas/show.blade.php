{{-- filepath: resources/views/entregas/show.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', 'Detalle de Entrega')
@section('content')

<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Detalle de Entrega</h2>
            <p class="text-muted mb-0">
                <i class="fas fa-book me-2"></i>{{ $entrega->actividad->titulo }}
                <span class="ms-3"><i class="fas fa-user me-2"></i>{{ $entrega->estudiante->nombres }} {{ $entrega->estudiante->apellidos }}</span>
            </p>
        </div>
        <div>
            @if(Auth::user()->hasRole(['admin', 'profesor']))
                <a href="{{ route('actividades.calificar', $entrega->actividad) }}" class="btn btn-outline-secondary me-2">
                    <i class="fas fa-arrow-left me-2"></i>Volver a Calificar
                </a>
                <a href="{{ route('actividades.show', $entrega->actividad) }}" class="btn btn-outline-primary">
                    <i class="fas fa-eye me-2"></i>Ver Actividad
                </a>
            @else
                <a href="{{ route('estudiante.actividades') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Mis Actividades
                </a>
            @endif
        </div>
    </div>

    <div class="row">
        <!-- Contenido Principal -->
        <div class="col-lg-8">
            <!-- Información de la Actividad -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-clipboard-list me-2"></i>Información de la Actividad
                    </h5>
                </div>
                <div class="card-body">
                    <h6 class="fw-bold">{{ $entrega->actividad->titulo }}</h6>
                    <p class="text-muted mb-3">{{ $entrega->actividad->descripcion }}</p>

                    @if($entrega->actividad->instrucciones)
                        <div class="mb-3">
                            <strong>Instrucciones:</strong>
                            <div class="mt-2 p-3 bg-light rounded">
                                {!! nl2br(e($entrega->actividad->instrucciones)) !!}
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-3">
                            <small class="text-muted d-block">Tipo de Entrega</small>
                            <span class="badge bg-info">
                                @switch($entrega->actividad->tipo_entrega)
                                    @case('archivo')
                                        <i class="fas fa-file-upload me-1"></i>Solo Archivo
                                        @break
                                    @case('texto')
                                        <i class="fas fa-edit me-1"></i>Solo Texto
                                        @break
                                    @case('ambos')
                                        <i class="fas fa-plus me-1"></i>Texto y Archivo
                                        @break
                                @endswitch
                            </span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Calificación Máxima</small>
                            <strong class="text-primary">{{ $entrega->actividad->calificacion_maxima }} puntos</strong>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Fecha Límite</small>
                            <strong class="{{ $entrega->actividad->estaVencida() ? 'text-danger' : 'text-success' }}">
                                {{ $entrega->actividad->fecha_vencimiento->format('d/m/Y H:i') }}
                            </strong>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Curso</small>
                            <strong>{{ $entrega->actividad->curso->nombre_curso }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Entrega del Estudiante -->
            @if($entrega->fecha_entrega)
                <div class="card mb-4 border-success">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-upload me-2"></i>Entrega del Estudiante
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Fecha de Entrega:</strong>
                                <div class="mt-1">{{ $entrega->fecha_entrega->format('d/m/Y H:i') }}</div>
                                @if($entrega->fecha_entrega > $entrega->actividad->fecha_vencimiento)
                                    <span class="badge bg-warning mt-1">
                                        <i class="fas fa-exclamation-triangle me-1"></i>Entrega Tardía
                                    </span>
                                    @php
                                        $tiempoTarde = $entrega->fecha_entrega->diffForHumans($entrega->actividad->fecha_vencimiento);
                                    @endphp
                                    <small class="text-muted d-block">{{ $tiempoTarde }} después del vencimiento</small>
                                @else
                                    <span class="badge bg-success mt-1">
                                        <i class="fas fa-check me-1"></i>Entrega a Tiempo
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <strong>Estado:</strong>
                                <div class="mt-1">
                                    @if($entrega->calificacion !== null)
                                        <span class="badge bg-primary fs-6">
                                            <i class="fas fa-star me-1"></i>Calificada: {{ $entrega->calificacion }}/{{ $entrega->actividad->calificacion_maxima }}
                                        </span>
                                    @else
                                        <span class="badge bg-warning fs-6">
                                            <i class="fas fa-clock me-1"></i>Pendiente de Calificación
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if($entrega->comentario_estudiante)
                            <div class="mb-3">
                                <strong>Comentario/Respuesta del Estudiante:</strong>
                                <div class="mt-2 p-3 bg-light rounded border-start border-primary border-3">
                                    <i class="fas fa-quote-left text-primary me-2"></i>
                                    {!! nl2br(e($entrega->comentario_estudiante)) !!}
                                </div>
                            </div>
                        @endif

                        @if($entrega->archivo_entrega)
                            <div class="mb-3">
                                <strong>Archivo Entregado:</strong>
                                <div class="mt-2">
                                    <div class="d-flex align-items-center p-3 bg-light rounded border">
                                        <div class="me-3">
                                            @php
                                                $extension = strtolower(pathinfo($entrega->archivo_entrega, PATHINFO_EXTENSION));
                                                $iconClass = match($extension) {
                                                    'pdf' => 'fa-file-pdf text-danger',
                                                    'doc', 'docx' => 'fa-file-word text-primary',
                                                    'txt' => 'fa-file-alt text-secondary',
                                                    'jpg', 'jpeg', 'png', 'gif' => 'fa-file-image text-success',
                                                    'zip', 'rar' => 'fa-file-archive text-warning',
                                                    default => 'fa-file text-muted'
                                                };
                                            @endphp
                                            <i class="fas {{ $iconClass }} fa-2x"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-bold">{{ basename($entrega->archivo_entrega) }}</div>
                                            @if(file_exists(storage_path('app/public/' . $entrega->archivo_entrega)))
                                                <small class="text-muted">
                                                    Tamaño: {{ number_format(filesize(storage_path('app/public/' . $entrega->archivo_entrega)) / 1024, 2) }} KB
                                                </small>
                                            @endif
                                        </div>
                                        <div>
                                            <a href="{{ Storage::url($entrega->archivo_entrega) }}" 
                                               class="btn btn-outline-primary btn-sm" target="_blank">
                                                <i class="fas fa-download me-1"></i>Descargar
                                            </a>
                                            @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                                                <button type="button" class="btn btn-outline-secondary btn-sm ms-1" 
                                                        data-bs-toggle="modal" data-bs-target="#imageModal">
                                                    <i class="fas fa-eye me-1"></i>Previsualizar
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                @if(Auth::user()->hasRole(['admin', 'profesor']))
                    <!-- Calificación del Profesor -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-star me-2"></i>Calificación y Comentarios
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('entregas.calificar', $entrega) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="calificacion" class="form-label">Calificación</label>
                                        <div class="input-group">
                                            <input type="number" name="calificacion" id="calificacion" 
                                                   class="form-control @error('calificacion') is-invalid @enderror" 
                                                   value="{{ old('calificacion', $entrega->calificacion) }}" 
                                                   min="0" max="{{ $entrega->actividad->calificacion_maxima }}" 
                                                   step="0.1" placeholder="0.0">
                                            <span class="input-group-text">/{{ $entrega->actividad->calificacion_maxima }}</span>
                                        </div>
                                        @error('calificacion')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        @if($entrega->calificacion !== null)
                                            @php
                                                $porcentaje = ($entrega->calificacion / $entrega->actividad->calificacion_maxima) * 100;
                                            @endphp
                                            <label class="form-label">Porcentaje Actual</label>
                                            <div class="mt-2">
                                                <span class="badge fs-6 
                                                    @if($porcentaje >= 70) bg-success
                                                    @elseif($porcentaje >= 60) bg-warning
                                                    @else bg-danger
                                                    @endif">
                                                    {{ number_format($porcentaje, 1) }}%
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="comentario_profesor" class="form-label">Comentarios y Retroalimentación</label>
                                    <textarea name="comentario_profesor" id="comentario_profesor" 
                                              class="form-control @error('comentario_profesor') is-invalid @enderror" 
                                              rows="4" placeholder="Escribe tus comentarios sobre la entrega del estudiante...">{{ old('comentario_profesor', $entrega->comentario_profesor) }}</textarea>
                                    @error('comentario_profesor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-2"></i>{{ $entrega->calificacion !== null ? 'Actualizar Calificación' : 'Calificar' }}
                                    </button>
                                    @if($entrega->calificacion !== null)
                                        <button type="button" class="btn btn-outline-danger" onclick="removerCalificacion()">
                                            <i class="fas fa-times me-2"></i>Remover Calificación
                                        </button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                @elseif($entrega->calificacion !== null)
                    <!-- Vista de Calificación para Estudiante -->
                    <div class="card mb-4 border-primary">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-star me-2"></i>Mi Calificación
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center mb-3">
                                <div class="col-md-6">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body">
                                            <h2 class="mb-1">{{ $entrega->calificacion }}/{{ $entrega->actividad->calificacion_maxima }}</h2>
                                            <small>Puntuación Obtenida</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    @php
                                        $porcentaje = ($entrega->calificacion / $entrega->actividad->calificacion_maxima) * 100;
                                    @endphp
                                    <div class="card 
                                        @if($porcentaje >= 70) bg-success
                                        @elseif($porcentaje >= 60) bg-warning
                                        @else bg-danger
                                        @endif text-white">
                                        <div class="card-body">
                                            <h2 class="mb-1">{{ number_format($porcentaje, 1) }}%</h2>
                                            <small>Porcentaje Obtenido</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($entrega->comentario_profesor)
                                <div class="alert alert-info">
                                    <h6 class="alert-heading">
                                        <i class="fas fa-comment me-2"></i>Comentarios del Profesor
                                    </h6>
                                    <hr>
                                    <p class="mb-0">{!! nl2br(e($entrega->comentario_profesor)) !!}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            @else
                <!-- Sin Entrega -->
                <div class="card border-warning">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-exclamation-triangle me-2"></i>Sin Entrega
                        </h5>
                    </div>
                    <div class="card-body text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">El estudiante aún no ha entregado esta actividad</h5>
                        @if($entrega->actividad->estaVencida())
                            <p class="text-danger">La actividad ha vencido sin entrega</p>
                        @else
                            <p class="text-muted">Tiempo restante hasta el vencimiento</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Panel Lateral -->
        <div class="col-lg-4">
            <!-- Información del Estudiante -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-user me-2"></i>Información del Estudiante
                    </h6>
                </div>
                <div class="card-body text-center">
                    <div class="avatar-lg bg-primary rounded-circle d-flex align-items-center justify-content-center text-white mx-auto mb-3">
                        {{ substr($entrega->estudiante->nombres, 0, 1) }}{{ substr($entrega->estudiante->apellidos, 0, 1) }}
                    </div>
                    <h6 class="mb-1">{{ $entrega->estudiante->nombres }} {{ $entrega->estudiante->apellidos }}</h6>
                    <p class="text-muted mb-2">{{ $entrega->estudiante->email }}</p>
                    @if($entrega->estudiante->telefono)
                        <p class="text-muted">{{ $entrega->estudiante->telefono }}</p>
                    @endif
                </div>
            </div>

            <!-- Resumen de la Entrega -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-line me-2"></i>Resumen
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block">Estado de Entrega</small>
                        @if($entrega->fecha_entrega)
                            <span class="badge bg-success">Entregada</span>
                        @else
                            <span class="badge bg-warning">Pendiente</span>
                        @endif
                    </div>

                    @if($entrega->fecha_entrega)
                        <div class="mb-3">
                            <small class="text-muted d-block">Puntualidad</small>
                            @if($entrega->fecha_entrega <= $entrega->actividad->fecha_vencimiento)
                                <span class="badge bg-success">A Tiempo</span>
                            @else
                                <span class="badge bg-danger">Tardía</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Estado de Calificación</small>
                            @if($entrega->calificacion !== null)
                                <span class="badge bg-primary">Calificada</span>
                            @else
                                <span class="badge bg-warning">Pendiente</span>
                            @endif
                        </div>
                    @endif

                    <div class="mb-3">
                        <small class="text-muted d-block">Fecha de Asignación</small>
                        <strong>{{ $entrega->created_at->format('d/m/Y H:i') }}</strong>
                    </div>
                </div>
            </div>

            <!-- Acciones Rápidas -->
            @if(Auth::user()->hasRole(['admin', 'profesor']))
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-tools me-2"></i>Acciones
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('actividades.calificar', $entrega->actividad) }}" class="btn btn-outline-primary">
                                <i class="fas fa-star me-2"></i>Calificar Todas
                            </a>
                            
                            <a href="{{ route('actividades.show', $entrega->actividad) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-eye me-2"></i>Ver Actividad
                            </a>
                            
                            @if($entrega->fecha_entrega && $entrega->archivo_entrega)
                                <a href="{{ Storage::url($entrega->archivo_entrega) }}" 
                                   class="btn btn-outline-success" target="_blank">
                                    <i class="fas fa-download me-2"></i>Descargar Archivo
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal para previsualizar imágenes -->
@if($entrega->archivo_entrega && in_array(strtolower(pathinfo($entrega->archivo_entrega, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif']))
    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Previsualización de Imagen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ Storage::url($entrega->archivo_entrega) }}" 
                         class="img-fluid rounded" 
                         alt="Archivo entregado">
                </div>
            </div>
        </div>
    </div>
@endif

<script>
@if(Auth::user()->hasRole(['admin', 'profesor']))
function removerCalificacion() {
    if (confirm('¿Estás seguro de que deseas remover la calificación? El estudiante será notificado.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("entregas.remover-calificacion", $entrega) }}';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodInput);
        document.body.appendChild(form);
        form.submit();
    }
}

// Calcular porcentaje en tiempo real
document.getElementById('calificacion').addEventListener('input', function() {
    const calificacion = parseFloat(this.value) || 0;
    const maxima = {{ $entrega->actividad->calificacion_maxima }};
    const porcentaje = (calificacion / maxima) * 100;
    
    console.log(`Calificación: ${calificacion}/${maxima} = ${porcentaje.toFixed(1)}%`);
});
@endif
</script>

<style>
.avatar-lg {
    width: 80px;
    height: 80px;
    font-size: 24px;
    font-weight: 600;
}

.border-start {
    border-left-width: 4px !important;
}

.card {
    transition: transform 0.2s ease;
}

.card:hover {
    transform: translateY(-1px);
}
</style>
@endsection
