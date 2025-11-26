<!DOCTYPE html>
<html lang="es">
@include('layouts.head')
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="{{ Auth::check() ? (Auth::user()->role === 'admin' ? route('dashboard') : route('alumno.dashboard')) : route('login') }}">
                <i class="fas fa-school me-2"></i>Sistema Alumnos
            </a>
            
            @auth
            <div class="navbar-text text-light me-3">
                <i class="fas fa-user me-1"></i>
                {{ Auth::user()->name }}
                <span class="badge badge-secondary-custom ms-1">
                    {{ Auth::user()->role === 'admin' ? 'Administrador' : 'Alumno' }}
                </span>
                @if(Auth::user()->role === 'admin')
                <span class="ms-2">
                    <i class="fas fa-clock me-1"></i>
                    Turno: <strong>{{ ucfirst(Auth::user()->turno) }}</strong>
                </span>
                @endif
            </div>
            @endauth

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <!-- Menú para Administradores -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard') }}">
                                    <i class="fas fa-home me-1"></i>Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('alumnos.index') }}">
                                    <i class="fas fa-users me-1"></i>Alumnos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('reportes.index') }}">
                                    <i class="fas fa-clipboard-list me-1"></i>Reportes
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('reportes.estadisticas') }}">
                                    <i class="fas fa-chart-pie me-1"></i>Estadísticas
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('grupos.index') }}">
                                    <i class="fas fa-layer-group me-1"></i>Grupos
                                </a>
                            </li>
                        @else
                            <!-- Menú para Alumnos -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('alumno.dashboard') }}">
                                    <i class="fas fa-home me-1"></i>Mi Dashboard
                                </a>
                            </li>
                        @endif
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-cog me-1"></i>Cuenta
                            </a>
                            <ul class="dropdown-menu">
                                <li><span class="dropdown-item-text">
                                    <small>
                                        <strong>{{ Auth::user()->name }}</strong><br>
                                        {{ Auth::user()->email }}<br>
                                        <span class="badge badge-secondary-custom">
                                            {{ Auth::user()->role === 'admin' ? 'Administrador' : 'Alumno' }}
                                        </span>
                                    </small>
                                </span></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}">
                                        <i class="fas fa-sign-out-alt me-1"></i>Cerrar Sesión
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i>Iniciar Sesión
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success-custom alert-custom alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger-custom alert-custom alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-light mt-5 py-4">
        <div class="container text-center">
            <p class="mb-0">Sistema de Gestión de Alumnos &copy; {{ date('Y') }}</p>
        </div>
    </footer>

    @include('layouts.scripts')
</body>
</html>