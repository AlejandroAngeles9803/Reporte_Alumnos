@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header text-center">
                <h1 class="display-4">🏫 Sistema de Gestión de Alumnos</h1>
            </div>
            <div class="card-body text-center">
                <p class="lead">Sistema para el control de reportes e incidencias de alumnos</p>
                
                <div class="row mt-5">
                    <div class="col-md-4 mb-3">
                        <div class="card text-white bg-primary">
                            <div class="card-body">
                                <h3>👨‍🎓 Alumnos</h3>
                                <p>Gestión de estudiantes</p>
                                <a href="{{ route('alumnos.index') }}" class="btn btn-light">Ver Alumnos</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <div class="card text-white bg-warning">
                            <div class="card-body">
                                <h3>📊 Reportes</h3>
                                <p>Registro de incidencias</p>
                                <a href="{{ route('reportes.index') }}" class="btn btn-light">Ver Reportes</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <div class="card text-white bg-success">
                            <div class="card-body">
                                <h3>📈 Estadísticas</h3>
                                <p>Gráficas y análisis</p>
                                <a href="{{ route('reportes.estadisticas') }}" class="btn btn-light">Ver Stats</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-md-6 mb-3">
                        <div class="card text-white bg-info">
                            <div class="card-body">
                                <h3>👥 Grupos</h3>
                                <p>Administrar grupos</p>
                                <a href="{{ route('grupos.index') }}" class="btn btn-light">Ver Grupos</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div class="card text-white bg-danger">
                            <div class="card-body">
                                <h3>🖨️ Imprimir</h3>
                                <p>Reportes en PDF</p>
                                <a href="{{ route('reportes.imprimir') }}" class="btn btn-light">Generar PDF</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection