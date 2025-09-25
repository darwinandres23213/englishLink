{{-- filepath: resources/views/actividades/show.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', $actividad->titulo)
@section('content')

<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">{{ $actividad->titulo }}</h2>
            <p class="text-muted mb-0">
                <i class="fas fa-book me-2"></i>{{ $actividad->curso->nombre_curso }}
                <span class="ms-3"><i class="fas fa-clock me-2"></i>Vence: {{ \Carbon\Carbon::parse($actividad->fecha_vencimiento)->format('d/m/Y H:i') }}</span>
            </p>
        </div>
        <div>
            @if(Auth::user()->hasRole(['admin', 'profesor']))
                <a href="{{ route('actividades.edit', $actividad) }}" class="btn btn-outline-primary">
                    <i class="fas fa-edit me-2"></i>Editar
                </a>
                <a href="{{ route('actividades.entregas', $actividad) }}" class="btn btn-info">
                    <i class="fas fa-file-alt me-2"></i>Ver Entregas 
                    ({{ $actividad->entregas->whereNotNull('fecha_entrega')->count() }}/{{ $actividad->entregas->count() }})
                </a>
                <a href="{{ route('actividades.calificar', $actividad) }}" class="btn btn-success">
                    <i class="fas fa-star me-2"></i>Calificar ({{ $actividad->entregas->whereNotNull('calificacion_obtenida')->count() }}/{{ $actividad->entregas->count() }})
                </a>
            @endif
        </div>
    </div>

    <div class="row">
        <!-- Información de la Actividad -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Detalles de la Actividad
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Descripción:</strong>
                        <p class="mt-2">{{ $actividad->descripcion }}</p>
                    </div>

                    @if($actividad->instrucciones)
                        <div class="mb-3">
                            <strong>Instrucciones:</strong>
                            <div class="mt-2 p-3 bg-light rounded">
                                {!! nl2br(e($actividad->instrucciones)) !!}
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <strong>Tipo de Entrega:</strong>
                            <span class="badge bg-info ms-2">
                                @switch($actividad->tipo_entrega)
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
                        <div class="col-md-6">
                            <strong>Calificación Máxima:</strong>
                            <span class="text-primary fw-bold">{{ $actividad->calificacion_maxima }} puntos</span>
                        </div>
                    </div>
                </div>
            </div>

            @if(Auth::user()->hasRole(['admin', 'profesor']))
                <!-- Estadísticas de Entregas -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-bar me-2"></i>Estadísticas de Entregas
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="p-3 bg-primary text-white rounded">
                                    <h3 class="mb-1">{{ $actividad->entregas->count() }}</h3>
                                    <small>Total Estudiantes</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="p-3 bg-success text-white rounded">
                                    <h3 class="mb-1">{{ $actividad->entregas->whereNotNull('fecha_entrega')->count() }}</h3>
                                    <small>Entregadas</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="p-3 bg-warning text-white rounded">
                                    <h3 class="mb-1">{{ $actividad->entregas->whereNull('fecha_entrega')->count() }}</h3>
                                    <small>Pendientes</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="p-3 bg-info text-white rounded">
                                    <h3 class="mb-1">{{ $actividad->entregas->whereNotNull('calificacion')->count() }}</h3>
                                    <small>Calificadas</small>
                                </div>
                            </div>
                        </div>

                        <!-- Lista de Entregas -->
                        <div class="mt-4">
                            <h6>Estado de Entregas por Estudiante:</h6>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Estudiante</th>
                                            <th>Estado</th>
                                            <th>Fecha Entrega</th>
                                            <th>Calificación</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($actividad->entregas as $entrega)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center text-white me-2">
                                                            {{ substr($entrega->estudiante->nombres, 0, 1) }}{{ substr($entrega->estudiante->apellidos, 0, 1) }}
                                                        </div>
                                                        <div>
                                                            <div class="fw-bold">{{ $entrega->estudiante->nombres }} {{ $entrega->estudiante->apellidos }}</div>
                                                            <small class="text-muted">{{ $entrega->estudiante->email }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($entrega->fecha_entrega)
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check-circle me-1"></i>Entregada
                                                        </span>
                                                        @if($actividad->estaVencida() && $entrega->fecha_entrega > $actividad->fecha_vencimiento)
                                                            <span class="badge bg-warning ms-1">Tardía</span>
                                                        @endif
                                                    @else
                                                        <span class="badge bg-warning">
                                                            <i class="fas fa-clock me-1"></i>Pendiente
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $entrega->fecha_entrega ? $entrega->fecha_entrega->format('d/m/Y H:i') : '-' }}
                                                </td>
                                                <td>
                                                    @if($entrega->calificacion !== null)
                                                        <span class="badge bg-primary">{{ $entrega->calificacion }}/{{ $actividad->calificacion_maxima }}</span>
                                                    @else
                                                        <span class="text-muted">Sin calificar</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($entrega->fecha_entrega)
                                                        <a href="{{ route('actividades.entregas', $actividad) }}#entrega-{{ $entrega->id_entrega }}" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-eye me-1"></i>Ver
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Panel Lateral -->
        <div class="col-lg-4">
            <!-- Estado de la Actividad -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-flag me-2"></i>Estado de la Actividad
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        @if($actividad->estaVencida())
                            <div class="badge bg-danger fs-6 p-2 mb-3">
                                <i class="fas fa-exclamation-triangle me-2"></i>VENCIDA
                            </div>
                        @else
                            <div class="badge bg-success fs-6 p-2 mb-3">
                                <i class="fas fa-clock me-2"></i>ACTIVA
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">Creada por:</small>
                        <strong>{{ $actividad->profesor->nombres }} {{ $actividad->profesor->apellidos }}</strong>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">Fecha de creación:</small>
                        <strong>{{ $actividad->created_at->format('d/m/Y H:i') }}</strong>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">Última actualización:</small>
                        <strong>{{ $actividad->updated_at->format('d/m/Y H:i') }}</strong>
                    </div>

                    @if(!$actividad->estaVencida())
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Tiempo restante:</strong><br>
                            <span id="countdown-timer" data-target="{{ $actividad->fecha_vencimiento->toISOString() }}"></span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-tools me-2"></i>Acciones Rápidas
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('actividades.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Volver a Lista
                        </a>
                        
                        @if(Auth::user()->hasRole(['admin', 'profesor']))
                            <a href="{{ route('actividades.edit', $actividad) }}" class="btn btn-outline-primary">
                                <i class="fas fa-edit me-2"></i>Editar Actividad
                            </a>
                            
                            <a href="{{ route('actividades.calificar', $actividad) }}" class="btn btn-success">
                                <i class="fas fa-star me-2"></i>Calificar Entregas
                            </a>
                            
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash me-2"></i>Eliminar
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(Auth::user()->hasRole(['admin', 'profesor']))
    <!-- Modal de Confirmación de Eliminación -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar esta actividad?</p>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Advertencia:</strong> Esta acción eliminará también todas las entregas de los estudiantes y no se puede deshacer.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form method="POST" action="{{ route('actividades.destroy', $actividad) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Countdown timer
    const timerElement = document.getElementById('countdown-timer');
    if (timerElement) {
        const targetDate = new Date(timerElement.dataset.target);
        
        function updateCountdown() {
            const now = new Date();
            const difference = targetDate - now;
            
            if (difference > 0) {
                const days = Math.floor(difference / (1000 * 60 * 60 * 24));
                const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
                
                timerElement.innerHTML = `${days}d ${hours}h ${minutes}m`;
            } else {
                timerElement.innerHTML = 'Vencida';
                timerElement.parentElement.className = 'alert alert-danger';
            }
        }
        
        updateCountdown();
        setInterval(updateCountdown, 60000); // Actualizar cada minuto
    }
});
</script>

<style>
.avatar-sm {
    width: 40px;
    height: 40px;
    font-size: 14px;
    font-weight: 600;
}
</style>
@endsection
