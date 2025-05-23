<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $fillable = ['fecha_inicio', 'fecha_fin', 'hora_inicio', 'hora_fin', 'rango',  'medico_id', 'consultorio_id', 'practica_id',
                            'lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];

    public function medicos()
    {
        return $this->belongsTo(Medico::class);
    }
    
    public function consultorios()
    {
        return $this->belongsTo(Consultorio::class);
    }

    public function practicas()
    {
        return $this->belongsTo(Practica::class);
    }
}
