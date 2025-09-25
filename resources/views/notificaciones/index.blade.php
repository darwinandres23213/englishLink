{{-- filepath: resources/views/notificaciones/index.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', 'Notificaciones')
@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="container py-4" style="background: #f8f9fc; min-height: 70vh; border-radius: 12px;">
    <h1 class="mb-4 fw-bold">Notificaciones</h1>
    <div class="mb-3">
        <a href="{{ route('notificaciones.create') }}" class="btn btn-primary">Nueva Notificación</a>
    </div>
    <div class="table-responsive rounded shadow-sm" style="background: #fff;">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Mensaje</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Fecha Envío</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($notificaciones as $notificacion)
                    <tr>
                        <td>{{ $notificacion->id }}</td>
                        <td>{{ $notificacion->usuario->nombre ?? $notificacion->usuario_id }}</td>
                        <td>{{ Str::limit($notificacion->mensaje, 40) }}</td>
                        <td>{{ $notificacion->tipo }}</td>
                        <td>{{ $notificacion->estado->nombre_estado ?? $notificacion->estado_id }}</td>
                        <td>{{ $notificacion->fecha_envio }}</td>
                        <td>
                            <a href="{{ route('notificaciones.edit', $notificacion->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('notificaciones.destroy', $notificacion->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar notificación?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row mt-3">
        <div class="col-md-12 text-end">
            {{ $notificaciones->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection