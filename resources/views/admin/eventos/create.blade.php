@extends('layouts.admin')

@section('header')
<h1 class="m-0">Generar Horarios Disponibles</h1>
@endsection

@section('content')
<div class="col-md-12">
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Complete los datos para generar horarios</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.eventos.create') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="medico_id">Médico <b>*</b></label>
                            <select name="medico_id" id="medico_id" class="form-control select2" required>
                                <option value="">Seleccione un médico</option>
                                @foreach($medicos as $medico)
                                <option value="{{ $medico->id }}">{{ $medico->apel_nombres }}</option>
                                @endforeach
                            </select>
                            @error('medico_id')
                                <small style="color: red">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="consultorio_id">Consultorio <b>*</b></label>
                            <select name="consultorio_id" id="consultorio_id" class="form-control select2" required>
                                <option value="">Seleccione un consultorio</option>
                                @foreach($consultorios as $consultorio)
                                <option value="{{ $consultorio->id }}">{{ $consultorio->nombre }}</option>
                                @endforeach
                            </select>
                            @error('consultorio_id')
                                <small style="color: red">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="practica_id">Práctica <b>*</b></label>
                            <select name="practica_id" id="practica_id" class="form-control select2" required>
                                <option value="">Seleccione una práctica</option>
                                @foreach($practicas as $practica)
                                <option value="{{ $practica->id }}">{{ $practica->nombre }}</option>
                                @endforeach
                            </select>
                            @error('practica_id')
                                <small style="color: red">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="rango">Duración de cada turno (minutos) <b>*</b></label>
                            <select name="rango" id="rango" class="form-control" required>
                                <option value="">Seleccione la duración</option>
                                <option value="10">10 minutos</option>
                                <option value="15">15 minutos</option>
                                <option value="20">20 minutos</option>
                                <option value="25">25 minutos</option>
                                <option value="30">30 minutos</option>
                            </select>
                            @error('rango')
                                <small style="color: red">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fecha_inicio">Fecha de inicio <b>*</b></label>
                            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" 
                                   value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
                            @error('fecha_inicio')
                                <small style="color: red">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fecha_fin">Fecha de fin <b>*</b></label>
                            <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" 
                                   value="{{ date('Y-m-d', strtotime('+30 days')) }}" min="{{ date('Y-m-d') }}" required>
                            @error('fecha_fin')
                                <small style="color: red">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="hora_inicio">Hora de inicio <b>*</b></label>
                            <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" 
                                   value="08:00" required>
                            @error('hora_inicio')
                                <small style="color: red">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="hora_fin">Hora de fin <b>*</b></label>
                            <input type="time" name="hora_fin" id="hora_fin" class="form-control" 
                                   value="18:00" required>
                            @error('hora_fin')
                                <small style="color: red">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Días de la semana <b>*</b></label>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="lunes" id="lunes" value="1">
                                        <label class="form-check-label" for="lunes">Lunes</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="martes" id="martes" value="1">
                                        <label class="form-check-label" for="martes">Martes</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="miercoles" id="miercoles" value="1">
                                        <label class="form-check-label" for="miercoles">Miércoles</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="jueves" id="jueves" value="1">
                                        <label class="form-check-label" for="jueves">Jueves</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="viernes" id="viernes" value="1">
                                        <label class="form-check-label" for="viernes">Viernes</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="sabado" id="sabado" value="1">
                                        <label class="form-check-label" for="sabado">Sábado</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-calendar-plus"></i> Generar Horarios
                            </button>
                            <a href="{{ route('admin.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validar que la fecha fin no sea menor que fecha inicio
    document.getElementById('fecha_inicio').addEventListener('change', function() {
        const fechaFin = document.getElementById('fecha_fin');
        fechaFin.min = this.value;
        if (fechaFin.value < this.value) {
            fechaFin.value = this.value;
        }
    });

    // Validar que la hora fin sea mayor que hora inicio
    document.getElementById('hora_inicio').addEventListener('change', function() {
        const horaFin = document.getElementById('hora_fin');
        if (horaFin.value <= this.value) {
            const horaInicio = new Date('2000-01-01 ' + this.value);
            horaInicio.setMinutes(horaInicio.getMinutes() + 60);
            horaFin.value = horaInicio.toTimeString().substr(0, 5);
        }
    });

    // Validar que al menos un día esté seleccionado
    document.querySelector('form').addEventListener('submit', function(e) {
        const diasSeleccionados = document.querySelectorAll('input[type="checkbox"]:checked');
        if (diasSeleccionados.length === 0) {
            e.preventDefault();
            alert('Debe seleccionar al menos un día de la semana.');
        }
    });
});
</script>
@endsection
