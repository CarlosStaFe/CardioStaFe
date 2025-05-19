<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Medico extends Model
{
    use HasFactory;

    protected $fillable = ['apel_nombres', 'matricula', 'telefono', 'email', 'especialidad', 'user_id'];

    public function consultorios()
    {
        return $this->belongsTo(Consultorio::class);
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

}
