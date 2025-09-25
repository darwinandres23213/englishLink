{{-- filepath: resources/views/registro_actividades/index.blade.php --}}

@extends('layouts.AreaInterna.app')

@section('title', 'Registro de Actividades')

@section('content')
@if(session('success'))
    <div id="toast-success" style="background: #fff;"> {{-- Puedes conservar el mismo estilo del toast que ya tienes --}} </div>
    <script>
        // mismo script de notificación
    </script>
@endif

<div class="container py-4">
    <h1 class="mb-4 fw-bold">Registro de Actividades</h1>

    <div class="mb-3">
        <a href="{{ route('registro_actividades.create') }}" class="btn btn-primary">Nueva Actividad</a>
    </div>

    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Filtros</span>
            <button class="btn btn-link text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#filtrosCollapse">
                <i class="bi bi-funnel">Mostrar/Ocultar</i>
            </button>
        </div>
        <div class="collapse show" id="filtrosCollapse">
            <div class="card-body">
                <form method="GET" action="{{ route('registro_actividades.index') }}" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Usuario</label>
                        <input type="text" name="usuario" class="form-control" placeholder="Nombre o ID..." value="{{ request('usuario') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">IP Origen</label>
                        <input type="text" name="ip_origen" class="form-control" value="{{ request('ip_origen') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Fecha desde</label>
                        <input type="date" name="fecha_inicio" class="form-control" value="{{ request('fecha_inicio') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Fecha hasta</label>
                        <input type="date" name="fecha_fin" class="form-control" value="{{ request('fecha_fin') }}">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">Consultar</button>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('registro_actividades.export.pdf', request()->all()) }}" class="btn btn-danger w-100">Descargar PDF</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="table-responsive rounded shadow-sm bg-white">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Acción</th>
                    <th>Fecha y Hora</th>
                    <th>IP Origen</th>
                    <th>Módulo Afectado</th>
                    <th>Curso</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($actividades as $actividad)
                    <tr>
                        <td>{{ $actividad->id }}</td>
                        <td>{{ $actividad->usuario->nombre ?? 'N/A' }}</td>
                        <td>{{ $actividad->accion }}</td>
                        <td>{{ $actividad->fecha_hora }}</td>
                        <td>{{ $actividad->ip_origen }}</td>
                        <td>{{ $actividad->modulo_afectado }}</td>
                        <td>{{ $actividad->curso->nombre_curso ?? 'N/A' }}</td>
                        <td>{{ $actividad->descripcion }}</td>
                        <td>
                            <a href="{{ route('registro_actividades.edit', $actividad) }}" class="text-primary fw-bold me-2">Editar</a>
                            <form action="{{ route('registro_actividades.destroy', $actividad) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link text-danger fw-bold p-0 m-0 align-baseline" onclick="return confirm('¿Eliminar este registro?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row mt-3">
        <div class="col-md-12 text-end">
            {{ $actividades->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection

@endsection





<!--<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Pagos</title>
    <link rel="stylesheet" href="{{ asset('css/pagos.css') }}">
</head>
<body>
<div class="container">
    <h1>Lista de Pagos</h1>
    <a href="{{ route('pagos.create') }}" class="btn">Nuevo Pago</a>
    <table>
        <thead>
            <tr>
                <th>ID Pago</th>
                <th>N° Matrícula</th>
                <th>Estudiante</th>
                <th>Curso</th>
                <th>Monto</th>
                <th>Fecha Pago</th>
                <th>Medio de Pago</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pagos as $pago)
                <tr>
                    <td>{{ $pago->id_pago }}</td>
                    <td>{{ $pago->matricula_id }}</td>
                    <td>{{ $pago->matricula->estudiante->nombre ?? 'N/A' }}</td>
                    <td>{{ $pago->matricula->curso->nombre_curso ?? 'N/A' }}</td>
                    <td>${{ $pago->monto }}</td>
                    <td>{{ $pago->fecha_pago }}</td>
                    <td>{{ $pago->medioPago->nombre ?? 'N/A' }}</td>
                    <td>{{ $pago->estadoPago->nombre_estado ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('pagos.edit', $pago) }}" class="btn-edit">Editar</a>
                        <form action="{{ route('pagos.destroy', $pago) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('¿Eliminar este pago?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>-->