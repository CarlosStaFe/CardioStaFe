<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class VerifyMedicoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar el usuario médico
        $medicoUser = User::where('email', 'medico@medico.com')->first();
        $medicoRole = Role::where('name', 'medico')->first();

        if (!$medicoUser) {
            echo "El usuario médico no existe. Creando...\n";
            $medicoUser = User::create([
                'name' => 'Médico',
                'email' => 'medico@medico.com',
                'password' => bcrypt('12345678')
            ]);
        }

        if (!$medicoRole) {
            echo "Error: El rol médico no existe.\n";
            return;
        }

        // Verificar si tiene el rol asignado
        if (!$medicoUser->hasRole('medico')) {
            echo "Asignando rol médico al usuario...\n";
            $medicoUser->assignRole('medico');
        }

        // Verificar permisos
        $permisos = $medicoUser->getAllPermissions()->pluck('name')->toArray();
        $eventosPermisos = array_filter($permisos, function($permiso) {
            return str_contains($permiso, 'eventos') || str_contains($permiso, 'horarios');
        });

        echo "Usuario: {$medicoUser->email}\n";
        echo "Roles: " . $medicoUser->roles->pluck('name')->implode(', ') . "\n";
        echo "Permisos de eventos/horarios:\n";
        foreach ($eventosPermisos as $permiso) {
            echo "- {$permiso}\n";
        }

        // Verificar específicamente si puede admin.eventos.index
        if ($medicoUser->can('admin.eventos.index')) {
            echo "\n✓ El usuario PUEDE acceder a admin.eventos.index\n";
        } else {
            echo "\n✗ El usuario NO PUEDE acceder a admin.eventos.index\n";
        }
    }
}
