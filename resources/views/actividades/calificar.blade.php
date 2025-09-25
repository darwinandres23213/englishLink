{{-- filepath: resources/views/actividades/calificar.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', 'Calificar Entregas')
@section('content')

<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Calificar Entregas</h2>
            <p class="text-muted mb-0">
                <i class="fas fa-book me-2"></i>{{ $actividad->titulo }}
                <span class="ms-3"><i class="fas fa-graduation-cap me-2"></i>{{ $actividad->curso->nombre_curso }}</span>
            </p>
        </div>
        <div>
            <!-- a href="{{ route('actividades.show', $actividad) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Volver a Actividad
            </a -->
        </div>
    </div>

    <!-- Estadísticas Rápidas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h3 class="mb-1">{{ $entregas->count() }}</h3>
                    <small>Total Estudiantes</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h3 class="mb-1">{{ $entregas->whereNotNull('fecha_entrega')->where('calificacion_obtenida', null)->count() }}</h3>
                    <small>Entregadas</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h3 class="mb-1">{{ $entregas->whereNotNull('calificacion_obtenida')->count() }}</h3>
                    <small>Calificadas</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            @php
                $sinEntregar = $entregas->whereNull('fecha_entrega');
                $noEntregaronVencido = $sinEntregar->filter(function($entrega) use ($actividad) {
                    return $actividad->estaVencida();
                });
                $sinEntregarEnPlazo = $sinEntregar->filter(function($entrega) use ($actividad) {
                    return !$actividad->estaVencida();
                });
            @endphp
            
            @if($actividad->estaVencida() && $noEntregaronVencido->count() > 0)
                <div class="card bg-danger text-white">
                    <div class="card-body text-center">
                        <h3 class="mb-1">{{ $noEntregaronVencido->count() }}</h3>
                        <small>No Entregaron</small>
                    </div>
                </div>
            @else
                <div class="card bg-warning text-white">
                    <div class="card-body text-center">
                        <h3 class="mb-1">{{ $entregas->whereNull('fecha_entrega')->count() }}</h3>
                        <small>Sin Entregar</small>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <form id="filterForm">
                <div class="row align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Filtrar por Estado</label>
                        <select class="form-select" id="filtroEstado">
                            <option value="">Todos</option>
                            <option value="entregada">Solo Entregadas</option>
                            <option value="calificada">Solo Calificadas</option>
                            <option value="sin-calificar">Sin Calificar</option>
                            <option value="sin-entregar">Sin Entregar</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Buscar Estudiante</label>
                        <input type="text" class="form-control" id="buscarEstudiante" placeholder="Nombre o email...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Ordenar por</label>
                        <select class="form-select" id="ordenar">
                            <option value="nombre">Nombre A-Z</option>
                            <option value="fecha_entrega">Fecha de Entrega</option>
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

    <!-- Lista de Entregas -->
    <div class="row" id="entregasContainer">
        @php
        // Ordenar entregas por prioridad:
        // 1. Entregadas sin calificar (prioridad alta)
        // 2. Sin entregar/Pendientes (prioridad media)
        // 3. Ya calificadas (prioridad baja)
        $entregasOrdenadas = $entregas->sortBy(function($entrega) {
            if ($entrega->fecha_entrega && $entrega->calificacion_obtenida === null) {
                return 1; // Entregadas sin calificar - PRIORIDAD ALTA
            } elseif (!$entrega->fecha_entrega) {
                return 2; // Sin entregar - PRIORIDAD MEDIA
            } else {
                return 3; // Ya calificadas - PRIORIDAD BAJA
            }
        });
        @endphp
        
        @foreach($entregasOrdenadas as $entrega)
            <div class="col-lg-4 col-md-6 mb-3 entrega-card" 
                 data-estado="{{ $entrega->fecha_entrega ? ($entrega->calificacion_obtenida !== null ? 'calificada' : 'sin-calificar') : 'sin-entregar' }}"
                 data-nombre="{{ strtolower($entrega->estudiante->nombre . ' ' . $entrega->estudiante->apellido) }}"
                 data-email="{{ strtolower($entrega->estudiante->email) }}"
                 data-fecha="{{ $entrega->fecha_entrega ? $entrega->fecha_entrega->timestamp : 0 }}"
                 data-calificacion="{{ $entrega->calificacion_obtenida ?? -1 }}">

                <div class="card h-100 {{ 
                    $entrega->fecha_entrega 
                        ? ($entrega->calificacion_obtenida !== null ? 'border-success' : 'border-info') 
                        : ($actividad->estaVencida() ? 'border-danger' : 'border-warning')
                }}">
                    <!-- Header compacto -->
                    <div class="card-header py-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                @php
                                    $nombre = $entrega->estudiante->nombre ?? 'N';
                                    $apellido = $entrega->estudiante->apellido ?? 'A';
                                    $iniciales = strtoupper(substr($nombre, 0, 1) . substr($apellido, 0, 1));
                                    $colores = ['primary', 'success', 'info', 'warning', 'danger', 'secondary'];
                                    $colorIndex = abs(crc32($nombre . $apellido)) % count($colores);
                                    $color = $colores[$colorIndex];
                                    $fotoPerfil = $entrega->estudiante->foto ?? $entrega->estudiante->imagen ?? null;
                                @endphp
                                
                                <div class="me-2">
                                    @if($fotoPerfil && file_exists(public_path('uploads/' . $fotoPerfil)))
                                        <!-- Mostrar foto de perfil -->
                                        <img src="{{ asset('uploads/' . $fotoPerfil) }}" 
                                             alt="{{ $nombre }} {{ $apellido }}" 
                                             class="rounded-circle avatar-sm" 
                                             style="width: 32px; height: 32px; object-fit: cover; border: 2px solid #{{ $color === 'primary' ? '4e73df' : ($color === 'success' ? '1cc88a' : ($color === 'info' ? '36b9cc' : ($color === 'warning' ? 'f6c23e' : ($color === 'danger' ? 'e74a3b' : '6c757d')))) }};">
                                    @else
                                        <!-- Mostrar iniciales como respaldo -->
                                        <div class="avatar-sm bg-{{ $color }} rounded-circle d-flex align-items-center justify-content-center text-white fw-bold">
                                            {{ $iniciales }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h6 class="mb-0 text-truncate" style="max-width: 120px;">{{ $entrega->estudiante->nombre }} {{ $entrega->estudiante->apellido }}</h6>
                                    <small class="text-muted text-truncate d-block" style="max-width: 120px;">{{ $entrega->estudiante->email }}</small>
                                </div>
                            </div>
                            <div class="text-end">
                                @if($entrega->fecha_entrega)
                                    @if($entrega->calificacion_obtenida !== null)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle me-1"></i>Calificada
                                        </span>
                                    @else
                                        <span class="badge bg-info">
                                            <i class="fas fa-clock me-1"></i>Por calificar
                                        </span>
                                    @endif
                                @else
                                    @if($actividad->estaVencida())
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times-circle me-1"></i>No entregó
                                        </span>
                                    @else
                                        <span class="badge bg-warning">
                                            <i class="fas fa-hourglass-half me-1"></i>Pendiente
                                        </span>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Cuerpo compacto -->
                    <div class="card-body py-2">
                        @if($entrega->fecha_entrega)
                            <!-- Información de entrega -->
                            <div class="row mb-2">
                                <div class="col-6">
                                    <small class="text-muted">Entregó:</small>
                                    <div class="fw-bold small">{{ $entrega->fecha_entrega->format('d/m/Y') }}</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">{{ $entrega->fecha_entrega->format('H:i') }}</div>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Calificación:</small>
                                    @if($entrega->calificacion_obtenida !== null)
                                        <div class="text-center">
                                            <span class="badge bg-success fs-6">
                                                {{ $entrega->calificacion_obtenida }}/{{ $actividad->calificacion_maxima }}
                                            </span>
                                        </div>
                                    @else
                                        <div class="text-center">
                                            <span class="badge bg-secondary fs-8">
                                                Sin calificar
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Botón de acción -->
                            <div class="text-center">
                                <a href="{{ route('actividades.entregas', $entrega->actividad) }}" class="btn btn-outline-primary btn-sm w-100">
                                    <i class="fas fa-eye me-1"></i>Ver Detalles
                                </a>
                            </div>
                        @else
                            <!-- Sin entrega -->
                            <div class="text-center py-3">
                                <i class="fas fa-hourglass-half text-gray-400 fa-2x mb-2"></i>
                                <p class="text-gray-600 mb-0 small">No ha entregado</p>
                                @if($actividad->estaVencida())
                                    <small class="text-danger">Actividad vencida</small>
                                @else
                                    <small class="text-gray-600">Aún en plazo</small>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($entregas->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No hay estudiantes asignados a esta actividad</h5>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filtroEstado = document.getElementById('filtroEstado');
    const buscarEstudiante = document.getElementById('buscarEstudiante');
    const ordenar = document.getElementById('ordenar');
    const entregasContainer = document.getElementById('entregasContainer');

    function aplicarFiltros() {
        const cards = Array.from(document.querySelectorAll('.entrega-card'));
        const estadoFiltro = filtroEstado.value;
        const busqueda = buscarEstudiante.value.toLowerCase();
        const ordenarPor = ordenar.value;

        // Filtrar
        cards.forEach(card => {
            let mostrar = true;

            // Filtro por estado
            if (estadoFiltro && card.dataset.estado !== estadoFiltro) {
                mostrar = false;
            }

            // Filtro por búsqueda
            if (busqueda && !card.dataset.nombre.includes(busqueda) && !card.dataset.email.includes(busqueda)) {
                mostrar = false;
            }

            card.style.display = mostrar ? 'block' : 'none';
        });

        // Ordenar
        const cardsVisibles = cards.filter(card => card.style.display !== 'none');
        
        cardsVisibles.sort((a, b) => {
            switch (ordenarPor) {
                case 'nombre':
                    return a.dataset.nombre.localeCompare(b.dataset.nombre);
                case 'fecha_entrega':
                    return parseInt(b.dataset.fecha) - parseInt(a.dataset.fecha);
                case 'calificacion':
                    return parseFloat(b.dataset.calificacion) - parseFloat(a.dataset.calificacion);
                default:
                    return 0;
            }
        });

        // Reordenar en el DOM
        cardsVisibles.forEach(card => {
            entregasContainer.appendChild(card);
        });
    }

    function limpiarFiltros() {
        filtroEstado.value = '';
        buscarEstudiante.value = '';
        ordenar.value = 'nombre';
        aplicarFiltros();
    }

    // Event listeners
    filtroEstado.addEventListener('change', aplicarFiltros);
    buscarEstudiante.addEventListener('input', aplicarFiltros);
    ordenar.addEventListener('change', aplicarFiltros);

    // Hacer limpiarFiltros disponible globalmente
    window.limpiarFiltros = limpiarFiltros;

    // Auto-submit forms cuando cambia la calificación
    document.querySelectorAll('.calificacion-form').forEach(form => {
        const calificacionInput = form.querySelector('input[name="calificacion"]');
        
        calificacionInput.addEventListener('blur', function() {
            if (this.value !== '' && this.value !== this.defaultValue) {
                if (confirm('¿Deseas guardar esta calificación?')) {
                    form.submit();
                }
            }
        });
    });
});
</script>

<style>
.avatar-sm {
    width: 32px;
    height: 32px;
    font-size: 12px;
    font-weight: 600;
}

.avatar-md {
    width: 45px;
    height: 45px;
    font-size: 14px;
    font-weight: 600;
}

.entrega-card {
    transition: opacity 0.3s ease;
}

.card {
    transition: transform 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
}

.badge {
    font-size: 0.75em;
    padding: 0.4em 0.6em;
}

.calificacion-form input:focus,
.calificacion-form textarea:focus {
    box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
    border-color: #198754;
}

/* Cards más compactas */
.card-body {
    padding: 0.75rem;
}

.card-header {
    padding: 0.5rem 0.75rem;
    background-color: rgba(0,0,0,0.03);
}

/* Optimización para 3 columnas */
@media (min-width: 992px) {
    .col-lg-4 {
        max-width: 33.333333%;
    }
}

/* Texto truncado mejorado */
.text-truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>
@endsection
