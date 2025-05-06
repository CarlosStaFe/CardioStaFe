<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultorio extends Model
{
    protected $fillable = ['nombre', 'numero', 'direccion', 'telefono', 'especialidad', 'observacion'];
    
    public function doctores()
    {
        return $this->hasMany(Doctor::class);
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }
}
