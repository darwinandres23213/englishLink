{{-- filepath: resources/views/usuarios/show.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', 'Detalle de Usuario')
@section('content')




<div class="container py-4" style="max-width: 850px; min-height: 70vh;">
    <h1 class="fw-bold mb-4">
        <i class="bi bi-info-square me-3"></i>Información del usuario: <!-- {{ $usuario->nombre }} {{ $usuario->apellido }} -->
    </h1>
    <div class="d-flex flex-column flex-md-row gap-5 py-4" style="max-width:600px; margin:auto;"> <!-- align-items-center -->
        <div class="flex-shrink-0 text-center">
            @php
                $tamanoImagen = isset($tamanoImagen) ? $tamanoImagen : 180;
            @endphp
            <img src="{{ $usuario->url_imagen_perfil ?? asset('uploads/' . ($usuario->imagen ?? 'UsuarioSinPerfil.png')) }}" alt="Imagen de usuario" width="{{ $tamanoImagen }}" height="{{ $tamanoImagen }}" style="object-fit:cover; border-radius:0;">
        </div>
        <div class="flex-grow-1 w-100">
            <h3 class="fw-bold mb-4">{{ $usuario->nombre }} {{ $usuario->apellido }}</h3>
            <p class="mb-2 text-muted ms-4"><i class="bi bi-key-fill me-2"></i>Id: {{ $usuario->id_usuario }}</p>
            <p class="mb-2 text-muted ms-4"><i class="bi bi-envelope me-2"></i>{{ $usuario->email }}</p>
            <p class="mb-3 text-muted ms-4"><i class="bi bi-person-badge me-2"></i>{{ $usuario->rol->nombre_rol ?? 'Sin rol' }}</p>
            <span class="badge mb-4 ms-4
                @switch($usuario->estado->nombre_estado ?? '')
                    @case('Activo') bg-success @break
                    @case('Inactivo') bg-secondary @break
                    @case('Suspendido') bg-danger @break
                    @case('Pendiente') bg-warning @break
                    @default bg-secondary
                @endswitch
                " style="min-width: 80px; display: inline-block; text-align: center; font-size:1rem;">
                {{ $usuario->estado->nombre_estado ?? 'N/A' }}
            </span>
            <div class="mt-5 ms-4 d-flex gap-2 py-4">
                <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left">
                        Volver
                    </i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection