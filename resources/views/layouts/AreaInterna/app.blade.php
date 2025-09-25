<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Panel')</title>

    {{-- ◽Librerias (https)--}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"> <!-- Iconos Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> <!-- Versión minificada de Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"> <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"> <!-- Flatpickr (calendario/selector de fechas) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css"> <!-- Tema azul para el calendario -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> <!-- Iconos de font-awesome -->
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"> <!-- Animaciones font-awesome --> --}}



    {{-- ◽Archivos CSS --}}
    <link rel="stylesheet" href="{{ asset('css/sb-admin-2.min.css') }}"> <!-- Archivo CSS | SB Admin 2 -->
    <link rel="stylesheet" href="{{ asset('css/SidebarAreaInterna.css') }}"> <!-- CSS personalizado del Sidebar -->
    <link rel="stylesheet" href="{{ asset('css/TopbarAreaInterna.css') }}"> <!-- CSS personalizado del Topbar -->

    {{-- ◽Archivos que NO estan funcionando! --}}
    {{-- <link rel="icon" href="asset('img/EL_User2.png')"> <!-- Ícono del sitio (favicon). --> --}}
    {{-- <link href="asset('css/custom.css')" rel="stylesheet"> <!-- ❌Archivo CSS para los correos largos (Navbar:Dropdown) --> --}}
    {{-- <link href="asset('style.css')" rel="stylesheet"> <!-- ❌Archivo CSS personalizado para el chat. --> --}}



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('styles')

</head>
<body id="page-top">
    <div id="wrapper">
        @include('layouts.AreaInterna.sidebar')
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('layouts.AreaInterna.topbar')
                <main class="py-4">
                    <!-- Mensajes de error/éxito -->
                    @if(session('error'))
                        <div class="container mt-3">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-bottom: 1rem;">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                    
                    @if(session('success'))
                        <div class="container mt-3">
                            <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom: 1rem;">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                    
                    @yield('content')
                </main>
                @include('layouts.AreaInterna.footer')
            </div>
            
        </div>
    </div>

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    {{-- Flatpickr JS Global --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

    
    <!-- <script> // ✅ Mejorar la UX del menú lateral
        document.addEventListener('DOMContentLoaded', function() {
            // ✅ Mantener menú abierto según la ruta actual
            const currentPath = window.location.pathname;
            
            // Si estamos en páginas de pagos o medios de pago, mantener el menú abierto
            if (currentPath.includes('/pagos') || currentPath.includes('/mediopago') || 
                currentPath.includes('/asignacion-actividades') || currentPath.includes('/historial_imagenes')) {
                
                const collapseElement = document.getElementById('collapselinksInstructor');
                if (collapseElement) {
                    collapseElement.classList.add('show');
                }
                
                // Quitar clase collapsed del enlace padre
                const parentLink = document.querySelector('[data-target="#collapselinksInstructor"]');
                if (parentLink) {
                    parentLink.classList.remove('collapsed');
                    parentLink.setAttribute('aria-expanded', 'true');
                }
            }
            
            // ✅ Prevenir cierre automático al hacer clic en elementos activos
            document.querySelectorAll('.collapse-item.active').forEach(function(item) {
                item.addEventListener('click', function(e) {
                    // No prevenir la navegación, solo evitar el collapse
                    const parentCollapse = this.closest('.collapse');
                    if (parentCollapse) {
                        parentCollapse.classList.add('show');
                    }
                });
            });
        });
    </script> -->
</body>
</html>