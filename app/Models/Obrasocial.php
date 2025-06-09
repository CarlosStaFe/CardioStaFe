<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obrasocial extends Model
{
    use HasFactory;

    protected $table = 'obrasociales';

    protected $fillable = [
        'nombre', 'telefono', 'contacto', 'email', 'activo', 'documentacion', 'observacion'
    ];

    public function pacientes()
    {
        return $this->hasMany(Paciente::class, 'obra_social_id');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'obra_social_id');
    }

}
