{{-- filepath: resources/views/estados/index.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', 'Estados')
@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="container py-4" style="background: #f8f9fc; min-height: 70vh; border-radius: 12px;">
    <h1 class="mb-4 fw-bold">Estados</h1>

    {{-- Botón para crear nuevo estado --}}
    <div class="mb-3">
        <a href="{{ route('estados.create') }}" class="btn btn-primary">Nuevo Estado</a>
    </div>

    {{-- Filtros desplegables --}}


    {{-- Tabla de Estados --}}
    <div class="table-responsive rounded shadow-sm" style="background: #fff;">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr class="text-center">
                    <th>ID</th>
                    <th>Estado para modulo</th>
                    <th>Nombre del Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($estados as $estado)
                    <tr class="text-center">
                        <td>{{ $estado->id_estado }}</td>
                        <td>{{ $estado->tipoEstado->nombre_tipo_estado ?? 'N/A' }}</td>
                        <td>
                            {{-- Estado del usuario con badge --}}
                            <span class="badge 
                                @switch($estado->nombre_estado ?? '')
                                    @case('Activo')
                                        bg-success
                                        @break
                                    @case('Inactivo')
                                        bg-secondary
                                        @break
                                    @case('Suspendido')
                                        bg-danger
                                        @break
                                    @case('Pendiente')
                                        bg-warning
                                        @break
                                    @default
                                        bg-secondary
                                @endswitch
                            " style="min-width: 80px; display: inline-block; text-align: center;">
                                {{ $estado->nombre_estado }}
                            </span>
                        </td>
                        
                        <td>
                            <a href="{{ route('estados.edit', $estado) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil" title="Editar Estado"></i>
                            </a>
                            <form action="{{ route('estados.destroy', $estado) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar este estado?')">
                                    <i class="bi bi-trash" title="Eliminar Estado"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if($estados->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center">No hay estados registrados.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="row mt-3">
        <div class="col-md-12 text-end">
            {{ $estados->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection