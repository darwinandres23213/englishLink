{{-- filepath: resources/views/dashboards/general.blade.php --}}
@extends('layouts.AreaInterna.app')

@section('title', 'Dashboard General')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Dashboard General</h1>
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
    
    <!-- Card de bienvenida -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                English Link
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Sistema de Gestión Académica</div>
                            <p class="mb-0 text-muted">Acceso limitado - Contacte al administrador para asignar un rol específico</p>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-info-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Acceso básico -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Acceso Disponible</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 mb-3">
                            <a href="{{ route('profile') }}" class="btn btn-primary btn-block">
                                <i class="fas fa-user me-2"></i>
                                Mi Perfil
                            </a>
                        </div>
                        <div class="col-lg-6 col-md-6 mb-3">
                            <a href="{{ route('mensajes.index') }}" class="btn btn-info btn-block">
                                <i class="fas fa-envelope me-2"></i>
                                Mensajes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información de contacto -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">Necesita Ayuda?</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Acceso Limitado:</strong> Su cuenta no tiene un rol específico asignado. 
                        Para acceder a todas las funcionalidades del sistema, contacte al administrador.
                    </div>
                    <div class="text-center">
                        <p class="mb-0 text-muted">
                            <i class="fas fa-phone me-1"></i> Soporte Técnico: +57 300 123 4567<br>
                            <i class="fas fa-envelope me-1"></i> Email: soporte@englishlink.edu.co
                        </p>
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

<!-- Custom styles para el dashboard general -->
<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
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
