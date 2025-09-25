{{-- componente: Botton logout con variantes de estilo --}}

@props(['variant' => 'dropdown'])

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>


@if($variant === 'para_sidebar')
    <button type="submit" form="logout-form" class="nav-link btn btn-link" style="text-decoration: none; width: 100%; text-align: left;">
        <i class="fa-solid fa-right-from-bracket"></i>
        <span>Cerrar Sesión</span>
    </button>
@else
    {{-- Para Dropdown 'Default' --}}
    <a class="dropdown-item text-gray-600" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-600"></i>
        Cerrar sesión
    </a>
@endif