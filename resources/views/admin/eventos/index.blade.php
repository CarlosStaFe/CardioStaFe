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
            <!-- Filtros -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-funnel"></i> Filtros de Búsqueda
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="filtro-consultorio">Consultorio:</label>
                                        <select class="form-select select2" id="filtro-consultorio">
                                            <option value="">Todos</option>
                                            @foreach($consultorios as $consultorio)
                                                <option value="{{ $consultorio->id }}">{{ $consultorio->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="filtro-fecha">Fecha:</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="date" class="form-control" id="filtro-fecha-desde" placeholder="Desde" value="{{ date('Y-m-d') }}">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="date" class="form-control" id="filtro-fecha-hasta" placeholder="Hasta" value="{{ date('Y-m-d') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="filtro-medico">Médico:</label>
                                        <select class="form-select select2" id="filtro-medico">
                                            <option value="">Todos</option>
                                            @foreach($medicos as $medico)
                                                <option value="{{ $medico->id }}">{{ $medico->apel_nombres }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="filtro-estado">Estado:</label>
                                        <select class="form-select select2" id="filtro-estado">
                                            <option value="">Todos</option>
                                            <option value="- Horario Disponible">Disponible</option>
                                            <option value="- Reservado">Reservado</option>
                                            <option value="- En Espera">En Espera</option>
                                            <option value="- Atendido">Atendido</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-primary" id="aplicar-filtros">
                                        <i class="bi bi-search"></i> Aplicar Filtros
                                    </button>
                                    <button type="button" class="btn btn-secondary" id="limpiar-filtros">
                                        <i class="bi bi-x-circle"></i> Limpiar Filtros
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
            <table id="example1" class="table table-striped table-bordered table-hover table-sm">
                <thead style="background-color:rgb(14, 107, 169); color: white;">
                    <tr>
                        <th style="text-align: center; width: 2%;">#</th>
                        <th style="text-align: center; width: 8%;">FECHA</th>
                        <th style="text-align: center; width: 4%;">HR.</th>
                        <th style="text-align: center; width: 5%;">ESTADO</th>
                        <th style="text-align: center; width: 10%;">CONSULTORIO</th>
                        <th style="text-align: center; width: 10%;">PRÁCTICA</th>
                        <th style="text-align: center; width: 10%;">MÉDICO</th>
                        <th style="text-align: center; width: 26%;">DESCRIPCIÓN</th>
                        <th style="text-align: center; width: 20%;">ACCIONES</th>
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
                                @elseif($evento->title === '- Atendido')
                                    <span class="badge bg-secondary">Atendido</span>
                                @else
                                    <span class="badge bg-success">Disponible</span>
                                @endif
                            </td>
                            <td>{{ $evento->consultorio->nombre ?? 'Sin asignar' }}</td>
                            <td>{{ $evento->practica->nombre ?? 'Sin asignar' }}</td>
                            <td>
                                @if($evento->medico)
                                    {{ $evento->medico->apel_nombres }}
                                @endif
                            </td>
                            <td>{{ $evento->description ?? 'Sin descripción' }}</td>
                            <td>
                                <a href="{{url('admin/eventos/'.$evento->id.'/confirm-delete')}}" type="button" class="btn btn-danger btn-sm" title="Eliminar"><i class="bi bi-trash"></i></a>
                                <a href="{{url('admin/eventos/'.$evento->id)}}" type="button" class="btn btn-success btn-sm" title="Ver detalles"><i class="bi bi-eye"></i></a>
                                <a href="{{url('admin/eventos/'.$evento->id.'/edit')}}" type="button" class="btn btn-info btn-sm" title="Editar"><i class="bi bi-pencil"></i></a>
                                
                                {{-- Solo mostrar botón "En Espera" si está Reservado --}}
                                @if($evento->title === '- Reservado')
                                    <button type="button" class="btn btn-warning btn-sm cambiar-estado" data-evento-id="{{ $evento->id }}" data-nuevo-estado="- En Espera" title="Marcar como En Espera">
                                        <i class="bi bi-clock"></i>
                                    </button>
                                @endif
                                
                                {{-- Solo mostrar botón "Atendido" si NO está Atendido y NO está En Espera --}}
                                @if($evento->title === '- En Espera')
                                    <button type="button" class="btn btn-secondary btn-sm cambiar-estado" data-evento-id="{{ $evento->id }}" data-nuevo-estado="- Atendido" title="Marcar como Atendido">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9" class="text-center">No hay eventos registrados</td>
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
            var table = $("#example1").DataTable({
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
                    { "orderable": false, "targets": [8] }
                ]
            });
            
            // Agregar botones al contenedor
            table.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            // Inicializar Select2 para los filtros
            if (typeof $.fn.select2 !== 'undefined') {
                $('.select2').select2({
                    theme: 'bootstrap-5',
                    width: '100%'
                });
            }

            // Manejar aplicación de filtros
            $('#aplicar-filtros').on('click', function() {
                aplicarFiltros(table);
            });

            // Manejar aplicación de filtros al cambiar cualquier select o campo de fecha
            $('.select2').on('change', function() {
                aplicarFiltros(table);
            });

            $('#filtro-fecha-desde, #filtro-fecha-hasta').on('change', function() {
                aplicarFiltros(table);
            });

            // Manejar limpieza de filtros
            $('#limpiar-filtros').on('click', function() {
                limpiarFiltros(table);
            });

            // Aplicar filtro de fecha actual automáticamente al cargar la página
            setTimeout(function() {
                aplicarFiltros(table);
            }, 500);

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

    function aplicarFiltros(table) {
        const consultorioId = $('#filtro-consultorio').val();
        const fechaDesde = $('#filtro-fecha-desde').val();
        const fechaHasta = $('#filtro-fecha-hasta').val();
        const medicoId = $('#filtro-medico').val();
        const estado = $('#filtro-estado').val();

        console.log('Aplicando filtros:', { consultorioId, fechaDesde, fechaHasta, medicoId, estado });

        // Limpiar filtros previos
        table.columns().search('');
        
        // Limpiar filtros personalizados anteriores
        limpiarFiltrosPersonalizados();

        // Aplicar filtro de estado
        if (estado) {
            if (estado === '- Horario Disponible') {
                table.column(3).search('Disponible', false, false);
            } else if (estado === '- Reservado') {
                table.column(3).search('Reservado', false, false);
            } else if (estado === '- En Espera') {
                table.column(3).search('En Espera', false, false);
            } else if (estado === '- Atendido') {
                table.column(3).search('Atendido', false, false);
            }
        }

        // Aplicar filtro de consultorio
        if (consultorioId) {
            const consultorioTexto = $('#filtro-consultorio option:selected').text();
            console.log('Filtro consultorio:', consultorioTexto);
            table.column(4).search(consultorioTexto, false, true);
        }

        // Aplicar filtro de médico
        if (medicoId) {
            const medicoTexto = $('#filtro-medico option:selected').text();
            console.log('Filtro médico:', medicoTexto);
            table.column(6).search(medicoTexto, false, true);
        }

        // Aplicar filtro de fecha personalizado
        if (fechaDesde || fechaHasta) {
            aplicarFiltroFecha(table, fechaDesde, fechaHasta);
        }

        // Aplicar todos los filtros
        table.draw();
    }

    function limpiarFiltros(table) {
        // Limpiar los selectores y campos de fecha
        $('#filtro-consultorio').val('').trigger('change');
        $('#filtro-fecha-desde').val('');
        $('#filtro-fecha-hasta').val('');
        $('#filtro-medico').val('').trigger('change');
        $('#filtro-estado').val('').trigger('change');

        // Limpiar filtros personalizados
        limpiarFiltrosPersonalizados();

        // Limpiar filtros de DataTables
        table.columns().search('').draw();
    }

    function limpiarFiltrosPersonalizados() {
        // Limpiar todos los filtros personalizados de fechas
        while ($.fn.dataTable.ext.search.length > 0) {
            $.fn.dataTable.ext.search.pop();
        }
    }

    function aplicarFiltroFecha(table, fechaDesde, fechaHasta) {
        // Convertir las fechas del input (YYYY-MM-DD) al formato de la tabla (DD/MM/YYYY)
        function convertirFecha(fechaInput) {
            if (!fechaInput) return null;
            const partes = fechaInput.split('-');
            return partes[2] + '/' + partes[1] + '/' + partes[0];
        }

        const fechaDesdeConvertida = convertirFecha(fechaDesde);
        const fechaHastaConvertida = convertirFecha(fechaHasta);

        console.log('Filtro fecha:', { fechaDesde, fechaHasta, fechaDesdeConvertida, fechaHastaConvertida });

        // Filtro personalizado para rango de fechas
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            if (settings.nTable.id !== 'example1') {
                return true; // Si no es nuestra tabla, mostrar todo
            }

            const fechaTabla = data[1]; // La fecha está en la columna 1 (índice 1)

            if (!fechaDesdeConvertida && !fechaHastaConvertida) {
                return true; // Si no hay filtros de fecha, mostrar todo
            }

            // Convertir fecha de la tabla a objeto Date para comparar
            function fechaADate(fechaStr) {
                const partes = fechaStr.split('/');
                return new Date(partes[2], partes[1] - 1, partes[0]);
            }

            const fechaTablaDate = fechaADate(fechaTabla);

            if (fechaDesdeConvertida) {
                const fechaDesdeDate = fechaADate(fechaDesdeConvertida);
                if (fechaTablaDate < fechaDesdeDate) {
                    return false;
                }
            }

            if (fechaHastaConvertida) {
                const fechaHastaDate = fechaADate(fechaHastaConvertida);
                if (fechaTablaDate > fechaHastaDate) {
                    return false;
                }
            }

            return true;
        });
    }

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