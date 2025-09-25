@extends('layouts.AreaInterna.app')
@section('title', 'Entregas de ' . $actividad->titulo)

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-1">Entregas de Actividad</h1>
            <h5 class="text-muted mb-0">
                <!-- i class="fas fa-book me-2"></i -->Curso: <strong>{{ $actividad->curso->nombre_curso }}</strong>
            </h5>
        </div>
        <div>
            <!-- a href="{{ route('actividades.show', $actividad) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Volver a Actividad
            </a -->
        </div>
    </div>

    <!-- Información de la Actividad -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h2><strong> {{ $actividad->titulo }} </strong></h2>
                    <!-- h5 class="text-muted"> {{ $actividad->titulo }} </h5 -->
                    <!-- h5 class="text-muted">{{ $actividad->descripcion }}</h5 -->
                    <div class="text-muted d-flex gap-5">
                        <small><strong>Fecha de vencimiento:</strong> {{ $actividad->fecha_vencimiento->format('d/m/Y H:i') }}</small>
                        <small><strong>Calificación máxima:</strong> {{ $actividad->calificacion_maxima }} pts</small>
                        <small><strong>Tipo:</strong> 
                            @switch($actividad->tipo_entrega)
                                @case('texto') Solo Texto @break
                                @case('archivo') Solo Archivo @break
                                @case('ambos') Texto y Archivo @break
                            @endswitch
                        </small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-end">
                        @if($actividad->estaVencida())
                            <span class="badge bg-danger fs-6">VENCIDA</span>
                        @else
                            <span class="badge bg-success fs-6">ACTIVA</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="row mb-3">
        <div class="col-md-2">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h3 class="mb-0">{{ $estadisticas['total'] }}</h3>
                    <small>Total</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h3 class="mb-0">{{ $estadisticas['entregadas'] }}</h3>
                    <small>Entregadas</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <h3 class="mb-0">{{ $estadisticas['pendientes'] }}</h3>
                    <small>Pendientes</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h3 class="mb-0">{{ $estadisticas['calificadas'] }}</h3>
                    <small>Calificadas</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <h3 class="mb-0">{{ $estadisticas['tardias'] }}</h3>
                    <small>Tardías</small>
                </div>
            </div>
        </div>
        <!-- div class="col-md-2">
            <div class="card bg-secondary text-white">
                <div class="card-body text-center">
                    @php
                        $promedio = $estadisticas['calificadas'] > 0 
                            ? $entregas->whereNotNull('calificacion_obtenida')->avg('calificacion_obtenida')
                            : 0;
                    @endphp
                    <h3 class="mb-0">{{ number_format($promedio, 1) }}</h3>
                    <small>Promedio</small>
                </div>
            </div>
        </div -->
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Filtrar por Estado</label>
                    <select class="form-select" id="filtroEstado">
                        <option value="">Todas las entregas</option>
                        <option value="entregada">Entregadas</option>
                        <option value="pendiente">Pendientes</option>
                        <option value="calificada">Calificadas</option>
                        <option value="tardia">Tardías</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Ordenar por</label>
                    <select class="form-select" id="ordenar">
                        <option value="fecha_entrega">Fecha de Entrega</option>
                        <option value="estudiante">Nombre del Estudiante</option>
                        <option value="calificacion">Calificación</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Buscar Estudiante</label>
                    <input type="text" class="form-control" id="buscarEstudiante" placeholder="Nombre del estudiante...">
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-outline-secondary w-100" onclick="limpiarFiltros()">
                        <i class="fas fa-undo me-2"></i>Limpiar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Entregas -->
    <div class="row" id="entregasContainer">
        @forelse($entregas as $entrega)
            @php
                $estado = 'pendiente';
                $esTardia = false;
                if ($entrega->fecha_entrega) {
                    $estado = $entrega->calificacion_obtenida !== null ? 'calificada' : 'entregada';
                    try {
                        $fechaEntrega = $entrega->fecha_entrega instanceof \Carbon\Carbon 
                            ? $entrega->fecha_entrega 
                            : \Carbon\Carbon::parse($entrega->fecha_entrega);
                        $esTardia = $fechaEntrega > $actividad->fecha_vencimiento;
                        if ($esTardia) $estado = 'tardia';
                    } catch (\Exception $e) {
                        $esTardia = false;
                    }
                }
            @endphp
            
            <div class="col-lg-4 col-md-6 mb-4 entrega-card" 
                 id="entrega-{{ $entrega->id_entrega }}"
                 data-estado="{{ $estado }}"
                 data-estudiante="{{ strtolower($entrega->estudiante->nombre . ' ' . $entrega->estudiante->apellido) }}"
                 data-fecha-entrega="{{ $entrega->fecha_entrega ? $entrega->fecha_entrega : '0000-00-00' }}"
                 data-calificacion="{{ $entrega->calificacion_obtenida ?? -1 }}">
                
                <div class="card h-100 
                    @if($estado === 'tardia') border-danger
                    @elseif($estado === 'calificada') border-success
                    @elseif($estado === 'entregada') border-info
                    @else border-warning
                    @endif">
                    
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">{{ $entrega->estudiante->nombre }} {{ $entrega->estudiante->apellido }}</h6>
                            <small class="text-muted">{{ $entrega->estudiante->email }}</small>
                        </div>
                        <div class="text-end">
                            @switch($estado)
                                @case('calificada')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>Calificada
                                    </span>
                                    @break
                                @case('tardia')
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times-circle me-1"></i>Tardía
                                    </span>
                                    @break
                                @case('entregada')
                                    <span class="badge bg-info">
                                        <i class="fas fa-clock me-1"></i>Entregada
                                    </span>
                                    @break
                                @default
                                    <span class="badge bg-warning">
                                        <i class="fas fa-hourglass me-1"></i>Pendiente
                                    </span>
                            @endswitch
                        </div>
                    </div>

                    <div class="card-body">
                        @if($entrega->fecha_entrega)
                            <!-- Información de la entrega -->
                            <div class="mb-3">
                                <small class="text-muted d-block">Fecha de entrega:</small>
                                <strong>
                                    @php
                                        try {
                                            $fechaEntrega = $entrega->fecha_entrega instanceof \Carbon\Carbon 
                                                ? $entrega->fecha_entrega 
                                                : \Carbon\Carbon::parse($entrega->fecha_entrega);
                                            echo $fechaEntrega->format('d/m/Y H:i');
                                        } catch (\Exception $e) {
                                            echo 'Fecha no disponible';
                                        }
                                    @endphp
                                </strong>
                                @if($esTardia)
                                    <span class="badge bg-warning ms-2">Tardía</span>
                                @endif
                            </div>

                            <!-- Respuesta de texto -->
                            @if($entrega->respuesta_texto)
                                <div class="mb-3">
                                    <small class="text-muted d-block">Respuesta del estudiante:</small>
                                    <div class="bg-light p-2 rounded">
                                        {{ Str::limit($entrega->respuesta_texto, 150) }}
                                        @if(strlen($entrega->respuesta_texto) > 150)
                                            <button class="btn btn-link btn-sm p-0" onclick="toggleTextoCompleto(this)">Ver más</button>
                                            <div class="texto-completo d-none">{{ $entrega->respuesta_texto }}</div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Archivo adjunto -->
                            @if($entrega->archivo_entrega)
                                <div class="mb-3">
                                    <small class="text-muted d-block">Archivo adjunto:</small>
                                    @php
                                        $nombreArchivo = basename($entrega->archivo_entrega);
                                        $extension = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));
                                        $tipoIcon = match($extension) {
                                            'pdf' => 'fas fa-file-pdf text-danger',
                                            'doc', 'docx' => 'fas fa-file-word text-primary',
                                            'xls', 'xlsx' => 'fas fa-file-excel text-success',
                                            'ppt', 'pptx' => 'fas fa-file-powerpoint text-warning',
                                            'jpg', 'jpeg', 'png', 'gif' => 'fas fa-file-image text-info',
                                            'txt' => 'fas fa-file-alt text-secondary',
                                            'zip', 'rar' => 'fas fa-file-archive text-dark',
                                            default => 'fas fa-file text-muted'
                                        };
                                        $puedeVisualizarse = in_array($extension, ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'txt']);
                                    @endphp
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('entrega.descargar', $entrega) }}" class="btn btn-outline-primary btn-sm" title="Descargar archivo">
                                            <i class="fas fa-download me-1"></i>Descargar
                                        </a>
                                        @if($puedeVisualizarse)
                                            <a href="{{ asset('storage/' . $entrega->archivo_entrega) }}" target="_blank" class="btn btn-outline-info btn-sm" title="Ver archivo">
                                                <i class="fas fa-eye me-1"></i>Ver
                                            </a>
                                        @endif
                                    </div>
                                    <div class="mt-1">
                                        <small class="text-muted">
                                            <i class="{{ $tipoIcon }} me-1"></i>
                                            {{ $nombreArchivo }}
                                            @php
                                                $rutaCompleta = storage_path('app/public/' . $entrega->archivo_entrega);
                                                if (file_exists($rutaCompleta)) {
                                                    $tamano = filesize($rutaCompleta);
                                                    $unidades = ['B', 'KB', 'MB', 'GB'];
                                                    $indice = 0;
                                                    while ($tamano > 1024 && $indice < count($unidades) - 1) {
                                                        $tamano /= 1024;
                                                        $indice++;
                                                    }
                                                    echo ' (' . number_format($tamano, 1) . ' ' . $unidades[$indice] . ')';
                                                }
                                            @endphp
                                        </small>
                                    </div>
                                </div>
                            @endif

                            <!-- Calificación -->
                            @if($entrega->calificacion_obtenida !== null)
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">Calificación:</small>
                                        <strong class="text-success fs-5">
                                            {{ $entrega->calificacion_obtenida }}/{{ $actividad->calificacion_maxima }}
                                        </strong>
                                    </div>
                                    @php
                                        $porcentaje = ($entrega->calificacion_obtenida / $actividad->calificacion_maxima) * 100;
                                    @endphp
                                    <div class="progress mt-1" style="height: 8px;">
                                        <div class="progress-bar 
                                            @if($porcentaje >= 70) bg-success
                                            @elseif($porcentaje >= 60) bg-warning
                                            @else bg-danger
                                            @endif" 
                                            style="width: {{ $porcentaje }}%"></div>
                                    </div>
                                </div>

                                @if($entrega->retroalimentacion_profesor)
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Tu retroalimentación:</small>
                                        <div class="alert alert-info">{{ $entrega->retroalimentacion_profesor }}</div>
                                    </div>
                                @endif
                            @endif

                            <!-- Botón de calificación -->
                            <div class="d-flex gap-2">
                                @if($entrega->calificacion_obtenida === null)
                                    <button class="btn btn-outline-primary btn-sm flex-fill" onclick="abrirModalCalificar({{ $entrega->id_entrega }}, {{ $actividad->calificacion_maxima }}, {{ $entrega->calificacion_obtenida ?? 0 }}, '{{ addslashes($entrega->retroalimentacion_profesor ?? '') }}')">
                                        <i class="fas fa-star me-1"></i>Calificar
                                    </button>
                                @else
                                    <button class="btn btn-outline-primary btn-sm flex-fill" onclick="abrirModalCalificar({{ $entrega->id_entrega }}, {{ $actividad->calificacion_maxima }}, {{ $entrega->calificacion_obtenida ?? 0 }}, '{{ addslashes($entrega->retroalimentacion_profesor ?? '') }}')">
                                        <i class="fas fa-edit me-1"></i>Editar Calificación
                                    </button>
                                @endif
                            </div>
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 py-4">
                                <div class="text-center">
                                    <i class="fas fa-hourglass-half fa-2x text-gray-400 mb-2"></i>
                                    <p class="text-gray-600 mb-0">El estudiante aún no ha <br> entregado la actividad</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No hay entregas registradas</h5>
                    <p class="text-muted">Las entregas aparecerán aquí cuando los estudiantes entreguen la actividad.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>

