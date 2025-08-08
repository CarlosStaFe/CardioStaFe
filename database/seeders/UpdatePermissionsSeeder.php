<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UpdatePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener los roles existentes
        $admin = Role::where('name', 'admin')->first();
        $secretaria = Role::where('name', 'secretaria')->first();
        $medico = Role::where('name', 'medico')->first();

        if (!$admin || !$secretaria || !$medico) {
            echo "Error: No se pudieron encontrar todos los roles necesarios\n";
            return;
        }

        // Lista de permisos de horarios y eventos que queremos actualizar
        $permissionsToUpdate = [
            'admin.horarios.index',
            'admin.horarios.create',
            'admin.horarios.store',
            'admin.horarios.show',
            'admin.horarios.edit',
            'admin.horarios.update',
            'admin.horarios.confirmDelete',
            'admin.horarios.destroy',
            'admin.eventos.index',
            'admin.eventos.create',
            'admin.eventos.store',
            'admin.eventos.show',
            'admin.eventos.edit',
            'admin.eventos.update',
            'admin.eventos.destroy'
        ];

        echo "Actualizando permisos para el rol médico...\n";

        // Actualizar cada permiso para incluir el rol de médico
        foreach ($permissionsToUpdate as $permissionName) {
            $permission = Permission::where('name', $permissionName)->first();
            
            if ($permission) {
                // Sincronizar roles: admin, secretaria y medico
                $permission->syncRoles([$admin, $secretaria, $medico]);
                echo "✓ Permiso '{$permissionName}' actualizado\n";
            } else {
                echo "✗ Permiso '{$permissionName}' no encontrado\n";
            }
        }

        echo "\nPermisos actualizados correctamente para el rol médico.\n";
        
        // Verificar permisos del médico
        $medicoPermisos = $medico->permissions->pluck('name')->toArray();
        $eventosPermisos = array_filter($medicoPermisos, function($permiso) {
            return str_contains($permiso, 'eventos') || str_contains($permiso, 'horarios');
        });
        
        echo "Permisos de eventos/horarios para médico:\n";
        foreach ($eventosPermisos as $permiso) {
            echo "- {$permiso}\n";
        }
    }
}
