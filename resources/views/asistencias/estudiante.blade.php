{{-- filepath: resources/views/asistencias/estudiante.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', 'Mi Historial de Asistencias')
@section('content')

<div class="container py-4" style="background: #f8f9fc; min-height: 70vh; border-radius: 12px;">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-user-check me-2 text-primary"></i>
                        Mi Historial de Asistencias
                    </h1>
                    <p class="mb-0 text-muted">Consulta tu registro de asistencias a clases</p>
                </div>
                <div class="badge bg-primary p-2">
                    <i class="fas fa-calendar me-1"></i>
                    Total: {{ $asistencias->total() }} registros
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas rápidas -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Asistencias
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php
                                    $asistencias_presentes = 0;
                                    foreach($asistencias as $item) {
                                        if($item->asistio == 1) $asistencias_presentes++;
                                    }
                                @endphp
                                {{ $asistencias_presentes }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Ausencias
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php
                                    $asistencias_ausentes = 0;
                                    foreach($asistencias as $item) {
                                        if($item->asistio == 0) $asistencias_ausentes++;
                                    }
                                @endphp
                                {{ $asistencias_ausentes }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                % Asistencia
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php
                                    $total_asistencias = $asistencias->count();
                                    $presentes = 0;
                                    foreach($asistencias as $item) {
                                        if($item->asistio == 1) $presentes++;
                                    }
                                    $porcentaje = $total_asistencias > 0 ? round(($presentes / $total_asistencias) * 100, 1) : 0;
                                @endphp
                                {{ $porcentaje }}%
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-pie fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de asistencias -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list me-2"></i>
                Detalle de Asistencias
            </h6>
        </div>
        <div class="card-body">
            @if($asistencias->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">#</th>
                                <th>Clase</th>
                                <th>Fecha</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Registrado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asistencias as $index => $asistencia)
                                <tr>
                                    <td class="text-center">
                                        <span class="badge bg-secondary">{{ $asistencias->firstItem() + $index }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $asistencia->clase->tema ?? 'Clase sin tema' }}</strong>
                                            @if($asistencia->clase && $asistencia->clase->curso)
                                                <br>
                                                <small class="text-muted">
                                                    <i class="fas fa-book me-1"></i>
                                                    {{ $asistencia->clase->curso->nombre_curso }}
                                                </small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($asistencia->clase && $asistencia->clase->fecha)
                                            <div>
                                                <strong>{{ \Carbon\Carbon::parse($asistencia->clase->fecha)->format('d/m/Y') }}</strong>
                                                <br>
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar me-1"></i>
                                                    {{ \Carbon\Carbon::parse($asistencia->clase->fecha)->diffForHumans() }}
                                                </small>
                                            </div>
                                        @else
                                            <span class="text-muted">Fecha no disponible</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($asistencia->asistio)
                                            <span class="badge bg-success px-3 py-2">
                                                <i class="fas fa-check me-1"></i>
                                                Presente
                                            </span>
                                        @else
                                            <span class="badge bg-danger px-3 py-2">
                                                <i class="fas fa-times me-1"></i>
                                                Ausente
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $asistencia->created_at->format('d/m/Y H:i') }}
                                        </small>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No hay registros de asistencia</h5>
                    <p class="text-muted">Aún no tienes registros de asistencia a clases</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Paginación -->
    @if($asistencias->hasPages())
        <div class="row">
            <div class="col-md-12 text-end">
                {{ $asistencias->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif

    <!-- Botón de regreso -->
    <div class="row mt-4">
        <div class="col-12 text-center">
            <a href="{{ route('estudiante.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Volver al Dashboard
            </a>
        </div>
    </div>
</div>

<!-- Custom styles -->
<style>
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-danger {
    border-left: 0.25rem solid #e74a3b !important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}
.table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.075);
}
</style>
@endsection
