<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAlumnoRole
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('alumno')->user();

        if (!$user || $user->rol !== 'alumno') {
            Auth::guard('alumno')->logout();
            return redirect()->route('login.form');
        }

        return $next($request);
    }
}