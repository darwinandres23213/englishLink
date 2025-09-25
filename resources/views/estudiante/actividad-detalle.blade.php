{{-- filepath: resources/views/estudiante/actividad-detalle.blade.php --}}
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
                <span class="ms-3"><i class="fas fa-user me-2"></i>{{ $actividad->profesor->nombre }} {{ $actividad->profesor->apellido }}</span>
            </p>
        </div>
        <div>
            <a href="{{ route('estudiante.actividades') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Volver a Mis Actividades
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Contenido Principal -->
        <div class="col-lg-8">
            <!-- Información de la Actividad -->
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
                        <div class="col-md-4">
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
                        <div class="col-md-4">
                            <strong>Calificación Máxima:</strong>
                            <span class="text-primary fw-bold">{{ $actividad->calificacion_maxima }} puntos</span>
                        </div>
                        <div class="col-md-4">
                            <strong>Fecha de Vencimiento:</strong>
                            <span class="fw-bold {{ $actividad->estaVencida() ? 'text-danger' : 'text-success' }}">
                                {{ $actividad->fecha_vencimiento->format('d/m/Y H:i') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estado de Mi Entrega -->
            @if($entrega->fecha_entrega)
                <div class="card mb-4 border-success">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-check-circle me-2"></i>Mi Entrega
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Fecha de Entrega:</strong>
                                <div class="mt-1">{{ $entrega->fecha_entrega->format('d/m/Y H:i') }}</div>
                                @if($entrega->fecha_entrega > $actividad->fecha_vencimiento)
                                    <span class="badge bg-warning mt-1">Entrega Tardía</span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <strong>Estado:</strong>
                                <div class="mt-1">
                                    @if($entrega->calificacion !== null)
                                        <span class="badge bg-success fs-6">Calificada</span>
                                    @else
                                        <span class="badge bg-info fs-6">Esperando Calificación</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if($entrega->comentario_estudiante)
                            <div class="mb-3">
                                <strong>Mi Comentario:</strong>
                                <div class="mt-2 p-3 bg-light rounded">
                                    {{ $entrega->comentario_estudiante }}
                                </div>
                            </div>
                        @endif

                        @if($entrega->archivo_entrega)
                            <div class="mb-3">
                                <strong>Archivo Entregado:</strong>
                                <div class="mt-2">
                                    <a href="{{ Storage::url($entrega->archivo_entrega) }}" 
                                       class="btn btn-outline-primary" target="_blank">
                                        <i class="fas fa-download me-2"></i>{{ basename($entrega->archivo_entrega) }}
                                    </a>
                                </div>
                            </div>
                        @endif

                        @if($entrega->calificacion !== null)
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body text-center">
                                            <h3 class="mb-1">{{ $entrega->calificacion }}/{{ $actividad->calificacion_maxima }}</h3>
                                            <small>Mi Calificación</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    @php
                                        $porcentaje = ($entrega->calificacion / $actividad->calificacion_maxima) * 100;
                                    @endphp
                                    <div class="card 
                                        @if($porcentaje >= 70) bg-success
                                        @elseif($porcentaje >= 60) bg-warning
                                        @else bg-danger
                                        @endif text-white">
                                        <div class="card-body text-center">
                                            <h3 class="mb-1">{{ number_format($porcentaje, 1) }}%</h3>
                                            <small>Porcentaje Obtenido</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($entrega->comentario_profesor)
                                <div class="mt-3">
                                    <strong>Comentarios del Profesor:</strong>
                                    <div class="mt-2 p-3 bg-info bg-opacity-10 border border-info rounded">
                                        <i class="fas fa-quote-left text-info me-2"></i>
                                        {{ $entrega->comentario_profesor }}
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            @else
                <!-- Formulario de Entrega -->
                <div class="card mb-4" id="entrega">
                    <div class="card-header {{ $actividad->estaVencida() ? 'bg-danger text-white' : 'bg-primary text-white' }}">
                        <h5 class="card-title mb-0">
                            @if($actividad->estaVencida())
                                <i class="fas fa-exclamation-triangle me-2"></i>Actividad Vencida
                            @else
                                <i class="fas fa-upload me-2"></i>Realizar Entrega
                            @endif
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($actividad->estaVencida())
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Esta actividad ha vencido.</strong> 
                                No puedes realizar entregas después de la fecha de vencimiento.
                            </div>
                        @else
                            <form action="{{ route('estudiante.actividad.entregar', $entrega) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="entrega_id" value="{{ $entrega->id_entrega }}">

                                @if(in_array($actividad->tipo_entrega, ['texto', 'ambos']))
                                    <!-- Comentario del Estudiante -->
                                    <div class="mb-3">
                                        <label for="respuesta_texto" class="form-label">
                                            Tu Respuesta/Comentario 
                                            @if($actividad->tipo_entrega === 'texto')
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                        <textarea name="respuesta_texto" id="respuesta_texto" 
                                                  class="form-control @error('respuesta_texto') is-invalid @enderror" 
                                                  rows="6" placeholder="Escribe tu respuesta aquí..."
                                                  @if($actividad->tipo_entrega === 'texto') required @endif>{{ old('respuesta_texto') }}</textarea>
                                        @error('respuesta_texto')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif

                                @if(in_array($actividad->tipo_entrega, ['archivo', 'ambos']))
                                    <!-- Archivo de Entrega -->
                                    <div class="mb-3">
                                        <label for="archivo" class="form-label">
                                            Archivo a Entregar 
                                            @if($actividad->tipo_entrega === 'archivo')
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                        <input type="file" name="archivo" id="archivo" 
                                               class="form-control @error('archivo') is-invalid @enderror"
                                               accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png,.zip,.rar"
                                               @if($actividad->tipo_entrega === 'archivo') required @endif>
                                        @error('archivo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            Archivos permitidos: PDF, Word, imágenes, texto, ZIP (máximo 10MB)
                                        </div>
                                    </div>
                                @endif

                                <!-- Confirmación -->
                                <div class="alert alert-warning">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Importante:</strong> Una vez que entregues la actividad, no podrás modificar tu entrega.
                                </div>

                                <div class="d-flex gap-2 justify-content-end">
                                    <button type="button" class="btn btn-secondary" onclick="confirmarEntrega()">
                                        <i class="fas fa-check me-2"></i>Entregar Actividad
                                    </button>
                                </div>

                                <!-- Modal de Confirmación -->
                                <div class="modal fade" id="confirmarEntregaModal" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Confirmar Entrega</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>¿Estás seguro de que deseas entregar esta actividad?</p>
                                                <div class="alert alert-info">
                                                    <i class="fas fa-exclamation-circle me-2"></i>
                                                    Una vez entregada, no podrás modificar tu respuesta.
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-primary">Confirmar Entrega</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endif
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
                        <i class="fas fa-flag me-2"></i>Estado
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        @if($entrega->fecha_entrega)
                            @if($entrega->calificacion !== null)
                                <div class="badge bg-success fs-6 p-2">
                                    <i class="fas fa-star me-2"></i>CALIFICADA
                                </div>
                            @else
                                <div class="badge bg-info fs-6 p-2">
                                    <i class="fas fa-clock me-2"></i>ENTREGADA
                                </div>
                            @endif
                        @elseif($actividad->estaVencida())
                            <div class="badge bg-danger fs-6 p-2">
                                <i class="fas fa-exclamation-triangle me-2"></i>VENCIDA
                            </div>
                        @else
                            <div class="badge bg-warning fs-6 p-2">
                                <i class="fas fa-clock me-2"></i>PENDIENTE
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">Fecha de vencimiento:</small>
                        <strong class="{{ $actividad->estaVencida() ? 'text-danger' : 'text-success' }}">
                            {{ $actividad->fecha_vencimiento->format('d/m/Y H:i') }}
                        </strong>
                    </div>

                    @if(!$actividad->estaVencida() && !$entrega->fecha_entrega)
                        <div class="alert alert-info">
                            <i class="fas fa-clock me-2"></i>
                            <strong>Tiempo restante:</strong><br>
                            <span id="countdown-timer" data-target="{{ $actividad->fecha_vencimiento->toISOString() }}"></span>
                        </div>
                    @endif

                    <div class="mb-3">
                        <small class="text-muted d-block">Profesor:</small>
                        <strong>{{ $actividad->profesor->nombre }} {{ $actividad->profesor->apellido }}</strong>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">Fecha de creación:</small>
                        <strong>{{ $actividad->created_at->format('d/m/Y H:i') }}</strong>
                    </div>
                </div>
            </div>

            <!-- Información de Entrega -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-upload me-2"></i>Información de Entrega
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block">Tipo requerido:</small>
                        <span class="badge bg-secondary">
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

                    @if(!$entrega->fecha_entrega && !$actividad->estaVencida())
                        <div class="d-grid">
                            <a href="#entrega" class="btn btn-primary">
                                <i class="fas fa-upload me-2"></i>Ir a Entrega
                            </a>
                        </div>
                    @elseif($entrega->fecha_entrega)
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            Ya has entregado esta actividad
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

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
                
                if (days > 0) {
                    timerElement.innerHTML = `${days}d ${hours}h ${minutes}m`;
                } else if (hours > 0) {
                    timerElement.innerHTML = `${hours}h ${minutes}m`;
                } else {
                    timerElement.innerHTML = `${minutes}m`;
                }
            } else {
                timerElement.innerHTML = 'Vencida';
                timerElement.parentElement.className = 'alert alert-danger';
                location.reload(); // Recargar para actualizar estado
            }
        }
        
        updateCountdown();
        setInterval(updateCountdown, 60000); // Actualizar cada minuto
    }

    // Validación de archivo
    const archivoInput = document.getElementById('archivo_entrega');
    if (archivoInput) {
        archivoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                // Validar tamaño (10MB máximo)
                if (file.size > 10 * 1024 * 1024) {
                    alert('El archivo es demasiado grande. El tamaño máximo es 10MB.');
                    this.value = '';
                    return;
                }

                // Mostrar información del archivo
                const fileName = file.name;
                const fileSize = (file.size / 1024 / 1024).toFixed(2);
                console.log(`Archivo seleccionado: ${fileName} (${fileSize} MB)`);
            }
        });
    }
});

function confirmarEntrega() {
    // Validar campos requeridos
    const form = document.querySelector('form');
    const comentario = document.getElementById('respuesta_texto');
    const archivo = document.getElementById('archivo');
    const tipoEntrega = '{{ $actividad->tipo_entrega }}';
    
    let valido = true;
    
    if ((tipoEntrega === 'texto' || tipoEntrega === 'ambos') && (!comentario.value.trim())) {
        alert('Debes escribir una respuesta.');
        comentario.focus();
        return;
    }
    
    if ((tipoEntrega === 'archivo' || tipoEntrega === 'ambos') && (!archivo.files.length)) {
        alert('Debes seleccionar un archivo.');
        archivo.focus();
        return;
    }
    
    // Mostrar modal de confirmación
    const modal = new bootstrap.Modal(document.getElementById('confirmarEntregaModal'));
    modal.show();
}
</script>
@endsection
