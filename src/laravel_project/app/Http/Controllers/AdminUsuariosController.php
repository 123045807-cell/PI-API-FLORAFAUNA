<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AdminUsuariosController extends Controller
{
    private $apiBase = 'http://api-pi:8001';
    private $apiKey  = 'MASTER999';
    
    public function index()
    {
        try {
            $response = Http::withHeaders(['X-API-Key' => $this->apiKey])
                ->get("{$this->apiBase}/admin/usuarios");

            $usuarios = $response->successful() ? ($response->json() ?? []) : [];

            if (!$response->successful()) {
                session()->flash('error', 'La API respondió con error: ' . $response->status());
            }
        } catch (\Exception $e) {
            $usuarios = [];
            Log::error('Error conectando a la API de Usuarios: ' . $e->getMessage());
            session()->flash('error', 'No se pudo conectar con el servidor de la API.');
        }

        return view('admin.usuarios', compact('usuarios'));
    }

    public function edit($id)
    {
        try {
            $response = Http::withHeaders(['X-API-Key' => $this->apiKey])
                ->get("{$this->apiBase}/admin/usuarios");

            $usuarios = $response->json() ?? [];
            $usuario  = collect($usuarios)->firstWhere('id', (int) $id);

            if (!$usuario) {
                return redirect()->route('admin.usuarios')
                                 ->with('error', 'Usuario no encontrado.');
            }
        } catch (\Exception $e) {
            Log::error('Error al obtener usuario: ' . $e->getMessage());
            return redirect()->route('admin.usuarios')
                             ->with('error', 'No se pudo conectar con la API.');
        }

        return view('admin.usuarios-editar', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        try {
            $response = Http::withHeaders([
                'X-API-Key'    => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->put("{$this->apiBase}/admin/usuarios/{$id}", [
                'rol' => $request->rol,
            ]);

            if ($response->successful()) {
                return redirect()->route('admin.usuarios')
                                 ->with('success', 'Rol actualizado correctamente.');
            }

            return redirect()->route('admin.usuarios')
                             ->with('error', 'Error al actualizar: ' . $response->status());

        } catch (\Exception $e) {
            Log::error('Error en update usuario: ' . $e->getMessage());
            return redirect()->route('admin.usuarios')
                             ->with('error', 'No se pudo conectar con la API.');
        }
    }

    public function destroy($id)
    {
        try {
            $response = Http::withHeaders(['X-API-Key' => $this->apiKey])
                ->delete("{$this->apiBase}/admin/usuarios/{$id}");

            if ($response->successful()) {
                return redirect()->route('admin.usuarios')
                                 ->with('success', 'Usuario eliminado correctamente.');
            }

            return redirect()->route('admin.usuarios')
                             ->with('error', 'Error al eliminar: ' . $response->status());

        } catch (\Exception $e) {
            Log::error('Error en destroy usuario: ' . $e->getMessage());
            return redirect()->route('admin.usuarios')
                             ->with('error', 'No se pudo conectar con la API.');
        }
    }
}