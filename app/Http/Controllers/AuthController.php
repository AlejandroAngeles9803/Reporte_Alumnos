<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'tipo_usuario' => 'required|in:admin,alumno'
        ]);

        // Buscar usuario según el tipo
        if ($request->tipo_usuario === 'admin') {
            $user = User::where('email', $request->email)
                        ->where('role', 'admin')
                        ->first();
        } else {
            // Para alumnos, buscamos por email
            $user = User::where('email', $request->email)
                        ->where('role', 'alumno')
                        ->first();
        }

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            
            // Redirigir según el tipo de usuario
            if ($user->role === 'admin') {
                return redirect()->route('dashboard')->with('success', 'Bienvenido ' . $user->name);
            } else {
                return redirect()->route('alumno.dashboard')->with('success', 'Bienvenido ' . $user->name);
            }
        }

        return back()->with('error', 'Credenciales incorrectas');
    }

    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect()->route('login')->with('success', 'Sesión cerrada correctamente');
    }

    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Si es alumno, redirigir a su dashboard
        if ($user->role === 'alumno') {
            return $this->alumnoDashboard();
        }
        
        // Dashboard para administradores
        $turno = $user->turno;
        $totalAlumnos = Alumno::where('turno', $turno)->count();
        $totalReportes = \App\Models\Reporte::whereHas('alumno', function($query) use ($turno) {
            $query->where('turno', $turno);
        })->count();
        $totalGrupos = \App\Models\Grupo::where('turno', $turno)->count();

        return view('dashboard', compact('turno', 'totalAlumnos', 'totalReportes', 'totalGrupos'));
    }

    public function alumnoDashboard()
    {
        $user = Auth::user();
        
        if ($user->role !== 'alumno') {
            return redirect()->route('dashboard')->with('error', 'Acceso no permitido');
        }
        
        // Buscar el alumno relacionado con este usuario
        // El email del usuario es la matrícula + @escuela.com
        $matricula = str_replace('@escuela.com', '', $user->email);
        $alumno = Alumno::where('matricula', $matricula)->first();

        if (!$alumno) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'No se encontró información del alumno');
        }

        $reportes = $alumno->reportes()->orderBy('fecha_reporte', 'desc')->get();
        
        return view('alumno.dashboard', compact('alumno', 'reportes'));
    }
}