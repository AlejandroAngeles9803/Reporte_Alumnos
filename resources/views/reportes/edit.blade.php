@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h2>Editar Reporte</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('reportes.update', $reporte) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="alumno_id" class="form-label">Alumno</label>
                        <select name="alumno_id" id="alumno_id" class="form-select" required>
                            <option value="">Seleccionar alumno</option>
                            @foreach($alumnos as $alumno)
                                <option value="{{ $alumno->id }}" {{ $reporte->alumno_id == $alumno->id ? 'selected' : '' }}>
                                    {{ $alumno->nombre }} - {{ $alumno->grupo->nombre }} ({{ $alumno->grupo->turno }})
                                    - Reportes: {{ $alumno->total_reportes }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tipo" class="form-label">Tipo de Incidencia</label>
                        <select name="tipo" id="tipo" class="form-select" required>
                            <option value="credencial" {{ $reporte->tipo == 'credencial' ? 'selected' : '' }}>Credencial</option>
                            <option value="uniforme" {{ $reporte->tipo == 'uniforme' ? 'selected' : '' }}>Uniforme</option>
                            <option value="cabello" {{ $reporte->tipo == 'cabello' ? 'selected' : '' }}>Cabello</option>
                            <option value="otro" {{ $reporte->tipo == 'otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="horas_sentencia" class="form-label">Horas de Sentencia</label>
                        <input type="number" name="horas_sentencia" id="horas_sentencia" class="form-control" min="0" value="{{ $reporte->horas_sentencia }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="fecha_reporte" class="form-label">Fecha del Reporte</label>
                        <input type="date" name="fecha_reporte" id="fecha_reporte" class="form-control" value="{{ $reporte->fecha_reporte->format('Y-m-d') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción (Opcional)</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" rows="4">{{ $reporte->descripcion }}</textarea>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary">Actualizar Reporte</button>
                        <a href="{{ route('reportes.show', $reporte) }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection