<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'color', 'start', 'end', 'user_id', 'obra_social_id', 'paciente_id', 'medico_id', 'consultorio_id', 'practica_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function obrasocial()
    {
        return $this->belongsTo(Obrasocial::class, 'obra_social_id');
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    public function medico()
    {
        return $this->belongsTo(Medico::class, 'medico_id');
    }

    public function consultorio()
    {
        return $this->belongsTo(Consultorio::class, 'consultorio_id');
    }

    public function practica()
    {
        return $this->belongsTo(Practica::class, 'practica_id');
    }
}
