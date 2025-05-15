<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\SecretariaController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\ConsultorioController;
use App\Http\Controllers\PracticaController;
use App\Http\Controllers\ObrasocialController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\HorarioController;

use App\Http\Controllers\LocalidadController;

Route::get('/', function () {
    return view('index');
});

Auth::routes();

//RUTA PARA EL HOME
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//RUTA PARA EL ADMIN
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index')->middleware(middleware:'auth');
//RUTA PARA EL ADMIN - USUARIO
Route::get('/admin/usuarios', [App\Http\Controllers\UsuarioController::class, 'index'])->name('admin.usuarios.index')->middleware(['auth', 'can:admin.usuarios.index']);
Route::get('/admin/usuarios/create', [UsuarioController::class, 'create'])->name('admin.usuarios.create')->middleware(['auth', 'can:admin.usuarios.create']);
Route::post('/admin/usuarios/create', [UsuarioController::class, 'store'])->name('admin.usuarios.store')->middleware(['auth', 'can:admin.usuarios.store']);
Route::get('/admin/usuarios/{id}', [UsuarioController::class, 'show'])->name('admin.usuarios.show')->middleware(['auth', 'can:admin.usuarios.show']);
Route::get('/admin/usuarios/{id}/edit', [UsuarioController::class, 'edit'])->name('admin.usuarios.edit')->middleware(['auth', 'can:admin.usuarios.edit']);
Route::put('/admin/usuarios/{id}', [UsuarioController::class, 'update'])->name('admin.usuarios.update')->middleware(['auth', 'can:admin.usuarios.update']);
Route::get('/admin/usuarios/{id}/confirm-delete', [UsuarioController::class, 'confirmDelete'])->name('admin.usuarios.confirmDelete')->middleware(['auth', 'can:admin.usuarios.confirmDelete']);
Route::delete('/admin/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('admin.usuarios.destroy')->middleware(['auth', 'can:admin.usuarios.destroy']);

//RUTA PARA EL ADMIN - SECRETARIA
Route::get('/admin/secretarias', [SecretariaController::class, 'index'])->name('admin.secretarias.index')->middleware(['auth', 'can:admin.secretarias.index']);
Route::get('/admin/secretarias/create', [SecretariaController::class, 'create'])->name('admin.secretarias.create')->middleware(['auth', 'can:admin.secretarias.create']);
Route::post('/admin/secretarias/create', [SecretariaController::class, 'store'])->name('admin.secretarias.store')->middleware(['auth', 'can:admin.secretarias.store']);
Route::get('/admin/secretarias/{id}', [SecretariaController::class, 'show'])->name('admin.secretarias.show')->middleware(['auth', 'can:admin.secretarias.show']);
Route::get('/admin/secretarias/{id}/edit', [SecretariaController::class, 'edit'])->name('admin.secretarias.edit')->middleware(['auth', 'can:admin.secretarias.edit']);
Route::put('/admin/secretarias/{id}', [SecretariaController::class, 'update'])->name('admin.secretarias.update')->middleware(['auth', 'can:admin.secretarias.update']);
Route::get('/admin/secretarias/{id}/confirm-delete', [SecretariaController::class, 'confirmDelete'])->name('admin.secretarias.confirmDelete')->middleware(['auth', 'can:admin.secretarias.confirmDelete']);
Route::delete('/admin/secretarias/{id}', [SecretariaController::class, 'destroy'])->name('admin.secretarias.destroy')->middleware(['auth', 'can:admin.secretarias.destroy']);

//RUTA PARA EL ADMIN - PACIENTES
Route::get('/admin/pacientes', [PacienteController::class, 'index'])->name('admin.pacientes.index')->middleware(['auth', 'can:admin.pacientes.index']);
Route::get('/admin/pacientes/create', [PacienteController::class, 'create'])->name('admin.pacientes.create')->middleware(['auth', 'can:admin.pacientes.create']);
Route::post('/admin/pacientes/create', [PacienteController::class, 'store'])->name('admin.pacientes.store')->middleware(['auth', 'can:admin.pacientes.store']);
Route::get('/admin/pacientes/{id}', [PacienteController::class, 'show'])->name('admin.pacientes.show')->middleware(['auth', 'can:admin.pacientes.show']);
Route::get('/admin/pacientes/{id}/edit', [PacienteController::class, 'edit'])->name('admin.pacientes.edit')->middleware(['auth', 'can:admin.pacientes.edit']);
Route::put('/admin/pacientes/{id}', [PacienteController::class, 'update'])->name('admin.pacientes.update')->middleware(['auth', 'can:admin.pacientes.update']);
Route::get('/admin/pacientes/{id}/confirm-delete', [PacienteController::class, 'confirmDelete'])->name('admin.pacientes.confirmDelete')->middleware(['auth', 'can:admin.pacientes.confirmDelete']);
Route::delete('/admin/pacientes/{id}', [PacienteController::class, 'destroy'])->name('admin.pacientes.destroy')->middleware(['auth', 'can:admin.pacientes.destroy']);

//RUTA PARA EL ADMIN - CONSULTORIOS
Route::get('/admin/consultorios', [ConsultorioController::class, 'index'])->name('admin.consultorios.index')->middleware(['auth', 'can:admin.consultorios.index']);
Route::get('/admin/consultorios/create', [ConsultorioController::class, 'create'])->name('admin.consultorios.create')->middleware(['auth', 'can:admin.consultorios.create']);
Route::post('/admin/consultorios/create', [ConsultorioController::class, 'store'])->name('admin.consultorios.store')->middleware(['auth', 'can:admin.consultorios.store']);
Route::get('/admin/consultorios/{id}', [ConsultorioController::class, 'show'])->name('admin.consultorios.show')->middleware(['auth', 'can:admin.consultorios.show']);
Route::get('/admin/consultorios/{id}/edit', [ConsultorioController::class, 'edit'])->name('admin.consultorios.edit')->middleware(['auth', 'can:admin.consultorios.edit']);
Route::put('/admin/consultorios/{id}', [ConsultorioController::class, 'update'])->name('admin.consultorios.update')->middleware(['auth', 'can:admin.consultorios.update']);
Route::get('/admin/consultorios/{id}/confirm-delete', [ConsultorioController::class, 'confirmDelete'])->name('admin.consultorios.confirmDelete')->middleware(['auth', 'can:admin.consultorios.confirmDelete']);
Route::delete('/admin/consultorios/{id}', [ConsultorioController::class, 'destroy'])->name('admin.consultorios.destroy')->middleware(['auth', 'can:admin.consultorios.destroy']);

//RUTA PARA EL ADMIN - PRACTICAS
Route::get('/admin/practicas', [PracticaController::class, 'index'])->name('admin.practicas.index')->middleware(['auth', 'can:admin.practicas.index']);
Route::get('/admin/practicas/create', [PracticaController::class, 'create'])->name('admin.practicas.create')->middleware(['auth', 'can:admin.practicas.create']);
Route::post('/admin/practicas/create', [PracticaController::class, 'store'])->name('admin.practicas.store')->middleware(['auth', 'can:admin.practicas.store']);
Route::get('/admin/practicas/{id}', [PracticaController::class, 'show'])->name('admin.practicas.show')->middleware(['auth', 'can:admin.practicas.show']);
Route::get('/admin/practicas/{id}/edit', [PracticaController::class, 'edit'])->name('admin.practicas.edit')->middleware(['auth', 'can:admin.practicas.edit']);
Route::put('/admin/practicas/{id}', [PracticaController::class, 'update'])->name('admin.practicas.update')->middleware(['auth', 'can:admin.practicas.update']);
Route::get('/admin/practicas/{id}/confirm-delete', [PracticaController::class, 'confirmDelete'])->name('admin.practicas.confirmDelete')->middleware(['auth', 'can:admin.practicas.confirmDelete']);
Route::delete('/admin/practicas/{id}', [PracticaController::class, 'destroy'])->name('admin.practicas.destroy')->middleware(['auth', 'can:admin.practicas.destroy']);

//RUTA PARA EL ADMIN - OBRAS SOCIALES
Route::get('/admin/obrasociales', [ObrasocialController::class, 'index'])->name('admin.obrasociales.index')->middleware(['auth', 'can:admin.obrasociales.index']);
Route::get('/admin/obrasociales/create', [ObrasocialController::class, 'create'])->name('admin.obrasociales.create')->middleware(['auth', 'can:admin.obrasociales.create']);
Route::post('/admin/obrasociales/create', [ObrasocialController::class, 'store'])->name('admin.obrasociales.store')->middleware(['auth', 'can:admin.obrasociales.store']);
Route::get('/admin/obrasociales/{id}', [ObrasocialController::class, 'show'])->name('admin.obrasociales.show')->middleware(['auth', 'can:admin.obrasociales.show']);
Route::get('/admin/obrasociales/{id}/edit', [ObrasocialController::class, 'edit'])->name('admin.obrasociales.edit')->middleware(['auth', 'can:admin.obrasociales.edit']);
Route::put('/admin/obrasociales/{id}', [ObrasocialController::class, 'update'])->name('admin.obrasociales.update')->middleware(['auth', 'can:admin.obrasociales.update']);
Route::get('/admin/obrasociales/{id}/confirm-delete', [ObrasocialController::class, 'confirmDelete'])->name('admin.obrasociales.confirmDelete')->middleware(['auth', 'can:admin.obrasociales.confirmDelete']);
Route::delete('/admin/obrasociales/{id}', [ObrasocialController::class, 'destroy'])->name('admin.obrasociales.destroy')->middleware(['auth', 'can:admin.obrasociales.destroy']);

//RUTA PARA EL ADMIN - MEDICOS
Route::get('/admin/medicos', [MedicoController::class, 'index'])->name('admin.medicos.index')->middleware(['auth', 'can:admin.medicos.index']);
Route::get('/admin/medicos/create', [MedicoController::class, 'create'])->name('admin.medicos.create')->middleware(['auth', 'can:admin.medicos.create']);
Route::post('/admin/medicos/create', [MedicoController::class, 'store'])->name('admin.medicos.store')->middleware(['auth', 'can:admin.medicos.store']);
Route::get('/admin/medicos/{id}', [MedicoController::class, 'show'])->name('admin.medicos.show')->middleware(['auth', 'can:admin.medicos.show']);
Route::get('/admin/medicos/{id}/edit', [MedicoController::class, 'edit'])->name('admin.medicos.edit')->middleware(['auth', 'can:admin.medicos.edit']);
Route::put('/admin/medicos/{id}', [MedicoController::class, 'update'])->name('admin.medicos.update')->middleware(['auth', 'can:admin.medicos.update']);
Route::get('/admin/medicos/{id}/confirm-delete', [MedicoController::class, 'confirmDelete'])->name('admin.medicos.confirmDelete')->middleware(['auth', 'can:admin.medicos.confirmDelete']);
Route::delete('/admin/medicos/{id}', [MedicoController::class, 'destroy'])->name('admin.medicos.destroy')->middleware(['auth', 'can:admin.medicos.destroy']);

//RUTA PARA EL ADMIN - HORARIOS
Route::get('/admin/horarios', [HorarioController::class, 'index'])->name('admin.horarios.index')->middleware(['auth', 'can:admin.horarios.index']);
Route::get('/admin/horarios/create', [HorarioController::class, 'create'])->name('admin.horarios.create')->middleware(['auth', 'can:admin.horarios.create']);
Route::post('/admin/horarios/create', [HorarioController::class, 'store'])->name('admin.horarios.store')->middleware(['auth', 'can:admin.horarios.store']);
Route::get('/admin/horarios/{id}', [HorarioController::class, 'show'])->name('admin.horarios.show')->middleware(['auth', 'can:admin.horarios.show']);
Route::get('/admin/horarios/{id}/edit', [HorarioController::class, 'edit'])->name('admin.horarios.edit')->middleware(['auth', 'can:admin.horarios.edit']);
Route::put('/admin/horarios/{id}', [HorarioController::class, 'update'])->name('admin.horarios.update')->middleware(['auth', 'can:admin.horarios.update']);
Route::get('/admin/horarios/{id}/confirm-delete', [HorarioController::class, 'confirmDelete'])->name('admin.horarios.confirmDelete')->middleware(['auth', 'can:admin.horarios.confirmDelete']);
Route::delete('/admin/horarios/{id}', [HorarioController::class, 'destroy'])->name('admin.horarios.destroy')->middleware(['auth', 'can:admin.horarios.destroy']);

//RUTA PARA BUSCAR LAS LOCALIDADES SEGÚN LA PROVINCIA Y LA LOCALIDAD
Route::get('/admin/localidades/{idProv}', [LocalidadController::class, 'getLocalidades']);
Route::get('/admin/codpostales/{idLocal}', [LocalidadController::class, 'getCodigosPostales']);
