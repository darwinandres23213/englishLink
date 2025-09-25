{{-- filepath: resources/views/clases/index.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', 'Gestión de Clases')
@section('content')

<!--style>
    .border-left-warning {
        border-left: 0.25rem solid #f6c23e !important;
    }
    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }
    .border-left-secondary {
        border-left: 0.25rem solid #858796 !important;
    }
    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }
    .badge-temporal {
        min-width: 100px;
        display: inline-block;
    }
    .info-temporal {
        font-size: 0.75rem;
        line-height: 1.2;
    }
</style -->

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
                <i class="bi bi-calendar-event me-3"></i>Gestión de Clases
            </h1>
            <p class="ms-4 mb-0 text-muted">
                Administra todas las clases de tus cursos
            </p>
        </div>

        <a href="{{ route('clases.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Nueva Clase
        </a>
    </div>

    {{-- Resumen 'cards' de estados --}}
    {{-- @if($clases->total() > 0)
        <div class="row mb-4">
            @php
                $hoy = \Carbon\Carbon::now();
                $clasesHoy = $clases->where('fecha', $hoy->format('Y-m-d'))->count();
                $clasesProgramadas = $clases->filter(function($clase) use ($hoy) {
                    return \Carbon\Carbon::parse($clase->fecha)->isFuture();
                })->count();
                $clasesCompletadas = $clases->filter(function($clase) use ($hoy) {
                    return \Carbon\Carbon::parse($clase->fecha)->isPast() && !\Carbon\Carbon::parse($clase->fecha)->isToday();
                })->count();
            @endphp
            
            <div class="col-md-3">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Hoy</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $clasesHoy }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-clock-fill fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Programadas</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $clasesProgramadas }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-calendar-check-fill fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card border-left-secondary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Completadas</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $clasesCompletadas }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-check-circle-fill fa-2x text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $clases->total() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-calendar-event fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif --}}

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
                <form method="GET" action="{{ route('clases.index') }}" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Buscar Clase</label>
                        <input type="text" name="buscar" class="form-control" placeholder="Buscar por tema..." value="{{ request('buscar') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Curso</label>
                        <select name="curso_id" class="form-select">
                            <option value="">Todos los cursos</option>
                            @if(isset($cursos))
                                @foreach($cursos as $curso)
                                    <option value="{{ $curso->id_curso }}" {{ request('curso_id') == $curso->id_curso ? 'selected' : '' }}>
                                        {{ $curso->nombre_curso }} - {{ $curso->nivel->nombre_nivel ?? 'N/A' }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-select">
                            <option value="">Todos los estados</option>
                            <option value="hoy" {{ request('estado') == 'hoy' ? 'selected' : '' }}>Hoy</option>
                            <option value="programada" {{ request('estado') == 'programada' ? 'selected' : '' }}>Programadas</option>
                            <option value="completada" {{ request('estado') == 'completada' ? 'selected' : '' }}>Completadas</option>
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
                        <a href="{{ route('clases.index') }}" class="btn btn-outline-secondary mt-4">
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

    {{-- Tabla de clases --}}
    <div class="table-responsive rounded shadow" style="background: #fff;">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="text-center">ID</th>
                    <th>Tema</th>
                    <th>Material</th>
                    <th>Curso - Nivel</th>
                    <th>Fecha</th>
                    <th class="text-center">Estado</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clases as $clase)
                    <tr>
                        <td class="text-center">{{ $clase->id_clase }}</td>

                        <!-- Tema de la clase -->
                        <td>
                            <div class="fw-bold">{{ $clase->tema }}</div>
                        </td>

                        <!-- Material de la clase -->
                        <td>
                            @if($clase->material && trim($clase->material) !== '')
                                {{ $clase->material }}
                            @else
                                <span class="text-muted">Sin material</span>
                            @endif
                        </td>

                        <!-- Curso y nivel de la clase -->
                        <td>
                            <div class="fw-semibold">{{ $clase->curso->nombre_curso ?? 'N/A' }}</div>
                            <small class="text-muted">{{ $clase->curso->nivel->nombre_nivel ?? 'N/A' }}</small>
                        </td>

                        <!-- Fecha de la clase -->
                        <td>
                            <div>{{ \Carbon\Carbon::parse($clase->fecha)->format('d/m/Y') }}</div>
                            <!-- small class="text-muted">{{ \Carbon\Carbon::parse($clase->fecha)->format('l') }}</small -->
                            <small class="text-muted">{{ \Carbon\Carbon::parse($clase->fecha)->locale('es')->translatedFormat('l') }}</small>
                        </td>

                        <!-- Estado de la clase -->
                        <td class="text-center">
                            @php
                                $fechaClase = \Carbon\Carbon::parse($clase->fecha)->locale('es');
                                $hoy = \Carbon\Carbon::now()->locale('es');
                                
                                // Configurar Carbon para español
                                \Carbon\Carbon::setLocale('es');
                            @endphp
                            @if($fechaClase->isToday())
                                <span class="badge bg-warning text-dark fw-bold badge-temporal">
                                    <i class="bi bi-clock-fill me-1"></i>Hoy
                                </span>
                                <div class="small text-muted mt-1 info-temporal">
                                    <i class="bi bi-calendar me-1"></i>{{ $fechaClase->format('d/m/Y') }}
                                </div>
                            @elseif($fechaClase->isFuture())
                                <span class="badge bg-success fw-bold badge-temporal">
                                    <i class="bi bi-calendar-check-fill me-1"></i>Programada
                                </span>
                                <div class="small text-muted mt-1 info-temporal">
                                    <i class="bi bi-calendar-plus me-1"></i>{{ $fechaClase->diffForHumans() }}
                                </div>
                            @else
                                <span class="badge bg-secondary fw-bold badge-temporal">
                                    <i class="bi bi-check-circle-fill me-1"></i>Completada
                                </span>
                                <div class="small text-muted mt-1 info-temporal">
                                    <i class="bi bi-clock-history me-1"></i>{{ $fechaClase->diffForHumans() }}
                                </div>
                            @endif
                        </td>

                        <!-- Acciones -->
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1" role="group">
                                <a href="{{ route('clases.edit', $clase->id_clase) }}" class="btn btn-sm btn-outline-primary" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('clases.destroy', $clase->id_clase) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar esta clase? Esta acción no se puede deshacer.')" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="bi bi-calendar-x display-1 text-muted mb-3"></i>
                            <h5 class="text-muted">No hay clases programadas</h5>
                            <p class="text-muted">
                                @if(request()->hasAny(['buscar', 'curso_id', 'fecha_desde', 'fecha_hasta', 'estado']))
                                    No se encontraron clases con los filtros aplicados.
                                @else
                                    Programa tu primera clase para comenzar.
                                @endif
                            </p>
                            @if(!request()->hasAny(['buscar', 'curso_id', 'fecha_desde', 'fecha_hasta', 'estado']))
                                <a href="{{ route('clases.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-2"></i>Crear Clase
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
            {{ $clases->links('pagination::bootstrap-5') }}
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