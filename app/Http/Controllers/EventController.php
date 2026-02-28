<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Consultorio;
use App\Models\Practica;
use App\Models\Medico;
use App\Models\Obrasocial;
use App\Models\Paciente;
use App\Models\Agenda;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\SuspensionEvento;
use Twilio\Rest\Client;

class EventController extends Controller
{
    public function index(Request $request)
    {
        // Construir query base
        $query = Event::with(['user', 'consultorio', 'practica', 'medico']);
        
        // Aplicar filtros si existen
        if ($request->filled('consultorio_id')) {
            $query->where('consultorio_id', $request->consultorio_id);
        }
        
        if ($request->filled('medico_id')) {
            $query->where('medico_id', $request->medico_id);
        }
        
        if ($request->filled('fecha_desde')) {
            $query->whereDate('start', '>=', $request->fecha_desde);
        }
        
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('start', '<=', $request->fecha_hasta);
        }
        
        if ($request->filled('estado')) {
            if ($request->estado === '- Horario disponible') {
                $query->whereNotIn('title', ['- Reservado', '- En Espera', '- Atendido']);
            } else {
                $query->where('title', $request->estado);
            }
        }
        
        // Siempre ordenar por fecha y hora (start)
        $eventos = $query->orderBy('start', 'asc')->get();
        
        $consultorios = Consultorio::all();
        $practicas = Practica::all();
        $medicos = Medico::all();
        
