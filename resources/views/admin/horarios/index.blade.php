@extends('layouts.admin')

@section('content')
<h1>Listado de Horarios</h1>

<!-- Debug info -->
<div class="alert alert-info">
    <strong>Total de eventos:</strong> {{ $eventos->count() }}
</div>

<!-- Mensaje de filtro automático -->
<div class="alert alert-warning" id="filtro-automatico-mensaje" style="display: none;">
    <i class="bi bi-info-circle"></i> <strong>Filtro Automático:</strong> Se está mostrando solo los eventos de la fecha actual. Use los filtros para cambiar el rango de fechas.
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
                                    <button type="button" class="btn btn-success" id="generar-pdf">
                                        <i class="bi bi-printer"></i> Generar PDF
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
                    @if($eventos && $eventos->count() > 0)
                        @php $linea = 1; @endphp
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
                            <td>{{ $evento->consultorio->nombre ?? 'Sin asignar' }}</td>
                            <td>{{ $evento->practica->nombre ?? 'Sin asignar' }}</td>
                            <td>
                                @if($evento->medico)
                                    {{ $evento->medico->apel_nombres }}
                                @else
                                    <span class="text-muted">Sin asignar</span>
                                @endif
                            </td>
                            <td>{{ $evento->description ?? 'Sin descripción' }}</td>
                            <td>
                                <a href="{{url('admin/eventos/'.$evento->id.'/confirm-delete')}}" type="button" class="btn btn-danger btn-sm" title="Eliminar"><i class="bi bi-trash"></i></a>
                                <a href="{{url('admin/eventos/'.$evento->id)}}" type="button" class="btn btn-success btn-sm" title="Ver detalles"><i class="bi bi-eye"></i></a>
                                <a href="{{url('admin/eventos/'.$evento->id.'/edit')}}" type="button" class="btn btn-info btn-sm" title="Editar"><i class="bi bi-pencil"></i></a>
                                
                                @if($evento->title === '- Reservado')
                                    <button type="button" class="btn btn-warning btn-sm cambiar-estado" data-evento-id="{{ $evento->id }}" data-nuevo-estado="- En Espera" title="Marcar como En Espera">
                                        <i class="bi bi-clock"></i>
                                    </button>
                                @endif
                                
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
            // Destruir tabla existente si ya existe
            if ($.fn.DataTable.isDataTable('#example1')) {
                $('#example1').DataTable().destroy();
            }
            
            var table = $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "processing": false,
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
                    { "orderable": false, "targets": [8] },
                    { "searchable": true, "targets": "_all" }
                ],
                "order": [[1, "asc"]] // Ordenar por fecha por defecto
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

            // Manejar generación de PDF con filtros
            $('#generar-pdf').on('click', function() {
                generarPDFConFiltros();
            });

            // Aplicar filtro de fecha actual automáticamente al cargar la página
            setTimeout(function() {
                try {
                    // Verificar que la tabla esté inicializada
                    if (table && $.fn.DataTable.isDataTable('#example1')) {
                        console.log('Aplicando filtro automático de fecha actual...');
                        
                        // Verificar que los campos de fecha tengan la fecha actual
                        const hoy = new Date().toISOString().split('T')[0];
                        const fechaDesde = $('#filtro-fecha-desde').val();
                        const fechaHasta = $('#filtro-fecha-hasta').val();
                        
                        if (fechaDesde === hoy && fechaHasta === hoy) {
                            aplicarFiltros(table);
                            console.log('Filtro automático aplicado correctamente');
                        } else {
                            console.log('Los campos de fecha no coinciden con la fecha actual');
                        }
                    } else {
                        console.log('La tabla no está inicializada correctamente');
                    }
                } catch (error) {
                    console.error('Error aplicando filtro automático:', error);
                }
            }, 1500);

            // Aplicar filtro adicional después de que Select2 esté completamente cargado
            setTimeout(function() {
                if (table && $.fn.DataTable.isDataTable('#example1')) {
                    const fechaDesde = $('#filtro-fecha-desde').val();
                    const fechaHasta = $('#filtro-fecha-hasta').val();
                    const hoy = new Date().toISOString().split('T')[0];
                    
                    if (fechaDesde === hoy && fechaHasta === hoy) {
                        aplicarFiltros(table);
                    }
                }
            }, 2500);

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

        try {
            // Limpiar filtros previos de forma segura
            table.search('').columns().search('');
            
            // Limpiar filtros personalizados anteriores
            limpiarFiltrosPersonalizados();

            // Aplicar filtro de estado
            if (estado) {
                let estadoBusqueda = '';
                switch (estado) {
                    case '- Horario Disponible':
                        estadoBusqueda = 'Disponible';
                        break;
                    case '- Reservado':
                        estadoBusqueda = 'Reservado';
                        break;
                    case '- En Espera':
                        estadoBusqueda = 'En Espera';
                        break;
                    case '- Atendido':
                        estadoBusqueda = 'Atendido';
                        break;
                }
                if (estadoBusqueda) {
                    table.column(3).search(estadoBusqueda, false, false);
                }
            }

            // Aplicar filtro de consultorio
            if (consultorioId) {
                const consultorioTexto = $('#filtro-consultorio option:selected').text();
                if (consultorioTexto && consultorioTexto !== 'Todos') {
                    console.log('Filtro consultorio:', consultorioTexto);
                    table.column(4).search(consultorioTexto, false, true);
                }
            }

            // Aplicar filtro de médico
            if (medicoId) {
                const medicoTexto = $('#filtro-medico option:selected').text();
                if (medicoTexto && medicoTexto !== 'Todos') {
                    console.log('Filtro médico:', medicoTexto);
                    table.column(6).search(medicoTexto, false, true);
                }
            }

            // Aplicar filtro de fecha personalizado
            if (fechaDesde || fechaHasta) {
                aplicarFiltroFecha(table, fechaDesde, fechaHasta);
                
                // Mostrar mensaje si estamos filtrando por fecha actual
                const hoy = new Date().toISOString().split('T')[0];
                if (fechaDesde === hoy && fechaHasta === hoy) {
                    $('#filtro-automatico-mensaje').show();
                } else {
                    $('#filtro-automatico-mensaje').hide();
                }
            } else {
                $('#filtro-automatico-mensaje').hide();
            }

            // Aplicar todos los filtros
            table.draw();
        } catch (error) {
            console.error('Error aplicando filtros:', error);
        }
    }

    function limpiarFiltros(table) {
        // Limpiar los selectores y campos de fecha
        $('#filtro-consultorio').val('').trigger('change');
        $('#filtro-fecha-desde').val('');
        $('#filtro-fecha-hasta').val('');
        $('#filtro-medico').val('').trigger('change');
        $('#filtro-estado').val('').trigger('change');

        // Ocultar mensaje de filtro automático
        $('#filtro-automatico-mensaje').hide();

        // Limpiar filtros personalizados
        limpiarFiltrosPersonalizados();

        // Limpiar filtros de DataTables
        table.columns().search('').draw();
    }

    function limpiarFiltrosPersonalizados() {
        try {
            // Limpiar todos los filtros personalizados de fechas
            if ($.fn.dataTable && $.fn.dataTable.ext && $.fn.dataTable.ext.search) {
                while ($.fn.dataTable.ext.search.length > 0) {
                    $.fn.dataTable.ext.search.pop();
                }
            }
        } catch (error) {
            console.error('Error limpiando filtros personalizados:', error);
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

    function generarPDFConFiltros() {
        // Obtener los valores actuales de los filtros
        const consultorioId = $('#filtro-consultorio').val();
        const fechaDesde = $('#filtro-fecha-desde').val();
        const fechaHasta = $('#filtro-fecha-hasta').val();
        const medicoId = $('#filtro-medico').val();
        const estado = $('#filtro-estado').val();
        
        // Construir la URL con los parámetros de filtro
        let url = '{{ route("admin.eventos.pdf") }}';
        let params = new URLSearchParams();
        
        if (consultorioId) {
            params.append('consultorio_id', consultorioId);
        }
        
        if (fechaDesde) {
            params.append('fecha_desde', fechaDesde);
        }
        
        if (fechaHasta) {
            params.append('fecha_hasta', fechaHasta);
        }
        
        if (medicoId) {
            params.append('medico_id', medicoId);
        }
        
        if (estado) {
            params.append('estado', estado);
        }
        
        // Si hay parámetros, agregarlos a la URL
        if (params.toString()) {
            url += '?' + params.toString();
        }
        
        // Abrir el PDF en una nueva ventana/pestaña
        window.open(url, '_blank');
    }
</script>

@endsection