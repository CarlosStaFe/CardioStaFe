<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Eventos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #333;
        }
        .info {
            margin-bottom: 15px;
        }
        .filtros {
            background-color: #f5f5f5;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .filtros h3 {
            margin: 0 0 10px 0;
            color: #333;
        }
        .filtro-item {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
            padding: 8px;
            text-align: left;
            font-weight: bold;
        }
        td {
            padding: 6px;
            vertical-align: top;
        }
        .estado-disponible {
            color: #28a745;
            font-weight: bold;
        }
        .estado-reservado {
            color: #dc3545;
            font-weight: bold;
        }
        .estado-espera {
            color: #ffc107;
            font-weight: bold;
        }
        .estado-atendido {
            color: #17a2b8;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .total-eventos {
            background-color: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header" style="display: flex; align-items: center; justify-content: flex-start;">
        <img src="{{ public_path('assets/img/LogoCompleto.jpg') }}" alt="Logo" style="height: 60px; margin-right: 20px;">
        <div style="flex: 1; text-align: left;">
            <h2 style="margin: 0;">REPORTE DE HORARIOS Y RESERVAS</h2>
        </div>
    </div>

    <div class="info">
        <!--<p><strong>Generado por:</strong> {{ $usuario }}</p>-->
        <p><strong>Fecha de generación:</strong> {{ $fecha_generacion }}</p>
    </div>

    @if(!empty($filtros))
    <div class="filtros">
        <h3>Filtros Aplicados:</h3>
        @if(isset($filtros['consultorio']))
            <div class="filtro-item"><strong>Consultorio:</strong> {{ $filtros['consultorio'] }}</div>
        @endif
        @if(isset($filtros['medico']))
            <div class="filtro-item"><strong>Médico:</strong> {{ $filtros['medico'] }}</div>
        @endif
        @if(isset($filtros['fecha_desde']) && isset($filtros['fecha_hasta']))
            <div class="filtro-item"><strong>Fecha desde:</strong> {{ \Carbon\Carbon::createFromFormat('Y-m-d', $filtros['fecha_desde'])->format('d-m-Y') }} - <strong>Fecha hasta:</strong> {{ \Carbon\Carbon::createFromFormat('Y-m-d', $filtros['fecha_hasta'])->format('d-m-Y') }}</div>
        @elseif(isset($filtros['fecha_desde']))
            <div class="filtro-item"><strong>Fecha desde:</strong> {{ \Carbon\Carbon::createFromFormat('Y-m-d', $filtros['fecha_desde'])->format('d-m-Y') }}</div>
        @elseif(isset($filtros['fecha_hasta']))
            <div class="filtro-item"><strong>Fecha hasta:</strong> {{ \Carbon\Carbon::createFromFormat('Y-m-d', $filtros['fecha_hasta'])->format('d-m-Y') }}</div>
        @endif
        @if(isset($filtros['estado']))
            <div class="filtro-item"><strong>Estado:</strong> {{ $filtros['estado'] }}</div>
        @endif
    </div>
    @endif

    <div class="total-eventos">
        <strong>Total de eventos encontrados:</strong> {{ $eventos->count() }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 8%;">Fecha</th>
                <th style="width: 5%;">Hora</th>
                <th style="width: 10%;">Consultorio</th>
                <th style="width: 15%;">Médico</th>
                <th style="width: 15%;">Práctica</th>
                <th style="width: 10%;">Estado</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            @forelse($eventos as $evento)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($evento->start)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($evento->start)->format('H:i') }}</td>
                    <td>{{ $evento->consultorio->nombre ?? 'Sin asignar' }}</td>
                    <td>{{ $evento->medico->apel_nombres ?? 'Sin asignar' }}</td>
                    <td>{{ $evento->practica->nombre ?? 'Sin asignar' }}</td>
                    <td>
                        @php
                            $claseEstado = 'estado-disponible';
                            if (str_contains($evento->title, 'Reservado')) {
                                $claseEstado = 'estado-reservado';
                            } elseif (str_contains($evento->title, 'Espera')) {
                                $claseEstado = 'estado-espera';
                            } elseif (str_contains($evento->title, 'Atendido')) {
                                $claseEstado = 'estado-atendido';
                            }
                        @endphp
                        <span class="{{ $claseEstado }}">{{ $evento->title }}</span>
                    </td>
                    <td>{{ $evento->description ?? 'Sin descripción' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #666; font-style: italic;">
                        No se encontraron eventos con los filtros aplicados
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <!--<p>Documento generado automáticamente por el Sistema de Gestión de Citas Médicas</p>-->
        <!--<p>{{ now()->format('d/m/Y H:i:s') }}</p>-->
    </div>
</body>
</html>
