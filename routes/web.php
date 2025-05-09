<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\SecretariaController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\ConsultorioController;
use App\Http\Controllers\MedicoController;

use App\Http\Controllers\LocalidadController;

Route::get('/', function () {
    return view('index');
});

Auth::routes();

//RUTA PARA EL HOME
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//RUTA PARA EL ADMIN
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index')->middleware(middleware:'auth');
//RUTA PARA EL ADMIN - USUARIO
Route::get('/admin/usuarios', [App\Http\Controllers\UsuarioController::class, 'index'])->name('admin.usuarios.index')->middleware(middleware:'auth');
Route::get('/admin/usuarios/create', [UsuarioController::class, 'create'])->name('admin.usuarios.create')->middleware(middleware:'auth');
Route::post('/admin/usuarios/create', [UsuarioController::class, 'store'])->name('admin.usuarios.store')->middleware(middleware:'auth');
Route::get('/admin/usuarios/{id}', [UsuarioController::class, 'show'])->name('admin.usuarios.show')->middleware(middleware:'auth');
Route::get('/admin/usuarios/{id}/edit', [UsuarioController::class, 'edit'])->name('admin.usuarios.edit')->middleware(middleware:'auth');
Route::put('/admin/usuarios/{id}', [UsuarioController::class, 'update'])->name('admin.usuarios.update')->middleware(middleware:'auth');
Route::get('/admin/usuarios/{id}/confirm-delete', [UsuarioController::class, 'confirmDelete'])->name('admin.usuarios.confirmDelete')->middleware(middleware:'auth');
Route::delete('/admin/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('admin.usuarios.destroy')->middleware(middleware:'auth');

//RUTA PARA EL ADMIN - SECRETARIA
Route::get('/admin/secretarias', [SecretariaController::class, 'index'])->name('admin.secretarias.index')->middleware(middleware:'auth');
Route::get('/admin/secretarias/create', [SecretariaController::class, 'create'])->name('admin.secretarias.create')->middleware(middleware:'auth');
Route::post('/admin/secretarias/create', [SecretariaController::class, 'store'])->name('admin.secretarias.store')->middleware(middleware:'auth');
Route::get('/admin/secretarias/{id}', [SecretariaController::class, 'show'])->name('admin.secretarias.show')->middleware(middleware:'auth');
Route::get('/admin/secretarias/{id}/edit', [SecretariaController::class, 'edit'])->name('admin.secretarias.edit')->middleware(middleware:'auth');
Route::put('/admin/secretarias/{id}', [SecretariaController::class, 'update'])->name('admin.secretarias.update')->middleware(middleware:'auth');
Route::get('/admin/secretarias/{id}/confirm-delete', [SecretariaController::class, 'confirmDelete'])->name('admin.secretarias.confirmDelete')->middleware(middleware:'auth');
Route::delete('/admin/secretarias/{id}', [SecretariaController::class, 'destroy'])->name('admin.secretarias.destroy')->middleware(middleware:'auth');

//RUTA PARA EL ADMIN - PACIENTES
Route::get('/admin/pacientes', [PacienteController::class, 'index'])->name('admin.pacientes.index')->middleware(middleware:'auth');
Route::get('/admin/pacientes/create', [PacienteController::class, 'create'])->name('admin.pacientes.create')->middleware(middleware:'auth');
Route::post('/admin/pacientes/create', [PacienteController::class, 'store'])->name('admin.pacientes.store')->middleware(middleware:'auth');
Route::get('/admin/pacientes/{id}', [PacienteController::class, 'show'])->name('admin.pacientes.show')->middleware(middleware:'auth');
Route::get('/admin/pacientes/{id}/edit', [PacienteController::class, 'edit'])->name('admin.pacientes.edit')->middleware(middleware:'auth');
Route::put('/admin/pacientes/{id}', [PacienteController::class, 'update'])->name('admin.pacientes.update')->middleware(middleware:'auth');
Route::get('/admin/pacientes/{id}/confirm-delete', [PacienteController::class, 'confirmDelete'])->name('admin.pacientes.confirmDelete')->middleware(middleware:'auth');
Route::delete('/admin/pacientes/{id}', [PacienteController::class, 'destroy'])->name('admin.pacientes.destroy')->middleware(middleware:'auth');

//RUTA PARA EL ADMIN - CONSULTORIOS
Route::get('/admin/consultorios', [ConsultorioController::class, 'index'])->name('admin.consultorios.index')->middleware(middleware:'auth');
Route::get('/admin/consultorios/create', [ConsultorioController::class, 'create'])->name('admin.consultorios.create')->middleware(middleware:'auth');
Route::post('/admin/consultorios/create', [ConsultorioController::class, 'store'])->name('admin.consultorios.store')->middleware(middleware:'auth');
Route::get('/admin/consultorios/{id}', [ConsultorioController::class, 'show'])->name('admin.consultorios.show')->middleware(middleware:'auth');
Route::get('/admin/consultorios/{id}/edit', [ConsultorioController::class, 'edit'])->name('admin.consultorios.edit')->middleware(middleware:'auth');
Route::put('/admin/consultorios/{id}', [ConsultorioController::class, 'update'])->name('admin.consultorios.update')->middleware(middleware:'auth');
Route::get('/admin/consultorios/{id}/confirm-delete', [ConsultorioController::class, 'confirmDelete'])->name('admin.consultorios.confirmDelete')->middleware(middleware:'auth');
Route::delete('/admin/consultorios/{id}', [ConsultorioController::class, 'destroy'])->name('admin.consultorios.destroy')->middleware(middleware:'auth');

//RUTA PARA EL ADMIN - MEDICOS
Route::get('/admin/medicos', [MedicoController::class, 'index'])->name('admin.medicos.index')->middleware(middleware:'auth');
Route::get('/admin/medicos/create', [MedicoController::class, 'create'])->name('admin.medicos.create')->middleware(middleware:'auth');
Route::post('/admin/medicos/create', [MedicoController::class, 'store'])->name('admin.medicos.store')->middleware(middleware:'auth');
Route::get('/admin/medicos/{id}', [MedicoController::class, 'show'])->name('admin.medicos.show')->middleware(middleware:'auth');
Route::get('/admin/medicos/{id}/edit', [MedicoController::class, 'edit'])->name('admin.medicos.edit')->middleware(middleware:'auth');
Route::put('/admin/medicos/{id}', [MedicoController::class, 'update'])->name('admin.medicos.update')->middleware(middleware:'auth');
Route::get('/admin/medicos/{id}/confirm-delete', [MedicoController::class, 'confirmDelete'])->name('admin.medicos.confirmDelete')->middleware(middleware:'auth');
Route::delete('/admin/medicos/{id}', [MedicoController::class, 'destroy'])->name('admin.medicos.destroy')->middleware(middleware:'auth');

//RUTA PARA BUSCAR LAS LOCALIDADES SEGÚN LA PROVINCIA Y LA LOCALIDAD
Route::get('/admin/localidades/{idProv}', [LocalidadController::class, 'getLocalidades']);
Route::get('/admin/codpostales/{idLocal}', [LocalidadController::class, 'getCodigosPostales']);
