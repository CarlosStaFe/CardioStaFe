@extends('layouts.admin')

@section('content')

<div class="row">
    <h1>Panel Principal - {{Auth::user()->email}}</h1>
    <!-- <h3><b>Bienvenido:</b> {{Auth::user()->email}} / <b>Rol:</b> {{Auth::user()->roles->pluck('name')->first()}} </h3> -->
</div>

<hr>

<div class="row">
    @can('admin.usuarios.index')
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$total_usuarios}}</h3>
                    <p>Usuarios</p>
                </div>
                <div class="icon">
                    <i class="fas bi bi-person-badge"></i>
                </div>
                <a href="{{url('admin/usuarios')}}" class="small-box-footer">Más información <i class="fas bi bi-person-badge"></i></a>
            </div>
        </div>
    @endcan

    @can('admin.secretarias.index')
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{$total_secretarias}}</h3>
                    <p>Secretarias</p>
                </div>
                <div class="icon">
                    <i class="fas bi bi-person-circle"></i>
                </div>
                <a href="{{url('admin/secretarias')}}" class="small-box-footer">Más información <i class="fas bi bi-person-circle"></i></a>
            </div>
        </div>
    @endcan

    @can('admin.pacientes.index')
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{$total_pacientes}}</h3>
                    <p>Pacientes</p>
                </div>
                <div class="icon">
                    <i class="fas bi bi-person-fill-check"></i>
                </div>
                <a href="{{url('admin/pacientes')}}" class="small-box-footer">Más información <i class="fas bi bi-person-fill-check"></i></a>
            </div>
        </div>
    @endcan

    @can('admin.consultorios.index')
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{$total_consultorios}}</h3>
                    <p>Consultorios</p>
                </div>
                <div class="icon">
                    <i class="fas fa-solid fa-house-medical"></i>
                </div>
                <a href="{{url('admin/consultorios')}}" class="small-box-footer">Más información <i class="fas fa-solid fa-house-medical"></i></a>
            </div>
        </div>
    @endcan

    @can('admin.practicas.index')
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{$total_practicas}}</h3>
                    <p>Prácticas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-solid fa-suitcase-medical"></i>
                </div>
                <a href="{{url('admin/practicas')}}" class="small-box-footer">Más información <i class="fas fa-solid fa-suitcase-medical"></i></a>
            </div>
        </div>
    @endcan

    @can('admin.medicos.index')
        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{$total_medicos}}</h3>
                    <p>Médicos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-solid fa-stethoscope"></i>
                </div>
                <a href="{{url('admin/medicos')}}" class="small-box-footer">Más información <i class="fas fa-solid fa-stethoscope"></i></a>
            </div>
        </div>
    @endcan

    @can('admin.obrasociales.index')
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$total_obras_sociales}}</h3>
                    <p>Obras Sociales</p>
                </div>
                <div class="icon">
                    <i class="fas fa-solid fa-building-columns"></i>
                </div>
                <a href="{{url('admin/obrasociales')}}" class="small-box-footer">Más información <i class="fas fa-solid fa-building-columns"></i></a>
            </div>
        </div>
    @endcan

    @can('admin.horarios.index')
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{$total_horarios}}</h3>
                    <p>Horarios</p>
                </div>
                <div class="icon">
                    <i class="fas fa-solid fa-clock"></i>
                </div>
                <a href="{{url('admin/horarios')}}" class="small-box-footer">Más información <i class="fas fa-solid fa-clock"></i></a>
            </div>
        </div>
    @endcan

</div>

