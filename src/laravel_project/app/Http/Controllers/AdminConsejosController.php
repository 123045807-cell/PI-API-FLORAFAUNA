<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminConsejosController extends Controller
{
    private $apiBase = 'http://api-pi:8001';
    private $apiKey  = 'MASTER999';

    public function index()
    {
        $zonas = Http::withHeaders(['X-API-Key' => $this->apiKey])
            ->get("{$this->apiBase}/admin/zonas/publico")
            ->json();

        $consejos = Http::withHeaders(['X-API-Key' => $this->apiKey])
            ->get("{$this->apiBase}/consejos")
            ->json();

        return view('admin.consejos', compact('consejos', 'zonas'));
    }

    public function store(Request $request)
    {
        $response = Http::withHeaders([
            'X-API-Key'    => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post("{$this->apiBase}/consejos", [
            'titulo'  => $request->titulo,
            'consejo' => $request->consejo,
            'fecha'   => $request->fecha,
            'hora'    => $request->hora,
            'zona'    => (int) $request->zona,
        ]);

        if ($response->successful()) {
            return redirect()->route('admin.consejos')
                             ->with('success', 'Consejo creado correctamente.');
        }

        return redirect()->route('admin.consejos')
                         ->with('error', 'No se pudo crear el consejo.');
    }

    public function update(Request $request, $id)
    {
        $response = Http::withHeaders([
            'X-API-Key'    => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->put("{$this->apiBase}/consejos/{$id}", [
            'titulo'  => $request->titulo,
            'consejo' => $request->consejo,
            'fecha'   => $request->fecha,
            'hora'    => $request->hora,
            'zona'    => (int) $request->zona,
        ]);

        if ($response->successful()) {
            return redirect()->route('admin.consejos')
                             ->with('success', 'Consejo actualizado correctamente.');
        }

        return redirect()->route('admin.consejos')
                         ->with('error', 'No se pudo actualizar el consejo.');
    }

    public function destroy($id)
    {
        $response = Http::withHeaders(['X-API-Key' => $this->apiKey])
            ->delete("{$this->apiBase}/consejos/{$id}");

        if ($response->successful()) {
            return redirect()->route('admin.consejos')
                             ->with('success', 'Consejo eliminado correctamente.');
        }

        return redirect()->route('admin.consejos')
                         ->with('error', 'No se pudo eliminar el consejo.');
    }
}