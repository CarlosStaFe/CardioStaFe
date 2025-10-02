<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Obrasocial;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PacienteController extends Controller
{
    public function index()
    {
        $pacientes = Paciente::with('localidad')->get();
        return view('admin.pacientes.index', compact('pacientes'));
    }

    public function create()
    {
        $obrasociales = Obrasocial::all();
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
        $paciente = Paciente::with(['localidad', 'obraSocial'])->findOrFail($id);
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

    public function buscarPorDocumento(Request $request)
    {
        try {
            $documento = $request->get('documento');
            $tipo = $request->get('tipo', 'DNI');
            
            // Validar que el documento no esté vacío
            if (empty($documento)) {
                return response()->json([
                    'encontrado' => false,
                    'message' => 'Documento requerido'
                ]);
            }

            // Limpiar el documento de espacios, puntos y guiones
            $documentoLimpio = preg_replace('/[.\-\s]/', '', trim($documento));
            
            Log::info('Buscando paciente', [
                'documento_original' => $documento,
                'documento_limpio' => $documentoLimpio,
                'tipo' => $tipo
            ]);

            // Buscar paciente con múltiples criterios de búsqueda
            $paciente = Paciente::with('obraSocial')
                ->where(function($query) use ($documentoLimpio, $documento) {
                    // Buscar por documento limpio o documento original
                    $query->where('num_documento', $documentoLimpio)
                          ->orWhere('num_documento', $documento);
                })
                ->where('tipo_documento', $tipo)
                ->first();

            // Si no encuentra con el tipo específico, buscar sin tipo
            if (!$paciente) {
                $paciente = Paciente::with('obraSocial')
                    ->where(function($query) use ($documentoLimpio, $documento) {
                        $query->where('num_documento', $documentoLimpio)
                              ->orWhere('num_documento', $documento);
                    })
                    ->first();
                    
                Log::info('Búsqueda sin tipo específico', [
                    'encontrado' => $paciente ? 'sí' : 'no'
                ]);
            }

            if ($paciente) {
                // Determinar el nombre de la obra social
                $obraSocialNombre = 'Sin obra social';
                if ($paciente->obraSocial) {
                    $obraSocialNombre = $paciente->obraSocial->nombre;
                } elseif ($paciente->obra_social_id) {
                    // Si hay obra_social_id pero no se carga la relación, buscar directamente
                    $obraSocial = \App\Models\Obrasocial::find($paciente->obra_social_id);
                    $obraSocialNombre = $obraSocial ? $obraSocial->nombre : 'Sin obra social';
                }

                Log::info('Paciente encontrado', [
                    'id' => $paciente->id,
                    'documento' => $paciente->num_documento,
                    'tipo' => $paciente->tipo_documento
                ]);

                return response()->json([
                    'encontrado' => true,
                    'paciente' => [
                        'id' => $paciente->id,
                        'apel_nombres' => $paciente->apel_nombres,
                        'tipo_documento' => $paciente->tipo_documento,
                        'num_documento' => $paciente->num_documento,
                        'obra_social' => $obraSocialNombre,
                        'telefono' => $paciente->telefono ?? '',
                        'email' => $paciente->email ?? '',
                    ]
                ]);
            } else {
                Log::info('Paciente no encontrado', [
                    'documento_buscado' => $documentoLimpio,
                    'tipo_buscado' => $tipo
                ]);
                
                return response()->json([
                    'encontrado' => false,
                    'message' => 'Paciente no encontrado con documento: ' . $documento
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error al buscar paciente por documento: ' . $e->getMessage());
            return response()->json([
                'encontrado' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }
}
