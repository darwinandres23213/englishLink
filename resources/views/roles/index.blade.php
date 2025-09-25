@extends('layouts.AreaInterna.app')
@section('title', 'Gestión de Roles')
@section('content')

@if(session('success'))
    <div id="toast-success"
        style="
            position: fixed;
            top: 100px;
            left: 75%;
            transform: translateX(-50%);
            z-index: 9999;
            min-width: 340px;
            max-width: 400px;
            background: #b7eac7;
            color: #155724;
            border-radius: 4px;
            box-shadow: 0 4px 24px #1199319f;
            padding: 18px 24px 12px 24px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            opacity: 1;
            transition: opacity 0.5s;
        ">
        <div style="display: flex; align-items: center; margin-bottom: 4px;">
            <svg width="22" height="22" fill="none" stroke="#155724" stroke-width="2" viewBox="0 0 24 24" style="margin-right: 8px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            <span style="font-weight: bold; font-size: 1.1em;">¡Éxito!</span>
        </div>
        <div style="margin-bottom: 8px; margin-left: 30px;">{{ session('success') }}</div>
        <div style="width: 100%; height: 5px; background: #d4f5e9; border-radius: 3px; overflow: hidden;">
            <div id="toast-progress" style="height: 5px; background: #218838; width: 100%; transition: width 0.3s;"></div>
        </div>
    </div>
    <script>
        const toastDuration = 2200;
        const progressBar = document.getElementById('toast-progress');
        let width = 100;
        const interval = 20;
        const decrement = 100 / (toastDuration / interval);

        const timer = setInterval(() => {
            width -= decrement;
            if (progressBar) progressBar.style.width = width + '%';
            if (width <= 0) {
                clearInterval(timer);
            }
        }, interval);

        setTimeout(() => {
            const toast = document.getElementById('toast-success');
            if(toast) toast.style.opacity = '0';
        }, toastDuration);
    </script>
@endif

<div class="container py-4" style="background: #f8f9fc; min-height: 70vh; border-radius: 12px;">
    <h1 class="mb-4 fw-bold">Gestión de Roles</h1>

    
    {{-- Botón para crear un nuevo rol --}}
    <div class="mb-3">
        <a href="{{ route('roles.create') }}" class="btn btn-primary">Nuevo Rol</a>
    </div>


    {{-- Filtros desplegables --}}
    {{-- <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>
                <i class="bi bi-sliders"> Filtros </i>
            </span>
            <button class="btn btn-link text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#filtrosCollapse" aria-expanded="false" aria-controls="filtrosCollapse">
                <i class="bi bi-funnel">Mostrar/Ocultar</i>
            </button>
        </div>

        <div class="collapse" id="filtrosCollapse">
            <div class="card-body">
                <form method="GET" action="{{ route('roles.index') }}" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="nombre_rol" class="form-label">Nombre del Rol</label>
                        <input type="text" name="nombre_rol" id="nombre_rol" class="form-control" value="{{ request('nombre_rol') }}" placeholder="Buscar por nombre">
                    </div>
                </form>
            </div>
        </div>
    </div> --}}


    {{-- Tabla de roles --}}
    <div class="table-responsive rounded shadow-sm" style="background: #fff;">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr class="text-center">
                    <th>ID Rol</th>
                    <th>Nombre del Rol</th>
                    <th> {{-- <th class="text-nowrap text-center" style="width: 140px;"> --}}
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $rol)
                    <tr class="text-center">
                        <td>{{ $rol->id_rol }}</td>
                        <td>{{ $rol->nombre_rol }}</td>
                        <td>
                            <a href="{{ route('roles.edit', $rol) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil" title="Editar Rol"></i>
                            </a>
                            <form action="{{ route('roles.destroy', $rol) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar este rol?')">
                                    <i class="bi bi-trash" title="Eliminar Rol"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if($roles->isEmpty())
                    <tr>
                        <td colspan="3" class="text-center">No se encontraron roles.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="row mt-3">
        <div class="col-md-12 text-end">
            {{ $roles->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection