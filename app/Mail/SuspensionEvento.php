<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SuspensionEvento extends Mailable
{
    use Queueable, SerializesModels;

    public $evento;
    public $motivo;

    public function __construct($evento, $motivo = null)
    {
        $this->evento = $evento;
        $this->motivo = $motivo;
    }

    public function build()
    {
        return $this->subject('Suspensión de turno médico')
            ->view('emails.suspension_evento');
    }
}
