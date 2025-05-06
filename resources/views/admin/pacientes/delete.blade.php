@extends('layouts.admin')

@section('content')

<div class="row">
    <h1>Paciente {{$paciente->apel_nombres}}</h1>
</div>

<div class="col-md-12">
    <div class="card card-outline card-danger">
        <div class="card-header">
            <h3 class="card-title">¿Desea eliminar este registro?</h3>
        </div>

        <div class="card-body">
            <form action="{{url('admin/pacientes/'.$paciente->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <div class="row">
                    <div>
                        <input id="nombrelocal" name="nombrelocal" type="hidden">
                        <input id="nombreprov" name="nombreprov" type="hidden">
                    </div>
                    <div class="col-md-5 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="apel_nombres">Apellidos y Nombres</label>
                            <p>{{strtoupper($paciente->apel_nombres)}}</p>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4 position-relative">
                        <div class="form group">
                            <label for="nacimiento">Nacimiento</label>
                            <p>{{$paciente->nacimiento}}</p>
                        </div>
                    </div>
                    <div class="col-md-1 col-sm-4 position-relative">
                        <div class="form-group">
                            <label for="sexo">Sexo</label>
                            <p>{{$paciente->sexo}}</p>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4 position-relative">
                        <div class="form-group">
                            <label for="tipo_documento">Tipo Doc.</label>
                            <p>{{$paciente->tipo_documento}}</p>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="num_documento">Documento</label>
                            <p>{{$paciente->num_documento}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="domicilio">Domicilio</label>
                            <p>{{$paciente->domicilio}}</p>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12 position-relative">
                        <div class="form-group">
                            <label for="provincia">Provincia</label>
                            <p>{{strtoupper($paciente->localidad->provincia ?? 'N/A')}}</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 position-relative">
                        <div class="form-group">
                            <label for="localidad">Localidad</label>
                            <p>{{strtoupper($paciente->localidad->localidad ?? 'N/A')}}</p>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12 position-relative">
                        <div class="form-group">
                            <label for="cod_postal">Cod.Postal</label>
                            <p>{{$paciente->localidad->cod_postal ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="telefono">Teléfono</label>
                            <p>{{$paciente->telefono}}</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 position-relative">
                        <div class="form group">
                            <label for="email">Email</label>
                            <p>{{$paciente->email}}</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 position-relative">
                        <div class="form-group">
                            <label for="obra_social">Obra Social</label>
                            <p>{{$paciente->obra_social}}</p>
                        </div>
                    </div>
                    <div class="col-md-1 col-sm-4 position-relative">
                        <div class="form-group">
                            <label for="plan_os">Plan</label>
                            <p>{{$paciente->plan_os}}</p>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="num_afiliado">Afiliado</label>
                            <p>{{$paciente->afiliado}}</p>
                        </div>
                    </div>
                    <div class="col-md-12 position-relative">
                        <div class="form-group">
                            <label for="observacion">Observación</label>
                            <p>{{$paciente->observacion}}</p>
                        </div>
                    </div>
                </div>
                <br>
                <div class="form group">
                    <a href="{{url('admin/pacientes')}}" class="btn btn-secondary">Volver</a>
                    <button type="submit" class="btn btn-danger">Eliminar Paciente</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection