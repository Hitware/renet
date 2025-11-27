<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PreventTimingAttacks
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        // Agregar delay aleatorio pequeño para prevenir timing attacks
        if ($request->is('login') || $request->is('password/*')) {
            usleep(random_int(50000, 150000)); // 50-150ms
        }
        
        return $response;
    }
}
