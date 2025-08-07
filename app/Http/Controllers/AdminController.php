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
use App\Models\Event;

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
        $total_obras_sociales = Obrasocial::count();
        $total_horarios = Horario::count();

        $consultorios = Consultorio::all();
        $practicas = Practica::all();
        $medicos = Medico::all();
        $obras_sociales = Obrasocial::all();
        $eventosfc = Event::all();

        return view('admin.index', compact(
            'total_usuarios',
            'total_secretarias',
            'total_pacientes',
            'total_consultorios',
            'total_practicas',
            'total_obras',
            'total_medicos',
            'total_obras_sociales',
            'total_horarios',
            'consultorios',
            'practicas',
            'medicos',
            'obras_sociales',
            'eventosfc'
        ));
    }

    public function filtrarEventos()
    {
        $consultorio_id = request('consultorio_id');
        $practica_id = request('practica_id');
        $medico_id = request('medico_id');

        $query = Event::query();

        if ($consultorio_id && $consultorio_id != '0') {
            $query->where('consultorio_id', $consultorio_id);
        }

        if ($practica_id && $practica_id != '0') {
            $query->where('practica_id', $practica_id);
        }

        if ($medico_id && $medico_id != '0') {
            $query->where('medico_id', $medico_id);
        }

        $eventos = $query->select('id', 'title', 'description', 'color', 'start', 'end')->get();

        return response()->json($eventos);
    }
}
