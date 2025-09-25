{{-- filepath: resources/views/historial_imagenes/form.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', isset($historial_imagene) ? 'Editar Imagen' : 'Subir Imagen')
@section('content')

<div class="container py-1">
    <div class="card-header bg-transparent text-primary mb-1">
        <h1 class="fw-bold">
            {{ isset($historial_imagene) ? 'Editar Imagen' : 'Subir Imagen' }}
            <i class="bi bi-card-image"></i>
        </h1>
    </div>

    <div class="card-body">
        <form action="{{ isset($historial_imagene) ? route('historial_imagenes.update', $historial_imagene->id) : route('historial_imagenes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($historial_imagene))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="usuario_id" class="form-label">ID Usuario</label>
                <input type="number" name="usuario_id" id="usuario_id" class="form-control" required value="{{ old('usuario_id', $historial_imagene->usuario_id ?? '') }}">
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen</label>
                <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*" @if(!isset($historial_imagene)) required @endif>
                @if(isset($historial_imagene) && $historial_imagene->ruta_imagen)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $historial_imagene->ruta_imagen) }}" alt="Imagen actual" width="120">
                    </div>
                @endif
            </div>

            <div class="d-flex gap-2 justify-content-end py-4">
                <a href="{{ route('historial_imagenes.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i>
                    {{ isset($historial_imagene) ? 'Actualizar' : 'Subir Imagen' }}</button>
            </div>
        </form>
    </div>
</div>
@endsection