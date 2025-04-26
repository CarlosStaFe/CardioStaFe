@extends('layouts.admin')

@section('content')
<h1>Listado de Pacientes</h1>

<div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Pacientes Registrados</h3>

            <div class="card-tools">
                <a href="{{url('/admin/pacientes/create')}}" class="btn btn-primary">
                    Registrar Paciente
                </a>
            </div>
        </div>

        <div class="card-body">
            <table id="example1" class="table table-striped table-bordered table-hover table-sm">
                <thead style="background-color:rgb(14, 107, 169); color: white;">
                    <tr>
                        <th style="text-align: center; width: 5%;">#</th>
                        <th style="text-align: center; width: 20%;">APELLIDOS Y NOMBRES</th>
                        <th style="text-align: center; width: 20%;">TELÉFONO</th>
                        <th style="text-align: center; width: 20%;">DOMICILIO</th>
                        <th style="text-align: center; width: 24%;">E-MAIL</th>
                        <th style="text-align: center; width: 11%;">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $linea = 1; ?>
                    @foreach($pacientes as $paciente)
                    <tr>
                        <td style="text-align: right;">{{ $linea++ }}</td>
                        <td>{{ strtoupper($paciente->apel_nombres) }}</td>
                        <td>{{ $paciente->telefono }}</td>
                        <td>{{ $paciente->domicilio }}</td>
                        <td>{{ $paciente->email }}</td>
                        <td>
                            <a href="{{url('admin/pacientes/'.$paciente->id)}}" type="button" class="btn btn-success btn-sm"><i class="bi bi-eye"></i></a>
                            <a href="{{url('admin/pacientes/'.$paciente->id.'/edit')}}" type="button" class="btn btn-info btn-sm"><i class="bi bi-pencil"></i></a>
                            <a href="{{url('admin/pacientes/'.$paciente->id.'/confirm-delete')}}" type="button" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <script>
                $(function() {
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
                            },
                        },
                        "columnDefs": [
                            { "orderable": false, "targets": [5] }
                        ]
                    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                });
            </script>
                
        </div>
    </div>
</div>

@endsection