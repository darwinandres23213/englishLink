{{-- filepath: resources/views/niveles/create.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', $edit ? 'Editar Nivel' : 'Nuevo Nivel')
@section('content')

<div class="container py-1">
    <div class="card-header bg-transparent text-primary mb-1">
        <h1 class="mb-0 fw-bold">
            {{ $edit ? 'Editar Nivel' : 'Nuevo Nivel' }}
            <i class="bi bi-ladder"></i>
        </h1>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('niveles.update', $nivel) : route('niveles.store') }}">
            @csrf
            @if($edit)
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="nombre_nivel" class="form-label">Nombre del Nivel <span class="text-danger">*</span></label>
                <input type="text" name="nombre_nivel" id="nombre_nivel" class="form-control" maxlength="50"
                    value="{{ old('nombre_nivel', $nivel->nombre_nivel ?? '') }}" required>
                @error('nombre_nivel')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2 justify-content-end py-4">
                {{-- Botones de acción --}}
                <a href="{{ route('niveles.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left">
                        Cancelar
                    </i>
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i>
                    {{ $edit ? 'Actualizar' : 'Crear' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection