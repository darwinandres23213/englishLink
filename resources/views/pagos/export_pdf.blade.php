{{-- filepath: resources/views/pagos/export_pdf.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pagos - PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #aaa; padding: 4px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Lista de Pagos</h2>
    <table>
        <thead>
            <tr>
                <th>ID Pago</th>
                <th>N° Matrícula</th>
                <th>Estudiante</th>
                <th>Curso</th>
                <th>Monto</th>
                <th>Fecha Pago</th>
                <th>Medio de Pago</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pagos as $pago)
                <tr>
                    <td>{{ $pago->id_pago }}</td>
                    <td>{{ $pago->matricula_id }}</td>
                    <td>{{ $pago->matricula->estudiante->nombre ?? 'N/A' }}</td>
                    <td>{{ $pago->matricula->curso->nombre_curso ?? 'N/A' }}</td>
                    <td>${{ $pago->monto }}</td>
                    <td>{{ $pago->fecha_pago }}</td>
                    <td>{{ $pago->medioPago->nombre ?? 'N/A' }}</td>
                    <td>{{ $pago->estadoPago->nombre_estado ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>