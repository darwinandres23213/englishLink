{{-- Componente Blade: Para los dashboard's --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-0 text-gray-700 fw-bold">
            Bienvenido {{ $user->nombre }} {{ $user->apellido }}
        </h1>
        <p class="ms-4 mb-4 text-muted">
            (Dashboard <strong>{{ $rol }}</strong>)
        </p>
    </div>

    <!-- Formulario de cierre de sesión -->
    {{-- <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <button type="submit" class="btn btn-outline-danger">
            <i class="fas fa-sign-out-alt me-1"></i> Cerrar Sesión
        </button>
    </form> --}}
</div>
