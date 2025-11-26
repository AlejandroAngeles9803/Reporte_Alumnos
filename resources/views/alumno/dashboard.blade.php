@extends('layouts.app')

@section('title', 'Dashboard Alumno')

@section('content')
<div class="container-fluid">
    <!-- Header del Alumno -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="dashboard-header fade-in-up">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="h3 mb-1">Bienvenido, {{ $alumno->nombre }}</h1>
                        <p class="mb-0">
                            <i class="fas fa-id-card me-1"></i>Matrícula: {{ $alumno->matricula }} | 
                            <i class="fas fa-users me-1"></i>Grupo: {{ $alumno->grupo->nombre }} | 
                            <i class="fas fa-clock me-1"></i>Turno: {{ ucfirst($alumno->grupo->turno) }}
                        </p>
                    </div>
                    <div class="col-md-4 text-end">
                        <span class="badge badge-accent fs-6 p-2">
                            <i class="fas fa-user-graduate me-1"></i> Modo Alumno
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas del Alumno -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card stats-card-primary">
                <h3 data-counter="{{ $alumno->total_reportes }}">0</h3>
                <p class="mb-0">Total Reportes</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card stats-card-secondary">
                <h3 data-counter="{{ $alumno->reportes->sum('horas_sentencia') }}">0</h3>
                <p class="mb-0">Horas Sentencia</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card stats-card-accent">
                <h3 data-counter="{{ $alumno->reportes->count() }}">0</h3>
                <p class="mb-0">Reportes Activos</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card stats-card-success">
                <h3 data-counter="{{ $alumno->reportes->where('horas_sentencia', '<=', 0)->count() }}">0</h3>
                <p class="mb-0">Sin Pendientes</p>
            </div>
        </div>
    </div>

    <!-- Alertas Importantes -->
    @if($alumno->total_reportes >= 3)
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-danger-custom alert-custom">
                <h5><i class="fas fa-exclamation-triangle me-2"></i>Alerta Importante</h5>
                <p class="mb-0">
                    Tienes 3 o más reportes. Por favor, contacta a la administración para regularizar tu situación.
                </p>
            </div>
        </div>
    </div>
    @elseif($alumno->total_reportes == 2)
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-warning-custom alert-custom">
                <h5><i class="fas fa-exclamation-circle me-2"></i>Advertencia</h5>
                <p class="mb-0">
                    Tienes 2 reportes. Mantén tu conducta para evitar más reportes.
                </p>
            </div>
        </div>
    </div>
    @elseif($alumno->total_reportes == 1)
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-info-custom alert-custom">
                <h5><i class="fas fa-info-circle me-2"></i>Información</h5>
                <p class="mb-0">
                    Tienes 1 reporte. Recuerda seguir las reglas del instituto.
                </p>
            </div>
        </div>
    </div>
    @else
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-success-custom alert-custom">
                <h5><i class="fas fa-check-circle me-2"></i>¡Excelente!</h5>
                <p class="mb-0">
                    No tienes reportes. Sigue manteniendo tu buen comportamiento.
                </p>
            </div>
        </div>
    </div>
    @endif

    <!-- Historial de Reportes -->
    <div class="row">
        <div class="col-12">
            <div class="card card-custom">
                <div class="card-header-custom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-clipboard-list me-2"></i>Mi Historial de Reportes
                    </h5>
                    <span class="badge badge-primary-custom">{{ $reportes->count() }} reportes</span>
                </div>
                <div class="card-body">
                    @if($reportes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-custom">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Tipo</th>
                                    <th>Descripción</th>
                                    <th>Horas Sentencia</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reportes as $reporte)
                                <tr class="fade-in-up">
                                    <td>{{ $reporte->fecha_reporte->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge badge-reporte badge-{{ $reporte->tipo }}">
                                            {{ ucfirst($reporte->tipo) }}
                                        </span>
                                    </td>
                                    <td>{{ $reporte->descripcion ?? 'Sin descripción' }}</td>
                                    <td>
                                        <span class="badge bg-dark">{{ $reporte->horas_sentencia }} horas</span>
                                    </td>
                                    <td>
                                        @if($reporte->horas_sentencia > 0)
                                            <span class="badge badge-warning">Pendiente</span>
                                        @else
                                            <span class="badge badge-success">Completado</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <h5>¡Excelente!</h5>
                        <p class="text-muted">No tienes reportes registrados.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Información para el Alumno -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card card-custom">
                <div class="card-header-custom">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Información Importante
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li>Revisa regularmente tu historial de reportes</li>
                        <li>Cumple con las horas de sentencia asignadas</li>
                        <li>Para aclaraciones, contacta a tu administrador de turno</li>
                        <li>Mantén tu uniforme y credencial en orden</li>
                        <li>Reporta cualquier irregularidad a la administración</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar animaciones específicas del dashboard
        setTimeout(() => {
            App.animateCounter(document.querySelector('[data-counter]'), {{ $alumno->total_reportes }});
        }, 500);
    });
</script>
@endpush