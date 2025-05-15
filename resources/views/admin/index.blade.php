@extends('layouts.admin')

@section('content')

    <div class="row">
        <h1>Panel Principal - {{Auth::user()->email}}</h1>
        <!-- <h3><b>Bienvenido:</b> {{Auth::user()->email}} / <b>Rol:</b> {{Auth::user()->roles->pluck('name')->first()}} </h3> -->
    </div>

    <hr>

    <div class="row">
        @can('admin.usuarios.index')
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{$total_usuarios}}</h3>
                        <p>Usuarios</p>
                    </div>
                    <div class="icon">
                        <i class="fas bi bi-person-badge"></i>
                    </div>
                    <a href="{{url('admin/usuarios')}}" class="small-box-footer">Más información <i class="fas bi bi-person-badge"></i></a>
                </div>
            </div>
        @endcan

        @can('admin.secretarias.index')
            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{$total_secretarias}}</h3>
                        <p>Secretarias</p>
                    </div>
                    <div class="icon">
                        <i class="fas bi bi-person-circle"></i>
                    </div>
                    <a href="{{url('admin/secretarias')}}" class="small-box-footer">Más información <i class="fas bi bi-person-circle"></i></a>
                </div>
            </div>
        @endcan

        @can('admin.pacientes.index')
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{$total_pacientes}}</h3>
                        <p>Pacientes</p>
                    </div>
                    <div class="icon">
                        <i class="fas bi bi-person-fill-check"></i>
                    </div>
                    <a href="{{url('admin/pacientes')}}" class="small-box-footer">Más información <i class="fas bi bi-person-fill-check"></i></a>
                </div>
            </div>
        @endcan

        @can('admin.consultorios.index')
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{$total_consultorios}}</h3>
                        <p>Consultorios</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-solid fa-house-medical"></i>
                    </div>
                    <a href="{{url('admin/consultorios')}}" class="small-box-footer">Más información <i class="fas fa-solid fa-house-medical"></i></a>
                </div>
            </div>
        @endcan

        @can('admin.practicas.index')
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{$total_practicas}}</h3>
                        <p>Prácticas</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-solid fa-suitcase-medical"></i>
                    </div>
                    <a href="{{url('admin/practicas')}}" class="small-box-footer">Más información <i class="fas fa-solid fa-suitcase-medical"></i></a>
                </div>
            </div>
        @endcan

        @can('admin.medicos.index')
            <div class="col-lg-3 col-6">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3>{{$total_medicos}}</h3>
                        <p>Médicos</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-solid fa-stethoscope"></i>
                    </div>
                    <a href="{{url('admin/medicos')}}" class="small-box-footer">Más información <i class="fas fa-solid fa-stethoscope"></i></a>
                </div>
            </div>
        @endcan

        @can('admin.horarios.index')
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{$total_horarios}}</h3>
                        <p>Horarios</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-solid fa-clock"></i>
                    </div>
                    <a href="{{url('admin/horarios')}}" class="small-box-footer">Más información <i class="fas fa-solid fa-clock"></i></a>
                </div>
            </div>
        @endcan

    </div>

@endsection