@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h2>Crear Nuevo Grupo</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('grupos.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre del Grupo</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej: 1A, 2B, 3C" required>
                    </div>

                    <div class="mb-3">
                        <label for="turno" class="form-label">Turno</label>
                        <select name="turno" id="turno" class="form-select" required>
                            <option value="">Seleccionar turno</option>
                            <option value="mañana">Mañana</option>
                            <option value="tarde">Tarde</option>
                        </select>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary">Crear Grupo</button>
                        <a href="{{ route('grupos.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection