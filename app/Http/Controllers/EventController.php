<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $medicos = \App\Models\Medico::all();
        $consultorios = \App\Models\Consultorio::all();
        $practicas = \App\Models\Practica::all();
        
        return view('admin.eventos.create', compact('medicos', 'consultorios', 'practicas'));
    }

    public function store(Request $request)
    {
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
     * Función auxiliar para limpiar horarios disponibles existentes
     */
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

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $evento = Event::with(['pacientes', 'medicos', 'consultorios', 'practicas'])->findOrFail($id);
        return response()->json($evento);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $evento = Event::findOrFail($id);
        
        $evento->title = $request->title ?? $evento->title;
        $evento->description = $request->description ?? $evento->description;
        $evento->start = $request->fecha_turno ?? $evento->start;
        $evento->end = $request->end ?? $evento->end;
        $evento->color = $request->color ?? $evento->color;
        
        $evento->save();

        return response()->json([
            'success' => true,
            'message' => 'Evento actualizado correctamente',
            'evento' => $evento
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        try {
            // Log para debugging
            Log::info('Intentando eliminar evento', ['event_id' => $event->id]);
            
            // Verificar que el evento existe
            if (!$event || !$event->exists) {
                Log::warning('Evento no encontrado', ['event_id' => $event->id ?? 'null']);
                return response()->json([
                    'success' => false,
                    'message' => 'Evento no encontrado'
                ], 404);
            }

            // Eliminar el evento
            $deleted = $event->delete();
            
            if ($deleted) {
                Log::info('Evento eliminado exitosamente', ['event_id' => $event->id]);
                return response()->json([
                    'success' => true,
                    'message' => 'Evento eliminado correctamente'
                ]);
            } else {
                Log::error('Error al eliminar evento - delete() retornó false', ['event_id' => $event->id]);
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar el evento'
                ], 500);
            }
            
        } catch (\Exception $e) {
            Log::error('Excepción al eliminar evento', [
                'event_id' => $event->id ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el evento: ' . $e->getMessage()
            ], 500);
        }
    }
}
