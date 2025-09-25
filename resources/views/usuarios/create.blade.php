{{-- filepath: resources/views/usuarios/create.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', $edit ? 'Editar Usuario' : 'Nuevo Usuario')
@section('content')

<div class="container py-1">
    <div class="card-header bg-transparent text-primary mb-1">
        <h1 class="fw-bold">
            {{ $edit ? 'Editar Usuario ' : 'Nuevo Usuario ' }} 
            <!-- <i class="bi bi-person"></i> -->
            <i class="bi bi-person-plus"></i>
            <!-- <i class="bi bi-person-circle"></i>
            <i class="bi bi-person-fill"></i>
            <i class="bi bi-person-lines-fill"></i>
            <i class="bi bi-person-badge"></i> -->
        </h1>
    </div>
    
    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('usuarios.update', $usuario) : route('usuarios.store') }}" enctype="multipart/form-data">
            @csrf
            @if($edit)
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                <input type="text" name="nombre" id="nombre" class="form-control" maxlength="100"
                    value="{{ old('nombre', $usuario->nombre ?? '') }}" required>
                @error('nombre')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido <span class="text-danger">*</span></label>
                <input type="text" name="apellido" id="apellido" class="form-control" maxlength="100"
                    value="{{ old('apellido', $usuario->apellido ?? '') }}" required>
                @error('apellido')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" id="email" class="form-control" maxlength="100"
                    value="{{ old('email', $usuario->email ?? '') }}" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            @if(!$edit)
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña <span class="text-danger">*</span></label>
                <input type="password" name="contrasena" id="contrasena" class="form-control" required>
                @error('contrasena')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            @endif
            
            <div class="mb-3">
                <label for="rol_id" class="form-label">Rol <span class="text-danger">*</span></label>
                <select name="rol_id" id="rol_id" class="form-select" required>
                    <option value="">Seleccione un rol</option>
                    @foreach($roles as $rol)
                        <option value="{{ $rol->id_rol }}" {{ old('rol_id', $usuario->rol_id ?? '') == $rol->id_rol ? 'selected' : '' }}>
                            {{ $rol->nombre_rol }}
                        </option>
                    @endforeach
                </select>
                @error('rol_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="estado_id" class="form-label">Estado <span class="text-danger">*</span></label>
                <select name="estado_id" id="estado_id" class="form-select" required>
                    <option value="">Seleccione un estado</option>
                    @foreach($estados as $estado)
                        <option value="{{ $estado->id_estado }}" {{ old('estado_id', $usuario->estado_id ?? '') == $estado->id_estado ? 'selected' : '' }}>
                            {{ $estado->nombre_estado }}
                        </option>
                    @endforeach
                </select>
                @error('estado_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen de perfil</label>
                <input type="file" name="imagen" id="imagen" class="form-control">
                @if($edit && $usuario->imagen)
                    <img src="{{ asset('uploads/' . $usuario->imagen) }}" alt="Imagen" width="60" class="mt-2 rounded-circle">
                @endif
                @error('imagen')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2 justify-content-end py-4">
                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left">
                        Cancelar
                    </i>
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"> 
                        {{ $edit ? 'Actualizar' : 'Crear' }}
                    </i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection