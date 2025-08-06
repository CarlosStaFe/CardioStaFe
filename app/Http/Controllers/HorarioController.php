<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Medico;
use App\Models\Consultorio;
use App\Models\Practica;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function index()
    {
        $medicos = Medico::all();
        $horarios = Horario::with('medico', 'consultorio', 'practica')->get();
        return view('admin.horarios.index', compact('horarios', 'medicos'));
    }

    public function create()
    {
        $medicos = Medico::all();
        $consultorios = Consultorio::all();
        $practicas = Practica::all();
        return view('admin.horarios.create', compact('medicos', 'consultorios', 'practicas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after_or_equal:hora_inicio',
            'rango' => 'required|date_format:H:i',
            'medico' => 'required',
            'consultorio' => 'required',
            'practica' => 'required',
            //        'lunes' => 'boolean',
            //        'martes' => 'boolean',
            //        'miercoles' => 'boolean',
            //        'jueves' => 'boolean',
            //        'viernes' => 'boolean',
            //        'sabado' => 'boolean',
            //        'domingo' => 'boolean',
        ]);

        // Asegura que los días no marcados se guarden como false
        foreach (['lunes','martes','miercoles','jueves','viernes','sabado','domingo'] as $dia) {
            $request[$dia] = $request->has($dia) ? true : false;
        }

        // Validar superposición de horarios
        $dias = ['lunes','martes','miercoles','jueves','viernes','sabado','domingo'];
        $diasSeleccionados = [];
        foreach ($dias as $dia) {
            if ($request->has($dia)) {
                $diasSeleccionados[] = $dia;
            }
        }

        $existe = \App\Models\Horario::where('medico_id', $request->medico)
            ->where('consultorio_id', $request->consultorio)
            ->where('practica_id', $request->practica)
            ->where(function($query) use ($request) {
                $query->where(function($q) use ($request) {
                    $q->where('fecha_inicio', '<=', $request->fecha_fin)
                      ->where('fecha_fin', '>=', $request->fecha_inicio);
                });
            })
            ->where(function($query) use ($diasSeleccionados) {
                foreach ($diasSeleccionados as $dia) {
                    $query->orWhere($dia, true);
                }
            })
            ->where(function($query) use ($request) {
                $query->where('hora_inicio', '<', $request->hora_fin)
                      ->where('hora_fin', '>', $request->hora_inicio);
            })
            ->exists();

        if ($existe) {
            return redirect()->route('admin.horarios.create')
                ->with('mensaje', 'Ya existe un horario que se superpone o se repite para este médico, consultorio y práctica en ese rango de fechas, horas y días.')
                ->with('icono', 'error');
        }

        $horario = new Horario();
        $horario->fecha_inicio = $request->fecha_inicio;
        $horario->fecha_fin = $request->fecha_fin;
        $horario->hora_inicio = $request->hora_inicio;
        $horario->hora_fin = $request->hora_fin;
        $horario->rango = $request->rango;
        $horario->medico_id = $request->medico;
        $horario->consultorio_id = $request->consultorio;
        $horario->practica_id = $request->practica;
        $horario->lunes = $request->lunes;
        $horario->martes = $request->martes;
        $horario->miercoles = $request->miercoles;
        $horario->jueves = $request->jueves;
        $horario->viernes = $request->viernes;
        $horario->sabado = $request->sabado;
        $horario->domingo = $request->domingo;
        $horario->save();

        // Crear eventos para cada día y fecha del rango
        $fechaInicio = new \DateTime($horario->fecha_inicio);
        $fechaFin = new \DateTime($horario->fecha_fin);
        $diasSemana = [
            'domingo' => 0,
            'lunes' => 1,
            'martes' => 2,
            'miercoles' => 3,
            'jueves' => 4,
            'viernes' => 5,
            'sabado' => 6,
        ];

        for ($fecha = clone $fechaInicio; $fecha <= $fechaFin; $fecha->modify('+1 day')) {
            foreach ($diasSemana as $diaNombre => $diaNumero) {
                if ($horario->$diaNombre && $fecha->format('w') == $diaNumero) {
                    $evento = new \App\Models\Event();
                    $evento->title = 'Práctica - Consultorio';
                    $evento->description = 'Horario para el médico: ' . $horario->medico_id;
                    $evento->color = '#00AA00';
                    $evento->start_date = $fecha->format('Y-m-d');
                    $evento->start_time = $horario->hora_inicio;
                    //$evento->user_id = auth()->id();
                    $evento->obra_social_id = 1;
                    $evento->paciente_id = 1;
                    $evento->medico_id = $horario->medico_id;
                    $evento->consultorio_id = $horario->consultorio_id;
                    $evento->practica_id = $horario->practica_id;
                    //$evento->observacion = 'Generado automáticamente desde HorarioController';
                    $evento->save();
                }
            }
        }
        
        //Horario::create($request->all());

        return redirect()->route('admin.horarios.index')
            ->with('mensaje', 'Horario creado con éxito.')
            ->with('icono', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Horario $horario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Horario $horario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Horario $horario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Horario $horario)
    {
        //
    }
}
