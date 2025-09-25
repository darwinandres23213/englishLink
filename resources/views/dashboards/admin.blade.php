{{-- filepath: resources/views/dashboards/admin.blade.php --}}
@extends('layouts.AreaInterna.app')

@section('title', 'Dashboard Administrador')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            {{-- <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Bienvenido, {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</h1>
                    <p class="mb-0 text-muted">Dashboard <strong>Administrador</strong></p>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-sign-out-alt me-1"></i> Cerrar Sesión
                    </button>
                </form>
            </div> --}}

            {{-- Componente Blade: 'HeaderDashboards.blade.php' --}}
            <x-HeaderDashboards :user="Auth::user()" :rol="Auth::user()->rol->nombre_rol" />
        </div>
    </div>
    
    <!-- Cards de estadísticas -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Gestión Completa
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Sistema</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cogs fa-2x text-gray-300"></i>
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
                                Usuarios
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Total</div>
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
                                Pagos
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Gestión</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Análisis</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-area fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botones de acceso rápido -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Acceso Rápido</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('mediopago.index') }}" class="btn btn-primary btn-block">
                                <i class="fas fa-credit-card me-2"></i>
                                Medios de Pago
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('pagos.index') }}" class="btn btn-success btn-block">
                                <i class="fas fa-money-bill-wave me-2"></i>
                                Gestión de Pagos
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('asignacion-actividades.index') }}" class="btn btn-info btn-block">
                                <i class="fas fa-tasks me-2"></i>
                                Actividades
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('registro_actividades.index') }}" class="btn btn-warning btn-block">
                                <i class="fas fa-history me-2"></i>
                                Registro
                            </a>
                        </div>
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

<!-- Custom styles para el admin dashboard -->
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
</style>
@endsection