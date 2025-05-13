@extends('layouts.admin')

@section('content')

<div class="row">
    <h1>Registrar Consultorios</h1>
</div>

<div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Completar los datos</h3>
        </div>

        <div class="card-body">
            <form action="{{url('/admin/consultorios/create')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-5 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="nombre">Nombre</label><b>*</b>
                            <input type="text" class="form-control" value="{{old('nombre')}}" id="nombre" name="nombre" placeholder="Nombre" required>
                            @error('nombre')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4 position-relative">
                        <div class="form group">
                            <label for="numero">Número</label><b>*</b>
                            <input type="number" class="form-control" value="{{old('numero')}}" id="numero" name="numero" placeholder="Número" required>
                            @error('numero')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="direccion">Dirección</label>
                            <input type="text" class="form-control" value="{{old('direccion')}}" id="direccion" name="direccion" placeholder="Dirección">
                            @error('direccion')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-3 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" class="form-control" value="{{old('telefono')}}" id="telefono" name="telefono" placeholder="Teléfono">
                            @error('telefono')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 position-relative">
                        <div class="form group">
                            <label for="especialidad">Especialidad</label>
                            <input type="especialidad" class="form-control" value="{{old('especialidad')}}" id="especialidad" name="especialidad" placeholder="Especialidad">
                            @error('especialidad')
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
                            <textarea class="form-control" id="observacion" name="observacion" placeholder="Ingrese una observación">{{ old('observacion') }}</textarea>
                            @error('observacion')
                                <small style="color: red">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <br>
                <div class="form group">
                    <a href="{{url('admin/consultorios')}}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Registrar Consultorio</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection