@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="mb-0">
                    <i class="fas fa-user-graduate me-2"></i>Detalles del Alumno
                </h2>
                <div>
                    <a href="{{ route('alumnos.edit', $alumno) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit me-1"></i>Editar
                    </a>
                    <a href="{{ route('alumnos.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Volver
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Columna de Foto e Información Básica -->
                    <div class="col-md-4 text-center">
                        @if($alumno->foto)
                            <img src="{{ asset('storage/' . $alumno->foto) }}" 
                                 class="img-fluid rounded-circle mb-3 shadow" 
                                 alt="Foto de {{ $alumno->nombre }}"
                                 style="max-width: 250px; border: 4px solid #dee2e6;"
                                 onerror="this.style.display='none'; document.getElementById('placeholder-photo').style.display='flex';">
                        @endif
                        
                        @if(!$alumno->foto)
                        <div id="placeholder-photo" class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 shadow" 
                             style="width: 250px; height: 250px; border: 4px solid #dee2e6;">
                            <i class="fas fa-user text-muted fa-5x"></i>
                        </div>
                        @endif

                        <div class="alert alert-{{ $alumno->alerta }} mt-3">
                            <h5 class="alert-heading">
                                <i class="fas fa-flag me-1"></i>
                                Estado del Alumno
                            </h5>
                            <p class="mb-2">
                                <strong>Reportes:</strong> 
                                <span class="badge bg-{{ $alumno->alerta }} fs-6">
                                    {{ $alumno->total_reportes }}
                                </span>
                            </p>
                            @if($alumno->total_reportes >= 3)
                                <p class="mb-0">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    <strong>Alerta:</strong> El alumno tiene 3 o más reportes
                                </p>
                            @elseif($alumno->total_reportes == 2)
                                <p class="mb-0">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    <strong>Advertencia:</strong> El alumno tiene 2 reportes
                                </p>
                            @elseif($alumno->total_reportes == 1)
                                <p class="mb-0">
                                    <i class="fas fa-info-circle me-1"></i>
                                    El alumno tiene 1 reporte
                                </p>
                            @else
                                <p class="mb-0">
                                    <i class="fas fa-check-circle me-1"></i>
                                    El alumno no tiene reportes
                                </p>
                            @endif
                        </div>

                        <div class="mt-3">
                            <a href="{{ route('reportes.create') }}?alumno_id={{ $alumno->id }}" 
                               class="btn btn-primary w-100 mb-2">
                                <i class="fas fa-plus me-1"></i>Agregar Reporte
                            </a>
                            
                            @if($alumno->foto)
                            <form action="{{ route('alumnos.update', $alumno) }}" method="POST" enctype="multipart/form-data" class="mt-2">
                                @csrf
                                @method('PUT')
                                <div class="input-group">
                                    <input type="file" name="foto" class="form-control form-control-sm" accept="image/*">
                                    <button type="submit" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                                <small class="form-text text-muted">Actualizar foto</small>
                            </form>
                            @endif
                        </div>
                    </div>

                    <!-- Columna de Información Detallada -->
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card bg-light mb-3">
                                    <div class="card-header">
                                        <h5 class="mb-0">
                                            <i class="fas fa-info-circle me-2"></i>Información Personal
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Nombre Completo:</strong><br>{{ $alumno->nombre }}</p>
                                        <p><strong>Matrícula:</strong><br>{{ $alumno->matricula }}</p>
                                        <p><strong>Turno:</strong><br>
                                            <span class="badge bg-{{ $alumno->grupo->turno == 'mañana' ? 'warning' : 'info' }}">
                                                {{ ucfirst($alumno->grupo->turno) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="card bg-light mb-3">
                                    <div class="card-header">
                                        <h5 class="mb-0">
                                            <i class="fas fa-users me-2"></i>Información Académica
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Grupo:</strong><br>{{ $alumno->grupo->nombre }}</p>
                                        <p><strong>Total de Reportes:</strong><br>
                                            <span class="badge bg-{{ $alumno->alerta }} fs-6">
                                                {{ $alumno->total_reportes }}
                                            </span>
                                        </p>
                                        <p><strong>Horas de Sentencia Total:</strong><br>
                                            <span class="badge bg-dark fs-6">
                                                {{ $alumno->reportes->sum('horas_sentencia') }} horas
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Historial de Reportes -->
                        @if($alumno->reportes->count() > 0)
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-clipboard-list me-2"></i>Historial de Reportes
                                    <span class="badge bg-primary ms-2">{{ $alumno->reportes->count() }}</span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Tipo</th>
                                                <th>Descripción</th>
                                                <th>Horas</th>
                                                <th>Fecha</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($alumno->reportes->sortByDesc('fecha_reporte') as $reporte)
                                            <tr>
                                                <td>
                                                    <span class="badge bg-{{ [
                                                        'credencial' => 'danger',
                                                        'uniforme' => 'warning', 
                                                        'cabello' => 'info',
                                                        'otro' => 'success'
                                                    ][$reporte->tipo] }}">
                                                        {{ ucfirst($reporte->tipo) }}
                                                    </span>
                                                </td>
                                                <td>{{ $reporte->descripcion ?? 'N/A' }}</td>
                                                <td>
                                                    <span class="badge bg-dark">{{ $reporte->horas_sentencia }}h</span>
                                                </td>
                                                <td>{{ $reporte->fecha_reporte->format('d/m/Y') }}</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('reportes.show', $reporte) }}" class="btn btn-info" title="Ver">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('reportes.edit', $reporte) }}" class="btn btn-warning" title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
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
                        <div class="alert alert-success text-center">
                            <i class="fas fa-check-circle fa-2x mb-3"></i>
                            <h5>¡Excelente!</h5>
                            <p class="mb-0">Este alumno no tiene reportes registrados.</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Acciones Adicionales -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="{{ route('reportes.create') }}?alumno_id={{ $alumno->id }}" 
                                   class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i>Nuevo Reporte
                                </a>
                                <a href="{{ route('alumnos.edit', $alumno) }}" class="btn btn-warning">
                                    <i class="fas fa-edit me-1"></i>Editar Alumno
                                </a>
                            </div>
                            <form action="{{ route('alumnos.destroy', $alumno) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" 
                                        onclick="return confirm('¿Estás seguro de que quieres eliminar este alumno? También se eliminarán todos sus reportes.')">
                                    <i class="fas fa-trash me-1"></i>Eliminar Alumno
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-bottom: none;
    }
    
    .table th {
        border-top: none;
        font-weight: 600;
    }
    
    .badge {
        font-size: 0.8em;
    }
</style>
@endpush