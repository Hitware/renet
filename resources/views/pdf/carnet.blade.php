<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Carnet Marítimo - {{ $embarcacion->nombre }}</title>
    <style>
        @page {
            size: 85.6mm 54mm;
            margin: 0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
        }

        .carnet {
            width: 85.6mm;
            height: 54mm;
            position: relative;
            overflow: hidden;
            page-break-after: always;
            page-break-inside: avoid;
        }

        .carnet:last-child {
            page-break-after: avoid;
        }

        /* Imagen de fondo */
        .fondo-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 85.6mm;
            height: 54mm;
            z-index: 0;
            border-radius: 3mm;
        }

        /* ============================================
           CARA FRONTAL
           ============================================ */
        .carnet-front {
            background: transparent;
            border-radius: 3mm;
        }

        .contenido {
            position: relative;
            z-index: 1;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.85);
            border-radius: 3mm;
        }

        /* Encabezado - Igual que carnet.html */
        .encabezado {
            position: absolute;
            top: 0;
            left: 0;
            width: 85.6mm;
            height: 10mm;
            background: transparent;
        }

        .encabezado-tabla {
            width: 100%;
            height: 10mm;
            border-collapse: collapse;
        }

        .encabezado-tabla td {
            vertical-align: middle;
            padding: 1.5mm 2.5mm;
        }

        .escudo-col {
            width: 9mm;
            padding: 1mm 1.5mm;
        }

        .escudo-img {
            width: 7mm;
            height: auto;
        }

        .titulo-col {
            text-align: left;
            padding: 0.5mm 1mm 0.5mm 0.5mm;
        }

        .titulo-principal {
            font-size: 1.4mm;
            font-weight: bold;
            color: #000;
            line-height: 1.4;
        }

        .subtitulo {
            font-size: 1.3mm;
            color: #000;
            margin-top: 0.3mm;
            font-weight: normal;
        }

        .logos-col {
            width: 16mm;
            text-align: right;
            padding: 1mm 2mm;
        }

        .bandera-img {
            width: 6mm;
            height: 4mm;
            vertical-align: middle;
            border-radius: 0.5mm;
        }

        .escudo-cartagena-img {
            width: 6mm;
            height: 4mm;
            vertical-align: middle;
            margin-left: 1.5mm;
        }

        /* Barra empresa - Igual que carnet.html */
        .empresa-barra {
            position: absolute;
            top: 10mm;
            left: 0;
            width: 85.6mm;
            height: 7.5mm;
            background: transparent;
            color: #000;
            padding: 1mm 2.5mm;
        }

        .empresa-nombre {
            font-size: 1.7mm;
            font-weight: bold;
            margin-bottom: 0.3mm;
            color: #000;
        }

        .empresa-resolucion {
            font-size: 1.5mm;
            margin-bottom: 0.2mm;
            color: #000;
        }

        .empresa-licencia {
            font-size: 1.3mm;
            color: #000;
        }

        /* Datos técnicos - Igual que carnet.html */
        .datos-tecnicos {
            position: absolute;
            top: 17.5mm;
            left: 0;
            width: 85.6mm;
            height: 36.5mm;
            padding: 2mm 3mm;
            background: transparent;
        }

        /* Fila de registro */
        .fila-registro {
            width: 100%;
            margin-bottom: 2mm;
            padding-bottom: 1.5mm;
            border-bottom: 0.3mm solid #ccc;
        }

        .registro-tabla {
            width: 100%;
            border-collapse: collapse;
        }

        .registro-tabla td {
            vertical-align: top;
            padding-right: 4mm;
        }

        .campo-registro-label {
            font-size: 1.4mm;
            color: #444;
            line-height: 1.3;
        }

        .campo-registro-label-en {
            font-size: 1.1mm;
            color: #666;
            font-style: italic;
            display: block;
        }

        .campo-registro-valor {
            font-size: 1.9mm;
            font-weight: bold;
            color: #000;
            border: 0.4mm solid #000;
            padding: 0.6mm 2mm;
            margin-top: 0.6mm;
            background: white;
            display: inline-block;
        }

        /* Filas de datos - Igual que carnet.html */
        .datos-tabla {
            width: 100%;
            border-collapse: collapse;
        }

        .datos-tabla tr {
            height: 3.8mm;
        }

        .datos-tabla td {
            vertical-align: middle;
            padding: 0.25mm 0;
        }

        .col-izq {
            width: 50%;
        }

        .col-der {
            width: 50%;
            padding-left: 4mm;
        }

        .fila-dato-tabla {
            width: 100%;
            border-collapse: collapse;
        }

        .fila-dato-tabla td {
            vertical-align: middle;
            padding: 0;
        }

        .dato-label {
            font-size: 1.3mm;
            color: #333;
            min-width: 19mm;
            width: 19mm;
        }

        .dato-valor {
            font-size: 1.6mm;
            font-weight: bold;
            color: #000;
        }

        .dato-valor-small {
            font-size: 1.2mm;
            font-weight: bold;
            color: #000;
        }

        /* ============================================
           CARA POSTERIOR
           ============================================ */
        .carnet-back {
            background: transparent;
            border-radius: 3mm;
        }

        .contenido-posterior {
            position: absolute;
            z-index: 1;
            top: 0;
            left: 0;
            width: 85.6mm;
            height: 54mm;
            background: rgba(255,255,255,0.75);
            padding: 3mm;
            box-sizing: border-box;
            border-radius: 3mm;
        }

        .back-tabla {
            width: 100%;
            border-collapse: collapse;
        }

        .back-tabla td {
            vertical-align: middle;
        }

        .col-propietario {
            width: 50%;
            padding-right: 2mm;
        }

        .col-empresa-qr {
            width: 50%;
        }

        .campo-prop {
            margin-bottom: 1.5mm;
        }

        .campo-prop-tabla {
            width: 100%;
            border-collapse: collapse;
        }

        .campo-prop-tabla td {
            vertical-align: middle;
            padding: 0;
        }

        .campo-prop-label {
            font-size: 1.3mm;
            color: #000;
            font-weight: bold;
            padding-right: 2mm;
            width: 35%;
            text-align: left;
        }

        .campo-prop-valor {
            font-size: 1.5mm;
            color: #000;
            text-align: left;
        }

        .info-empresa {
            text-align: right;
            background: rgba(255,255,255,0.6);
            padding: 1.5mm 2mm;
            border-radius: 0.8mm;
            margin-bottom: 2mm;
        }

        .info-empresa-nombre {
            font-size: 1.7mm;
            font-weight: bold;
            color: #111;
            margin-bottom: 0.8mm;
        }

        .info-empresa-nit-label {
            font-size: 1.5mm;
            font-weight: bold;
            color: #333;
        }

        .info-empresa-nit-valor {
            font-size: 1.6mm;
            color: #000;
            margin-bottom: 1mm;
        }

        .info-empresa-contacto {
            font-size: 1.4mm;
            color: #222;
            line-height: 1.4;
        }

        .seccion-qr {
            text-align: center;
            margin-top: 2mm;
        }

        .qr-texto {
            font-size: 1.4mm;
            color: #000;
            font-weight: bold;
            line-height: 1.4;
            margin-bottom: 2mm;
        }

        .qr-img {
            width: 18mm;
            height: 18mm;
        }

        .pie-posterior {
            position: absolute;
            bottom: 1mm;
            left: 3mm;
            right: 3mm;
            text-align: center;
            font-size: 1.6mm;
            color: #000;
            font-weight: bold;
            z-index: 10;
        }
    </style>
