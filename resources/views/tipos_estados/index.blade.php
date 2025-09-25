{{-- filepath: resources/views/tipos_estados/index.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', 'Tipos de Estado')
@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="container py-4" style="background: #f8f9fc; min-height: 70vh; border-radius: 12px;">
    <h1 class="mb-4 fw-bold">Tipos de Estado</h1>

    {{-- Botón para crear nuevo tipo de estado (para un Módulo) --}}
    <div class="mb-3">
        <a href="{{ route('tipos_estados.create') }}" class="btn btn-primary">Nuevo Tipo de Estado</a>
    </div>

    {{-- Tabla de tipos de estado --}}
    <div class="table-responsive rounded shadow-sm" style="background: #fff;">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr class="text-center">
                    <th>ID</th>
                    <th>Nombre del Modulo o Area</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tipos_estados as $tipo)
                    <tr class="text-center">
                        <td>{{ $tipo->id_tipo_estado }}</td>
                        <td>{{ $tipo->nombre_tipo_estado }}</td>
                        <td>
                            <a href="{{ route('tipos_estados.edit', $tipo) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil" title="Editar Tipo de Estado"></i>
                            </a>
                            <form action="{{ route('tipos_estados.destroy', $tipo) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar este tipo de estado?')">
                                    <i class="bi bi-trash" title="Eliminar Tipo de Estado"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if($tipos_estados->isEmpty())
                    <tr>
                        <td colspan="3" class="text-center">No hay tipos de estado registrados.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
     <div class="row mt-3">
        <div class="col-md-12 text-end">
            {{ $tipos_estados->links('pagination::bootstrap-5') }}
        </div>
    </div>
    
</div>
@endsection