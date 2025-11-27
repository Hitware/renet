<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateHostHeader
{
    public function handle(Request $request, Closure $next)
    {
        // Omitir validación en entorno local
        if (config('app.env') === 'local') {
            return $next($request);
        }
        
        $allowedHosts = [
            parse_url(config('app.url'), PHP_URL_HOST),
            'localhost',
            '127.0.0.1'
        ];
        
        if (!in_array($request->getHost(), $allowedHosts)) {
            abort(400, 'Invalid Host Header');
        }
        
        return $next($request);
    }
}
