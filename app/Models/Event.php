<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'color', 'start_date', 'start_time', 'user_id', 'medico_id', 'consultorio_id', 'practica_id'];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

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
