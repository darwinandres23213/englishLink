{{-- filepath: resources/views/actividades/create.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', isset($actividad) ? 'Editar Actividad' : 'Crear Nueva Actividad')

@section('content')

    <div class="container py-1">
        <div class="card-header bg-transparent text-primary mb-1">
            <h1 class="fw-bold">
                @if (isset($actividad))
                    Editar Actividad
                    <i class="bi bi-pencil-square"></i>
                @else
                    Nueva Actividad
                    <i class="bi bi-plus-circle"></i>
                @endif
            </h1>
        </div>

        <div class="card-body">
            @if (isset($actividad))
                <!-- Alerta si tiene entregas -->
                @if ($actividad->entregas->where('fecha_entrega', '!=', null)->count() > 0)
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Atención:</strong> Esta actividad ya tiene
                        {{ $actividad->entregas->where('fecha_entrega', '!=', null)->count() }} entrega(s).
                        Los cambios pueden afectar las entregas existentes.
                    </div>
                @endif
            @endif

            <form method="POST"
                action="{{ isset($actividad) ? route('actividades.update', $actividad) : route('actividades.store') }}">
                @csrf
                @if (isset($actividad))
                    @method('PUT')
                @endif

                @if (isset($actividad))
                    <!-- Curso (Solo información en edición) -->
                    <div class="mb-4">
                        <label class="form-label">Curso Asignado</label>
                        <div class="p-3 bg-gray-200 border rounded font-weight-bold">
                            <div><!--i class="bi bi-book me-2"></i -->{{ $actividad->curso->nombre_curso }}</div>
                            <div class="ms-3 mt-0"><small class="text-muted">Nivel:
                                    {{ $actividad->curso->nivel->nombre_nivel ?? 'N/A' }}</small></div>
                        </div>
                        <div class="ms-4 form-text text-danger">
                            <i class="bi bi-exclamation-triangle me-1"></i>El curso no se puede cambiar después de crear la
                            actividad.
                        </div>
                        <!-- <small class="ms-4 text-muted">El curso no se puede cambiar después de crear la actividad.</small> -->
                    </div>
                @else
                    <!-- Seleccionar Curso (solo en creación) -->
                    <div class="mb-4">
                        <label for="curso_id" class="form-label">Curso <span class="text-danger">*</span></label>
                        <select name="curso_id" id="curso_id" class="form-select @error('curso_id') is-invalid @enderror"
                            required>
                            <option value="">Selecciona un curso</option>
                            @foreach ($cursos as $curso)
                                <option value="{{ $curso->id_curso }}"
                                    {{ old('curso_id', request('curso')) == $curso->id_curso ? 'selected' : '' }}>
                                    {{ $curso->nombre_curso }} - {{ $curso->nivel->nombre_nivel ?? 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                        @error('curso_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endif

                <!-- Título -->
                <div class="mb-4">
                    <label for="titulo" class="form-label">Título de la Actividad <span
                            class="text-danger">*</span></label>
                    <input type="text" name="titulo" id="titulo"
                        class="form-control @error('titulo') is-invalid @enderror"
                        value="{{ old('titulo', $actividad->titulo ?? '') }}" required maxlength="255"
                        placeholder="Ej: Ensayo sobre literatura inglesa">
                    @error('titulo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Descripción -->
                <div class="mb-4">
                    <label for="descripcion" class="form-label">Descripción <span class="text-danger">*</span></label>
                    <textarea name="descripcion" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror"
                        rows="4" required placeholder="Describe brevemente la actividad...">{{ old('descripcion', $actividad->descripcion ?? '') }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Instrucciones -->
                <div class="mb-4">
                    <label for="instrucciones" class="form-label">Instrucciones Detalladas <span
                            class="text-danger">*</span></label>
                    <textarea name="instrucciones" id="instrucciones" class="form-control @error('instrucciones') is-invalid @enderror"
                        rows="6" placeholder="Proporciona instrucciones detalladas para completar la actividad...">{{ old('instrucciones', $actividad->instrucciones ?? '') }}</textarea>
                    @error('instrucciones')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <!-- Fecha de Vencimiento -->
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-calendar-event"></i>
                                </span>
                                <input type="text" name="fecha_vencimiento" id="fecha_vencimiento"
                                    class="form-control @error('fecha_vencimiento') is-invalid @enderror"
                                    value="{{ old('fecha_vencimiento', isset($actividad) ? \Carbon\Carbon::parse($actividad->fecha_vencimiento)->format('Y-m-d H:i') : '') }}"
                                    required placeholder="Selecciona fecha y hora">
                                @error('fecha_vencimiento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text">
                                <!-- i class="bi bi-clock me-1"></i>
                                Especifica cuándo vence la actividad (hora local: {{ config('app.timezone') }}) -->
                                @if (isset($actividad) && $actividad->estaVencida())
                                    <span class="text-danger ms-4">
                                        <i class="bi bi-exclamation-triangle me-1"></i>Esta actividad ya está vencida!
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Calificación Máxima -->
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="calificacion_maxima" class="form-label">Calificación Máxima <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="calificacion_maxima" id="calificacion_maxima"
                                class="form-control @error('calificacion_maxima') is-invalid @enderror"
                                value="{{ old('calificacion_maxima', $actividad->calificacion_maxima ?? 5) }}" required
                                min="1" max="5" step="0.1">
                            @error('calificacion_maxima')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Puntuación máxima que puede obtener el estudiante</div>
                            @if (isset($actividad) && $actividad->entregas->where('calificacion', '!=', null)->count() > 0)
                                <div class="ms-4 form-text text-danger">
                                    <i class="bi bi-exclamation-triangle me-1"></i>Cambiar esto afectará las calificaciones
                                    existentes
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Tipo de Entrega -->
                <div class="mb-4">
                    <label class="form-label">Tipo de Entrega <span class="text-danger">*</span></label>
                    @if (isset($actividad) && $actividad->entregas->where('fecha_entrega', '!=', null)->count() > 0)
                        <div class="p-2 bg-gray-200 border rounded font-weight-bold"> <!-- bg-warning-subtle -->
                            @switch($actividad->tipo_entrega)
                                @case('archivo')
                                    <i class="bi bi-file-earmark-arrow-up me-1"></i>Solo Archivo
                                @break

                                @case('texto')
                                    <i class="bi bi-pencil me-1"></i>Solo Texto
                                @break

                                @case('ambos')
                                    <i class="bi bi-plus me-1"></i>Texto y Archivo
                                @break
                            @endswitch
                        </div>
                        <div class="ms-4 form-text text-danger">
                            <i class="bi bi-exclamation-triangle me-1"></i>No se puede cambiar el tipo de entrega porque ya
                            hay entregas realizadas.
                        </div>
                        <input type="hidden" name="tipo_entrega" value="{{ $actividad->tipo_entrega }}">
                    @else
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipo_entrega" id="tipo_archivo"
                                        value="archivo"
                                        {{ old('tipo_entrega', $actividad->tipo_entrega ?? 'archivo') == 'archivo' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tipo_archivo">
                                        <i class="bi bi-file-earmark-arrow-up me-2"></i>Solo Archivo
                                    </label>
                                    <div class="form-text">El estudiante debe subir un archivo</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipo_entrega" id="tipo_texto"
                                        value="texto"
                                        {{ old('tipo_entrega', $actividad->tipo_entrega ?? '') == 'texto' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tipo_texto">
                                        <i class="fas fa-edit me-2"></i>Solo Texto
                                    </label>
                                    <div class="form-text">El estudiante escribe su respuesta</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipo_entrega" id="tipo_ambos"
                                        value="ambos"
                                        {{ old('tipo_entrega', $actividad->tipo_entrega ?? '') == 'ambos' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tipo_ambos">
                                        <i class="fas fa-plus me-2"></i>Texto y Archivo
                                    </label>
                                    <div class="form-text">Ambos son requeridos</div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @error('tipo_entrega')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Estado de la Actividad -->
                <div class="mb-4">
                    <label class="form-label">Estado de la Actividad <span class="text-danger">*</span></label>
                    <div class="p-4 border rounded bg-gray-200 text-center">
                        <div class="form-check form-switch d-flex justify-content-center mb-3">
                            <input class="form-check-input" type="checkbox" name="activa" id="activa"
                                value="1"
                                {{ old('activa', isset($actividad) ? $actividad->activa : true) ? 'checked' : '' }}
                                style="transform: scale(1.5);">
                        </div>

                        <div class="mb-2">
                            <label class="form-check-label fw-bold fs-5 d-flex justify-content-center align-items-center"
                                for="activa">
                                <span id="estadoTexto" class="me-2">
                                    {{ old('activa', isset($actividad) ? $actividad->activa : true) ? 'Actividad Activa' : 'Actividad Inactiva' }}
                                </span>
                                <span id="estadoIcono" class="fs-4">
                                    {{ old('activa', isset($actividad) ? $actividad->activa : true) ? '🟢' : '🔴' }}
                                </span>
                            </label>
                        </div>

                        <div>
                            <div id="descripcionActiva" class="text-muted small"
                                style="display: {{ old('activa', isset($actividad) ? $actividad->activa : true) ? 'block' : 'none' }}">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                Los estudiantes pueden ver y entregar esta actividad.
                            </div>
                            <div id="descripcionInactiva" class="text-muted small"
                                style="display: {{ old('activa', isset($actividad) ? $actividad->activa : true) ? 'none' : 'block' }}">
                                <i class="bi bi-pause-circle text-warning me-2"></i>
                                @if (isset($actividad))
                                    Los estudiantes no pueden ver ni entregar esta actividad.
                                @else
                                    Crear como borrador, activar después cuando esté lista.
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @if (isset($actividad))
                    <!-- Información adicional (solo en edición) -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h5 class="text-primary">{{ $actividad->entregas->count() }}</h5>
                                    <small class="text-muted">Estudiantes Asignados</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h5 class="text-success">
                                        {{ $actividad->entregas->where('fecha_entrega', '!=', null)->count() }}</h5>
                                    <small class="text-muted">Entregas Realizadas</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Botones -->
                <div class="d-flex gap-2 justify-content-end py-4">
                    <a href="{{ isset($actividad) ? route('actividades.show', $actividad) : route('actividades.index') }}"
                        class="btn btn-secondary">
                        <i class="bi bi-arrow-left">
                            Cancelar
                        </i>
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle">
                            {{ isset($actividad) ? 'Actualizar' : 'Crear' }}
                        </i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Manejar cambios en el estado de actividad
                const switchActiva = document.getElementById('activa');
                const estadoTexto = document.getElementById('estadoTexto');
                const estadoIcono = document.getElementById('estadoIcono');
                const descripcionActiva = document.getElementById('descripcionActiva');
                const descripcionInactiva = document.getElementById('descripcionInactiva');

                switchActiva.addEventListener('change', function() {
                    if (this.checked) {
                        estadoTexto.textContent = 'Actividad Activa';
                        estadoIcono.textContent = '🟢';
                        descripcionActiva.style.display = 'block';
                        descripcionInactiva.style.display = 'none';
                    } else {
                        estadoTexto.textContent = 'Actividad Inactiva';
                        estadoIcono.textContent = '🔴';
                        descripcionActiva.style.display = 'none';
                        descripcionInactiva.style.display = 'block';
                    }
                });

                @if (isset($actividad))
                    // Validar calificación máxima si hay entregas calificadas
                    const calificacionMaxima = document.getElementById('calificacion_maxima');
                    const entregasCalificadas = {{ $actividad->entregas->where('calificacion', '!=', null)->count() }};

                    if (entregasCalificadas > 0) {
                        calificacionMaxima.addEventListener('change', function() {
                            if (!confirm(
                                    `Cambiar la calificación máxima afectará ${entregasCalificadas} entrega(s) ya calificada(s). ¿Deseas continuar?`
                                    )) {
                                this.value = '{{ $actividad->calificacion_maxima }}';
                            }
                        });
                    }
                @endif

                // Configurar Flatpickr para fecha de vencimiento
                const fp = flatpickr("#fecha_vencimiento", {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
                    time_24hr: false,
                    locale: "es",
                    minDate: "today",
                    minuteIncrement: 15,
                    defaultHour: 23,
                    defaultMinute: 59,
                    theme: "material_blue",
                    allowInput: true,
                    clickOpens: true,
                    onChange: function(selectedDates, dateStr, instance) {
                        // Validar que la fecha sea futura
                        const selectedDate = selectedDates[0];
                        const now = new Date();

                        if (selectedDate && selectedDate <= now) {
                            @if (!isset($actividad))
                                alert(
                                'La fecha de vencimiento debe ser posterior a la fecha y hora actual');
                                instance.clear();
                            @else
                                if (!confirm(
                                        'La fecha de vencimiento es anterior o igual a la fecha actual. ¿Deseas continuar? La actividad estará vencida.'
                                        )) {
                                    instance.setDate(
                                        '{{ isset($actividad) ? \Carbon\Carbon::parse($actividad->fecha_vencimiento)->format('Y-m-d H:i') : '' }}'
                                        );
                                }
                            @endif
                        }
                    }
                });

                // Agregar icono de reloj al selector
                const calendarIcon = document.querySelector('#fecha_vencimiento').parentNode.querySelector(
                    '.bi-calendar-event');
                if (calendarIcon) {
                    calendarIcon.addEventListener('click', function() {
                        fp.open();
                    });
                }
            });
        </script>
    @endpush
@endsection