{{-- filepath: resources/views/actividades/index.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', 'Gestión de Actividades')
@section('content')

@if(session('success'))
    <div id="toast-success"
        style="
            position: fixed;
            top: 100px;
            left: 75%;
            transform: translateX(-50%);
            z-index: 9999;
            min-width: 340px;
            max-width: 400px;
            background: #d1e7dd;
            color: #0f5132;
            border-radius: 4px;
            box-shadow: 0 4px 24px #19875499;
            padding: 18px 24px 12px 24px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            opacity: 1;
            transition: opacity 0.5s;
        ">
        <div style="display: flex; align-items: center; margin-bottom: 4px;">
            <svg width="22" height="22" fill="none" stroke="#0f5132" stroke-width="2" viewBox="0 0 24 24" style="margin-right: 8px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            <span style="font-weight: bold; font-size: 1.1em;">¡Éxito!</span>
        </div>
        <div style="margin-bottom: 8px; margin-left: 30px;">{{ session('success') }}</div>
        <div style="width: 100%; height: 5px; background: #d4f5e9; border-radius: 3px; overflow: hidden;">
            <div id="toast-progress" style="height: 5px; background: #198754; width: 100%; transition: width 0.3s;"></div>
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

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="container py-4" style="background: #f8f9fc; min-height: 70vh; border-radius: 12px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold">
                <i class="bi bi-card-checklist me-3"></i>Gestión de Actividades
            </h1>
            <p class="ms-4 mb-0 text-muted">
                Administra todas las actividades de tus cursos
                <!-- span class="ms-3">
                    <i class="bi bi-clock me-1"></i>
                    Zona horaria: {{ config('app.timezone') }}
                </span -->
            </p>
        </div>

        <a href="{{ route('actividades.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Nueva Actividad
        </a>
    </div>

    {{-- Filtros desplegables --}}
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>
                <i class="bi bi-sliders"> Filtros </i>
            </span>
            <button class="btn btn-link text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#filtrosCollapse" aria-expanded="false" aria-controls="filtrosCollapse">
                <i class="bi bi-funnel">Mostrar/Ocultar</i>
            </button>
        </div>
        
        <div class="collapse{{ (request()->except(['page']) ? ' show' : '') }}" id="filtrosCollapse">
            <div class="card-body">
                <form method="GET" action="{{ route('actividades.index') }}" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Buscar Actividad</label>
                        <input type="text" name="buscar" class="form-control" placeholder="Buscar por título o descripción..." value="{{ request('buscar') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Curso</label>
                        <select name="curso_id" class="form-select">
                            <option value="">Todos los cursos</option>
                            @foreach($cursos as $curso)
                                <option value="{{ $curso->id_curso }}" {{ request('curso_id') == $curso->id_curso ? 'selected' : '' }}>
                                    {{ $curso->nombre_curso }} - {{ $curso->nivel->nombre_nivel ?? 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-select">
                            <option value="">Todos</option>
                            <option value="activa" {{ request('estado') == 'activa' ? 'selected' : '' }}>Activas</option>
                            <option value="inactiva" {{ request('estado') == 'inactiva' ? 'selected' : '' }}>Inactivas</option>
                            <option value="vencida" {{ request('estado') == 'vencida' ? 'selected' : '' }}>Vencidas</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Fecha desde</label>
                        <input type="date" name="fecha_desde" class="form-control" value="{{ request('fecha_desde') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Fecha hasta</label>
                        <input type="date" name="fecha_hasta" class="form-control" value="{{ request('fecha_hasta') }}">
                    </div>

                    <div class="col-md-6 d-flex gap-1">
                        <button type="submit" class="btn btn-primary mt-4">
                            <i class="bi bi-search"> Buscar</i>
                        </button>
                        <a href="{{ route('actividades.index') }}" class="btn btn-outline-secondary mt-4">
                            <i class="bi bi-arrow-counterclockwise"> Limpiar</i>
                        </a>
                        <a href="#" class="btn btn-outline-danger mt-4">
                            <i class="bi bi-file-earmark-pdf"> PDF</i>
                        </a>
                        <a href="#" class="btn btn-outline-success mt-4">
                            <i class="bi bi-file-earmark-excel"> Excel</i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Tabla de actividades --}}
    <div class="table-responsive rounded shadow" style="background: #fff;">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="text-center">ID</th>
                    <th>Título</th>
                    <th>Curso</th>
                    <th>Fecha Vencimiento</th>
                    <th class="text-center">Entregas</th>
                    <th class="text-center">Calificadas</th>
                    <th class="text-center">Estado</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($actividades as $actividad)
                    <tr>
                        <td class="text-center">{{ $actividad->id_actividad }}</td>
                        <td>
                            <div class="fw-bold">{{ $actividad->titulo }}</div>
                            <small class="text-muted">{{ Str::limit($actividad->descripcion, 30) }}</small>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $actividad->curso->nombre_curso }}</div>
                            <small class="text-muted">{{ $actividad->curso->nivel->nombre_nivel ?? 'N/A' }}</small>
                        </td>
                        <td>
                            <div>{{ $actividad->fecha_vencimiento->format('d/m/Y') }}</div>
                            <small class="text-muted">{{ $actividad->fecha_vencimiento->format('H:i') }}</small>
                        </td>
                        <td class="text-center">
                            <span class="fw-bold text-primary fs-6">
                                {{ $actividad->entregas->where('fecha_entrega', '!=', null)->count() }}/{{ $actividad->entregas->count() }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="fw-bold text-success fs-6">
                                {{ $actividad->entregas->where('calificacion', '!=', null)->count() }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if(!$actividad->activa)
                                <span class="badge bg-secondary">Inactiva</span>
                            @elseif($actividad->estaVencida())
                                <span class="badge bg-danger">Vencida</span>
                            @else
                                <span class="badge bg-success">Activa</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1" role="group">
                                <a href="{{ route('actividades.show', $actividad) }}" class="btn btn-sm btn-outline-info" title="Ver detalles">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('actividades.edit', $actividad) }}" class="btn btn-sm btn-outline-primary" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="{{ route('actividades.calificar', $actividad) }}" class="btn btn-sm btn-outline-success" title="Ver entregas">
                                    <i class="bi bi-list-check"></i>
                                </a>
                                <form action="{{ route('actividades.destroy', $actividad) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar esta actividad? Esta acción no se puede deshacer.')" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="bi bi-list-task display-1 text-muted mb-3"></i>
                            <h5 class="text-muted">No hay actividades</h5>
                            <p class="text-muted">
                                @if(request()->hasAny(['buscar', 'curso_id', 'estado', 'fecha_desde', 'fecha_hasta']))
                                    No se encontraron actividades con los filtros aplicados.
                                @else
                                    Crea tu primera actividad para comenzar.
                                @endif
                            </p>
                            @if(!request()->hasAny(['buscar', 'curso_id', 'estado', 'fecha_desde', 'fecha_hasta']))
                                <a href="{{ route('actividades.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-2"></i>Crear Actividad
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Información de resultados y paginación --}}
    <div class="row mt-3">
        <div class="col-md-12 text-end">
            {{ $actividades->links('pagination::bootstrap-5') }}
        </div>
    </div>

    
    <!-- Acciones rápidas flotantes -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 text-muted font-weight-bold">
                        <i class="fas fa-bolt me-2 text-gray-500"></i>
                        Acciones Rápidas
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-0">
                            <a href="{{ route('profesor.dashboard') }}" class="btn btn-outline-secondary btn-block">
                                <i class="bi bi-arrow-left me-1"></i>
                                Volver al Dashboard
                            </a>
                        </div>
                        <div class="col-md-2 mb-0">
                            <a href="{{ route('profesor.mis-clases') }}" class="btn btn-outline-primary btn-block">
                                <i class="bi bi-journal-bookmark-fill me-2"></i>
                                Mis Cursos
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
