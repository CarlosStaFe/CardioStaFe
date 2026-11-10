<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php'; 
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== PASO 1: Verificando usuario admin@admin.com ===" . PHP_EOL;
$user = App\Models\User::where('email', 'admin@admin.com')->first();
if ($user) {
    echo 'Usuario encontrado: ' . $user->email . ' (ID: ' . $user->id . ')' . PHP_EOL;
} else {
    echo 'ERROR: Usuario no encontrado' . PHP_EOL;
    exit;
}

echo PHP_EOL . "=== PASO 2: Creando token de reset ===" . PHP_EOL;
use Illuminate\Support\Facades\Password;
$token = Password::createToken($user);
echo 'Token generado: ' . $token . PHP_EOL;
echo 'Longitud del token: ' . strlen($token) . PHP_EOL;

echo PHP_EOL . "=== PASO 3: Verificando token en base de datos ===" . PHP_EOL;
use Illuminate\Support\Facades\DB;
$resetRecord = DB::table('password_reset_tokens')->where('email', 'admin@admin.com')->first();
if ($resetRecord) {
    echo "Token guardado en DB:" . PHP_EOL;
    echo "- Email: " . $resetRecord->email . PHP_EOL;
    echo "- Token (primeros 20 chars): " . substr($resetRecord->token, 0, 20) . "..." . PHP_EOL;
    echo "- Creado: " . $resetRecord->created_at . PHP_EOL;
} else {
    echo "ERROR: No se encontró el token en la base de datos" . PHP_EOL;
}

echo PHP_EOL . "=== PASO 4: Intentando validar token ===" . PHP_EOL;
$credentials = [
    'email' => 'admin@admin.com',
    'password' => 'newpassword123',
    'password_confirmation' => 'newpassword123', 
    'token' => $token
];

try {
    $response = Password::reset($credentials, function ($user, $password) {
        echo "Callback ejecutado para usuario: " . $user->email . PHP_EOL;
        // Solo simulamos, no cambiamos realmente la contraseña
        return true;
    });
    echo "Respuesta del reset: " . $response . PHP_EOL;
} catch (Exception $e) {
    echo "Error durante reset: " . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . "=== PASO 5: Verificando logs ===" . PHP_EOL;
$logFile = storage_path('logs/laravel.log');
if (file_exists($logFile)) {
    $lines = file($logFile);
    $lastLines = array_slice($lines, -5);
    echo "Últimas 5 líneas del log:" . PHP_EOL;
    foreach ($lastLines as $line) {
        echo "  " . trim($line) . PHP_EOL;
    }
} else {
    echo "No se encontró archivo de log" . PHP_EOL;
}

echo PHP_EOL . "=== PRUEBA COMPLETADA ===" . PHP_EOL;
?>
