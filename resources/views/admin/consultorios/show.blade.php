@extends('layouts.admin')

@section('content')

<div class="row">
    <h1>Consultorio {{$consultorio->nombre}}</h1>
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
                            <p>{{$consultorio->nombre}}</p>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4 position-relative">
                        <div class="form group">
                            <label for="numero">Número</label><b>*</b>
                            <p>{{$consultorio->numero}}</p>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="direccion">Dirección</label>
                            <p>{{$consultorio->direccion}}</p>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-3 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="telefono">Teléfono</label>
                            <p>{{$consultorio->telefono}}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 position-relative">
                        <div class="form group">
                            <label for="especialidad">Especialidad</label>
                            <p>{{$consultorio->especialidad}}</p>
                        </div>
                    </div>
                </div>
                <br>
                <div class="col-md-12 position-relative">
                    <div class="form-group">
                        <label for="observacion">Observación</label>
                        <p>{{$consultorio->observacion}}</p>
                    </div>
                </div>
            <br>
            <div class="form group">
                <a href="{{url('admin/consultorios')}}" class="btn btn-secondary">Volver</a>
            </div>
        </div>
    </div>
</div>

@endsection