<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValidateUserRole
{
    public function handle(Request $request, Closure $next)
    {
        // Excluir rutas de autenticación del middleware
        if ($request->routeIs('login') || $request->routeIs('register') || $request->routeIs('password.*') || $request->routeIs('verification.*')) {
            return $next($request);
        }

        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();
        
        // Validar que el rol del usuario en sesión coincida con el de la BD
        $freshUser = \App\Models\User::find($user->id);
        
        if (!$freshUser || $freshUser->role !== $user->role) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('login')->with('error', 'Sesión inválida. Por favor inicie sesión nuevamente.');
        }

        // Validar empresa_id si el usuario es de tipo empresa
        if ($user->role === 'empresa' && $freshUser->empresa_id !== $user->empresa_id) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('login')->with('error', 'Sesión inválida. Por favor inicie sesión nuevamente.');
        }

        return $next($request);
    }
}
