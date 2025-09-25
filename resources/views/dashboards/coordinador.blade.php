{{-- filepath: resources/views/dashboards/coordinador.blade.php --}}
@extends('layouts.AreaInterna.app')

@section('title', 'Dashboard Coordinador')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Dashboard Coordinador</h1>
                    <p class="mb-0 text-muted">Bienvenido, {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-sign-out-alt me-1"></i> Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Cards de estadísticas del coordinador -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Coordinación
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Académica</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-sitemap fa-2x text-gray-300"></i>
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
                                Profesores
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Gestión</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
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
                                Cursos
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Supervisión</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
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
                                Reportes
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Académicos</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Acceso rápido para coordinador -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Panel de Coordinación</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('cursos.index') }}" class="btn btn-primary btn-block">
                                <i class="fas fa-book-open me-2"></i>
                                Gestión de Cursos
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('horarios.index') }}" class="btn btn-success btn-block">
                                <i class="fas fa-calendar-alt me-2"></i>
                                Planificación Horarios
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('usuarios.index') }}" class="btn btn-info btn-block">
                                <i class="fas fa-user-tie me-2"></i>
                                Gestión Profesores
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('evaluaciones.index') }}" class="btn btn-warning btn-block">
                                <i class="fas fa-clipboard-list me-2"></i>
                                Supervisar Evaluaciones
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('matriculas.index') }}" class="btn btn-secondary btn-block">
                                <i class="fas fa-graduation-cap me-2"></i>
                                Gestión Matrículas
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('asignacion-actividades.index') }}" class="btn btn-dark btn-block">
                                <i class="fas fa-tasks me-2"></i>
                                Asignación Actividades
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('mensajes.index') }}" class="btn btn-light btn-block">
                                <i class="fas fa-envelope me-2"></i>
                                Comunicaciones
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('profile') }}" class="btn btn-outline-primary btn-block">
                                <i class="fas fa-user-cog me-2"></i>
                                Mi Perfil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información adicional para coordinador -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Resumen Académico</h6>
                </div>
                <div class="card-body">
                    <div class="small text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Vista general del rendimiento académico institucional
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Alertas de Coordinación</h6>
                </div>
                <div class="card-body">
                    <div class="small text-muted">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        Notificaciones importantes para la coordinación académica
                    </div>
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

<!-- Custom styles para el dashboard coordinador -->
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
