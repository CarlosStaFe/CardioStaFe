<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    use HasFactory;

    // Especifica el nombre correcto de la tabla
    protected $table = 'localidades';

    protected $fillable = ['nombre', 'codigo_postal', 'provincia_id'];

    public function pacientes()
    {
        return $this->hasMany(Paciente::class, 'cod_postal_id');
    }
}
