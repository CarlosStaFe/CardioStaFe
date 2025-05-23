<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Secretaria;
use App\Models\Paciente;
use App\Models\Consultorio;
use App\Models\Practica;
use App\Models\Obrasocial;
use App\Models\Medico;
use App\Models\Horario;

class AdminController extends Controller
{
    public function index()
    {
        $total_usuarios = User::count();
        $total_secretarias = Secretaria::count();
        $total_pacientes = Paciente::count();
        $total_consultorios = Consultorio::count();
        $total_practicas = Practica::count();
        $total_obras = Obrasocial::count();
        $total_medicos = Medico::count();
        $total_horarios = Horario::count();

        $consultorios = Consultorio::all();
        $practicas = Practica::all();
        $medicos = Medico::all();

        return view('admin.index', [
            'total_usuarios' => $total_usuarios,
            'total_secretarias' => $total_secretarias,
            'total_pacientes' => $total_pacientes,
            'total_consultorios' => $total_consultorios,
            'total_practicas' => $total_practicas,
            'total_obras' => $total_obras,
            'total_medicos' => $total_medicos,
            'total_horarios' => $total_horarios,
            'consultorios' => $consultorios,
            'practicas' => $practicas,
            'medicos' => $medicos
        ]);
    }
}
