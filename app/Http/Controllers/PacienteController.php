<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    public function index()
    {
        $pacientes = Paciente::with('localidad')->get();
        return view('admin.pacientes.index', compact('pacientes'));
    }

    public function create()
    {
        return view('admin.pacientes.create');
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
            'plan_os' => 'string|max:255',
            'num_afiliado' => 'string|max:255',
            'observacion' => 'string|max:255',
        ]);

        $paciente = new Paciente();
        $paciente->apel_nombres = strtoupper($request->apel_nombres);
        $paciente->nacimiento = $request->nacimiento;
        $paciente->sexo = $request->sexo;
        $paciente->tipo_documento = $request->tipo_documento;
        $paciente->num_documento = $request->num_documento;
        $paciente->domicilio = $request->domicilio;
        $paciente->cod_postal_id = $request->cod_postal; 
        $paciente->telefono = $request->telefono;
        $paciente->email = $request->email;
        $paciente->obra_social = $request->obra_social;
        $paciente->plan_os = $request->plan_os;
        $paciente->num_afiliado = $request->num_afiliado;
        $paciente->observacion = $request->observacion;
        $paciente->save();

        return redirect()->route('admin.pacientes.index')
            ->with('mensaje', 'Paciente creado con éxito.')
            ->with('icono', 'success');
    }

    public function show($id)
    {
        $paciente = Paciente::with('localidad')->findOrFail($id);
        return view('admin.pacientes.show', compact('paciente'));
    }

    public function edit($id)
    {
        $paciente = Paciente::with('localidad')->findOrFail($id);
        return view('admin.pacientes.edit', compact('paciente'));
    }

    public function update(Request $request, $id)
    {
        $paciente = Paciente::findOrFail($id);

        $request->validate([
            'apel_nombres' => 'required|string|max:255',
            'nacimiento' => 'required|date|max:255',
            'sexo' => 'required|string|max:255',
            'tipo_documento' => 'required|string|max:255',
            'num_documento' => 'required|string|max:255|unique:pacientes,num_documento,' . $paciente->id,
            'domicilio' => 'string|max:255',
            'cod_postal_id' => 'string|max:255',
            'telefono' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'obra_social' => 'string|max:255',
            'plan_os' => 'string|max:255',
            'num_afiliado' => 'string|max:255',
            'observacion' => 'string|max:255',
        ]);

        $paciente->apel_nombres = $request->apel_nombres;
        $paciente->nacimiento = $request->nacimiento;
        $paciente->sexo = $request->sexo;
        $paciente->tipo_documento = $request->tipo_documento;
        $paciente->num_documento = $request->num_documento;
        $paciente->domicilio = $request->domicilio;
        $paciente->cod_postal_id = $request->cod_postal; 
        $paciente->telefono = $request->telefono;
        $paciente->email = $request->email;
        $paciente->obra_social = $request->obra_social;
        $paciente->plan_os = $request->plan_os;
        $paciente->num_afiliado = $request->num_afiliado;
        $paciente->observacion = $request->observacion;
        $paciente->save();

        return redirect()->route('admin.pacientes.index')
            ->with('mensaje', 'Paciente actualizado con éxito.')
            ->with('icono', 'success');
    }

    public function confirmDelete($id)
    {
        $paciente = Paciente::with('localidad')->findOrFail($id);
        return view('admin.pacientes.confirmDelete', compact('paciente'));
    }

    public function destroy($id)
    {
        $paciente = Paciente::findOrFail($id);

        $paciente->delete();

        return redirect()->route('admin.pacientes.index')
            ->with('mensaje', 'Paciente eliminada con éxito.')
            ->with('icono', 'success');
    }
}
