<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        //$datos = request()->all();
        //return response()->json($datos)

        //$request->validate([
            //'apel_nombres' => 'required|string|max:255',
        //]);

        //$medico = Medico::find($request->medico_id);
        //$evento->user_id = Auth::user()->id;

        $evento = new Event();
        $evento->title = 'prueba';
        $evento->description = 'descripcion';
        $evento->color = '#08e408c7';
        $evento->start = $request->fecha_turno;
        $evento->end = '2024-06-20 10:30:00';
        $evento->user_id = Auth::user()->id;
        $evento->obra_social_id = 1;
        $evento->paciente_id = 1;
        $evento->medico_id = 1;
        $evento->consultorio_id = 1;
        $evento->practica_id = 1;
        //$evento->color = $request->color ?? '#0000FF';
        //$evento->start = $request->start;
        //$evento->end = $request->end;
        //$evento->user_id = $request->user_id; 
        //$evento->medico_id = $request->medico_id;
        //$evento->consultorio_id = $request->email;
        //$evento->practica_id = $request->obra_social;
        //$evento->num_afiliado = $request->num_afiliado;
        //$evento->observacion = $request->observacion;
        $evento->save();

        return redirect()->route('admin.index')
            ->with('mensaje', 'Se registró la reserva.')
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
        //
    }
}
