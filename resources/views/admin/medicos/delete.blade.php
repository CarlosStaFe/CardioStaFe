@extends('layouts.admin')

@section('content')

<div class="row">
    <h1>Médico: {{$medico->apel_nombres}}</h1>
</div>

<div class="col-md-12">
    <div class="card card-danger">
        <div class="card-header">
            <h3 class="card-title">¿Desea eliminar este registro?</h3>
        </div>

        <div class="card-body">
            <form action="{{url('admin/medicos/'.$medico->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <div class="row">
                    <div class="col-md-4 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="apelnombres">Apellidos y Nombres</label>
                            <p>{{$medico->apel_nombres}}</p>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="matricula">Matrícula</label>
                            <p>{{$medico->matricula}}</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="telefono">Teléfono</label>
                            <p>{{$medico->telefono}}</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="especialidad">Especialidad</label>
                            <p>{{$medico->especialidad}}</p>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="email">E-mail</label>
                            <p>{{$medico->user->email}}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="activo"></label>
                            <div class="form-check" style="margin-top: 10px; margin-left: 20px;">
                                <input class="form-check-input" type="checkbox" id="activo" name="activo" value="S" style="transform: scale(2.0);" {{($medico->activo == 'S' ?      'checked' : '')}} disabled>
                                <label class="form-check-label" for="activo"><b>¿Está activo?</b></label>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="form group">
                    <a href="{{url('admin/medicos')}}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-danger">Eliminar Médico</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection