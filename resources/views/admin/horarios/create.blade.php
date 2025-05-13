@extends('layouts.admin')

@section('content')

<div class="row">
    <h1>Registrar Horarios</h1>
</div>

<div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Completar los datos</h3>
        </div>

        <div class="card-body">
            <form action="{{url('/admin/horarios/create')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-3 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="medico">Médico</label><b>*</b>
                            <select class="form-control" id="medico" name="medico" required>
                                @foreach($medicos as $medico)
                                    <option value="{{$medico->id}}" {{ old('medico') == $medico->id ? 'selected' : '' }}>{{ strtoupper($medico->apel_nombres) }}</option>
                                @endforeach
                            </select>
                            @error('telefono')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="medico">Consultorio</label><b>*</b>
                            <select class="form-control" id="consultorio" name="consultorio" required>
                                @foreach($consultorios as $consultorio)
                                    <option value="{{$consultorio->id}}" {{ old('consultorio') == $consultorio->id ? 'selected' : '' }}>{{ $consultorio->nombre }}</option>
                                @endforeach
                            </select>
                            @error('consultorio')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="medico">Especialidad</label><b>*</b>
                            <input type="text" class="form-control" value="{{old('especialidad')}}" id="especialidad" name="especialidad" placeholder="Especialidad" required>
                            @error('especialidad')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-2 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="dia">Día</label><b>*</b>
                            <select class="form-control" id="dia" name="dia" required>
                                <option value="">Seleccione un día</option>
                                <option value="LUNES" {{ old('dia') == 'LUNES' ? 'selected' : '' }}>LUNES</option>
                                <option value="MARTES" {{ old('dia') == 'MARTES' ? 'selected' : '' }}>MARTES</option>
                                <option value="MIÉRCOLES" {{ old('dia') == 'MIÉRCOLES' ? 'selected' : '' }}>MIÉRCOLES</option>
                                <option value="JUEVES" {{ old('dia') == 'JUEVES' ? 'selected' : '' }}>JUEVES</option>
                                <option value="VIERNES" {{ old('dia') == 'VIERNES' ? 'selected' : '' }}>VIERNES</option>
                                <option value="SÁBADO" {{ old('dia') == 'SÁBADO' ? 'selected' : '' }}>SÁBADO</option>
                                <option value="DOMINGO" {{ old('dia') == 'DOMINGO' ? 'selected' : '' }}>DOMINGO</option>
                            </select>
                            @error('dia')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="hora_inicio">Hora Inicio</label><b>*</b>
                            <input type="time" class="form-control" value="{{old('hora_inicio')}}" id="hora_inicio" name="hora_inicio" placeholder="Horario de inicio">
                            @error('hora_inicio')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="hora_fin">Hora Final</label><b>*</b>
                            <input type="time" class="form-control" value="{{old('hora_fin')}}" id="hora_fin" name="hora_fin" placeholder="Horario del final">
                            @error('hora_fin')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <br>
                <div class="form group">
                    <a href="{{url('admin/horarios')}}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Registrar Horario</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection