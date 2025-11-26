<?php

namespace App\Http\Controllers;

use App\Models\Reporte;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'embarcacion_id' => 'required|exists:embarcaciones,id',
            'nombre_reportante' => 'required|string|max:255',
            'email_reportante' => 'nullable|email|max:255',
            'telefono_reportante' => 'nullable|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|max:5120'
        ]);

        $validated['ip_address'] = $request->ip();

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('reportes', 'public');
        }

        Reporte::create($validated);

        return redirect()->back()->with('success', 'Reporte enviado exitosamente. Gracias por tu colaboración.');
    }
}
