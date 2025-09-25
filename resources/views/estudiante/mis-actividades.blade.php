{{-- filepath: resources/views/estudiante/mis-actividades.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', 'Mis Actividades')
@section('content')

<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Mis Actividades</h2>
            <p class="text-muted mb-0">
                <i class="fas fa-user me-2"></i>{{ Auth::user()->nombre }} {{ Auth::user()->apellido }}
            </p>
        </div>
    </div>

    <!-- Estadísticas Personales -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h3 class="mb-1">{{ $estadisticas['total'] }}</h3>
                    <small>Total Actividades</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h3 class="mb-1">{{ $estadisticas['entregadas'] }}</h3>
                    <small>Entregadas</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <h3 class="mb-1">{{ $estadisticas['pendientes'] }}</h3>
                    <small>Pendientes</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h3 class="mb-1">{{ $estadisticas['calificadas'] }}</h3>
                    <small>Calificadas</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <form>
                <div class="row align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Filtrar por Curso</label>
                        <select class="form-select" id="filtroCurso">
                            <option value="">Todos los cursos</option>
                            @foreach($cursos as $curso)
                                <option value="{{ $curso->id_curso }}">{{ $curso->nombre_curso }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Estado</label>
                        <select class="form-select" id="filtroEstado">
                            <option value="">Todos</option>
                            <option value="pendiente">Pendientes</option>
                            <option value="entregada">Entregadas</option>
                            <option value="calificada">Calificadas</option>
                            <option value="vencida">Vencidas</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Ordenar por</label>
                        <select class="form-select" id="ordenar">
                            <option value="fecha_vencimiento">Fecha de Vencimiento</option>
                            <option value="fecha_creacion">Fecha de Creación</option>
                            <option value="curso">Curso</option>
                            <option value="calificacion">Calificación</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-outline-secondary w-100" onclick="limpiarFiltros()">
                            <i class="fas fa-undo me-2"></i>Limpiar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de Actividades -->
    <div class="row" id="actividadesContainer">
        @forelse($entregas as $entrega)
            @php
                $actividad = $entrega->actividad;
                $estado = 'pendiente';
                if ($entrega->fecha_entrega) {
                    $estado = $entrega->calificacion !== null ? 'calificada' : 'entregada';
                } elseif ($actividad->estaVencida()) {
                    $estado = 'vencida';
                }
            @endphp
            
            <div class="col-lg-6 mb-4 actividad-card" 
                 data-curso="{{ $actividad->curso_id }}"
                 data-estado="{{ $estado }}"
                 data-fecha-vencimiento="{{ $actividad->fecha_vencimiento->timestamp }}"
                 data-fecha-creacion="{{ $actividad->created_at->timestamp }}"
                 data-curso-nombre="{{ strtolower($actividad->curso->nombre_curso) }}"
                 data-calificacion="{{ $entrega->calificacion ?? -1 }}">
                
                <div class="card h-100 
                    @if($estado === 'vencida') border-danger
                    @elseif($estado === 'calificada') border-success
                    @elseif($estado === 'entregada') border-info
                    @else border-warning
                    @endif">
                    
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 font-weight-bold text-muted">{{ $actividad->titulo }}</h5>
                            <small class="text-muted">
                                <!-- i class="fas fa-book me-1"></i -->Curso: {{ $actividad->curso->nombre_curso }}
                            </small>
                        </div>
                        <div class="text-end">
                            @switch($estado)
                                @case('calificada')
                                    <span class="badge bg-success">
                                        <i class="fas fa-star me-1"></i>Calificada
                                    </span>
                                    @break
                                @case('entregada')
                                    <span class="badge bg-info">
                                        <i class="fas fa-check me-1"></i>Entregada
                                    </span>
                                    @break
                                @case('vencida')
                                    <span class="badge bg-danger">
                                        <i class="fas fa-exclamation-triangle me-1"></i>Vencida
                                    </span>
                                    @break
                                @default
                                    <span class="badge bg-warning">
                                        <i class="fas fa-clock me-1"></i>Pendiente
                                    </span>
                            @endswitch
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Alerta si la actividad está inactiva pero visible por entrega existente -->
                        @if(!$actividad->activa && $entrega->fecha_entrega)
                            <div class="alert alert-warning">
                                <i class="fas fa-pause-circle me-2"></i>
                                <strong>Actividad pausada:</strong> Esta actividad está actualmente pausada por el profesor. 
                                Puedes ver tus entregas e instrucciones, pero no realizar nuevas entregas.
                            </div>
                        @endif

                        <p class="card-text">{{ Str::limit($actividad->descripcion, 100) }}</p>

                        <!-- Información de fechas -->
                        <div class="row text-center mb-3">
                            <div class="col-6">
                                <small class="text-muted d-block">Vence</small>
                                <strong class="{{ $actividad->estaVencida() ? 'text-danger' : 'text-primary' }}">
                                    {{ $actividad->fecha_vencimiento->format('d/m/Y H:i') }}
                                </strong>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Calificación Máxima</small>
                                <strong class="text-info">{{ $actividad->calificacion_maxima }} pts</strong>
                            </div>
                        </div>

                        <!-- Estado de la entrega -->
                        @if($entrega->fecha_entrega)
                            <div class="bg-light p-3 rounded mb-3">
                                <div class="row">
                                    <div class="col-6">
                                        <small class="text-muted d-block">Entregado</small>
                                        <strong>
                                            @php
                                                try {
                                                    $fechaEntrega = $entrega->fecha_entrega instanceof \Carbon\Carbon 
                                                        ? $entrega->fecha_entrega 
                                                        : \Carbon\Carbon::parse($entrega->fecha_entrega);
                                                    echo $fechaEntrega->format('d/m/Y H:i');
                                                } catch (\Exception $e) {
                                                    echo $entrega->fecha_entrega ?? 'No disponible';
                                                }
                                            @endphp
                                        </strong>
                                        @php
                                            try {
                                                $fechaEntrega = $entrega->fecha_entrega instanceof \Carbon\Carbon 
                                                    ? $entrega->fecha_entrega 
                                                    : \Carbon\Carbon::parse($entrega->fecha_entrega);
                                                $esTardia = $fechaEntrega > $actividad->fecha_vencimiento;
                                            } catch (\Exception $e) {
                                                $esTardia = false;
                                            }
                                        @endphp
                                        @if($esTardia)
                                            <span class="badge bg-warning ms-1">Tardía</span>
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Calificación</small>
                                        @if($entrega->calificacion !== null)
                                            <strong class="text-success">
                                                {{ $entrega->calificacion }}/{{ $actividad->calificacion_maxima }}
                                            </strong>
                                            @php
                                                $porcentaje = ($entrega->calificacion / $actividad->calificacion_maxima) * 100;
                                            @endphp
                                            <div class="progress mt-1" style="height: 5px;">
                                                <div class="progress-bar 
                                                    @if($porcentaje >= 70) bg-success
                                                    @elseif($porcentaje >= 60) bg-warning
                                                    @else bg-danger
                                                    @endif" 
                                                    style="width: {{ $porcentaje }}%"></div>
                                            </div>
                                        @else
                                            <span class="text-muted">Pendiente</span>
                                        @endif
                                    </div>
                                </div>

                                @if($entrega->comentario_profesor)
                                    <div class="mt-2">
                                        <small class="text-muted d-block">Comentario del profesor:</small>
                                        <div class="text-primary">{{ $entrega->comentario_profesor }}</div>
                                    </div>
                                @endif
                            </div>
                        @else
                            <!-- Tiempo restante -->
                            @if(!$actividad->estaVencida())
                                <div class="alert alert-info">
                                    <i class="fas fa-clock me-2"></i>
                                    <strong>Tiempo restante:</strong>
                                    <span class="countdown-timer" data-target="{{ $actividad->fecha_vencimiento->toISOString() }}"></span>
                                </div>
                            @else
                                <div class="alert alert-danger">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Esta actividad ha vencido</strong>
                                </div>
                            @endif
                        @endif

                        <!-- Tipo de entrega -->
                        <div class="mb-3">
                            <small class="text-muted">Tipo de entrega requerida:</small>
                            <div class="mt-1">
                                @switch($actividad->tipo_entrega)
                                    @case('archivo')
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-file-upload me-1"></i>Solo Archivo
                                        </span>
                                        @break
                                    @case('texto')
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-edit me-1"></i>Solo Texto
                                        </span>
                                        @break
                                    @case('ambos')
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-plus me-1"></i>Texto y Archivo
                                        </span>
                                        @break
                                @endswitch
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-flex gap-2">
                            <a href="{{ route('estudiante.actividad.show', $entrega) }}" class="btn btn-primary btn-sm flex-fill">
                                <i class="fas fa-eye me-1"></i>Ver Detalle
                            </a>
                            
                            @if(!$entrega->fecha_entrega && !$actividad->estaVencida() && $actividad->activa)
                                <a href="{{ route('estudiante.actividad.show', $entrega) }}#entrega" class="btn btn-success btn-sm">
                                    <i class="fas fa-upload me-1"></i>Entregar
                                </a>
                            @elseif(!$entrega->fecha_entrega && !$actividad->activa)
                                <span class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-pause me-1"></i>Pausada
                                </span>
                            @elseif($entrega->fecha_entrega && !$entrega->calificacion)
                                <span class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-hourglass-half me-1"></i>Esperando calificación
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No tienes actividades asignadas</h5>
                    <p class="text-muted">Las actividades aparecerán aquí cuando tu profesor las cree.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filtroCurso = document.getElementById('filtroCurso');
    const filtroEstado = document.getElementById('filtroEstado');
    const ordenar = document.getElementById('ordenar');
    const actividadesContainer = document.getElementById('actividadesContainer');

    function aplicarFiltros() {
        const cards = Array.from(document.querySelectorAll('.actividad-card'));
        const cursoFiltro = filtroCurso.value;
        const estadoFiltro = filtroEstado.value;
        const ordenarPor = ordenar.value;

        // Filtrar
        cards.forEach(card => {
            let mostrar = true;

            // Filtro por curso
            if (cursoFiltro && card.dataset.curso !== cursoFiltro) {
                mostrar = false;
            }

            // Filtro por estado
            if (estadoFiltro && card.dataset.estado !== estadoFiltro) {
                mostrar = false;
            }

            card.style.display = mostrar ? 'block' : 'none';
        });

        // Ordenar
        const cardsVisibles = cards.filter(card => card.style.display !== 'none');
        
        cardsVisibles.sort((a, b) => {
            switch (ordenarPor) {
                case 'fecha_vencimiento':
                    return parseInt(a.dataset.fechaVencimiento) - parseInt(b.dataset.fechaVencimiento);
                case 'fecha_creacion':
                    return parseInt(b.dataset.fechaCreacion) - parseInt(a.dataset.fechaCreacion);
                case 'curso':
                    return a.dataset.cursoNombre.localeCompare(b.dataset.cursoNombre);
                case 'calificacion':
                    return parseFloat(b.dataset.calificacion) - parseFloat(a.dataset.calificacion);
                default:
                    return 0;
            }
        });

        // Reordenar en el DOM
        cardsVisibles.forEach(card => {
            actividadesContainer.appendChild(card);
        });
    }

    function limpiarFiltros() {
        filtroCurso.value = '';
        filtroEstado.value = '';
        ordenar.value = 'fecha_vencimiento';
        aplicarFiltros();
    }

    // Event listeners
    filtroCurso.addEventListener('change', aplicarFiltros);
    filtroEstado.addEventListener('change', aplicarFiltros);
    ordenar.addEventListener('change', aplicarFiltros);

    // Hacer limpiarFiltros disponible globalmente
    window.limpiarFiltros = limpiarFiltros;

    // Countdown timers
    function updateCountdowns() {
        document.querySelectorAll('.countdown-timer').forEach(timer => {
            const targetDate = new Date(timer.dataset.target);
            const now = new Date();
            const difference = targetDate - now;
            
            if (difference > 0) {
                const days = Math.floor(difference / (1000 * 60 * 60 * 24));
                const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
                
                if (days > 0) {
                    timer.innerHTML = `${days}d ${hours}h ${minutes}m`;
                } else if (hours > 0) {
                    timer.innerHTML = `${hours}h ${minutes}m`;
                } else {
                    timer.innerHTML = `${minutes}m`;
                }
            } else {
                timer.innerHTML = 'Vencida';
                timer.parentElement.className = 'alert alert-danger';
            }
        });
    }
    
    updateCountdowns();
    setInterval(updateCountdowns, 60000); // Actualizar cada minuto
});
</script>

<style>
.actividad-card {
    transition: opacity 0.3s ease;
}

.card {
    transition: transform 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
}

.progress {
    border-radius: 10px;
}

.countdown-timer {
    font-weight: bold;
    font-family: monospace;
}

.badge {
    font-size: 0.8em;
}
</style>
@endsection
