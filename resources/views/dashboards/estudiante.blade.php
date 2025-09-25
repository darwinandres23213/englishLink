{{-- filepath: resources/views/dashboards/estudiante.blade.php --}}
@extends('layouts.AreaInterna.app')

@section('title', 'Dashboard Estudiante')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            {{-- Componente Blade: 'HeaderDashboards.blade.php' --}}
            <x-HeaderDashboards :user="Auth::user()" :rol="Auth::user()->rol->nombre_rol" />
        </div>
    </div>
    
    <!-- Cards de estadísticas del estudiante -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Actividades
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['total'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Entregadas
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['entregadas'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pendientes
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['pendientes'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Calificadas
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['calificadas'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-star fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Acceso rápido para estudiante -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Mi Portal Estudiantil</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('estudiante.actividades') }}" class="btn btn-primary btn-block">
                                <i class="fas fa-tasks me-2"></i>
                                Mis Actividades
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('matriculas.index') }}" class="btn btn-success btn-block">
                                <i class="fas fa-graduation-cap me-2"></i>
                                Mis Matrículas
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('notas.index') }}" class="btn btn-info btn-block">
                                <i class="fas fa-star me-2"></i>
                                Mis Calificaciones
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('horarios.index') }}" class="btn btn-warning btn-block">
                                <i class="fas fa-clock me-2"></i>
                                Horarios de Clase
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('evaluaciones.index') }}" class="btn btn-secondary btn-block">
                                <i class="fas fa-clipboard-list me-2"></i>
                                Evaluaciones
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('estudiante.asistencias') }}" class="btn btn-dark btn-block">
                                <i class="fas fa-user-check me-2"></i>
                                Mi Asistencia
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('pagos.index') }}" class="btn btn-outline-primary btn-block">
                                <i class="fas fa-receipt me-2"></i>
                                Mis Pagos
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('mensajes.index') }}" class="btn btn-outline-secondary btn-block">
                                <i class="fas fa-envelope me-2"></i>
                                Mensajes
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('profile') }}" class="btn btn-outline-primary btn-block">
                                <i class="fas fa-user-edit me-2"></i>
                                Mi Perfil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información adicional para el estudiante -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Próximas Clases</h6>
                </div>
                <div class="card-body">
                    <div class="small text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Aquí aparecerán tus próximas clases programadas
                    </div>
                    <!-- Aquí se puede agregar lógica para mostrar las próximas clases -->
                </div>
            </div>
        </div>
        
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Notificaciones Recientes</h6>
                </div>
                <div class="card-body">
                    <div class="small text-muted">
                        <i class="fas fa-bell me-1"></i>
                        Mantente al día con las últimas actualizaciones
                    </div>
                    <!-- Aquí se puede agregar lógica para mostrar notificaciones -->
                </div>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript para prevenir navegación hacia atrás --}}
<script>
// Prevenir botón atrás del navegador
(function (global) {
    if(typeof (global) === "undefined") {
        throw new Error("window is undefined");
    }

    var _hash = "!";
    var noBackPlease = function () {
        global.location.href += "#";
        global.setTimeout(function () {
            global.location.href += "!";
        }, 50);
    };

    global.onhashchange = function () {
        if (global.location.hash !== _hash) {
            global.location.hash = _hash;
        }
    };

    global.onload = function () {
        noBackPlease();
        
        // Limpiar historial del navegador
        global.document.addEventListener("DOMContentLoaded", function(event) {
            global.history.pushState(null, "", global.location.href);
            global.onpopstate = function () {
                global.history.pushState(null, "", global.location.href);
            };
        });
    };
})(window);
</script>

<!-- Custom styles para el dashboard estudiante -->
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
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}
.btn-block {
    display: block;
    width: 100%;
}
</style>
@endsection
