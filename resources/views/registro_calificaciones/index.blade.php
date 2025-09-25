{{-- filepath: resources/views/registro_calificaciones/index.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', 'Registro de Calificaciones')
@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="container py-4" style="background: #f8f9fc; min-height: 70vh; border-radius: 12px;">
    <h1 class="mb-4 fw-bold">Registro de Calificaciones</h1>
    <div class="mb-3">
        <a href="{{ route('registro_calificaciones.create') }}" class="btn btn-primary">Nuevo Registro</a>
    </div>
    <div class="table-responsive rounded shadow-sm" style="background: #fff;">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Estudiante</th>
                    <th>Curso</th>
                    <th>Calificación</th>
                    <th>Fecha</th>
                    <th>Pendiente Recuperación</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($registros as $registro)
                    <tr>
                        <td>{{ $registro->id }}</td>
                        <td>{{ $registro->usuario->nombre ?? $registro->usuario_id }}</td>
                        <td>{{ $registro->curso->nombre_curso ?? $registro->curso_id }}</td>
                        <td>{{ $registro->calificacion }}</td>
                        <td>{{ $registro->fecha_registro }}</td>
                        <td>
                            @if($registro->pendiente_recuperacion)
                                <span class="badge bg-warning">Sí</span>
                            @else
                                <span class="badge bg-success">No</span>
                            @endif
                        </td>
                        <td>{{ $registro->estado->nombre_estado ?? $registro->estado_id }}</td>
                        <td>
                            <a href="{{ route('registro_calificaciones.edit', $registro->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('registro_calificaciones.destroy', $registro->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar registro?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="row mt-3">
        <div class="col-md-12 text-end">
            {{ $registros->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection