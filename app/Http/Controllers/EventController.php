<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Consultorio;
use App\Models\Practica;
use App\Models\Medico;
use App\Models\Obrasocial;
use App\Models\Paciente;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class EventController extends Controller
{
    public function index()
    {
        $eventos = Event::with(['user', 'consultorio', 'practica', 'medico'])->get();
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
        // Log para debugging
        Log::info('Método store llamado', [
            'has_evento_id' => $request->has('evento_id'),
            'has_documento' => $request->has('documento'),
            'all_request' => $request->all()
        ]);
        
        // Detectar si es una reserva individual (desde el modal) o creación masiva de horarios
        if ($request->has('evento_id') && $request->has('documento')) {
            // Es una reserva individual desde el modal
            Log::info('Detectado como reserva individual');
            return $this->reservarTurno($request);
        }
        
        Log::info('Detectado como creación masiva');
        
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
                ->with('icono', 'error');
        }

        // Validar que la hora de inicio sea menor que la hora de fin
        if (strtotime($horaInicioStr) >= strtotime($horaFinStr)) {
            return redirect()->back()
                ->withInput()
                ->with('mensaje', 'La hora de inicio debe ser menor que la hora de fin.')
                ->with('icono', 'error');
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

        // Iterar por cada día en el rango de fechas
        for ($fecha = clone $fechaInicio; $fecha <= $fechaFin; $fecha->modify('+1 day')) {
            $diaSemanaNum = (int)$fecha->format('w'); // 0 = domingo, 1 = lunes, etc.
            $diaSemanaTexto = array_search($diaSemanaNum, $diasNumero);

            // Verificar si este día está seleccionado
            if (in_array($diaSemanaTexto, $diasSeleccionados)) {
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
                        }
                    }
                    
                    // Avanzar al siguiente turno
                    $timestampSiguiente = strtotime($horaActual) + ($rangoMinutos * 60);
                    $horaActual = date('H:i', $timestampSiguiente);
                }
            }
        }

        return redirect()->route('admin.index')
            ->with('mensaje', "Se crearon {$eventosCreados} horarios disponibles exitosamente.")
            ->with('icono', 'success');
    }

    /**
     * Reservar un turno individual (desde el modal)
     */
    private function reservarTurno(Request $request)
    {
        Log::info('Iniciando reserva de turno', ['request_data' => $request->all()]);
        
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
                    ->with('icono', 'error');
            }

            // Buscar la obra social por nombre una sola vez
            $obraSocial = Obrasocial::where('nombre', $request->obra_social)->first();
            $obraSocialId = $obraSocial ? $obraSocial->id : 1;
            Log::info('Obra social encontrada', ['obra_social_id' => $obraSocialId]);

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
                Log::info('Nuevo paciente creado', ['paciente_id' => $paciente->id]);
            } else {
                Log::info('Paciente existente encontrado', ['paciente_id' => $paciente->id]);
            }

            // Actualizar el evento con los datos de la reserva
            $evento->title = '- Reservado';
            $evento->description = "Paciente: {$request->nombre}\nDocumento: {$request->documento}\nTeléfono: {$request->telefono}\nEmail: {$request->email}\nObra Social: {$request->obra_social}";
            $evento->color = '#dc3545'; // Color rojo para reservado
            $evento->paciente_id = $paciente->id;
            $evento->obra_social_id = $obraSocialId;
            
            $evento->save();
            
            Log::info('Evento actualizado a reservado', [
                'evento_id' => $evento->id,
                'paciente_id' => $paciente->id,
                'title' => $evento->title
            ]);

            return redirect()->route('admin.index')
                ->with('mensaje', 'Turno reservado exitosamente para ' . $request->nombre)
                ->with('icono', 'success');

        } catch (\Exception $e) {
            Log::error('Error al reservar turno: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return redirect()->route('admin.index')
                ->with('mensaje', 'Error al reservar el turno: ' . $e->getMessage())
                ->with('icono', 'error');
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

        $eventosEliminados = Event::where('medico_id', $request->medico_id)
            ->where('consultorio_id', $request->consultorio_id)
            ->where('practica_id', $request->practica_id)
            ->where('title', '- Horario disponible')
            ->whereBetween('start', [$request->fecha_inicio, $request->fecha_fin . ' 23:59:59'])
            ->delete();

        return redirect()->back()
            ->with('mensaje', "Se eliminaron {$eventosEliminados} horarios disponibles.")
            ->with('icono', 'success');
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
        return redirect()->route('admin.horarios.index')->with('success', 'Evento actualizado correctamente');
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
                
                return redirect()->route('admin.horarios.index')->with('error', 'Evento no encontrado');
            }

            // Eliminar el evento
            $deleted = $event->delete();
            
            if ($deleted) {
                Log::info('Evento eliminado exitosamente', ['event_id' => $event->id]);
                
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Evento eliminado correctamente'
                    ]);
                }
                
                return redirect()->route('admin.horarios.index')->with('success', 'Evento eliminado correctamente');
            } else {
                Log::error('Error al eliminar evento - delete() retornó false', ['event_id' => $event->id]);
                
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Error al eliminar el evento'
                    ], 500);
                }
                
                return redirect()->route('admin.horarios.index')->with('error', 'Error al eliminar el evento');
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
            
            return redirect()->route('admin.horarios.index')->with('error', 'Error al eliminar el evento: ' . $e->getMessage());
        }
    }

    public function confirmDelete($id)
    {
        $evento = Event::findOrFail($id);
        return view('admin.eventos.confirm-delete', compact('evento'));
    }

    public function cambiarEstado(Request $request, $id)
    {
        $request->validate([
            'nuevo_estado' => 'required|string|in:- En Espera,- Atendido'
        ]);

        try {
            $evento = Event::findOrFail($id);
            
            // Verificar que el cambio de estado sea válido
            $estadosValidos = ['- En Espera', '- Atendido'];
            if (!in_array($request->nuevo_estado, $estadosValidos)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Estado no válido'
                ], 400);
            }

            // Cambiar el estado
            $evento->title = $request->nuevo_estado;
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
            if ($request->estado === '- Horario Disponible') {
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
        
        return $pdf->download($filename);
    }
}
