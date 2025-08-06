@extends('layouts.admin')

@section('content')

<div class="row">
    <h1>Obra Social {{$obrasocial->nombre}}</h1>
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
                        <label for="apelnombres">Nombre</label>
                        <p>{{$obrasocial->nombre}}</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 position-relative">
                    <div class="form group">
                        <label for="plan">Plan</label>
                        <p>{{$obrasocial->plan}}</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-12 position-relative">
                    <div class="form group">
                        <label for="telefono">Teléfono</label>
                        <p>{{$obrasocial->telefono}}</p>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-3 col-sm-12 position-relative">
                    <div class="form group">
                        <label for="contacto">Contacto</label>
                        <p>{{$obrasocial->contacto}}</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 position-relative">
                    <div class="form group">
                        <label for="email">E-mail</label>
                        <p>{{$obrasocial->email}}</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 position-relative">
                    <div class="form group">
                        <label for="activo"></label>
                        <div class="form-check" style="margin-top: 10px; margin-left: 20px;">
                            <input class="form-check-input" type="checkbox" id="activo" name="activo" value="1" style="transform: scale(2.0);" 
                                {{ $obrasocial->activo == '1' ? 'checked' : '' }} disabled>
                            <label class="form-check-label" for="activo"><b>¿Está activo?</b></label>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12 position-relative">
                    <div class="form-group">
                        <label for="documentacion">Documentación Necesaria</label>
                        <textarea class="form-control" id="documentacion" name="documentacion" placeholder="Ingrese la documentación" disabled>{{$obrasocial->documentacion}}</textarea>
                            @error('documentacion')
                                <small style="color: red">{{ $message }}</small>
                            @enderror
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12 position-relative">
                    <div class="form-group">
                        <label for="observacion">Observación</label>
                        <textarea class="form-control" id="observacion" name="observacion" placeholder="Ingrese una observación" disabled>{{$obrasocial->observacion}}</textarea>
                        @error('observacion')
                            <small style="color: red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <br>
            <div class="form group">
                <a href="{{url('admin/obrasociales')}}" class="btn btn-success">Volver</a>
            </div>

        </div>
    </div>
</div>

@endsection