<!-- ***** CALENDARIO DE TURNOS ***** -->
<div class="row" style="margin-bottom: 15px;">
    <div class="col-md-12">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Calendario de atención</h3>
            </div>
            <br>
            <div class="row mb-3">
                <div class="col-md-3 ml-3">
                    <label for="consultorio">CONSULTORIOS</label>
                    <select id="consultorio" class="form-control select2" style="width: 100%;">
                        <option value="0">Seleccione un consultorio</option>
                        @foreach($consultorios as $consultorio)
                        <option value="{{ $consultorio->id }}">{{ $consultorio->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="practica">PRÁCTICAS</label>
                    <select id="practica" class="form-control select2" style="width: 100%;">
                        <option value="0">Seleccione una práctica</option>
                        @foreach($practicas as $practica)
                        <option value="{{ $practica->id }}">{{ $practica->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="medico">MÉDICOS</label>
                    <select id="medico" class="form-control select2" style="width: 100%;">
                        <option value="0">Seleccione un médico</option>
                        @foreach($medicos as $medico)
                        <option value="{{ $medico->id }}">{{ $medico->apel_nombres }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-center mt-4">
                    <button type="button" class="btn btn-primary ml-3 mr-2" id="buscarTurnoBtn" onclick="filtrarCalendario()">
                        Buscar Turno
                    </button>
                    <button type="button" class="btn btn-secondary" id="limpiarFiltrosBtn" onclick="limpiarFiltros()">
                        Limpiar
                    </button>
                </div>
            </div>

            <!-- ***** FORMULARIO DE RESERVA (MODAL) ***** -->
            <form action="{{ url('admin/eventos/create') }}" method="POST" id="eventoForm">
                @csrf
                <input type="hidden" id="evento_id" name="evento_id" value="">
                <input type="hidden" id="form_method" name="_method" value="">
                <input type="hidden" id="title" name="title" value="">
                <input type="hidden" id="description" name="description" value="">
                <!-- Modal fuera del row para evitar problemas de anidamiento -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel"><b>Reservar Turno</b></h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div>
                                <h4 class="ms-3" style="color: #1b5a10ff;">*** Datos del paciente ***</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class='col-md-4'>
                                        <div class="form-goup">
                                            <label for="fecha_turno" style="color: #08a1ddff;">Fecha Turno</label>
                                            <input type="date" class="form-control fw-bold" id="fecha_turno" value="<?php echo date('Y-m-d');?>" name="fecha_turno" readonly style="background-color: #d4edda; color: #080808ff;">
                                        </div>
                                    </div>
                                    <div class='col-md-4'>
                                        <div class="form-group">
                                            <label for="horario" style="color: #08a1ddff;">Horario</label>
                                            <input type="time" class="form-control fw-bold" id="horario" name="horario" value="<?php echo date('H:i');?>" readonly style="background-color: #d4edda; color: #080808ff;">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class='col-md-3'>
                                        <div class="form-goup">
                                            <label for="tipo">Tipo Doc.</label><b>*</b>
                                            <select class="form-control" id="tipo" name="tipo" required>
                                                <option value="DNI">DNI</option>
                                                <option value="CI">CI</option>
                                                <option value="PAS">PAS</option>
                                                <option value="LE">LE</option>
                                                <option value="LC">LC</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='col-md-9'>
                                        <div class="form-goup">
                                            <label for="documento">Documento</label><b>*</b>
                                            <input type="text" class="form-control" id="documento" name="documento" placeholder="Ingrese documento del paciente" required onblur="buscarPaciente()">
                                            <small id="documento-mensaje" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class='col-md-12'>
                                        <div class="form-goup">
                                            <label for="nombre">Apellido y Nombres</label><b>*</b>
                                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese nombre del paciente" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class='col-md-6'>
                                        <div class="form-goup">
                                            <label for="email">Email</label><b>*</b>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese email del paciente" required>
                                        </div>
                                    </div>
                                    <div class='col-md-6'>
                                        <div class="form-goup">
                                            <label for="telefono">Teléfono</label><b>*</b>
                                            <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Ingrese teléfono del paciente" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class='col-md-12'>
                                        <div class="form-goup">
                                            <label for="obra_social">Obra Social</label><b>*</b>
                                            <select class="form-control" id="obra_social" name="obra_social" required>
                                                <option value="" disabled selected>Seleccione una obra social</option>
                                                @foreach($obras_sociales as $obra_social)
                                                    <option value="{{ $obra_social->nombre }}">{{ $obra_social->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                @can('admin.eventos.destroy')
                                    <button type="button" class="btn btn-danger" id="eliminarEventoBtn" onclick="eliminarEvento()" style="display: none;">Eliminar</button>
                                @endcan
                                <button type="button" class="btn btn-warning" onclick="limpiarDatosPaciente()">Limpiar</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary" id="guardarEventoBtn">Reservar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="card-body" id="calendario-container" style="display: none;">
                <div class="col-md-12">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    // Variables globales del usuario
    const userRoles = @json(Auth::user()->roles->pluck('name'));
    const isUsuarioRole = userRoles.includes('usuario') && !userRoles.includes('admin');
    
    console.log('Roles del usuario:', userRoles);
    console.log('Es usuario con rol "usuario" exclusivo:', isUsuarioRole);

    let calendar; // Variable global para el calendario
    let medicoSeleccionado = ''; // Variable global para el médico seleccionado
    let practicaSeleccionada = ''; // Variable global para la práctica seleccionada
    let consultorioSeleccionado = ''; // Variable global para el consultorio seleccionado

    //***** INICIALIZA EL FORMULARIO EN BLANCO SIN MOSTRAR LOS TURNOS DISPONIBLES *****/
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar el calendario pero no renderizarlo todavía
        var calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            weekends: false,
            slotMinTime: '08:00:00',
            slotMaxTime: '20:00:00',
            dayMaxEvents: 3, // Limitar a 3 eventos por día, muestra "+ más" si hay más
            moreLinkClick: 'popover', // Muestra los eventos adicionales en un popover
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
            events: [], // Inicialmente sin eventos
            eventClick: function(info) {
                info.jsEvent.preventDefault();
                cargarEventoParaEditar(info.event.id);
            },
            editable: true,
            selectable: true,
            selectAllow: function(selectInfo) {
                // Permitir selección solo en días que tengan eventos
                const events = calendar.getEvents();
                const selectedDate = selectInfo.start.toISOString().split('T')[0];
                
                // Verificar si hay eventos en la fecha seleccionada
                const hasEvents = events.some(event => {
                    const eventDate = event.start.toISOString().split('T')[0];
                    return eventDate === selectedDate;
                });
                
                return hasEvents;
            },
            dayCellDidMount: function(info) {
                // Verificar si el día tiene eventos
                const events = calendar.getEvents();
                const cellDate = info.date.toISOString().split('T')[0];
                
                const hasEvents = events.some(event => {
                    const eventDate = event.start.toISOString().split('T')[0];
                    return eventDate === cellDate;
                });
                
                // Si no hay eventos, deshabilitar el día
                if (!hasEvents) {
                    info.el.style.backgroundColor = '#f8f9fa';
                    info.el.style.color = '#6c757d';
                    info.el.style.cursor = 'not-allowed';
                    info.el.style.opacity = '0.6';
                    info.el.title = 'No hay horarios disponibles';
                }
            },
            dateClick: function(info) {
                // Verificar si hay eventos en la fecha antes de abrir el modal
                const events = calendar.getEvents();
                const clickedDate = info.dateStr;
                
                const hasEvents = events.some(event => {
                    const eventDate = event.start.toISOString().split('T')[0];
                    return eventDate === clickedDate;
                });
                
                if (!hasEvents) {
                    alert('No hay horarios disponibles para esta fecha.');
                    return;
                }
                
                // Abrir modal para crear evento en la fecha seleccionada
                document.getElementById('fecha_turno').value = info.dateStr;
                var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
                myModal.show();
            }
        });
    });

    //***** FILTRAR LOS EVENTOS PARA MOSTRAR *****/
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

        fetch(`{{ route('admin.eventos.filtrar') }}?${params.toString()}`)
            .then(response => response.json())
            .then(eventos => {
                console.log('Eventos recibidos del backend:', eventos);
                console.log('Total eventos recibidos:', eventos.length);
                
                // Contar eventos por tipo
                const disponibles = eventos.filter(e => e.title === '- Horario disponible').length;
                const reservados = eventos.filter(e => e.title === '- Reservado').length;
                console.log(`Eventos disponibles: ${disponibles}, Eventos reservados: ${reservados}`);
                
                // Mostrar eventos según el rol del usuario
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
                
                // Restaurar el contenido del calendario
                calendarioContainer.innerHTML = '<div class="col-md-12"><div id="calendar"></div></div>';
                
                // Volver a inicializar el calendario con los nuevos eventos
                const calendarEl = document.getElementById('calendar');
                calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    weekends: false,
                    slotMinTime: '08:00:00',
                    slotMaxTime: '20:00:00',
                    dayMaxEvents: 3, // Limitar a 3 eventos por día, muestra "+ más" si hay más
                    moreLinkClick: 'popover', // Muestra los eventos adicionales en un popover
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
                        backgroundColor: evento.title === '- Horario disponible' ? '#28a745' : '#dc3545', // Verde para disponible, rojo para reservado
                        borderColor: evento.title === '- Horario disponible' ? '#1e7e34' : '#c82333',     // Borde acorde al estado
                        textColor: 'white',         // Color del texto
                        description: evento.description
                    })),
                    eventClick: function(info) {
                        info.jsEvent.preventDefault();
                        cargarEventoParaEditar(info.event.id);
                    },
                    editable: true,
                    selectable: true,
                    selectAllow: function(selectInfo) {
                        // Permitir selección solo en días que tengan eventos disponibles
                        const events = calendar.getEvents();
                        const selectedDate = selectInfo.start.toISOString().split('T')[0];
                        
                        // Verificar si hay eventos disponibles en la fecha seleccionada
                        const hasAvailableEvents = events.some(event => {
                            const eventDate = event.start.toISOString().split('T')[0];
                            return eventDate === selectedDate && event.title === '- Horario disponible';
                        });
                        
                        return hasAvailableEvents;
                    },
                    dayCellDidMount: function(info) {
                        // Verificar si el día tiene eventos disponibles y reservados según el rol
                        const events = calendar.getEvents();
                        const cellDate = info.date.toISOString().split('T')[0];
                        
                        const hasAvailableEvents = events.some(event => {
                            const eventDate = event.start.toISOString().split('T')[0];
                            return eventDate === cellDate && event.title === '- Horario disponible';
                        });
                        
                        let hasReservedEvents = false;
                        if (!isUsuarioRole) {
                            // Solo verificar eventos reservados si no es usuario con rol 'usuarios'
                            hasReservedEvents = events.some(event => {
                                const eventDate = event.start.toISOString().split('T')[0];
                                return eventDate === cellDate && event.title === '- Reservado';
                            });
                        }
                        
                        // Aplicar estilos según el estado del día
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
                            // Día sin turnos (o solo reservados para usuarios con rol 'usuarios')
                            info.el.style.backgroundColor = '#f8f9fa';
                            info.el.style.color = '#6c757d';
                            info.el.style.cursor = 'not-allowed';
                            info.el.style.opacity = '0.6';
                            info.el.title = 'No hay horarios disponibles';
                        }
                    },
                    dateClick: function(info) {
                        // Verificar si hay eventos disponibles en la fecha antes de abrir el modal
                        const events = calendar.getEvents();
                        const clickedDate = info.dateStr;
                        
                        const hasAvailableEvents = events.some(event => {
                            const eventDate = event.start.toISOString().split('T')[0];
                            return eventDate === clickedDate && event.title === '- Horario disponible';
                        });
                        
                        if (!hasAvailableEvents) {
                            alert('No hay horarios disponibles para esta fecha.');
                            return;
                        }
                        
                        // Actualizar título del modal con médico y práctica
                        const tituloModal = `<b>* Reservar Turno * <br> Dr. ${medicoSeleccionado}  <br>  ${practicaSeleccionada} <br>  ${consultorioSeleccionado}</b>`;
                        document.getElementById('exampleModalLabel').innerHTML = tituloModal;
                        
                        // Abrir modal para crear evento en la fecha seleccionada
                        document.getElementById('fecha_turno').value = info.dateStr;
                        var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
                        myModal.show();
                    }
                });
                
                calendar.render();
            })
            .catch(error => {
                console.error('Error al cargar eventos:', error);
                calendarioContainer.innerHTML = '<div class="alert alert-danger">Error al cargar el calendario. Por favor, intente nuevamente.</div>';
            });
    }

    //***** BUSCAR PACIENTE POR DOCUMENTO *****/
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
        fetch(`{{ url('admin/pacientes/buscar') }}/${documento}`, {
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
                    // Paciente encontrado - llenar los campos
                    const paciente = data.paciente;
                    
                    document.getElementById('tipo').value = paciente.tipo_documento || 'DNI';
                    document.getElementById('nombre').value = paciente.apel_nombres || '';
                    document.getElementById('email').value = paciente.email || '{{ Auth::user()->email }}';
                    document.getElementById('telefono').value = paciente.telefono || '';

                    // Buscar y seleccionar la obra social en el dropdown
                    const obraSocialSelect = document.getElementById('obra_social');
                    const obraSocialNombre = paciente.obra_social;
                    let obraSocialEncontrada = false;
                    
                    for (let i = 0; i < obraSocialSelect.options.length; i++) {
                        if (obraSocialSelect.options[i].value === obraSocialNombre) {
                            obraSocialSelect.selectedIndex = i;
                            obraSocialEncontrada = true;
                            break;
                        }
                    }
                    
                    // Si no se encuentra la obra social exacta, seleccionar la primera opción por defecto
                    if (!obraSocialEncontrada && obraSocialNombre && obraSocialNombre !== 'Sin obra social') {
                        obraSocialSelect.selectedIndex = 0; // Opción "Seleccione una obra social"
                    }
                    
                    // Mostrar mensaje de éxito
                    mensajeElement.textContent = '✓ Paciente encontrado';
                    mensajeElement.className = 'form-text text-success';
                    
                } else {
                    // Paciente no encontrado - limpiar campos y mostrar mensaje
                    document.getElementById('nombre').value = '';
                    document.getElementById('email').value = '{{ Auth::user()->email }}';
                    document.getElementById('telefono').value = '';
                    document.getElementById('obra_social').selectedIndex = 0;
                    
                    mensajeElement.textContent = '⚠ Paciente no encontrado. Complete los datos manualmente.';
                    mensajeElement.className = 'form-text text-warning';
                }
            })
            .catch(error => {
                console.error('Error al buscar paciente:', error);
                mensajeElement.textContent = `✗ Error: ${error.message}`;
                mensajeElement.className = 'form-text text-danger';
            });
    }

    //***** LIMPIAR LOS FILTROS DEL FORMULARIO *****/
    function limpiarFiltros() {
        // Limpiar los select boxes
        document.getElementById('consultorio').value = '0';
        document.getElementById('practica').value = '0';
        document.getElementById('medico').value = '0';
        
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

    //***** CARGA EL EVENTO SELECCIONADO PARA RESERVAR *****/
    function cargarEventoParaEditar(eventoId) {
        // Hacer petición AJAX para obtener los datos del evento
        fetch(`{{ url('admin/eventos') }}/${eventoId}`)
            .then(response => response.json())
            .then(evento => {
                // Si es usuario con rol 'usuarios' y el evento está reservado, no permitir acceso
                if (isUsuarioRole && evento.title === '- Reservado') {
                    alert('No tiene permisos para ver este evento.');
                    return;
                }
                
                // Llenar el formulario con los datos del evento
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
                
                // Verificar si el evento ya está reservado
                if (evento.title === '- Reservado') {
                    // Extraer datos del paciente de la descripción si está reservado
                    if (evento.description) {
                        const lines = evento.description.split('\n');
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
                                const select = document.getElementById('obra_social');
                                for (let i = 0; i < select.options.length; i++) {
                                    if (select.options[i].value === obraSocial) {
                                        select.selectedIndex = i;
                                        break;
                                    }
                                }
                            }
                        });
                    }
                    
                    // Cambiar título del modal para turno reservado
                    const tituloModal = `<b>* Turno Reservado * <br> Dr. ${medicoSeleccionado} <br> ${practicaSeleccionada} <br> ${consultorioSeleccionado}</b>`;
                    document.getElementById('exampleModalLabel').innerHTML = tituloModal;
                    document.getElementById('guardarEventoBtn').textContent = 'Ver Datos';
                    document.getElementById('guardarEventoBtn').disabled = true;
                } else {
                    // Cambiar el título del modal y el texto del botón para reserva
                    const tituloModal = `<b>* Reservar Turno * <br> Dr. ${medicoSeleccionado} <br> ${practicaSeleccionada} <br> ${consultorioSeleccionado}</b>`;
                    document.getElementById('exampleModalLabel').innerHTML = tituloModal;
                    document.getElementById('guardarEventoBtn').textContent = 'Reservar';
                    document.getElementById('guardarEventoBtn').disabled = false;
                }
                
                // Mostrar el botón eliminar solo si existe el botón (el usuario tiene permisos) y no es rol 'usuarios'
                const eliminarBtn = document.getElementById('eliminarEventoBtn');
                if (eliminarBtn && !isUsuarioRole) {
                    eliminarBtn.style.display = 'inline-block';
                } else if (eliminarBtn) {
                    eliminarBtn.style.display = 'none';
                }
                
                // Cambiar la acción del formulario
                document.getElementById('eventoForm').action = `{{ url("admin/eventos") }}/${evento.id}`;
                
                // Abrir el modal
                var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
                myModal.show();
            })
            .catch(error => {
                console.error('Error al cargar evento:', error);
                alert('Error al cargar los datos del evento');
            });
    }

    // Evento para limpiar el formulario cuando se cierra el modal
    document.getElementById('exampleModal').addEventListener('hidden.bs.modal', function() {
        limpiarFormulario();
    });

    //***** LIMPIAR SOLO LOS DATOS DEL PACIENTE *****/
    function limpiarDatosPaciente() {
        // Limpiar solo los campos de datos del paciente, manteniendo fecha y horario
        document.getElementById('tipo').value = 'DNI';
        document.getElementById('documento').value = '';
        document.getElementById('nombre').value = '';
        document.getElementById('email').value = '';
        document.getElementById('telefono').value = '';
        document.getElementById('obra_social').selectedIndex = 0; // Restablece a "Seleccione una obra social"
        
        // Limpiar mensaje de búsqueda de paciente
        const mensajeElement = document.getElementById('documento-mensaje');
        if (mensajeElement) {
            mensajeElement.textContent = '';
            mensajeElement.className = 'form-text text-muted';
        }
    }

    //***** LIMPIAR EL FORMULARIO MODAL COMPLETO *****/
    function limpiarFormulario() {
        // Limpiar campos del formulario
        document.getElementById('evento_id').value = '';
        document.getElementById('form_method').value = '';
        document.getElementById('title').value = '';
        document.getElementById('description').value = '';
        document.getElementById('fecha_turno').value = '<?php echo date('Y-m-d'); ?>';
        document.getElementById('horario').value = '<?php echo date('H:i'); ?>';
        document.getElementById('tipo').value = 'DNI';
        document.getElementById('documento').value = '';
        document.getElementById('nombre').value = '';
        document.getElementById('email').value = '';
        document.getElementById('telefono').value = '';
        document.getElementById('obra_social').selectedIndex = 0; // Restablece a "Seleccione una obra social"
        
        // Limpiar mensaje de búsqueda
        const mensajeElement = document.getElementById('documento-mensaje');
        if (mensajeElement) {
            mensajeElement.textContent = '';
            mensajeElement.className = 'form-text text-muted';
        }
        
        // Restaurar el título del modal y el texto del botón
        document.getElementById('exampleModalLabel').innerHTML = '<b>Reservar Turno</b>';
        document.getElementById('guardarEventoBtn').textContent = 'Reservar';
        document.getElementById('guardarEventoBtn').disabled = false;
        
        // Ocultar el botón eliminar
        const eliminarBtn = document.getElementById('eliminarEventoBtn');
        if (eliminarBtn) {
            eliminarBtn.style.display = 'none';
        }
        
        // Restaurar la acción del formulario
        document.getElementById('eventoForm').action = '{{ url("admin/eventos/create") }}';
    }

    // Manejar el envío del formulario
    document.getElementById('eventoForm').addEventListener('submit', function(e) {
        e.preventDefault();
        reservarTurno();
    });

    //***** FUNCIÓN PARA RESERVAR TURNO *****/
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
        fetch('{{ url("admin/eventos/create") }}', {
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
                // Si hay redirección, seguirla
                console.log('Redirección detectada a:', response.url);
                window.location.href = response.url;
                return;
            }
            
            // Intentar parsear como JSON
            return response.text().then(text => {
                console.log('Response text:', text);
                try {
                    return JSON.parse(text);
                } catch (e) {
                    // Si no es JSON válido, probablemente sea una redirección HTML
                    console.log('No es JSON, probablemente redirección HTML');
                    window.location.reload();
                    return null;
                }
            });
        })
        .then(data => {
            if (!data) return; // Ya se procesó como redirección
            
            console.log('Response data:', data);
            if (data && data.success) {
                alert('Turno reservado correctamente');
                var modal = bootstrap.Modal.getInstance(document.getElementById('exampleModal'));
                modal.hide();
                // Recargar el calendario
                filtrarCalendario();
            } else if (data && data.error) {
                alert('Error: ' + data.error);
            } else {
                // Si llegamos aquí, algo salió mal
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
            // Restaurar el botón
            document.getElementById('guardarEventoBtn').disabled = false;
            document.getElementById('guardarEventoBtn').textContent = 'Reservar';
        });
    }

    //***** FUNCIÓN PARA ELIMINAR EVENTO *****/
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
        
        // Confirmar la eliminación
        if (confirm('¿Está seguro de que desea eliminar este turno? Esta acción no se puede deshacer.')) {
            const url = `{{ url("admin/eventos") }}/${eventoId}`;
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
                    var modal = bootstrap.Modal.getInstance(document.getElementById('exampleModal'));
                    modal.hide();
                    // Recargar el calendario
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

</script>

@endsection