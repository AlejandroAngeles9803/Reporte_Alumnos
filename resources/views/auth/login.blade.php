<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Reportes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card card-custom mt-5">
                    <div class="card-header-custom text-center">
                        <h1 class="h3 font-weight-normal">🏫 Sistema de Reportes</h1>
                        <p class="mb-0 text-light">Selecciona tu tipo de usuario e inicia sesión</p>
                    </div>
                    <div class="card-body p-5">
                        @if(session('error'))
                            <div class="alert alert-danger-custom alert-custom alert-dismissible fade show">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success-custom alert-custom alert-dismissible fade show">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('login.post') }}" method="POST">
                            @csrf
                            
                            <!-- Selector de Tipo de Usuario -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Tipo de Usuario:</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-primary-custom w-100 user-type-btn py-3" 
                                                onclick="selectUserType('admin')" id="btn-admin">
                                            <i class="fas fa-user-shield fa-2x mb-2"></i><br>
                                            Administrador
                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <button type="button" class="btn btn-secondary-custom w-100 user-type-btn py-3" 
                                                onclick="selectUserType('alumno')" id="btn-alumno">
                                            <i class="fas fa-user-graduate fa-2x mb-2"></i><br>
                                            Alumno
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" name="tipo_usuario" id="tipo_usuario" value="admin" required>
                            </div>

                            <!-- Campos de Login -->
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-1"></i>
                                    <span id="email-label">Email</span>
                                </label>
                                <input type="email" name="email" id="email" class="form-control" required autofocus>
                                <div class="form-text" id="email-help">
                                    Ingresa tu email de administrador
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-1"></i>
                                    Contraseña
                                </label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary-custom w-100 py-2 fw-bold">
                                <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                            </button>
                        </form>

                        <!-- Credenciales de Prueba -->
                        <div class="mt-4">
                            <div class="accordion" id="credencialesAccordion">
                                <div class="accordion-item border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#credencialesCollapse">
                                            <i class="fas fa-key me-2"></i>Credenciales de Prueba
                                        </button>
                                    </h2>
                                    <div id="credencialesCollapse" class="accordion-collapse collapse" data-bs-parent="#credencialesAccordion">
                                        <div class="accordion-body bg-light">
                                            <small>
                                                <strong>Administradores:</strong><br>
                                                🌅 Mañana: manana@escuela.com / password123<br>
                                                🌇 Tarde: tarde@escuela.com / password123<br><br>
                                                <strong>Alumnos:</strong><br>
                                                👨‍🎓 Alumno: 2024001@escuela.com / password123<br>
                                                👩‍🎓 Alumna: 2024002@escuela.com / password123
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function selectUserType(tipo) {
            document.getElementById('tipo_usuario').value = tipo;
            
            // Reset ambos botones
            document.getElementById('btn-admin').classList.remove('btn-primary-custom', 'btn-secondary-custom');
            document.getElementById('btn-alumno').classList.remove('btn-primary-custom', 'btn-secondary-custom');
            
            // Activar el seleccionado
            if (tipo === 'admin') {
                document.getElementById('btn-admin').classList.add('btn-primary-custom');
                document.getElementById('btn-alumno').classList.add('btn-secondary-custom');
                document.getElementById('email-label').textContent = 'Email';
                document.getElementById('email-help').textContent = 'Ingresa tu email de administrador';
            } else {
                document.getElementById('btn-admin').classList.add('btn-secondary-custom');
                document.getElementById('btn-alumno').classList.add('btn-primary-custom');
                document.getElementById('email-label').textContent = 'Matrícula/Email';
                document.getElementById('email-help').textContent = 'Ingresa tu matrícula o email';
            }
        }

        // Seleccionar administrador por defecto
        document.addEventListener('DOMContentLoaded', function() {
            selectUserType('admin');
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>