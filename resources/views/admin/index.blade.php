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
                <!-- Modal fuera del row para evitar problemas de anidamiento -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Reserva de Turno - Datos del Paciente</h1>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class='col-md-6'>
                                        <div class="form-goup">
                                            <label for="fecha_turno">Fecha Turno</label>
                                            <input type="date" class="form-control" id="fecha_turno" value="<?php echo date('Y-m-d');?>" name="fecha_turno" required>
                                            <!-- Validamos que la fecha no sea menor -->
                                            <script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    const fechaTurnoInput = document.getElementById('fecha_turno');
                                                    fechaTurnoInput.addEventListener('change', function() {
                                                        const fechaSeleccionada = new Date(fechaTurnoInput.value);
                                                        const hoy = new Date();
                                                        if (fechaSeleccionada < hoy) {
                                                            alert('La fecha seleccionada no puede ser anterior a hoy.');
                                                            fechaTurnoInput.value = '';
                                                        }
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </div>
                                    <div class='col-md-6'>
                                        <div class="form-group">
                                            <label for="title">Título del Evento</label>
                                            <input type="text" class="form-control" id="title" name="title" placeholder="Título del evento">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class='col-md-12'>
                                        <div class="form-group">
                                            <label for="description">Descripción</label>
                                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Descripción del evento"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class='col-md-6'>
                                        <div class="form-goup">
                                            <label for="tipo">Tipo Documento</label>
                                            <select class="form-control" id="tipo" name="tipo" required>
                                                <option value="DNI">DNI</option>
                                                <option value="CI">CI</option>
                                                <option value="PAS">PAS</option>
                                                <option value="LE">LE</option>
                                                <option value="LC">LC</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='col-md-6'>
                                        <div class="form-goup">
                                            <label for="documento">Documento</label>
                                            <input type="text" class="form-control" id="documento" name="documento" placeholder="Ingrese el documento del paciente" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-danger" id="eliminarEventoBtn" style="display: none;" onclick="eliminarEvento()">Eliminar</button>
                                <button type="submit" class="btn btn-primary" id="guardarEventoBtn">Registrar</button>
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
    let calendar; // Variable global para el calendario

    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar el calendario pero no renderizarlo todavía
        var calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            weekends: false,
            startTime: '08:00',
            endTime: '20:00',
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
            dateClick: function(info) {
                // Abrir modal para crear evento en la fecha seleccionada
                document.getElementById('fecha_turno').value = info.dateStr;
                $('#exampleModal').modal('show');
            }
        });
    });

    function filtrarCalendario() {
        const consultorio = document.getElementById('consultorio').value;
        const practica = document.getElementById('practica').value;
        const medico = document.getElementById('medico').value;

        // Validar que al menos un filtro esté seleccionado
        if (consultorio === '0' || practica === '0' || medico === '0') {
            alert('Por favor, seleccione todos los filtros: consultorio, práctica y médico.');
            return;
        }

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
                // Restaurar el contenido del calendario
                calendarioContainer.innerHTML = '<div class="col-md-12"><div id="calendar"></div></div>';
                
                // Volver a inicializar el calendario con los nuevos eventos
                const calendarEl = document.getElementById('calendar');
                calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    weekends: false,
                    startTime: '08:00',
                    endTime: '20:00',
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
                    events: eventos.map(evento => ({
                        id: evento.id,
                        title: evento.title,
                        start: evento.start,
                        end: evento.end,
                        color: evento.color,
                        description: evento.description
                    })),
                    eventClick: function(info) {
                        info.jsEvent.preventDefault();
                        cargarEventoParaEditar(info.event.id);
                    },
                    editable: true,
                    selectable: true,
                    dateClick: function(info) {
                        // Abrir modal para crear evento en la fecha seleccionada
                        document.getElementById('fecha_turno').value = info.dateStr;
                        $('#exampleModal').modal('show');
                    }
                });
                
                calendar.render();
            })
            .catch(error => {
                console.error('Error al cargar eventos:', error);
                calendarioContainer.innerHTML = '<div class="alert alert-danger">Error al cargar el calendario. Por favor, intente nuevamente.</div>';
            });
    }

    function limpiarFiltros() {
        // Limpiar los select boxes
        document.getElementById('consultorio').value = '0';
        document.getElementById('practica').value = '0';
        document.getElementById('medico').value = '0';
        
        // Ocultar el calendario
        document.getElementById('calendario-container').style.display = 'none';
        
        // Si existe una instancia de calendario, destruirla
        if (calendar) {
            calendar.destroy();
        }
    }

    function cargarEventoParaEditar(eventoId) {
        // Hacer petición AJAX para obtener los datos del evento
        fetch(`{{ url('admin/eventos') }}/${eventoId}`)
            .then(response => response.json())
            .then(evento => {
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
                }
                
                // Cambiar el título del modal y el texto del botón
                document.getElementById('exampleModalLabel').textContent = 'Editar Evento';
                document.getElementById('guardarEventoBtn').textContent = 'Actualizar';
                document.getElementById('eliminarEventoBtn').style.display = 'inline-block';
                
                // Cambiar la acción del formulario
                document.getElementById('eventoForm').action = `{{ url("admin/eventos") }}/${evento.id}`;
                
                // Abrir el modal
                $('#exampleModal').modal('show');
            })
            .catch(error => {
                console.error('Error al cargar evento:', error);
                alert('Error al cargar los datos del evento');
            });
    }

    function limpiarFormulario() {
        // Limpiar campos del formulario
        document.getElementById('evento_id').value = '';
        document.getElementById('form_method').value = '';
        document.getElementById('title').value = '';
        document.getElementById('description').value = '';
        document.getElementById('fecha_turno').value = '<?php echo date('Y-m-d'); ?>';
        document.getElementById('tipo').value = 'DNI';
        document.getElementById('documento').value = '';
        
        // Restaurar el título del modal y el texto del botón
        document.getElementById('exampleModalLabel').textContent = 'Reserva de Turno - Datos del Paciente';
        document.getElementById('guardarEventoBtn').textContent = 'Registrar';
        document.getElementById('eliminarEventoBtn').style.display = 'none';
        
        // Restaurar la acción del formulario
        document.getElementById('eventoForm').action = '{{ url("admin/eventos/create") }}';
    }

    function eliminarEvento() {
        const eventoId = document.getElementById('evento_id').value;
        if (confirm('¿Está seguro de que desea eliminar este evento?')) {
            // Aquí puedes agregar la lógica para eliminar el evento
            console.log('Eliminando evento:', eventoId);
            // Por ahora solo cerrar el modal
            $('#exampleModal').modal('hide');
        }
    }

    // Evento para limpiar el formulario cuando se cierra el modal
    $('#exampleModal').on('hidden.bs.modal', function() {
        limpiarFormulario();
    });

    // Manejar el envío del formulario
    document.getElementById('eventoForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const eventoId = document.getElementById('evento_id').value;
        const isEditing = eventoId !== '';
        
        if (isEditing) {
            // Actualizar evento existente
            const formData = new FormData(this);
            formData.append('_method', 'PUT');
            
            fetch(`{{ url("admin/eventos") }}/${eventoId}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Evento actualizado correctamente');
                    $('#exampleModal').modal('hide');
                    // Recargar el calendario
                    filtrarCalendario();
                } else {
                    alert('Error al actualizar el evento');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al actualizar el evento');
            });
        } else {
            // Crear nuevo evento - enviar el formulario normalmente
            this.submit();
        }
    });
</script>

@endsection