<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'matricula', 'grupo_id', 'foto', 'turno'];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    public function reportes()
    {
        return $this->hasMany(Reporte::class);
    }

    public function getTotalReportesAttribute()
    {
        return $this->reportes()->count();
    }

    public function getAlertaAttribute()
    {
        $total = $this->total_reportes;
        if ($total >= 3) {
            return 'danger';
        } elseif ($total == 2) {
            return 'warning';
        } elseif ($total == 1) {
            return 'info';
        }
        return 'success';
    }

    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return null;
    }
}