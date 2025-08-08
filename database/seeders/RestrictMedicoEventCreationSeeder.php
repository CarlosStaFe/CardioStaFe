<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RestrictMedicoEventCreationSeeder extends Seeder
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

        // Permisos que SOLO admin y secretaria pueden tener (crear eventos)
        $restrictedPermissions = [
            'admin.eventos.create',
            'admin.eventos.store',
            'admin.horarios.create',
            'admin.horarios.store'
        ];

        // Permisos que médico SÍ puede tener (ver, editar, cambiar estados, eliminar)
        $allowedPermissions = [
            'admin.eventos.index',
            'admin.eventos.show',
            'admin.eventos.edit', 
            'admin.eventos.update',
            'admin.eventos.destroy',
            'admin.horarios.index',
            'admin.horarios.show',
            'admin.horarios.edit',
            'admin.horarios.update',
            'admin.horarios.destroy',
            'admin.horarios.confirmDelete'
        ];

        echo "Restringiendo permisos de creación para médicos...\n";

        // Remover permisos de creación del médico
        foreach ($restrictedPermissions as $permissionName) {
            $permission = Permission::where('name', $permissionName)->first();
            
            if ($permission) {
                // Solo admin y secretaria pueden crear
                $permission->syncRoles([$admin, $secretaria]);
                echo "✗ Permiso '{$permissionName}' restringido (solo admin y secretaria)\n";
            }
        }

        // Asegurar que médico tenga los permisos permitidos
        foreach ($allowedPermissions as $permissionName) {
            $permission = Permission::where('name', $permissionName)->first();
            
            if ($permission) {
                // Admin, secretaria y médico pueden ver/editar
                $permission->syncRoles([$admin, $secretaria, $medico]);
                echo "✓ Permiso '{$permissionName}' permitido para médico\n";
            }
        }

        echo "\nPermisos actualizados correctamente.\n";
        
        // Verificar permisos finales del médico
        $medicoPermisos = $medico->fresh()->permissions->pluck('name')->toArray();
        $eventosHorariosPermisos = array_filter($medicoPermisos, function($permiso) {
            return str_contains($permiso, 'eventos') || str_contains($permiso, 'horarios');
        });
        
        echo "\nPermisos finales de eventos/horarios para médico:\n";
        foreach ($eventosHorariosPermisos as $permiso) {
            echo "- {$permiso}\n";
        }
        
        echo "\nPermisos RESTRINGIDOS (solo admin/secretaria):\n";
        foreach ($restrictedPermissions as $permiso) {
            echo "- {$permiso}\n";
        }
    }
}
