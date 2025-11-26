<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Administrador extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['nombre', 'email', 'password', 'turno'];

    protected $hidden = ['password', 'remember_token'];

    // Relación con grupos del mismo turno
    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'turno', 'turno');
    }

    // Obtener alumnos del mismo turno
    public function alumnosTurno()
    {
        return Alumno::where('turno', $this->turno)->get();
    }

    // Obtener reportes del mismo turno
    public function reportesTurno()
    {
        return Reporte::whereHas('alumno', function($query) {
            $query->where('turno', $this->turno);
        })->get();
    }
}