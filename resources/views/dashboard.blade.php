@extends('layouts.app')

@section('title', 'Dashboard Administrador')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="dashboard-header">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="h3 mb-1">Bienvenido, {{ Auth::user()->name }}</h1>
                        <p class="mb-0">Turno: <strong>{{ ucfirst($turno) }}</strong></p>
                    </div>
                    <div class="col-md-4 text-end">
                        <span class="badge badge-accent fs-6 p-2">
                            {{ $turno == 'mañana' ? '🌅' : '🌇' }} Turno {{ ucfirst($turno) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stats-card stats-card-primary">
                <h3 data-counter="{{ $totalAlumnos }}">0</h3>
                <p class="mb-0">Alumnos en {{ $turno }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card stats-card-secondary">
                <h3 data-counter="{{ $totalReportes }}">0</h3>
                <p class="mb-0">Reportes en {{ $turno }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card stats-card-success">
                <h3 data-counter="{{ $totalGrupos }}">0</h3>
                <p class="mb-0">Grupos en {{ $turno }}</p>
            </div>
        </div>
    </div>

    <!-- Acciones Rápidas -->
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card card-custom h-100">
                <div class="card-body text-center">
                    <h1 class="text-primary">👨‍🎓</h1>
                    <h5>Alumnos</h5>
                    <p>Gestión de estudiantes</p>
                    <a href="{{ route('alumnos.index') }}" class="btn btn-primary-custom w-100">Ver Alumnos</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-custom h-100">
                <div class="card-body text-center">
                    <h1 class="text-secondary">📝</h1>
                    <h5>Reportes</h5>
                    <p>Registro de incidencias</p>
                    <a href="{{ route('reportes.index') }}" class="btn btn-secondary-custom w-100">Ver Reportes</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-custom h-100">
                <div class="card-body text-center">
                    <h1 class="text-accent">📈</h1>
                    <h5>Estadísticas</h5>
                    <p>Gráficas y análisis</p>
                    <a href="{{ route('reportes.estadisticas') }}" class="btn btn-primary-custom w-100">Ver Stats</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-custom h-100">
                <div class="card-body text-center">
                    <h1 class="text-success">👥</h1>
                    <h5>Grupos</h5>
                    <p>Administrar grupos</p>
                    <a href="{{ route('grupos.index') }}" class="btn btn-secondary-custom w-100">Ver Grupos</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerta de Turno -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="alert alert-info-custom alert-custom">
                <h5>🔒 Modo {{ ucfirst($turno) }}</h5>
                <p class="mb-0">
                    Estás viendo únicamente la información del turno de <strong>{{ $turno }}</strong>. 
                    No podrás acceder a datos del turno contrario.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar contadores
        setTimeout(() => {
            App.initializeCounters();
        }, 500);
    });
</script>
@endpush