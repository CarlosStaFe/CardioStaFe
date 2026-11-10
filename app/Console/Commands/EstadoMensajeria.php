<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use App\Services\TwilioService;
use Carbon\Carbon;

class EstadoMensajeria extends Command
{
    protected $signature = 'mensajeria:estado';
    protected $description = 'Muestra el estado de la configuración de email y SMS';

    protected $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        parent::__construct();
        $this->twilioService = $twilioService;
    }

    public function handle()
    {
        $this->info('📊 Estado del Sistema de Mensajería');
        $this->newLine();

        // Estado del Email
        $this->info('📧 Configuración de Email:');
        $mailConfig = config('mail.default');
        $this->table(['Configuración', 'Valor'], [
            ['Mailer por defecto', $mailConfig],
            ['Host SMTP', config('mail.mailers.smtp.host')],
            ['Puerto SMTP', config('mail.mailers.smtp.port')],
            ['Username SMTP', config('mail.mailers.smtp.username') ? '✅ Configurado' : '❌ No configurado'],
            ['Password SMTP', config('mail.mailers.smtp.password') ? '✅ Configurado' : '❌ No configurado'],
        ]);

        $this->newLine();

        // Estado del SMS/Twilio
        $this->info('📱 Configuración de SMS (Twilio):');
        $twilioStatus = $this->twilioService->estaConfigurado();
        
        $this->table(['Configuración', 'Estado'], [
            ['Twilio SID', config('twilio.sid') ? '✅ Configurado' : '❌ No configurado'],
            ['Twilio Auth Token', config('twilio.auth_token') ? '✅ Configurado' : '❌ No configurado'],
            ['Número de teléfono', config('twilio.phone_number') ? '✅ ' . config('twilio.phone_number') : '❌ No configurado'],
            ['WhatsApp Number', config('twilio.whatsapp_number') ? '✅ ' . config('twilio.whatsapp_number') : '❌ No configurado'],
            ['Estado general', $twilioStatus ? '✅ Funcionando' : '❌ No funcional'],
        ]);

        $this->newLine();

        // Próximos recordatorios
        $this->info('📅 Próximos Recordatorios (2 días):');
        $fechaObjetivo = Carbon::now()->addDays(2)->format('Y-m-d');
        $eventos = Event::whereDate('start', $fechaObjetivo)
                        ->with(['paciente'])
                        ->where('title', '!=', '- Horario disponible')
                        ->get();

        if ($eventos->count() > 0) {
            $recordatorios = [];
            foreach ($eventos as $evento) {
                if ($evento->paciente) {
                    $recordatorios[] = [
                        'Paciente' => $evento->paciente->apel_nombres,
                        'Fecha/Hora' => Carbon::parse($evento->start)->format('d/m/Y H:i'),
                        'Email' => $evento->paciente->email ? '📧' : '❌',
                        'SMS' => $evento->paciente->telefono ? '📱' : '❌',
                    ];
                }
            }
            $this->table(['Paciente', 'Fecha/Hora', 'Email', 'SMS'], $recordatorios);
        } else {
            $this->line('🔄 No hay turnos programados para ' . Carbon::now()->addDays(2)->format('d/m/Y'));
        }

        $this->newLine();

        // Scheduler status
        $this->info('⏰ Configuración del Scheduler:');
        $this->line('• Comando: eventos:recordatorio');
        $this->line('• Frecuencia: Diariamente a las 21:30');
        $this->line('• Archivo: app/Console/Kernel.php');

        $this->newLine();

        // Recomendaciones
        if (!$twilioStatus) {
            $this->warn('⚠️  Para activar SMS, configure las siguientes variables en su archivo .env:');
            $this->line('TWILIO_SID=su_account_sid_de_twilio');
            $this->line('TWILIO_AUTH_TOKEN=su_auth_token_de_twilio');
            $this->line('TWILIO_PHONE_NUMBER=+1234567890');
        }

        if ($mailConfig === 'log') {
            $this->warn('⚠️  El email está configurado en modo LOG. Los emails no se enviarán realmente.');
        }

        return 0;
    }
}