<!-- Modal de Calificación -->
<div class="modal fade" id="modalCalificar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formCalificar" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Calificar Entrega</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="calificacion_obtenida" class="form-label">Calificación</label>
                        <input type="number" class="form-control" id="calificacion_obtenida" name="calificacion_obtenida" 
                               step="0.1" min="0" required>
                        <div class="form-text">Calificación máxima: <span id="calificacionMaxima"></span> puntos</div>
                    </div>
                    <div class="mb-3">
                        <label for="retroalimentacion_profesor" class="form-label">Retroalimentación (opcional)</label>
                        <textarea class="form-control" id="retroalimentacion_profesor" name="retroalimentacion_profesor" 
                                  rows="4" placeholder="Escribe comentarios sobre la entrega..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Calificar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function abrirModalCalificar(entregaId, calificacionMaxima, calificacionActual = 0, retroalimentacionActual = '') {
    const form = document.getElementById('formCalificar');
    form.action = `/entregas/${entregaId}/calificar`;
    
    // Configurar calificación máxima
    document.getElementById('calificacionMaxima').textContent = calificacionMaxima;
    document.getElementById('calificacion_obtenida').max = calificacionMaxima;
    
    // Cargar datos existentes
    document.getElementById('calificacion_obtenida').value = calificacionActual;
    document.getElementById('retroalimentacion_profesor').value = retroalimentacionActual;
    
    // Cambiar texto del botón según si ya está calificado o no
    const submitBtn = form.querySelector('button[type="submit"]');
    submitBtn.textContent = calificacionActual > 0 ? 'Actualizar Calificación' : 'Calificar';
    
    const modal = new bootstrap.Modal(document.getElementById('modalCalificar'));
    modal.show();
}

