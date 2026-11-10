# Guía de Troubleshooting - Reset de Contraseña

## ✅ Estado del Sistema
- Las migraciones están ejecutadas correctamente
- La tabla `password_reset_tokens` existe
- Las rutas de autenticación están configuradas
- El flujo de backend funciona correctamente

## 📋 Pasos para el Usuario

### 1. Solicitar Reset de Contraseña
1. Ir a la página de login
2. Hacer clic en "¿Olvidaste tu contraseña?"
3. Ingresar su email
4. Hacer clic en "Enviar Enlace de Restablecimiento"

### 2. Revisar Email
- **IMPORTANTE**: En desarrollo, los emails se guardan en `storage/logs/laravel.log`
- Buscar el enlace que contiene `/password/reset/`
- Copiar y pegar en el navegador

### 3. Establecer Nueva Contraseña
- La contraseña debe tener **mínimo 8 caracteres**
- Debe coincidir con la confirmación
- Evitar caracteres especiales complejos

### 4. Iniciar Sesión
- Usar el **email original**
- Usar la **nueva contraseña** (no la anterior)
- Si no funciona, repetir el proceso

## 🔧 Para Administradores

### Verificar Logs
```bash
tail -f storage/logs/laravel.log | grep "Password reset"
```

### Limpiar Cache
```bash
php artisan optimize:clear
```

### Verificar Usuario en BD
```bash
php artisan tinker
User::where('email', 'email@usuario.com')->first()
```