</head>
<body>

<!-- ============================================
     PÁGINA 1: CARA FRONTAL
     ============================================ -->
<div class="carnet carnet-front">
    <!-- Imagen de fondo -->
    <img class="fondo-img" src="{{ $fondoFrontal }}" alt="">

    <div class="contenido">
        <!-- Encabezado -->
        <div class="encabezado">
            <table class="encabezado-tabla">
                <tr>
                    <td class="escudo-col">
                        <img class="escudo-img" src="{{ $escudoColombia }}" alt="Escudo">
                    </td>
                    <td class="titulo-col">
                        <div class="titulo-principal">CARTAGENA DE INDIAS DISTRITO TURISTICO Y CULTURAL</div>
                        <div class="subtitulo">REPÚBLICA DE COLOMBIA</div>
                    </td>
                    <td class="logos-col">
                        <img class="bandera-img" src="{{ $banderaColombia }}" alt="Bandera">
                        <img class="escudo-cartagena-img" src="{{ $escudoCartagena }}" alt="Cartagena">
                    </td>
                </tr>
            </table>
        </div>

        <!-- Barra empresa -->
        <div class="empresa-barra">
            <div class="empresa-nombre">{{ strtoupper($embarcacion->empresa->razon_social ?? 'EMPRESA NO DEFINIDA') }}</div>
            <div class="empresa-resolucion">RESOLUCIÓN EMPRESA DE TRANSPORTE MARÍTIMO NO. 0367-2022 DIMAR</div>
            <div class="empresa-licencia">LICENCIA DE AFILIACIÓN E.T.M</div>
        </div>

        <!-- Datos técnicos -->
        <div class="datos-tecnicos">
            <!-- Fila de registro -->
            <div class="fila-registro">
                <table class="registro-tabla">
                    <tr>
                        <td>
                            <span class="campo-registro-label">No. de REGISTRO<span class="campo-registro-label-en">OFFICIAL NUMBER</span></span>
                            <span class="campo-registro-valor">{{ $embarcacion->matricula }}</span>
                        </td>
                        <td>
                            <span class="campo-registro-label">PUERTO DE REGISTRO<span class="campo-registro-label-en">PORT OF REGISTRY</span></span>
                            <span class="campo-registro-valor">CARTAGENA</span>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Filas de datos -->
            <table class="datos-tabla">
                <tr>
                    <td class="col-izq">
                        <table class="fila-dato-tabla"><tr>
                            <td class="dato-label">NOMBRE DE LA NAVE</td>
                            <td class="dato-valor">{{ strtoupper($embarcacion->nombre) }}</td>
                        </tr></table>
                    </td>
                    <td class="col-der">
                        <table class="fila-dato-tabla"><tr>
                            <td class="dato-label">DISTINTIVO DE LLAMADA</td>
                            <td class="dato-valor">{{ $embarcacion->distintivo_llamada ?? 'N/A' }}</td>
                        </tr></table>
                    </td>
                </tr>
                <tr>
                    <td class="col-izq">
                        <table class="fila-dato-tabla"><tr>
                            <td class="dato-label">ESLORA</td>
                            <td class="dato-valor">{{ $embarcacion->eslora }}</td>
                        </tr></table>
                    </td>
                    <td class="col-der">
                        <table class="fila-dato-tabla"><tr>
                            <td class="dato-label">MMSI</td>
                            <td class="dato-valor">{{ $embarcacion->mmsi ?? 'N/A' }}</td>
                        </tr></table>
                    </td>
                </tr>
                <tr>
                    <td class="col-izq">
                        <table class="fila-dato-tabla"><tr>
                            <td class="dato-label">MANGA</td>
                            <td class="dato-valor">{{ $embarcacion->manga }}</td>
                        </tr></table>
                    </td>
                    <td class="col-der">
                        <table class="fila-dato-tabla"><tr>
                            <td class="dato-label">NÚMERO MÁXIMO DE PASAJEROS</td>
                            <td class="dato-valor">{{ $embarcacion->capacidad_pasajeros }} + 2</td>
                        </tr></table>
                    </td>
                </tr>
                <tr>
                    <td class="col-izq">
                        <table class="fila-dato-tabla"><tr>
                            <td class="dato-label">PUNTAL</td>
                            <td class="dato-valor">{{ $embarcacion->puntal ?? 'N/A' }}</td>
                        </tr></table>
                    </td>
                    <td class="col-der">
                        <table class="fila-dato-tabla"><tr>
                            <td class="dato-label">NÚMERO DE SERIE MOTORES</td>
                            <td class="dato-valor-small">{{ $embarcacion->numero_motores ?? 'N/A' }}</td>
                        </tr></table>
                    </td>
                </tr>
                <tr>
                    <td class="col-izq">
                        <table class="fila-dato-tabla"><tr>
                            <td class="dato-label">CALADO</td>
                            <td class="dato-valor">{{ $embarcacion->calado ?? 'N/A' }}</td>
                        </tr></table>
                    </td>
                    <td class="col-der">
                        <table class="fila-dato-tabla"><tr>
                            <td class="dato-label">TIPO DE NAVE/GRUPO-SUBGRUPO</td>
                            <td class="dato-valor">{{ strtoupper(str_replace('_', '/', $embarcacion->tipo)) }}</td>
                        </tr></table>
                    </td>
                </tr>
                <tr>
                    <td class="col-izq">
                        <table class="fila-dato-tabla"><tr>
                            <td class="dato-label">FECHA DE CONSTRUCCIÓN</td>
                            <td class="dato-valor">{{ $embarcacion->ano_construccion ? \Carbon\Carbon::parse($embarcacion->ano_construccion)->format('d/m/Y') : 'N/A' }}</td>
                        </tr></table>
                    </td>
                    <td class="col-der">
                        <table class="fila-dato-tabla"><tr>
                            <td class="dato-label">No. OMI/NIC</td>
                            <td class="dato-valor">{{ $embarcacion->numero_omi ?? 'N/A' }}</td>
                        </tr></table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<!-- ============================================
     PÁGINA 2: CARA POSTERIOR
     ============================================ -->
