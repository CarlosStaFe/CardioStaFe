<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obrasocial extends Model
{
    use HasFactory;

    protected $table = 'obrasociales';

    protected $fillable = [
        'nombre', 'telefono', 'contacto', 'documentacion', 'observacion'
    ];

    public function pacientes()
    {
        return $this->hasMany(Paciente::class, 'obra_social_id');
    }

}
