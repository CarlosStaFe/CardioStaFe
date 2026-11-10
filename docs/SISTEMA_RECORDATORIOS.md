# Sistema de Recordatorios Automáticos - Email y SMS

## 📧 Estado Actual
✅ **Email ya funciona** - El sistema envía automáticamente emails 2 días antes de cada turno

## 📱 Nueva Funcionalidad: SMS
✅ **SMS implementado** - Ahora también envía SMS junto con el email

---

## ⚙️ Configuración Necesaria

### 1. Variables de Entorno (.env)

Agregue estas variables a su archivo `.env`:

```env
# Configuración de Email (ya existente)
MAIL_MAILER=smtp
MAIL_HOST=su_servidor_smtp
MAIL_PORT=587
MAIL_USERNAME=su_email@dominio.com
MAIL_PASSWORD=su_password_smtp
MAIL_ENCRYPTION=tls

# Configuración de Twilio para SMS (NUEVO)
TWILIO_SID=your_twilio_account_sid
TWILIO_AUTH_TOKEN=your_twilio_auth_token
TWILIO_PHONE_NUMBER=+1234567890
TWILIO_WHATSAPP_NUMBER=whatsapp:+14155238886
```

### 2. Cuenta de Twilio

1. **Crear cuenta en Twilio**: https://www.twilio.com
2. **Obtener credenciales**:
   - Account SID (TWILIO_SID)
   - Auth Token (TWILIO_AUTH_TOKEN)
3. **Comprar número de teléfono** para SMS (TWILIO_PHONE_NUMBER)
4. **Opcional**: Configurar WhatsApp Business

---

## 🔄 Funcionamiento Automático

### Scheduler Configurado
- **Comando**: `eventos:recordatorio`
- **Frecuencia**: Diariamente a las 21:30
- **Acción**: Envía recordatorios para turnos de dentro de 2 días

### Proceso Automático
1. **21:30 cada día** → Sistema busca turnos para pasado mañana
2. **Para cada turno encontrado**:
   - ✅ Envía **EMAIL** si el paciente tiene email
   - ✅ Envía **SMS** si el paciente tiene teléfono y Twilio configurado
3. **Registra logs** de envíos exitosos y errores

---

## 🛠️ Comandos de Gestión

### Verificar Estado del Sistema
```bash
php artisan mensajeria:estado
```
**Muestra**:
- ✅/❌ Configuración de email
- ✅/❌ Configuración de SMS  
- 📅 Próximos recordatorios programados
- ⚠️ Recomendaciones de configuración

### Probar Envío de SMS
```bash
# Probar recordatorio
php artisan sms:probar [evento_id]

# Probar mensaje de suspensión  
php artisan sms:probar [evento_id] --tipo=suspension
```

### Ejecutar Recordatorios Manualmente
```bash
php artisan eventos:recordatorio
```

---

## 📝 Tipos de Mensajes

### 📧 Email de Recordatorio
- **Plantilla**: `resources/views/emails/recordatorio_evento.blade.php`
- **Incluye**: Logo, datos del turno, información del médico

### 📱 SMS de Recordatorio
```
🏥 RECORDATORIO DE TURNO

Hola [Paciente],
Le recordamos su turno:

📅 Fecha: 25/04/2026
🕐 Hora: 10:30
👩‍⚕️ Médico: Dr. García
🩺 Práctica: Cardiología

Por favor llegue 15 min antes.
¡Gracias por confiar en nosotros!
```

### 🚫 Notificaciones de Suspensión
Cuando se suspende un turno, **automáticamente**:
- ✅ Envía email de suspensión
- ✅ Envía SMS de suspensión

---

## ✅ Ventajas del Sistema

### Para la Clínica
- 📉 **Reduce inasistencias** - Recordatorios automáticos 2 días antes
- ⚡ **Doble canal** - Email + SMS para mayor alcance
- 🤖 **Completamente automático** - No requiere intervención manual
- 📊 **Logs detallados** - Seguimiento de envíos y errores

### Para los Pacientes
- 📧 **Email detallado** con toda la información del turno
- 📱 **SMS inmediato** que llega al celular
- 🔔 **Notificaciones de suspensión** automáticas
- ⏰ **Recordatorio oportuno** 2 días antes

---

## 🎯 Próximos Pasos

1. **Configurar Twilio**: Crear cuenta y obtener credenciales
2. **Actualizar .env**: Agregar variables de Twilio  
3. **Probar sistema**: Usar `php artisan mensajeria:estado`
4. **Hacer prueba**: Usar `php artisan sms:probar [evento_id]`
5. **¡Funciona automáticamente!** 🚀

---

## 💡 Notas Importantes

- **Costos**: SMS tienen costo por mensaje (aprox. $0.01-0.05 USD c/u)
- **Horarios**: Recordatorios se envían a las 21:30 (configurable)
- **Fallback**: Si SMS falla, email sigue funcionando
- **Logs**: Todos los envíos se registran en `storage/logs/laravel.log`