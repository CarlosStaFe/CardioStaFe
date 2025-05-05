@extends('layouts.admin')

@section('content')

<div class="row">
    <h1>Modificar paciente: {{$paciente->apel_nombres}}</h1>
</div>

<div class="col-md-12">
    <div class="card card-outline card-info">
        <div class="card-header">
            <h3 class="card-title">Actualizar los datos</h3>
        </div>

        <div class="card-body">
            <form action="{{url('/admin/pacientes',$paciente->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div>
                        <input id="nombrelocal" name="nombrelocal" type="hidden">
                        <input id="nombreprov" name="nombreprov" type="hidden">
                        <input id="codigopostal" name="codigopostal" type="hidden" value="{{$paciente->localidad->id}}">
                    </div>
                    <div class="col-md-5 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="apel_nombres">Apellidos y Nombres</label><b>*</b>
                            <input type="text" class="form-control" value="{{$paciente->apel_nombres}}" id="apel_nombres" name="apel_nombres" placeholder="Apellidos y nombres"  style="text-transform: uppercase;" required>
                            @error('apel_nombres')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4 position-relative">
                        <div class="form group">
                            <label for="nacimiento">Nacimiento</label><b>*</b>
                            <input type="date" class="form-control" value="{{$paciente->nacimiento}}" id="nacimiento" name="nacimiento" placeholder="Nacimiento" required>
                            @error('nacimiento')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-1 col-sm-4 position-relative">
                        <div class="form-group">
                            <label for="sexo">Sexo</label><b>*</b>
                            <select type="text" class="form-control" value="{{$paciente->sexo}}" id="sexo" name="sexo" placeholder="Sexo" required>
                                <option value="M">M</option>
                                <option value="F">F</option>
                            </select>
                            @error('sexo')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4 position-relative">
                        <div class="form-group">
                            <label for="tipo_documento">Tipo Doc.</label><b>*</b>
                            <select type="text" class="form-control" value="{{$paciente->tipo_documento}}" id="tipo_documento" name="tipo_documento" placeholder="Tipo Doc." required>
                                <option value="DNI">DNI</option>
                                <option value="CI">CI</option>
                                <option value="PAS">PAS</option>
                                <option value="LE">LE</option>
                                <option value="LC">LC</option>
                            </select>
                            @error('tipo_documento')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="num_documento">Documento</label><b>*</b>
                            <input type="text" class="form-control" value="{{$paciente->num_documento}}" id="num_documento" name="num_documento" placeholder="Documento" required>
                            @error('num_documento')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="domicilio">Domicilio</label>
                            <input type="text" class="form-control" value="{{$paciente->domicilio}}" id="domicilio" name="domicilio" placeholder="Domicilio">
                            @error('domicilio')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12 position-relative">
                        <div class="form-group">
                            <label for="provincia">Provincia</label>
                            <select type="text" class="form-control" value="{{strtoupper($paciente->localidad->provincia ?? 'N/A')}}" id="provincia" name="provincia" placeholder="Provincia">
                                <option value="{{$paciente->localidad->id_prov}}">{{strtoupper($paciente->localidad->provincia ?? 'N/A')}}</option>
                                <option value="82">SANTA FE</option>
                                <option value="6">BUENOS AIRES</option>
                                <option value="2">CABA</option>
                                <option value="10">CATAMARCA</option>
                                <option value="22">CHACO</option>
                                <option value="26">CHUBUT</option>
                                <option value="18">CORRIENTES</option>
                                <option value="14">CORDOBA</option>
                                <option value="30">ENTRE RIOS</option>
                                <option value="34">FORMOSA</option>
                                <option value="38">JUJUY</option>
                                <option value="42">LA PAMPA</option>
                                <option value="46">LA RIOJA</option>
                                <option value="50">MENDOZA</option>
                                <option value="54">MISIONES</option>
                                <option value="58">NEUQUEN</option>
                                <option value="62">RIO NEGRO</option>
                                <option value="70">SAN JUAN</option>
                                <option value="74">SAN LUIS</option>
                                <option value="66">SALTA</option>
                                <option value="78">SANTA CRUZ</option>
                                <option value="86">SANTIAGO DEL ESTERO</option>
                                <option value="94">TIERRA DEL FUEGO</option>
                                <option value="90">TUCUMAN</option>
                            </select>
                            @error('provincia')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 position-relative">
                        <div class="form-group">
                            <label for="localidad">Localidad</label>
                            <select type="text" class="form-control" value="{{strtoupper($paciente->localidad->localidad ?? 'N/A')}}" id="localidad" name="localidad" placeholder="Localidad">
                                <option value="{{$paciente->localidad->id_local}}">{{strtoupper($paciente->localidad->localidad ?? 'N/A')}}</option>
                            </select>
                            @error('localidad')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12 position-relative">
                        <div class="form-group">
                            <label for="cod_postal">Cod.Postal</label>
                            <select type="text" class="form-control" value="{{$paciente->localidad->cod_postal ?? 'N/A' }}" id="cod_postal" name="cod_postal" placeholder="Código">
                                <option value="{{$paciente->localidad->id}}">{{strtoupper($paciente->localidad->cod_postal ?? 'N/A')}}</option>
                            </select>
                            @error('cod_postal')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="telefono">Teléfono</label><b>*</b>
                            <input type="text" class="form-control" value="{{$paciente->telefono}}" id="telefono" name="telefono" placeholder="Teléfono" required>
                            @error('telefono')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 position-relative">
                        <div class="form group">
                            <label for="email">Email</label><b>*</b>
                            <input type="email" class="form-control" value="{{$paciente->email}}" id="email" name="email" placeholder="Email" required>
                            @error('email')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 position-relative">
                        <div class="form-group">
                            <label for="obra_social">Obra Social</label>
                            <select type="text" class="form-control" value="{{$paciente->obra_social}}" id="obra_social" name="obra_social" placeholder="Obra Social">
                            </select>
                            @error('obra_social')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-1 col-sm-4 position-relative">
                        <div class="form-group">
                            <label for="plan_os">Plan</label>
                            <select type="text" class="form-control" value="{{$paciente->plan_os}}" id="plan_os" name="plan_os" placeholder="Plan">
                            </select>
                            @error('plan_os')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="num_afiliado">Afiliado</label>
                            <input type="text" class="form-control" value="{{$paciente->num_afiliado}}" id="num_afiliado" name="num_afiliado" placeholder="Afiliado">
                            @error('num_afiliado')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12 position-relative">
                        <div class="form-group">
                            <label for="observacion">Observación</label>
                            <textarea class="form-control" id="observacion" name="observacion">{{ $paciente->observacion }}</textarea>
                            @error('observacion')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <br>
                <div class="form group">
                    <a href="{{url('admin/pacientes')}}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-info">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- // Script para seleccionar la provincia y la localidad -->
