/**
 * Manejo de filtros y búsqueda de eventos
 */

/**
 * Filtra el calendario según los criterios seleccionados
 */
function filtrarCalendario() {
    const consultorio = document.getElementById('consultorio').value;
    const practica = document.getElementById('practica').value;
    const medico = document.getElementById('medico').value;

    // Validar que todos los filtros estén seleccionados
    if (consultorio === '0' || practica === '0' || medico === '0') {
        alert('Por favor, seleccione todos los filtros: consultorio, práctica y médico.');
        return;
    }

    // Guardar nombres del médico y práctica seleccionados
    medicoSeleccionado = document.getElementById('medico').selectedOptions[0].text;
    practicaSeleccionada = document.getElementById('practica').selectedOptions[0].text;
    consultorioSeleccionado = document.getElementById('consultorio').selectedOptions[0].text;

    // Mostrar indicador de carga
    const calendarioContainer = document.getElementById('calendario-container');
    calendarioContainer.style.display = 'block';
    calendarioContainer.innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Cargando calendario...</div>';

    // Hacer petición AJAX para obtener eventos filtrados
    const params = new URLSearchParams();
    if (consultorio !== '0') params.append('consultorio_id', consultorio);
    if (practica !== '0') params.append('practica_id', practica);
    if (medico !== '0') params.append('medico_id', medico);

    fetch(`${rutaFiltrarEventos}?${params.toString()}`)
        .then(response => response.json())
        .then(eventos => {
            console.log('Eventos recibidos del backend:', eventos);
            console.log('Total eventos recibidos:', eventos.length);
            
            // Contar eventos por tipo
            const disponibles = eventos.filter(e => e.title === '- Horario disponible').length;
            const reservados = eventos.filter(e => e.title === '- Reservado').length;
            console.log(`Eventos disponibles: ${disponibles}, Eventos reservados: ${reservados}`);
            
            // Mostrar eventos según el rol del usuario
            let eventosParaMostrar = filtrarEventosPorRol(eventos);
            
            // Crear el calendario con los nuevos eventos
            crearCalendarioConEventos(eventosParaMostrar);
        })
        .catch(error => {
            console.error('Error al cargar eventos:', error);
            calendarioContainer.innerHTML = '<div class="alert alert-danger">Error al cargar el calendario. Por favor, intente nuevamente.</div>';
        });
}

/**
 * Filtra eventos según el rol del usuario
 */
function filtrarEventosPorRol(eventos) {
    let eventosParaMostrar;
    
    if (isUsuarioRole) {
        // Solo mostrar eventos disponibles para usuarios con rol 'usuario'
        eventosParaMostrar = eventos.filter(evento => 
            evento.title === '- Horario disponible'
        );
        console.log('Usuario con rol "usuario": mostrando solo eventos disponibles');
        console.log('Eventos filtrados para mostrar:', eventosParaMostrar.length);
    } else {
        // Mostrar tanto eventos disponibles como reservados para admin y otros roles
        eventosParaMostrar = eventos.filter(evento => 
            evento.title === '- Horario disponible' || evento.title === '- Reservado'
        );
        console.log('Usuario admin: mostrando eventos disponibles y reservados');
        console.log('Eventos filtrados para mostrar:', eventosParaMostrar.length);
    }
    
    return eventosParaMostrar;
}

/**
 * Limpia los filtros del formulario
 */
function limpiarFiltros() {
    // Limpiar los select boxes con Select2
    if (typeof $.fn.select2 !== 'undefined') {
        $('#consultorio, #practica, #medico').val('0').trigger('change');
    } else {
        // Fallback si Select2 no está disponible
        document.getElementById('consultorio').value = '0';
        document.getElementById('practica').value = '0';
        document.getElementById('medico').value = '0';
    }
    
    // Limpiar variables globales
    medicoSeleccionado = '';
    practicaSeleccionada = '';
    consultorioSeleccionado = '';
    
    // Ocultar el calendario
    document.getElementById('calendario-container').style.display = 'none';
    
    // Si existe una instancia de calendario, destruirla
    if (calendar) {
        calendar.destroy();
    }
}
