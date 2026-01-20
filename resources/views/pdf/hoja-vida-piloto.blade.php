<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Hoja de Vida - {{ $piloto->nombre_completo }}</title>
    <style>
        @page {
            margin: 15mm;
        }
        body {
            font-family: 'Arial', sans-serif;
            font-size: 10pt;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            padding-bottom: 10mm;
            border-bottom: 2px solid #667eea;
            margin-bottom: 8mm;
        }
        .header h1 {
            font-size: 18pt;
            color: #667eea;
            margin: 0 0 2mm 0;
            text-transform: uppercase;
            font-weight: 900;
        }
        .header h2 {
            font-size: 14pt;
            color: #4b5563;
            margin: 0 0 3mm 0;
            font-weight: normal;
        }
        .documento-info {
            text-align: center;
            font-size: 9pt;
            color: #6b7280;
        }
        .section {
            margin-bottom: 6mm;
        }
        .section-title {
            background: #667eea;
            color: white;
            padding: 2mm 3mm;
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 3mm;
        }
        .personal-info {
            display: table;
            width: 100%;
            margin-bottom: 4mm;
        }
        .info-row {
            display: table-row;
        }
        .info-label {
            display: table-cell;
            width: 30%;
            font-weight: bold;
            padding: 1.5mm 0;
            color: #4b5563;
        }
        .info-value {
            display: table-cell;
            padding: 1.5mm 0;
            color: #1f2937;
        }
        .licencia-box {
            background: #f3f4f6;
            border-left: 4px solid #667eea;
            padding: 4mm;
            margin: 3mm 0;
        }
        .licencia-box h3 {
            margin: 0 0 2mm 0;
            color: #667eea;
            font-size: 12pt;
        }
        .status-badge {
            display: inline-block;
            padding: 1mm 3mm;
            border-radius: 2mm;
            font-size: 8pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-activo {
            background: #10b981;
            color: white;
        }
        .status-inactivo {
            background: #ef4444;
            color: white;
        }
        .vigente {
            background: #dcfce7;
            color: #166534;
        }
        .vencida {
            background: #fee2e2;
            color: #991b1b;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 3mm;
        }
        table th {
            background: #f3f4f6;
            padding: 2mm;
            text-align: left;
            font-size: 9pt;
            border-bottom: 1px solid #d1d5db;
        }
        table td {
            padding: 2mm;
            font-size: 9pt;
            border-bottom: 1px solid #e5e7eb;
        }
        .experiencia-item {
            background: #f9fafb;
            padding: 3mm;
            margin-bottom: 2mm;
            border-left: 3px solid #667eea;
        }
        .experiencia-item h4 {
            margin: 0 0 1mm 0;
            color: #1f2937;
            font-size: 10pt;
        }
        .experiencia-item p {
            margin: 0.5mm 0;
            font-size: 8.5pt;
            color: #6b7280;
        }
        .footer {
            position: fixed;
            bottom: 10mm;
            left: 15mm;
            right: 15mm;
            text-align: center;
            font-size: 8pt;
            color: #9ca3af;
            padding-top: 3mm;
            border-top: 1px solid #e5e7eb;
        }
        .qr-section {
            position: absolute;
            top: 15mm;
            right: 15mm;
            text-align: center;
        }
        .qr-box {
            width: 25mm;
            height: 25mm;
            border: 1px solid #d1d5db;
            padding: 1mm;
        }
        .qr-box img {
            width: 100%;
            height: 100%;
        }
        .qr-label {
            font-size: 7pt;
            color: #6b7280;
            margin-top: 1mm;
        }
        .page-break {
            page-break-after: always;
        }
        .grid-2 {
            display: table;
            width: 100%;
        }
        .grid-col {
            display: table-cell;
            width: 50%;
            padding-right: 3mm;
        }
        .no-data {
            text-align: center;
            padding: 5mm;
            color: #9ca3af;
            font-style: italic;
        }
    </style>
</head>
<body>
    <!-- QR Code en la esquina -->
    <div class="qr-section">
        <div class="qr-box">
            <img src="{{ route('qr.generar', $piloto->codigo_qr) }}" alt="QR">
        </div>
        <div class="qr-label">Código de Verificación</div>
    </div>

    <!-- Header -->
    <div class="header">
        <h1>{{ strtoupper($piloto->nombre_completo) }}</h1>
        <h2>{{ $piloto->licencia_tipo }}</h2>
        <div class="documento-info">
            <strong>Licencia No.:</strong> {{ $piloto->licencia_numero }} |
            <strong>Documento:</strong> {{ $piloto->tipo_documento }} {{ $piloto->numero_documento }}
        </div>
    </div>

    <!-- Información Personal -->
    <div class="section">
        <div class="section-title">Información Personal</div>
        <div class="personal-info">
            <div class="info-row">
                <div class="info-label">Nombre Completo:</div>
                <div class="info-value">{{ $piloto->nombre_completo }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Tipo de Documento:</div>
                <div class="info-value">{{ $piloto->tipo_documento }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Número de Documento:</div>
                <div class="info-value">{{ $piloto->numero_documento }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Fecha de Nacimiento:</div>
                <div class="info-value">{{ $piloto->fecha_nacimiento->format('d/m/Y') }} ({{ $piloto->fecha_nacimiento->age }} años)</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email:</div>
                <div class="info-value">{{ $piloto->email }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Teléfono:</div>
                <div class="info-value">{{ $piloto->telefono }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Dirección:</div>
                <div class="info-value">{{ $piloto->direccion }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Estado:</div>
                <div class="info-value">
                    <span class="status-badge status-{{ $piloto->estado }}">{{ strtoupper($piloto->estado) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Información de Licencia -->
    <div class="section">
        <div class="section-title">Información de Licencia y Experiencia</div>
        <div class="licencia-box">
            <h3>{{ $piloto->licencia_tipo }}</h3>
            <div class="grid-2">
                <div class="grid-col">
                    <div class="personal-info">
                        <div class="info-row">
                            <div class="info-label">Número de Licencia:</div>
                            <div class="info-value">{{ $piloto->licencia_numero }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Tipo:</div>
                            <div class="info-value">{{ $piloto->licencia_tipo }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Fecha de Expedición:</div>
                            <div class="info-value">{{ $piloto->licencia_fecha_expedicion->format('d/m/Y') }}</div>
                        </div>
                    </div>
                </div>
                <div class="grid-col">
                    <div class="personal-info">
                        <div class="info-row">
                            <div class="info-label">Fecha de Vencimiento:</div>
                            <div class="info-value">
                                {{ $piloto->licencia_fecha_vencimiento->format('d/m/Y') }}
                                <span class="status-badge {{ $piloto->licenciaVigente() ? 'vigente' : 'vencida' }}">
                                    {{ $piloto->licenciaVigente() ? 'VIGENTE' : 'VENCIDA' }}
                                </span>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Años de Experiencia:</div>
                            <div class="info-value"><strong>{{ $piloto->anos_experiencia }} años</strong></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Certificaciones -->
    <div class="section">
        <div class="section-title">Certificaciones y Cursos</div>
        @if($piloto->certificaciones->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Tipo de Certificación</th>
                        <th>Institución Emisora</th>
                        <th>No. Certificado</th>
                        <th>Expedición</th>
                        <th>Vencimiento</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($piloto->certificaciones as $cert)
                        <tr>
                            <td><strong>{{ $cert->tipo_certificacion }}</strong></td>
                            <td>{{ $cert->institucion_emisora }}</td>
                            <td>{{ $cert->numero_certificado ?? 'N/A' }}</td>
                            <td>{{ $cert->fecha_expedicion->format('d/m/Y') }}</td>
                            <td>{{ $cert->fecha_vencimiento->format('d/m/Y') }}</td>
                            <td>
                                <span class="status-badge {{ $cert->estaVigente() ? 'vigente' : 'vencida' }}">
                                    {{ $cert->estaVigente() ? 'Vigente' : 'Vencida' }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">No hay certificaciones registradas</div>
        @endif
    </div>

    <!-- Historial de Navegación -->
    <div class="section">
        <div class="section-title">Experiencia Laboral y Historial de Navegación</div>
        @if($piloto->historialNavegacion->count() > 0)
            @foreach($piloto->historialNavegacion->sortByDesc('fecha_inicio') as $historial)
                <div class="experiencia-item">
                    <h4>
                        {{ $historial->embarcacion->nombre ?? 'Embarcación no registrada' }}
                        @if(!$historial->fecha_fin)
                            <span class="status-badge vigente" style="float: right;">ACTIVO</span>
                        @endif
                    </h4>
                    <p><strong>Cargo:</strong> {{ $historial->cargo }}</p>
                    <p><strong>Periodo:</strong> {{ $historial->fecha_inicio->format('d/m/Y') }} - {{ $historial->fecha_fin ? $historial->fecha_fin->format('d/m/Y') : 'Presente' }}</p>
                    @if($historial->embarcacion)
                        <p><strong>Tipo de Embarcación:</strong> {{ ucfirst(str_replace('_', ' ', $historial->embarcacion->tipo)) }} |
                        <strong>Matrícula:</strong> {{ $historial->embarcacion->matricula }}</p>
                    @endif
                    @if($historial->observaciones)
                        <p><strong>Observaciones:</strong> {{ $historial->observaciones }}</p>
                    @endif
                </div>
            @endforeach
        @else
            <div class="no-data">No hay historial de navegación registrado</div>
        @endif
    </div>

    <!-- Información de Empresa -->
    @if($piloto->empresa)
    <div class="section">
        <div class="section-title">Empresa Actual</div>
        <div class="personal-info">
            <div class="info-row">
                <div class="info-label">Razón Social:</div>
                <div class="info-value">{{ $piloto->empresa->razon_social }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">NIT:</div>
                <div class="info-value">{{ $piloto->empresa->nit }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Representante Legal:</div>
                <div class="info-value">{{ $piloto->empresa->representante_legal }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Contacto:</div>
                <div class="info-value">{{ $piloto->empresa->telefono }} | {{ $piloto->empresa->email }}</div>
            </div>
        </div>
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p><strong>RENET - Registro Nacional de Embarcaciones y Tripulantes</strong></p>
        <p>Documento generado el {{ now()->format('d/m/Y H:i:s') }} | Código de Verificación: {{ strtoupper(substr($piloto->codigo_qr, 0, 12)) }}</p>
        <p style="font-size: 7pt; margin-top: 2mm;">Este documento es de carácter informativo y puede ser verificado en {{ route('verificar.piloto') }}</p>
    </div>
</body>
</html>
