{{-- filepath: resources/views/alertas/create.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', isset($alerta) ? 'Editar Alerta' : 'Nueva Alerta')
@section('content')

<div class="container py-4" style="background: #f8f9fc; min-height: 70vh; border-radius: 12px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">{{ isset($alerta) ? 'Editar Alerta' : 'Nueva Alerta' }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ isset($alerta) ? route('alertas.update', $alerta->id) : route('alertas.store') }}">
                        @csrf
                        @if(isset($alerta))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="usuario_id" class="form-label">Usuario</label>
                            <select name="usuario_id" id="usuario_id" class="form-select" required>
                                <option value="">Seleccione un usuario</option>
                                @foreach($usuarios as $usuario)
                                    <option value="{{ $usuario->id_usuario }}" {{ old('usuario_id', $alerta->usuario_id ?? '') == $usuario->id_usuario ? 'selected' : '' }}>
                                        {{ $usuario->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('usuario_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="hora_alerta" class="form-label">Hora de Alerta</label>
                            <input type="time" name="hora_alerta" id="hora_alerta" class="form-control" value="{{ old('hora_alerta', $alerta->hora_alerta ?? '') }}" required>
                            @error('hora_alerta')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="tipo_alerta" class="form-label">Tipo de Alerta</label>
                            <select name="tipo_alerta" id="tipo_alerta" class="form-select" required>
                                <option value="">Seleccione un tipo</option>
                                <option value="sistema" {{ old('tipo_alerta', $alerta->tipo_alerta ?? '') == 'sistema' ? 'selected' : '' }}>Sistema</option>
                                <option value="curso" {{ old('tipo_alerta', $alerta->tipo_alerta ?? '') == 'curso' ? 'selected' : '' }}>Curso</option>
                                <option value="usuario" {{ old('tipo_alerta', $alerta->tipo_alerta ?? '') == 'usuario' ? 'selected' : '' }}>Usuario</option>
                                <option value="urgente" {{ old('tipo_alerta', $alerta->tipo_alerta ?? '') == 'urgente' ? 'selected' : '' }}>Urgente</option>
                                <option value="email" {{ old('tipo_alerta', $alerta->tipo_alerta ?? '') == 'email' ? 'selected' : '' }}>Email</option>
                                <option value="sms" {{ old('tipo_alerta', $alerta->tipo_alerta ?? '') == 'sms' ? 'selected' : '' }}>SMS</option>
                                <option value="push" {{ old('tipo_alerta', $alerta->tipo_alerta ?? '') == 'push' ? 'selected' : '' }}>Push</option>
                            </select>
                            @error('tipo_alerta')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="mensaje" class="form-label">Mensaje</label>
                            <textarea name="mensaje" id="mensaje" class="form-control" required>{{ old('mensaje', $alerta->mensaje ?? '') }}</textarea>
                            @error('mensaje')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="estado_id" class="form-label">Estado</label>
                            <select name="estado_id" id="estado_id" class="form-select" required>
                                <option value="">Seleccione un estado</option>
                                @foreach($estados as $estado)
                                    <option value="{{ $estado->id_estado }}" {{ old('estado_id', $alerta->estado_id ?? '') == $estado->id_estado ? 'selected' : '' }}>
                                        {{ $estado->nombre_estado }}
                                    </option>
                                @endforeach
                            </select>
                            @error('estado_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="fecha_creacion" class="form-label">Fecha de Creación</label>
                            <input type="date" name="fecha_creacion" id="fecha_creacion" class="form-control" value="{{ old('fecha_creacion', isset($alerta) ? \Illuminate\Support\Str::substr($alerta->fecha_creacion, 0, 10) : '') }}" required>
                            @error('fecha_creacion')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('alertas.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection