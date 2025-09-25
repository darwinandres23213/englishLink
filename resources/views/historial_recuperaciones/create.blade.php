{{-- filepath: resources/views/historial_recuperaciones/create.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', isset($historialRecuperacione) ? 'Editar Historial' : 'Nuevo Historial')
@section('content')

<div class="container py-4" style="background: #f8f9fc; min-height: 70vh; border-radius: 12px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">{{ isset($historialRecuperacione) ? 'Editar Historial' : 'Nuevo Historial' }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ isset($historialRecuperacione) ? route('historial_recuperaciones.update', $historialRecuperacione->id) : route('historial_recuperaciones.store') }}">
                        @csrf
                        @if(isset($historialRecuperacione))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="id_recuperacion" class="form-label">Recuperación</label>
                            <select name="id_recuperacion" id="id_recuperacion" class="form-select" required>
                                <option value="">Seleccione una recuperación</option>
                                @foreach($recuperaciones as $recuperacion)
                                    <option value="{{ $recuperacion->id }}" {{ old('id_recuperacion', $historialRecuperacione->id_recuperacion ?? '') == $recuperacion->id ? 'selected' : '' }}>
                                        {{ $recuperacion->id }} - {{ $recuperacion->nota_recuperacion }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_recuperacion')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nota_anterior" class="form-label">Nota Anterior</label>
                            <input type="number" step="0.1" name="nota_anterior" id="nota_anterior" class="form-control" value="{{ old('nota_anterior', $historialRecuperacione->nota_anterior ?? '') }}" required>
                            @error('nota_anterior')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nota_nueva" class="form-label">Nota Nueva</label>
                            <input type="number" step="0.1" name="nota_nueva" id="nota_nueva" class="form-control" value="{{ old('nota_nueva', $historialRecuperacione->nota_nueva ?? '') }}" required>
                            @error('nota_nueva')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="fecha_cambio" class="form-label">Fecha de Cambio</label>
                            <input type="date" name="fecha_cambio" id="fecha_cambio" class="form-control" value="{{ old('fecha_cambio', isset($historialRecuperacione) ? \Illuminate\Support\Str::substr($historialRecuperacione->fecha_cambio, 0, 10) : '') }}" required>
                            @error('fecha_cambio')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="modificado_por" class="form-label">Modificado por</label>
                            <input type="text" name="modificado_por" id="modificado_por" class="form-control" value="{{ old('modificado_por', $historialRecuperacione->modificado_por ?? '') }}" required>
                            @error('modificado_por')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('historial_recuperaciones.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection