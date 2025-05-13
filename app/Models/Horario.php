<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $fillable = ['dia', 'hora_inicio', 'hora_fin', 'especialidad',  'doctor_id', 'consultorio_id'];

    public function doctor()
    {
        return $this->belongsTo(Medico::class);
    }
    
    public function consultorio()
    {
        return $this->belongsTo(Consultorio::class);
    }

}
