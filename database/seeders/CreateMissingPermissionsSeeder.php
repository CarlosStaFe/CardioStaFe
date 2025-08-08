<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateMissingPermissionsSeeder extends Seeder
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

        // Lista de permisos de eventos que faltan
        $missingPermissions = [
            'admin.eventos.index',
            'admin.eventos.create', 
            'admin.eventos.store',
            'admin.eventos.show',
            'admin.eventos.edit',
            'admin.eventos.update'
        ];

        echo "Creando permisos faltantes...\n";

        foreach ($missingPermissions as $permissionName) {
            // Verificar si el permiso ya existe
            $existingPermission = Permission::where('name', $permissionName)->first();
            
            if (!$existingPermission) {
                // Crear el permiso y asignarlo a los roles necesarios
                $permission = Permission::create(['name' => $permissionName]);
                $permission->syncRoles([$admin, $secretaria, $medico]);
                echo "✓ Permiso '{$permissionName}' creado y asignado\n";
            } else {
                // Si existe, solo actualizar los roles
                $existingPermission->syncRoles([$admin, $secretaria, $medico]);
                echo "✓ Permiso '{$permissionName}' ya existe - roles actualizados\n";
            }
        }

        echo "\nPermisos creados y asignados correctamente.\n";
        
        // Verificar todos los permisos del médico relacionados con eventos/horarios
        $medicoPermisos = $medico->fresh()->permissions->pluck('name')->toArray();
        $eventosHorariosPermisos = array_filter($medicoPermisos, function($permiso) {
            return str_contains($permiso, 'eventos') || str_contains($permiso, 'horarios');
        });
        
        echo "\nPermisos finales de eventos/horarios para médico:\n";
        foreach ($eventosHorariosPermisos as $permiso) {
            echo "- {$permiso}\n";
        }
    }
}
