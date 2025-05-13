@extends('layouts.admin')

@section('content')

<div class="row">
    <h1>Práctica {{$practica->nombre}}</h1>
</div>

<div class="col-md-12">
    <div class="card card-outline card-success">
        <div class="card-header">
            <h3 class="card-title">Datos Registrados</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-5 col-sm-12 position-relative">
                    <div class="form group">
                        <label for="nombre">Nombre</label>
                        <p>{{$practica->nombre}}</p>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12 position-relative">
                    <div class="form-group">
                        <label for="observacion">Observación</label>
                            <p>{{$practica->observacion}}</p>
                    </div>
                </div>
            </div>
            <br>
            <div class="form group">
                <a href="{{url('admin/practicas')}}" class="btn btn-secondary">Volver</a>
            </div>
        </div>
    </div>
</div>

@endsection