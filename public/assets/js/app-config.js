/**
 * Configuración principal de la aplicación
 * Variables globales y inicialización
 */

// Variables globales del usuario
let userRoles;
let isUsuarioRole;
let emailUsuario;

// Variables de fechas
let fechaHoy;
let horaActual;

// Rutas de la aplicación
let rutaFiltrarEventos;
let rutaBuscarPaciente;
let rutaEventos;
let rutaCrearEvento;

/**
 * Inicializa las variables globales de la aplicación
 */
function inicializarVariablesGlobales(config) {
    // Configurar variables de usuario
    userRoles = config.userRoles;
    isUsuarioRole = config.isUsuarioRole;
    emailUsuario = config.emailUsuario;
    
    // Configurar fechas
    fechaHoy = config.fechaHoy;
    horaActual = config.horaActual;
    
    // Configurar rutas
    rutaFiltrarEventos = config.rutaFiltrarEventos;
    rutaBuscarPaciente = config.rutaBuscarPaciente;
    rutaEventos = config.rutaEventos;
    rutaCrearEvento = config.rutaCrearEvento;
    
    console.log('Roles del usuario:', userRoles);
    console.log('Es usuario con rol "usuario" exclusivo:', isUsuarioRole);
}

/**
 * Inicializa la aplicación cuando el DOM está listo
 */
function inicializarAplicacion() {
    inicializarCalendario();
    inicializarSelect2();
    configurarEventos();
}

/**
 * Inicializa Select2 para los elementos select
 */
function inicializarSelect2() {
    // Inicializar Select2 con tema Bootstrap 5
    if (typeof $.fn.select2 !== 'undefined') {
        $('#consultorio, #practica, #medico, #obra_social').select2({
            theme: 'bootstrap-5',
            width: '100%'
        });
    }
}

/**
 * Configura los event listeners
 */
function configurarEventos() {
    // Evento para limpiar el formulario cuando se cierra el modal
    document.getElementById('exampleModal').addEventListener('hidden.bs.modal', function() {
        limpiarFormulario();
    });

    // Manejar el envío del formulario
    document.getElementById('eventoForm').addEventListener('submit', function(e) {
        e.preventDefault();
        reservarTurno();
    });
}
