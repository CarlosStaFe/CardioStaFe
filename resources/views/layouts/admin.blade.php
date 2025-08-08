<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistema Clínica</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{url('dist/css/adminlte.min.css')}}">
    <!-- Iconos Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- jQuery -->
    <script src="{{url('plugins/jquery/jquery.min.js')}}"></script>
    <!-- Sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- DataTables Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <!-- Full Calendar -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js'></script>
    <script src="{{url('fullcalendar/es.global.js')}}"></script>
    
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{url('/admin')}}" class="nav-link">Sistema de Reserva de Citas Médicas</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{url('index3.html')}}" class="brand-link">
                <img src="{{url('dist/img/LogoChico.jpg')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Cardiología Infantil</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="info">
                        <a href="" class="d-block">Usuario: <b>{{ Auth::user()->name }}</b></a>
                        <a href="" class="d-block">Rol: <b>{{ Auth::user()->roles->pluck('name')->first() }}</b></a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        @can('admin.usuarios.index')
                            <li class="nav-item">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fas bi bi-person-badge"></i>
                                    <p>
                                        Usuarios
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{url('admin/usuarios/create')}}" class="nav-link active">
                                            <i class="bi bi-person-plus-fill nav-icon"></i>
                                            <p>Crear Usuarios</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{url('admin/usuarios')}}" class="nav-link active">
                                            <i class="bi bi-person-lines-fill nav-icon"></i>
                                            <p>Listado de Usuarios</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan

                        @can('admin.secretarias.index')
                            <li class="nav-item">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fas bi bi-person-circle"></i>
                                    <p>
                                        Secretarias
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{url('admin/secretarias/create')}}" class="nav-link active">
                                            <i class="bi bi-person-plus-fill nav-icon"></i>
                                            <p>Crear Secretarias</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{url('admin/secretarias')}}" class="nav-link active">
                                            <i class="bi bi-person-lines-fill nav-icon"></i>
                                            <p>Listado de Secretarias</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan

                        @can('admin.pacientes.index')
                            <li class="nav-item">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fas bi bi-person-fill-check"></i>
                                    <p>
                                        Pacientes
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{url('admin/pacientes/create')}}" class="nav-link active">
                                            <i class="bi bi-person-plus-fill nav-icon"></i>
                                            <p>Crear Pacientes</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{url('admin/pacientes')}}" class="nav-link active">
                                            <i class="bi bi-person-lines-fill nav-icon"></i>
                                            <p>Listado de Pacientes</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan

                        @can('admin.consultorios.index')
                            <li class="nav-item">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fa-solid fa-house-medical"></i>
                                    <p>
                                        Consultorios
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{url('admin/consultorios/create')}}" class="nav-link active">
                                            <i class="bi bi-clipboard2-plus-fill nav-icon"></i>
                                            <p>Crear Consultorio</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{url('admin/consultorios')}}" class="nav-link active">
                                            <i class="fa-solid fa-file-medical nav-icon"></i>
                                            <p>Listado de Consultorios</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan

                        @can('admin.practicas.index')
                            <li class="nav-item">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fa-solid fa-suitcase-medical"></i>
                                    <p>
                                        Prácticas
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{url('admin/practicas/create')}}" class="nav-link active">
                                            <i class="fa-solid fa-prescription-bottle-medical nav-icon"></i>
                                            <p>Crear Prácticas</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{url('admin/practicas')}}" class="nav-link active">
                                            <i class="fa-solid fa-file-medical nav-icon"></i>
                                            <p>Listado de Prácticas</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan

                        @can('admin.obrasociales.index')
                            <li class="nav-item">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fas fa-solid fa-building-columns"></i>
                                    <p>
                                        Obras Sociales
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{url('admin/obrasociales/create')}}" class="nav-link active">
                                            <i class="fa-solid fa-building nav-icon"></i>
                                            <p>Crear Obras Sociales</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{url('admin/obrasociales')}}" class="nav-link active">
                                            <i class="fa-solid fa-file-contract nav-icon"></i>
                                            <p>Listado de Obras Soc.</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan

                        @can('admin.medicos.index')
                            <li class="nav-item">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fas fa-solid fa-stethoscope"></i>
                                    <p>
                                        Médicos
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{url('admin/medicos/create')}}" class="nav-link active">
                                            <i class="bi bi-person-plus-fill nav-icon"></i>
                                            <p>Crear Médicos</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{url('admin/medicos')}}" class="nav-link active">
                                            <i class="bi bi-person-lines-fill nav-icon"></i>
                                            <p>Listado de Médicos</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan

                        @can('admin.horarios.index')
                            <li class="nav-item">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fas fa-solid fa-clock"></i>
                                    <p>
                                        Horarios
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('admin.eventos.generar') }}" class="nav-link active">
                                            <i class="fa-solid fa-calendar-plus nav-icon"></i>
                                            <p>Generar Disponibilidad</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{url('admin/eventos')}}" class="nav-link active">
                                            <i class="fa-solid fa-table-cells nav-icon"></i>
                                            <p>Listado de Horarios</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan

                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="nav-link" style="background-color: #a9200e;"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <i class="nav-icon fas bi bi-door-open-fill"></i>
                                <p>
                                    Cerrar Sesión
                                </p>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <div class="content-wrapper">
            <div class="container">
                @yield('content')
            </div>
        </div>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Título</h5>
                <p>Contenido Barra Lateral</p>
            </div>
        </aside>

        @if((($message = Session::get('mensaje')) && ($icono = Session::get('icono'))))
            <script>
                Swal.fire({
                    //position: "top-end",
                    icon: "{{$icono}}",
                    title: "{{$message}}",
                    showConfirmButton: false,
                    timer: 3000
                });
            </script>
        @endif

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Reserva de turno
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2025 <a href="https://adminlte.io"> OM Computación </a>.</strong> Todos los derechos reservados.
        </footer>
    </div>

    <!-- REQUIRED SCRIPTS -->

    <!-- Bootstrap 5 JS + Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- DataTables Bootstrap 5 & Plugins -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="{{url('plugins/jszip/jszip.min.js')}}"></script>
    <script src="{{url('plugins/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{url('plugins/pdfmake/vfs_fonts.js')}}"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{url('dist/js/adminlte.min.js')}}"></script>
</body>

</html>