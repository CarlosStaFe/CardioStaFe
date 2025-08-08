/**
 * Manejo de reservas de turnos y eventos
 */

/**
 * Carga los datos de un evento para editar/visualizar
 */
function cargarEventoParaEditar(eventoId) {
    fetch(`${rutaEventos}/${eventoId}`)
        .then(response => response.json())
        .then(evento => {
            // Si es usuario con rol 'usuario' y el evento está reservado, no permitir acceso
            if (isUsuarioRole && evento.title === '- Reservado') {
                alert('No tiene permisos para ver este evento.');
                return;
            }
            
            llenarFormularioEvento(evento);
            configurarModalSegunEvento(evento);
            abrirModal();
        })
        .catch(error => {
            console.error('Error al cargar evento:', error);
            alert('Error al cargar los datos del evento');
        });
}

/**
 * Llena el formulario con los datos del evento
 */
function llenarFormularioEvento(evento) {
    document.getElementById('evento_id').value = evento.id;
    document.getElementById('form_method').value = 'PUT';
    document.getElementById('title').value = evento.title || '';
    document.getElementById('description').value = evento.description || '';
    
    // Formatear la fecha para el input date
    if (evento.start) {
        const fecha = new Date(evento.start);
        const fechaFormateada = fecha.getFullYear() + '-' + 
            String(fecha.getMonth() + 1).padStart(2, '0') + '-' + 
            String(fecha.getDate()).padStart(2, '0');
        document.getElementById('fecha_turno').value = fechaFormateada;
        
        // Formatear la hora para el input time
        const horaFormateada = String(fecha.getHours()).padStart(2, '0') + ':' + 
            String(fecha.getMinutes()).padStart(2, '0');
        document.getElementById('horario').value = horaFormateada;
    }
}

/**
 * Configura el modal según si el evento está reservado o disponible
 */
function configurarModalSegunEvento(evento) {
    if (evento.title === '- Reservado') {
        extraerDatosPacienteDeDescripcion(evento.description);
        configurarModalReservado();
    } else {
        configurarModalDisponible();
    }
    
    // Mostrar el botón eliminar solo si existe el botón y no es rol 'usuario'
    const eliminarBtn = document.getElementById('eliminarEventoBtn');
    if (eliminarBtn && !isUsuarioRole) {
        eliminarBtn.style.display = 'inline-block';
    } else if (eliminarBtn) {
        eliminarBtn.style.display = 'none';
    }
    
    // Cambiar la acción del formulario
    document.getElementById('eventoForm').action = `${rutaEventos}/${evento.id}`;
}

/**
 * Extrae datos del paciente de la descripción del evento
 */
function extraerDatosPacienteDeDescripcion(description) {
    if (description) {
        const lines = description.split('\n');
        lines.forEach(line => {
            if (line.startsWith('Paciente: ')) {
                document.getElementById('nombre').value = line.replace('Paciente: ', '').trim();
            } else if (line.startsWith('Documento: ')) {
                document.getElementById('documento').value = line.replace('Documento: ', '').trim();
            } else if (line.startsWith('Teléfono: ')) {
                document.getElementById('telefono').value = line.replace('Teléfono: ', '').trim();
            } else if (line.startsWith('Email: ')) {
                document.getElementById('email').value = line.replace('Email: ', '').trim();
            } else if (line.startsWith('Obra Social: ')) {
                const obraSocial = line.replace('Obra Social: ', '').trim();
                
                // Si Select2 está disponible
                if (typeof $.fn.select2 !== 'undefined') {
                    $('#obra_social').val(obraSocial).trigger('change');
                } else {
                    // Fallback sin Select2
                    const select = document.getElementById('obra_social');
                    for (let i = 0; i < select.options.length; i++) {
                        if (select.options[i].value === obraSocial) {
                            select.selectedIndex = i;
                            break;
                        }
                    }
                }
            }
        });
    }
}

/**
 * Configura el modal para un turno reservado
 */
function configurarModalReservado() {
    const tituloModal = `<b>* Turno Reservado * <br> Dr. ${medicoSeleccionado} <br> ${practicaSeleccionada} <br> ${consultorioSeleccionado}</b>`;
    document.getElementById('exampleModalLabel').innerHTML = tituloModal;
    
    // Ocultar botones de Reservar y Limpiar cuando está reservado
    document.getElementById('guardarEventoBtn').style.display = 'none';
    const limpiarBtn = document.querySelector('button[onclick="limpiarDatosPaciente()"]');
    if (limpiarBtn) {
        limpiarBtn.style.display = 'none';
    }
}

/**
 * Configura el modal para un turno disponible
 */
