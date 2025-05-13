@extends('layouts.admin')

@section('content')

<div class="row">
    <h1>Práctica {{$practica->nombre}}</h1>
</div>

<div class="col-md-12">
    <div class="card card-danger">
        <div class="card-header">
            <h3 class="card-title">¿Desea eliminar este registro?</h3>
        </div>

        <div class="card-body">
            <form action="{{url('admin/practicas/'.$practica->id)}}" method="POST">
                @csrf
                @method('DELETE')
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
                    <button type="submit" class="btn btn-danger">Eliminar Consultorio</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection