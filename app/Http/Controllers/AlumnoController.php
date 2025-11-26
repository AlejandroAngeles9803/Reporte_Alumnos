<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Grupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AlumnoController extends Controller
{
    public function index()
    {
        $alumnos = Alumno::with(['grupo', 'reportes'])
                        ->orderBy('nombre')
                        ->paginate(12);
        
        return view('alumnos.index', compact('alumnos'));
    }

    public function create()
    {
        $grupos = Grupo::all();
        return view('alumnos.create', compact('grupos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'matricula' => [
                'required',
                'string',
                'max:50',
                Rule::unique('alumnos')->whereNull('deleted_at')
            ],
            'grupo_id' => 'required|exists:grupos,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('alumnos', 'public');
        }

        try {
            Alumno::create($data);
            return redirect()->route('alumnos.index')->with('success', 'Alumno creado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear el alumno: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Alumno $alumno)
    {
        $alumno->load(['grupo', 'reportes']);
        return view('alumnos.show', compact('alumno'));
    }

    public function edit(Alumno $alumno)
    {
        $grupos = Grupo::all();
        return view('alumnos.edit', compact('alumno', 'grupos'));
    }

    public function update(Request $request, Alumno $alumno)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'matricula' => [
                'required',
                'string',
                'max:50',
                Rule::unique('alumnos')->ignore($alumno->id)
            ],
            'grupo_id' => 'required|exists:grupos,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            // Eliminar foto anterior si existe
            if ($alumno->foto) {
                Storage::disk('public')->delete($alumno->foto);
            }
            $data['foto'] = $request->file('foto')->store('alumnos', 'public');
        }

        try {
            $alumno->update($data);
            return redirect()->route('alumnos.index')->with('success', 'Alumno actualizado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar el alumno: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Alumno $alumno)
    {
        try {
            // Eliminar foto si existe
            if ($alumno->foto) {
                Storage::disk('public')->delete($alumno->foto);
            }
            
            $alumno->delete();
            return redirect()->route('alumnos.index')->with('success', 'Alumno eliminado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el alumno: ' . $e->getMessage());
        }
    }
}