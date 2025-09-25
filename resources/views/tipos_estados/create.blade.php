{{-- filepath: resources/views/tipos_estados/create.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', $edit ? 'Editar Tipo de Estado' : 'Nuevo Tipo de Estado')
@section('content')

<div class="container py-1">
    <div class="card-header bg-transparent text-primary mb-1">
        <h1 class="fw-bold">
            {{ $edit ? 'Editar Tipo de Estado' : 'Nuevo Tipo de Estado' }}
            <i class="bi bi-cloud-upload"></i>
        </h1>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('tipos_estados.update', $tipo) : route('tipos_estados.store') }}">
            @csrf
            @if($edit)
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="nombre_tipo_estado" class="form-label">Nombre del Tipo de Estado (Modulo) <span class="text-danger">*</span></label>
                <input type="text" name="nombre_tipo_estado" id="nombre_tipo_estado" class="form-control" maxlength="50"
                    value="{{ old('nombre_tipo_estado', $tipo->nombre_tipo_estado ?? '') }}" required>
                @error('nombre_tipo_estado')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-flex gap-2 justify-content-end py-4">
                <a href="{{ route('tipos_estados.index') }}" class="btn btn-secondary">
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