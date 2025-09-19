<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Mail\RecordatorioEvento;

class EnviarRecordatorioEventos extends Command
{
    protected $signature = 'eventos:recordatorio';
    protected $description = 'Envía recordatorios por email dos días antes de cada evento';

    public function handle()
    {
        Log::info('El scheduler ejecutó el comando de recordatorio');

        $fechaObjetivo = Carbon::now()->addDays(2)->format('Y-m-d');
        $eventos = Event::whereDate('start', $fechaObjetivo)->with('paciente')->get();

        foreach ($eventos as $evento) {
            if ($evento->paciente && $evento->paciente->email) {
                Mail::to($evento->paciente->email)
                    ->send(new RecordatorioEvento($evento));
            }
        }
        $this->info('Recordatorios enviados.');
    }
}
