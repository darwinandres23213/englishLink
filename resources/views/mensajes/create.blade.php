{{-- filepath: resources/views/mensajes/create.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', 'Nuevo Mensaje')
@section('content')

<div class="container py-4">
    <h1>Nuevo Mensaje</h1>
    <form method="POST" action="{{ route('mensajes.store') }}">
        @csrf
        <div class="mb-3">
            <label for="remitente_id" class="form-label">Remitente</label>
            <select name="remitente_id" id="remitente_id" class="form-select" required>
                <option value="">Seleccione</option>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id_usuario }}">{{ $usuario->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="destinatario_id" class="form-label">Destinatario</label>
            <select name="destinatario_id" id="destinatario_id" class="form-select" required>
                <option value="">Seleccione</option>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id_usuario }}">{{ $usuario->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="contenido" class="form-label">Contenido</label>
            <textarea name="contenido" id="contenido" class="form-control" required>{{ old('contenido') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
        <a href="{{ route('mensajes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection