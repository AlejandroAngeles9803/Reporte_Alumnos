@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h2>Crear Nuevo Reporte</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('reportes.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="alumno_id" class="form-label">Alumno</label>
                        <select name="alumno_id" id="alumno_id" class="form-select" required>
                            <option value="">Seleccionar alumno</option>
                            @foreach($alumnos as $alumno)
                                <option value="{{ $alumno->id }}">
                                    {{ $alumno->nombre }} - {{ $alumno->grupo->nombre }} ({{ $alumno->grupo->turno }})
                                    - Reportes: {{ $alumno->total_reportes }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tipo" class="form-label">Tipo de Incidencia</label>
                        <select name="tipo" id="tipo" class="form-select" required>
                            <option value="credencial">Credencial</option>
                            <option value="uniforme">Uniforme</option>
                            <option value="cabello">Cabello</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="horas_sentencia" class="form-label">Horas de Sentencia</label>
                        <input type="number" name="horas_sentencia" id="horas_sentencia" class="form-control" min="0" value="1" required>
                        <div class="form-text">Cantidad de horas que el alumno debe cumplir como sentencia.</div>
                    </div>

                    <div class="mb-3">
                        <label for="fecha_reporte" class="form-label">Fecha del Reporte</label>
                        <input type="date" name="fecha_reporte" id="fecha_reporte" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción (Opcional)</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" rows="4" placeholder="Describe los detalles de la incidencia..."></textarea>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary">Guardar Reporte</button>
                        <a href="{{ route('reportes.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Mostrar información del alumno seleccionado
    document.getElementById('alumno_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            const text = selectedOption.text;
            // Puedes agregar aquí lógica para mostrar más información del alumno
            console.log('Alumno seleccionado:', text);
        }
    });
</script>
@endsection