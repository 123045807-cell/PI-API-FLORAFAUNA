<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminComentariosController extends Controller
{
    private $apiBase = 'http://api-pi:8001';
    private $apiKey  = 'MASTER999';

    public function index(Request $request)
    {
        $zonas = Http::withHeaders(['X-API-Key' => $this->apiKey])
            ->get("{$this->apiBase}/admin/zonas/publico")
            ->json();

        $idZona = $request->query('zona', '');

        if ($idZona) {
            $comentarios = Http::withHeaders(['X-API-Key' => $this->apiKey])
                ->get("{$this->apiBase}/comentarios/zona/{$idZona}")
                ->json();
        } else {
            $comentarios = Http::withHeaders(['X-API-Key' => $this->apiKey])
                ->get("{$this->apiBase}/comentarios")
                ->json();
        }

        return view('admin.comentarios', compact('comentarios', 'zonas', 'idZona'));
    }

    public function destroy($id)
    {
        $response = Http::withHeaders(['X-API-Key' => $this->apiKey])
            ->delete("{$this->apiBase}/comentarios/{$id}");

        if ($response->successful()) {
            return redirect()->route('admin.comentarios')
                             ->with('success', 'Comentario eliminado correctamente.');
        }

        return redirect()->route('admin.comentarios')
                         ->with('error', 'No se pudo eliminar el comentario.');
    }
}