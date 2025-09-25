{{-- filepath: resources/views/medios_pago/export_pdf.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Medios de Pago</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Medios de Pago</h2>
    <table>
        <thead>
            <tr>
                <!--<th>ID</th>-->
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Activo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($medios as $medio)
                <tr>
                    <!--<td>{{ $medio->id_medio_pago }}</td>-->
                    <td>{{ $medio->nombre }}</td>
                    <td>{{ $medio->descripcion }}</td>
                    <td>{{ $medio->activo ? 'Sí' : 'No' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>