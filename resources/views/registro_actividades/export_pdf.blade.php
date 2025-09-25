{{-- filepath: resources/views/actividades/export_pdf.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Actividades - PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #aaa; padding: 4px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Registro de Actividades</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Acción</th>
                <th>Fecha y Hora</th>
                <th>IP de Origen</th>
                <th>Módulo Afectado</th>
                <th>Curso</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($actividades as $actividad)
                <tr>
                    <td>{{ $actividad->id }}</td>
                    <td>{{ $actividad->usuario->nombre ?? 'N/A' }}</td>
                    <td>{{ $actividad->accion }}</td>
                    <td>{{ $actividad->fecha_hora }}</td>
                    <td>{{ $actividad->ip_origen }}</td>
                    <td>{{ $actividad->modulo_afectado }}</td>
                    <td>{{ $actividad->curso->nombre_curso ?? 'N/A' }}</td>
                    <td>{{ $actividad->descripcion }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