        return view('admin.eventos.index', compact('eventos', 'consultorios', 'practicas', 'medicos'));
    }

    public function create()
    {
        $medicos = Medico::all();
        $consultorios = Consultorio::all();
        $practicas = Practica::all();
        
        return view('admin.eventos.create', compact('medicos', 'consultorios', 'practicas'));
    }

    public function store(Request $request)
    {
        // Detectar si es una reserva individual (desde el modal) o creación masiva de horarios
        if ($request->has('evento_id') && $request->has('documento')) {
            // Es una reserva individual desde el modal
            Log::info('Detectado como reserva individual');
            return $this->reservarTurno($request);
        }
        
        // Es creación masiva de horarios disponibles
        // Validar los datos recibidos
        $request->validate([
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'rango' => 'required|integer|min:10|max:60', // Rango en minutos
            'medico_id' => 'required|exists:medicos,id',
            'consultorio_id' => 'required|exists:consultorios,id',
            'practica_id' => 'required|exists:practicas,id',
        ]);

        // Obtener días de la semana seleccionados
        $diasSemana = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
        $diasSeleccionados = [];
        foreach ($diasSemana as $dia) {
            if ($request->has($dia) && $request->$dia) {
                $diasSeleccionados[] = $dia;
            }
        }

        // Obtener las horas como strings
        $horaInicioStr = $request->hora_inicio;
        $horaFinStr = $request->hora_fin;

        if (empty($diasSeleccionados)) {
            return redirect()->back()
                ->withInput()
                ->with('mensaje', 'Debe seleccionar al menos un día de la semana.')
                ->with('icono', 'error')
                ->with('showBtn', 'false')
                ->with('timer', '4000');
        }

        // Validar que la hora de inicio sea menor que la hora de fin
        if (strtotime($horaInicioStr) >= strtotime($horaFinStr)) {
            return redirect()->back()
                ->withInput()
                ->with('mensaje', 'La hora de inicio debe ser menor que la hora de fin.')
                ->with('icono', 'error')
                ->with('showBtn', 'false')
                ->with('timer', '4000');
        }

        // Mapeo de días a números (0 = domingo, 1 = lunes, etc.)
        $diasNumero = [
            'domingo' => 0,
            'lunes' => 1,
            'martes' => 2,
            'miercoles' => 3,
            'jueves' => 4,
            'viernes' => 5,
            'sabado' => 6,
        ];

        $fechaInicio = new \DateTime($request->fecha_inicio);
        $fechaFin = new \DateTime($request->fecha_fin);
        
        $rangoMinutos = (int)$request->rango;

        $eventosCreados = 0;
        $agendasCreadas = 0;

        // Iterar por cada día en el rango de fechas
        for ($fecha = clone $fechaInicio; $fecha <= $fechaFin; $fecha->modify('+1 day')) {
            $diaSemanaNum = (int)$fecha->format('w'); // 0 = domingo, 1 = lunes, etc.
            $diaSemanaTexto = array_search($diaSemanaNum, $diasNumero);

            // Verificar si este día está seleccionado
            if (in_array($diaSemanaTexto, $diasSeleccionados)) {
                $eventosDelDia = 0; // Contador para eventos creados en este día
                
                // Generar horarios para este día usando strings de tiempo
                $horaActual = $horaInicioStr;
                
                while (strtotime($horaActual) < strtotime($horaFinStr)) {
                    // Calcular hora fin del turno
                    $timestampHoraFin = strtotime($horaActual) + ($rangoMinutos * 60);
                    $horaFinTurno = date('H:i', $timestampHoraFin);
                    
                    // Verificar que no se pase de la hora fin
                    if (strtotime($horaFinTurno) <= strtotime($horaFinStr)) {
                        // Verificar que no existe ya un evento en este horario
                        $existeEvento = Event::where('medico_id', $request->medico_id)
                            ->where('consultorio_id', $request->consultorio_id)
                            ->where('practica_id', $request->practica_id)
                            ->whereDate('start', $fecha->format('Y-m-d'))
                            ->whereTime('start', $horaActual . ':00')
                            ->exists();

                        if (!$existeEvento) {
                            $evento = new Event();
                            $evento->title = '- Horario disponible';
                            $evento->description = '';
                            $evento->color = '#08e408c7';
                            $evento->start = $fecha->format('Y-m-d') . ' ' . $horaActual . ':00';
                            $evento->end = $fecha->format('Y-m-d') . ' ' . $horaFinTurno . ':00';
                            $evento->user_id = Auth::user()->id;
                            $evento->obra_social_id = 1; // Valor por defecto
                            $evento->paciente_id = 1; // Valor por defecto
                            $evento->medico_id = $request->medico_id;
                            $evento->consultorio_id = $request->consultorio_id;
                            $evento->practica_id = $request->practica_id;
                            $evento->save();
                            
                            $eventosCreados++;
                            $eventosDelDia++;
                        }
                    }
                    
                    // Avanzar al siguiente turno
                    $timestampSiguiente = strtotime($horaActual) + ($rangoMinutos * 60);
                    $horaActual = date('H:i', $timestampSiguiente);
                }
                
                // Si se crearon eventos para este día, crear o actualizar registro en agenda
                if ($eventosDelDia > 0) {
                    $existeAgenda = Agenda::where('fecha', $fecha->format('Y-m-d'))
                        ->where('medico_id', $request->medico_id)
                        ->where('consultorio_id', $request->consultorio_id)
                        ->where('practica_id', $request->practica_id)
                        ->first();
                        
                    if (!$existeAgenda) {
                        Agenda::create([
                            'fecha' => $fecha->format('Y-m-d'),
                            'medico_id' => $request->medico_id,
                            'practica_id' => $request->practica_id,
                            'consultorio_id' => $request->consultorio_id,
                            'hora_inicio' => $horaInicioStr,
                            'hora_fin' => $horaFinStr
                        ]);
                        $agendasCreadas++;
                    }
                }
            }
        }

        return redirect()->route('admin.eventos.generar')
            ->with('mensaje', "Se crearon {$eventosCreados} horarios disponibles y {$agendasCreadas} registros de agenda exitosamente.")
            ->with('icono', 'success')
            ->with('showBtn', 'false')
            ->with('timer', '4000')
            ->with('actualizar_calendario', true);
    }

    /**
     * Reservar un turno individual (desde el modal)
     */
    private function reservarTurno(Request $request)
    {
        // Validar los datos de la reserva
        $request->validate([
            'evento_id' => 'required|exists:events,id',
            'fecha_turno' => 'required|date',
            'horario' => 'required',
            'tipo' => 'required|string',
            'documento' => 'required|string',
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'required|string|max:255',
            'obra_social' => 'required|string|max:255',
        ]);

        try {
            // Buscar el evento (horario disponible)
            $evento = Event::findOrFail($request->evento_id);
            Log::info('Evento encontrado', ['evento_id' => $evento->id, 'title' => $evento->title]);

            // Verificar que el evento esté disponible
            if ($evento->title !== '- Horario disponible') {
                Log::warning('Evento no disponible', ['title' => $evento->title]);
                return redirect()->route('admin.index')
                    ->with('mensaje', 'Este horario ya no está disponible.')
                    ->with('icono', 'error')
                    ->with('showBtn', 'true')
                    ->with('timer', '6000');
            }

            // Tomar el id directamente del select
            $obraSocialId = is_numeric($request->obra_social) ? (int)$request->obra_social : 1;
            $obraSocial = Obrasocial::find($obraSocialId);
            $presentar = $obraSocial ? $obraSocial->documentacion : '';

            // Buscar o crear el paciente
            $paciente = \App\Models\Paciente::where('num_documento', $request->documento)->first();
            
            if (!$paciente) {
                // Crear nuevo paciente
                $paciente = new Paciente();
                $paciente->apel_nombres = strtoupper($request->nombre);
                $paciente->tipo_documento = $request->tipo;
                $paciente->num_documento = $request->documento;
                $paciente->telefono = $request->telefono;
                $paciente->email = $request->email;
                $paciente->sexo = 'M';
                $paciente->nacimiento = '1900-01-01';
                $paciente->domicilio = 'No especificado';
                $paciente->cod_postal_id = 1;
                $paciente->obra_social_id = $obraSocialId;
                $paciente->observacion = 'Paciente creado desde reserva de turno';
                $paciente->save();
            } else {
                // Actualizar datos siempre con lo ingresado en el modal
                $paciente->email = $request->email;
                $paciente->telefono = $request->telefono;
                $paciente->obra_social_id = $obraSocialId;
                $paciente->save();
            }

            // Actualizar el evento con los datos de la reserva
            $evento->title = '- Reservado';
            $evento->description = "Paciente: {$request->nombre}\nDocumento: {$request->documento}\nTeléfono: {$request->telefono}\nEmail: {$request->email}\nObra Social: " . ($obraSocial && $obraSocial->nombre ? $obraSocial->nombre : '');
            $evento->color = '#dc3545'; // Color rojo para reservado
            $evento->paciente_id = $paciente->id;
            $evento->obra_social_id = $obraSocialId;
            $email = $request->email;

            $evento->save();

            // Enviar email con los datos del turno
            Mail::send([], [], function ($message) use ($email, $request, $presentar, $evento, $obraSocial) {
                $appUrl = preg_replace('/^https?:\/\//', '', env('APP_URL'));
                $message->to($email)
                    ->subject('Turno reservado - NO CONTESTAR ESTE MENSAJE')
                    ->html(
                        '<p>Su turno ha sido reservado.</p><br>' .
                        '<p><b>Fecha:</b> ' . date('d/m/Y', strtotime($evento->start)) . '</p>' .
                        '<p><b>Hora:</b> ' . date('H:i', strtotime($evento->start)) . '</p>' .
                        '<p><b>Práctica:</b> ' . ($evento->practica ? $evento->practica->nombre : '') . '</p>' .
                        '<p><b>Médico:</b> ' . ($evento->medico ? $evento->medico->apel_nombres : '') . '</p>' .
                        '<p><b>Paciente:</b> ' . $request->nombre . '</p>' .
                        '<p><b>Documento:</b> ' . $request->documento . '</p>' .
                        '<p><b>Teléfono:</b> ' . $request->telefono . '</p>' .
                        '<p><b>Email:</b> ' . $request->email . '</p>' .
                        '<p><b>Obra Social:</b> ' . ($obraSocial ? $obraSocial->nombre : '') . '</p>' .
                        '<p><b>Documentación requerida:</b> ' . $presentar . '</p>' .
                        '<p>Link de la aplicación: <a href="https://' . $appUrl . '">' . $appUrl . '</a></p>'
                    );
            });

            // Generar PDF con los mismos datos del turno
            $appUrl = preg_replace('/^https?:\/\//', '', env('APP_URL'));
            
            // Obtener el logo en base64
            $logoPath = public_path('assets/img/LogoCompletoChico.jpg');
            $logoBase64 = '';
            if (file_exists($logoPath)) {
                $logoData = file_get_contents($logoPath);
                $logoBase64 = 'data:image/jpeg;base64,' . base64_encode($logoData);
            }
            
            $htmlContent = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <title>Comprobante de Turno</title>
                <style>
                    body { font-family: Arial, sans-serif; font-size: 12px; line-height: 1.4; }
                    .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
                    .logo { margin-bottom: 10px; }
                    .logo img { max-width: 150px; height: auto; }
                    .title { font-size: 18px; font-weight: bold; margin-bottom: 5px; }
                    .subtitle { font-size: 14px; color: #666; }
                    .content { margin: 20px 0; }
                    .data-row { margin: 8px 0; border-bottom: 1px dotted #ccc; padding-bottom: 5px; }
                    .label { font-weight: bold; color: #333; }
                    .value { margin-left: 10px; }
                    .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #666; border-top: 1px solid #ccc; padding-top: 10px; }
                    .important { background-color: #fff2cc; padding: 10px; border-left: 4px solid #ffc107; margin: 15px 0; }
                </style>
            </head>
            <body>
                <div class="header">
                    ' . ($logoBase64 ? '<div class="logo"><img src="' . $logoBase64 . '" alt="Logo Centro"></div>' : '') . '
                    <div class="title">COMPROBANTE DE TURNO RESERVADO</div>
                    <div class="subtitle">Centro de Cardiología Infantil Santa Fe</div>
                </div>
                
                <div class="content">
                    <div class="data-row">
                        <span class="label">Fecha del Turno:</span>
                        <span class="value">' . date('d/m/Y', strtotime($evento->start)) . '</span>
                    </div>
                    <div class="data-row">
                        <span class="label">Hora:</span>
                        <span class="value">' . date('H:i', strtotime($evento->start)) . '</span>
                    </div>
                    <div class="data-row">
                        <span class="label">Práctica:</span>
                        <span class="value">' . ($evento->practica ? $evento->practica->nombre : '') . '</span>
                    </div>
                    <div class="data-row">
                        <span class="label">Médico:</span>
                        <span class="value">' . ($evento->medico ? $evento->medico->apel_nombres : '') . '</span>
                    </div>
                    <div class="data-row">
                        <span class="label">Paciente:</span>
                        <span class="value">' . $request->nombre . '</span>
                    </div>
                    <div class="data-row">
                        <span class="label">Documento:</span>
                        <span class="value">' . $request->documento . '</span>
                    </div>
                    <div class="data-row">
                        <span class="label">Teléfono:</span>
                        <span class="value">' . $request->telefono . '</span>
                    </div>
                    <div class="data-row">
                        <span class="label">Email:</span>
                        <span class="value">' . $request->email . '</span>
                    </div>
                    <div class="data-row">
                        <span class="label">Obra Social:</span>
                        <span class="value">' . ($obraSocial ? $obraSocial->nombre : '') . '</span>
                    </div>
                    
                    <div class="important">
                        <div class="label">Documentación requerida:</div>
                        <div class="value">' . $presentar . '</div>
                    </div>
                </div>
                
                <div class="footer">
                    <p>Comprobante generado el ' . date('d/m/Y H:i') . '</p>
                    <p>Centro de Cardiología Infantil Santa Fe - Catamarca 3373, Santa Fe</p>
                    <p>Web: https://' . $appUrl . ' | Tel: (0342) 4565514</p>
                    <p><strong>Conserve este comprobante hasta el día de su turno</strong></p>
                </div>
            </body>
            </html>';

            // Generar el PDF
            $pdf = Pdf::loadHTML($htmlContent);
            $nombreArchivo = 'turno_' . date('Ymd_His') . '_' . str_replace(' ', '_', $request->nombre) . '.pdf';
            
            // Configurar ruta de almacenamiento público
            $directorioTurnos = public_path('storage/turnos');
            $pdfPath = $directorioTurnos . '/' . $nombreArchivo;
            
            // Crear directorio si no existe
            if (!file_exists($directorioTurnos)) {
                mkdir($directorioTurnos, 0755, true);
            }
            
            $pdf->save($pdfPath);

            return redirect()->route('admin.index')
                // ->with('mensaje', 'Turno reservado exitosamente para ' . $request->nombre . '\n\nLE LLEGARÁ UN CORREO A SU CASILLA CON LOS DATOS DEL TURNO.')
                ->with('mensaje', 'Turno reservado exitosamente.')
                ->with('icono', 'success')
                ->with('showBtn', 'true')
                ->with('timer', '100000')
                ->with('pdf_path', 'storage/turnos/' . $nombreArchivo);
        } catch (\Exception $e) {
            return redirect()->route('admin.index')
                ->with('mensaje', 'Error al reservar el turno: ' . $e->getMessage())
                ->with('icono', 'error')
                ->with('showBtn', 'true')
                ->with('timer', '6000');
           }
    }

    public function limpiarHorariosDisponibles(Request $request)
    {
        $request->validate([
            'medico_id' => 'required|exists:medicos,id',
            'consultorio_id' => 'required|exists:consultorios,id',
            'practica_id' => 'required|exists:practicas,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        // Eliminar eventos (el event listener del modelo se encarga automáticamente de agenda)
        $eventosEliminados = Event::where('medico_id', $request->medico_id)
            ->where('consultorio_id', $request->consultorio_id)
            ->where('practica_id', $request->practica_id)
            ->where('title', '- Horario disponible')
            ->whereBetween('start', [$request->fecha_inicio . ' 00:00:00', $request->fecha_fin . ' 23:59:59'])
            ->delete();

        Log::info('Limpieza masiva de horarios', [
            'eventos_eliminados' => $eventosEliminados,
            'criterios' => [
                'medico_id' => $request->medico_id,
                'consultorio_id' => $request->consultorio_id,
                'practica_id' => $request->practica_id,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin
            ]
        ]);

        // Eliminar registros de agenda correspondientes a los criterios del formulario
        $agendaEliminada = 0;
        for ($fecha = $request->fecha_inicio; $fecha <= $request->fecha_fin; $fecha = date('Y-m-d', strtotime($fecha . ' +1 day'))) {
            $agendaResponse = Agenda::where('fecha', $fecha)
                ->where('medico_id', $request->medico_id)
                ->where('practica_id', $request->practica_id)
                ->where('consultorio_id', $request->consultorio_id)
                ->delete();
            
            $agendaEliminada += $agendaResponse;
        }

        Log::info('Limpieza de agenda por criterios del formulario', [
            'agenda_eliminada' => $agendaEliminada,
            'criterios' => [
                'medico_id' => $request->medico_id,
                'consultorio_id' => $request->consultorio_id,
                'practica_id' => $request->practica_id,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin
            ]
        ]);

        $mensajeCompleto = "Se eliminaron {$eventosEliminados} horarios disponibles";
        if ($agendaEliminada > 0) {
            $mensajeCompleto .= " y {$agendaEliminada} registros de agenda";
        }

        return redirect()->back()
            ->with('mensaje', $mensajeCompleto . ".")
            ->with('icono', 'success')
            ->with('showBtn', 'true')
            ->with('timer', '6000');
    }

    public function show($id)
    {
        $evento = Event::with(['user', 'consultorio', 'medico', 'practica'])->findOrFail($id);
        
        // Si es una request AJAX, devolver JSON
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'evento' => [
                    'id' => $evento->id,
                    'title' => $evento->title,
                    'description' => $evento->description,
                    'start' => $evento->start,
                    'end' => $evento->end,
                    'color' => $evento->color,
                    'consultorio' => $evento->consultorio ? $evento->consultorio->nombre : '',
                    'medico' => $evento->medico ? $evento->medico->nombres . ' ' . $evento->medico->apellidos : '',
                    'practica' => $evento->practica ? $evento->practica->nombre : '',
                    'user' => $evento->user ? $evento->user->name : ''
                ]
            ]);
        }
        
        return view('admin.eventos.show', compact('evento'));
    }

    public function edit($id)
    {
        $evento = Event::findOrFail($id);
        return view('admin.eventos.edit', compact('evento'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'nullable|date|after_or_equal:start',
            'description' => 'nullable|string',
            'color' => 'nullable|string'
        ]);

        $evento = Event::findOrFail($id);
        
        $evento->title = $request->title;
        $evento->description = $request->description;
        $evento->start = $request->start;
        $evento->end = $request->end;
        $evento->color = $request->color ?? $evento->color;
        
        $evento->save();

        // Si es una request AJAX, devolver JSON
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Evento actualizado correctamente',
                'evento' => $evento
            ]);
        }

        // Si es una request web, redirigir con mensaje
        return redirect()->route('admin.eventos.index')->with('success', 'Evento actualizado correctamente');
    }

    public function destroy(Request $request, Event $event)
    {
        try {
            // Log para debugging
            Log::info('Intentando eliminar evento', ['event_id' => $event->id]);
            
            // Verificar que el evento existe
            if (!$event || !$event->exists) {
                Log::warning('Evento no encontrado', ['event_id' => $event->id ?? 'null']);
                
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Evento no encontrado'
                    ], 404);
                }
                
                return redirect()->route('admin.eventos.index')->with('error', 'Evento no encontrado');
            }

            // Eliminar el evento (el event listener del modelo se encargará de eliminar agenda automáticamente)
            $deleted = $event->delete();
            
            if ($deleted) {
                Log::info('Evento eliminado exitosamente', ['event_id' => $event->id]);
                
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Evento eliminado correctamente'
                    ]);
                }
                
                return redirect()->route('admin.eventos.index')->with('success', 'Evento eliminado correctamente');
            } else {
                Log::error('Error al eliminar evento - delete() retornó false', ['event_id' => $event->id]);
                
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Error al eliminar el evento'
                    ], 500);
                }
                
                return redirect()->route('admin.eventos.index')->with('error', 'Error al eliminar el evento');
            }
            
        } catch (\Exception $e) {
            Log::error('Excepción al eliminar evento', [
                'event_id' => $event->id ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar el evento: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('admin.eventos.index')->with('error', 'Error al eliminar el evento: ' . $e->getMessage());
        }
    }

    public function confirmDelete($id)
    {
        $evento = Event::findOrFail($id);
        
        // Verificar si hay registros de agenda correspondientes
        $fechaEvento = date('Y-m-d', strtotime($evento->start));
        $agendaCoincidentes = Agenda::where('fecha', $fechaEvento)
            ->where('medico_id', $evento->medico_id)
            ->where('practica_id', $evento->practica_id)
            ->where('consultorio_id', $evento->consultorio_id)
            ->get();
        
        Log::info('Confirmación de eliminación - Verificando agenda', [
            'event_id' => $evento->id,
            'agenda_coincidentes' => $agendaCoincidentes->count(),
            'criterios' => [
                'fecha' => $fechaEvento,
                'medico_id' => $evento->medico_id,
                'practica_id' => $evento->practica_id,  
                'consultorio_id' => $evento->consultorio_id,
            ]
        ]);
        
        return view('admin.eventos.confirm-delete', compact('evento', 'agendaCoincidentes'));
    }

    public function verificarEventosConAgenda()
    {
        // Obtener todos los registros de agenda
        $agendaRecords = Agenda::all();
        $eventosConAgenda = [];
        
        foreach ($agendaRecords as $agenda) {
            $fechaStr = $agenda->fecha->format('Y-m-d');
            
            $eventos = Event::whereDate('start', $fechaStr)
                ->where('medico_id', $agenda->medico_id)
                ->where('practica_id', $agenda->practica_id)
                ->where('consultorio_id', $agenda->consultorio_id)
                ->get();
            
            if ($eventos->count() > 0) {
                $eventosConAgenda[] = [
                    'agenda' => $agenda,
                    'eventos' => $eventos,
                    'fecha' => $fechaStr
                ];
            }
        }
        
        Log::info('Verificación de eventos con agenda', [
            'total_agenda_records' => $agendaRecords->count(),
            'eventos_con_agenda_coincidente' => count($eventosConAgenda)
        ]);
        
        return response()->json([
            'agenda_records' => $agendaRecords->count(),
            'eventos_con_agenda' => $eventosConAgenda,
            'message' => 'Solo los eventos que coincidan exactamente con fecha, médico, práctica y consultorio eliminarán agenda'
        ]);
    }

    public function cambiarEstado(Request $request, $id)
    {
        $request->validate([
            'nuevo_estado' => 'required|string|in:- En Espera,- Atendido,- Horario disponible',
            'motivo_suspension' => 'nullable|string|max:500'
        ]);

        try {
            $evento = Event::findOrFail($id);
            
            // Verificar que el cambio de estado sea válido
            $estadosValidos = ['- En Espera', '- Atendido', '- Horario disponible'];
            if (!in_array($request->nuevo_estado, $estadosValidos)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Estado no válido'
                ], 400);
            }

            // Cambiar el estado
            $estado_anterior = $evento->title;
            $evento->title = $request->nuevo_estado;
            
            if ($request->nuevo_estado === '- Horario disponible') {
                // Si había un paciente asignado y se está suspendiendo el turno, enviar email
                if ($estado_anterior !== '- Horario disponible' && $evento->paciente_id > 1) {
                    try {
                        // Cargar las relaciones necesarias antes de resetear los datos
                        $evento->load(['paciente', 'medico', 'practica', 'consultorio']);
                        
                        // Enviar email de suspensión solo si el paciente tiene email
                        if ($evento->paciente && $evento->paciente->email) {
                            $motivo = $request->input('motivo_suspension', 'Suspensión por parte del paciente.');
                            Mail::to($evento->paciente->email)->send(new SuspensionEvento($evento, $motivo));
                            
                            Log::info('Email de suspensión enviado', [
                                'event_id' => $evento->id,
                                'paciente_email' => $evento->paciente->email,
                                'paciente_nombre' => $evento->paciente->apel_nombres
                            ]);
                        }
                    } catch (\Exception $e) {
                        Log::error('Error al enviar email de suspensión', [
                            'event_id' => $evento->id,
                            'error' => $e->getMessage()
                        ]);
                        // No fallar la operación si falla el envío del email
                    }
                }
                
                $evento->color = '#08e408c7'; // Verde
                $evento->paciente_id = 1; // Resetear paciente
                $evento->obra_social_id = 1; // Resetear obra social
                $evento->description = 'CANCELADO';
            } elseif ($request->nuevo_estado === '- En Espera') {
                $evento->color = '#ffc107'; // Amarillo
            } elseif ($request->nuevo_estado === '- Atendido') {
                $evento->color = '#007bff'; // Azul
            }
            $evento->save();

            Log::info('Estado de evento cambiado', [
                'event_id' => $evento->id,
                'estado_anterior' => $evento->getOriginal('title'),
                'estado_nuevo' => $request->nuevo_estado,
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Estado cambiado correctamente',
                'nuevo_estado' => $request->nuevo_estado
            ]);

        } catch (\Exception $e) {
            Log::error('Error al cambiar estado del evento', [
                'event_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar el estado: ' . $e->getMessage()
            ], 500);
        }
    }

    public function pdf(Request $request)
    {
        // Construir query con relaciones
        $query = Event::with(['user', 'consultorio', 'practica', 'medico']);
        
        // Obtener filtros del request
        $filtros = [];
        
        // Filtro por consultorio
        if ($request->filled('consultorio_id')) {
            $consultorio = Consultorio::find($request->consultorio_id);
            if ($consultorio) {
                $query->where('consultorio_id', $request->consultorio_id);
                $filtros['consultorio'] = $consultorio->nombre;
            }
        }
        
        // Filtro por médico
        if ($request->filled('medico_id')) {
            $medico = Medico::find($request->medico_id);
            if ($medico) {
                $query->where('medico_id', $request->medico_id);
                $filtros['medico'] = $medico->apel_nombres;
            }
        }
        
        // Filtro por fecha desde
        if ($request->filled('fecha_desde')) {
            $query->whereDate('start', '>=', $request->fecha_desde);
            $filtros['fecha_desde'] = $request->fecha_desde;
        }
        
        // Filtro por fecha hasta
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('start', '<=', $request->fecha_hasta);
            $filtros['fecha_hasta'] = $request->fecha_hasta;
        }
        
        // Filtro por estado
        if ($request->filled('estado')) {
            if ($request->estado === '- Horario disponible') {
                $query->whereNotIn('title', ['- Reservado', '- En Espera', '- Atendido']);
            } else {
                $query->where('title', $request->estado);
            }
            $filtros['estado'] = $request->estado;
        }
        
        // Obtener los eventos filtrados
        $eventos = $query->orderBy('start', 'asc')->get();
        
        // Datos adicionales para el PDF
        $fecha_generacion = now()->format('d/m/Y H:i');
        $usuario = Auth::user()->email;
        
        // Generar el PDF
        $pdf = Pdf::loadView('admin.eventos.pdf', compact('eventos', 'filtros', 'fecha_generacion', 'usuario'));
        
        // Configurar el PDF
        $pdf->setPaper('A4', 'landscape');
        
        // Generar nombre del archivo
        $filename = 'reporte_eventos_' . date('Y-m-d_H-i-s') . '.pdf';
        
        //return $pdf->download($filename);
        return $pdf->stream($filename);
    }

    public function buscarReservado(Request $request)
    {
        $documento = $request->input('documento');
        $practicaIdBusqueda = $request->input('id_practica');
        Log::info('Request completo:', $request->all());
        Log::info('Valor de id_practica recibido:', ['id_practica' => $practicaIdBusqueda]);
        $paciente = \App\Models\Paciente::where('num_documento', $documento)->first();
        if (!$paciente) {
            return response()->json(['encontrado' => false]);
        }
        $evento = \App\Models\Event::where('paciente_id', $paciente->id)
            ->where('title', '- Reservado')
            ->where('practica_id', $practicaIdBusqueda)
            ->orderBy('start', 'desc')
            ->first();
        if ($evento) {
            return response()->json([
                'encontrado' => true,
                'evento' => [
                    'id' => $evento->id,
                    'fecha' => date('Y-m-d', strtotime($evento->start)),
                    'hora' => date('H:i', strtotime($evento->start)),
                    'practica_id' => $evento->practica_id,
                    'obra_social_id' => $evento->obra_social_id,
                ]
            ]);
        }
        return response()->json(['encontrado' => false]);
    }

    // Método temporal para probar email de suspensión
    public function probarEmailSuspension($id)
    {
        try {
            $evento = Event::with(['paciente', 'medico', 'practica', 'consultorio'])->findOrFail($id);
            
            if ($evento->paciente && $evento->paciente->email) {
                Mail::to($evento->paciente->email)->send(new SuspensionEvento($evento, 'Prueba de email de suspensión'));
                return response()->json(['success' => true, 'message' => 'Email enviado correctamente']);
            }
            
            return response()->json(['success' => false, 'message' => 'El paciente no tiene email']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Obtener datos de la agenda para el calendario
     */
    public function obtenerAgenda()
    {
        try {
            $agendas = Agenda::with(['medico', 'practica', 'consultorio'])
                ->whereDate('fecha', '>=', now()->format('Y-m-d'))
                ->orderBy('fecha', 'asc')
                ->get();

            $eventos = [];
            foreach ($agendas as $agenda) {
                // Asignar color según el médico
                $colores = [
                    1 => '#87CEEB', // Celeste
                    2 => '#FFD700', // Amarillo  
                    3 => '#FFB6C1', // Rosado
                    4 => '#FFA500'  // Naranja
                ];
                $colorMedico = isset($colores[$agenda->medico_id]) ? $colores[$agenda->medico_id] : '#17a2b8';
                
                $eventos[] = [
                    'id' => 'agenda_' . $agenda->id,
                    'title' => ($agenda->medico ? $agenda->medico->apel_nombres : 'Médico no encontrado'),
                    'extendedProps' => [
                        'medico' => $agenda->medico ? $agenda->medico->apel_nombres : 'Médico no encontrado',
                        'practica' => $agenda->practica ? $agenda->practica->nombre : 'Práctica no encontrada',
                        'consultorio' => $agenda->consultorio ? $agenda->consultorio->nombre : 'No especificado',
                        'horario' => $agenda->hora_inicio . ' - ' . $agenda->hora_fin
                    ],
                    'start' => $agenda->fecha->format('Y-m-d') . 'T' . $agenda->hora_inicio,
                    'end' => $agenda->fecha->format('Y-m-d') . 'T' . $agenda->hora_fin,
                    'color' => $colorMedico,
                    'allDay' => false
                ];
            }
            
            return response()->json($eventos);
        } catch (\Exception $e) {
            \Log::error('Error al obtener agenda: ' . $e->getMessage());
            return response()->json(['error' => 'Error al obtener datos de la agenda'], 500);
        }
    }

}
