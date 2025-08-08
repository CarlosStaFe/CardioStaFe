@extends('layouts.admin')

@section('content')
<h1>Confirmar Eliminación</h1>

<div class="col-md-12">
    <div class="card card-outline card-danger">
        <div class="card-header">
            <h3 class="card-title">Eliminar Evento</h3>
        </div>

        <div class="card-body">
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle"></i>
                <strong>¡Atención!</strong> Esta acción no se puede deshacer.
            </div>

            <p>¿Está seguro de que desea eliminar el siguiente evento?</p>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 200px;">ID:</th>
                        <td>{{ $evento->id }}</td>
                    </tr>
                    <tr>
                        <th>Título:</th>
                        <td>{{ $evento->title ?? 'Sin título' }}</td>
                    </tr>
                    <tr>
                        <th>Fecha:</th>
                        <td>{{ \Carbon\Carbon::parse($evento->start)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Horario:</th>
                        <td>{{ \Carbon\Carbon::parse($evento->start)->format('H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Estado:</th>
                        <td>
                            @if($evento->title === '- Reservado')
                                <span class="badge bg-danger">Reservado</span>
                            @elseif($evento->title === '- En Espera')
                                <span class="badge bg-warning">En Espera</span>
                            @elseif($evento->title === '- Atendido')
                                <span class="badge bg-secondary">Atendido</span>
                            @else
                                <span class="badge bg-success">Disponible</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Descripción:</th>
                        <td>{{ $evento->description ?? 'Sin descripción' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card-footer">
            <a href="{{ url('admin/eventos') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Cancelar
            </a>
            <form method="POST" action="{{ route('admin.eventos.destroy', $evento->id) }}" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está completamente seguro?')">
                    <i class="bi bi-trash"></i> Confirmar Eliminación
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
