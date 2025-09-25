{{-- filepath: resources/views/clases/create.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', isset($clase) ? 'Editar Clase' : 'Nueva Clase')

@section('content')

<div class="container py-1">
    <div class="card-header bg-transparent text-primary mb-1">
        <h1 class="fw-bold">
            @if (isset($clase))
                Editar Clase
                <i class="bi bi-pencil-square"></i>
            @else
                Nueva Clase
                <i class="bi bi-plus-circle"></i>
            @endif
        </h1>
    </div>

    <div class="card-body">
        @if (isset($clase))
            <!-- Información de la clase existente -->
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Editando clase:</strong> {{ $clase->tema }}
                <br><small class="text-muted">Creada el {{ \Carbon\Carbon::parse($clase->created_at)->format('d/m/Y') }}</small>
            </div>
        @endif

        <form method="POST" action="{{ isset($clase) ? route('clases.update', $clase->id_clase) : route('clases.store') }}">
            @csrf
            @if(isset($clase))
                @method('PUT')
            @endif

            @if (isset($clase))
                <!-- Curso (Solo información en edición) -->
                <div class="mb-4">
                    <label class="form-label">Curso Asignado</label>
                    <div class="p-3 bg-gray-200 border rounded font-weight-bold">
                        <div><i class="bi bi-book me-2"></i>{{ $clase->curso->nombre_curso ?? 'N/A' }}</div>
                        <div class="ms-3 mt-0"><small class="text-muted">Nivel: {{ $clase->curso->nivel->nombre_nivel ?? 'N/A' }}</small></div>
                    </div>
                    <div class="ms-4 form-text text-danger">
                        <i class="bi bi-exclamation-triangle me-1"></i>El curso no se puede cambiar después de crear la clase.
                    </div>
                </div>
            @else
                <!-- Seleccionar Curso (solo en creación) -->
                <div class="mb-4">
                    <label for="curso_id" class="form-label">Curso <span class="text-danger">*</span></label>
                    <select name="curso_id" id="curso_id" class="form-select @error('curso_id') is-invalid @enderror" required>
                        <option value="">Selecciona un curso</option>
                        @foreach($cursos as $curso)
                            <option value="{{ $curso->id_curso }}" {{ old('curso_id', request('curso')) == $curso->id_curso ? 'selected' : '' }}>
                                {{ $curso->nombre_curso }} - {{ $curso->nivel->nombre_nivel ?? 'N/A' }}
                            </option>
                        @endforeach
                    </select>
                    @error('curso_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endif
            <!-- Fecha de la Clase -->
            <div class="mb-4">
                <label for="fecha" class="form-label">Fecha de la Clase <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-calendar-event"></i>
                    </span>
                    <input type="date" name="fecha" id="fecha" 
                           class="form-control @error('fecha') is-invalid @enderror" 
                           value="{{ old('fecha', isset($clase) ? $clase->fecha : '') }}" 
                           required min="{{ date('Y-m-d') }}">
                    @error('fecha')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="ms-4 form-text text-primary">
                    <i class="bi bi-info-circle me-1"></i>
                    Selecciona la fecha en que se realizará la clase.
                </div>
            </div>

            <!-- Tema de la Clase -->
            <div class="mb-4">
                <label for="tema" class="form-label">Tema de la Clase <span class="text-danger">*</span></label>
                <input type="text" name="tema" id="tema" 
                       class="form-control @error('tema') is-invalid @enderror"
                       value="{{ old('tema', $clase->tema ?? '') }}" 
                       required maxlength="255"
                       placeholder="Ej: Introducción al Present Perfect">
                @error('tema')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="ms-4 form-text text-primary">Describe brevemente el tema que se tratará en la clase</div>
            </div>

            <!-- Material de la Clase -->
            <div class="mb-4">
                <label for="material" class="form-label">Material y Recursos <span class="text-danger">*</span></label>
                <textarea name="material" id="material" 
                          class="form-control @error('material') is-invalid @enderror"
                          rows="6" required 
                          placeholder="Describe los materiales, recursos, libros, páginas, ejercicios que se utilizarán en la clase...">{{ old('material', $clase->material ?? '') }}</textarea>
                @error('material')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="ms-4 form-text text-primary">
                    <i class="bi bi-lightbulb me-1"></i>
                    Especifica libros, páginas, ejercicios, materiales digitales, etc.
                </div>
            </div>

            @if (isset($clase))
                <!-- Información adicional (solo en edición) -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <i class="bi bi-calendar-check fa-2x text-primary mb-2"></i>
                                <h6 class="card-title">Fecha de Creación</h6>
                                <p class="card-text">{{ \Carbon\Carbon::parse($clase->created_at)->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <i class="bi bi-pencil-square fa-2x text-success mb-2"></i>
                                <h6 class="card-title">Última Modificación</h6>
                                <p class="card-text">{{ \Carbon\Carbon::parse($clase->updated_at)->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Botones -->
            <div class="d-flex gap-2 justify-content-end py-4">
                <a href="{{ isset($clase) ? route('clases.index') : route('clases.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i>
                    {{ isset($clase) ? 'Actualizar Clase' : 'Crear Clase' }}
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuración del input de fecha
    const fechaInput = document.getElementById('fecha');
    
    // Validar que la fecha no sea anterior a hoy (solo para nuevas clases)
    @if (!isset($clase))
    fechaInput.addEventListener('change', function() {
        const selectedDate = new Date(this.value);
        const today = new Date();
        today.setHours(0,0,0,0);
        
        if (selectedDate < today) {
            alert('La fecha de la clase no puede ser anterior a hoy.');
            this.value = '';
        }
    });
    @endif
    
    // Auto-resize para el textarea de material
    const materialTextarea = document.getElementById('material');
    materialTextarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    });
    
    // Validación del formulario antes de enviar
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const tema = document.getElementById('tema').value.trim();
        const material = document.getElementById('material').value.trim();
        
        if (tema.length < 5) {
            e.preventDefault();
            alert('El tema debe tener al menos 5 caracteres.');
            document.getElementById('tema').focus();
            return;
        }
        
        if (material.length < 10) {
            e.preventDefault();
            alert('El material debe tener al menos 10 caracteres.');
            document.getElementById('material').focus();
            return;
        }
    });
});
</script>
@endpush

@endsection