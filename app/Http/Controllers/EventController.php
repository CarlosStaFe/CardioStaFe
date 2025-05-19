<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'apel_nombres' => 'required|string|max:255',
            'nacimiento' => 'required|date|max:255',
            'sexo' => 'required|string|max:255',
            'tipo_documento' => 'required|string|max:255',
            'num_documento' => 'required|string|max:255|unique:pacientes',
            'domicilio' => 'string|max:255',
            'cod_postal_id' => 'string|max:255',
            'telefono' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'obra_social' => 'string|max:255',
            'num_afiliado' => 'string|max:255',
            'observacion' => 'string|max:255',
        ]);

        $evento = new Event();
        $evento->title = strtoupper($request->title);
        $evento->description = $request->nacimiento;
        $evento->start_date = $request->sexo;
        $evento->end_date = $request->tipo_documento;
        $evento->start_time = $request->num_documento;
        $evento->end_time = $request->domicilio;
        $evento->user_id = $request->cod_postal_id ?? null; 
        $evento->medico_id = $request->telefono;
        $evento->consultorio_id = $request->email;
        $evento->practica_id = $request->obra_social;
        $evento->num_afiliado = $request->num_afiliado;
        $evento->observacion = $request->observacion;
        $evento->save();

        return redirect()->route('admin.pacientes.index')
            ->with('mensaje', 'Paciente creado con éxito.')
            ->with('icono', 'success');

    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
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
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}
