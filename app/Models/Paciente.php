<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $fillable = [
        'apel_nombres', 'nacimiento', 'sexo', 'tipo_documento', 'num_documento',
        'domicilio', 'cod_postal_id', 'telefono', 'email', 'obra_social_id', 'num_afiliado', 'observacion'
    ];
    
    public function localidad()
    {
        return $this->belongsTo(Localidad::class , 'cod_postal_id');
    }

    public function obraSocial()
    {
        return $this->belongsTo(Obrasocial::class , 'obra_social_id');
    }

}