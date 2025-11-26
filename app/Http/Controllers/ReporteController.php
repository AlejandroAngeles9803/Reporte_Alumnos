<?php

namespace App\Http\Controllers;

use App\Models\Reporte;
use App\Models\Alumno;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    public function index()
    {
        $reportes = Reporte::with('alumno.grupo')->latest()->get();
        return view('reportes.index', compact('reportes'));
    }

    public function create()
    {
        $alumnos = Alumno::with('grupo')->get();
        return view('reportes.create', compact('alumnos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alumno_id' => 'required|exists:alumnos,id',
            'tipo' => 'required|in:credencial,uniforme,cabello,otro',
            'descripcion' => 'nullable|string',
            'horas_sentencia' => 'required|integer|min:0',
            'fecha_reporte' => 'required|date'
        ]);

        Reporte::create($request->all());

        return redirect()->route('reportes.index')->with('success', 'Reporte creado exitosamente');
    }

    public function show(Reporte $reporte)
    {
        $reporte->load('alumno.grupo');
        return view('reportes.show', compact('reporte'));
    }

    public function edit(Reporte $reporte)
    {
        $alumnos = Alumno::with('grupo')->get();
        return view('reportes.edit', compact('reporte', 'alumnos'));
    }

    public function update(Request $request, Reporte $reporte)
    {
        $request->validate([
            'alumno_id' => 'required|exists:alumnos,id',
            'tipo' => 'required|in:credencial,uniforme,cabello,otro',
            'descripcion' => 'nullable|string',
            'horas_sentencia' => 'required|integer|min:0',
            'fecha_reporte' => 'required|date'
        ]);

        $reporte->update($request->all());

        return redirect()->route('reportes.index')->with('success', 'Reporte actualizado exitosamente');
    }

    public function destroy(Reporte $reporte)
    {
        $reporte->delete();
        return redirect()->route('reportes.index')->with('success', 'Reporte eliminado exitosamente');
    }

    public function estadisticas()
    {
        $estadisticas = Reporte::selectRaw('tipo, count(*) as total')
            ->groupBy('tipo')
            ->get();

        return view('reportes.estadisticas', compact('estadisticas'));
    }

    public function imprimir()
    {
        $reportes = Reporte::with('alumno.grupo')->latest()->get();
        $pdf = Pdf::loadView('reportes.pdf', compact('reportes'));
        return $pdf->download('reportes-incidencias.pdf');
    }
}