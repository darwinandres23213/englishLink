{{-- filepath: resources/views/dashboards/secretario.blade.php --}}
@extends('layouts.AreaInterna.app')

@section('title', 'Dashboard Secretario')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Dashboard Secretario</h1>
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
    
    <!-- Cards de estadísticas del secretario -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Gestión
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Administrativa</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>
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
                                Matrículas
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Procesadas</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-plus fa-2x text-gray-300"></i>
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
                                Documentos
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Pendientes</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-folder-open fa-2x text-gray-300"></i>
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
                                Comunicaciones
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Activas</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-phone fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Acceso rápido para secretario -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Panel Administrativo</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('matriculas.index') }}" class="btn btn-primary btn-block">
                                <i class="fas fa-user-graduate me-2"></i>
                                Gestión Matrículas
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('usuarios.index') }}" class="btn btn-success btn-block">
                                <i class="fas fa-users me-2"></i>
                                Registro Estudiantes
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('pagos.index') }}" class="btn btn-info btn-block">
                                <i class="fas fa-dollar-sign me-2"></i>
                                Control de Pagos
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('horarios.index') }}" class="btn btn-warning btn-block">
                                <i class="fas fa-calendar me-2"></i>
                                Consulta Horarios
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('mensajes.index') }}" class="btn btn-secondary btn-block">
                                <i class="fas fa-envelope me-2"></i>
                                Mensajería
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('notas.index') }}" class="btn btn-dark btn-block">
                                <i class="fas fa-file-invoice me-2"></i>
                                Consulta Notas
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('asistencias.index') }}" class="btn btn-light btn-block">
                                <i class="fas fa-clipboard-check me-2"></i>
                                Control Asistencia
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

    <!-- Herramientas de oficina -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Herramientas de Oficina</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 mb-3">
                            <a href="#" class="btn btn-outline-primary btn-block">
                                <i class="fas fa-print me-2"></i>
                                Imprimir Certificados
                            </a>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-3">
                            <a href="#" class="btn btn-outline-success btn-block">
                                <i class="fas fa-file-export me-2"></i>
                                Generar Reportes
                            </a>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-3">
                            <a href="#" class="btn btn-outline-info btn-block">
                                <i class="fas fa-archive me-2"></i>
                                Archivo Documentos
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información adicional para secretario -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tareas del Día</h6>
                </div>
                <div class="card-body">
                    <div class="small text-muted">
                        <i class="fas fa-tasks me-1"></i>
                        Lista de actividades administrativas pendientes
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recordatorios</h6>
                </div>
                <div class="card-body">
                    <div class="small text-muted">
                        <i class="fas fa-bell me-1"></i>
                        Fechas importantes y recordatorios administrativos
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

<!-- Custom styles para el dashboard secretario -->
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
