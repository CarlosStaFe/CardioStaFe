<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MedicoController extends Controller
{
    public function index()
    {
        $medicos = Medico::with('user')->get();
        return view('admin.medicos.index', compact('medicos'));
    }

    public function create()
    {
        return view('admin.medicos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'apel_nombres' => 'required|string|max:255',
            'matricula' => 'string|max:255',
            'telefono' => 'required|string|max:255',
            'especialidad' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:medicos',
            'activo' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $usuario = new User();
        $usuario->name = $request->apel_nombres;
        $usuario->email = $request->email;
        $usuario->password = bcrypt($request->password);
        $usuario->save();

        $medico = new Medico();
        $medico->user_id = $usuario->id;
        $medico->apel_nombres = strtoupper($request->apel_nombres);
        $medico->matricula = $request->matricula;
        $medico->telefono = $request->telefono;
        $medico->especialidad = $request->especialidad;
        $medico->email = $request->email;
        $medico->activo = $request->activo;
        $medico->save();

        return redirect()->route('admin.medicos.index')
            ->with('mensaje', 'Médico creado con éxito.')
            ->with('icono', 'success');
    }

    public function show($id)
    {
        $medico = Medico::with('user')->findOrFail($id);
        return view('admin.medicos.show', compact('medico'));
    }

    public function edit($id)
    {
        $medico = Medico::with('user')->findOrFail($id);
        return view('admin.medicos.edit', compact('medico'));
    }

    public function update(Request $request, $id)
    {
        $medico = Medico::findOrFail($id);
        $usuario = User::findOrFail($medico->user_id);


        $request->validate([
            'apel_nombres' => 'required|string|max:255',
            'matricula' => 'string|max:255',
            'telefono' => 'required|string|max:255',
            'especialidad' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $usuario->id,
            'activo' => 'string|max:255',
            'password' => 'string|min:8|confirmed',
        ]);

        $medico->apel_nombres = strtoupper($request->apel_nombres);
        $medico->matricula = $request->matricula;
        $medico->telefono = $request->telefono;
        $medico->especialidad = $request->especialidad;
        $medico->email = $request->email;
        $medico->activo = $request->activo;
        $medico->save();
        
        $usuario->name = $request->apel_nombres;
        $usuario->email = $request->email;
        if ($request->password) {
            $usuario->password = bcrypt($request->password);
        }
        $usuario->save();

        return redirect()->route('admin.medicos.index')
            ->with('mensaje', 'Médico actualizada con éxito.')
            ->with('icono', 'success');
    }

    public function confirmDelete($id)
    {
        $medico = Medico::with('user')->findOrFail($id);
        return view('admin.medicos.delete', compact('medico'));
    }

    public function destroy($id)
    {
        $medico = Medico::findOrFail($id);
        $usuario = User::findOrFail($medico->user_id);

        if ($usuario) {
            $usuario->delete();
        }

        $medico->delete();

        return redirect()->route('admin.medicos.index')
            ->with('mensaje', 'Medico eliminado con éxito.')
            ->with('icono', 'success');
    }
}
