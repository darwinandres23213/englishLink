{{-- filepath: resources/views/roles/create.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', $edit ? 'Editar Rol' : 'Nuevo Rol')
@section('content')

<div class="container py-1">
    <div class="card-header bg-transparent text-primary mb-1">
        <h1 class="fw-bold">
            {{ $edit ? 'Editar Rol ' : 'Nuevo Rol ' }} 
            <i class="bi bi-shield-lock"></i>
        </h1>
    </div>
        


    <div class="card-body">
        <form method="POST" action="{{ $edit ? route('roles.update', $rol) : route('roles.store') }}">
            @csrf
            @if($edit)
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="nombre_rol" class="form-label">Nombre del Rol <span class="text-danger">*</span></label>
                <input type="text" name="nombre_rol" id="nombre_rol" maxlength="50" class="form-control"
                        value="{{ old('nombre_rol', $rol->nombre_rol ?? '') }}" required>
                @error('nombre_rol')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2 justify-content-end">
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> {{ $edit ? 'Actualizar' : 'Crear' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection




{{-- filepath: resources/views/roles/create.blade.php --}}
{{-- @extends('layouts.AreaInterna.app')
@section('title', $edit ? 'Editar Rol' : 'Nuevo Rol')
@section('content')

<div class="container py-4" style="background: #f8f9fc; min-height: 70vh; border-radius: 12px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">{{ $edit ? 'Editar Rol' : 'Nuevo Rol' }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{-- $edit ? route('roles.update', $rol) : route('roles.store') --}} {{--">
                        @csrf
                        @if($edit)
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="nombre_rol" class="form-label">Nombre del Rol <span class="text-danger">*</span></label>
                            <input type="text" name="nombre_rol" id="nombre_rol" maxlength="50" class="form-control"
                                   value="{{-- old('nombre_rol', $rol->nombre_rol ?? '') --}} {{--" required>
                            @error('nombre_rol')
                                <div class="text-danger">{{-- $message --}} {{--</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{-- route('roles.index') --}} {{--" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> {{-- $edit ? 'Actualizar' : 'Crear' --}} {{--
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}