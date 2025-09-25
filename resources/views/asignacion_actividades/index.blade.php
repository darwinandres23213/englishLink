{{-- filepath: resources/views/asignacion_actividades/index.blade.php --}}
@extends('layouts.AreaInterna.app')

@section('title', 'Asignación de Actividades')

@section('content')

@if(session('success'))
    <div id="toast-success"
        style="
            position: fixed;
            top: 24px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            min-width: 340px;
            max-width: 400px;
            background: #b7eac7;
            color: #155724;
            border-radius: 12px;
            box-shadow: 0 4px 24px #0002;
            padding: 18px 24px 12px 24px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            opacity: 1;
            transition: opacity 0.5s;
        ">
        <div style="display: flex; align-items: center; margin-bottom: 4px;">
            <svg width="22" height="22" fill="none" stroke="#155724" stroke-width="2" viewBox="0 0 24 24" style="margin-right: 8px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            <span style="font-weight: bold; font-size: 1.1em;">¡Éxito!</span>
        </div>
        <div style="margin-bottom: 8px; margin-left: 30px;">{{ session('success') }}</div>
        <div style="width: 100%; height: 5px; background: #d4f5e9; border-radius: 3px; overflow: hidden;">
            <div id="toast-progress" style="height: 5px; background: #218838; width: 100%; transition: width 0.3s;"></div>
        </div>
    </div>
    <script>
        const toastDuration = 2200;
        const progressBar = document.getElementById('toast-progress');
        let width = 100;
        const interval = 20;
        const decrement = 100 / (toastDuration / interval);

        const timer = setInterval(() => {
            width -= decrement;
            if (progressBar) progressBar.style.width = width + '%';
            if (width <= 0) {
                clearInterval(timer);
            }
        }, interval);

        setTimeout(() => {
            const toast = document.getElementById('toast-success');
            if(toast) toast.style.opacity = '0';
        }, toastDuration);
    </script>
@endif

<div class="container py-4">
    <h1 class="mb-4 fw-bold">Asignación de Actividades</h1>

    <div class="mb-3">
        <a href="{{ route('asignacion-actividades.create') }}" class="btn btn-primary">Nueva Asignación</a>
    </div>

    {{-- Filtros avanzados --}}
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>
                <i class="bi bi-sliders"> Filtros</i>
            </span>
            <button class="btn btn-link text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#filtrosCollapse" aria-expanded="{{ (request()->except(['page']) ? 'true' : 'false') }}" aria-controls="filtrosCollapse">
                <i class="bi bi-funnel"> Mostrar/Ocultar</i>
            </button>
        </div>
        <div class="collapse{{ (request()->except(['page']) ? ' show' : '') }}" id="filtrosCollapse">
            <div class="card-body">
                <form method="GET" action="{{ route('asignacion-actividades.index') }}" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="usuario" class="form-label">Usuario</label>
                        <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Buscar por usuario" value="{{ request('usuario') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="curso" class="form-label">Curso</label>
                        <input type="text" name="curso" id="curso" class="form-control" placeholder="Buscar por curso" value="{{ request('curso') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="estado" class="form-label">Estado</label>
                        <select name="estado" id="estado" class="form-select">
                            <option value="">-- Todos --</option>
                            @foreach($estados as $estado)
                                <option value="{{ $estado->id_estado }}" {{ request('estado') == $estado->id_estado ? 'selected' : '' }}>{{ $estado->nombre_estado }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 d-flex gap-2">
                        <button type="submit" class="btn btn-primary mt-4">
                            <i class="bi bi-funnel"> Buscar</i>
                        </button>
                        <a href="{{ route('asignacion-actividades.index') }}" class="btn btn-secondary mt-4">
                            <i class="bi bi-x-circle"> Limpiar filtros</i>
                        </a>
                        {{-- <a href="#" class="btn btn-danger mt-4"><i class="bi bi-file-earmark-pdf"></i> PDF</a> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    
    <div class="table-responsive rounded shadow-sm" style="background: #fff;"> 
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Curso</th>
                    <th>Nombre de la Actividad</th>
                    <th>Estado</th> 
                    <th class="text-nowrap text-center" style="width: 140px;">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($asignaciones as $asignacion)
                    <tr class="clase-item"> 
                        <td>{{ $asignacion->id_asignacion_actividad ?? $asignacion->id }}</td>
                        <td>{{ $asignacion->usuario->nombre ?? 'N/A' }}</td>
                        <td>{{ $asignacion->curso->nombre_curso ?? 'N/A' }}</td>
                        <td>{{ $asignacion->nombre }}</td>
                        <td>{{ $asignacion->estado->nombre_estado ?? 'N/A' }}</td>
                        <td class="d-flex gap-2 text-nowrap justify-content-center">
                            <a href="{{ route('asignacion-actividades.edit', $asignacion->id_asignacion_actividad ?? $asignacion->id) }}" class="btn btn-sm btn-outline-primary me-2">
                                <i class="bi bi-pencil"> Editar </i>
                            </a>
                            <form action="{{ route('asignacion-actividades.destroy', $asignacion->id_asignacion_actividad ?? $asignacion->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar esta asignación?')">
                                    <i class="bi bi-trash"> Eliminar </i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4"> 
                            <i class="bi bi-info-circle"></i> No hay asignaciones disponibles y/o no hay resultados para los filtros aplicados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="row mt-3">
        <div class="col-md-12 text-end">
            {{ $asignaciones->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $("input[name='usuario'], input[name='curso']").on("keyup", function () {
        var usuario = $("input[name='usuario']").val().toLowerCase();
        var curso = $("input[name='curso']").val().toLowerCase();
        $(".clase-item").filter(function () {
            var row = $(this).text().toLowerCase();
            $(this).toggle(
                (usuario === "" || row.indexOf(usuario) > -1) &&
                (curso === "" || row.indexOf(curso) > -1)
            );
        });
    });
});
</script>
@endsection





<!-- <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignación de Actividades</title>
    <link rel="stylesheet" href="{{ asset('css/pagos.css') }}">
</head>
<body>
<div class="container">
    <h1>Asignación de Actividades</h1>
    <a href="{{ route('asignacion-actividades.create') }}" class="btn">Nueva Asignación</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Curso</th>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($asignaciones as $asignacion)
                <tr>
                    <td>{{ $asignacion->id }}</td>
                    <td>{{ $asignacion->usuario->nombre ?? 'N/A' }}</td>
                    <td>{{ $asignacion->curso->nombre_curso ?? 'N/A' }}</td>
                    <td>{{ $asignacion->nombre }}</td>
                    <td>{{ $asignacion->estado->nombre_estado ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('asignacion-actividades.edit', $asignacion->id) }}" class="btn-edit">Editar</a>
                        <form action="{{ route('asignacion-actividades.destroy', $asignacion->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('¿Eliminar esta asignación?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html> -->