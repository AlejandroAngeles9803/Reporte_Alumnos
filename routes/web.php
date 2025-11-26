<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\AuthController;

// Ruta principal redirige a login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::get('/alumno/dashboard', [AuthController::class, 'alumnoDashboard'])->name('alumno.dashboard');

// Rutas públicas que requieren autenticación
Route::middleware(['auth'])->group(function () {
    // Dashboard principal (redirige según el rol)
    Route::get('/home', function () {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('alumno.dashboard');
        }
    });

    // RUTAS PARA REPORTES
    Route::get('reportes/estadisticas', [ReporteController::class, 'estadisticas'])->name('reportes.estadisticas');
    Route::get('reportes/imprimir', [ReporteController::class, 'imprimir'])->name('reportes.imprimir');
    Route::resource('reportes', ReporteController::class);

    // RUTAS PARA ALUMNOS
    Route::resource('alumnos', AlumnoController::class);

    // RUTAS PARA GRUPOS
    Route::resource('grupos', GrupoController::class);
});

// Rutas de prueba y debug (puedes eliminarlas después)
Route::get('/test', function () {
    $userData = Auth::check() ? [
        'name' => Auth::user()->name,
        'email' => Auth::user()->email,
        'role' => Auth::user()->role,
        'turno' => Auth::user()->turno
    ] : 'No autenticado';
    
    return response()->json([
        'status' => 'success',
        'message' => 'El sistema está funcionando correctamente',
        'user' => $userData
    ]);
});

Route::get('/debug-fotos', function () {
    $alumnos = \App\Models\Alumno::whereNotNull('foto')->get();
    
    echo "<h1>Debug de Fotos</h1>";
    foreach ($alumnos as $alumno) {
        echo "<div style='margin: 20px;'>";
        echo "<h3>{$alumno->nombre}</h3>";
        echo "<p>Ruta: {$alumno->foto}</p>";
        echo "<img src='" . Storage::url($alumno->foto) . "' width='100'>";
        echo "<p>URL: " . Storage::url($alumno->foto) . "</p>";
        echo "<p>¿Existe archivo?: " . (Storage::exists($alumno->foto) ? 'SÍ' : 'NO') . "</p>";
        echo "</div><hr>";
    }
});

Route::get('/debug-storage', function () {
    echo "<h1>Debug de Storage</h1>";
    
    // Verificar enlace
    $enlace = public_path('storage');
    echo "<p>Ruta: " . $enlace . "</p>";
    echo "<p>¿Existe?: " . (file_exists($enlace) ? '✅ SÍ' : '❌ NO') . "</p>";
    
    // Verificar archivos en storage
    echo "<h2>Archivos en storage/app/public/alumnos:</h2>";
    $archivos = Storage::disk('public')->files('alumnos');
    if (count($archivos) > 0) {
        foreach ($archivos as $archivo) {
            echo "<p>📁 " . $archivo . " - " . (Storage::disk('public')->exists($archivo) ? '✅ Existe' : '❌ No existe') . "</p>";
        }
    } else {
        echo "<p>❌ No hay archivos</p>";
    }
});