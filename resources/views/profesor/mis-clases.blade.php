{{-- filepath: resources/views/profesor/mis-clases.blade.php --}}
@extends('layouts.AreaInterna.app')

@section('title', 'Mis Clases - Profesor')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="fw-bold">
                        <i class="fas fa-chalkboard-teacher me-3"></i>Mis Cursos
                    </h1>
                    <p class="ms-4 mb-0 text-muted">
                        Cursos que diriges, {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}
                    </p>
                </div>
                <a href="{{ route('profesor.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Volver al Inicio
                </a>
            </div>
        </div>
    </div>

    <!-- Estadísticas rápidas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Cursos
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalCursos }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Estudiantes
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalEstudiantes }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- div class="col-md-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Estado
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Activo</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div -->
    </div>

    <!-- Lista de cursos -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">
                <i class="bi bi-list-check me-2"></i>
                Cursos a cargo
            </h5>
        </div>
        <div class="card-body">
            @if($cursosDelProfesor->count() > 0)
                <div class="row">
                    @foreach($cursosDelProfesor as $curso)
                        <div class="col-lg-6 col-xl-4 mb-4">
                            <a href="{{ route('profesor.curso.detalle', $curso->id_curso) }}" class="text-decoration-none">
                                <div class="card border-left-primary h-100 card-hover">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-0">
                                            <h4 class="card-title text-primary font-weight-bold mb-0">
                                                <!-- i class="fas fa-book-open me-2"></i -->
                                                {{ $curso->nombre_curso }}
                                            </h4>
                                            <span class="badge badge-primary">{{ $curso->nivel->nombre_nivel ?? 'N/A' }}</span>
                                        </div>
                                    
                                    <!-- Descripción del curso -->
                                    <div class="mb-4">
                                        <p class="ms-2 card-text text-muted small">
                                            <!-- i class="fas fa-info-circle me-2"></i -->
                                            {{ Str::limit($curso->descripcion ?? 'Sin descripción disponible', 120) }}
                                        </p>
                                    </div>

                                    <!-- Información del curso (Estudiantes, Horario) -->
                                    <div class="mb-3">
                                        <div class="row text-center">
                                            <div class="col-6">
                                                <div class="border-right">
                                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                                        {{ $curso->matriculas->count() }}
                                                    </div>
                                                    <div class="small text-muted">Estudiantes</div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="h6 mb-0 font-weight-bold text-gray-800">
                                                    @if($curso->horario)
                                                        {{ $curso->horario->nombre_horario }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </div>
                                                <!-- div class="small text-muted">
                                                    @if($curso->horario && $curso->horario->hora_inicio && $curso->horario->hora_fin)
                                                        {{ \Carbon\Carbon::parse($curso->horario->hora_inicio)->format('g:i A') }} - {{ \Carbon\Carbon::parse($curso->horario->hora_fin)->format('g:i A') }}
                                                    @else
                                                        Horario por definir
                                                    @endif
                                                </div -->
                                                <div class="small text-muted">Horario</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Lista de estudiantes -->
                                    <!-- @if($curso->matriculas->count() > 0)
                                        <div class="mb-3">
                                            <h6 class="text-gray-800 mb-2">
                                                <i class="fas fa-users me-2"></i>
                                                Estudiantes:
                                            </h6>
                                            <div class="student-list" style="max-height: 150px; overflow-y: auto;">
                                                @foreach($curso->matriculas as $matricula)
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="avatar-sm me-2">
                                                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                                <i class="fas fa-user text-white" style="font-size: 14px;"></i>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="font-weight-bold text-gray-800" style="font-size: 14px;">
                                                                {{ $matricula->estudiante->nombre ?? 'N/A' }} {{ $matricula->estudiante->apellido ?? '' }}
                                                            </div>
                                                            <div class="text-muted" style="font-size: 12px;">
                                                                {{ $matricula->estudiante->email ?? 'Sin email' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif -->

                                    <!-- Indicador visual para hacer clic -->
                                    <div class="text-center mt-3">
                                        <small class="text-muted">
                                            <i class="fas fa-mouse-pointer me-1"></i>
                                            Clic para ver detalles del curso
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-chalkboard-teacher fa-3x text-gray-300 mb-3"></i>
                    <h4 class="text-gray-600">No tienes cursos asignados</h4>
                    <p class="text-muted">Contacta con el administrador para que te asigne cursos.</p>
                    <a href="{{ route('profesor.dashboard') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Volver al Dashboard
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Acciones rápidas -->
    @if($cursosDelProfesor->count() > 0)
    
    <!-- div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-tools me-2"></i>
                Acciones Rápidas
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-2">
                    <a href="{{ route('actividades.create') }}" class="btn btn-success btn-block">
                        <i class="fas fa-plus me-2"></i>
                        Nueva Actividad
                    </a>
                </div>
                <div class="col-md-3 mb-2">
                    <a href="{{ route('asistencias.registrar.masivo') }}" class="btn btn-info btn-block">
                        <i class="fas fa-clipboard-check me-2"></i>
                        Tomar Asistencia
                    </a>
                </div>
                <div class="col-md-3 mb-2">
                    <a href="{{ route('notas.index') }}" class="btn btn-warning btn-block">
                        <i class="fas fa-edit me-2"></i>
                        Calificar
                    </a>
                </div>
                <div class="col-md-3 mb-2">
                    <a href="{{ route('evaluaciones.index') }}" class="btn btn-secondary btn-block">
                        <i class="fas fa-file-alt me-2"></i>
                        Evaluaciones
                    </a>
                </div>
            </div>
        </div>
    </div -->
    @endif
</div>

<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}
.badge {
    font-size: 0.75em;
}
.student-list {
    border: 1px solid #e3e6f0;
    border-radius: 0.375rem;
    padding: 0.75rem;
    background-color: #f8f9fc;
}
.btn-block {
    display: block;
    width: 100%;
}
.card-hover {
    transition: transform 0.2s, box-shadow 0.2s;
}
.card-hover:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.25rem 2rem 0 rgba(58, 59, 69, 0.25) !important;
}
.text-decoration-none {
    text-decoration: none !important;
}
.text-decoration-none:hover {
    text-decoration: none !important;
}
</style>
@endsection
