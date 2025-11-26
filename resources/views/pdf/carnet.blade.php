<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tarjeta de Registro - Embarcación</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Times New Roman', serif; }
        .page { width: 210mm; padding: 15mm; display: flex; gap: 10mm; }
        .tarjeta { width: 85.6mm; height: 53.98mm; background: #fff; border: 1px solid #2c3e50; position: relative; box-shadow: 0 0 3mm rgba(0,0,0,0.1); }
        
        /* FRENTE */
        .frente .header { background: #003d7a; color: #fff; padding: 1.8mm 3mm; border-bottom: 1mm solid #ffd700; }
        .frente .header h1 { font-size: 8.5pt; font-weight: bold; letter-spacing: 1px; margin-bottom: 0.5mm; text-align: center; text-transform: uppercase; }
        .frente .header p { font-size: 5.5pt; letter-spacing: 0.4px; text-align: center; color: #e8e8e8; text-transform: uppercase; }
        .frente .body { padding: 2.5mm 3mm 12mm 3mm; }
        .frente .row { display: flex; gap: 2.5mm; }
        .frente .col-left { width: 25mm; }
        .frente .col-right { flex: 1; }
        .frente .foto { width: 25mm; height: 18mm; border: 1px solid #003d7a; background: #f5f5f5; }
        .frente .foto img { width: 100%; height: 100%; object-fit: cover; }
        .frente .field { margin-bottom: 1.3mm; border-bottom: 0.5px solid #d0d0d0; padding-bottom: 0.8mm; }
        .frente .field-label { font-size: 5pt; color: #003d7a; font-weight: bold; text-transform: uppercase; letter-spacing: 0.2px; }
        .frente .field-value { font-size: 7pt; color: #000; font-weight: bold; margin-top: 0.3mm; line-height: 1.1; }
        .frente .divider { display: none; }
        .frente .matricula-section { position: absolute; bottom: 2mm; left: 3mm; right: 3mm; background: #f8f8f8; border: 1px solid #003d7a; padding: 1mm 2mm; display: flex; justify-content: space-between; align-items: center; }
        .frente .matricula-box { flex: 1; }
        .frente .matricula-label { font-size: 5pt; color: #003d7a; font-weight: bold; letter-spacing: 0.5px; text-transform: uppercase; }
        .frente .matricula-value { font-size: 9pt; color: #000; font-weight: bold; letter-spacing: 1.5px; margin-top: 0.3mm; font-family: 'Courier New', monospace; }
        
        /* REVERSO */
        .reverso { background: linear-gradient(to bottom, #ffffff 0%, #f8f9fa 100%); }
        .reverso .header { background: linear-gradient(to bottom, #1a2332 0%, #2c3e50 100%); color: #fff; padding: 1.2mm 3mm; text-align: center; border-bottom: 0.5mm solid #c9b037; }
        .reverso .header h2 { font-size: 7.5pt; font-weight: normal; letter-spacing: 0.8px; }
        .reverso .body { padding: 2.5mm 3mm; text-align: center; }
        .reverso .qr-box { width: 28mm; height: 28mm; margin: 1mm auto 1.5mm; border: 0.5px solid #7f8c8d; background: #fff; padding: 0.8mm; }
        .reverso .qr-box img { width: 100%; height: 100%; }
        .reverso .codigo { font-size: 6pt; color: #2c3e50; font-family: 'Courier New', monospace; font-weight: normal; margin: 0.8mm 0; letter-spacing: 0.3px; }
        .reverso .url { font-size: 5pt; color: #5a6c7d; font-weight: normal; }
        .reverso .divider { height: 0.2mm; background: linear-gradient(to right, #c9b037 0%, #f4e5a1 50%, #c9b037 100%); margin: 1.5mm auto; width: 70%; }
        .reverso .footer { position: absolute; bottom: 1.5mm; left: 2.5mm; right: 2.5mm; border-top: 0.3px solid #bdc3c7; padding-top: 0.8mm; }
        .reverso .footer p { font-size: 4.5pt; color: #5a6c7d; text-align: justify; line-height: 1.4; }
        .reverso .estado { display: inline-block; padding: 0.8mm 2.5mm; margin-top: 0.8mm; font-size: 5.5pt; font-weight: normal; border: 0.3px solid; letter-spacing: 0.5px; }
        .reverso .estado.disponible { background: #d5f4e6; color: #27ae60; border-color: #27ae60; }
        .reverso .estado.no-disponible { background: #fadbd8; color: #c0392b; border-color: #c0392b; }
    </style>
</head>
<body>
    <div class="page">
        <!-- FRENTE -->
        <div class="tarjeta frente">
            <div class="header">
                <h1>REPÚBLICA DE COLOMBIA</h1>
                <p>REGISTRO NACIONAL DE EMBARCACIONES Y TRIPULANTES</p>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-left">
                        <div class="foto">
                            @if($embarcacion->imagenPrincipal)
                                <img src="{{ public_path('storage/' . $embarcacion->imagenPrincipal->ruta) }}" alt="Foto">
                            @endif
                        </div>
                    </div>
                    <div class="col-right">
                        <div class="field">
                            <div class="field-label">Embarcación</div>
                            <div class="field-value">{{ strtoupper($embarcacion->nombre) }}</div>
                        </div>
                        <div class="field">
                            <div class="field-label">Propietario</div>
                            <div class="field-value">{{ strtoupper($embarcacion->empresa->razon_social) }}</div>
                        </div>
                        <div class="field">
                            <div class="field-label">Tipo</div>
                            <div class="field-value">{{ strtoupper(str_replace('_', ' ', $embarcacion->tipo)) }}</div>
                        </div>
                        <div class="field">
                            <div class="field-label">Capacidad</div>
                            <div class="field-value">{{ $embarcacion->capacidad_pasajeros }} PASAJEROS</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="matricula-section">
                <div class="matricula-box">
                    <div class="matricula-label">Matrícula</div>
                    <div class="matricula-value">{{ $embarcacion->matricula }}</div>
                </div>
            </div>
        </div>
        
        <!-- REVERSO -->
        <div class="tarjeta reverso">
            <div class="header">
                <h2>CÓDIGO DE VERIFICACIÓN DIGITAL</h2>
            </div>
            <div class="body">
                <div class="qr-box">
                    <img src="{{ route('qr.generar', $embarcacion->codigo_qr) }}" alt="QR">
                </div>
                <div class="codigo">{{ $embarcacion->codigo_qr }}</div>
                <div class="url">{{ route('verificar') }}</div>
            </div>
            <div class="footer">
                <p>Esta tarjeta certifica el registro de la embarcación ante RENET. La validez está sujeta a la vigencia de los documentos obligatorios. Verifique el estado actual escaneando el código QR.</p>
            </div>
        </div>
    </div>
</body>
</html>
