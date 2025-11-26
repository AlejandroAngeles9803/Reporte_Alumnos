<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'turno',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Verificar si es administrador
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Verificar si es alumno
    public function isAlumno()
    {
        return $this->role === 'alumno';
    }

    // Obtener alumnos del mismo turno (para administradores)
    public function alumnosTurno()
    {
        if ($this->isAdmin()) {
            return \App\Models\Alumno::where('turno', $this->turno)->get();
        }
        return collect();
    }

    // Obtener reportes del mismo turno
    public function reportesTurno()
    {
        if ($this->isAdmin()) {
            return \App\Models\Reporte::whereHas('alumno', function($query) {
                $query->where('turno', $this->turno);
            })->get();
        }
        return collect();
    }
}