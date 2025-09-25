{{-- filepath: resources/views/recuperaciones/create.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', isset($recuperacione) ? 'Editar Recuperación' : 'Nueva Recuperación')
@section('content')

<div class="container py-4" style="background: #f8f9fc; min-height: 70vh; border-radius: 12px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">{{ isset($recuperacione) ? 'Editar Recuperación' : 'Nueva Recuperación' }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ isset($recuperacione) ? route('recuperaciones.update', $recuperacione->id) : route('recuperaciones.store') }}">
                        @csrf
                        @if(isset($recuperacione))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="id_calificacion" class="form-label">Calificación</label>
                            <select name="id_calificacion" id="id_calificacion" class="form-select" required>
                                <option value="">Seleccione una calificación</option>
                                @foreach($calificaciones as $calificacion)
                                    <option value="{{ $calificacion->id }}" {{ old('id_calificacion', $recuperacione->id_calificacion ?? '') == $calificacion->id ? 'selected' : '' }}>
                                        {{ $calificacion->usuario->nombre ?? '' }} - {{ $calificacion->curso->nombre_curso ?? '' }} ({{ $calificacion->calificacion }})
                                    </option>
                                @endforeach
                            </select>
                            @error('id_calificacion')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nota_recuperacion" class="form-label">Nota Recuperación</label>
                            <input type="number" step="0.1" name="nota_recuperacion" id="nota_recuperacion" class="form-control" value="{{ old('nota_recuperacion', $recuperacione->nota_recuperacion ?? '') }}" required>
                            @error('nota_recuperacion')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="fecha_recuperacion" class="form-label">Fecha de Recuperación</label>
                            <input type="date" name="fecha_recuperacion" id="fecha_recuperacion" class="form-control" value="{{ old('fecha_recuperacion', isset($recuperacione) ? \Illuminate\Support\Str::substr($recuperacione->fecha_recuperacion, 0, 10) : '') }}" required>
                            @error('fecha_recuperacion')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="estado_id" class="form-label">Estado</label>
                            <select name="estado_id" id="estado_id" class="form-select" required>
                                <option value="">Seleccione un estado</option>
                                @foreach($estados as $estado)
                                    <option value="{{ $estado->id_estado }}" {{ old('estado_id', $recuperacione->estado_id ?? '') == $estado->id_estado ? 'selected' : '' }}>
                                        {{ $estado->nombre_estado }}
                                    </option>
                                @endforeach
                            </select>
                            @error('estado_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="creado_por" class="form-label">Creado por</label>
                            <input type="text" name="creado_por" id="creado_por" class="form-control" value="{{ old('creado_por', $recuperacione->creado_por ?? '') }}" required>
                            @error('creado_por')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="actualizado_por" class="form-label">Actualizado por</label>
                            <input type="text" name="actualizado_por" id="actualizado_por" class="form-control" value="{{ old('actualizado_por', $recuperacione->actualizado_por ?? '') }}" required>
                            @error('actualizado_por')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="comentarios" class="form-label">Comentarios</label>
                            <textarea name="comentarios" id="comentarios" class="form-control">{{ old('comentarios', $recuperacione->comentarios ?? '') }}</textarea>
                            @error('comentarios')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('recuperaciones.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection