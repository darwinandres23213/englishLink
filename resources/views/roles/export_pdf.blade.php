<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Roles - PDF</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        h2 {
            text-align: center;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 6px;
            text-align: left;
        }
        th {
            background: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Listado de Roles</h2>

    <table>
        <thead>
            <tr>
                <th>ID Rol</th>
                <th>Nombre del Rol</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $rol)
                <tr>
                    <td>{{ $rol->id_rol }}</td>
                    <td>{{ $rol->nombre_rol }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>