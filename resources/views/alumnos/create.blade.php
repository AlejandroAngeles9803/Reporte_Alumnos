@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h2>Agregar Nuevo Alumno</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('alumnos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre Completo</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="matricula" class="form-label">Matrícula</label>
                        <input type="text" name="matricula" id="matricula" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="grupo_id" class="form-label">Grupo</label>
                        <select name="grupo_id" id="grupo_id" class="form-select" required>
                            <option value="">Seleccionar grupo</option>
                            @foreach($grupos as $grupo)
                                <option value="{{ $grupo->id }}">
                                    {{ $grupo->nombre }} - {{ $grupo->turno }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto del Alumno (Opcional)</label>
                        <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                        <div class="form-text">Formatos aceptados: JPG, PNG, GIF. Tamaño máximo: 2MB</div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary">Guardar Alumno</button>
                        <a href="{{ route('alumnos.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection