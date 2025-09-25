{{-- filepath: resources/views/usuarios/index.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', 'Usuarios')
@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="container py-4" style="background: #f8f9fc; min-height: 70vh; border-radius: 12px;">
    <h1 class="mb-4 fw-bold">Usuarios</h1>

    {{-- Botón para crear nuevo usuario --}}
    <div class="mb-3">
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary">Nuevo Usuario</a>
    </div>

    {{-- Filtros desplegables --}}
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>
                <i class="bi bi-sliders"> Filtros </i>
            </span>
            <button class="btn btn-link text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#filtrosCollapse" aria-expanded="false" aria-controls="filtrosCollapse">
                <i class="bi bi-funnel">Mostrar/Ocultar</i>
            </button>
        </div>
        
        <div class="collapse{{ (request()->except(['page']) ? ' show' : '') }}" id="filtrosCollapse">
            <div class="card-body">
                <form method="GET" action="{{ route('usuarios.index') }}" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Escriba el nombre del usuario..." value="{{ request('nombre') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Apellido</label>
                        <input type="text" name="apellido" class="form-control" placeholder="Escriba el apellido del usuario..." value="{{ request('apellido') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" placeholder="Escriba el correo electrónico..." value="{{ request('email') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Rol</label>
                        <select name="rol" class="form-select">
                            <option value="">Todos</option>
                            @foreach($roles as $rol)
                                <option value="{{ $rol->id_rol }}" {{ request('rol') == $rol->id_rol ? 'selected' : '' }}>
                                    {{ $rol->nombre_rol }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-select">
                            <option value="">Todos</option>
                            @foreach($estados as $estado)
                                <option value="{{ $estado->id_estado }}" {{ request('estado') == $estado->id_estado ? 'selected' : '' }}>
                                    {{ $estado->nombre_estado }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 d-flex gap-1">
                        <button type="submit" class="btn btn-primary mt-4">
                            <i class="bi bi-search"> Buscar</i>
                        </button>
                        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary mt-4">
                            <i class="bi bi-x-circle"> Limpiar filtros</i>
                        </a>
                        <a href="#" class="btn btn-danger mt-4">
                            <i class="bi bi-file-earmark-pdf"> PDF</i>
                        </a>
                        <a href="#" class="btn btn-success mt-4">
                            <i class="bi bi-file-earmark-excel"> Excel</i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Tabla de usuarios --}}
    <div class="table-responsive rounded shadow-sm" style="background: #fff;">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th class="text-center">Estado</th>
                    <th class="text-center">Imagen</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->id_usuario }}</td>
                        <td>{{ $usuario->nombre }}</td>
                        <td>{{ $usuario->apellido }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td>{{ $usuario->rol->nombre_rol ?? 'N/A' }}</td>

                        <td class="text-center"> 
                            {{-- Estado del usuario con badge --}}
                            <span class="badge 
                                @switch($usuario->estado->nombre_estado ?? '')
                                    @case('Activo')
                                        bg-success
                                        @break
                                    @case('Inactivo')
                                        bg-secondary
                                        @break
                                    @case('Suspendido')
                                        bg-danger
                                        @break
                                    @case('Pendiente')
                                        bg-warning
                                        @break
                                    @default
                                        bg-secondary
                                @endswitch
                            " style="min-width: 80px; display: inline-block; text-align: center;">
                                {{ $usuario->estado->nombre_estado ?? 'N/A' }}
                            </span>
                        </td>

                        <td class="text-center"> 
                            {{-- Imagen del usuario --}}
                            @if($usuario->imagen)
                                <img src="{{ asset('uploads/' . $usuario->imagen) }}" alt="Imagen" width="40" height="40" class="rounded-circle">
                            @else
                                <span class="text-muted">Sin imagen</span>
                            @endif
                        </td>

                        {{-- Botones de acción --}}
                        <td class="text-center"> 
                            <a href="{{ route('usuarios.show', $usuario) }}" class="btn btn-sm btn-outline-info" title="Ver Detalle">
                                <i class="bi bi-search"></i>
                            </a>
                            <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-sm btn-outline-primary" title="Editar Usuario">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar este usuario?')" title="Eliminar Usuario">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if($usuarios->isEmpty())
                    <tr>
                        <td colspan="8" class="text-center">No hay usuarios registrados.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    {{-- Paginación --}}
    <div class="row mt-3">
        <div class="col-md-12 text-end">
            {{ $usuarios->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection