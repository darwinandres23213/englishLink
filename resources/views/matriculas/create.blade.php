{{-- filepath: resources/views/matriculas/create.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', $edit ? 'Editar Matrícula' : 'Nueva Matrícula')
@section('content')

<div class="container py-1">
    <div class="card-header bg-transparent text-primary mb-1">
        <h1 class="fw-bold">
            {{ $edit ? 'Editar Matrícula' : 'Nueva Matrícula' }}
            <i class="fas fa-user-graduate"></i>
        </h1>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('matriculas.update', $matricula->id_matricula) : route('matriculas.store') }}">
            @csrf
            @if($edit)
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="estudiante_id" class="form-label">Estudiante <span class="text-danger">*</span></label>
                <select name="estudiante_id" id="estudiante_id" class="form-select @error('estudiante_id') is-invalid @enderror" required>
                    <option value="">Seleccione un estudiante</option>
                    @foreach($estudiantes as $estudiante)
                        <option value="{{ $estudiante->id_usuario }}" 
                                {{ old('estudiante_id', $matricula->estudiante_id ?? '') == $estudiante->id_usuario ? 'selected' : '' }}>
                            ID: {{ $estudiante->id_usuario }} - {{ $estudiante->nombre }} {{ $estudiante->apellido }}
                            @if($estudiante->email)
                                ({{ $estudiante->email }})
                            @endif
                        </option>
                    @endforeach
                </select>
                @error('estudiante_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">
                    <i class="fas fa-info-circle me-1"></i>
                    Selecciona el estudiante que será matriculado en el curso
                </div>
            </div>

            <div class="mb-3">
                <label for="curso_id" class="form-label">Curso <span class="text-danger">*</span></label>
                <select name="curso_id" id="curso_id" class="form-select @error('curso_id') is-invalid @enderror" required>
                    <option value="">Seleccione un curso</option>
                    @foreach($cursos as $curso)
                        <option value="{{ $curso->id_curso }}" 
                                {{ old('curso_id', $matricula->curso_id ?? '') == $curso->id_curso ? 'selected' : '' }}
                                data-nivel="{{ $curso->nivel->nombre_nivel ?? 'N/A' }}"
                                data-profesor="{{ $curso->profesor->nombre ?? 'N/A' }} {{ $curso->profesor->apellido ?? '' }}">
                            {{ $curso->nombre_curso }}
                            @if($curso->nivel)
                                - {{ $curso->nivel->nombre_nivel }}
                            @endif
                            @if($curso->profesor)
                                (Prof: {{ $curso->profesor->nombre }} {{ $curso->profesor->apellido }})
                            @endif
                        </option>
                    @endforeach
                </select>
                @error('curso_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">
                    <i class="fas fa-info-circle me-1"></i>
                    Selecciona el curso en el que se matriculará el estudiante
                </div>
            </div>

            <div class="mb-3">
                <label for="fecha_matricula" class="form-label">Fecha de Matrícula <span class="text-danger">*</span></label>
                <input type="date" name="fecha_matricula" id="fecha_matricula" 
                       class="form-control @error('fecha_matricula') is-invalid @enderror"
                       value="{{ old('fecha_matricula', $matricula->fecha_matricula ?? now()->format('Y-m-d')) }}" 
                       max="{{ now()->format('Y-m-d') }}" required>
                @error('fecha_matricula')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">
                    <i class="fas fa-calendar me-1"></i>
                    Fecha en la que el estudiante se matriculó (no puede ser futura)
                </div>
            </div>

            <!-- Información adicional del curso seleccionado -->
            <div id="curso-info" class="mb-3" style="display: none;">
                <div class="card bg-light">
                    <div class="card-body">
                        <h6 class="card-title">
                            <i class="fas fa-info-circle me-2"></i>Información del Curso Seleccionado
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Nivel:</strong> <span id="curso-nivel">-</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Profesor:</strong> <span id="curso-profesor">-</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 justify-content-end py-4">
                <a href="{{ route('matriculas.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>
                    {{ $edit ? 'Actualizar Matrícula' : 'Crear Matrícula' }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cursoSelect = document.getElementById('curso_id');
    const cursoInfo = document.getElementById('curso-info');
    const cursoNivel = document.getElementById('curso-nivel');
    const cursoProfesor = document.getElementById('curso-profesor');
    const fechaInput = document.getElementById('fecha_matricula');

    // Mostrar información del curso al seleccionar
    cursoSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (this.value) {
            const nivel = selectedOption.getAttribute('data-nivel') || 'N/A';
            const profesor = selectedOption.getAttribute('data-profesor') || 'N/A';
            
            cursoNivel.textContent = nivel;
            cursoProfesor.textContent = profesor;
            cursoInfo.style.display = 'block';
        } else {
            cursoInfo.style.display = 'none';
        }
    });

    // Validar fecha (no puede ser futura)
    fechaInput.addEventListener('change', function() {
        const fechaSeleccionada = new Date(this.value);
        const hoy = new Date();
        hoy.setHours(0, 0, 0, 0);
        
        if (fechaSeleccionada > hoy) {
            alert('La fecha de matrícula no puede ser posterior a la fecha actual.');
            this.value = new Date().toISOString().split('T')[0];
        }
    });

    // Mostrar información del curso si ya hay uno seleccionado (modo edición)
    if (cursoSelect.value) {
        cursoSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection