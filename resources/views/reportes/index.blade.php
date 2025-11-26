@extends('layouts.app')

@section('title', 'Lista de Reportes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Lista de Reportes</h1>
    <div>
        <a href="{{ route('reportes.create') }}" class="btn btn-primary-custom">Nuevo Reporte</a>
        <a href="{{ route('reportes.estadisticas') }}" class="btn btn-secondary-custom">Ver Estadísticas</a>
        <a href="{{ route('reportes.imprimir') }}" class="btn btn-success">Imprimir Reportes</a>
    </div>
</div>

@if($reportes->count() > 0)
<div class="card card-custom">
    <div class="card-header-custom">
        <h5 class="mb-0">
            <i class="fas fa-clipboard-list me-2"></i>Reportes Registrados
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th>Alumno</th>
                        <th>Grupo</th>
                        <th>Turno</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Horas Sentencia</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reportes as $reporte)
                    <tr>
                        <td>
                            <strong>{{ $reporte->alumno->nombre }}</strong>
                            <br>
                            <small class="text-muted">{{ $reporte->alumno->matricula }}</small>
                        </td>
                        <td>{{ $reporte->alumno->grupo->nombre }}</td>
                        <td>
                            <span class="badge bg-{{ $reporte->alumno->grupo->turno == 'mañana' ? 'warning' : 'info' }}">
                                {{ ucfirst($reporte->alumno->grupo->turno) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-{{ $reporte->tipo }}">
                                {{ ucfirst($reporte->tipo) }}
                            </span>
                        </td>
                        <td>{{ $reporte->descripcion ? Str::limit($reporte->descripcion, 50) : 'N/A' }}</td>
                        <td>
                            <span class="badge bg-dark">{{ $reporte->horas_sentencia }} horas</span>
                        </td>
                        <td>{{ $reporte->fecha_reporte->format('d/m/Y') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('reportes.show', $reporte) }}" class="btn btn-primary-custom" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('reportes.edit', $reporte) }}" class="btn btn-secondary-custom" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('reportes.destroy', $reporte) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Eliminar" onclick="return confirm('¿Estás seguro?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@else
<div class="alert alert-info-custom alert-custom text-center">
    <h4>No hay reportes registrados</h4>
    <p>Comienza creando tu primer reporte de incidencia.</p>
    <a href="{{ route('reportes.create') }}" class="btn btn-primary-custom">Crear Primer Reporte</a>
</div>
@endif
@endsection