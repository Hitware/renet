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
        if (!$codigo && $request->has('codigo')) {
            $codigo = $request->input('codigo');
        }

        if (!$codigo) {
            return view('verificacion.buscar');
        }

        try {
            $embarcacion = Embarcacion::where('codigo_qr', $codigo)
                ->with(['empresa', 'documentos', 'imagenPrincipal'])
                ->firstOrFail();

            $puedeNavegar = $embarcacion->puedeNavegar();
            $motivos = $puedeNavegar ? null : $embarcacion->getDocumentosFaltantes();

            Verificacion::create([
                'embarcacion_id' => $embarcacion->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'resultado' => $puedeNavegar ? 'disponible' : 'no_disponible',
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
