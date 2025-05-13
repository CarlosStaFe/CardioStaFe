@extends('layouts.admin')

@section('content')

<div class="row">
    <h1>Modificar practica: {{$practica->nombre}}</h1>
</div>

<div class="col-md-12">
    <div class="card card-outline card-info">
        <div class="card-header">
            <h3 class="card-title">Actualizar los datos</h3>
        </div>

        <div class="card-body">
            <form action="{{url('/admin/practicas',$practica->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-5 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="nombre">Nombre</label><b>*</b>
                            <input type="text" class="form-control" value="{{$practica->nombre}}" id="nombre" name="nombre" placeholder="Nombre" required>
                            @error('nombre')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12 position-relative">
                        <div class="form-group">
                            <label for="observacion">Observación</label>
                            <textarea class="form-control" id="observacion" name="observacion" placeholder="Ingrese una observación">{{$practica->observacion}}</    textarea>
                            @error('observacion')
                                <small style="color: red">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <br>
                <div class="form group">
                    <a href="{{url('admin/practicas')}}" class="btn btn-secundary">Cancelar</a>
                    <button type="submit" class="btn btn-info">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection