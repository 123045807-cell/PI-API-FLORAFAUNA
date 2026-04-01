<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('admin_autenticado')) {
            // Si no está autenticado, redirigir al login de Flask
            return redirect('http://localhost:5000/login');
        }

        return $next($request);
    }
}