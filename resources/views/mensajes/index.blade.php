{{-- filepath: resources/views/mensajes/index.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', 'Mensajes')
@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="container py-4">
    <h1 class="mb-4">Mensajes</h1>
    <a href="{{ route('mensajes.create') }}" class="btn btn-primary mb-3">Nuevo Mensaje</a>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Remitente</th>
                    <th>Destinatario</th>
                    <th>Contenido</th>
                    <th>Fecha Envío</th>
                    <th>Leído</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mensajes as $mensaje)
                    <tr>
                        <td>{{ $mensaje->id }}</td>
                        <td>{{ $mensaje->remitente->nombre ?? 'N/A' }}</td>
                        <td>{{ $mensaje->destinatario->nombre ?? 'N/A' }}</td>
                        <td>{{ Str::limit($mensaje->contenido, 50) }}</td>
                        <td>{{ $mensaje->fecha_envio }}</td>
                        <td>{{ $mensaje->leido ? 'Sí' : 'No' }}</td>
                        <td>
                            <a href="{{ route('mensajes.show', $mensaje) }}" class="btn btn-info btn-sm">Ver</a>
                            <a href="{{ route('mensajes.edit', $mensaje) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('mensajes.destroy', $mensaje) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este mensaje?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if($mensajes->isEmpty())
                    <tr>
                        <td colspan="7" class="text-center">No hay mensajes.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="row mt-3">
        <div class="col-md-12 text-end">
            {{ $mensajes->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection