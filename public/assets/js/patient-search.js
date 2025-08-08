/**
 * Manejo de búsqueda de pacientes
 */

/**
 * Busca un paciente por documento
 */
function buscarPaciente() {
    const documento = document.getElementById('documento').value.trim();
    const mensajeElement = document.getElementById('documento-mensaje');
    
    // Limpiar mensaje anterior
    mensajeElement.textContent = '';
    mensajeElement.className = 'form-text text-muted';
    
    if (documento === '') {
        return;
    }
    
    // Validar que el documento tenga al menos 6 dígitos
    if (documento.length < 6) {
        mensajeElement.textContent = '⚠ El documento debe tener al menos 6 dígitos';
        mensajeElement.className = 'form-text text-warning';
        return;
    }
    
    // Mostrar indicador de búsqueda
    mensajeElement.textContent = 'Buscando paciente...';
    mensajeElement.className = 'form-text text-info';
    
    // Hacer petición AJAX para buscar el paciente
    fetch(`${rutaBuscarPaciente}/${documento}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Datos recibidos:', data);
            if (data.success && data.paciente) {
                cargarDatosPaciente(data.paciente, mensajeElement);
            } else {
                limpiarDatosPacienteEncontrado(mensajeElement);
            }
        })
        .catch(error => {
            console.error('Error al buscar paciente:', error);
            mensajeElement.textContent = `✗ Error: ${error.message}`;
            mensajeElement.className = 'form-text text-danger';
        });
}

/**
 * Carga los datos del paciente encontrado en el formulario
 */
function cargarDatosPaciente(paciente, mensajeElement) {
    document.getElementById('tipo').value = paciente.tipo_documento || 'DNI';
    document.getElementById('nombre').value = paciente.apel_nombres || '';
    document.getElementById('email').value = paciente.email || emailUsuario;
    document.getElementById('telefono').value = paciente.telefono || '';

    // Buscar y seleccionar la obra social en el dropdown
    const obraSocialNombre = paciente.obra_social;
    let obraSocialEncontrada = false;
    
    // Si Select2 está disponible
    if (typeof $.fn.select2 !== 'undefined') {
        const $obraSocialSelect = $('#obra_social');
        $obraSocialSelect.find('option').each(function() {
            if ($(this).val() === obraSocialNombre) {
                $obraSocialSelect.val(obraSocialNombre).trigger('change');
                obraSocialEncontrada = true;
                return false; // break
            }
        });
        
        if (!obraSocialEncontrada && obraSocialNombre && obraSocialNombre !== 'Sin obra social') {
            $obraSocialSelect.val('').trigger('change');
        }
    } else {
        // Fallback sin Select2
        const obraSocialSelect = document.getElementById('obra_social');
        for (let i = 0; i < obraSocialSelect.options.length; i++) {
            if (obraSocialSelect.options[i].value === obraSocialNombre) {
                obraSocialSelect.selectedIndex = i;
                obraSocialEncontrada = true;
                break;
            }
        }
        
        if (!obraSocialEncontrada && obraSocialNombre && obraSocialNombre !== 'Sin obra social') {
            obraSocialSelect.selectedIndex = 0;
        }
    }
    
    // Mostrar mensaje de éxito
    mensajeElement.textContent = '✓ Paciente encontrado';
    mensajeElement.className = 'form-text text-success';
}

/**
 * Limpia los datos cuando no se encuentra el paciente
 */
function limpiarDatosPacienteEncontrado(mensajeElement) {
    document.getElementById('nombre').value = '';
    document.getElementById('email').value = emailUsuario;
    document.getElementById('telefono').value = '';
    
    // Limpiar obra social con Select2
    if (typeof $.fn.select2 !== 'undefined') {
        $('#obra_social').val('').trigger('change');
    } else {
        document.getElementById('obra_social').selectedIndex = 0;
    }
    
    mensajeElement.textContent = '⚠ Paciente no encontrado. Complete los datos manualmente.';
    mensajeElement.className = 'form-text text-warning';
}
