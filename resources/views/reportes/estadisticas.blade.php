@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Estadísticas de Reportes</h1>
    <div>
        <a href="{{ route('reportes.index') }}" class="btn btn-secondary">Volver a Reportes</a>
        <a href="{{ route('reportes.imprimir') }}" class="btn btn-success">Imprimir Reportes</a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">📊 Distribución de Incidencias</h3>
            </div>
            <div class="card-body">
                <canvas id="graficaPastel" width="400" height="400"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h3 class="mb-0">📈 Resumen por Tipo</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Tipo de Incidencia</th>
                                <th>Cantidad</th>
                                <th>Porcentaje</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = $estadisticas->sum('total');
                            @endphp
                            @foreach($estadisticas as $estadistica)
                            <tr>
                                <td>
                                    <span class="badge bg-{{ [
                                        'credencial' => 'danger',
                                        'uniforme' => 'warning',
                                        'cabello' => 'info',
                                        'otro' => 'success'
                                    ][$estadistica->tipo] }}">
                                        {{ ucfirst($estadistica->tipo) }}
                                    </span>
                                </td>
                                <td><strong>{{ $estadistica->total }}</strong></td>
                                <td>
                                    @if($total > 0)
                                    <div class="progress">
                                        <div class="progress-bar bg-{{ [
                                            'credencial' => 'danger',
                                            'uniforme' => 'warning',
                                            'cabello' => 'info',
                                            'otro' => 'success'
                                        ][$estadistica->tipo] }}" 
                                        style="width: {{ ($estadistica->total / $total) * 100 }}%">
                                            {{ number_format(($estadistica->total / $total) * 100, 1) }}%
                                        </div>
                                    </div>
                                    @else
                                    0%
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-dark">
                            <tr>
                                <th>Total</th>
                                <th>{{ $total }}</th>
                                <th>100%</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@if($total > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h3 class="mb-0">📋 Resumen General</h3>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h4>📝</h4>
                                <h3>{{ $total }}</h3>
                                <p class="mb-0">Total de Reportes</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h4>👨‍🎓</h4>
                                <h3>{{ $estadisticas->count() }}</h3>
                                <p class="mb-0">Tipos de Incidencias</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h4>🔥</h4>
                                <h3>{{ $estadisticas->max('total') }}</h3>
                                <p class="mb-0">Incidencia Más Frecuente</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h4>📅</h4>
                                <h3>{{ date('d/m/Y') }}</h3>
                                <p class="mb-0">Fecha de Reporte</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="alert alert-warning text-center mt-4">
    <h4>No hay datos para mostrar</h4>
    <p>No se han registrado reportes aún.</p>
    <a href="{{ route('reportes.create') }}" class="btn btn-primary">Crear Primer Reporte</a>
</div>
@endif

<script>
    const ctx = document.getElementById('graficaPastel').getContext('2d');
    const datos = @json($estadisticas);
    
    if(datos.length > 0) {
        const tipos = datos.map(item => {
            return item.tipo.charAt(0).toUpperCase() + item.tipo.slice(1);
        });
        const totals = datos.map(item => item.total);
        const colores = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'];

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: tipos,
                datasets: [{
                    data: totals,
                    backgroundColor: colores,
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    } else {
        // Mostrar mensaje si no hay datos
        ctx.font = '16px Arial';
        ctx.fillStyle = '#666';
        ctx.textAlign = 'center';
        ctx.fillText('No hay datos para mostrar', 200, 200);
    }
</script>
@endsection