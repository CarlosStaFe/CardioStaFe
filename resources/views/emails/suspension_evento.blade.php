<div style="text-align:center; margin-bottom:20px;">
    <img src="{{ asset('public/assets/img/LogoCompletoChico.jpg') }}" alt="Logo Centro" style="max-width:180px;">
</div>

<h2 style="color: #dc3545;">Suspensión de turno</h2>

<p>Estimado/a {{ $evento->paciente->apel_nombres ?? 'Paciente' }},</p>

<p>Lamentamos informarle que su turno programado ha sido <strong style="color: #dc3545;">suspendido</strong>:</p>

<div style="background-color: #f8f9fa; padding: 15px; border-left: 4px solid #dc3545; margin: 20px 0;">
    <ul style="margin: 0; padding-left: 20px;">
        <li><b>Fecha:</b> {{ \Carbon\Carbon::parse($evento->start)->format('d/m/Y') }}</li>
        <li><b>Hora:</b> {{ \Carbon\Carbon::parse($evento->start)->format('H:i') }}</li>
        <li><b>Práctica:</b> {{ $evento->practica->nombre ?? '' }}</li>
        <li><b>Médico:</b> {{ $evento->medico->apel_nombres ?? '' }}</li>
        <li><b>Consultorio:</b> {{ $evento->consultorio->nombre ?? '' }}</li>
    </ul>
</div>

@if($motivo)
<p><b>Motivo de la suspensión:</b> {{ $motivo }}</p>
@endif

<p>Para reprogramar su turno, ingrese a:</p>
<ul>
    <li><b>Página:</b> <a href="{{ config('app.url') }}">{{ config('app.url') }}</a></li>
</ul>

<p>Disculpe las molestias ocasionadas y gracias por su comprensión.</p>

<hr style="margin: 30px 0; border: none; border-top: 1px solid #dee2e6;">
<p style="font-size: 12px; color: #6c757d; text-align: center;">
    Este es un mensaje automático, por favor no responda a este correo.
</p>