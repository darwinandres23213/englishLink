{{-- filepath: resources/views/asistencias/index.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', 'Gestión de Asistencias')
@section('content')

<div class="container py-4" style="background: #f8f9fc; min-height: 70vh; border-radius: 12px;">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-clipboard-check me-2 text-primary"></i>
                        Gestión de Asistencias
                    </h1>
                    @if(request()->get('curso'))
                        @php
                            $curso = \App\Models\Curso::find(request()->get('curso'));
                        @endphp
                        @if($curso)
                            <p class="mb-0 text-muted">Curso: <strong>{{ $curso->nombre_curso }}</strong></p>
                        @endif
                    @endif
                </div>
                <div>
                    <a href="{{ route('profesor.mis-clases') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Volver a Mis Clases
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Botones de acción -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-tools me-2"></i>Acciones Disponibles
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <button type="button" class="btn btn-success btn-block" data-bs-toggle="modal" data-bs-target="#modalCrearClase" onclick="prepararModalClase()">
                                <i class="fas fa-plus me-2"></i>
                                Crear Nueva Clase
                            </button>
                            <small class="text-muted d-block mt-1">Crea una clase antes de tomar asistencia</small>
                        </div>
                        <div class="col-md-4 mb-2">
                            <a href="{{ route('asistencias.registrar.masivo') }}{{ request()->get('curso') ? '?curso=' . request()->get('curso') : '' }}" class="btn btn-info btn-block">
                                <i class="fas fa-clipboard-check me-2"></i>
                                Tomar Asistencia Masiva
                            </a>
                            <small class="text-muted d-block mt-1">Registra asistencia de toda la clase</small>
                        </div>
                        <div class="col-md-4 mb-2">
                            <a href="{{ route('clases.index') }}" class="btn btn-outline-primary btn-block">
                                <i class="fas fa-chalkboard-teacher me-2"></i>
                                Ver Todas las Clases
                            </a>
                            <small class="text-muted d-block mt-1">Gestiona todas tus clases</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Historial de asistencias -->
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-history me-2"></i>Historial de Asistencias Recientes
            </h6>
        </div>
        <div class="card-body">
            @if($asistencias->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Clase/Tema</th>
                                <th>Curso</th>
                                <th>Estudiante</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asistencias as $asistencia)
                                <tr>
                                    <td>
                                        <small class="text-muted">
                                            {{ $asistencia->clase && $asistencia->clase->fecha ? \Carbon\Carbon::parse($asistencia->clase->fecha)->format('d/m/Y') : 'Sin fecha' }}
                                        </small>
                                    </td>
                                    <td>
                                        <strong>{{ $asistencia->clase->tema ?? 'Clase #' . $asistencia->clase_id }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ $asistencia->clase->curso->nombre_curso ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white me-2" style="width: 30px; height: 30px; font-size: 12px;">
                                                {{ strtoupper(substr($asistencia->estudiante->nombre ?? 'N', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $asistencia->estudiante->nombre ?? 'N/A' }} {{ $asistencia->estudiante->apellido ?? '' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $nombreEstado = $asistencia->estado->nombre_estado ?? 'Sin estado';
                                            $claseEstado = 'badge-secondary';
                                            $icono = 'fas fa-question';
                                            
                                            switch($nombreEstado) {
                                                case 'Asistió':
                                                    $claseEstado = 'badge-success';
                                                    $icono = 'fas fa-check';
                                                    break;
                                                case 'No Asistió':
                                                    $claseEstado = 'badge-danger';
                                                    $icono = 'fas fa-times';
                                                    break;
                                                case 'Llegó Tarde':
                                                    $claseEstado = 'badge-warning';
                                                    $icono = 'fas fa-clock';
                                                    break;
                                                case 'Falta Justificada':
                                                    $claseEstado = 'badge-info';
                                                    $icono = 'fas fa-check-circle';
                                                    break;
                                            }
                                        @endphp
                                        <span class="badge {{ $claseEstado }}">
                                            <i class="{{ $icono }} me-1"></i>{{ $nombreEstado }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('asistencias.edit', $asistencia->id_asistencia) }}" class="btn btn-warning btn-sm" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('asistencias.destroy', $asistencia->id_asistencia) }}" method="POST" style="display:inline;">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este registro de asistencia?')" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="row mt-3">
                    <div class="col-md-12">
                        {{ $asistencias->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-clipboard-check fa-3x text-gray-300 mb-3"></i>
                    <h6 class="text-gray-600">No hay registros de asistencia</h6>
                    <p class="text-muted">Comienza creando una clase y tomando asistencia</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal para crear nueva clase -->
<div class="modal fade" id="modalCrearClase" tabindex="-1" aria-labelledby="modalCrearClaseLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
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
                    <input type="hidden" name="from_asistencia" value="1">
                    
                    <div class="mb-3">
                        <label for="modal_curso_id" class="form-label">
                            <i class="fas fa-book me-1"></i>Curso <span class="text-danger">*</span>
                        </label>
                        <select name="curso_id" id="modal_curso_id" class="form-select" required>
                            <option value="">Seleccione un curso</option>
                            @php
                                $profesorId = Auth::user()->id_usuario;
                                $cursosProfesor = \App\Models\Curso::where('profesor_id', $profesorId)->get();
                            @endphp
                            @foreach($cursosProfesor as $curso)
                                <option value="{{ $curso->id_curso }}" {{ request()->get('curso') == $curso->id_curso ? 'selected' : '' }}>
                                    {{ $curso->nombre_curso }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modal_fecha" class="form-label">
                                    <i class="fas fa-calendar me-1"></i>Fecha de la Clase <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control" name="fecha" id="modal_fecha" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modal_tema" class="form-label">
                                    <i class="fas fa-lightbulb me-1"></i>Tema de la Clase <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="tema" id="modal_tema" placeholder="Ej: Present Simple - Affirmative sentences" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="modal_material" class="form-label">
                            <i class="fas fa-file-alt me-1"></i>Material de la Clase
                        </label>
                        <textarea class="form-control" name="material" id="modal_material" rows="3" placeholder="Describa el material que se utilizará (libros, páginas, recursos digitales, etc.)">Material de clase</textarea>
                        <small class="form-text text-muted">Opcional: Especifique los recursos que los estudiantes necesitarán</small>
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

<style>
.btn-block {
    display: block;
    width: 100%;
}

.modal-content {
    border-radius: 10px;
}

.modal-header {
    border-radius: 10px 10px 0 0;
}

.btn-close-white {
    filter: invert(1) grayscale(100%) brightness(200%);
}

.badge {
    font-size: 0.75em;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Establecer fecha de hoy por defecto
    const fechaInput = document.getElementById('modal_fecha');
    if (fechaInput) {
        const hoy = new Date();
        const fechaHoy = hoy.toISOString().split('T')[0];
        fechaInput.value = fechaHoy;
    }
});

function prepararModalClase() {
    // Limpiar campos
    document.getElementById('modal_tema').value = '';
    document.getElementById('modal_material').value = 'Material de clase';
    
    // Establecer fecha de hoy
    const hoy = new Date();
    const fechaHoy = hoy.toISOString().split('T')[0];
    document.getElementById('modal_fecha').value = fechaHoy;
    
    // Enfocar el campo de tema cuando se abra el modal
    setTimeout(() => {
        document.getElementById('modal_tema').focus();
    }, 500);
}
</script>

@endsection