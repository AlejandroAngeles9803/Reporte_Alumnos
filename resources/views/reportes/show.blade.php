@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2>Detalles del Reporte</h2>
                <div>
                    <a href="{{ route('reportes.edit', $reporte) }}" class="btn btn-warning btn-sm">Editar</a>
                    <a href="{{ route('reportes.index') }}" class="btn btn-secondary btn-sm">Volver</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Información del Alumno</h4>
                        <p><strong>Nombre:</strong> {{ $reporte->alumno->nombre }}</p>
                        <p><strong>Matrícula:</strong> {{ $reporte->alumno->matricula }}</p>
                        <p><strong>Grupo:</strong> {{ $reporte->alumno->grupo->nombre }}</p>
                        <p><strong>Turno:</strong> {{ $reporte->alumno->grupo->turno }}</p>
                    </div>
                    <div class="col-md-6">
                        <h4>Detalles del Reporte</h4>
                        <p>
                            <strong>Tipo:</strong> 
                            <span class="badge bg-{{ [
                                'credencial' => 'danger',
                                'uniforme' => 'warning',
                                'cabello' => 'info',
                                'otro' => 'success'
                            ][$reporte->tipo] }}">
                                {{ ucfirst($reporte->tipo) }}
                            </span>
                        </p>
                        <p><strong>Horas de Sentencia:</strong> {{ $reporte->horas_sentencia }} horas</p>
                        <p><strong>Fecha del Reporte:</strong> {{ $reporte->fecha_reporte->format('d/m/Y') }}</p>
                        <p><strong>Creado:</strong> {{ $reporte->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                @if($reporte->descripcion)
                <div class="row mt-4">
                    <div class="col-12">
                        <h4>Descripción</h4>
                        <div class="card">
                            <div class="card-body">
                                {{ $reporte->descripcion }}
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <form action="{{ route('reportes.destroy', $reporte) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este reporte?')">Eliminar Reporte</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection