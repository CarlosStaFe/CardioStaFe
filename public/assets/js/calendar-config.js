/**
 * Configuración y manejo del calendario FullCalendar
 */

// Variables globales del calendario
let calendar;
let medicoSeleccionado = '';
let practicaSeleccionada = '';
let consultorioSeleccionado = '';

/**
 * Inicializa el calendario básico sin eventos
 */
function inicializarCalendario() {
    const calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        weekends: false,
        slotMinTime: '08:00:00',
        slotMaxTime: '20:00:00',
        dayMaxEvents: 3,
        moreLinkClick: 'popover',
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        buttonText: {
            today: 'Hoy',
            month: 'Mes',
            week: 'Semana',
            day: 'Día'
        },
        events: [],
        eventClick: function(info) {
            info.jsEvent.preventDefault();
            cargarEventoParaEditar(info.event.id);
        },
        editable: true,
        selectable: true,
        selectAllow: function(selectInfo) {
            const events = calendar.getEvents();
            const selectedDate = selectInfo.start.toISOString().split('T')[0];
            
            const hasEvents = events.some(event => {
                const eventDate = event.start.toISOString().split('T')[0];
                return eventDate === selectedDate;
            });
            
            return hasEvents;
        },
        dayCellDidMount: function(info) {
            const events = calendar.getEvents();
            const cellDate = info.date.toISOString().split('T')[0];
            
            const hasEvents = events.some(event => {
                const eventDate = event.start.toISOString().split('T')[0];
                return eventDate === cellDate;
            });
            
            if (!hasEvents) {
                info.el.style.backgroundColor = '#f8f9fa';
                info.el.style.color = '#6c757d';
                info.el.style.cursor = 'not-allowed';
                info.el.style.opacity = '0.6';
                info.el.style.pointerEvents = 'none';
                info.el.title = 'No hay horarios disponibles';
            }
        },
        dateClick: function(info) {
            const events = calendar.getEvents();
            const clickedDate = info.dateStr;
            
            const hasEvents = events.some(event => {
                const eventDate = event.start.toISOString().split('T')[0];
                return eventDate === clickedDate;
            });
            
            if (!hasEvents) {
                return;
            }
            
            document.getElementById('fecha_turno').value = info.dateStr;
            const myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
            myModal.show();
        }
    });
}

/**
 * Crea un nuevo calendario con eventos filtrados
 */
function crearCalendarioConEventos(eventosParaMostrar) {
    const calendarioContainer = document.getElementById('calendario-container');
    calendarioContainer.innerHTML = '<div class="col-md-12"><div id="calendar"></div></div>';
    
    const calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        weekends: false,
        slotMinTime: '08:00:00',
        slotMaxTime: '20:00:00',
        dayMaxEvents: 3,
        moreLinkClick: 'popover',
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        buttonText: {
            today: 'Hoy',
            month: 'Mes',
            week: 'Semana',
            day: 'Día'
        },
        events: eventosParaMostrar.map(evento => ({
            id: evento.id,
            title: evento.title,
            start: evento.start,
            end: evento.end,
            backgroundColor: evento.title === '- Horario disponible' ? '#28a745' : '#dc3545',
            borderColor: evento.title === '- Horario disponible' ? '#1e7e34' : '#c82333',
            textColor: 'white',
            description: evento.description
        })),
        eventClick: function(info) {
            info.jsEvent.preventDefault();
            cargarEventoParaEditar(info.event.id);
        },
        editable: true,
        selectable: true,
        selectAllow: function(selectInfo) {
            const events = calendar.getEvents();
            const selectedDate = selectInfo.start.toISOString().split('T')[0];
            
            const hasAvailableEvents = events.some(event => {
                const eventDate = event.start.toISOString().split('T')[0];
                return eventDate === selectedDate && event.title === '- Horario disponible';
            });
            
            return hasAvailableEvents;
        },
        dayCellDidMount: function(info) {
            aplicarEstilosCelda(info);
        },
        dateClick: function(info) {
            const events = calendar.getEvents();
            const clickedDate = info.dateStr;
            
            const hasAvailableEvents = events.some(event => {
                const eventDate = event.start.toISOString().split('T')[0];
                return eventDate === clickedDate && event.title === '- Horario disponible';
            });
            
            if (!hasAvailableEvents) {
                return;
            }
            
            const tituloModal = `<b>* Reservar Turno * <br> Dr. ${medicoSeleccionado}  <br>  ${practicaSeleccionada} <br>  ${consultorioSeleccionado}</b>`;
            document.getElementById('exampleModalLabel').innerHTML = tituloModal;
            
            document.getElementById('fecha_turno').value = info.dateStr;
            const myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
            myModal.show();
        }
    });
    
    calendar.render();
}

/**
 * Aplica estilos a las celdas del calendario según el tipo de eventos
 */
function aplicarEstilosCelda(info) {
    const events = calendar.getEvents();
    const cellDate = info.date.toISOString().split('T')[0];
    
    const hasAvailableEvents = events.some(event => {
        const eventDate = event.start.toISOString().split('T')[0];
        return eventDate === cellDate && event.title === '- Horario disponible';
    });
    
    let hasReservedEvents = false;
    if (!isUsuarioRole) {
        hasReservedEvents = events.some(event => {
            const eventDate = event.start.toISOString().split('T')[0];
            return eventDate === cellDate && event.title === '- Reservado';
        });
    }
    
    if (hasAvailableEvents && hasReservedEvents) {
        // Día con turnos disponibles y reservados (solo para admin)
        info.el.style.backgroundColor = '#fff3cd';
        info.el.style.border = '2px solid #ffc107';
        info.el.title = 'Día con turnos disponibles y reservados';
    } else if (hasAvailableEvents) {
        // Día solo con turnos disponibles
        info.el.style.backgroundColor = '#d1f2eb';
        info.el.style.border = '2px solid #28a745';
        info.el.title = 'Día con turnos disponibles';
    } else if (hasReservedEvents && !isUsuarioRole) {
        // Día solo con turnos reservados (solo para admin)
        info.el.style.backgroundColor = '#f8d7da';
        info.el.style.border = '2px solid #dc3545';
        info.el.style.cursor = 'not-allowed';
        info.el.style.opacity = '0.8';
        info.el.title = 'Día con todos los turnos reservados';
    } else {
        // Día sin turnos (o solo reservados para usuarios con rol 'usuario')
        info.el.style.backgroundColor = '#f8f9fa';
        info.el.style.color = '#6c757d';
        info.el.style.cursor = 'not-allowed';
        info.el.style.opacity = '0.6';
        info.el.style.pointerEvents = 'none';
        info.el.title = 'No hay horarios disponibles';
    }
}
