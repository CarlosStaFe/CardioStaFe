<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BackupController extends Controller
{
    /**
     * Constructor - verificar permisos
     */
    public function __construct()
    {
        // Solo administradores y secretarias pueden acceder
        $this->middleware(['auth', function ($request, $next) {
            $user = Auth::user();
            $userRoles = $user->roles->pluck('name')->toArray();
            
            // Verificar si es administrador o secretaria
            if (!in_array('admin', $userRoles) && !in_array('secretaria', $userRoles)) {
                abort(403, 'No tienes permisos para acceder a esta sección.');
            }
            
            return $next($request);
        }]);
    }

    /**
     * Mostrar formulario de backup y restore
     */
    public function index()
    {
        try {
            Log::info('Acceso a backup', [
                'user' => Auth::user()->email,
                'roles' => Auth::user()->roles->pluck('name')->toArray()
            ]);
            
            // Obtener lista de backups existentes
            $backupPath = storage_path('app/backups');
            $backups = [];
            
            // Crear directorio si no existe
            if (!is_dir($backupPath)) {
                mkdir($backupPath, 0755, true);
            }
            
            if (is_dir($backupPath)) {
                $files = glob($backupPath . '/*.sql');
                foreach ($files as $file) {
                    $backups[] = [
                        'filename' => basename($file),
                        'size' => number_format(filesize($file) / 1024 / 1024, 2) . ' MB',
                        'created_at' => date('d/m/Y H:i', filemtime($file))
                    ];
                }
                // Ordenar por fecha de creación descendente
                usort($backups, function($a, $b) {
                    return filemtime(storage_path('app/backups/' . $b['filename'])) - 
                           filemtime(storage_path('app/backups/' . $a['filename']));
                });
            }
            
            return view('admin.backup.index', compact('backups'));
        } catch (\Exception $e) {
            Log::error('Error al cargar backup: ' . $e->getMessage());
            return redirect()->back()->with('mensaje', 'Error al cargar la página: ' . $e->getMessage())
                ->with('icono', 'error')->with('showBtn', 'true')->with('timer', '6000');
        }
    }

    /**
     * Crear backup de la base de datos
     */
    public function create(Request $request)
    {
        try {
            $dbName = config('database.connections.mysql.database');
            $dbUser = config('database.connections.mysql.username');
            $dbPass = config('database.connections.mysql.password');
            $dbHost = config('database.connections.mysql.host');
            $dbPort = config('database.connections.mysql.port');
            
            // Crear directorio de backups si no existe
            $backupPath = storage_path('app/backups');
            if (!is_dir($backupPath)) {
                mkdir($backupPath, 0755, true);
            }
            
            // Nombre del archivo de backup
            $filename = 'backup_' . $dbName . '_' . date('Y-m-d_H-i-s') . '.sql';
            $filepath = $backupPath . '/' . $filename;
            
            // Comando mysqldump con ruta completa
            $mysqldumpPath = 'C:/xampp/mysql/bin/mysqldump.exe';
            $command = sprintf(
                '"%s" --host="%s" --port="%s" --user="%s" --password="%s" --single-transaction --routines --triggers "%s" > "%s"',
                $mysqldumpPath,
                $dbHost,
                $dbPort,
                $dbUser,
                $dbPass,
                $dbName,
                $filepath
            );
            
            // Verificar que mysqldump existe
            if (!file_exists($mysqldumpPath)) {
                Log::error('mysqldump no encontrado', ['path' => $mysqldumpPath]);
                return redirect()->route('admin.backup.index')
                    ->with('mensaje', 'mysqldump no encontrado en: ' . $mysqldumpPath)
                    ->with('icono', 'error');
            }
            
            // Log del comando para debug (sin mostrar contraseña)
            $logCommand = str_replace(
                '--password="' . $dbPass . '"',
                '--password="***"',
                $command
            );
            Log::info('Ejecutando comando backup', ['command' => $logCommand]);
            
            // Ejecutar el comando
            $output = [];
            $returnCode = 0;
            \exec($command . ' 2>&1', $output, $returnCode);
            
            // Log detallado del resultado
            Log::info('Resultado comando backup', [
                'return_code' => $returnCode,
                'output' => implode('\n', $output),
                'file_exists' => file_exists($filepath),
                'file_size' => file_exists($filepath) ? filesize($filepath) : 0
            ]);
            
            if ($returnCode === 0 && file_exists($filepath) && filesize($filepath) > 0) {
                Log::info('Backup creado exitosamente', [
                    'filename' => $filename,
                    'size' => filesize($filepath),
                    'user' => Auth::user()->email,
                    'role' => Auth::user()->roles->pluck('name')->first()
                ]);
                
                return redirect()->route('admin.backup.index')
                    ->with('mensaje', 'Backup creado exitosamente: ' . $filename)
                    ->with('icono', 'success')
                    ->with('showBtn', 'true')
                    ->with('timer', '6000');
            } else {
                $errorDetails = [
                    'return_code' => $returnCode,
                    'output' => implode('\n', $output),
                    'user' => Auth::user()->email,
                    'file_exists' => file_exists($filepath),
                    'file_size' => file_exists($filepath) ? filesize($filepath) : 0,
                    'command_path_exists' => file_exists($mysqldumpPath),
                    'working_directory' => getcwd(),
                    'php_user' => get_current_user()
                ];
                
                Log::error('Error al crear backup', $errorDetails);
                
                $errorMsg = 'Error al crear backup. Código: ' . $returnCode;
                if ($returnCode === 127) {
                    $errorMsg .= ' (Comando no encontrado)';
                }
                
                return redirect()->route('admin.backup.index')
                    ->with('mensaje', $errorMsg)
                    ->with('icono', 'error')
                    ->with('showBtn', 'true')
                    ->with('timer', '8000');
            }
            
        } catch (\Exception $e) {
            Log::error('Excepción al crear backup: ' . $e->getMessage(), [
                'user' => Auth::user()->email
            ]);
            return redirect()->back()
                ->with('mensaje', 'Error al crear backup: ' . $e->getMessage())
                ->with('icono', 'error')
                ->with('showBtn', 'true')
                ->with('timer', '6000');
        }
    }

    /**
     * Restaurar backup de la base de datos
     */
    public function restore(Request $request)
    {
        // Solo administradores pueden restaurar
        $userRoles = Auth::user()->roles->pluck('name')->toArray();
        if (!in_array('admin', $userRoles)) {
            return redirect()->back()
                ->with('mensaje', 'Solo los administradores pueden restaurar la base de datos.')
                ->with('icono', 'error')
                ->with('showBtn', 'true')
                ->with('timer', '6000');
        }

        $request->validate([
            'backup_file' => 'required|string'
        ]);
        
        try {
            $backupPath = storage_path('app/backups/' . $request->backup_file);
            
            if (!file_exists($backupPath)) {
                return redirect()->back()
                    ->with('mensaje', 'Archivo de backup no encontrado.')
                    ->with('icono', 'error')
                    ->with('showBtn', 'true')
                    ->with('timer', '6000');
            }
            
            $dbName = config('database.connections.mysql.database');
            $dbUser = config('database.connections.mysql.username');
            $dbPass = config('database.connections.mysql.password');
            $dbHost = config('database.connections.mysql.host');
            $dbPort = config('database.connections.mysql.port');
            
            // Comando mysql para restaurar con ruta completa
            $mysqlPath = 'C:/xampp/mysql/bin/mysql.exe';
            $command = sprintf(
                '"%s" --host="%s" --port="%s" --user="%s" --password="%s" "%s" < "%s"',
                $mysqlPath,
                $dbHost,
                $dbPort,
                $dbUser,
                $dbPass,
                $dbName,
                $backupPath
            );
            
            // Verificar que mysql existe
            if (!file_exists($mysqlPath)) {
                Log::error('mysql no encontrado', ['path' => $mysqlPath]);
                return redirect()->route('admin.backup.index')
                    ->with('mensaje', 'mysql no encontrado en: ' . $mysqlPath)
                    ->with('icono', 'error');
            }
            
            // Log del comando para debug (sin mostrar contraseña)
            $logCommand = str_replace(
                '--password="' . $dbPass . '"',
                '--password="***"',
                $command
            );
            Log::info('Ejecutando comando restauración', ['command' => $logCommand]);
            
            // Ejecutar el comando
            $output = [];
            $returnCode = 0;
            \exec($command . ' 2>&1', $output, $returnCode);

            if ($returnCode === 0) {
                Log::info('Backup restaurado exitosamente', [
                    'filename' => $request->backup_file,
                    'user' => Auth::user()->email
                ]);
                
                return redirect()->route('admin.backup.index')
                    ->with('mensaje', 'Base de datos restaurada exitosamente desde: ' . $request->backup_file)
                    ->with('icono', 'success')
                    ->with('showBtn', 'true')
                    ->with('timer', '6000');
            } else {
                Log::error('Error al restaurar backup', [
                    'filename' => $request->backup_file,
                    'return_code' => $returnCode,
                    'output' => implode("\n", $output),
                    'user' => Auth::user()->email
                ]);
                
                return redirect()->back()
                    ->with('mensaje', 'Error al restaurar backup. Verifique el archivo y la configuración.')
                    ->with('icono', 'error')
                    ->with('showBtn', 'true')
                    ->with('timer', '6000');
            }
            
        } catch (\Exception $e) {
            Log::error('Excepción al restaurar backup: ' . $e->getMessage(), [
                'user' => Auth::user()->email
            ]);
            return redirect()->back()
                ->with('mensaje', 'Error al restaurar backup: ' . $e->getMessage())
                ->with('icono', 'error')
                ->with('showBtn', 'true')
                ->with('timer', '6000');
        }
    }

    /**
     * Eliminar archivo de backup
     */
    public function delete($filename)
    {
        try {
            $backupPath = storage_path('app/backups/' . basename($filename));
            
            if (file_exists($backupPath)) {
                unlink($backupPath);
                
                Log::info('Backup eliminado', [
                    'filename' => $filename,
                    'user' => Auth::user()->email
                ]);
                
                return redirect()->route('admin.backup.index')
                    ->with('mensaje', 'Backup eliminado exitosamente: ' . $filename)
                    ->with('icono', 'success')
                    ->with('showBtn', 'true')
                    ->with('timer', '4000');
            } else {
                return redirect()->back()
                    ->with('mensaje', 'Archivo de backup no encontrado.')
                    ->with('icono', 'error')
                    ->with('showBtn', 'true')
                    ->with('timer', '4000');
            }
            
        } catch (\Exception $e) {
            Log::error('Error al eliminar backup: ' . $e->getMessage());
            return redirect()->back()
                ->with('mensaje', 'Error al eliminar backup: ' . $e->getMessage())
                ->with('icono', 'error')
                ->with('showBtn', 'true')
                ->with('timer', '6000');
        }
    }

    /**
     * Descargar archivo de backup
     */
    public function download($filename)
    {
        try {
            $backupPath = storage_path('app/backups/' . basename($filename));
            
            if (file_exists($backupPath)) {
                Log::info('Backup descargado', [
                    'filename' => $filename,
                    'user' => Auth::user()->email
                ]);
                
                return response()->download($backupPath);
            } else {
                return redirect()->back()
                    ->with('mensaje', 'Archivo de backup no encontrado.')
                    ->with('icono', 'error')
                    ->with('showBtn', 'true')
                    ->with('timer', '4000');
            }
            
        } catch (\Exception $e) {
            Log::error('Error al descargar backup: ' . $e->getMessage());
            return redirect()->back()
                ->with('mensaje', 'Error al descargar backup: ' . $e->getMessage())
                ->with('icono', 'error')
                ->with('showBtn', 'true')
                ->with('timer', '6000');
        }
    }
}