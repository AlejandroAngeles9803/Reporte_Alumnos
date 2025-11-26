<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    use HasFactory;

    protected $fillable = ['alumno_id', 'tipo', 'descripcion', 'horas_sentencia', 'fecha_reporte'];

    protected $casts = [
        'fecha_reporte' => 'date',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }
}