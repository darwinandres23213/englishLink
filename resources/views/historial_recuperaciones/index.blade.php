{{-- filepath: resources/views/historial_recuperaciones/index.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', 'Historial de Recuperaciones')
@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="container py-4" style="background: #f8f9fc; min-height: 70vh; border-radius: 12px;">
    <h1 class="mb-4 fw-bold">Historial de Recuperaciones</h1>
    <div class="mb-3">
        <a href="{{ route('historial_recuperaciones.create') }}" class="btn btn-primary">Nuevo Historial</a>
    </div>
    <div class="table-responsive rounded shadow-sm" style="background: #fff;">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Recuperación</th>
                    <th>Nota Anterior</th>
                    <th>Nota Nueva</th>
                    <th>Fecha de Cambio</th>
                    <th>Modificado por</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($historiales as $historial)
                    <tr>
                        <td>{{ $historial->id }}</td>
                        <td>{{ $historial->recuperacion->id ?? $historial->id_recuperacion }}</td>
                        <td>{{ $historial->nota_anterior }}</td>
                        <td>{{ $historial->nota_nueva }}</td>
                        <td>{{ $historial->fecha_cambio }}</td>
                        <td>{{ $historial->modificado_por }}</td>
                        <td>
                            <a href="{{ route('historial_recuperaciones.edit', $historial->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('historial_recuperaciones.destroy', $historial->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar historial?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="row mt-3">
        <div class="col-md-12 text-end">
            {{ $historiales->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection