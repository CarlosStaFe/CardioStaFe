<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $table = 'agenda';
    
    protected $fillable = [
        'fecha',
        'medico_id',
        'practica_id', 
        'consultorio_id',
        'hora_inicio',
        'hora_fin'
    ];
    
    protected $casts = [
        'fecha' => 'date'
    ];
    
    // Relationships
    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }
    
    public function practica()
    {
        return $this->belongsTo(Practica::class);
    }
    
    public function consultorio()
    {
        return $this->belongsTo(Consultorio::class);
    }
}