function toggleTextoCompleto(btn) {
    const textoCompleto = btn.nextElementSibling;
    const textoParcial = btn.parentElement.firstChild;
    
    if (textoCompleto.classList.contains('d-none')) {
        textoCompleto.classList.remove('d-none');
        textoParcial.style.display = 'none';
        btn.textContent = 'Ver menos';
    } else {
        textoCompleto.classList.add('d-none');
        textoParcial.style.display = 'inline';
        btn.textContent = 'Ver más';
    }
}

// Filtros
document.addEventListener('DOMContentLoaded', function() {
    const filtroEstado = document.getElementById('filtroEstado');
    const ordenar = document.getElementById('ordenar');
    const buscarEstudiante = document.getElementById('buscarEstudiante');
    const entregasContainer = document.getElementById('entregasContainer');

    function aplicarFiltros() {
        const cards = Array.from(document.querySelectorAll('.entrega-card'));
        const estadoFiltro = filtroEstado.value;
        const ordenarPor = ordenar.value;
        const busqueda = buscarEstudiante.value.toLowerCase();

        // Filtrar
        cards.forEach(card => {
            let mostrar = true;

            // Filtro por estado
            if (estadoFiltro && card.dataset.estado !== estadoFiltro) {
                mostrar = false;
            }

            // Filtro por búsqueda
            if (busqueda && !card.dataset.estudiante.includes(busqueda)) {
                mostrar = false;
            }

            card.style.display = mostrar ? 'block' : 'none';
        });

        // Ordenar
        const cardsVisibles = cards.filter(card => card.style.display !== 'none');
        
        cardsVisibles.sort((a, b) => {
            switch (ordenarPor) {
                case 'fecha_entrega':
                    return new Date(b.dataset.fechaEntrega) - new Date(a.dataset.fechaEntrega);
                case 'estudiante':
                    return a.dataset.estudiante.localeCompare(b.dataset.estudiante);
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
        ordenar.value = 'fecha_entrega';
        buscarEstudiante.value = '';
        aplicarFiltros();
    }

    // Event listeners
    filtroEstado.addEventListener('change', aplicarFiltros);
    ordenar.addEventListener('change', aplicarFiltros);
    buscarEstudiante.addEventListener('input', aplicarFiltros);

    // Hacer limpiarFiltros disponible globalmente
    window.limpiarFiltros = limpiarFiltros;
});
</script>

<style>
.entrega-card {
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

.badge {
    font-size: 0.8em;
}
</style>
@endsection
