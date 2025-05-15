@extends('layouts.admin')

@section('content')

<div class="row">
    <h1>Modificar médicos: {{$medico->apel_nombres}}</h1>
</div>

<div class="col-md-12">
    <div class="card card-outline card-info">
        <div class="card-header">
            <h3 class="card-title">Actualizar los datos</h3>
        </div>

        <div class="card-body">
            <form action="{{url('/admin/medicos',$medico->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-4 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="apel_nombres">Apellidos y Nombres</label><b>*</b>
                            <input type="text" class="form-control" value="{{$medico->apel_nombres}}" id="apel_nombres" name="apel_nombres" placeholder="Apellido y nombres"  required>
                            @error('apel_nombres')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="matricula">Matrícula</label>
                            <input type="text" class="form-control" value="{{$medico->matricula}}" id="matricula" name="matricula" placeholder="Matrícula">
                            @error('matricula')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="telefono">Teléfono</label><b>*</b>
                            <input type="text" class="form-control" value="{{$medico->telefono}}" id="telefono" name="telefono" placeholder="Teléfono" required>
                            @error('telefono')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="especialidad">Especialidad</label><b>*</b>
                            <input type="text" class="form-control" value="{{$medico->especialidad}}" id="especialidad" name="especialidad" placeholder="Especialidad" required>
                            @error('especialidad')
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
                            <input type="email" class="form-control" value="{{$medico->email}}" id="email" name="email" placeholder="Email" required>
                            @error('email')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="activo"></label>
                                <div class="form-check" style="margin-top: 17px; margin-left: 20px;">
                                    <input class="form-check-input" type="checkbox" id="activo" name="activo" value="{{$medico->activo}}" style="transform: scale(2.0);" {{ $medico->activo == 'S' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="activo"><b>¿Está activo?</b><b>*</b></label>
                                </div>
                                @error('activo')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="password">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
                            @error('password')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="password_confirmation">Verificar Contraseña</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Verificar Contraseña">
                            @error('password_verify')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <br>
                <div class="form group">
                    <a href="{{url('admin/medicos')}}" class="btn btn-info">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection