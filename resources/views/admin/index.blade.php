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

    @can('admin.horarios.index')
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
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

<div class="row" style="margin-bottom: 15px;">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Calendario de atención</h3>
            </div>
            <br>
            <div class="row mb-3">
                <div class="col-md-3">
                    <select id="medico" class="form-control select2" style="width: 100%;">
                        <option value="">Seleccione un Consultorio</option>
                        @foreach($consultorios as $consultorio)
                        <option value="{{ $consultorio->id }}">{{ $consultorio->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="medico" class="form-control select2" style="width: 100%;">
                        <option value="">Seleccione una Práctica</option>
                        @foreach($practicas as $practica)
                        <option value="{{ $practica->id }}">{{ $practica->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="medico" class="form-control select2" style="width: 100%;">
                        <option value="">Seleccione un Médico</option>
                        @foreach($medicos as $medico)
                        <option value="{{ $medico->id }}">{{ $medico->apel_nombres }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-center">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Registrar Turno
                    </button>
                </div>
            </div>

            <form action="{{ url('admin/eventos/create') }}" method="POST">
                @csrf
                <!-- Modal fuera del row para evitar problemas de anidamiento -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Reserva de Turno</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class='col-md-12'>
                                        <div class="form-goup">
                                            <label for="medico">Seleccione un Médico</label>
                                            <select id="medico" class="form-control select2" style="width: 100%;">
                                                <option value="">Seleccione un Médico</option>
                                                @foreach($medicos as $medico)
                                                <option value="{{ $medico->id }}">{{ $medico->apel_nombres }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Enviar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="card-body">
                <div class="col-md-12">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
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
            events: function(fetchInfo, successCallback, failureCallback) {
                var medicoId = document.getElementById('medico').value;
                var url = "{{ url('admin/horarios/consultorios') }}/" + medicoId;

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        successCallback(data);
                    })
                    .catch(error => {
                        console.error('Error fetching events:', error);
                        failureCallback(error);
                    });
            },
        });
        calendar.render();
    });
</script>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS + Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


@endsection