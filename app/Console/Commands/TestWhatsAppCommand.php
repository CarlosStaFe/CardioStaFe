<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Twilio\Rest\Client;
use Exception;

class TestWhatsAppCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Probar la configuración de WhatsApp con Twilio';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== PRUEBA DE CONFIGURACIÓN WHATSAPP ===');
        $this->newLine();

        // Verificar variables de entorno
        $this->info('1. Verificando variables de entorno...');
        
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $twilioNumber = env('TWILIO_WHATSAPP_NUMBER');

        $this->line('   TWILIO_SID: ' . ($sid ? '<fg=green>✓ Configurado</>' : '<fg=red>✗ No configurado</>'));
        $this->line('   TWILIO_AUTH_TOKEN: ' . ($token ? '<fg=green>✓ Configurado</>' : '<fg=red>✗ No configurado</>'));
        $this->line('   TWILIO_WHATSAPP_NUMBER: ' . ($twilioNumber ? "<fg=green>✓ Configurado ($twilioNumber)</>" : '<fg=red>✗ No configurado</>'));
        $this->newLine();

        if (!$sid || !$token || !$twilioNumber) {
            $this->error('❌ Error: Faltan configurar las variables de entorno en el archivo .env');
            $this->line('Consulta el archivo CONFIGURACION_WHATSAPP.md para más detalles.');
            return 1;
        }

        // Probar conexión con Twilio
        $this->info('2. Probando conexión con Twilio...');
        try {
            $client = new Client($sid, $token);
            
            // Obtener información de la cuenta
            $account = $client->api->accounts($sid)->fetch();
            $this->line('   <fg=green>✓ Conexión exitosa</>');
            $this->line('   Cuenta: ' . $account->friendlyName);
            $this->line('   Estado: ' . $account->status);
            $this->newLine();
            
        } catch (Exception $e) {
            $this->line('   <fg=red>✗ Error de conexión: ' . $e->getMessage() . '</>');
            return 1;
        }

        // Validar formato de números de prueba
        $this->info('3. Validando formato de números argentinos...');
        $numerosTest = [
            '3425123456',  // Válido - Santa Fe
            '1134567890',  // Inválido - Buenos Aires
            '3424567890',  // Válido - Santa Fe
            '9876543210',  // Válido - Celular
            '342512345',   // Inválido - Muy corto
            '34251234567', // Inválido - Muy largo
        ];

        foreach ($numerosTest as $numero) {
            $valido = preg_match('/^3[4-9][0-9]{8}$/', $numero);
            $formatoWhatsApp = 'whatsapp:+549' . $numero;
            $color = $valido ? 'green' : 'red';
            $icono = $valido ? '✓' : '✗';
            $estado = $valido ? "Válido ($formatoWhatsApp)" : 'Inválido';
            $this->line("   <fg=$color>$icono $numero -> $estado</>");
        }

        $this->newLine();
        $this->info('4. Información adicional:');
        $this->line('   La validación se realiza automáticamente en el método enviarWhatsApp()');
        $this->line('   Solo se envían mensajes a números que comiencen con 3 y tengan 10 dígitos');
        $this->newLine();

        $this->info('<fg=green>=== CONFIGURACIÓN LISTA ===</>');
        $this->line('El sistema está configurado correctamente para enviar WhatsApp.');
        $this->line('Los mensajes se enviarán automáticamente al reservar turnos.');
        $this->newLine();

        $this->comment('Para probar el envío real:');
        $this->line('1. Activa el sandbox de WhatsApp en Twilio');
        $this->line('2. Registra tu número en el sandbox');
        $this->line('3. Reserva un turno con un número válido argentino');

        return 0;
    }
}
