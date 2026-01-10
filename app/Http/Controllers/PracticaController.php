<?php

namespace App\Http\Controllers;

use App\Models\Practica;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PracticaController extends Controller
{
    public function index()
    {
        $practicas = Practica::all();
        return view('admin.practicas.index', compact('practicas'));
    }

    public function create()
    {
        return view('admin.practicas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'observacion' => 'string|max:255',
        ]);

        //Practica::create($request->all());

        $practica = new Practica();
        $practica->nombre = strtoupper($request->nombre);
        $practica->observacion = $request->observacion;
        $practica->save();

        return redirect()->route('admin.practicas.index')
        ->with('mensaje', 'Práctica creada con éxito.')
        ->with('icono', 'success')
        ->with('showBtn', 'false')
        ->with('timer', '4000');
    }

    public function show($id)
    {
        $practica = Practica::findOrFail($id);
        return view('admin.practicas.show', compact('practica'));
    }

    public function edit($id)
    {
        $practica = Practica::findOrFail($id);
        return view('admin.practicas.edit', compact('practica'));
    }

    public function update(Request $request, $id)
    {
        $practica = Practica::findOrFail($id);

        $request->validate([
            'nombre' => 'string|max:255',
            'observacion' => 'string|max:255',
        ]);

        //$practica = Practica::findOrFail($id);
        //$practica->update($request->all());

        $practica->nombre = strtoupper($request->nombre);
        $practica->observacion = $request->observacion;
        $practica->save();

        return redirect()->route('admin.practicas.index')
        ->with('mensaje', 'Práctica actualizada con éxito.')
        ->with('icono', 'success')
        ->with('showBtn', 'false')
        ->with('timer', '4000');
    }

    public function confirmDelete($id)
    {
        $practica = Practica::findOrFail($id);
        return view('admin.practicas.delete', compact('practica'));
    }

    public function destroy($id)
    {
        $practica = Practica::findOrFail($id);
        
        $practica->delete();

        return redirect()->route('admin.practicas.index')
            ->with('mensaje', 'Práctica eliminada con éxito.')
            ->with('icono', 'success')
            ->with('showBtn', 'false')
            ->with('timer', '4000');
    }
}
