<?php

namespace App\Http\Controllers;

use App\Models\Reporte;
use App\Models\Alumno;
use App\Models\Grupo;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $reportesPorTipo = Reporte::selectRaw('tipo, count(*) as total')
            ->groupBy('tipo')
            ->get();

        $alumnosConMasReportes = Alumno::withCount('reportes')
            ->having('reportes_count', '>=', 3)
            ->orderBy('reportes_count', 'desc')
            ->get();

        return view('dashboard', compact('reportesPorTipo', 'alumnosConMasReportes'));
    }

    public function estadisticas()
    {
        $reportesPorTipo = Reporte::selectRaw('tipo, count(*) as total')
            ->groupBy('tipo')
            ->get();

        return response()->json($reportesPorTipo);
    }
}