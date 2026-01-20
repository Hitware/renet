<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Credencial de Piloto</title>
    <style>
        @page {
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }
        .page {
            width: 210mm;
            height: 297mm;
            padding: 10mm;
            background: #fff;
        }

        /* TARJETA */
        .card {
            width: 85.6mm;
            height: 53.98mm;
            position: relative;
            border-radius: 4mm;
            overflow: hidden;
            margin-bottom: 10mm;
            color: #000;
            font-size: 5pt;
            border: 1px solid #333;
        }

        .card-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            z-index: 0;
        }

        .card-content {
            position: relative;
            z-index: 1;
            width: 100%;
            height: 100%;
        }

        /* FRENTE */
        .frente .header {
            background: rgba(255, 255, 255, 0.98);
            padding: 1.5mm 2mm;
            display: flex;
            align-items: center;
            gap: 1.5mm;
            height: 12mm;
            border-bottom: 0.5px solid #333;
        }

        .escudo {
            width: 8mm;
            height: 8mm;
            background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDAgMTAwIj48cGF0aCBmaWxsPSIjRkZENzAwIiBkPSJNNTAgNSBMOTAgMjAgTDkwIDUwIEM5MCA3NSA1MCA5NSA1MCA5NSBDNTAgOTUgMTAgNzUgMTAgNTAgTDEwIDIwIFoiLz48cGF0aCBmaWxsPSIjMDAzM0EwIiBkPSJNMjAgMzAgSDgwIFY0NSBIMjAgWiIvPjxwYXRoIGZpbGw9IiNDRTExMjYiIGQ9Ik0yMCA0NSBIODAgVjYwIEgyMCBaIi8+PC9zdmc+') no-repeat center center;
            background-size: contain;
        }

        .header-text {
            flex: 1;
        }

        .header-text h1 {
            font-size: 3.5pt;
            margin: 0;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.1px;
        }

        .header-text h2 {
            font-size: 5.5pt;
            margin: 0.5mm 0 0 0;
            font-weight: 900;
            text-transform: uppercase;
            color: #667eea;
        }

        .header-text h3 {
            font-size: 2.8pt;
            margin: 0.3mm 0 0 0;
            font-weight: normal;
        }

        .main-content {
            display: flex;
            padding: 3mm;
            gap: 3mm;
            background: rgba(255, 255, 255, 0.95);
            height: calc(100% - 12mm);
        }

        .photo-section {
            width: 22mm;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .photo {
            width: 20mm;
            height: 24mm;
            border: 1px solid #333;
            border-radius: 2mm;
            overflow: hidden;
            background: #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-placeholder {
            font-size: 8pt;
            color: #999;
        }

        .status-badge {
            margin-top: 1mm;
            padding: 0.5mm 2mm;
            border-radius: 2mm;
            font-size: 3pt;
            font-weight: bold;
            text-align: center;
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

        .info-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 1mm;
        }

        .nombre-completo {
            font-size: 6pt;
            font-weight: 900;
            text-transform: uppercase;
            color: #1f2937;
            margin-bottom: 0.5mm;
            border-bottom: 1px solid #667eea;
            padding-bottom: 0.5mm;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 0.3mm;
        }

        .info-label {
            font-size: 2.8pt;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: normal;
        }

        .info-value {
            font-size: 4pt;
            font-weight: bold;
            color: #000;
            text-align: right;
        }

        .licencia-box {
            background: #f3f4f6;
            padding: 1.5mm;
            border-radius: 1.5mm;
            margin-top: 1mm;
            border: 0.5px solid #d1d5db;
        }

        .licencia-tipo {
            font-size: 5pt;
            font-weight: 900;
            color: #667eea;
            text-align: center;
            margin-bottom: 0.5mm;
        }

        .licencia-numero {
            font-size: 3.5pt;
            text-align: center;
            font-weight: bold;
        }

        .vencimiento {
            font-size: 3pt;
            text-align: center;
            margin-top: 0.5mm;
        }

        .vigente {
            color: #10b981;
        }

        .vencida {
            color: #ef4444;
        }

        /* REVERSO */
        .reverso .card-content {
            padding: 3mm;
            background: rgba(255, 255, 255, 0.95);
        }

        .reverso-header {
            text-align: center;
            margin-bottom: 2mm;
            padding-bottom: 1mm;
            border-bottom: 1px solid #667eea;
        }

        .reverso-title {
            font-size: 5pt;
            font-weight: 900;
            color: #667eea;
            text-transform: uppercase;
        }

        .qr-section {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin: 2mm 0;
        }

        .qr-box {
            width: 22mm;
            height: 22mm;
            border: 1px solid #333;
            border-radius: 2mm;
            padding: 1mm;
            background: white;
        }

        .qr-box img {
            width: 100%;
            height: 100%;
        }

        .scan-text {
            font-size: 3pt;
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
            margin-top: 1mm;
            color: #667eea;
        }

        .certificaciones {
            margin-top: 2mm;
        }

        .cert-title {
            font-size: 3.5pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 0.5mm;
            color: #1f2937;
        }

        .cert-item {
            font-size: 2.8pt;
            margin-bottom: 0.3mm;
            padding-left: 1mm;
            color: #4b5563;
        }

        .footer-info {
            position: absolute;
            bottom: 2mm;
            left: 3mm;
            right: 3mm;
            text-align: center;
            font-size: 2.5pt;
            color: #6b7280;
            border-top: 0.5px solid #d1d5db;
            padding-top: 1mm;
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 20pt;
            color: rgba(102, 126, 234, 0.1);
            font-weight: 900;
            letter-spacing: 2px;
            pointer-events: none;
            z-index: 0;
        }
    </style>
</head>
<body>
    <div class="page">
        <!-- FRENTE -->
        <div class="card frente">
            <div class="card-bg"></div>
            <div class="watermark">RENET</div>
            <div class="card-content">
                <div class="header">
                    <div class="escudo"></div>
                    <div class="header-text">
                        <h1>REPUBLICA DE COLOMBIA</h1>
                        <h2>CREDENCIAL DE PILOTO</h2>
                        <h3>Registro Nacional de Embarcaciones y Tripulantes</h3>
                    </div>
                </div>

                <div class="main-content">
                    <div class="photo-section">
                        <div class="photo">
                            @if($piloto->foto_perfil)
                                <img src="{{ public_path('storage/' . $piloto->foto_perfil) }}" alt="Foto">
                            @else
                                <span class="photo-placeholder">FOTO</span>
                            @endif
                        </div>
                        <div class="status-badge status-{{ $piloto->estado }}">
                            {{ strtoupper($piloto->estado) }}
                        </div>
                    </div>

                    <div class="info-section">
                        <div class="nombre-completo">{{ strtoupper($piloto->nombre_completo) }}</div>

                        <div class="info-row">
                            <span class="info-label">Documento</span>
                            <span class="info-value">{{ $piloto->tipo_documento }} {{ $piloto->numero_documento }}</span>
                        </div>

                        <div class="info-row">
                            <span class="info-label">Fecha de Nacimiento</span>
                            <span class="info-value">{{ $piloto->fecha_nacimiento->format('d/m/Y') }}</span>
                        </div>

                        <div class="info-row">
                            <span class="info-label">Experiencia</span>
                            <span class="info-value">{{ $piloto->anos_experiencia }} años</span>
                        </div>

                        <div class="licencia-box">
                            <div class="licencia-tipo">{{ strtoupper($piloto->licencia_tipo) }}</div>
                            <div class="licencia-numero">Lic. No. {{ $piloto->licencia_numero }}</div>
                            <div class="vencimiento {{ $piloto->licenciaVigente() ? 'vigente' : 'vencida' }}">
                                <strong>Vencimiento:</strong> {{ $piloto->licencia_fecha_vencimiento->format('d/m/Y') }}
                                @if($piloto->licenciaVigente())
                                    (VIGENTE)
                                @else
                                    (VENCIDA)
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- REVERSO -->
        <div class="card reverso">
            <div class="card-bg"></div>
            <div class="watermark">RENET</div>
            <div class="card-content">
                <div class="reverso-header">
                    <div class="reverso-title">Verificación de Credencial</div>
                </div>

                <div class="qr-section">
                    <div class="qr-box">
                        <img src="{{ route('qr.generar', $piloto->codigo_qr) }}" alt="QR">
                    </div>
                    <div class="scan-text">Escanee para verificar<br>información del piloto</div>
                </div>

                <div class="certificaciones">
                    <div class="cert-title">Certificaciones Vigentes:</div>
                    @forelse($piloto->getCertificacionesVigentes() as $cert)
                        <div class="cert-item">• {{ $cert->tipo_certificacion }} - Vence: {{ $cert->fecha_vencimiento->format('d/m/Y') }}</div>
                    @empty
                        <div class="cert-item">• No hay certificaciones registradas</div>
                    @endforelse
                </div>

                <div class="footer-info">
                    <div>RENET - Registro Nacional de Embarcaciones y Tripulantes</div>
                    <div>Código de Verificación: {{ strtoupper(substr($piloto->codigo_qr, 0, 8)) }}</div>
                    <div>Expedido: {{ now()->format('d/m/Y') }}</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
