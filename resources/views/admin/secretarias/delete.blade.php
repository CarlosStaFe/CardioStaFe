@extends('layouts.admin')

@section('content')

<div class="row">
    <h1>Secretaria: {{$secretaria->apel_nombres}}</h1>
</div>

<div class="col-md-6">
    <div class="card card-danger">
        <div class="card-header">
            <h3 class="card-title">¿Desea eliminar este registro?</h3>
        </div>

        <div class="card-body">
            <form action="{{url('admin/secretarias/'.$secretaria->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <div class="form group">
                    <label for="apelnombres">Appellidos y Nombres</label>
                    <p>{{$secretaria->apel_nombres}}</p>
                </div>
                <br>
                <div class="form group">
                    <label for="telefono">Teléfono</label>
                    <p>{{$secretaria->telefono}}</p>
                </div>
                <br>
                <div class="form group">
                    <label for="domicilio">Domicilio</label>
                    <p>{{$secretaria->domicilio}}</p>
                </div>
                <br>
                <div class="form group">
                    <label for="email">E-mail</label>
                    <p>{{$secretaria->user->email}}</p>
                </div>
                <br>
                <div class="form group">
                    <a href="{{url('admin/secretarias')}}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-danger">Eliminar Secretaria</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection