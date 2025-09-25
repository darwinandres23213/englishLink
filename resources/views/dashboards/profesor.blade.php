{{-- filepath: resources/views/dashboards/profesor.blade.php --}}
@extends('layouts.AreaInterna.app')

@section('title', 'Dashboard Profesor')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            {{-- Componente Blade: 'HeaderDashboards.blade.php' --}}
            <x-HeaderDashboards :user="Auth::user()" :rol="Auth::user()->rol->nombre_rol" />
        </div>
    </div>
    

    <!-- Cards de estadísticas del profesor -->
    <!-- Mis Cursos -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('profesor.mis-clases') }}" class="text-decoration-none">
                <div class="card border-left-primary shadow h-100 py-2 card-hover">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-gray-500 text-uppercase mb-1">
                                    Mis
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-primary">Cursos</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-journal-bookmark-fill fa-2x text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>


        <!-- Total Estudiantes -->
        <!-- div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-gray-500 text-uppercase mb-1">
                                Total
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-success">Estudiantes</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div -->


        <!-- Evaluaciones Pendientes -->
        <!-- div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Evaluaciones
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Pendientes</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div -->


        <!-- Asistencia Hoy -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('asistencias.index') }}" class="text-decoration-none">
                <div class="card border-left-warning shadow h-100 py-2 card-hover">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-gray-500 text-uppercase mb-1">
                                    Tomar
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-warning">Asistencia</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-clipboard-check-fill fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>


    <!-- Acceso rápido para profesor -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Panel de Gestión Académica</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-2 col-md-6 mb-3">
                            <a href="{{ route('profesor.mis-clases') }}" class="btn btn-outline-primary btn-block">
                                <i class="bi bi-journal-bookmark-fill me-2"></i>
                                Mis Cursos 1️⃣
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('actividades.create') }}" class="btn btn-outline-success btn-block">
                                <i class="bi bi-plus-square me-2"></i>
                                Crear Actividad 1️⃣
                            </a>
                        </div>
                        
                        <!-- div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('asignacion-actividades.index') }}" class="btn btn-info btn-block">
                                <i class="fas fa-clipboard-list me-2"></i>
                                ❌Asignar Actividades
                            </a>
                        </div -->

                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('actividades.index') }}" class="btn btn-outline-danger btn-block">
                                <i class="bi bi-list-task me-2"></i>
                                Gestión de Actividades 1️⃣
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('clases.index') }}" class="btn btn-warning btn-block">
                                <i class="fas fa-chalkboard me-2"></i>
                                Gestión de Clases ✅
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('evaluaciones.index') }}" class="btn btn-secondary btn-block">
                                <i class="fas fa-file-alt me-2"></i>
                                Crear Evaluaciones ➖
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('notas.index') }}" class="btn btn-dark btn-block">
                                <i class="fas fa-edit me-2"></i>
                                Calificar ➖
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('asistencias.registrar.masivo') }}" class="btn btn-outline-primary btn-block">
                                <i class="fas fa-clipboard-check me-2"></i>
                                Tomar Asistencia por Clase ✅
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('asistencias.index') }}" class="btn btn-outline-secondary btn-block">
                                <i class="fas fa-list me-2"></i>
                                Ver Asistencias ✅
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('horarios.index') }}" class="btn btn-outline-secondary btn-block">
                                <i class="fas fa-calendar me-2"></i>
                                Mis Horarios ➖
                            </a>
                        </div>
                        
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('recuperaciones.index') }}" class="btn btn-outline-warning btn-block">
                                <i class="fas fa-redo me-2"></i>
                                Recuperaciones ➖
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('mensajes.index') }}" class="btn btn-outline-info btn-block">
                                <i class="fas fa-comments me-2"></i>
                                Mensajes ❌
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Herramientas adicionales para profesor -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Clases de Hoy ❌</h6>
                </div>
                <div class="card-body">
                    <div class="small text-muted">
                        <i class="fas fa-clock me-1"></i>
                        Aquí aparecerán las clases programadas para hoy
                    </div>
                    <!-- Aquí se puede agregar lógica para mostrar las clases del día -->
                </div>
            </div>
        </div>
        
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tareas por Revisar ✅</h6>
                </div>
                <div class="card-body">
                    <div class="small text-muted">
                        <i class="fas fa-tasks me-1"></i>
                        Evaluaciones y tareas pendientes de calificación
                    </div>
                    <!-- Aquí se puede agregar lógica para mostrar tareas pendientes -->
                </div>
            </div>
        </div>
    </div>


    <!-- Herramientas de reportes -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Reportes y Análisis ✅</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 mb-3">
                            <a href="#" class="btn btn-outline-primary btn-block">
                                <i class="fas fa-chart-bar me-2"></i>
                                Reporte de Asistencia
                            </a>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-3">
                            <a href="#" class="btn btn-outline-success btn-block">
                                <i class="fas fa-chart-line me-2"></i>
                                Rendimiento Académico
                            </a>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-3">
                            <a href="#" class="btn btn-outline-info btn-block">
                                <i class="fas fa-file-export me-2"></i>
                                Exportar Calificaciones
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

<!-- Custom styles para el dashboard profesor -->
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