function configurarModalDisponible() {
    const tituloModal = `<b>* Reservar Turno * <br> Dr. ${medicoSeleccionado} <br> ${practicaSeleccionada} <br> ${consultorioSeleccionado}</b>`;
    document.getElementById('exampleModalLabel').innerHTML = tituloModal;
    
    // Mostrar botones de Reservar y Limpiar cuando está disponible
    document.getElementById('guardarEventoBtn').style.display = 'inline-block';
    const limpiarBtn = document.querySelector('button[onclick="limpiarDatosPaciente()"]');
    if (limpiarBtn) {
        limpiarBtn.style.display = 'inline-block';
    }
}

/**
 * Abre el modal de reserva
 */
function abrirModal() {
    const myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
    myModal.show();
}

/**
 * Reserva un turno
 */
function reservarTurno() {
    const eventoId = document.getElementById('evento_id').value;
    const documento = document.getElementById('documento').value;
    const nombre = document.getElementById('nombre').value;
    const email = document.getElementById('email').value;
    const telefono = document.getElementById('telefono').value;
    const obraSocial = document.getElementById('obra_social').value;
    const tipo = document.getElementById('tipo').value;
    
    console.log('Datos a enviar:', {
        evento_id: eventoId,
        documento: documento,
        nombre: nombre,
        email: email,
        telefono: telefono,
        obra_social: obraSocial,
        tipo: tipo
    });
    
    // Validar campos requeridos
    if (!documento || !nombre || !email || !telefono || !obraSocial) {
        alert('Por favor complete todos los campos requeridos.');
        return;
    }
    
    if (!eventoId) {
        alert('No hay un turno seleccionado para reservar.');
        return;
    }
    
    // Preparar datos para la reserva
    const formData = new FormData();
    formData.append('evento_id', eventoId);
    formData.append('fecha_turno', document.getElementById('fecha_turno').value);
    formData.append('horario', document.getElementById('horario').value);
    formData.append('tipo', tipo);
    formData.append('documento', documento);
    formData.append('nombre', nombre);
    formData.append('email', email);
    formData.append('telefono', telefono);
    formData.append('obra_social', obraSocial);
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    
    // Mostrar indicador de carga
    document.getElementById('guardarEventoBtn').disabled = true;
    document.getElementById('guardarEventoBtn').textContent = 'Reservando...';
    
    // Enviar solicitud de reserva
    fetch(rutaCrearEvento, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response redirected:', response.redirected);
        
        if (response.redirected) {
            console.log('Redirección detectada a:', response.url);
            window.location.href = response.url;
            return;
        }
        
        return response.text().then(text => {
            console.log('Response text:', text);
            try {
                return JSON.parse(text);
            } catch (e) {
                console.log('No es JSON, probablemente redirección HTML');
                window.location.reload();
                return null;
            }
        });
    })
    .then(data => {
        if (!data) return;
        
        console.log('Response data:', data);
        if (data && data.success) {
            alert('Turno reservado correctamente');
            const modal = bootstrap.Modal.getInstance(document.getElementById('exampleModal'));
            modal.hide();
            filtrarCalendario();
        } else if (data && data.error) {
            alert('Error: ' + data.error);
        } else {
            console.log('Respuesta inesperada, recargando página');
            window.location.reload();
        }
    })
    .catch(error => {
        console.error('Error en fetch:', error);
        alert('Error de conexión. La página se recargará.');
        window.location.reload();
    })
    .finally(() => {
        document.getElementById('guardarEventoBtn').disabled = false;
        document.getElementById('guardarEventoBtn').textContent = 'Reservar';
    });
}

/**
 * Elimina un evento
 */
function eliminarEvento() {
    const eventoId = document.getElementById('evento_id').value;
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    
    console.log('ID del evento a eliminar:', eventoId);
    console.log('CSRF Token encontrado:', csrfToken ? 'Sí' : 'No');
    
    if (!eventoId) {
        alert('No hay un evento seleccionado para eliminar');
        return;
    }
    
    if (!csrfToken) {
        alert('Token CSRF no encontrado');
        return;
    }
    
    if (confirm('¿Está seguro de que desea eliminar este turno? Esta acción no se puede deshacer.')) {
        const url = `${rutaEventos}/${eventoId}`;
        console.log('URL de eliminación:', url);
        
        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response ok:', response.ok);
            
            if (!response.ok) {
                return response.text().then(text => {
                    console.error('Response text:', text);
                    throw new Error(`HTTP ${response.status}: ${text}`);
                });
            }
            
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                alert('Turno eliminado correctamente');
                const modal = bootstrap.Modal.getInstance(document.getElementById('exampleModal'));
                modal.hide();
                filtrarCalendario();
            } else {
                alert('Error al eliminar el turno: ' + (data.message || 'Error desconocido'));
            }
        })
        .catch(error => {
            console.error('Error completo:', error);
            alert('Error al eliminar el turno: ' + error.message);
        });
    }
}
