<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'color', 'start', 'end', 'user_id', 'obra_social_id', 'paciente_id', 'medico_id', 'consultorio_id', 'practica_id'];

    protected static function booted()
    {
        static::deleting(function ($event) {
            // Log de la eliminación que se va a realizar
            Log::info('Event deleting - Eliminando registros de agenda correspondientes', [
                'event_id' => $event->id,
                'start' => $event->start,
                'medico_id' => $event->medico_id,
                'consultorio_id' => $event->consultorio_id,
                'practica_id' => $event->practica_id,
            ]);

            // Extraer la fecha del evento
            $fechaEvento = date('Y-m-d', strtotime($event->start));

            // Primero verificar qué registros coinciden antes de eliminar
            $registrosCoincidentes = \App\Models\Agenda::where('fecha', $fechaEvento)
                ->where('medico_id', $event->medico_id)
                ->where('practica_id', $event->practica_id)
                ->where('consultorio_id', $event->consultorio_id)
                ->get();

            Log::info('Event deleting - Registros de agenda encontrados antes de eliminar', [
                'event_id' => $event->id,
                'registros_encontrados' => $registrosCoincidentes->count(),
                'registros' => $registrosCoincidentes->toArray(),
                'criterios_busqueda' => [
                    'fecha' => $fechaEvento,
                    'medico_id' => $event->medico_id,
                    'practica_id' => $event->practica_id,
                    'consultorio_id' => $event->consultorio_id,
                ]
            ]);

            // Solo proceder si hay registros que eliminar
            if ($registrosCoincidentes->count() > 0) {
                // Eliminar registros de agenda correspondientes
                $agendaEliminada = \App\Models\Agenda::where('fecha', $fechaEvento)
                    ->where('medico_id', $event->medico_id)
                    ->where('practica_id', $event->practica_id)
                    ->where('consultorio_id', $event->consultorio_id)
                    ->delete();

                Log::info('Event deleted - Registros de agenda eliminados', [
                    'event_id' => $event->id,
                    'agenda_eliminada' => $agendaEliminada,
                    'criterios' => [
                        'fecha' => $fechaEvento,
                        'medico_id' => $event->medico_id,
                        'practica_id' => $event->practica_id,
                        'consultorio_id' => $event->consultorio_id,
                    ]
                ]);
            } else {
                Log::info('Event deleted - Sin registros de agenda para eliminar', [
                    'event_id' => $event->id,
                    'motivo' => 'No se encontraron registros de agenda que coincidan con los criterios',
                    'criterios' => [
                        'fecha' => $fechaEvento,
                        'medico_id' => $event->medico_id,
                        'practica_id' => $event->practica_id,
                        'consultorio_id' => $event->consultorio_id,
                    ]
                ]);
            }
        });
    }

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
