<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Medico extends Model
{
    use HasFactory;

    protected $fillable = ['apel_nombres', 'matricula', 'telefono', 'email', 'especialidad', 'user_id'];

    public function consultorio()
    {
        return $this->belongsTo(Consultorio::class);
    }

    public function horario()
    {
        return $this->hasMany(Horario::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
