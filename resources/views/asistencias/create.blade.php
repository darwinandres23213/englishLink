{{-- filepath: resources/views/asistencias/create.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', isset($asistencia) ? 'Editar Asistencia' : 'Registrar Asistencia Individual')
@section('content')

<div class="container py-4" style="background: #f8f9fc; min-height: 70vh; border-radius: 12px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-user-check me-2"></i>
                            {{ isset($asistencia) ? 'Editar Asistencia' : 'Registrar Asistencia Individual' }}
                        </h4>
                        <a href="{{ url()->previous() }}" class="btn btn-outline-light btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Volver
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($clases->count() > 0)
                        <form method="POST" action="{{ isset($asistencia) ? route('asistencias.update', $asistencia->id_asistencia) : route('asistencias.store') }}">
                            @csrf
                            @if(isset($asistencia))
                                @method('PUT')
                            @endif

                            <div class="mb-3">
                                <label for="clase_id" class="form-label">
                                    <i class="fas fa-chalkboard-teacher me-1"></i>Clase
                                </label>
                                <select name="clase_id" id="clase_id" class="form-select" required>
                                    <option value="">Seleccione una clase</option>
                                    @foreach($clases as $clase)
                                        <option value="{{ $clase->id_clase }}" 
                                                data-curso="{{ $clase->curso->nombre_curso ?? 'N/A' }}"
                                                {{ old('clase_id', $asistencia->clase_id ?? '') == $clase->id_clase ? 'selected' : '' }}>
                                            {{ $clase->tema }} - {{ $clase->fecha ? \Carbon\Carbon::parse($clase->fecha)->format('d/m/Y') : 'Sin fecha' }} 
                                            ({{ $clase->curso->nombre_curso ?? 'N/A' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('clase_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle me-1"></i>Solo se muestran las clases de sus cursos asignados
                                </small>
                            </div>

                            <div class="mb-3">
                                <label for="estudiante_id" class="form-label">
                                    <i class="fas fa-user-graduate me-1"></i>Estudiante
                                </label>
                                <select name="estudiante_id" id="estudiante_id" class="form-select" required disabled>
                                    <option value="">Primero seleccione una clase</option>
                                </select>
                                @error('estudiante_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div id="loading-estudiantes" class="text-muted small mt-1" style="display: none;">
                                    <i class="fas fa-spinner fa-spin me-1"></i>Cargando estudiantes...
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="estado_id" class="form-label">
                                    <i class="fas fa-clipboard-check me-1"></i>Estado de Asistencia
                                </label>
                                <select name="estado_id" id="estado_id" class="form-select" required>
                                    <option value="">Seleccione el estado</option>
                                    @if(isset($estados))
                                        @foreach($estados as $estado)
                                            <option value="{{ $estado->id_estado }}" 
                                                    {{ old('estado_id', $asistencia->estado_id ?? '') == $estado->id_estado ? 'selected' : '' }}>
                                                {{ $estado->nombre_estado }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('estado_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i>Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>
                                    {{ isset($asistencia) ? 'Actualizar' : 'Registrar' }} Asistencia
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-chalkboard-teacher fa-3x text-gray-300 mb-3"></i>
                            <h6 class="text-gray-600">No hay clases disponibles</h6>
                            <p class="text-muted">Necesita crear clases para sus cursos antes de tomar asistencia.</p>
                            
                            <!-- Mostrar cursos disponibles para crear clases -->
                            @if(request()->get('curso'))
                                @php
                                    $curso = \App\Models\Curso::find(request()->get('curso'));
                                @endphp
                                @if($curso)
                                    <div class="alert alert-info">
                                        <h6><i class="fas fa-info-circle me-2"></i>Curso seleccionado: {{ $curso->nombre_curso }}</h6>
                                        <p class="mb-2">Para tomar asistencia, primero debe crear una clase para este curso.</p>
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalCrearClase" onclick="prepararModalClase('{{ $curso->id_curso }}', '{{ $curso->nombre_curso }}')">
                                            <i class="fas fa-plus me-1"></i>Crear Nueva Clase
                                        </button>
                                    </div>
                                @endif
                            @endif
                            
                            <a href="{{ route('profesor.mis-clases') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-1"></i>Volver a Mis Clases
                            </a>
                        </div>
                        
                        <!-- Modal para crear nueva clase -->
                        <div class="modal fade" id="modalCrearClase" tabindex="-1" aria-labelledby="modalCrearClaseLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="modalCrearClaseLabel">
                                            <i class="fas fa-chalkboard-teacher me-2"></i>Crear Nueva Clase
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form id="form-crear-clase" method="POST" action="{{ route('clases.store') }}">
                                        @csrf
                                        <div class="modal-body">
                                            <input type="hidden" name="curso_id" id="modal_curso_id">
                                            <input type="hidden" name="from_asistencia" value="1">
                                            
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    <i class="fas fa-book me-1"></i>Curso
                                                </label>
                                                <input type="text" class="form-control" id="modal_nombre_curso" readonly>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="modal_fecha" class="form-label">
                                                    <i class="fas fa-calendar me-1"></i>Fecha de la Clase <span class="text-danger">*</span>
                                                </label>
                                                <input type="date" class="form-control" name="fecha" id="modal_fecha" required>
                                                <small class="form-text text-muted">Seleccione la fecha en que se impartirá la clase</small>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="modal_tema" class="form-label">
                                                    <i class="fas fa-lightbulb me-1"></i>Tema de la Clase <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" name="tema" id="modal_tema" placeholder="Ej: Introducción a los verbos irregulares" required>
                                                <small class="form-text text-muted">Describa brevemente el tema que se verá en la clase</small>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="modal_material" class="form-label">
                                                    <i class="fas fa-file-alt me-1"></i>Material de la Clase
                                                </label>
                                                <textarea class="form-control" name="material" id="modal_material" rows="3" placeholder="Describa el material que se utilizará en la clase (libros, páginas, recursos, etc.)">Material de clase</textarea>
                                                <small class="form-text text-muted">Opcional: Especifique el material que los estudiantes necesitarán</small>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                <i class="fas fa-times me-1"></i>Cancelar
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save me-1"></i>Crear Clase
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
@endsection

<style>
.modal-content {
    border-radius: 10px;
}

.modal-header {
    border-radius: 10px 10px 0 0;
}

.form-control:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

.btn-close-white {
    filter: invert(1) grayscale(100%) brightness(200%);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const claseSelect = document.getElementById('clase_id');
    const estudianteSelect = document.getElementById('estudiante_id');
    const loadingIndicator = document.getElementById('loading-estudiantes');

    // Variables para el modo edición
    const isEditing = {{ isset($asistencia) ? 'true' : 'false' }};
    const editingData = isEditing ? {
        claseId: '{{ $asistencia->clase_id ?? '' }}',
        estudianteId: '{{ $asistencia->estudiante_id ?? '' }}'
    } : null;

    function cargarEstudiantes(claseId, estudianteIdSeleccionado = null) {
        if (!claseId) return;
        
        // Mostrar indicador de carga
        loadingIndicator.style.display = 'block';
        estudianteSelect.innerHTML = '<option value="">Cargando estudiantes...</option>';
        estudianteSelect.disabled = true;
        
        // Hacer petición AJAX
        fetch(`{{ route('asistencias.estudiantes-por-clase') }}?clase_id=${claseId}`)
            .then(response => response.json())
            .then(data => {
                loadingIndicator.style.display = 'none';
                
                if (data.length > 0) {
                    estudianteSelect.innerHTML = '<option value="">Seleccione un estudiante</option>';
                    
                    data.forEach(estudiante => {
                        const option = document.createElement('option');
                        option.value = estudiante.id;
                        option.textContent = estudiante.nombre;
                        // Preseleccionar el estudiante si estamos editando
                        if (estudianteIdSeleccionado && estudiante.id == estudianteIdSeleccionado) {
                            option.selected = true;
                        }
                        estudianteSelect.appendChild(option);
                    });
                    
                    estudianteSelect.disabled = false;
                } else {
                    estudianteSelect.innerHTML = '<option value="">No hay estudiantes matriculados en esta clase</option>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                loadingIndicator.style.display = 'none';
                estudianteSelect.innerHTML = '<option value="">Error al cargar estudiantes</option>';
            });
    }

    if (claseSelect) {
        claseSelect.addEventListener('change', function() {
            const claseId = this.value;
            
            // Limpiar y deshabilitar el select de estudiantes
            estudianteSelect.innerHTML = '<option value="">Primero seleccione una clase</option>';
            estudianteSelect.disabled = true;
            
            if (claseId) {
                cargarEstudiantes(claseId);
            }
        });

        // Si estamos en modo edición, cargar los estudiantes automáticamente
        if (isEditing && editingData.claseId) {
            cargarEstudiantes(editingData.claseId, editingData.estudianteId);
        }
    }
    
    // Validación adicional para el formulario de crear clase
    const formCrearClase = document.getElementById('form-crear-clase');
    if (formCrearClase) {
        formCrearClase.addEventListener('submit', function(e) {
            const fecha = document.getElementById('modal_fecha').value;
            const tema = document.getElementById('modal_tema').value.trim();
            
            if (!fecha) {
                e.preventDefault();
                alert('Por favor seleccione una fecha para la clase.');
                return;
            }
            
            if (!tema) {
                e.preventDefault();
                alert('Por favor ingrese un tema para la clase.');
                return;
            }
            
            // Confirmar creación
            const nombreCurso = document.getElementById('modal_nombre_curso').value;
            const fechaFormateada = new Date(fecha).toLocaleDateString('es-ES');
            
            if (!confirm(`¿Crear clase "${tema}" para el curso "${nombreCurso}" el día ${fechaFormateada}?`)) {
                e.preventDefault();
            }
        });
    }
});

// Función para preparar el modal de crear clase
function prepararModalClase(cursoId, nombreCurso) {
    // Establecer valores en el formulario del modal
    document.getElementById('modal_curso_id').value = cursoId;
    document.getElementById('modal_nombre_curso').value = nombreCurso;
    
    // Establecer fecha de hoy como sugerencia
    const hoy = new Date();
    const fechaHoy = hoy.toISOString().split('T')[0];
    document.getElementById('modal_fecha').value = fechaHoy;
    
    // Limpiar campos
    document.getElementById('modal_tema').value = '';
    document.getElementById('modal_material').value = 'Material de clase';
    
    // Enfocar el campo de tema cuando se abra el modal
    setTimeout(() => {
        document.getElementById('modal_tema').focus();
    }, 500);
}

// Función para crear clase rápida (mantenida para compatibilidad)
function crearClaseRapida(cursoId, nombreCurso) {
    prepararModalClase(cursoId, nombreCurso);
}
</script>