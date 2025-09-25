{{-- filepath: resources/views/asignacion_actividades/form.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $edit ? 'Editar' : 'Nueva' }} Asignación de Actividad</title>
    <link rel="stylesheet" href="{{ asset('css/pagos.css') }}">
</head>
<body>
<div class="container">
    <h1>{{ $edit ? 'Editar' : 'Nueva' }} Asignación de Actividad</h1>
    <form method="POST" action="{{ $edit ? route('asignacion-actividades.update', $asignacion) : route('asignacion-actividades.store') }}">
        @csrf
        @if($edit)
            @method('PUT')
        @endif

        <label>Usuario:</label>
        <select name="usuario_id" required>
            @foreach($usuarios as $usuario)
                <option value="{{ $usuario->id_usuario }}" {{ $asignacion->usuario_id == $usuario->id_usuario ? 'selected' : '' }}>
                    {{ $usuario->nombre }}
                </option>
            @endforeach
        </select>

        <label>Curso:</label>
        <select name="curso_id" required>
            @foreach($cursos as $curso)
                <option value="{{ $curso->id_curso }}" {{ $asignacion->curso_id == $curso->id_curso ? 'selected' : '' }}>
                    {{ $curso->nombre_curso }}
                </option>
            @endforeach
        </select>

        <label>Nombre de la Actividad:</label>
        <input type="text" name="nombre" value="{{ old('nombre', $asignacion->nombre) }}" required>

        <label>Estado:</label>
        <select name="estado_id" required>
            @foreach($estados as $estado)
                <option value="{{ $estado->id_estado }}" {{ $asignacion->estado_id == $estado->id_estado ? 'selected' : '' }}>
                    {{ $estado->nombre_estado }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn">{{ $edit ? 'Actualizar' : 'Crear' }}</button>
        <a href="{{ route('asignacion-actividades.index') }}" class="btn-cancel">Cancelar</a>
    </form>
</div>
</body>
</html>