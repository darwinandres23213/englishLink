{{-- filepath: resources/views/recuperaciones/index.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', 'Recuperaciones')
@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="container py-4" style="background: #f8f9fc; min-height: 70vh; border-radius: 12px;">
    <h1 class="mb-4 fw-bold">Recuperaciones</h1>
    <div class="mb-3">
        <a href="{{ route('recuperaciones.create') }}" class="btn btn-primary">Nueva Recuperación</a>
    </div>
    <div class="table-responsive rounded shadow-sm" style="background: #fff;">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Calificación</th>
                    <th>Nota Recuperación</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recuperaciones as $recuperacion)
                    <tr>
                        <td>{{ $recuperacion->id }}</td>
                        <td>{{ $recuperacion->registroCalificacion->calificacion ?? $recuperacion->id_calificacion }}</td>
                        <td>{{ $recuperacion->nota_recuperacion }}</td>
                        <td>{{ $recuperacion->fecha_recuperacion }}</td>
                        <td>{{ $recuperacion->estado->nombre_estado ?? $recuperacion->estado_id }}</td>
                        <td>
                            <a href="{{ route('recuperaciones.edit', $recuperacion->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('recuperaciones.destroy', $recuperacion->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar recuperación?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row mt-3">
        <div class="col-md-12 text-end">
            {{ $recuperaciones->links('pagination::bootstrap-5') }}
        </div>
    </div>
        
</div>
@endsection