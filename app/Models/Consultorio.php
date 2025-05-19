<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultorio extends Model
{
    protected $fillable = ['nombre', 'numero', 'direccion', 'telefono', 'observacion'];
    
    public function medicos()
    {
        return $this->hasMany(Medico::class);
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }

    public function practicas()
    {
        return $this->hasMany(Practica::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
