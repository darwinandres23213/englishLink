@extends('layouts.AreaInterna.app')
@section('title', $edit ? 'Editar Pago' : 'Nuevo Pago')
@section('content')

<div class="container py-4" style="background: #f8f9fc; min-height: 70vh; border-radius: 12px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">{{ $edit ? 'Editar Pago' : 'Nuevo Pago' }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ $edit ? route('pagos.update', $pago) : route('pagos.store') }}">
                        @csrf
                        @if($edit)
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="matricula_id" class="form-label">Matrícula <span class="text-danger">*</span></label>
                            <select name="matricula_id" id="matricula_id" class="form-select" required>
                                <option value="">Seleccione una matrícula</option>
                                @foreach($matriculas as $matricula)
                                    <option value="{{ $matricula->id_matricula }}"
                                        data-estudiante="{{ $matricula->estudiante->nombre ?? 'N/A' }}"
                                        data-estudiante-id="{{ $matricula->estudiante->id_usuario ?? '' }}"
                                        data-curso="{{ $matricula->curso->nombre_curso ?? 'N/A' }}"
                                        {{ old('matricula_id', $pago->matricula_id) == $matricula->id_matricula ? 'selected' : '' }}>
                                        Matrícula #{{ $matricula->id_matricula }} - {{ $matricula->estudiante->nombre ?? 'N/A' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('matricula_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Información de la matrícula seleccionada -->
                        <div id="infoMatricula" class="mb-3 p-3 bg-light rounded" style="display: none;">
                            <h6 class="mb-2 text-muted">Información de la Matrícula:</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Estudiante:</strong> <span id="estudiante"></span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Curso:</strong> <span id="curso"></span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="monto" class="form-label">Monto <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" name="monto" id="monto" class="form-control" 
                                       value="{{ old('monto', $pago->monto) }}" required>
                            </div>
                            @error('monto')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="fecha_pago" class="form-label">Fecha de Pago <span class="text-danger">*</span></label>
                            <input type="date" name="fecha_pago" id="fecha_pago" class="form-control" 
                                   value="{{ old('fecha_pago', $pago->fecha_pago) }}" required>
                            @error('fecha_pago')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="medio_pago_id" class="form-label">Medio de Pago <span class="text-danger">*</span></label>
                            <select name="medio_pago_id" id="medio_pago_id" class="form-select" required>
                                <option value="">Seleccione un medio de pago</option>
                                @foreach($medios as $medio)
                                    <option value="{{ $medio->id_medio_pago }}" 
                                            {{ old('medio_pago_id', $pago->medio_pago_id) == $medio->id_medio_pago ? 'selected' : '' }}>
                                        {{ $medio->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('medio_pago_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="estado_pago_id" class="form-label">Estado <span class="text-danger">*</span></label>
                            <select name="estado_pago_id" id="estado_pago_id" class="form-select" required>
                                <option value="">Seleccione un estado</option>
                                @foreach($estados as $estado)
                                    <option value="{{ $estado->id_estado }}" 
                                            {{ old('estado_pago_id', $pago->estado_pago_id) == $estado->id_estado ? 'selected' : '' }}>
                                        {{ $estado->nombre_estado }}
                                    </option>
                                @endforeach
                            </select>
                            @error('estado_pago_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Campo oculto para estudiante_id -->
                        <input type="hidden" name="estudiante_id" id="estudiante_id" 
                               value="{{ old('estudiante_id', $pago->estudiante_id) }}">

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('pagos.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> {{ $edit ? 'Actualizar' : 'Crear' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectMatricula = document.getElementById('matricula_id');
        const infoMatricula = document.getElementById('infoMatricula');
        const estudianteSpan = document.getElementById('estudiante');
        const cursoSpan = document.getElementById('curso');
        const estudianteIdInput = document.getElementById('estudiante_id');

        function mostrarInfo() {
            const selected = selectMatricula.options[selectMatricula.selectedIndex];
            
            if (selected.value) {
                const estudiante = selected.getAttribute('data-estudiante') || 'N/A';
                const estudianteId = selected.getAttribute('data-estudiante-id') || '';
                const curso = selected.getAttribute('data-curso') || 'N/A';
                
                estudianteSpan.textContent = estudiante;
                cursoSpan.textContent = curso;
                infoMatricula.style.display = 'block';
                
                // Asignar el ID del estudiante
                estudianteIdInput.value = estudianteId;
                
            } else {
                infoMatricula.style.display = 'none';
                estudianteIdInput.value = '';
            }
        }

        selectMatricula.addEventListener('change', mostrarInfo);

        // Mostrar info al cargar si hay valor seleccionado
        if (selectMatricula.value) {
            mostrarInfo();
        }
    });
</script>

@endsection