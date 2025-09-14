<?php

namespace App\Http\Controllers;

use App\Models\Obrasocial;
use App\Models\Practica;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ObrasocialController extends Controller
{
    public function index()
    {
        $obrasociales = Obrasocial::all();
        return view('admin.obrasociales.index', compact('obrasociales'));
    }

    public function create()
    {
        $practicas = Practica::all();
        return view('admin.obrasociales.create', compact('practicas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'activo' => 'nullable|boolean',
            'documentacion' => 'string|max:255',
        ]);

        $obrasocial = new Obrasocial();
        $obrasocial->nombre = strtoupper($request->nombre);
        $obrasocial->practica_id = $request->practica_id;
        $obrasocial->telefono = $request->telefono;
        $obrasocial->contacto = $request->contacto;
        $obrasocial->email = $request->email;
        $obrasocial->activo = $request->has('activo') ? true : false;
        $obrasocial->documentacion = $request->documentacion;
        $obrasocial->observacion = $request->observacion;
        $obrasocial->save();

        return redirect()->route('admin.obrasociales.index')
            ->with('mensaje', 'Obra Social creada con éxito.')
            ->with('icono', 'success');
    }

    public function show($id)
    {
        $obrasocial = Obrasocial::findOrFail($id);
        return view('admin.obrasociales.show', compact('obrasocial'));
    }

    public function edit($id)
    {
        $obrasocial = Obrasocial::findOrFail($id);
        $practicas = Practica::all();
        return view('admin.obrasociales.edit', compact('obrasocial', 'practicas'));
    }

    public function update(Request $request, $id)
    {
        $obrasocial = Obrasocial::findOrFail($id);

        $request->validate([
            'nombre' => 'string|max:255',
        ]);

        $obrasocial->nombre = strtoupper($request->nombre);
        $obrasocial->practica_id = $request->practica_id;
        $obrasocial->telefono = $request->telefono;
        $obrasocial->contacto = $request->contacto;
        $obrasocial->email = $request->email;
        $obrasocial->activo = $request->has('activo') ? true : false;
        $obrasocial->documentacion = $request->documentacion;
        $obrasocial->observacion = $request->observacion;
        $obrasocial->save();

        return redirect()->route('admin.obrasociales.index')
        ->with('mensaje', 'Obra Social actualizada con éxito.')
        ->with('icono', 'success');
    }

        public function confirmDelete($id)
    {
        $obrasocial = Obrasocial::findOrFail($id);
        return view('admin.obrasociales.delete', compact('obrasocial'));
    }

    public function destroy($id)
    {
        $obrasocial = Obrasocial::findOrFail($id);
        
        $obrasocial->delete();

        return redirect()->route('admin.obrasociales.index')
            ->with('mensaje', 'Obra Social eliminada con éxito.')
            ->with('icono', 'success');
    }

    public function porPractica($id)
    {
        $obras_sociales = Obrasocial::where('practica_id', $id)->get();
        return response()->json($obras_sociales);
    }
}
