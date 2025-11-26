<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EstadisticasController extends Controller
{
    public function index()
    {
        // Vista mínima sin dependencias
        return view('estadisticas_simple');
    }
}