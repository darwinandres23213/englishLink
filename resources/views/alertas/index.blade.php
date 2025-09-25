{{-- filepath: resources/views/alertas/index.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', 'Alertas')
@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="container py-4" style="background: #f8f9fc; min-height: 70vh; border-radius: 12px;">
    <h1 class="mb-4 fw-bold">Alertas</h1>

    <div class="mb-3">
        <a href="{{ route('alertas.create') }}" class="btn btn-primary">Nueva Alerta</a>
    </div>

    <div class="table-responsive rounded shadow-sm" style="background: #fff;">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Hora</th>
                    <th>Tipo</th>
                    <th>Mensaje</th>
                    <th>Estado</th>
                    <th class="text-center">Fecha Creación</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($alertas as $alerta)
                    <tr>
                        <td>{{ $alerta->id }}</td>
                        <td>{{ $alerta->usuario->nombre ?? $alerta->usuario_id }}</td>
                        <td>{{ $alerta->hora_alerta }}</td>
                        <td>{{ $alerta->tipo_alerta }}</td>
                        <td>{{ Str::limit($alerta->mensaje, 40) }}</td>
                        <td class="text-center">
                            {{-- Estado de alerta --}}
                            <span class="badge 
                                @switch($alerta->estado->nombre_estado ?? '') 
                                    @case('Leída')
                                        bg-success
                                        @break
                                    @case('Nueva')
                                        bg-warning
                                        @break
                                    {{-- @case('Vencido')
                                        bg-danger
                                        @break --}}
                                    @case('Archivada')
                                        bg-secondary
                                        @break
                                    @default
                                        bg-secondary
                                @endswitch
                            " style="min-width: 80px; display: inline-block; text-align: center;">
                                {{ $alerta->estado->nombre_estado ?? 'N/A' }}
                            </span>
                            {{-- $alerta->estado->nombre_estado ?? $alerta->estado_id --}}
                        </td>
                        <td class="text-center">{{ $alerta->fecha_creacion }}</td>
                        
                        <td class="text-center">
                            {{-- Botones de acción --}}
                            <a href="{{ route('alertas.edit', $alerta->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil" title="Editar alerta"></i>
                            </a>
                            <form action="{{ route('alertas.destroy', $alerta->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar alerta?')">
                                    <i class="bi bi-trash" title="Eliminar alerta"></i>

                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row mt-3">
        <div class="col-md-12 text-end">
            {{ $alertas->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection