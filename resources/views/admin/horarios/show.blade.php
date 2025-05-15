@extends('layouts.admin')

@section('content')

<div class="row">
    <h1>Horarios {{$horario->fecha_inicio}} al {{$horario->fecha_fin}}</h1>
</div>

<div class="col-md-12">
    <div class="card card-outline card-success">
        <div class="card-header">
            <h3 class="card-title">Datos Registrados</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-3 col-sm-12 position-relative">
                    <div class="form group">
                        <label for="medico">Médico</label>
                            <p>{{$horario->medico->nombre}}</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-12 position-relative">
                    <div class="form group">
                        <label for="medico">Consultorio</label>
                            <p>{{$horario->consultorio->nombre}}</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-12 position-relative">
                    <div class="form group">
                        <label for="medico">Práctica Médica</label>
                            <p>{{$horario->practica->nombre}}</p>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-3 col-sm-12 position-relative">
                    <div class="form-group">
                        <label for="dias">Días de la Semana</label>
                        <div>             
                            @foreach (['LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO', 'DOMINGO'] as $dia)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="{{ $dia }}" value="{{ $dia }}" disabled
                                        {{ in_array($dia, $diasSeleccionados) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ $dia }}">{{ $dia }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-2 col-sm-12 position-relative">
                    <div class="form group">
                        <label for="fecha_inicio">Desde Fecha</label>
                            <p>{{$horario->fecha_inicio}}</p>
                    </div>
                </div>
                <div class="col-md-2 col-sm-12 position-relative">
                    <div class="form group">
                        <label for="fecha_fin">Hasta Fecha</label>
                            <p>{{$horario->fecha_fin}}</p>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-2 col-sm-12 position-relative">
                    <div class="form group">
                        <label for="hora_inicio">Hora Inicio</label>
                            <p>{{$horario->hora_inicio}}</p>
                    </div>
                </div>
                <div class="col-md-2 col-sm-12 position-relative">
                    <div class="form group">
                        <label for="hora_fin">Hora Final</label>
                            <p>{{$horario->hora_fin}}</p>
                    </div>
                </div>
                <div class="col-md-2 col-sm-12 position-relative">
                    <div class="form group">
                        <label for="rango">Rango Turno</label>
                            <p>{{$horario->rango}}</p>
                    </div>
                </div>
            </div>
            <br>

            <div class="form group">
                <a href="{{url('admin/horarios')}}" class="btn btn-secondary">Volver</a>
            </div>
        </div>
    </div>
</div>

@endsection