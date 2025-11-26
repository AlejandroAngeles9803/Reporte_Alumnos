@extends('layouts.app')

@section('title', 'Gestión de Grupos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Gestión de Grupos</h1>
    <a href="{{ route('grupos.create') }}" class="btn btn-primary-custom">Crear Grupo</a>
</div>

<div class="row">
    @foreach($grupos as $grupo)
    <div class="col-md-6 mb-4">
        <div class="card card-custom">
            <div class="card-header-custom d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Grupo {{ $grupo->nombre }}</h4>
                <span class="badge badge-{{ $grupo->turno == 'mañana' ? 'warning' : 'info' }}">
                    Turno: {{ ucfirst($grupo->turno) }}
                </span>
            </div>
            <div class="card-body">
                <h5>Alumnos en este grupo: {{ $grupo->alumnos_count }}</h5>
                
                @if($grupo->alumnos_count > 0)
                <div class="mt-3">
                    <h6>Alumnos:</h6>
                    <ul class="list-group">
                        @foreach($grupo->alumnos->take(5) as $alumno)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $alumno->nombre }}
                            <span class="badge badge-{{ $alumno->alerta }} rounded-pill">
                                {{ $alumno->total_reportes }}
                            </span>
                        </li>
                        @endforeach
                        @if($grupo->alumnos_count > 5)
                        <li class="list-group-item text-center text-muted">
                            ... y {{ $grupo->alumnos_count - 5 }} alumnos más
                        </li>
                        @endif
                    </ul>
                </div>
                @else
                <div class="alert alert-info-custom alert-custom mt-3">
                    No hay alumnos registrados en este grupo.
                </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

@if($grupos->isEmpty())
<div class="alert alert-warning-custom alert-custom text-center">
    <h4>No hay grupos registrados</h4>
    <p>Comienza creando tu primer grupo.</p>
    <a href="{{ route('grupos.create') }}" class="btn btn-primary-custom">Crear Primer Grupo</a>
</div>
@endif
@endsection