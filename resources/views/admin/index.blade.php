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

    @can('admin.eventos.index')
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{$total_reservas}}</h3>
                    <p>Reservas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-solid fa-clock"></i>
                </div>
                <a href="{{url('admin/eventos')}}" class="small-box-footer">Más información <i class="fas fa-solid fa-clock"></i></a>
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
                <div class="col-md-4">
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
                </div>
            </div>

            <div class="card-body">
                <div id="calendar"></div>
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

<style>
    .is-warning {
        border-color: #ffc107 !important;
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25) !important;
    }
    
    .text-warning {
        color: #856404 !important;
    }
    
    #documento-mensaje {
        margin-top: 0.25rem;
        font-size: 0.875em;
    }
    
    .form-control.is-valid {
        border-color: #198754;
        box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
    }
    
    .form-control.is-invalid {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
</style>

<script>
    // Manejo global de errores para detectar problemas de extensiones
    window.addEventListener('error', function(e) {
        console.warn('Error detectado:', e.message);
        // No mostrar alerta para errores de extensiones
        if (e.message && e.message.includes('listener indicated an asynchronous response')) {
            console.warn('Error relacionado con extensiones del navegador - ignorado');
            return false;
        }
    });

    // Función auxiliar para manejar fetch de manera segura
    function safeFetch(url, options = {}) {
        return fetch(url, {
            ...options,
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                ...options.headers
            }
        }).then(response => {
            if (!response.ok) {
                throw new Error(`Error HTTP ${response.status}: ${response.statusText}`);
            }
            return response.json();
        }).catch(error => {
            console.error('Error en fetch:', error);
            throw error;
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar el calendario
        var calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            weekends: false,
            slotMinTime: '08:00:00',
            slotMaxTime: '20:00:00',
            // dayMaxEvents: 3,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: ''
            },
            buttonText: {
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                day: 'Día'
            },
            eventClick: function(info) {
                // Manejar clic en evento
                var evento = info.event;
                
                if (evento.title === '- Horario disponible') {
                    // Es un horario disponible, abrir modal para reservar
                    document.getElementById('evento_id').value = evento.id;
                    document.getElementById('fecha_turno').value = evento.start.toISOString().split('T')[0];
                    document.getElementById('horario').value = evento.start.toTimeString().slice(0, 5);
                    
                    // Limpiar formulario
                    limpiarFormularioReserva();
                    
                    // Mostrar modal
                    var modal = new bootstrap.Modal(document.getElementById('exampleModal'));
                    modal.show();
                } else if (evento.title === '- Reservado') {
                    // Es un turno reservado, mostrar información
                    alert('Turno reservado\n\nInformación:\n' + (evento.extendedProps.description || 'Sin detalles adicionales'));
                } else {
                    console.log('Evento:', evento.title);
                }
            }
        });
        calendar.render();
        
        // Establecer DNI como tipo por defecto al cargar la página
        document.getElementById('tipo').value = 'DNI';
    });

    function limpiarFormularioReserva() {
        document.getElementById('tipo').value = 'DNI';
        document.getElementById('documento').value = '';
        document.getElementById('nombre').value = '';
        document.getElementById('email').value = '';
        document.getElementById('telefono').value = '';
        document.getElementById('obra_social').value = '';
        
        // Limpiar mensaje de documento
        var mensaje = document.getElementById('documento-mensaje');
        if (mensaje) {
            mensaje.textContent = '';
            mensaje.className = 'form-text text-muted';
        }
        
        // Limpiar clases de validación
        var campos = document.querySelectorAll('#exampleModal input, #exampleModal select');
        campos.forEach(function(campo) {
            campo.classList.remove('is-valid', 'is-invalid');
        });
    }

    function filtrarCalendario() {
        var consultorio = document.getElementById('consultorio').value;
        var practica = document.getElementById('practica').value;
        var medico = document.getElementById('medico').value;

        if (consultorio == 0 && practica == 0 && medico == 0) {
            alert('Por favor, seleccione un consultorio, una práctica o un médico para filtrar el calendario.');
            return;
        }

        // Mostrar el contenedor del calendario
        document.getElementById('calendario-container').style.display = 'block';

        // Construir URL con parámetros
        var url = '{{ url("admin/eventos/filtrar") }}';
        var params = [];
        
        if (consultorio != 0) params.push('consultorio_id=' + consultorio);
        if (practica != 0) params.push('practica_id=' + practica);
        if (medico != 0) params.push('medico_id=' + medico);

        if (params.length > 0) {
            url += '?' + params.join('&');
        }

        // Cargar eventos filtrados desde el servidor usando safeFetch
        safeFetch(url)
        .then(eventos => {
            // Limpiar eventos actuales
            calendar.removeAllEvents();

            if (eventos && eventos.length > 0) {
                // Filtrar solo los eventos disponibles y futuros (no mostrar anteriores a hoy)
                let hoy = new Date();
                hoy.setHours(0,0,0,0);
                let eventosDisponibles = eventos.filter(e => {
                    if (e.title !== '- Horario disponible') return false;
                    let fechaEvento = new Date(e.start);
                    fechaEvento.setHours(0,0,0,0);
                    return fechaEvento >= hoy;
                });
                // Ordenar por fecha y hora ascendente
                eventosDisponibles.sort((a, b) => new Date(a.start) - new Date(b.start));

                // Agrupar y limitar a 3 por día de forma robusta
                let eventosPorDia = {};
                eventosDisponibles.forEach(evento => {
                    // Obtener solo la fecha (YYYY-MM-DD) sin hora
                    let fechaCompleta = evento.start || '';
                    let fecha = '';
                    if (fechaCompleta.includes('T')) {
                        fecha = fechaCompleta.split('T')[0];
                    } else if (fechaCompleta.length >= 10) {
                        fecha = fechaCompleta.substring(0, 10);
                    }
                    if (!fecha) return;
                    if (!eventosPorDia[fecha]) {
                        eventosPorDia[fecha] = [];
                    }
                    eventosPorDia[fecha].push(evento);
                });
                // Limitar a solo 3 eventos por día
                Object.keys(eventosPorDia).forEach(fecha => {
                    if (eventosPorDia[fecha].length > 3) {
                        eventosPorDia[fecha] = eventosPorDia[fecha].slice(0, 3);
                    }
                });
                // Mostrar por consola el agrupamiento por día y cuántos se agregan
                Object.keys(eventosPorDia).forEach(fecha => {
                    console.log('Fecha:', fecha, 'Eventos agregados:', eventosPorDia[fecha].length, eventosPorDia[fecha]);
                });

                // Agregar al calendario solo los eventos seleccionados
                let horariosDisponiblesMostrados = 0;
                Object.values(eventosPorDia).forEach(arr => {
                    arr.forEach(evento => {
                        calendar.addEvent({
                            id: evento.id,
                            title: evento.title,
                            start: evento.start,
                            end: evento.end,
                            color: evento.color,
                            description: evento.description,
                            extendedProps: {
                                consultorio_id: evento.consultorio_id,
                                practica_id: evento.practica_id,
                                medico_id: evento.medico_id
                            }
                        });
                        horariosDisponiblesMostrados++;
                    });
                });
                console.log('Total eventos agregados al calendario:', horariosDisponiblesMostrados);

                if (horariosDisponiblesMostrados === 0) {
                    alert('No se encontraron horarios disponibles con los filtros seleccionados.');
                }
            } else {
                alert('No se encontraron eventos con los filtros seleccionados.');
            }
        })
        .catch(error => {
            console.error('Error al cargar eventos:', error);
            alert('Error al cargar los eventos. Por favor, inténtelo nuevamente.');
        });
    }

    function buscarPaciente() {
        var documento = document.getElementById('documento').value.trim();
        var tipo = document.getElementById('tipo').value;
        
        if (!documento) {
            return;
        }
        
        // Limpiar el documento de puntos, guiones y espacios extra
        var documentoLimpio = documento.replace(/[.\-\s]/g, '');
        
        // Mostrar indicador de búsqueda
        var mensaje = document.getElementById('documento-mensaje');
        if (mensaje) {
            mensaje.textContent = 'Buscando paciente...';
            mensaje.className = 'form-text text-info';
        }
        
        var url = '{{ url("admin/pacientes/buscar") }}?documento=' + encodeURIComponent(documentoLimpio) + '&tipo=' + encodeURIComponent(tipo);
        
        safeFetch(url)
        .then(data => {
            var mensaje = document.getElementById('documento-mensaje');
            var documentoInput = document.getElementById('documento');
            
            if (data.encontrado) {
                // Paciente encontrado, llenar datos
                document.getElementById('nombre').value = data.paciente.apel_nombres || '';
                document.getElementById('email').value = data.paciente.email || '';
                document.getElementById('telefono').value = data.paciente.telefono || '';
                document.getElementById('obra_social').value = data.paciente.obra_social || '';
                
                // Actualizar el tipo si es diferente
                if (data.paciente.tipo_documento && data.paciente.tipo_documento !== tipo) {
                    document.getElementById('tipo').value = data.paciente.tipo_documento;
                }
                
                if (mensaje) {
                    mensaje.textContent = '✓ Paciente encontrado: ' + data.paciente.apel_nombres;
                    mensaje.className = 'form-text text-success';
                }
                documentoInput.classList.remove('is-invalid', 'is-warning');
                documentoInput.classList.add('is-valid');
            } else {
                // Paciente no encontrado, limpiar campos excepto documento y tipo
                document.getElementById('nombre').value = '';
                document.getElementById('email').value = '';
                document.getElementById('telefono').value = '';
                document.getElementById('obra_social').selectedIndex = 0; // Resetear select
                
                if (mensaje) {
                    mensaje.textContent = 'ℹ Paciente no encontrado. Complete los datos para crear uno nuevo.';
                    mensaje.className = 'form-text text-warning';
                }
                documentoInput.classList.remove('is-invalid', 'is-valid');
                documentoInput.classList.add('is-warning');
                
                // Enfocar el campo nombre para continuar
                document.getElementById('nombre').focus();
            }
        })
        .catch(error => {
            console.error('Error al buscar paciente:', error);
            var mensaje = document.getElementById('documento-mensaje');
            if (mensaje) {
                mensaje.textContent = '✗ Error al buscar el paciente. Intente nuevamente.';
                mensaje.className = 'form-text text-danger';
            }
            document.getElementById('documento').classList.add('is-invalid');
        });
    }

    function eliminarEvento() {
        if (!confirm('¿Está seguro de que desea eliminar este evento?')) {
            return;
        }
        
        var eventoId = document.getElementById('evento_id').value;
        if (!eventoId) {
            alert('No se pudo identificar el evento a eliminar');
            return;
        }
        
        safeFetch('{{ url("admin/eventos") }}/' + eventoId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(data => {
            if (data.success) {
                // Cerrar modal
                var modal = bootstrap.Modal.getInstance(document.getElementById('exampleModal'));
                if (modal) {
                    modal.hide();
                }
                
                // Recargar eventos en el calendario
                filtrarCalendario();
                
                alert('Evento eliminado exitosamente');
            } else {
                alert('Error al eliminar el evento: ' + (data.message || 'Error desconocido'));
            }
        })
        .catch(error => {
            console.error('Error al eliminar evento:', error);
            alert('Error al eliminar el evento. Por favor, inténtelo nuevamente.');
        });
    }
</script>

@endsection