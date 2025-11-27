<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class LimitConcurrentUploads
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->hasFile('archivo') || $request->hasFile('imagen')) {
            $key = 'upload:' . $request->user()->id;
            
            if (RateLimiter::tooManyAttempts($key, 5)) {
                return back()->with('error', 'Demasiadas subidas simultáneas. Espere un momento.');
            }
            
            RateLimiter::hit($key, 60); // 5 uploads por minuto
        }
        
        return $next($request);
    }
}
