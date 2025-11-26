<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function index()
    {
        $grupos = Grupo::withCount('alumnos')->get();
        return view('grupos.index', compact('grupos'));
    }

    public function create()
    {
        return view('grupos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'turno' => 'required|in:mañana,tarde'
        ]);

        Grupo::create($request->all());

        return redirect()->route('grupos.index')->with('success', 'Grupo creado exitosamente');
    }

    public function show(Grupo $grupo)
    {
        $grupo->load('alumnos.reportes');
        return view('grupos.show', compact('grupo'));
    }

    public function edit(Grupo $grupo)
    {
        return view('grupos.edit', compact('grupo'));
    }

    public function update(Request $request, Grupo $grupo)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'turno' => 'required|in:mañana,tarde'
        ]);

        $grupo->update($request->all());

        return redirect()->route('grupos.index')->with('success', 'Grupo actualizado exitosamente');
    }

    public function destroy(Grupo $grupo)
    {
        $grupo->delete();
        return redirect()->route('grupos.index')->with('success', 'Grupo eliminado exitosamente');
    }
}