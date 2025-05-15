@extends('layouts.admin')

@section('content')

<div class="row">
    <h1>Registrar Obra Social</h1>
</div>

<div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Completar los datos</h3>
        </div>

        <div class="card-body">
            <form action="{{url('/admin/obrasociales/create')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-5 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="nombre">Nombre</label><b>*</b>
                            <input type="text" class="form-control" value="{{old('nombre')}}" id="nombre" name="nombre" placeholder="Nombre Obra Social"  required>
                            @error('nombre')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="telefono">Teléfono</label><b>*</b>
                            <input type="number" class="form-control" value="{{old('telefono')}}" id="telefono" name="telefono" placeholder="Teléfono" required>
                            @error('telefono')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="contacto">Contacto</label>
                            <input type="text" class="form-control" value="{{old('contacto')}}" id="contacto" name="contacto" placeholder="Contacto">
                            @error('contacto')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="email">E-mail</label><b>*</b>
                            <input type="email" class="form-control" value="{{old('email')}}" id="email" name="email" placeholder="Email" required>
                            @error('email')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="activo"></label>
                                <div class="form-check" style="margin-top: 17px; margin-left: 20px;">
                                    <input type="checkbox" class="form-check-input" id="activo" name="activo" value="1" {{ old('activo') ? 'checked' : '' }} style="transform: scale(2.0);">
                                    <label class="form-check-label" for="activo"><b>¿Está activo?</b><b>*</b></label>
                                </div>
                                @error('activo')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12 position-relative">
                        <div class="form-group">
                            <label for="documentacion">Documentación Necesaria</label>
                            <textarea class="form-control" id="documentacion" name="documentacion" placeholder="Ingrese la documentación">{{ old('documentacion') }}</textarea>
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
                            <textarea class="form-control" id="observacion" name="observacion" placeholder="Ingrese una observación">{{ old('observacion') }}</textarea>
                            @error('observacion')
                                <small style="color: red">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <br>
                <div class="form group">
                    <a href="{{url('admin/obrasociales')}}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Registrar Obra Social</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection