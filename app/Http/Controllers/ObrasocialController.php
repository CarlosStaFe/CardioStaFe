<?php

namespace App\Http\Controllers;

use App\Models\Obrasocial;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ObrasocialController extends Controller
{
    public function index() //strtoupper($request->apel_nombres);
    {
        $obrasociales = Obrasocial::all();
        return view('admin.obrasociales.index', compact('obrasociales'));
    }

    public function create()
    {
        return view('admin.obrasociales.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'string|max:255',
            'contacto' => 'string|max:255',
            'email' => 'string|max:255',
            'activo' => 'nullable|boolean',
            'documentacion' => 'string|max:255',
            'observacion' => 'string|max:255',
        ]);

        $obrasocial = new Obrasocial();
        $obrasocial->nombre = strtoupper($request->nombre);
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
        return view('admin.obrasociales.edit', compact('obrasocial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Obrasocial $obrasocial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Obrasocial $obrasocial)
    {
        //
    }
}
