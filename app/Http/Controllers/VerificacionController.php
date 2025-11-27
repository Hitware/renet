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
        $pdf = \PDF::loadView('pdf.carnet', compact('embarcacion'));
        return $pdf->download('carnet_' . $embarcacion->matricula . '.pdf');
    }
}
