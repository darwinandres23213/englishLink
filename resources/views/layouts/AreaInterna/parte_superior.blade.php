{{-- filepath: resources/views/layouts/parte_superior.blade.php --}}




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="{{ asset('img/EL_User2.png') }}">
    <title>@yield('title', 'English Link 🔵🔴')</title>
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('style.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('styles')
    <style>
        /* ...aquí va el CSS personalizado del dropdown del perfil... */
    </style>
</head>
<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-2">English Link <sup>4</sup></div>
            </a>
            <!-- ...resto del sidebar, usa @if(Auth::user()->role == 'admin') para los menús por rol... -->
            <!-- Ejemplo: -->
            @if(Auth::user() && Auth::user()->role === 'admin')
                <!-- Menú solo para admin -->
            @endif
            <!-- ...continúa con el resto del menú, usando sintaxis Blade... -->
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- ...topbar, usa Blade para mostrar datos del usuario... -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    {{ Auth::user()->name ?? 'Usuario' }}
                                </span>
                                <img class="img-profile rounded-circle"
                                    src="{{ Auth::user()->profile_image ? asset('uploads/' . Auth::user()->profile_image) : asset('img/UsuarioSinPerfil.png') }}"
                                    alt="Profile Picture">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <div class="text-center p-3">
                                    <p class="text-gray-600 small mb-1 marquee-email" title="{{ Auth::user()->email }}">
                                        <span>{{ Auth::user()->email ?? 'correo@ejemplo.com' }}</span>
                                    </p>
                                    <div class="dropdown-divider"></div>
                                    <img class="img-profile rounded-circle mb-2"
                                        src="{{ Auth::user()->profile_image ? asset('uploads/' . Auth::user()->profile_image) : asset('img/UsuarioSinPerfil.png') }}"
                                        alt="Profile Picture" width="50">
                                    <h6 class="dropdown-header text-uppercase text-gray-600">
                                        {{ Auth::user()->name ?? 'Usuario' }}
                                    </h6>
                                </div>
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Perfil
                                </a>
                                <a class="dropdown-item" href="{{ route('settings') }}">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Configuración
                                </a>
                                <a class="dropdown-item" href="{{ route('activity_log') }}">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Actividad
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Cerrar sesión
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Contenido principal -->
                <main>
                    @yield('content')
                </main>
            </div>
            @include('layouts.parte_inferior')
        </div>
    </div>
    {{-- @stack('scripts') --}}
</body>
</html>