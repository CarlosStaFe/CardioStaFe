@extends('layouts.admin')

@section('content')

<div class="row">
    <h1>Modificar secretaria: {{$secretaria->apel_nombres}}</h1>
</div>

<div class="col-md-6">
    <div class="card card-outline card-info">
        <div class="card-header">
            <h3 class="card-title">Actualizar los datos</h3>
        </div>

        <div class="card-body">
            <form action="{{url('admin/secretarias',$secretaria->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="form group">
                    <label for="apel_nombres">Appellidos y Nombres</label><b>*</b>
                    <input type="text" class="form-control" value="{{$secretaria->apel_nombres}}" id="apel_nombres" name="apel_nombres" placeholder="Apellido y nombres" required>
                    @error('apelnombres')
                        <small style="color: red">{{$message}}</small>
                    @enderror
                </div>
                <br>
                <div class="form group">
                    <label for="telefono">Teléfono</label><b>*</b>
                    <input type="text" class="form-control" value="{{$secretaria->telefono}}" id="telefono" name="telefono" placeholder="Teléfono" required>
                    @error('telegono')
                        <small style="color: red">{{$message}}</small>
                    @enderror
                </div>
                <br>
                <div class="form group">
                    <label for="domicilio">Domicilio</label><b>*</b>
                    <input type="address" class="form-control" value="{{$secretaria->domicilio}}" id="domicilio" name="domicilio" placeholder="Domicilio" required>
                    @error('domicilio')
                        <small style="color: red">{{$message}}</small>
                    @enderror
                </div>
                <br>
                <div class="form group">
                    <label for="email">E-mail</label><b>*</b>
                    <input type="email" class="form-control" value="{{$secretaria->user->email}}" id="email" name="email" placeholder="Email" required>
                    @error('email')
                        <small style="color: red">{{$message}}</small>
                    @enderror
                </div>
                <br>
                <div class="form group">
                    <label for="password">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
                    @error('password')
                        <small style="color: red">{{$message}}</small>
                    @enderror
                </div>
                <br>
                <div class="form group">
                    <label for="password_confirmation">Verificar Contraseña</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Verificar Contraseña">
                </div>
                    @error('password_verify')
                            <small style="color: red">{{$message}}</small>
                    @enderror
                <br>
                <div class="form group">
                    <a href="{{url('admin/secretarias')}}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-info">Actualizar Secretaria</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection