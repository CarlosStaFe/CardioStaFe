@extends('layouts.admin')

@section('content')

<div class="row">
    <h1>Modificar consultorio: {{$consultorio->nombre}}</h1>
</div>

<div class="col-md-12">
    <div class="card card-outline card-info">
        <div class="card-header">
            <h3 class="card-title">Actualizar los datos</h3>
        </div>

        <div class="card-body">
            <form action="{{url('/admin/consultorios',$consultorio->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-3 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="nombre">Nombre</label><b>*</b>
                            <input type="text" class="form-control" value="{{$consultorio->nombre}}" id="nombre" name="nombre" placeholder="Nombre" required>
                            @error('nombre')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4 position-relative">
                        <div class="form group">
                            <label for="numero">Número</label><b>*</b>
                            <input type="number" class="form-control" value="{{$consultorio->numero}}" id="numero" name="numero" placeholder="Número" required>
                            @error('numero')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="direccion">Dirección</label>
                            <input type="text" class="form-control" value="{{$consultorio->direccion}}" id="direccion" name="direccion" placeholder="Domicilio">
                            @error('direccion')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" class="form-control" value="{{$consultorio->telefono}}" id="telefono" name="telefono" placeholder="Teléfono">
                            @error('telefono')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <br>
                <div class="col-md-12 position-relative">
                    <div class="form-group">
                        <label for="observacion">Observación</label>
                        <textarea class="form-control" id="observacion" name="observacion" placeholder="Ingrese una observación">{{$consultorio->observacion}}</textarea>
                        @error('observacion')
                            <small style="color: red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <br>
                <div class="form group">
                    <a href="{{url('admin/consultorios')}}" class="btn btn-secundary">Cancelar</a>
                    <button type="submit" class="btn btn-info">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection