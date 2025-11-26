<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlumnoMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Debes iniciar sesión');
        }

        // Verificación directa del role
        if (Auth::user()->role !== 'alumno') {
            return redirect('/')->with('error', 'Acceso restringido para alumnos');
        }

        return $next($request);
    }
}