<div style="text-align:center; margin-bottom:20px;">
    <img src="{{ asset('LogoCompletoChico.jpg') }}" alt="Logo Centro" style="max-width:180px;">
</div>

<h2>Recordatorio de turno</h2>

<p>Hola {{ $evento->paciente->apel_nombres ?? 'Paciente' }},</p>
<p>Le recordamos que tiene un turno programado para:</p>
<ul>
    <li><b>Fecha:</b> {{ \Carbon\Carbon::parse($evento->start)->format('d/m/Y') }}</li>
    <li><b>Hora:</b> {{ \Carbon\Carbon::parse($evento->start)->format('H:i') }}</li>
    <li><b>Práctica:</b> {{ $evento->practica->nombre ?? '' }}</li>
    <li><b>Médico:</b> {{ $evento->medico->apel_nombres ?? '' }}</li>
    <li><b>Consultorio:</b> {{ $evento->consultorio->nombre ?? '' }}</li>
</ul>
<p>Por favor, no olvide asistir con la documentación requerida.</p>
<p>Gracias por confiar en nuestro centro.</p>