<script>
    document.getElementById('provincia').addEventListener('change', function () {
        const idProv = this.value;
        const nombreProv = this.options[this.selectedIndex].text;
        const localidadSelect = document.getElementById('localidad');
        document.getElementById('nombreprov').value = nombreProv;

        // Limpiar las opciones actuales
        localidadSelect.innerHTML = '<option value="">Seleccione una localidad</option>';

        if (idProv) {
            // Realizar la solicitud AJAX
            fetch(`{{url('admin/localidades') }}/${idProv}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(localidad => {
                        const option = document.createElement('option');
                        option.value = localidad.id_local;
                        option.textContent = localidad.localidad;
                        localidadSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error al cargar localidades:', error));
        }
    });

    document.getElementById('localidad').addEventListener('change', function() {
        const idLocal = this.value;
        const nombreLocal = this.options[this.selectedIndex].text;
        const codpostalSelect = document.getElementById('cod_postal');
        document.getElementById('nombrelocal').value = nombreLocal;

        // Limpiar las opciones de códigos postales
        codpostalSelect.innerHTML = '<option selected disabled>Elige un Código...</option>';

        // Hacer una solicitud AJAX para obtener las localidades
        fetch(`{{url('admin/codpostales') }}/${idLocal}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(codigos => {
                    const option = document.createElement('option');
                    option.value = codigos.id;
                    option.textContent = codigos.cod_postal;
                    codpostalSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error al obtener los códigos postales:', error));
    });

</script>

@endsection