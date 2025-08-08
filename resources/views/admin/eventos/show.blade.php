@extends('layouts.admin')

@section('content')
<h1>Detalles del Evento</h1>

<div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Información del Evento</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><strong>ID:</strong></label>
                        <p>{{ $evento->id }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label><strong>Estado:</strong></label>
                        <p>
                            @if($evento->title === '- Reservado')
                                <span class="badge bg-danger">Reservado</span>
                            @elseif($evento->title === '- En Espera')
                                <span class="badge bg-warning">En Espera</span>
                            @elseif($evento->title === '- Atendido')
                                <span class="badge bg-secondary">Atendido</span>
                            @else
                                <span class="badge bg-success">Disponible</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><strong>Fecha:</strong></label>
                        <p>{{ \Carbon\Carbon::parse($evento->start)->format('d/m/Y') }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label><strong>Horario:</strong></label>
                        <p>{{ \Carbon\Carbon::parse($evento->start)->format('H:i') }}</p>
                    </div>
                </div>
            </div>

            @if($evento->end)
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><strong>Fecha Fin:</strong></label>
                        <p>{{ \Carbon\Carbon::parse($evento->end)->format('d/m/Y') }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label><strong>Horario Fin:</strong></label>
                        <p>{{ \Carbon\Carbon::parse($evento->end)->format('H:i') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label><strong>Título:</strong></label>
                        <p>{{ $evento->title ?? 'Sin título' }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label><strong>Descripción:</strong></label>
                        <p>{{ $evento->description ?? 'Sin descripción' }}</p>
                    </div>
                </div>
            </div>

            @if($evento->user)
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label><strong>Creado por:</strong></label>
                        <p>{{ $evento->user->email }}</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><strong>Creado el:</strong></label>
                        <p>{{ $evento->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label><strong>Actualizado el:</strong></label>
                        <p>{{ $evento->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <a href="{{ url('admin/eventos') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver al listado
            </a>
            <a href="{{ url('admin/eventos/'.$evento->id.'/edit') }}" class="btn btn-primary">
                <i class="bi bi-pencil"></i> Editar
            </a>
        </div>
    </div>
</div>

@endsection
