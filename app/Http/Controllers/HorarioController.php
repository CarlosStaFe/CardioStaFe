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
        $horarios = Horario::with('medico', 'consultorio')->get();
        return view('admin.horarios.index', compact('horarios'));
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
            'dia' => 'required|string',
            'fecha' => 'required|date',
            'hora_inicio' => 'required|time',
            'hora_fin' => 'required|time',
            'rango' => 'required|time',
        ]);

        Horario::create($request->all());

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
