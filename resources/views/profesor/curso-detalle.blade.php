{{-- filepath: resources/views/profesor/curso-detalle.blade.php --}}
@extends('layouts.AreaInterna.app')

@section('title', 'Curso: ' . $curso->nombre_curso)

@section('content')
<div class="container py-4">
    <!-- Header del curso -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card shadow-lg border-left-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        
                        <div>
                            <h1 class="h1 mb-2 text-primary"> <!-- Opciones: <h1 class="h3 mb-2 text-primary fs-1"> || <h1 class="display-4 mb-2 text-primary"> -->
                                <!-- i class="fas fa-book-open me-2"></i -->
                                <strong>{{ $curso->nombre_curso }}</strong>
                            </h1>
                            <p class="text-muted mb-0">
                                {{ $curso->descripcion ?? 'Sin descripción disponible!' }}
                            </p>


                            <!-- div class="d-flex flex-wrap gap-3 mb-2 mt-5">
                                <span class="badge badge-primary fs-6">{{ $curso->nivel->nombre_nivel ?? 'N/A' }}</span>
                                <span class="badge badge-info fs-6">
                                    <i class="fas fa-users me-1"></i>{{ $totalEstudiantes }} estudiantes
                                </span>
                                <span class="badge badge-success fs-6">
                                    <i class="fas fa-tasks me-1"></i>{{ $totalActividades }} actividades
                                </span>
                            </div -->
                        </div>

                        <div class="text-end">
                            @if($curso->horario)
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    Dias: {{ $curso->horario->dia_semana ?? 'N/A' }} <br>
                                    Horario de: ({{ $curso->horario->hora_inicio ?? '' }} - {{ $curso->horario->hora_fin ?? '' }}) <br>
                                    Nivel: {{ $curso->nivel->nombre_nivel ?? 'N/A' }}
                                </small>
                            @endif
                            <br><br>
                            <a href="{{ route('profesor.mis-clases') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Volver a Mis Clases
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas rápidas -->
    <div class="row mb-3">
        <div class="col-md-3">
            <div class="card border-left-primary shadow h-100 py-1 stats-card-clickable" onclick="activarTab('estudiantes')" style="cursor: pointer;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Estudiantes
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalEstudiantes }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-graduate fa-2x text-gray-200"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-success shadow h-100 py-1 stats-card-clickable" onclick="activarTab('actividades')" style="cursor: pointer;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Actividades
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalActividades }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-gray-200"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-warning shadow h-100 py-1 stats-card-clickable" onclick="activarTab('entregas')" style="cursor: pointer;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Actividades por Calificar
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalEntregasPendientes }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-200"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-danger shadow h-100 py-1">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Actividades Vencidas
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $actividadesVencidas }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-200"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección principal con tabs -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <ul class="nav nav-tabs card-header-tabs" id="cursoTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="actividades-tab" data-bs-toggle="tab" data-bs-target="#actividades" type="button" role="tab">
                                <!-- i class="fas fa-tasks me-2" --></i>Gestión de Actividades
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="estudiantes-tab" data-bs-toggle="tab" data-bs-target="#estudiantes" type="button" role="tab">
                                <!-- i class="fas fa-users me-2" --></i>Lista de Estudiantes
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="entregas-tab" data-bs-toggle="tab" data-bs-target="#entregas" type="button" role="tab">
                                <!-- i class="fas fa-file-alt me-2" --></i>Actividades por Calificar
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="estadisticas-tab" data-bs-toggle="tab" data-bs-target="#estadisticas" type="button" role="tab">
                                <!-- i class="fas fa-chart-bar me-2" --></i>Rendimiento por estudiante
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="cursoTabsContent">


                        <!-- Tab: Gestión de Actividades -->
                        <div class="tab-pane fade show active" id="actividades" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">
                                    <i class="fas fa-tasks me-2 text-gray-400"></i>
                                    Actividades del Curso
                                </h5>
                                <a href="{{ route('actividades.create') }}?curso={{ $curso->id_curso }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-plus me-1"></i> Nueva Actividad
                                </a>
                            </div>

                            <!-- Filtros de Actividades -->
                            <div class="card mb-3">
                                <div class="card-body py-2">
                                    <div class="row align-items-center">
                                        <div class="col-md-3">
                                            <label class="form-label small mb-1">Filtrar por Estado:</label>
                                            <select class="form-select form-select-sm" id="filtroEstadoActividad">
                                                <option value="">Todas</option>
                                                <option value="activa">Solo Activas</option>
                                                <option value="vencida">Solo Vencidas</option>
                                                <option value="inactiva">Solo Inactivas</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label small mb-1">Ordenar por:</label>
                                            <select class="form-select form-select-sm" id="ordenarActividades">
                                                <option value="estado">Estado (Activas primero)</option>
                                                <option value="fecha_venc_asc">Fecha vencimiento (Próxima primero)</option>
                                                <option value="fecha_venc_desc">Fecha vencimiento (Lejana primero)</option>
                                                <option value="titulo">Título A-Z</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small mb-1">Buscar actividad:</label>
                                            <input type="text" class="form-control form-control-sm" id="buscarActividad" placeholder="Título de la actividad...">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label small mb-1">&nbsp;</label>
                                            <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="limpiarFiltrosActividades()">
                                                <i class="fas fa-undo me-1"></i>Limpiar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @if($actividadesRecientes->count() > 0)
                                <div class="row" id="actividadesContainer">
                                    @foreach($actividadesRecientes as $actividad)
                                        <div class="col-lg-6 mb-3 actividad-card" 
                                             data-estado="{{ !$actividad->activa ? 'inactiva' : ($actividad->fecha_vencimiento < now() ? 'vencida' : 'activa') }}"
                                             data-titulo="{{ strtolower($actividad->titulo) }}"
                                             data-fecha="{{ $actividad->fecha_vencimiento->timestamp }}">
                                            <div class="card border-left-{{ !$actividad->activa ? 'secondary' : ($actividad->fecha_vencimiento < now() ? 'danger' : 'success') }} h-100">
                                                
                                                <!-- Header gris con información básica -->
                                                <div class="card-header bg-light py-2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="flex-grow-1">
                                                            <h6 class="card-title mb-1 text-dark fw-bold">{{ $actividad->titulo }}</h6>
                                                            <p class="text-muted small mb-0">{{ Str::limit($actividad->descripcion, 80) }}</p>
                                                        </div>
                                                        <div class="ms-2">
                                                            <span class="badge badge-{{ !$actividad->activa ? 'secondary' : ($actividad->fecha_vencimiento < now() ? 'danger' : 'success') }}">
                                                                {{ !$actividad->activa ? 'Inactiva' : ($actividad->fecha_vencimiento < now() ? 'Vencida' : 'Activa') }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Contenido del card -->
                                                <div class="card-body">

                                                    <!-- Conteo de actividades -->
                                                    <div class="row text-center mb-3">
                                                        <div class="col-6">
                                                            <div class="border-end">
                                                                <div class="h5 mb-0 text-primary">{{ $actividad->entregas->where('estado', 'entregado')->count() + $actividad->entregas->where('estado', 'calificado')->count() }}</div>
                                                                <small class="text-muted">Entregadas</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="h5 mb-0 text-success">{{ $actividad->entregas->where('estado', 'calificado')->count() }}</div>
                                                            <small class="text-muted">Calificadas</small>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <small class="text-muted">
                                                            <i class="fas fa-calendar me-1"></i>
                                                            Vence: {{ $actividad->fecha_vencimiento->format('d/m/Y H:i') }}
                                                        </small>
                                                        <div>
                                                            <a href="{{ route('actividades.show', $actividad) }}" class="btn btn-sm btn-outline-primary">
                                                                <!-- i class="fas fa-eye me-1" --></i>Instrucciones
                                                            </a>
                                                            <a href="{{ route('actividades.calificar', $actividad) }}" class="btn btn-sm btn-outline-success">
                                                                <!-- i class="fas fa-star me-1" --></i>Ver entregas
                                                            </a>

                                                            <!-- Dropdown para acciones -->
                                                            <div class="dropdown d-inline">
                                                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                                    <i class="fas fa-ellipsis-v"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a class="dropdown-item" href="{{ route('actividades.edit', $actividad) }}">
                                                                        <i class="fas fa-edit me-2"></i>Editar
                                                                    </a></li>
                                                                    <li><hr class="dropdown-divider"></li>
                                                                    <li>
                                                                        <form action="{{ route('actividades.destroy', $actividad) }}" method="POST" class="d-inline">
                                                                            @csrf @method('DELETE')
                                                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('¿Eliminar esta actividad?')">
                                                                                <i class="fas fa-trash me-2"></i>Eliminar
                                                                            </button>
                                                                        </form>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- div class="text-center">
                                    <a href="{{ route('actividades.index') }}?curso={{ $curso->id_curso }}" class="btn btn-outline-primary">
                                        <i class="fas fa-list me-1"></i>Ver Todas las Actividades
                                    </a>
                                </div -->
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-tasks fa-3x text-gray-300 mb-3"></i>
                                    <h6 class="text-gray-600">No hay actividades creadas</h6>
                                    <p class="text-muted">Crea la primera actividad para este curso</p>
                                </div>
                            @endif
                        </div>




                        <!-- Tab: Lista de Estudiantes -->
                        <div class="tab-pane fade" id="estudiantes" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">
                                    <i class="fas fa-users me-2 text-gray-400"></i>
                                    Estudiantes Matriculados ({{ $totalEstudiantes }})
                                </h5>
                                <div>
                                    <a href="{{ route('asistencias.index') }}?curso={{ $curso->id_curso }}" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-clipboard-check me-1"></i>Tomar Asistencia
                                    </a>
                                    <!-- a href="{{ route('matriculas.create') }}?curso={{ $curso->id_curso }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-user-plus me-1"></i>Matricular Estudiante
                                    </a -->
                                </div>
                            </div>
                            
                            @if($curso->matriculas->count() > 0)
                                <div class="row">
                                    @foreach($curso->matriculas as $matricula)
                                        <div class="col-md-6 mb-3">
                                            <div class="list-group-item border rounded shadow-sm">
                                                <div class="d-flex align-items-center p-1">
                                                    <!-- Avatar con foto de perfil o iniciales -->
                                                    <div class="me-3">
                                                        @php
                                                            $nombre = $matricula->estudiante->nombre ?? 'N';
                                                            $apellido = $matricula->estudiante->apellido ?? 'A';
                                                            $iniciales = strtoupper(substr($nombre, 0, 1) . substr($apellido, 0, 1));
                                                            $colores = ['primary', 'success', 'info', 'warning', 'danger', 'secondary'];
                                                            $colorIndex = abs(crc32($nombre . $apellido)) % count($colores);
                                                            $color = $colores[$colorIndex];
                                                            $fotoPerfil = $matricula->estudiante->foto ?? $matricula->estudiante->imagen ?? null;
                                                        @endphp
                                                        
                                                        @if($fotoPerfil && file_exists(public_path('uploads/' . $fotoPerfil)))
                                                            <!-- Mostrar foto de perfil -->
                                                            <img src="{{ asset('uploads/' . $fotoPerfil) }}" 
                                                                 alt="{{ $nombre }} {{ $apellido }}" 
                                                                 class="rounded-circle" 
                                                                 style="width: 50px; height: 50px; object-fit: cover; border: 2px solid #{{ $color === 'primary' ? '4e73df' : ($color === 'success' ? '1cc88a' : ($color === 'info' ? '36b9cc' : ($color === 'warning' ? 'f6c23e' : ($color === 'danger' ? 'e74a3b' : '6c757d')))) }};">
                                                        @else
                                                            <!-- Mostrar iniciales como respaldo -->
                                                            <div class="bg-{{ $color }} rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width: 48px; height: 48px; font-size: 16px;">
                                                                {{ $iniciales }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    
                                                    <!-- Información del estudiante -->
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1 fw-bold">{{ $matricula->estudiante->nombre ?? 'N/A' }} {{ $matricula->estudiante->apellido ?? '' }}</h6>
                                                        <p class="mb-1 text-muted small">
                                                            <i class="fas fa-envelope me-1"></i>
                                                            {{ $matricula->estudiante->email ?? 'Sin email' }}
                                                        </p>
                                                        <!-- small class="text-muted">
                                                            <i class="fas fa-calendar me-1"></i>
                                                            Matriculado: {{ $matricula->fecha_matricula ? \Carbon\Carbon::parse($matricula->fecha_matricula)->format('d/m/Y') : 'N/A' }}
                                                        </small -->
                                                    </div>
                                                    
                                                    <!-- Botón de acción -->
                                                    <div class="ms-3">
                                                        <a href="{{ route('notas.index') }}?estudiante={{ $matricula->estudiante->id_usuario }}&curso={{ $curso->id_curso }}" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-star me-1"></i>Calificar
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-user-graduate fa-3x text-gray-300 mb-3"></i>
                                    <h6 class="text-gray-600">No hay estudiantes matriculados</h6>
                                    <p class="text-muted">Los estudiantes aparecerán aquí una vez matriculados</p>
                                </div>
                            @endif
                        </div>




                        <!-- Tab: Entregas por Calificar -->
                        <div class="tab-pane fade" id="entregas" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">
                                    <i class="fas fa-file-alt me-2 text-gray-400"></i>
                                    Entregas pendientes por calificar ({{ $totalEntregasPendientes }})
                                </h5>
                            </div>
                            
                            @if($totalEntregasPendientes > 0)
                                <div class="list-group">
                                    @foreach($entregasPendientes->take(10) as $entrega)
                                        <div class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">{{ $entrega->actividad->titulo ?? 'N/A' }}</h6>
                                                    <p class="mb-1 text-muted">
                                                        <i class="fas fa-user me-1"></i>
                                                        {{ $entrega->estudiante->nombre ?? 'N/A' }} {{ $entrega->estudiante->apellido ?? '' }}
                                                    </p>
                                                    <small class="text-muted">
                                                        <i class="fas fa-clock me-1"></i>
                                                        Entregado: {{ $entrega->fecha_entrega ? \Carbon\Carbon::parse($entrega->fecha_entrega)->format('d/m/Y H:i') : 'Sin fecha' }}
                                                        @if($entrega->actividad && $entrega->actividad->fecha_vencimiento)
                                                            @if($entrega->fecha_entrega && \Carbon\Carbon::parse($entrega->fecha_entrega) > $entrega->actividad->fecha_vencimiento)
                                                                <span class="badge badge-warning ms-2">Entrega tardía</span>
                                                            @else
                                                                <span class="badge badge-success ms-2">A tiempo</span>
                                                            @endif
                                                        @endif
                                                    </small>
                                                </div>
                                                <div class="text-end">
                                                    <a href="{{ route('actividades.calificar', $entrega->actividad) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye me-1"></i>Ver entrega
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @if($totalEntregasPendientes > 10)
                                    <div class="text-center mt-3">
                                        <a href="{{ route('actividades.index') }}?curso={{ $curso->id_curso }}&filter=pending" class="btn btn-outline-primary">
                                            <i class="fas fa-list me-1"></i>Ver Todas las Entregas Pendientes
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-clipboard-check fa-3x text-success mb-3"></i>
                                    <h6 class="text-success">¡No hay entregas por calificar!</h6>
                                    <!-- p class="text-muted text-gray-500">No hay estudiantes que hayan enviado tareas <br> pendientes de calificación</p -->
                                    <small class="text-muted text-gray-500">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Las entregas aparecerán aquí cuando los estudiantes suban sus tareas
                                    </small>
                                </div>
                            @endif
                        </div>




                        <!-- Tab: Rendimiento por estudiante -->
                        <div class="tab-pane fade" id="estadisticas" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">
                                    <i class="fas fa-chart-bar me-2 text-primary"></i>
                                    Rendimiento de Estudiantes
                                </h5>
                            </div>
                            
                            @if($estudiantesRendimiento->count() > 0)
                                <div class="row">
                                    @foreach($estudiantesRendimiento as $estudiante)
                                        @php
                                            $nombre = $estudiante['estudiante']->nombre ?? 'N';
                                            $apellido = $estudiante['estudiante']->apellido ?? 'A';
                                            $iniciales = strtoupper(substr($nombre, 0, 1) . substr($apellido, 0, 1));
                                            $promedio = $estudiante['promedio']; // Promedio sobre 5.0
                                            $porcentaje = $estudiante['porcentaje']; // Porcentaje para colores
                                            
                                            // Colores según porcentaje (80% = 4.0/5.0, 60% = 3.0/5.0)
                                            $colorClase = $porcentaje >= 80 ? 'success' : ($porcentaje >= 60 ? 'warning' : 'danger');
                                            $colorHex = $porcentaje >= 80 ? '#1cc88a' : ($porcentaje >= 60 ? '#f6c23e' : '#e74a3b');
                                            
                                            // Foto de perfil
                                            $fotoPerfil = $estudiante['estudiante']->foto ?? $estudiante['estudiante']->imagen ?? null;
                                        @endphp
                                        
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card border-left-{{ $colorClase }} h-100 shadow-sm">
                                                <div class="card-body text-center py-3">
                                                    <!-- Avatar y nombre en línea horizontal -->
                                                    <div class="d-flex align-items-start justify-content-start mb-2">
                                                        <!-- Avatar con foto o iniciales -->
                                                        <div class="me-3">
                                                            @if($fotoPerfil && file_exists(public_path('uploads/' . $fotoPerfil)))
                                                                <!-- Mostrar foto de perfil con borde colorido -->
                                                                <img src="{{ asset('uploads/' . $fotoPerfil) }}" 
                                                                     alt="{{ $nombre }} {{ $apellido }}" 
                                                                     class="rounded-circle shadow-sm" 
                                                                     style="width: 40px; height: 40px; object-fit: cover; border: 3px solid {{ $colorHex }};">
                                                            @else
                                                                <!-- Mostrar iniciales con fondo según promedio -->
                                                                <div class="bg-{{ $colorClase }} rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-sm" 
                                                                     style="width: 40px; height: 40px; font-size: 18px; border: 3px solid {{ $colorHex }};">
                                                                    {{ $iniciales }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                        
                                                        <!-- Nombre del estudiante al lado -->
                                                        <div class="text-start">
                                                            <h6 class="mb-0">{{ $nombre }} {{ $apellido }}</h6>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Badge de promedio sobre 5.0 -->
                                                    <div class="mb-3">
                                                        <span class="badge badge-{{ $colorClase }} px-2 py-1" style="font-size: 14px;">
                                                            <i class="bi bi-calculator-fill me-2"></i>{{ $promedio }} /5.0 promedio
                                                        </span>
                                                    </div>
                                                    
                                                    <!-- Estadísticas centradas y elegantes -->
                                                    <div class="d-flex justify-content-center mb-3">
                                                        <div class="d-flex align-items-center">
                                                            <!-- Entregadas -->
                                                            <div class="text-center mx-3">
                                                                <div class="h5 mb-0 font-weight-bold text-{{ $colorClase }}">{{ $estudiante['entregas_realizadas'] }}</div>
                                                                <div class="small text-gray-600">Entregadas</div>
                                                            </div>
                                                            
                                                            <div class="mx-2 text-gray-300">|</div>
                                                            
                                                            <!-- Calificadas -->
                                                            <div class="text-center mx-3">
                                                                <div class="h5 mb-0 font-weight-bold text-success">{{ $estudiante['entregas_calificadas'] }}</div>
                                                                <div class="small text-gray-600">Calificadas</div>
                                                            </div>
                                                            
                                                            <div class="mx-2 text-gray-300">|</div>
                                                            
                                                            <!-- Total -->
                                                            <div class="text-center mx-3">
                                                                <div class="h5 mb-0 font-weight-bold text-primary">{{ $estudiante['total_actividades'] }}</div>
                                                                <div class="small text-gray-600">Total</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Información adicional con texto outline -->
                                                    <div class="small text-center">
                                                        @if($estudiante['entregas_pendientes'] > 0)
                                                            <span class="text-warning fw-bold">{{ $estudiante['entregas_pendientes'] }} Por calificar</span>
                                                        @endif
                                                        @if($estudiante['entregas_pendientes'] > 0 && $estudiante['sin_entregar'] > 0)
                                                            <span class="text-muted mx-2">•</span>
                                                        @endif
                                                        @if($estudiante['sin_entregar'] > 0)
                                                            <span class="text-danger fw-bold">{{ $estudiante['sin_entregar'] }} Sin entregar</span>
                                                        @endif
                                                        @if($estudiante['entregas_pendientes'] == 0 && $estudiante['sin_entregar'] == 0)
                                                            <span class="text-success fw-bold">✓ Al día</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-chart-bar fa-3x text-gray-300 mb-3"></i>
                                    <h6 class="text-gray-600">Sin datos de rendimiento</h6>
                                    <p class="text-muted">Los datos aparecerán cuando haya entregas calificadas</p>
                                </div>
                            @endif
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- Acciones rápidas flotantes -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 text-primary">
                        <i class="fas fa-bolt me-2"></i>
                        Acciones Rápidas para este Curso
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 mb-2">
                            <a href="{{ route('actividades.create') }}?curso={{ $curso->id_curso }}" class="btn btn-outline-success btn-block">
                                <i class="fas fa-plus me-1"></i>
                                Nueva Actividad
                            </a>
                        </div>
                        <div class="col-md-2 mb-2">
                            <a href="{{ route('evaluaciones.create') }}?curso={{ $curso->id_curso }}" class="btn btn-outline-dark btn-block">
                                <i class="fas fa-file-alt me-2"></i>
                                Nueva Evaluación
                            </a>
                        </div>
                        <div class="col-md-2 mb-2">
                            <a href="{{ route('asistencias.index') }}?curso={{ $curso->id_curso }}" class="btn btn-outline-info btn-block">
                                <i class="fas fa-clipboard-check me-2"></i>
                                Tomar Asistencia
                            </a>
                        </div>
                        <div class="col-md-2 mb-2">
                            <a href="{{ route('notas.index') }}?curso={{ $curso->id_curso }}" class="btn btn-outline-secondary btn-block">
                                <i class="fas fa-star me-2"></i>
                                Ver Calificaciones
                            </a>
                        </div>
                        <!-- div class="col-md-2 mb-2">
                            <a href="{{ route('matriculas.create') }}?curso={{ $curso->id_curso }}" class="btn btn-primary btn-block">
                                <i class="fas fa-user-plus me-2"></i>
                                Matricular Estudiante
                            </a>
                        </div -->
                        <div class="col-md-2 mb-2">
                            <a href="{{ route('mensajes.create') }}?curso={{ $curso->id_curso }}" class="btn btn-outline-primary btn-block">
                                <i class="fas fa-envelope me-2"></i>
                                Enviar Mensaje
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.border-left-primary { border-left: 0.25rem solid #4e73df !important; }
.border-left-success { border-left: 0.25rem solid #1cc88a !important; }
.border-left-info { border-left: 0.25rem solid #36b9cc !important; }
.border-left-warning { border-left: 0.25rem solid #f6c23e !important; }
.border-left-danger { border-left: 0.25rem solid #e74a3b !important; }
.card { box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important; }
.badge { font-size: 0.75em; }
.btn-block { display: block; width: 100%; }
.nav-tabs .nav-link.active { background-color: #4e72df41; color: #4e73df; font-weight: bold; border-color: #4e73df; }
.nav-tabs .nav-link { color: #4e73df; }
.nav-tabs .nav-link:hover { color: #2653d4; }

/* Estilos para filtros de actividades */
.actividad-card {
    transition: opacity 0.3s ease;
}

/* Dropdown menus */
.dropdown-menu {
    z-index: 1050;
}

.border-right {
    border-right: 1px solid #e6e6de;
}

/* Estados vacíos mejorados */
.text-gray-300 {
    color: #d1d3e2 !important;
}

.text-gray-600 {
    color: #6e707e !important;
}

/* Mejoras en el espaciado */
.gap-2 {
    gap: 0.5rem !important;
}

.py-5 {
    padding-top: 3rem !important;
    padding-bottom: 3rem !important;
}
</style>
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filtroEstado = document.getElementById('filtroEstadoActividad');
    const buscarActividad = document.getElementById('buscarActividad');
    const ordenarActividades = document.getElementById('ordenarActividades');
    const actividadesContainer = document.getElementById('actividadesContainer');

    function aplicarFiltrosActividades() {
        if (!actividadesContainer) return;
        
        const cards = Array.from(document.querySelectorAll('.actividad-card'));
        const estadoFiltro = filtroEstado ? filtroEstado.value : '';
        const busqueda = buscarActividad ? buscarActividad.value.toLowerCase() : '';
        const ordenarPor = ordenarActividades ? ordenarActividades.value : 'estado';

        // Filtrar
        cards.forEach(card => {
            let mostrar = true;

            // Filtro por estado
            if (estadoFiltro && card.dataset.estado !== estadoFiltro) {
                mostrar = false;
            }

            // Filtro por búsqueda
            if (busqueda && !card.dataset.titulo.includes(busqueda)) {
                mostrar = false;
            }

            card.style.display = mostrar ? 'block' : 'none';
        });

        // Ordenar
        const cardsVisibles = cards.filter(card => card.style.display !== 'none');
        
        cardsVisibles.sort((a, b) => {
            switch (ordenarPor) {
                case 'estado':
                    // Activas primero (estado='activa' < estado='vencida')
                    if (a.dataset.estado !== b.dataset.estado) {
                        return a.dataset.estado === 'activa' ? -1 : 1;
                    }
                    // Si mismo estado, ordenar por fecha de vencimiento
                    return parseInt(a.dataset.fecha) - parseInt(b.dataset.fecha);
                case 'fecha_venc_asc':
                    return parseInt(a.dataset.fecha) - parseInt(b.dataset.fecha);
                case 'fecha_venc_desc':
                    return parseInt(b.dataset.fecha) - parseInt(a.dataset.fecha);
                case 'titulo':
                    return a.dataset.titulo.localeCompare(b.dataset.titulo);
                default:
                    return 0;
            }
        });

        // Reordenar en el DOM
        cardsVisibles.forEach(card => {
            actividadesContainer.appendChild(card);
        });
    }

    function limpiarFiltrosActividades() {
        if (filtroEstado) filtroEstado.value = '';
        if (buscarActividad) buscarActividad.value = '';
        if (ordenarActividades) ordenarActividades.value = 'estado';
        aplicarFiltrosActividades();
    }

    // Event listeners
    if (filtroEstado) filtroEstado.addEventListener('change', aplicarFiltrosActividades);
    if (buscarActividad) buscarActividad.addEventListener('input', aplicarFiltrosActividades);
    if (ordenarActividades) ordenarActividades.addEventListener('change', aplicarFiltrosActividades);

    // Hacer limpiarFiltrosActividades disponible globalmente
    window.limpiarFiltrosActividades = limpiarFiltrosActividades;
});

// Función para activar un tab específico
function activarTab(tabId) {
    // Remover clase active de todos los tabs
    document.querySelectorAll('.nav-link').forEach(tab => {
        tab.classList.remove('active');
    });
    
    // Remover clase active y show de todos los tab-panes
    document.querySelectorAll('.tab-pane').forEach(pane => {
        pane.classList.remove('active', 'show');
    });
    
    // Activar el tab deseado
    const tabButton = document.getElementById(tabId + '-tab');
    const tabPane = document.getElementById(tabId);
    
    if (tabButton && tabPane) {
        tabButton.classList.add('active');
        tabPane.classList.add('active', 'show');
    }
}
</script>

<style>
/* Hacer el ícono verde más transparente como los otros iconos */
.fas.fa-clipboard-check.fa-3x {
    opacity: 0.4 !important;
    color: #1cc88a !important;
}

/* Efecto hover para las cards clickeables */
.stats-card-clickable {
    transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
}

.stats-card-clickable:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.2) !important;
    background-color: auto;
}

/* Efecto sutil para todas las cards de estadísticas */
.card.shadow {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card.shadow:hover {
    transform: translateY(-1px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

/* Estilos adicionales para los bordes de las cards */
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}

.border-left-danger {
    border-left: 0.25rem solid #e74a3b !important;
}

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}

/* Mejorar la transparencia del ícono cuando está en el mensaje de éxito */
.text-center .fas.fa-clipboard-check.fa-3x.text-success {
    opacity: 0.4;
}
</style>

@endsection
