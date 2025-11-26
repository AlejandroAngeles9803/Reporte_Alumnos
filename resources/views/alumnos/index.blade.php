@extends('layouts.app')

@section('title', 'Lista de Alumnos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Lista de Alumnos</h1>
    <a href="{{ route('alumnos.create') }}" class="btn btn-primary-custom">
        <i class="fas fa-plus me-1"></i>Agregar Alumno
    </a>
</div>

@if($alumnos->count() > 0)
<div class="row">
    @foreach($alumnos as $alumno)
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card card-custom h-100 border-{{ $alumno->alerta }}">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <!-- Foto del Alumno -->
                    @if($alumno->foto)
                        <img src="{{ asset('storage/' . $alumno->foto) }}" 
                             class="rounded-circle me-3" 
                             width="70" 
                             height="70" 
                             alt="Foto de {{ $alumno->nombre }}"
                             style="object-fit: cover;"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    @endif
                    
                    @if(!$alumno->foto)
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3" 
                         style="width: 70px; height: 70px;">
                        <i class="fas fa-user text-muted fa-lg"></i>
                    </div>
                    @endif

                    <div class="flex-grow-1">
                        <h5 class="card-title mb-1">{{ $alumno->nombre }}</h5>
                        <p class="card-text text-muted small mb-1">
                            <i class="fas fa-id-card me-1"></i>{{ $alumno->matricula }}
                        </p>
                        <p class="card-text mb-1">
                            <strong>Grupo:</strong> {{ $alumno->grupo->nombre }}
                        </p>
                        <p class="card-text mb-2">
                            <strong>Turno:</strong> 
                            <span class="badge bg-{{ $alumno->grupo->turno == 'mañana' ? 'warning' : 'info' }}">
                                {{ ucfirst($alumno->grupo->turno) }}
                            </span>
                        </p>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge badge-{{ $alumno->alerta }} fs-6">
                                <i class="fas fa-flag me-1"></i>
                                {{ $alumno->total_reportes }} Reporte{{ $alumno->total_reportes != 1 ? 's' : '' }}
                            </span>
                            
                            <a href="{{ route('alumnos.show', $alumno) }}" class="btn btn-sm btn-primary-custom">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>

                        @if($alumno->total_reportes >= 3)
                        <div class="alert alert-danger-custom alert-custom mt-2 mb-0 py-2">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            <strong>Alerta:</strong> El alumno tiene 3 o más reportes
                        </div>
                        @elseif($alumno->total_reportes == 2)
                        <div class="alert alert-warning-custom alert-custom mt-2 mb-0 py-2">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            <strong>Advertencia:</strong> El alumno tiene 2 reportes
                        </div>
                        @elseif($alumno->total_reportes == 1)
                        <div class="alert alert-info-custom alert-custom mt-2 mb-0 py-2">
                            <i class="fas fa-info-circle me-1"></i>
                            El alumno tiene 1 reporte
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Paginación -->
@if(method_exists($alumnos, 'hasPages') && $alumnos->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $alumnos->links() }}
</div>
@endif

@else
<div class="alert alert-info-custom alert-custom text-center">
    <div class="py-4">
        <i class="fas fa-users fa-3x text-info mb-3"></i>
        <h4>No hay alumnos registrados</h4>
        <p class="mb-3">Comienza agregando el primer alumno al sistema.</p>
        <a href="{{ route('alumnos.create') }}" class="btn btn-primary-custom">
            <i class="fas fa-plus me-1"></i>Agregar Primer Alumno
        </a>
    </div>
</div>
@endif

<!-- Estadísticas Rápidas -->
@if($alumnos->count() > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card card-custom">
            <div class="card-header-custom">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Estadísticas de Alumnos
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="stats-card stats-card-primary">
                            <h3>{{ $alumnos->count() }}</h3>
                            <p class="mb-0">Total Alumnos</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card stats-card-success">
                            <h3>{{ $alumnos->where('total_reportes', 0)->count() }}</h3>
                            <p class="mb-0">Sin Reportes</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card stats-card-accent">
                            <h3>{{ $alumnos->where('total_reportes', '>=', 1)->where('total_reportes', '<=', 2)->count() }}</h3>
                            <p class="mb-0">Con 1-2 Reportes</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card stats-card-secondary">
                            <h3>{{ $alumnos->where('total_reportes', '>=', 3)->count() }}</h3>
                            <p class="mb-0">Con 3+ Reportes</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection