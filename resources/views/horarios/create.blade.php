{{-- filepath: resources/views/horarios/create.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', isset($horario) ? 'Editar Horario' : 'Nuevo Horario')
@section('content')

<div class="container py-1">
    <div class="card-header bg-transparent text-primary mb-1">
        <h1 class="fw-bold">
            {{ isset($horario) ? 'Editar Horario' : 'Nuevo Horario' }}
            <i class="bi bi-calendar3"></i>
        </h1>
    </div>

    
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('horarios.update', $horario) : route('horarios.store') }}">
            @csrf
            @if($edit)
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="nombre_horario" class="form-label">Nombre del Horario <span class="text-danger">*</span></label>
                <input type="text"
                        name="nombre_horario" 
                        id="nombre_horario" 
                        class="form-control @error('nombre_horario') is-invalid @enderror" 
                        value="{{ old('nombre_horario', $edit ? $horario->nombre_horario : '') }}" 
                        required 
                        maxlength="50"
                        placeholder="Ej: Mañana, Tarde, Noche">
                @error('nombre_horario')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="hora_inicio" class="form-label">Hora de Inicio <span class="text-danger">*</span></label>
                <input type="time" 
                        name="hora_inicio" 
                        id="hora_inicio" 
                        class="form-control @error('hora_inicio') is-invalid @enderror" 
                        {{-- value="{{ old('hora_inicio', $edit ? \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') : '') }}" --}}
                        value="{{ old('hora_inicio', $edit ? $horario->hora_inicio : '') }}" 
                        required>
                @error('hora_inicio')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="hora_fin" class="form-label">Hora de Fin <span class="text-danger">*</span></label>
                <input type="time" 
                        name="hora_fin" 
                        id="hora_fin" 
                        class="form-control @error('hora_fin') is-invalid @enderror" 
                        {{-- value="{{ old('hora_fin', $edit ? \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') : '') }}" --}}
                        value="{{ old('hora_fin', $edit ? $horario->hora_fin : '') }}"
                        required>
                @error('hora_fin')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">La hora de fin debe ser posterior a la hora de inicio.</div>
            </div>

            <div class="d-flex gap-2 justify-content-end py-4">
                <a href="{{ route('horarios.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i>
                    {{ $edit ? 'Actualizar Horario' : 'Crear Horario' }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const horaInicio = document.getElementById('hora_inicio');
    const horaFin = document.getElementById('hora_fin');
    
    function validarHoras() {
        if (horaInicio.value && horaFin.value) {
            if (horaInicio.value >= horaFin.value) {
                horaFin.setCustomValidity('La hora de fin debe ser posterior a la hora de inicio');
            } else {
                horaFin.setCustomValidity('');
            }
        }
    }
    
    horaInicio.addEventListener('change', validarHoras);
    horaFin.addEventListener('change', validarHoras);
});
</script>

@endsection