@extends('layouts.admin')

@section('content')

<div class="row">
    <h1>Registrar Pacientes</h1>
</div>

<div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Completar los datos</h3>
        </div>

        <div class="card-body">
            <form action="{{url('/admin/pacientes/create')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-5 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="apel_nombres">Apellidos y Nombres</label><b>*</b>
                            <input type="text" class="form-control" value="{{old('apel_nombres')}}" id="apel_nombres" name="apel_nombres" placeholder="Apellidos y nombres" required>
                            @error('apel_nombres')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4 position-relative">
                        <div class="form group">
                            <label for="nacimiento">Nacimiento</label><b>*</b>
                            <input type="date" class="form-control" value="{{old('nacimiento')}}" id="nacimiento" name="nacimiento" placeholder="Nacimiento" required>
                            @error('nacimiento')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-1 col-sm-4 position-relative">
                        <div class="form-group">
                            <label for="nacimiento">Sexo</label><b>*</b>
                            <select type="text" class="form-control" value="{{old('sexo')}}" id="sexo" name="sexo" placeholder="Sexo" required>
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
                            <select type="text" class="form-control" value="{{old('tipo_documento')}}" id="tipo_documento" name="tipo_documento" placeholder="Tipo Doc." required>
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
                            <input type="text" class="form-control" value="{{old('num_documento')}}" id="num_documento" name="num_documento" placeholder="Documento" required>
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
                            <input type="text" class="form-control" value="{{old('domicilio')}}" id="domicilio" name="domicilio" placeholder="Domicilio">
                            @error('domicilio')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12 position-relative">
                        <div class="form-group">
                            <label for="provincia">Provincia</label>
                            <select type="text" class="form-control" value="{{old('provincia')}}" id="provincia" name="provincia" placeholder="Provincia">
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
                            <select type="text" class="form-control" value="{{old('localidad')}}" id="localidad" name="localidad" placeholder="Localidad">
                            </select>
                            @error('localidad')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12 position-relative">
                        <div class="form-group">
                            <label for="cod_postal">Cod.Postal</label>
                            <select type="text" class="form-control" value="{{old('cod_postal')}}" id="cod_postal" name="cod_postal" placeholder="Código">
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
                            <input type="text" class="form-control" value="{{old('telefono')}}" id="telefono" name="telefono" placeholder="Teléfono" required>
                            @error('telefono')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 position-relative">
                        <div class="form group">
                            <label for="email">Email</label><b>*</b>
                            <input type="email" class="form-control" value="{{old('email')}}" id="email" name="email" placeholder="Email" required>
                            @error('email')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 position-relative">
                        <div class="form-group">
                            <label for="obra_social">Obra Social</label>
                            <select type="text" class="form-control" value="{{old('obra_social')}}" id="obra_social" name="obra_social" placeholder="Obra Social">
                            </select>
                            @error('obra_social')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-1 col-sm-4 position-relative">
                        <div class="form-group">
                            <label for="plan_os">Plan</label>
                            <select type="text" class="form-control" value="{{old('plan_os')}}" id="plan_os" name="plan_os" placeholder="Plan">
                            </select>
                            @error('plan_os')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12 position-relative">
                        <div class="form group">
                            <label for="num_afiliado">Afiliado</label>
                            <input type="text" class="form-control" value="{{old('num_afiliado')}}" id="num_afiliado" name="num_afiliado" placeholder="Afiliado">
                            @error('num_afiliado')
                                <small style="color: red">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <br>
                <div class="form group">
                    <a href="{{url('admin/pacientes')}}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Registrar Paciente</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection