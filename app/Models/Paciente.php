<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    public function localidad()
    {
        return $this->belongsTo(Localidad::class , 'cod_postal_id');
    }
}