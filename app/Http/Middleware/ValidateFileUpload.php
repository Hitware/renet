<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateFileUpload
{
    private $allowedMimeTypes = [
        'application/pdf',
        'image/jpeg',
        'image/jpg',
        'image/png'
    ];

    private $maxFileSize = 10240; // 10MB en KB

    public function handle(Request $request, Closure $next)
    {
        if ($request->hasFile('archivo') || $request->hasFile('imagen')) {
            $file = $request->file('archivo') ?? $request->file('imagen');
            
            if (!in_array($file->getMimeType(), $this->allowedMimeTypes)) {
                return back()->with('error', 'Tipo de archivo no permitido. Solo PDF, JPG y PNG.');
            }

            if ($file->getSize() > ($this->maxFileSize * 1024)) {
                return back()->with('error', 'El archivo excede el tamaño máximo de 10MB.');
            }

            $extension = strtolower($file->getClientOriginalExtension());
            if (!in_array($extension, ['pdf', 'jpg', 'jpeg', 'png'])) {
                return back()->with('error', 'Extensión de archivo no permitida.');
            }
        }

        return $next($request);
    }
}
