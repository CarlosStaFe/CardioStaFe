# Organización JavaScript - Sistema de Reserva de Turnos Médicos

## Estructura de Archivos

El código JavaScript del sistema se ha organizado en módulos separados para mejorar la mantenibilidad y organización:

### `/public/assets/js/`

#### `app-config.js`
- **Propósito**: Configuración principal y variables globales de la aplicación
- **Contiene**:
  - Variables globales del usuario (roles, permisos)
  - Configuración de fechas y rutas
  - Inicialización de la aplicación
  - Configuración de event listeners globales
  - **Inicialización de Select2** para elementos de formulario

#### `calendar-config.js`
- **Propósito**: Configuración y manejo del calendario FullCalendar
- **Contiene**:
  - Inicialización del calendario básico
  - Creación de calendarios con eventos filtrados
  - Aplicación de estilos a las celdas según tipo de eventos
  - Manejo de interacciones del calendario

#### `event-filters.js`
- **Propósito**: Manejo de filtros y búsqueda de eventos
- **Contiene**:
  - Filtrado del calendario por consultorio, práctica y médico
  - Filtrado de eventos según rol del usuario
  - Limpieza de filtros con **soporte para Select2**
  - Manejo de estados de carga

#### `patient-search.js`
- **Propósito**: Búsqueda y manejo de datos de pacientes
- **Contiene**:
  - Búsqueda de pacientes por documento
  - Carga automática de datos del paciente encontrado
  - Validación de documentos
  - Manejo de mensajes de estado
  - **Integración con Select2** para obra social

#### `appointment-management.js`
- **Propósito**: Gestión de reservas y eventos del calendario
- **Contiene**:
  - Carga y edición de eventos
  - Reserva de turnos médicos
  - Eliminación de eventos
  - Configuración de modales según tipo de evento
  - Manejo de datos del formulario de reserva
  - **Soporte para Select2** en extracción de datos

#### `form-utils.js`
- **Propósito**: Utilidades para manejo de formularios
- **Contiene**:
  - Limpieza de datos de pacientes
  - Limpieza del formulario completo
  - Funciones de utilidad para campos del formulario
  - **Gestión de Select2** en limpieza de campos

### `/public/assets/css/`

#### `custom-select2.css`
- **Propósito**: Estilos personalizados para Select2
- **Contiene**:
  - Estilos Bootstrap 5 compatibles
  - Mejoras visuales para las flechas desplegables
  - Estilos para dropdown y opciones
  - Consistencia visual con el resto del formulario

## Flujo de Inicialización

1. **DOMContentLoaded**: Se ejecuta `app-config.js`
2. **Configuración**: Se inicializan variables globales desde Laravel
3. **Calendario**: Se inicializa el calendario básico
4. **Select2**: Se inicializan los elementos select con mejoras visuales
5. **Event Listeners**: Se configuran los manejadores de eventos

## Variables Globales Compartidas

- `userRoles`: Roles del usuario actual
- `isUsuarioRole`: Indica si es usuario con rol limitado
- `emailUsuario`: Email del usuario logueado
- `fechaHoy`, `horaActual`: Valores de fecha y hora actuales
- `rutaFiltrarEventos`, `rutaBuscarPaciente`, `rutaEventos`, `rutaCrearEvento`: URLs de la API

## Dependencias

- **FullCalendar v6.1.17**: Biblioteca principal del calendario
- **Bootstrap 5**: Para modales y componentes UI
- **Select2 v4.1.0**: Para mejores elementos select con búsqueda
- **Select2 Bootstrap 5 Theme**: Tema visual integrado
- **jQuery**: Requerido para Select2 y otras funcionalidades
- **Laravel Routes**: Integración con rutas del backend

## Nuevas Características - Select2

### Funcionalidades Agregadas:
- ✅ **Flechas desplegables visibles** en todos los select
- ✅ **Búsqueda integrada** en elementos select
- ✅ **Tema Bootstrap 5** consistente
- ✅ **Limpieza automática** de valores
- ✅ **Selección programática** desde JavaScript
- ✅ **Estilos personalizados** para mejor apariencia

### Select2 se aplica a:
- Selector de consultorios
- Selector de prácticas médicas  
- Selector de médicos
- Selector de obra social

## Beneficios de esta Organización

1. **Mantenibilidad**: Código separado por funcionalidad
2. **Reutilización**: Funciones modulares pueden reutilizarse
3. **Debugging**: Más fácil identificar y corregir errores
4. **Colaboración**: Diferentes desarrolladores pueden trabajar en módulos específicos
5. **Escalabilidad**: Facilita la adición de nuevas funcionalidades
6. **UX Mejorada**: Select2 proporciona mejor experiencia de usuario

## Uso

Los archivos se cargan automáticamente en `index.blade.php` en el orden correcto:

```html
<script src="{{ asset('assets/js/app-config.js') }}"></script>
<script src="{{ asset('assets/js/calendar-config.js') }}"></script>
<script src="{{ asset('assets/js/event-filters.js') }}"></script>
<script src="{{ asset('assets/js/patient-search.js') }}"></script>
<script src="{{ asset('assets/js/appointment-management.js') }}"></script>
<script src="{{ asset('assets/js/form-utils.js') }}"></script>
```

Los estilos se cargan en el `<head>` del layout:

```html
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<link href="{{ asset('assets/css/custom-select2.css') }}" rel="stylesheet" />
```