<div class="carnet carnet-back">
    <!-- Imagen de fondo -->
    <img class="fondo-img" src="{{ $fondoPosterior }}" alt="">

    <div class="contenido-posterior">
        <table class="back-tabla">
            <tr>
                <td class="col-propietario">
                    <div class="campo-prop">
                        <table class="campo-prop-tabla"><tr>
                            <td class="campo-prop-label">PROPIETARIO</td>
                            <td class="campo-prop-valor">{{ strtoupper($embarcacion->empresa->razon_social ?? '') }}</td>
                        </tr></table>
                    </div>
                    <div class="campo-prop">
                        <table class="campo-prop-tabla"><tr>
                            <td class="campo-prop-label">IDENTIFICACIÓN</td>
                            <td class="campo-prop-valor">NIT</td>
                        </tr></table>
                    </div>
                    <div class="campo-prop">
                        <table class="campo-prop-tabla"><tr>
                            <td class="campo-prop-label">NO. IDENTIFICACIÓN</td>
                            <td class="campo-prop-valor">{{ $embarcacion->empresa->nit ?? '' }}</td>
                        </tr></table>
                    </div>
                    <div class="campo-prop">
                        <table class="campo-prop-tabla"><tr>
                            <td class="campo-prop-label">DPA</td>
                            <td class="campo-prop-valor">{{ strtoupper($embarcacion->empresa->representante_legal ?? '') }}</td>
                        </tr></table>
                    </div>
                    <div class="campo-prop">
                        <table class="campo-prop-tabla"><tr>
                            <td class="campo-prop-label">CONTACTO DE EMERGENCIA</td>
                            <td class="campo-prop-valor">{{ $embarcacion->empresa->telefono ?? '' }}</td>
                        </tr></table>
                    </div>
                </td>
                <td class="col-empresa-qr">
                    <div class="seccion-qr">
                        <div class="qr-texto">ESCANEE PARA MÁS<br>INFORMACIÓN DE<br>SEGURIDAD</div>
                        <img class="qr-img" src="{{ $qrBase64 }}" alt="QR">
                    </div>
                </td>
            </tr>
        </table>
    </div>
    
    <div class="pie-posterior">Propiedad de GT BOATS SAS - Prohibida su reproducción no autorizada.</div>
</div>

</body>
</html>
