<?php

namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class TwilioService
{
    protected $client;
    protected $from;

    public function __construct()
    {
        $sid = config('twilio.sid');
        $token = config('twilio.auth_token');
        
        if ($sid && $token) {
            $this->client = new Client($sid, $token);
            $this->from = config('twilio.phone_number');
        }
    }

    /**
     * Envía SMS a un número de teléfono
     */
    public function enviarSMS($telefono, $mensaje)
    {
        if (!$this->client) {
            throw new \Exception('Twilio no está configurado correctamente');
        }

        $telefonoFormateado = $this->formatearTelefono($telefono);

        return $this->client->messages->create(
            $telefonoFormateado,
            [
                'from' => $this->from,
                'body' => $mensaje
            ]
        );
    }

    /**
     * Envía WhatsApp a un número de teléfono
     */
    public function enviarWhatsApp($telefono, $mensaje)
    {
        if (!$this->client) {
            throw new \Exception('Twilio no está configurado correctamente');
        }

        $telefonoFormateado = 'whatsapp:' . $this->formatearTelefono($telefono);
        $whatsappFrom = config('twilio.whatsapp_number');

        return $this->client->messages->create(
            $telefonoFormateado,
            [
                'from' => $whatsappFrom,
                'body' => $mensaje
            ]
        );
    }

    /**
     * Formatea el número de teléfono para Twilio
     */
    public function formatearTelefono($telefono)
    {
        // Limpiar el teléfono de caracteres especiales
        $telefono = preg_replace('/[^0-9+]/', '', $telefono);
        
        // Si no empieza con +, agregar código de Argentina (+54)
        if (!str_starts_with($telefono, '+')) {
            $codigoPais = config('twilio.default_country_code', '+54');
            $codigoMovil = config('twilio.default_mobile_code', '9');
            
            if (str_starts_with($telefono, '549')) {
                $telefono = '+' . $telefono;
            } elseif (str_starts_with($telefono, '9')) {
                $telefono = $codigoPais . $telefono;
            } else {
                $telefono = $codigoPais . $codigoMovil . $telefono;
            }
        }
        
        return $telefono;
    }

    /**
     * Crea mensaje de recordatorio para turno médico
     */
    public function crearMensajeRecordatorio($evento)
    {
        $fecha = Carbon::parse($evento->start)->format('d/m/Y');
        $hora = Carbon::parse($evento->start)->format('H:i');
        $paciente = $evento->paciente->apel_nombres ?? 'Paciente';
        $practica = $evento->practica->nombre ?? '';
        $medico = $evento->medico->apel_nombres ?? '';
        
        return "🏥 RECORDATORIO DE TURNO\n\n" .
               "Hola {$paciente},\n" .
               "Le recordamos su turno:\n\n" .
               "📅 Fecha: {$fecha}\n" .
               "🕐 Hora: {$hora}\n" .
               "👩‍⚕️ Médico: {$medico}\n" .
               "🩺 Práctica: {$practica}\n\n" .
               "Por favor llegue 15 min antes.\n" .
               "¡Gracias por confiar en nosotros!";
    }

    /**
     * Crea mensaje de suspensión para turno médico
     */
    public function crearMensajeSuspension($evento, $motivo = null)
    {
        $fecha = Carbon::parse($evento->start)->format('d/m/Y');
        $hora = Carbon::parse($evento->start)->format('H:i');
        $paciente = $evento->paciente->apel_nombres ?? 'Paciente';
        $practica = $evento->practica->nombre ?? '';
        $medico = $evento->medico->apel_nombres ?? '';
        
        $mensaje = "🚫 SUSPENSIÓN DE TURNO\n\n" .
                  "Estimado/a {$paciente},\n" .
                  "Lamentamos informarle que su turno ha sido suspendido:\n\n" .
                  "📅 Fecha: {$fecha}\n" .
                  "🕐 Hora: {$hora}\n" .
                  "👩‍⚕️ Médico: {$medico}\n" .
                  "🩺 Práctica: {$practica}\n\n";
        
        if ($motivo) {
            $mensaje .= "Motivo: {$motivo}\n\n";
        }
        
        $mensaje .= "Para reprogramar su turno, contáctenos.\n" .
                   "Disculpe las molestias.";
        
        return $mensaje;
    }

    /**
     * Verifica si Twilio está configurado correctamente
     */
    public function estaConfigurado()
    {
        return $this->client !== null && $this->from !== null;
    }
}