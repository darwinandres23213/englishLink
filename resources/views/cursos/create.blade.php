{{-- filepath: resources/views/cursos/create.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', $edit ? 'Editar Curso' : 'Nuevo Curso')
@section('content')

<div class="container py-1">
    <div class="card-header bg-transparent text-primary mb-1">
        <h1 class="fw-bold">
            {{ $edit ? 'Editar Curso' : 'Nuevo Curso' }}
            <i class="bi bi-person-video3"></i>
        </h1>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('cursos.update', $curso) : route('cursos.store') }}">
            @csrf
            @if($edit)
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="nombre_curso" class="form-label">Nombre del Curso <span class="text-danger">*</span></label>
                <input type="text" name="nombre_curso" id="nombre_curso" class="form-control" maxlength="100"
                    value="{{ old('nombre_curso', $curso->nombre_curso ?? '') }}" required>
                @error('nombre_curso')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <input type="text" name="descripcion" id="descripcion" class="form-control" maxlength="255"
                    value="{{ old('descripcion', $curso->descripcion ?? '') }}">
                @error('descripcion')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="nivel_id" class="form-label">Nivel <span class="text-danger">*</span></label>
                <select name="nivel_id" id="nivel_id" class="form-select" required>
                    <option value="">Seleccione un nivel</option>
                    @foreach($niveles as $nivel)
                        <option value="{{ $nivel->id_nivel }}" {{ old('nivel_id', $curso->nivel_id ?? '') == $nivel->id_nivel ? 'selected' : '' }}>
                            {{ $nivel->nombre_nivel }}
                        </option>
                    @endforeach
                </select>
                @error('nivel_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="horario_id" class="form-label">Horario <span class="text-danger">*</span></label>
                <select name="horario_id" id="horario_id" class="form-select" required>
                    <option value="">Seleccione un horario</option>
                    @foreach($horarios as $horario)
                        <option value="{{ $horario->id_horario }}" 
                                {{ old('horario_id', $curso->horario_id ?? '') == $horario->id_horario ? 'selected' : '' }}>
                            {{ $horario->nombre_horario }} -> ({{ \Carbon\Carbon::parse($horario->hora_inicio)->format('g:i A') }} - {{ \Carbon\Carbon::parse($horario->hora_fin)->format('g:i A') }})
                        </option>
                    @endforeach
                </select>
                @error('horario_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="profesor_id" class="form-label">Profesor <span class="text-danger">*</span></label>
                <select name="profesor_id" id="profesor_id" class="form-select @error('profesor_id') is-invalid @enderror" required>
                    <option value="">Seleccione un profesor</option>
                    @foreach($profesores as $profesor)
                        <option value="{{ $profesor->id_usuario }}" 
                                {{ old('profesor_id', $edit ? $curso->profesor_id : '') == $profesor->id_usuario ? 'selected' : '' }}>
                            Id: {{ $profesor->id_usuario }} - {{ $profesor->nombre }} {{ $profesor->apellido }}
                        </option>
                    @endforeach
                </select>
                @error('profesor_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2 justify-content-end py-4">
                <a href="{{ route('cursos.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i>
                    {{ $edit ? 'Actualizar' : 'Crear' }}
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Debug ampliado --}}
{{-- @if($edit && config('app.debug'))
    <div class="container mt-3">
        <div class="alert alert-info">
            <strong>Debug Info:</strong><br>
            Curso ID: {{ $curso->id_curso }}<br>
            Profesor ID guardado: {{ $curso->profesor_id }}<br>
            Profesor asociado: {{ $curso->profesor ? $curso->profesor->nombre . ' ' . $curso->profesor->apellido : 'NULL' }}<br>
            Nivel ID: {{ $curso->nivel_id }}<br>
            Horario ID: {{ $curso->horario_id }}<br>
            <hr>
            <strong>Profesores disponibles:</strong><br>
            @foreach($profesores as $prof)
                ID: {{ $prof->id_usuario }} - {{ $prof->nombre }} {{ $prof->apellido }}<br>
            @endforeach
            <hr>
            <strong>¿Profesor encontrado en lista?</strong> {{ isset($profesorEncontrado) && $profesorEncontrado ? 'SÍ' : 'NO' }}
        </div>
    </div>
@endif --}}

@endsection