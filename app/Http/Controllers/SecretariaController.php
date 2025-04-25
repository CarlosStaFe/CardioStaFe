<?php

namespace App\Http\Controllers;

use App\Models\Secretaria;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SecretariaController extends Controller
{
    public function index()
    {
        $secretarias = Secretaria::with('user')->get();
        return view('admin.secretarias.index', compact('secretarias'));
    }

    public function create()
    {
        return view('admin.secretarias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'apel_nombres' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'domicilio' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $usuario = new User();
        $usuario->name = $request->apel_nombres;
        $usuario->email = $request->email;
        $usuario->password = bcrypt($request->password);
        $usuario->save();

        $secretaria = new Secretaria();
        $secretaria->user_id = $usuario->id;
        $secretaria->apel_nombres = $request->apel_nombres;
        $secretaria->telefono = $request->telefono;
        $secretaria->domicilio = $request->domicilio;
        $secretaria->save();

        return redirect()->route('admin.secretarias.index')
            ->with('mensaje', 'Secretaria creada con éxito.')
            ->with('icono', 'success');
    }

    public function show($id)
    {
        $secretaria = Secretaria::with('user')->findOrFail($id);
        return view('admin.secretarias.show', compact('secretaria'));
    }

    public function edit($id)
    {
        $secretaria = Secretaria::with('user')->findOrFail($id);
        return view('admin.secretarias.edit', compact('secretaria'));
    }

    public function update(Request $request, $id)
    {
        $secretaria = Secretaria::findOrFail($id);
        $usuario = User::findOrFail($secretaria->user_id);


        $request->validate([
            'apel_nombres' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'domicilio' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $usuario->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $secretaria->apel_nombres = $request->apel_nombres;
        $secretaria->telefono = $request->telefono;
        $secretaria->domicilio = $request->domicilio;
        $secretaria->save();
        
        $usuario->name = $request->apel_nombres;
        $usuario->email = $request->email;
        if ($request->password) {
            $usuario->password = bcrypt($request->password);
        }
        $usuario->save();

        return redirect()->route('admin.secretarias.index')
            ->with('mensaje', 'Secretaria actualizada con éxito.')
            ->with('icono', 'success');
    }

    public function confirmDelete($id)
    {
        $secretaria = Secretaria::with('user')->findOrFail($id);
        return view('admin.secretarias.delete', compact('secretaria'));
    }

    public function destroy($id)
    {
        $secretaria = Secretaria::findOrFail($id);
        $usuario = User::findOrFail($secretaria->user_id);

        if ($usuario) {
            $usuario->delete();
        }

        $secretaria->delete();

        return redirect()->route('admin.secretarias.index')
            ->with('mensaje', 'Secretaria eliminada con éxito.')
            ->with('icono', 'success');
    }
}
