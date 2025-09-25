{{-- filepath: resources/views/notificaciones/create.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', isset($notificacione) ? 'Editar Notificación' : 'Nueva Notificación')
@section('content')

<div class="container py-4" style="background: #f8f9fc; min-height: 70vh; border-radius: 12px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">{{ isset($notificacione) ? 'Editar Notificación' : 'Nueva Notificación' }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ isset($notificacione) ? route('notificaciones.update', $notificacione->id) : route('notificaciones.store') }}">
                        @csrf
                        @if(isset($notificacione))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="usuario_id" class="form-label">Usuario</label>
                            <select name="usuario_id" id="usuario_id" class="form-select" required>
                                <option value="">Seleccione un usuario</option>
                                @foreach($usuarios as $usuario)
                                    <option value="{{ $usuario->id_usuario }}" {{ old('usuario_id', $notificacione->usuario_id ?? '') == $usuario->id_usuario ? 'selected' : '' }}>
                                        {{ $usuario->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('usuario_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="mensaje" class="form-label">Mensaje</label>
                            <textarea name="mensaje" id="mensaje" class="form-control" required>{{ old('mensaje', $notificacione->mensaje ?? '') }}</textarea>
                            @error('mensaje')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo</label>
                            <select name="tipo" id="tipo" class="form-select" required>
                                <option value="">Seleccione un tipo</option>
                                <option value="Sistema" {{ old('tipo', $notificacione->tipo ?? '') == 'Sistema' ? 'selected' : '' }}>Sistema</option>
                                <option value="Curso" {{ old('tipo', $notificacione->tipo ?? '') == 'Curso' ? 'selected' : '' }}>Curso</option>
                                <option value="Usuario" {{ old('tipo', $notificacione->tipo ?? '') == 'Usuario' ? 'selected' : '' }}>Usuario</option>
                            </select>
                            @error('tipo')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="estado_id" class="form-label">Estado</label>
                            <select name="estado_id" id="estado_id" class="form-select" required>
                                <option value="">Seleccione un estado</option>
                                @foreach($estados as $estado)
                                    <option value="{{ $estado->id_estado }}" {{ old('estado_id', $notificacione->estado_id ?? '') == $estado->id_estado ? 'selected' : '' }}>
                                        {{ $estado->nombre_estado }}
                                    </option>
                                @endforeach
                            </select>
                            @error('estado_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="fecha_envio" class="form-label">Fecha de Envío</label>
                            <input type="datetime-local" name="fecha_envio" id="fecha_envio" class="form-control" value="{{ old('fecha_envio', isset($notificacione) && $notificacione->fecha_envio ? \Illuminate\Support\Str::replace(' ', 'T', $notificacione->fecha_envio) : '') }}">
                            @error('fecha_envio')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('notificaciones.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection