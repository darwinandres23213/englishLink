{{-- resources/views/components/user-menu.blade.php --}}

@php 
    $usuario = Auth::user(); 
@endphp

<li class="nav-item dropdown no-arrow">
    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline text-white small text-uppercase font-weight-bold">
            {{ $usuario->nombre_completo ?? 'Usuario' }}
        </span>
    <img class="img-profile rounded-circle" src="{{ $usuario->url_imagen_perfil }}" alt="Profile Picture" width="35" height="35">
    </a>
    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in mt-2" aria-labelledby="userDropdown" style="min-width: 220px;">
        <div class="text-center p-2">
            <p class="text-gray-600 mb-1" title="{{ $usuario->email ?? 'correo@ejemplo.com' }}">
                <span>{{ $usuario->email ?? 'correo@ejemplo.com' }}</span>
            </p>
            <div class="dropdown-divider"></div>
            <img class="img-profile rounded-circle mb-2" src="{{ $usuario->url_imagen_perfil }}" alt="Profile Picture" width="70" height="70">
            <h6 class="text-gray-600 font-weight-bold">
                {{ $usuario->nombre_completo ?? 'Usuario de English Link' }}
            </h6>
        </div>
        <a class="dropdown-item text-gray-600" href="{{ route('profile') }}">
            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-600"></i>
            Perfil
        </a>
        <a class="dropdown-item text-gray-600" href="#">
            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-600"></i>
            Configuración
        </a>
        {{-- <a class="dropdown-item text-gray-600" href="#">
            <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-600"></i>
            Actividad
        </a> --}}

        <div class="dropdown-divider"></div>

        <x-Boton-LogOut variant="para_dropdown" />

    </div>
</li>
