<?php

namespace App\Http\Controllers;

use App\Models\Embarcacion;
use App\Models\Verificacion;
use Illuminate\Http\Request;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class VerificacionController extends Controller
{
    public function verificar(Request $request, $codigo = null)
    {
        // Verificar por código QR
        if (!$codigo && $request->has('codigo')) {
            $codigo = $request->input('codigo');
        }

        // Verificar por matrícula
        $matricula = $request->input('matricula');

        if (!$codigo && !$matricula) {
            return view('verificacion.buscar');
        }

        try {
            $query = Embarcacion::with(['empresa', 'documentos', 'imagenPrincipal']);
            
            if ($codigo) {
                $embarcacion = $query->where('codigo_qr', $codigo)->firstOrFail();
            } else {
                // Buscar por matrícula (case insensitive)
                $embarcacion = $query->whereRaw('UPPER(matricula) = ?', [strtoupper($matricula)])->firstOrFail();
            }

            $puedeNavegar = $embarcacion->esAptaParaNavegar();
            $motivos = $puedeNavegar ? null : $embarcacion->getRazonesNoApta();

            Verificacion::create([
                'embarcacion_id' => $embarcacion->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'resultado' => $puedeNavegar ? 'apta' : 'no_apta',
                'motivos' => $motivos,
            ]);

            return view('verificacion.resultado', compact('embarcacion', 'puedeNavegar', 'motivos'));
        } catch (\Exception $e) {
            return view('verificacion.no-encontrado');
        }
    }

    public function generarQR($codigo)
    {
        $renderer = new ImageRenderer(
            new RendererStyle(300),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrCode = $writer->writeString(route('verificar', ['codigo' => $codigo]));

        return response($qrCode)->header('Content-Type', 'image/svg+xml');
    }

    public function descargarCarnet(Embarcacion $embarcacion)
    {
        // Generar QR code como SVG en base64 para incluir directamente en el PDF
        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrSvg = $writer->writeString(route('verificar', ['codigo' => $embarcacion->codigo_qr]));
        $qrBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrSvg);

        // Cargar imágenes como base64 para el PDF (versiones simplificadas para DomPDF)
        $escudoColombia = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('images/carnet/logo_republica_colombia.png')));
        $banderaColombia = 'data:image/svg+xml;base64,' . base64_encode(file_get_contents(public_path('images/carnet/bandera_colombia.svg')));
        $escudoCartagena = 'data:image/svg+xml;base64,' . base64_encode(file_get_contents(public_path('images/carnet/bandera_cartagena.svg')));

        // Cargar fondos como base64
        $fondoFrontal = 'data:image/jpeg;base64,' . base64_encode(file_get_contents(public_path('images/carnet/embarcacion.jpg')));
        
        // Usar imagen principal de la embarcación como fondo posterior
        $imagenPrincipal = $embarcacion->imagenPrincipal;
        if ($imagenPrincipal && file_exists(storage_path('app/public/' . $imagenPrincipal->ruta))) {
            $fondoPosterior = 'data:image/jpeg;base64,' . base64_encode(file_get_contents(storage_path('app/public/' . $imagenPrincipal->ruta)));
        } else {
            $fondoPosterior = 'data:image/svg+xml;base64,' . base64_encode(file_get_contents(public_path('images/carnet/fondo_posterior.svg')));
        }

        $pdf = \PDF::loadView('pdf.carnet', compact(
            'embarcacion',
            'qrBase64',
            'escudoColombia',
            'banderaColombia',
            'escudoCartagena',
            'fondoFrontal',
            'fondoPosterior'
        ));

        // Configurar tamaño de página personalizado (tarjeta de crédito: 85.6mm x 54mm)
        // En puntos: 242.6pt x 153pt
        $pdf->setPaper([0, 0, 242.6, 153]);

        return $pdf->download('carnet_' . $embarcacion->matricula . '.pdf');
    }

    public function descargarCredencialPiloto(\App\Models\Piloto $piloto)
    {
        // Verificar que el usuario puede descargar esta credencial
        if (!auth()->user()->isAdmin() && auth()->user()->piloto_id !== $piloto->id) {
            abort(403, 'No autorizado');
        }

        $pdf = \PDF::loadView('pdf.credencial-piloto', compact('piloto'));
        return $pdf->download('credencial_piloto_' . $piloto->numero_documento . '.pdf');
    }

    public function descargarHojaVida(\App\Models\Piloto $piloto)
    {
        // Verificar que el usuario puede descargar esta hoja de vida
        if (!auth()->user()->isAdmin() && auth()->user()->piloto_id !== $piloto->id) {
            abort(403, 'No autorizado');
        }

        $pdf = \PDF::loadView('pdf.hoja-vida-piloto', compact('piloto'));
        return $pdf->download('hoja_vida_' . $piloto->nombre_completo . '.pdf');
    }

    public function verificarPiloto(Request $request, $codigo = null)
    {
        // Verificar por código QR
        if (!$codigo && $request->has('codigo')) {
            $codigo = $request->input('codigo');
        }

        // Verificar por número de documento
        $numeroDocumento = $request->input('documento');

        if (!$codigo && !$numeroDocumento) {
            return view('verificacion.buscar-piloto');
        }

        try {
            $query = \App\Models\Piloto::with(['empresa', 'certificaciones', 'historialNavegacion']);

            if ($codigo) {
                $piloto = $query->where('codigo_qr', $codigo)->firstOrFail();
            } else {
                $piloto = $query->where('numero_documento', $numeroDocumento)->firstOrFail();
            }

            $licenciaVigente = $piloto->licenciaVigente();
            $certificacionesVigentes = $piloto->getCertificacionesVigentes();

            return view('verificacion.resultado-piloto', compact('piloto', 'licenciaVigente', 'certificacionesVigentes'));
        } catch (\Exception $e) {
            return view('verificacion.piloto-no-encontrado');
        }
    }
}
