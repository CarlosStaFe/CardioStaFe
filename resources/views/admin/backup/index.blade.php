@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <i class="bi bi-shield-lock"></i> 
                    Copias de Seguridad de la Base de Datos
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Copias de Seguridad</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <!-- Información de permisos de usuario -->
        <div class="alert alert-info">
            <h5><i class="bi bi-person-check"></i> Información de Acceso</h5>
            <p class="mb-2">
                <strong>Usuario:</strong> {{ Auth::user()->name }} ({{ Auth::user()->email }})
            </p>
            <p class="mb-0">
                <strong>Rol:</strong> {{ Auth::user()->roles->pluck('name')->first() }}
                @if(Auth::user()->hasRole('admin'))
                    <span class="badge badge-success ml-2">Acceso completo a backup y restore</span>
                @else
                    <span class="badge badge-warning ml-2">Solo backup - Restore requiere admin</span>
                @endif
            </p>
        </div>

        <div class="row">
            <!-- Crear Backup -->
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-database-add"></i>
                            Crear Copia de Seguridad
                        </h3>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">
                            <i class="bi bi-info-circle"></i>
                            Genera una copia de seguridad completa de la base de datos del sistema.
                        </p>
                        
                        <div class="alert alert-success">
                            <h6><i class="bi bi-check-circle"></i> Permisos:</h6>
                            <ul class="mb-0">
                                <li><strong>admines</strong>: Acceso completo</li>
                                <li><strong>Secretarias</strong>: Pueden crear backups</li>
                            </ul>
                        </div>

                        <form action="{{ route('admin.backup.create') }}" method="POST" id="form-backup">
                            @csrf
                            <div class="alert alert-info">
                                <h6><i class="bi bi-exclamation-triangle"></i> Información importante:</h6>
                                <ul class="mb-0">
                                    <li>El proceso puede tomar varios minutos</li>
                                    <li>Se incluirán todas las tablas, datos y procedimientos</li>
                                    <li>Base de datos actual: <strong>{{ env('DB_DATABASE') }}</strong></li>
                                    <li>Servidor: <strong>{{ env('DB_HOST') }}:{{ env('DB_PORT') }}</strong></li>
                                </ul>
                            </div>
                            <button type="button" class="btn btn-primary btn-block" onclick="confirmarBackup()">
                                <i class="bi bi-database-gear"></i>
                                Crear Backup Ahora
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Restaurar Backup -->
            <div class="col-md-6">
                <div class="card {{ Auth::user()->hasRole('admin') ? 'card-warning' : 'card-secondary' }}">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-database-up"></i>
                            Restaurar Base de Datos
                        </h3>
                    </div>
                    <div class="card-body">
                        @if(Auth::user()->hasRole('admin'))
                            <p class="text-muted">
                                <i class="bi bi-info-circle"></i>
                                Restaura la base de datos desde un archivo de backup existente.
                            </p>
                            @if(count($backups) > 0)
                                <form action="{{ route('admin.backup.restore') }}" method="POST" id="form-restore">
                                    @csrf
                                    <div class="form-group">
                                        <label for="backup_file">Seleccionar archivo de backup:</label>
                                        <select name="backup_file" id="backup_file" class="form-control" required>
                                            <option value="">Seleccione un archivo...</option>
                                            @foreach($backups as $backup)
                                                <option value="{{ $backup['filename'] }}">
                                                    {{ $backup['filename'] }} ({{ $backup['size'] }} - {{ $backup['created_at'] }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="alert alert-danger">
                                        <h6><i class="bi bi-exclamation-triangle-fill"></i> ¡ADVERTENCIA!</h6>
                                        <ul class="mb-0">
                                            <li><strong>Esta acción eliminará TODOS los datos actuales</strong></li>
                                            <li>Se recomienda crear un backup antes de restaurar</li>
                                            <li>El proceso es irreversible</li>
                                            <li>Todos los usuarios serán desconectados</li>
                                        </ul>
                                    </div>
                                    <button type="button" class="btn btn-warning btn-block" onclick="confirmarRestore()">
                                        <i class="bi bi-exclamation-triangle"></i>
                                        Restaurar Base de Datos
                                    </button>
                                </form>
                            @else
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle"></i>
                                    No hay archivos de backup disponibles. Cree un backup primero.
                                </div>
                            @endif
                        @else
                            <div class="alert alert-warning">
                                <h6><i class="bi bi-shield-exclamation"></i> Acceso Restringido</h6>
                                <p class="mb-0">
                                    Solo los <strong>admines</strong> pueden restaurar la base de datos.
                                    Como <strong>secretaria</strong>, puede crear y descargar backups únicamente.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de Backups Existentes -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-folder2-open"></i>
                            Archivos de Backup Disponibles
                        </h3>
                    </div>
                    <div class="card-body">
                        @if(count($backups) > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th><i class="bi bi-file-earmark-text"></i> Nombre del Archivo</th>
                                            <th><i class="bi bi-hdd"></i> Tamaño</th>
                                            <th><i class="bi bi-calendar2-date"></i> Fecha de Creación</th>
                                            <th><i class="bi bi-gear"></i> Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($backups as $backup)
                                            <tr>
                                                <td>
                                                    <i class="bi bi-file-earmark-zip text-primary"></i>
                                                    {{ $backup['filename'] }}
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">{{ $backup['size'] }}</span>
                                                </td>
                                                <td>
                                                    <i class="bi bi-clock"></i>
                                                    {{ $backup['created_at'] }}
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.backup.download', $backup['filename']) }}" 
                                                           class="btn btn-success btn-sm" 
                                                           title="Descargar backup">
                                                            <i class="bi bi-download"></i>
                                                        </a>
                                                        @if(Auth::user()->hasRole('admin'))
                                                            <button type="button" 
                                                                    class="btn btn-danger btn-sm" 
                                                                    onclick="confirmarEliminar('{{ $backup['filename'] }}')"
                                                                    title="Eliminar backup">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        @else
                                                            <button type="button" 
                                                                    class="btn btn-secondary btn-sm" 
                                                                    disabled
                                                                    title="Solo admines pueden eliminar">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info text-center">
                                <i class="bi bi-info-circle fs-1 text-muted mb-3"></i>
                                <h5>No hay backups disponibles</h5>
                                <p class="text-muted mb-0">
                                    Cree su primer backup usando el formulario de arriba.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Formulario oculto para eliminar -->
@if(Auth::user()->hasRole('admin'))
    <form id="form-eliminar" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endif

<script>
function confirmarBackup() {
    Swal.fire({
        title: '¿Crear copia de seguridad?',
        html: `
            <div class="text-start">
                <p><i class="bi bi-info-circle text-info"></i> Se creará un backup completo de:</p>
                <ul>
                    <li>Base de datos: <strong>{{ env('DB_DATABASE') }}</strong></li>
                    <li>Todas las tablas y datos</li>
                    <li>Procedimientos y triggers</li>
                </ul>
                <p class="text-muted"><i class="bi bi-clock"></i> El proceso puede tomar varios minutos.</p>
            </div>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="bi bi-check-circle"></i> Sí, crear backup',
        cancelButtonText: '<i class="bi bi-x-circle"></i> Cancelar',
        allowOutsideClick: false
    }).then((result) => {
        if (result.isConfirmed) {
            // Mostrar loading
            Swal.fire({
                title: 'Creando backup...',
                html: '<i class="bi bi-hourglass-split"></i> Por favor espere, esto puede tomar varios minutos.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
            // Enviar formulario
            document.getElementById('form-backup').submit();
        }
    });
}

@if(Auth::user()->hasRole('admin'))
function confirmarRestore() {
    const selectedFile = document.getElementById('backup_file').value;
    if (!selectedFile) {
        Swal.fire({
            icon: 'warning',
            title: 'Seleccione un archivo',
            text: 'Debe seleccionar un archivo de backup para continuar.'
        });
        return false;
    }
    
    Swal.fire({
        title: '⚠️ ADVERTENCIA CRÍTICA',
        html: `
            <div class="text-start">
                <p class="text-danger fw-bold">Esta acción:</p>
                <ul class="text-danger">
                    <li><strong>ELIMINARÁ todos los datos actuales</strong></li>
                    <li><strong>ES IRREVERSIBLE</strong></li>
                    <li><strong>Desconectará a todos los usuarios</strong></li>
                </ul>
                <hr>
                <p>Archivo seleccionado:</p>
                <p class="fw-bold text-primary">${selectedFile}</p>
                <p class="text-muted">¿Está completamente seguro de continuar?</p>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="bi bi-exclamation-triangle"></i> SÍ, RESTAURAR',
        cancelButtonText: '<i class="bi bi-x-circle"></i> Cancelar',
        allowOutsideClick: false,
        footer: '<p class="text-muted small">Se recomienda crear un backup antes de restaurar</p>'
    }).then((result) => {
        if (result.isConfirmed) {
            // Mostrar loading
            Swal.fire({
                title: 'Restaurando base de datos...',
                html: '<i class="bi bi-arrow-repeat"></i> Por favor espere, esto puede tomar varios minutos.<br><strong>NO cierre esta ventana.</strong>',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
            // Enviar formulario
            document.getElementById('form-restore').submit();
        }
    });
}

function confirmarEliminar(filename) {
    Swal.fire({
        title: '¿Eliminar backup?',
        html: `
            <p>¿Está seguro de eliminar este archivo de backup?</p>
            <p class="fw-bold text-primary">${filename}</p>
            <p class="text-danger"><i class="bi bi-exclamation-triangle"></i> Esta acción no se puede deshacer.</p>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="bi bi-trash"></i> Sí, eliminar',
        cancelButtonText: '<i class="bi bi-x-circle"></i> Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('form-eliminar');
            form.action = `/admin/backup/${filename}`;
            form.submit();
        }
    });
}
@endif
</script>

@endsection
