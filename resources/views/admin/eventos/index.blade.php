@extends('layouts.admin')

@section('content')
<h1>Listado de Horarios</h1>

<!-- Debug info -->
<div class="alert alert-info">
    <strong>Total de eventos:</strong> {{ $eventos->count() }}
</div>

<div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Horarios Registrados</h3>
        </div>

        <div class="card-body">
           
            <table id="example1" class="table table-striped table-bordered table-hover table-sm">
                <thead style="background-color:rgb(14, 107, 169); color: white;">
                    <tr>
                        <th style="text-align: center; width: 3%;">#</th>
                        <th style="text-align: center; width: 9%;">FECHA</th>
                        <th style="text-align: center; width: 5%;">HR.</th>
                        <th style="text-align: center; width: 5%;">ESTADO</th>
                        <th style="text-align: center; width: 21%;">DESCRIPCIÓN</th>
                        <th style="text-align: center; width: 15%;">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @if($eventos->count() > 0)
                        <?php $linea = 1; ?>
                        @foreach($eventos as $evento)
                        <tr>
                            <td style="text-align: right;">{{ $linea++ }}</td>
                            <td>{{ \Carbon\Carbon::parse($evento->start)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($evento->start)->format('H:i') }}</td>
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
                            <td>{{ $evento->description ?? 'Sin descripción' }}</td>
                            <td>
                                <a href="{{url('admin/eventos/'.$evento->id)}}" type="button" class="btn btn-success btn-sm" title="Ver detalles"><i class="bi bi-eye"></i></a>
                                <a href="{{url('admin/eventos/'.$evento->id.'/edit')}}" type="button" class="btn btn-info btn-sm" title="Editar"><i class="bi bi-pencil"></i></a>
                                <a href="{{url('admin/eventos/'.$evento->id.'/confirm-delete')}}" type="button" class="btn btn-danger btn-sm" title="Eliminar"><i class="bi bi-trash"></i></a>
                                
                                @if($evento->title !== '- En Espera')
                                    <button type="button" class="btn btn-warning btn-sm cambiar-estado" data-evento-id="{{ $evento->id }}" data-nuevo-estado="- En Espera" title="Marcar como En Espera">
                                        <i class="bi bi-clock"></i>
                                    </button>
                                @endif
                                
                                @if($evento->title !== '- Atendido')
                                    <button type="button" class="btn btn-secondary btn-sm cambiar-estado" data-evento-id="{{ $evento->id }}" data-nuevo-estado="- Atendido" title="Marcar como Atendido">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center">No hay eventos registrados</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(function() {
        // Verificar si DataTables está disponible
        if (!$.fn.DataTable) {
            console.error('DataTables no está cargado');
            return;
        }

        try {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
                "pageLength": 10,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "zeroRecords": "No se encontraron resultados",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                "columnDefs": [
                    { "orderable": false, "targets": [5] }
                ]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        } catch (error) {
            console.error('Error al inicializar DataTables:', error);
        }

        // Manejar clicks en botones de cambio de estado
        $(document).on('click', '.cambiar-estado', function() {
            const eventoId = $(this).data('evento-id');
            const nuevoEstado = $(this).data('nuevo-estado');
            const boton = $(this);
            
            if (confirm(`¿Está seguro de cambiar el estado a "${nuevoEstado}"?`)) {
                cambiarEstadoEvento(eventoId, nuevoEstado, boton);
            }
        });
    });

    function cambiarEstadoEvento(eventoId, nuevoEstado, boton) {
        // Deshabilitar el botón durante la petición
        boton.prop('disabled', true);
        
        fetch(`{{ url('admin/eventos') }}/${eventoId}/cambiar-estado`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                nuevo_estado: nuevoEstado
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mostrar mensaje de éxito
                alert('Estado cambiado correctamente');
                // Recargar la página para actualizar la vista
                location.reload();
            } else {
                alert('Error al cambiar el estado: ' + (data.message || 'Error desconocido'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de conexión al cambiar el estado');
        })
        .finally(() => {
            // Rehabilitar el botón
            boton.prop('disabled', false);
        });
    }
</script>

@endsection