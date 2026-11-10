<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use App\Services\TwilioService;
use Carbon\Carbon;

class ProbarSMS extends Command
{
    protected $signature = 'sms:probar {evento_id} {--tipo=recordatorio : Tipo de mensaje: recordatorio o suspension}';
    protected $description = 'Prueba el envío de SMS para un evento específico';

    protected $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        parent::__construct();
        $this->twilioService = $twilioService;
    }

    public function handle()
    {
        $eventoId = $this->argument('evento_id');
        $tipo = $this->option('tipo');

        if (!$this->twilioService->estaConfigurado()) {
            $this->error('❌ Twilio no está configurado. Revise las variables de entorno TWILIO_SID, TWILIO_AUTH_TOKEN y TWILIO_PHONE_NUMBER');
            return 1;
        }

        $evento = Event::with(['paciente', 'medico', 'practica', 'consultorio'])->find($eventoId);

        if (!$evento) {
            $this->error("❌ No se encontró el evento con ID: {$eventoId}");
            return 1;
        }

        if (!$evento->paciente || !$evento->paciente->telefono) {
            $this->error('❌ El evento no tiene un paciente con teléfono asociado');
            return 1;
        }

        try {
            if ($tipo === 'suspension') {
                $mensaje = $this->twilioService->crearMensajeSuspension($evento, 'Prueba de mensaje de suspensión');
            } else {
                $mensaje = $this->twilioService->crearMensajeRecordatorio($evento);
            }

            $this->info("📱 Enviando SMS de {$tipo} a: " . $evento->paciente->telefono);
            $this->info("👤 Paciente: " . $evento->paciente->apel_nombres);
            $this->info("📅 Fecha turno: " . Carbon::parse($evento->start)->format('d/m/Y H:i'));
            $this->newLine();
            $this->info("📝 Mensaje:");
            $this->line($mensaje);
            $this->newLine();

            if ($this->confirm('¿Desea enviar este SMS?')) {
                $result = $this->twilioService->enviarSMS($evento->paciente->telefono, $mensaje);
                
                $this->info("✅ SMS enviado exitosamente!");
                $this->info("🆔 Message SID: " . $result->sid);
                $this->info("📲 A: " . $result->to);
                $this->info("📞 Desde: " . $result->from);
                $this->info("💰 Precio: " . ($result->price ?? 'N/A') . ' ' . ($result->priceUnit ?? ''));
            } else {
                $this->info('❌ Envío cancelado');
            }

        } catch (\Exception $e) {
            $this->error("❌ Error al enviar SMS: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}