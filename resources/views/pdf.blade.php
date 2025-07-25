@php
    use Carbon\Carbon;
    $total = $records->count();
    $certificados = $records->where('es_certificado', true)->count();
    $noCertificados = $records->where('es_certificado', false)->count();
@endphp
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Productores</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }

        .summary {
            margin-bottom: 15px;
            font-size: 13px;
        }
        .summary strong {
            color: #2d3748;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        thead {
            background-color: #f0f0f0;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px 6px;
            text-align: left;
        }

        th {
            background-color: #2d3748;
            color: white;
            text-transform: uppercase;
            font-size: 11px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        h1 {
            text-align: center;
            color: #2d3748;
            margin-bottom: 10px;
        }

        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: center;
            color: #888;
        }
    </style>
</head>
<body>

<h1>Listado de Productores</h1>

<div class="summary">
    <strong>Total de registros:</strong> {{ $total }}<br>
    <strong>Certificados:</strong> {{ $certificados }}<br>
    <strong>No certificados:</strong> {{ $noCertificados }}
</div>

<table>
    <thead>
    <tr>
        <th>Nombre del Productor</th>
        <th>Código</th>
        <th>Cédula</th>
        <th>Finca</th>
        <th>Departamento</th>
        <th>Municipio</th>
        <th>Comunidad</th>
        <th>Aprobado</th>
    </tr>
    </thead>
    <tbody>
    @foreach($records as $record)
        <tr>
            <td>{{ $record->nombre_productor }}</td>
            <td>{{ $record->codigo }}</td>
            <td>{{ $record->numero_cedula }}</td>
            <td>{{ $record->nombre_finca }}</td>
            <td>{{ $record->departamento }}</td>
            <td>{{ $record->municipio }}</td>
            <td>{{ $record->comunidad }}</td>
            <td>{{ $record->es_certificado ? 'Sí' : 'No' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="footer">
    Generado el {{ Carbon::now()->format('d/m/Y H:i') }}
</div>

</body>
</html>
