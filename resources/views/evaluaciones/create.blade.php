{{-- filepath: resources/views/evaluaciones/create.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', isset($evaluacione) ? 'Editar Evaluación' : 'Nueva Evaluación')
@section('content')

<div class="container py-4" style="background: #f8f9fc; min-height: 70vh; border-radius: 12px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">{{ isset($evaluacione) ? 'Editar Evaluación' : 'Nueva Evaluación' }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ isset($evaluacione) ? route('evaluaciones.update', $evaluacione) : route('evaluaciones.store') }}">
                        @csrf
                        @if(isset($evaluacione))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="curso_id" class="form-label">Curso</label>
                            <select name="curso_id" id="curso_id" class="form-select" required>
                                <option value="">Seleccione un curso</option>
                                @foreach($cursos as $curso)
                                    <option value="{{ $curso->id_curso }}" {{ old('curso_id', $evaluacione->curso_id ?? '') == $curso->id_curso ? 'selected' : '' }}>
                                        {{ $curso->nombre_curso }}
                                    </option>
                                @endforeach
                            </select>
                            @error('curso_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo', $evaluacione->titulo ?? '') }}" required>
                            @error('titulo')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('evaluaciones.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection