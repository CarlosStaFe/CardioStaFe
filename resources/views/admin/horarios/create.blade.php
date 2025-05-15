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
                            <label for="medico">Práctica Médica</label><b>*</b>
                            <select class="form-control" id="practica" name="practica" required>
                                @foreach($practicas as $practica)
                                    <option value="{{$practica->id}}" {{ old('practica') == $practica->id ? 'selected' : '' }}>{{ $practica->nombre }}</option>
                                @endforeach
                            </select>
                            @error('practica')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12 col-sm-12 position-relative">
                        <div class="form group">
                            <div class="form-check form-check-inline col-md-1">
                                <input class="form-check-input" type="checkbox" id="lunes" name="dias[]" value="LUNES" {{ is_array(old('dias')) && in_array('LUNES', old ('dias')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="lunes" style="color: green;"><b>LUNES</b></label>
                            </div>
                            <div class="form-check form-check-inline col-md-1">
                                <input class="form-check-input" type="checkbox" id="martes" name="dias[]" value="MARTES" {{ is_array(old('dias')) && in_array('MARTES', old ('dias')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="martes" style="color: green;"><b>MARTES</b></label>
                            </div>
                            <div class="form-check form-check-inline col-md-1">
                                <input class="form-check-input" type="checkbox" id="miercoles" name="dias[]" value="MIERCOLES" {{ is_array(old('dias')) && in_array ('MIERCOLES', old ('dias')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="miercoles" style="color: green;"><b>MIERCOLES</b></label>
                            </div>
                            <div class="form-check form-check-inline col-md-1">
                                <input class="form-check-input" type="checkbox" id="jueves" name="dias[]" value="JUEVES" {{ is_array(old('dias')) && in_array('JUEVES', old ('dias')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="jueves" style="color: green;"><b>JUEVES</b></label>
                            </div>
                            <div class="form-check form-check-inline col-md-1">
                                <input class="form-check-input" type="checkbox" id="viernes" name="dias[]" value="VIERNES" {{ is_array(old('dias')) && in_array('VIERNES',  old ('dias')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="viernes" style="color: green;"><b>VIERNES</b></label>
                            </div>
                            <div class="form-check form-check-inline col-md-1">
                                <input class="form-check-input" type="checkbox" id="sabado" name="dias[]" value="SABADO" {{ is_array(old('dias')) && in_array('SABADO', old ('dias')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="sabado" style="color: green;"><b>SABADO</b></label>
                            </div>
                            <div class="form-check form-check-inline col-md-1">
                                <input class="form-check-input" type="checkbox" id="domingo" name="dias[]" value="DOMINGO" {{ is_array(old('dias')) && in_array('DOMINGO', old ('dias')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="domingo" style="color: green;"><b>DOMINGO</b></label>
                            </div>
                            @error('dias')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-2 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="fecha_inicio">Desde Fecha</label><b>*</b>
                            <input type="date" class="form-control" value="{{old('fecha_inicio')}}" id="fecha_inicio" name="fecha_inicio" placeholder="Desde la Fecha">
                            @error('fecha_inicio')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="fecha_fin">Hasta Fecha</label><b>*</b>
                            <input type="date" class="form-control" value="{{old('fecha_fin')}}" id="fecha_fin" name="fecha_fin" placeholder="Hasta la Fecha">
                            @error('fecha_fin')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
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
                    <div class="col-md-2 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="rango">Rango Turno</label><b>*</b>
                            <input type="time" class="form-control" value="{{old('rango')}}" id="rango" name="rango" placeholder="Rango de turnos">
                            @error('rango')
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