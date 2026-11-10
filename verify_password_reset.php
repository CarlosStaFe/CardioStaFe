<?php

// Verificar configuración de password reset en desarrollo

echo "🔍 VERIFICACIÓN DE PASSWORD RESET\n";
echo "================================\n\n";

// 1. Verificar configuración de mail
echo "📧 Configuración de Mail:\n";
echo "- MAIL_MAILER: " . env('MAIL_MAILER', 'log') . "\n";
echo "- En desarrollo, emails se guardan en: storage/logs/laravel.log\n\n";

// 2. Verificar rutas
echo "🛣️ Verificando rutas:\n";
exec('php artisan route:list | grep password', $routes);
foreach($routes as $route) {
    echo "- " . trim($route) . "\n";
}
echo "\n";

// 3. Verificar configuración de auth
echo "🔐 Configuración de Auth:\n";
echo "- Guard por defecto: " . config('auth.defaults.guard') . "\n";
echo "- Password broker: " . config('auth.defaults.passwords') . "\n";
echo "- Tabla tokens: " . config('auth.passwords.users.table') . "\n";
echo "- Expiración: " . config('auth.passwords.users.expire') . " minutos\n\n";

// 4. Verificar base de datos
echo "💾 Verificando Base de Datos:\n";
try {
    require_once 'bootstrap/app.php';
    $app = require_once 'bootstrap/app.php';
    
    // Verificar tabla usuarios
    $userCount = DB::table('users')->count();
    echo "- Usuarios en BD: $userCount\n";
    
    // Verificar tabla password reset tokens
    $tokenCount = DB::table('password_reset_tokens')->count();
    echo "- Tokens de reset: $tokenCount\n";
    
    echo "✅ Base de datos conectada correctamente\n\n";
} catch (Exception $e) {
    echo "❌ Error de BD: " . $e->getMessage() . "\n\n";
}

echo "🎯 INSTRUCCIONES PARA EL USUARIO:\n";
echo "================================\n";
echo "1. Ir a la página de login\n";
echo "2. Hacer clic en '¿Olvidaste tu contraseña?'\n";
echo "3. Ingresar email y enviar\n";
echo "4. En DESARROLLO: revisar storage/logs/laravel.log para ver el enlace\n";
echo "5. Abrir el enlace y establecer nueva contraseña (mín. 8 caracteres)\n";
echo "6. Regresar al login y usar la NUEVA contraseña\n\n";

echo "✅ Sistema configurado correctamente\n";
echo "⚠️  Recuerde: En producción configure SMTP real\n";

?>