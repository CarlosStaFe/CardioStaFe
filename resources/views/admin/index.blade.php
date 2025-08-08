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

<!-- Scripts JavaScript -->
<script src="{{ asset('assets/js/app-config.js') }}"></script>
<script src="{{ asset('assets/js/calendar-config.js') }}"></script>
<script src="{{ asset('assets/js/event-filters.js') }}"></script>
<script src="{{ asset('assets/js/patient-search.js') }}"></script>
<script src="{{ asset('assets/js/appointment-management.js') }}"></script>
<script src="{{ asset('assets/js/form-utils.js') }}"></script>

<script>
    // Inicializar variables globales al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        // Configuración inicial de la aplicación
        const config = {
            userRoles: @json(Auth::user()->roles->pluck('name')),
            isUsuarioRole: @json(Auth::user()->roles->pluck('name')).includes('usuario') && !@json(Auth::user()->roles->pluck('name')).includes('admin'),
            emailUsuario: '{{ Auth::user()->email }}',
            fechaHoy: '<?php echo date('Y-m-d'); ?>',
            horaActual: '<?php echo date('H:i'); ?>',
            rutaFiltrarEventos: '{{ route('admin.eventos.filtrar') }}',
            rutaBuscarPaciente: '{{ url('admin/pacientes/buscar') }}',
            rutaEventos: '{{ url("admin/eventos") }}',
            rutaCrearEvento: '{{ url("admin/eventos/create") }}'
        };
        
        // Inicializar la aplicación
        inicializarVariablesGlobales(config);
        inicializarAplicacion();
    });
</script>

@endsection