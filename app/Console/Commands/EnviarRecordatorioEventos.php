<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Mail\RecordatorioEvento;
use App\Services\TwilioService;

class EnviarRecordatorioEventos extends Command
{
    protected $signature = 'eventos:recordatorio';
    protected $description = 'Envía recordatorios por email y SMS dos días antes de cada evento';

    protected $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        parent::__construct();
        $this->twilioService = $twilioService;
    }

    public function handle()
    {
        Log::info('Iniciando envío de recordatorios automáticos');

        $fechaObjetivo = Carbon::now()->addDays(2)->format('Y-m-d');
        $eventos = Event::whereDate('start', $fechaObjetivo)
                        ->with(['paciente', 'medico', 'practica', 'consultorio'])
                        ->where('title', '!=', '- Horario disponible')
                        ->get();

        $emailsEnviados = 0;
        $smsEnviados = 0;

        foreach ($eventos as $evento) {
            if ($evento->paciente) {
                // Enviar EMAIL si tiene email
                if ($evento->paciente->email) {
                    $emailsEnviados += $this->enviarEmailRecordatorio($evento);
                }

                // Enviar SMS si tiene teléfono y Twilio está configurado
                if ($evento->paciente->telefono && $this->twilioService->estaConfigurado()) {
                    $smsEnviados += $this->enviarSMSRecordatorio($evento);
                }
            }
        }

        $mensaje = "Recordatorios enviados - Emails: {$emailsEnviados}, SMS: {$smsEnviados}";
        $this->info($mensaje);
        
        Log::info("Proceso de recordatorios completado", [
            'emails_enviados' => $emailsEnviados,
            'sms_enviados' => $smsEnviados,
            'total_eventos' => $eventos->count()
        ]);
    }

    /**
     * Envía email de recordatorio
     */
    private function enviarEmailRecordatorio($evento)
    {
        try {
            Mail::to($evento->paciente->email)->send(new RecordatorioEvento($evento));
            
            Log::info("Email de recordatorio enviado", [
                'paciente' => $evento->paciente->apel_nombres,
                'email' => $evento->paciente->email,
                'fecha_turno' => $evento->start
            ]);
            
            return 1;
        } catch (\Exception $e) {
            Log::error("Error enviando email de recordatorio", [
                'paciente' => $evento->paciente->apel_nombres,
                'error' => $e->getMessage()
            ]);
            return 0;
        }
    }

    /**
     * Envía SMS de recordatorio usando TwilioService
     */
    private function enviarSMSRecordatorio($evento)
    {
        try {
            $mensaje = $this->twilioService->crearMensajeRecordatorio($evento);
            $this->twilioService->enviarSMS($evento->paciente->telefono, $mensaje);
            
            Log::info("SMS de recordatorio enviado", [
                'paciente' => $evento->paciente->apel_nombres,
                'telefono' => $evento->paciente->telefono,
                'fecha_turno' => $evento->start
            ]);
            
            return 1;
        } catch (\Exception $e) {
            Log::error("Error enviando SMS de recordatorio", [
                'paciente' => $evento->paciente->apel_nombres,
                'error' => $e->getMessage()
            ]);
            return 0;
        }
    }
}
