<?php

namespace App\Http\Controllers;

use App\Models\Consultorio;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConsultorioController extends Controller
{
    public function index()
    {
        $consultorios = Consultorio::all();
        return view('admin.consultorios.index', compact('consultorios'));
    }

    public function create()
    {
        return view('admin.consultorios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'numero' => 'required|string|max:255',
            'direccion' => 'string|max:255',
            'telefono' => 'string|max:255',
            'especialidad' => 'string|max:255',
            'observacion' => 'string|max:255',
        ]);

        //Consultorio::create($request->all()); //Reemplaza el método siguiente por este
        
        $consultorio = new Consultorio();
        $consultorio->nombre = strtoupper($request->nombre);
        $consultorio->numero = $request->numero;
        $consultorio->direccion = $request->direccion;
        $consultorio->telefono = $request->telefono;
        $consultorio->especialidad = $request->especialidad;
        $consultorio->observacion = $request->observacion;
        $consultorio->save();

        return redirect()->route('admin.consultorios.index')
            ->with('mensaje', 'Consultorio creado con éxito.')
            ->with('icono', 'success')
            ->with('showBtn', 'false')
            ->with('timer', '4000');
    }

    public function show($id)
    {
        $consultorio = Consultorio::findOrFail($id);
        return view('admin.consultorios.show', compact('consultorio'));
    }

    public function edit($id)
    {
        $consultorio = Consultorio::findOrFail($id);
        return view('admin.consultorios.edit', compact('consultorio'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'numero' => 'required|string|max:255',
            'direccion' => 'string|max:255',
            'telefono' => 'string|max:255',
            'especialidad' => 'string|max:255',
            'observacion' => 'string|max:255',
        ]);

        $consultorio = Consultorio::findOrFail($id);
        $consultorio->update($request->all());

        return redirect()->route('admin.consultorios.index')
        ->with('mensaje', 'Consultorio actualizado con éxito.')
        ->with('icono', 'success')
        ->with('showBtn', 'false')
        ->with('timer', '4000');
    }

    public function confirmDelete($id)
    {
        $consultorio = Consultorio::findOrFail($id);
        return view('admin.consultorios.delete', compact('consultorio'));
    }

    public function destroy($id)
    {
        $consultorio = Consultorio::findOrFail($id);
        
        $consultorio->delete();

        return redirect()->route('admin.consultorios.index')
            ->with('mensaje', 'Consultorio eliminado con éxito.')
            ->with('icono', 'success')
            ->with('showBtn', 'false')
            ->with('timer', '4000');
    }
}
