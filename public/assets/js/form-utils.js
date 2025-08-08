/**
 * Funciones utilitarias para el manejo del formulario
 */

/**
 * Limpia solo los datos del paciente
 */
function limpiarDatosPaciente() {
    document.getElementById('tipo').value = 'DNI';
    document.getElementById('documento').value = '';
    document.getElementById('nombre').value = '';
    document.getElementById('email').value = '';
    document.getElementById('telefono').value = '';
    
    // Limpiar obra social con Select2
    if (typeof $.fn.select2 !== 'undefined') {
        $('#obra_social').val('').trigger('change');
    } else {
        document.getElementById('obra_social').selectedIndex = 0;
    }
    
    const mensajeElement = document.getElementById('documento-mensaje');
    if (mensajeElement) {
        mensajeElement.textContent = '';
        mensajeElement.className = 'form-text text-muted';
    }
}

/**
 * Limpia el formulario modal completo
 */
function limpiarFormulario() {
    document.getElementById('evento_id').value = '';
    document.getElementById('form_method').value = '';
    document.getElementById('title').value = '';
    document.getElementById('description').value = '';
    document.getElementById('fecha_turno').value = fechaHoy;
    document.getElementById('horario').value = horaActual;
    
    limpiarDatosPaciente();
    
    document.getElementById('exampleModalLabel').innerHTML = '<b>Reservar Turno</b>';
    document.getElementById('guardarEventoBtn').textContent = 'Reservar';
    document.getElementById('guardarEventoBtn').disabled = false;
    
    const eliminarBtn = document.getElementById('eliminarEventoBtn');
    if (eliminarBtn) {
        eliminarBtn.style.display = 'none';
    }
    
    document.getElementById('eventoForm').action = rutaCrearEvento;
}
