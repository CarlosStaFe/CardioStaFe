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
    // Seeder para roles y permisos admin, secretaria, doctores, pacientes, usuarios
    $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
    $secretaria = Role::firstOrCreate(['name' => 'secretaria', 'guard_name' => 'web']);
    $medico = Role::firstOrCreate(['name' => 'medico', 'guard_name' => 'web']);
    $paciente = Role::firstOrCreate(['name' => 'paciente', 'guard_name' => 'web']);
    $usuario = Role::firstOrCreate(['name' => 'usuario', 'guard_name' => 'web']);

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            ['name' => 'Administrador', 'password' => bcrypt('12345678')]
        );
        $adminUser->assignRole('admin');

        $secretariaUser = User::firstOrCreate(
            ['email' => 'secretaria@secretaria.com'],
            ['name' => 'Secretaria', 'password' => bcrypt('12345678')]
        );
        $secretariaUser->assignRole('secretaria');

        $medicoUser = User::firstOrCreate(
            ['email' => 'medico@medico.com'],
            ['name' => 'Medico', 'password' => bcrypt('12345678')]
        );
        $medicoUser->assignRole('medico');

        $pacienteUser = User::firstOrCreate(
            ['email' => 'paciente@paciente.com'],
            ['name' => 'Paciente', 'password' => bcrypt('12345678')]
        );
        $pacienteUser->assignRole('paciente');

        $usuarioUser = User::firstOrCreate(
            ['email' => 'usuario@usuario.com'],
            ['name' => 'Usuario', 'password' => bcrypt('12345678')]
        );
        $usuarioUser->assignRole('usuario');

        //RUTA PARA EL ADMIN
        Permission::firstOrCreate(['name' => 'admin.index', 'guard_name' => 'web']);

        //RUTA PARA EL ADMIN - USUARIO
        Permission::firstOrCreate(['name' => 'admin.usuarios.index', 'guard_name' => 'web'])->syncRoles([$admin]);
        Permission::firstOrCreate(['name' => 'admin.usuarios.create', 'guard_name' => 'web'])->syncRoles([$admin]);
        Permission::firstOrCreate(['name' => 'admin.usuarios.store', 'guard_name' => 'web'])->syncRoles([$admin]);
        Permission::firstOrCreate(['name' => 'admin.usuarios.show', 'guard_name' => 'web'])->syncRoles([$admin]);
        Permission::firstOrCreate(['name' => 'admin.usuarios.edit', 'guard_name' => 'web'])->syncRoles([$admin]);
        Permission::firstOrCreate(['name' => 'admin.usuarios.update', 'guard_name' => 'web'])->syncRoles([$admin]);
        Permission::firstOrCreate(['name' => 'admin.usuarios.confirmDelete', 'guard_name' => 'web'])->syncRoles([$admin]);
        Permission::firstOrCreate(['name' => 'admin.usuarios.destroy', 'guard_name' => 'web'])->syncRoles([$admin]);

        //RUTA PARA EL ADMIN - SECRETARIA
        Permission::firstOrCreate(['name' => 'admin.secretarias.index'])->syncRoles([$admin]);
        Permission::firstOrCreate(['name' => 'admin.secretarias.create'])->syncRoles([$admin]);
        Permission::firstOrCreate(['name' => 'admin.secretarias.store'])->syncRoles([$admin]);
        Permission::firstOrCreate(['name' => 'admin.secretarias.show'])->syncRoles([$admin]);
        Permission::firstOrCreate(['name' => 'admin.secretarias.edit'])->syncRoles([$admin]);
        Permission::firstOrCreate(['name' => 'admin.secretarias.update'])->syncRoles([$admin]);
        Permission::firstOrCreate(['name' => 'admin.secretarias.confirmDelete'])->syncRoles([$admin]);
        Permission::firstOrCreate(['name' => 'admin.secretarias.destroy'])->syncRoles([$admin]);

        //RUTA PARA EL ADMIN - PACIENTES
        Permission::firstOrCreate(['name' => 'admin.pacientes.index'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.pacientes.create'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.pacientes.store'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.pacientes.show'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.pacientes.edit'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.pacientes.update'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.pacientes.confirmDelete'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.pacientes.destroy'])->syncRoles([$admin,$secretaria]);

        //RUTA PARA EL ADMIN - CONSULTORIOS
        Permission::firstOrCreate(['name' => 'admin.consultorios.index'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.consultorios.create'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.consultorios.store'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.consultorios.show'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.consultorios.edit'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.consultorios.update'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.consultorios.confirmDelete'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.consultorios.destroy'])->syncRoles([$admin,$secretaria]);

        //RUTA PARA EL ADMIN - PRACTICAS
        Permission::firstOrCreate(['name' => 'admin.practicas.index'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.practicas.create'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.practicas.store'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.practicas.show'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.practicas.edit'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.practicas.update'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.practicas.confirmDelete'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.practicas.destroy'])->syncRoles([$admin,$secretaria]);
      
        //RUTA PARA EL ADMIN - OBRAS SOCIALES
        Permission::firstOrCreate(['name' => 'admin.obrasociales.index'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.obrasociales.create'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.obrasociales.store'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.obrasociales.show'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.obrasociales.edit'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.obrasociales.update'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.obrasociales.confirmDelete'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.obrasociales.destroy'])->syncRoles([$admin,$secretaria]);
      
        //RUTA PARA EL ADMIN - MEDICOS
        Permission::firstOrCreate(['name' => 'admin.medicos.index'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.medicos.create'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.medicos.store'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.medicos.show'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.medicos.edit'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.medicos.update'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.medicos.confirmDelete'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.medicos.destroy'])->syncRoles([$admin,$secretaria]);

        //RUTA PARA EL ADMIN - EVENTOS
        Permission::firstOrCreate(['name' => 'admin.eventos.index'])->syncRoles([$admin,$secretaria,$medico]);
        Permission::firstOrCreate(['name' => 'admin.eventos.create'])->syncRoles([$admin,$secretaria]);
        Permission::firstOrCreate(['name' => 'admin.eventos.store'])->syncRoles([$admin,$secretaria,$medico]);
        Permission::firstOrCreate(['name' => 'admin.eventos.show'])->syncRoles([$admin,$secretaria,$medico]);
        Permission::firstOrCreate(['name' => 'admin.eventos.edit'])->syncRoles([$admin,$secretaria,$medico]);
        Permission::firstOrCreate(['name' => 'admin.eventos.update'])->syncRoles([$admin,$secretaria,$medico]);
        Permission::firstOrCreate(['name' => 'admin.eventos.destroy'])->syncRoles([$admin,$secretaria,$medico]);

         $this->call([
            //ConsultoriosSeeder::class,
            //LocalidadesSeeder::class,
            //MedicosSeeder::class,
            //ObraSocialesSeeder::class,
            //PacientesSeeder::class,
            //PracticasSeeder::class,
            //SecretariasSeeder::class,
        ]);

    }
}
