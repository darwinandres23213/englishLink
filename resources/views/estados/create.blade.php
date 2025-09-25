{{-- filepath: resources/views/estados/create.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', $edit ? 'Editar Estado' : 'Nuevo Estado')
@section('content')

<div class="container py-1">
    <div class="card-header bg-transparent text-primary mb-1">
        <h1 class="fw-bold">
            {{ $edit ? 'Editar Estado' : 'Nuevo Estado' }}
            <i class="bi bi-cloud-upload"></i>
        </h1>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('estados.update', $estado) : route('estados.store') }}">
            @csrf
            @if($edit)
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="id_tipo_estado" class="form-label">Tipo de Estado <span class="text-danger">*</span></label>
                <select name="id_tipo_estado" id="id_tipo_estado" class="form-select" required>
                    <option value="">Seleccione el *módulo* que va a utilizar el estado</option>
                    @foreach($tipos_estados as $tipo)
                        <option value="{{ $tipo->id_tipo_estado }}" {{ old('id_tipo_estado', $estado->id_tipo_estado ?? '') == $tipo->id_tipo_estado ? 'selected' : '' }}>
                            {{ $tipo->nombre_tipo_estado }}
                        </option>
                    @endforeach
                </select>
                @error('id_tipo_estado')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="nombre_estado" class="form-label">Nombre del Estado <span class="text-danger">*</span></label>
                <input type="text" name="nombre_estado" id="nombre_estado" class="form-control" maxlength="50"
                    value="{{ old('nombre_estado', $estado->nombre_estado ?? '') }}" required>
                @error('nombre_estado')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2 justify-content-end py-4">
                <a href="{{ route('estados.index') }}" class="btn btn-secondary">
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