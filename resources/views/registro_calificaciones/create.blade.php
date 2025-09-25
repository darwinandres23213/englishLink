{{-- filepath: resources/views/registro_calificaciones/create.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', isset($registroCalificacione) ? 'Editar Registro' : 'Nuevo Registro')
@section('content')

<div class="container py-4" style="background: #f8f9fc; min-height: 70vh; border-radius: 12px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">{{ isset($registroCalificacione) ? 'Editar Registro' : 'Nuevo Registro' }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ isset($registroCalificacione) ? route('registro_calificaciones.update', $registroCalificacione->id) : route('registro_calificaciones.store') }}">
                        @csrf
                        @if(isset($registroCalificacione))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="usuario_id" class="form-label">Estudiante</label>
                            <select name="usuario_id" id="usuario_id" class="form-select" required>
                                <option value="">Seleccione un estudiante</option>
                                @foreach($usuarios as $usuario)
                                    <option value="{{ $usuario->id_usuario }}" {{ old('usuario_id', $registroCalificacione->usuario_id ?? '') == $usuario->id_usuario ? 'selected' : '' }}>
                                        {{ $usuario->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('usuario_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="curso_id" class="form-label">Curso</label>
                            <select name="curso_id" id="curso_id" class="form-select" required>
                                <option value="">Seleccione un curso</option>
                                @foreach($cursos as $curso)
                                    <option value="{{ $curso->id_curso }}" {{ old('curso_id', $registroCalificacione->curso_id ?? '') == $curso->id_curso ? 'selected' : '' }}>
                                        {{ $curso->nombre_curso }}
                                    </option>
                                @endforeach
                            </select>
                            @error('curso_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="calificacion" class="form-label">Calificación</label>
                            <input type="number" step="0.1" name="calificacion" id="calificacion" class="form-control" value="{{ old('calificacion', $registroCalificacione->calificacion ?? '') }}" required>
                            @error('calificacion')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="retroalimentacion" class="form-label">Retroalimentación</label>
                            <textarea name="retroalimentacion" id="retroalimentacion" class="form-control">{{ old('retroalimentacion', $registroCalificacione->retroalimentacion ?? '') }}</textarea>
                            @error('retroalimentacion')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="fecha_registro" class="form-label">Fecha de Registro</label>
                            <input type="date" name="fecha_registro" id="fecha_registro" class="form-control" value="{{ old('fecha_registro', isset($registroCalificacione) ? \Illuminate\Support\Str::substr($registroCalificacione->fecha_registro, 0, 10) : '') }}" required>
                            @error('fecha_registro')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="pendiente_recuperacion" class="form-label">¿Pendiente de Recuperación?</label>
                            <select name="pendiente_recuperacion" id="pendiente_recuperacion" class="form-select" required>
                                <option value="1" {{ old('pendiente_recuperacion', $registroCalificacione->pendiente_recuperacion ?? '') == 1 ? 'selected' : '' }}>Sí</option>
                                <option value="0" {{ old('pendiente_recuperacion', $registroCalificacione->pendiente_recuperacion ?? '') == 0 ? 'selected' : '' }}>No</option>
                            </select>
                            @error('pendiente_recuperacion')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="creado_por" class="form-label">Creado por</label>
                            <input type="text" name="creado_por" id="creado_por" class="form-control" value="{{ old('creado_por', $registroCalificacione->creado_por ?? '') }}" required>
                            @error('creado_por')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="actualizado_por" class="form-label">Actualizado por</label>
                            <input type="text" name="actualizado_por" id="actualizado_por" class="form-control" value="{{ old('actualizado_por', $registroCalificacione->actualizado_por ?? '') }}" required>
                            @error('actualizado_por')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="estado_id" class="form-label">Estado</label>
                            <select name="estado_id" id="estado_id" class="form-select" required>
                                <option value="">Seleccione un estado</option>
                                @foreach($estados as $estado)
                                    <option value="{{ $estado->id_estado }}" {{ old('estado_id', $registroCalificacione->estado_id ?? '') == $estado->id_estado ? 'selected' : '' }}>
                                        {{ $estado->nombre_estado }}
                                    </option>
                                @endforeach
                            </select>
                            @error('estado_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('registro_calificaciones.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection