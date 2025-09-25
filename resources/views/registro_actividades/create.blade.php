<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $edit ? 'Editar Actividad' : 'Nueva Actividad' }}</title>
    <link rel="stylesheet" href="{{ asset('css/actividades.css') }}">
</head>
<body>
<div class="container">
    <h1>{{ $edit ? 'Editar Actividad' : 'Nueva Actividad' }}</h1>
    <form method="POST" action="{{ $edit ? route('actividades.update', $actividad) : route('actividades.store') }}">
        @csrf
        @if($edit)
            @method('PUT')
        @endif

        <label>Usuario:</label>
        <select name="usuario_id" required>
            <option value="">Seleccione un usuario</option>
            @foreach($usuarios as $usuario)
                <option value="{{ $usuario->id_usuario }}" {{ $actividad->usuario_id == $usuario->id_usuario ? 'selected' : '' }}>
                    {{ $usuario->nombre }}
                </option>
            @endforeach
        </select>

        <label>Acción:</label>
        <textarea name="accion" rows="2" required>{{ old('accion', $actividad->accion) }}</textarea>

        <label>Fecha y Hora:</label>
        <input type="datetime-local" name="fecha_hora"
               value="{{ old('fecha_hora', isset($actividad->fecha_hora) ? \Carbon\Carbon::parse($actividad->fecha_hora)->format('Y-m-d\TH:i') : '') }}"
               required>

        <label>IP de Origen:</label>
        <input type="text" name="ip_origen" maxlength="45" value="{{ old('ip_origen', $actividad->ip_origen) }}" required>

        <label>Módulo Afectado:</label>
        <input type="text" name="modulo_afectado" maxlength="100" value="{{ old('modulo_afectado', $actividad->modulo_afectado) }}" required>

        <label>Curso:</label>
        <select name="curso_id" required>
            <option value="">Seleccione un curso</option>
            @foreach($cursos as $curso)
                <option value="{{ $curso->id_curso }}" {{ $actividad->curso_id == $curso->id_curso ? 'selected' : '' }}>
                    {{ $curso->nombre_curso }}
                </option>
            @endforeach
        </select>

        <label>Descripción:</label>
        <textarea name="descripcion" rows="4" required>{{ old('descripcion', $actividad->descripcion) }}</textarea>

        <button type="submit" class="btn">{{ $edit ? 'Actualizar' : 'Crear' }}</button>
        <a href="{{ route('actividades.index') }}" class="btn-cancel">Cancelar</a>
    </form>
</div>
</body>
</html>
