<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //seeder para roles y permisos admin, secretaria, doctores, pacientes, usuarios
        $admin = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $secretaria = Role::create(['name' => 'secretaria', 'guard_name' => 'web']);
        $medico = Role::create(['name' => 'medico', 'guard_name' => 'web']);
        $paciente = Role::create(['name' => 'paciente', 'guard_name' => 'web']);
        $usuario = Role::create(['name' => 'usuario', 'guard_name' => 'web']);

        // User::factory(10)->create();

        //User::factory()->create([
        //    'name' => 'Test User',
        //    'email' => 'test@example.com',
        //]);
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345678')
        ])->assignRole('admin');
        User::create([
            'name' => 'Secretaria',
            'email' => 'secretaria@secretaria.com',
            'password' => bcrypt('12345678')
        ])->assignRole('secretaria');
        User::create([
            'name' => 'Medico',
            'email' => 'medico@medico.com',
            'password' => bcrypt('12345678')
        ])->assignRole('medico');
        User::create([
            'name' => 'Paciente',
            'email' => 'paciente@paciente.com',
            'password' => bcrypt('12345678')
        ])->assignRole('paciente');
        User::create([
            'name' => 'Usuario',
            'email' => 'usuario@usuario.com',
            'password' => bcrypt('12345678')
        ])->assignRole('usuario');

        //RUTA PARA EL ADMIN
        Permission::create(['name' => 'admin.index']);

        //RUTA PARA EL ADMIN - USUARIO
        Permission::create(['name' => 'admin.usuarios.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.usuarios.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.usuarios.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.usuarios.show'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.usuarios.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.usuarios.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.usuarios.confirmDelete'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.usuarios.destroy'])->syncRoles([$admin]);

        //RUTA PARA EL ADMIN - SECRETARIA
        Permission::create(['name' => 'admin.secretarias.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.secretarias.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.secretarias.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.secretarias.show'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.secretarias.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.secretarias.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.secretarias.confirmDelete'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.secretarias.destroy'])->syncRoles([$admin]);

        //RUTA PARA EL ADMIN - PACIENTES
        Permission::create(['name' => 'admin.pacientes.index'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.pacientes.create'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.pacientes.store'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.pacientes.show'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.pacientes.edit'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.pacientes.update'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.pacientes.confirmDelete'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.pacientes.destroy'])->syncRoles([$admin,$secretaria]);

        //RUTA PARA EL ADMIN - CONSULTORIOS
        Permission::create(['name' => 'admin.consultorios.index'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.consultorios.create'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.consultorios.store'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.consultorios.show'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.consultorios.edit'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.consultorios.update'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.consultorios.confirmDelete'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.consultorios.destroy'])->syncRoles([$admin,$secretaria]);

        //RUTA PARA EL ADMIN - PRACTICAS
        Permission::create(['name' => 'admin.practicas.index'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.practicas.create'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.practicas.store'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.practicas.show'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.practicas.edit'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.practicas.update'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.practicas.confirmDelete'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.practicas.destroy'])->syncRoles([$admin,$secretaria]);
      
        //RUTA PARA EL ADMIN - OBRAS SOCIALES
        Permission::create(['name' => 'admin.obrasociales.index'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.obrasociales.create'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.obrasociales.store'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.obrasociales.show'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.obrasociales.edit'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.obrasociales.update'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.obrasociales.confirmDelete'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.obrasociales.destroy'])->syncRoles([$admin,$secretaria]);
      
        //RUTA PARA EL ADMIN - MEDICOS
        Permission::create(['name' => 'admin.medicos.index'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.medicos.create'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.medicos.store'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.medicos.show'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.medicos.edit'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.medicos.update'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.medicos.confirmDelete'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.medicos.destroy'])->syncRoles([$admin,$secretaria]);

        //RUTA PARA EL ADMIN - HORARIOS
        Permission::create(['name' => 'admin.horarios.index'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.horarios.create'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.horarios.store'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.horarios.show'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.horarios.edit'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.horarios.update'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.horarios.confirmDelete'])->syncRoles([$admin,$secretaria]);
        Permission::create(['name' => 'admin.horarios.destroy'])->syncRoles([$admin,$secretaria]);





    }
}
