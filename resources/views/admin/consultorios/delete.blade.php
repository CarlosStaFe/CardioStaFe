@extends('layouts.admin')

@section('content')

<div class="row">
    <h1>Consultorio {{$consultorio->nombre}}</h1>
</div>

<div class="col-md-12">
    <div class="card card-danger">
        <div class="card-header">
            <h3 class="card-title">¿Desea eliminar este registro?</h3>
        </div>

        <div class="card-body">
            <form action="{{url('admin/consultorios/'.$consultorio->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <div class="row">
                    <div class="col-md-3 col-sm-12 position-relative">
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
                    <div class="col-md-4 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="direccion">Dirección</label>
                            <p>{{$consultorio->direccion}}</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="telefono">Teléfono</label>
                            <p>{{$consultorio->telefono}}</p>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12 position-relative">
                        <div class="form-group">
                            <label for="observacion">Observación</label>
                            <p>{{$consultorio->observacion}}</p>
                        </div>
                    </div>
                </div>
                <br>
                <div class="form group">
                    <a href="{{url('admin/consultorios')}}" class="btn btn-secondary">Volver</a>
                    <button type="submit" class="btn btn-danger">Eliminar Consultorio</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection