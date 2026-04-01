<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminAuthController extends Controller
{
    private $apiBase = 'http://api-pi:8001';
    private $apiKey  = 'MASTER999';

    public function entrar(Request $request)
    {
        // Verificar que viene con el token correcto
        $token = $request->query('token', '');

        if ($token !== $this->apiKey) {
            abort(403, 'No autorizado');
        }

        session([
            'admin_autenticado' => true,
            'admin_rol'         => 'admin',
        ]);

        return redirect('/admin');

    }
    public function logout()
    {
        session()->flush();
        return redirect('http://localhost:5000/login');
    }

}