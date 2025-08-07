<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\ObraSocial;
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
        $obrasociales = ObraSocial::all();
        return view('admin.pacientes.create', compact('obrasociales'));
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
            'obra_social_id' => 'string|max:255',
            'num_afiliado' => 'string|max:255',
            'observacion' => 'string|max:255',
        ]);

        // dd($request->all());

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
        $paciente->obra_social_id = $request->obra_social;
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
        $paciente = Paciente::with('obrasociales')->findOrFail($id);
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
            'obra_social_id' => 'string|max:255',
            'num_afiliado' => 'string|max:255',
            'observacion' => 'string|max:255',
        ]);

        $paciente->apel_nombres = strtoupper($request->apel_nombres);
        $paciente->nacimiento = $request->nacimiento;
        $paciente->sexo = $request->sexo;
        $paciente->tipo_documento = $request->tipo_documento;
        $paciente->num_documento = $request->num_documento;
        $paciente->domicilio = $request->domicilio;
        $paciente->cod_postal_id = $request->cod_postal;
        $paciente->telefono = $request->telefono;
        $paciente->email = $request->email;
        $paciente->obra_social_id = $request->obra_social;
        $paciente->num_afiliado = $request->num_afiliado;
        $paciente->observacion = $request->observacion;
        $paciente->save();

        return redirect()->route('admin.pacientes.index')
            ->with('mensaje', 'Paciente actualizado con éxito.')
            ->with('icono', 'success');
    }

    public function confirmDelete($id)
    {
        $paciente = Paciente::findOrFail($id);
        return view('admin.pacientes.delete', compact('paciente'));
    }

    public function destroy($id)
    {
        $paciente = Paciente::findOrFail($id);
        
        $paciente->delete();

        return redirect()->route('admin.pacientes.index')
            ->with('mensaje', 'Paciente eliminada con éxito.')
            ->with('icono', 'success');
    }

    /**
     * Buscar paciente por número de documento
     */
    public function buscarPorDocumento($documento)
    {
        try {
            $paciente = Paciente::with('obraSocial')
                ->where('num_documento', $documento)
                ->first();

            if ($paciente) {
                return response()->json([
                    'success' => true,
                    'paciente' => [
                        'id' => $paciente->id,
                        'apel_nombres' => $paciente->apel_nombres,
                        'tipo_documento' => $paciente->tipo_documento,
                        'num_documento' => $paciente->num_documento,
                        'obra_social' => $paciente->obraSocial->nombre ?? $paciente->obra_social ?? 'Sin obra social',
                        'telefono' => $paciente->telefono,
                        'email' => $paciente->email,
                    ]
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Paciente no encontrado'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al buscar paciente: ' . $e->getMessage()
            ], 500);
        }
    }
}
