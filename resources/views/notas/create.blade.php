{{-- filepath: resources/views/notas/create.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', isset($nota) && $nota->exists ? 'Editar Nota' : 'Nueva Nota')
@section('content')

<div class="container py-4" style="background: #f8f9fc; min-height: 70vh; border-radius: 12px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">{{ isset($nota) && $nota->exists ? 'Editar Nota' : 'Nueva Nota' }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ isset($nota) && $nota->exists ? route('notas.update', $nota) : route('notas.store') }}">
                        @csrf
                        @if(isset($nota) && $nota->exists)
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="evaluacion_id" class="form-label">Evaluación</label>
                            <input type="number" name="evaluacion_id" id="evaluacion_id" class="form-control" value="{{ old('evaluacion_id', $nota->evaluacion_id ?? '') }}" required>
                            @error('evaluacion_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="estudiante_id" class="form-label">Estudiante</label>
                            <input type="number" name="estudiante_id" id="estudiante_id" class="form-control" value="{{ old('estudiante_id', $nota->estudiante_id ?? '') }}" required>
                            @error('estudiante_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="calificacion" class="form-label">Calificación</label>
                            <input type="number" step="0.01" name="calificacion" id="calificacion" class="form-control" value="{{ old('calificacion', $nota->calificacion ?? '') }}" required>
                            @error('calificacion')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('notas.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection