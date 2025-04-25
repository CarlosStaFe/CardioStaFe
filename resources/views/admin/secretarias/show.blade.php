@extends('layouts.admin')

@section('content')

<div class="row">
    <h1>Secretaria {{$secretaria->apel_nombres}}</h1>
</div>

<div class="col-md-6">
    <div class="card card-outline card-success">
        <div class="card-header">
            <h3 class="card-title">Datos Registrados</h3>
        </div>

        <div class="card-body">
            <div class="form group">
                <label for="apelnombres">Appellidos y Nombres</label>
                <p>{{$secretaria->apel_nombres}}</p>
            </div>
            <br>
            <div class="form group">
                <label for="telefono">Teléfono</label>
                <p>{{$secretaria->telefono}}</p>
            </div>
            <br>
            <div class="form group">
                <label for="domicilio">Domicilio</label>
                <p>{{$secretaria->domicilio}}</p>
            </div>
            <br>
            <div class="form group">
                <label for="email">E-mail</label>
                <p>{{$secretaria->user->email}}</p>
            </div>
            <br>
            <div class="form group">
                <a href="{{url('admin/secretarias')}}" class="btn btn-success">Volver</a>
            </div>
        </div>
    </div>
</div>

@endsection