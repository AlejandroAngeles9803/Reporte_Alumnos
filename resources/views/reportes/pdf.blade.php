<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Incidencias</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #333; margin-bottom: 5px; }
        .header .date { color: #666; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f8f9fa; font-weight: bold; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; }
        .badge-danger { background-color: #dc3545; color: white; }
        .badge-warning { background-color: #ffc107; color: black; }
        .badge-info { background-color: #17a2b8; color: white; }
        .badge-success { background-color: #28a745; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Incidencias</h1>
        <div class="date">Generado el: {{ date('d/m/Y H:i:s') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Alumno</th>
                <th>Grupo</th>
                <th>Turno</th>
                <th>Tipo de Incidencia</th>
                <th>Descripción</th>
                <th>Horas Sentencia</th>
                <th>Fecha Reporte</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportes as $reporte)
            <tr>
                <td>{{ $reporte->alumno->nombre }}</td>
                <td>{{ $reporte->alumno->grupo->nombre }}</td>
                <td>{{ $reporte->alumno->grupo->turno }}</td>
                <td>
                    @php
                        $badgeClass = [
                            'credencial' => 'badge-danger',
                            'uniforme' => 'badge-warning',
                            'cabello' => 'badge-info',
                            'otro' => 'badge-success'
                        ][$reporte->tipo] ?? 'badge-secondary';
                    @endphp
                    <span class="badge {{ $badgeClass }}">
                        {{ ucfirst($reporte->tipo) }}
                    </span>
                </td>
                <td>{{ $reporte->descripcion ?? 'N/A' }}</td>
                <td>{{ $reporte->horas_sentencia }} horas</td>
                <td>{{ $reporte->fecha_reporte->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 30px; text-align: center; color: #666;">
        <p>Total de incidencias: {{ $reportes->count() }}</p>
    </div>
</body>
</html>