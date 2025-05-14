<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $fillable = ['dia', 'fecha', 'hora_inicio', 'hora_fin', 'rango', 'practica_id',  'doctor_id', 'consultorio_id'];

    public function practica()
    {
        return $this->belongsTo(Practica::class);
    }

    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }
    
    public function consultorio()
    {
        return $this->belongsTo(Consultorio::class);
    }

}
