<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminEspeciesController extends Controller
{
    private $apiBase = 'http://api-pi:8001';
    private $apiKey  = 'MASTER999';

    private function getFamilias(): array
    {
        return [
            ['ID'=>1,'nombre_familia'=>'Turdidae'],['ID'=>2,'nombre_familia'=>'Arecaceae'],
            ['ID'=>3,'nombre_familia'=>'Euphorbiaceae'],['ID'=>4,'nombre_familia'=>'Thraupidae'],
            ['ID'=>5,'nombre_familia'=>'Araneidae'],['ID'=>6,'nombre_familia'=>'Lamiaceae'],
            ['ID'=>7,'nombre_familia'=>'Bromeliaceae'],['ID'=>8,'nombre_familia'=>'Heliotropiaceae'],
            ['ID'=>9,'nombre_familia'=>'Cactaceae'],['ID'=>10,'nombre_familia'=>'Psittacidae'],
            ['ID'=>11,'nombre_familia'=>'Formicidae'],['ID'=>12,'nombre_familia'=>'Hylidae'],
            ['ID'=>13,'nombre_familia'=>'Nymphalidae'],['ID'=>14,'nombre_familia'=>'Asparagaceae'],
            ['ID'=>15,'nombre_familia'=>'Juglandaceae'],['ID'=>16,'nombre_familia'=>'Corvidae'],
            ['ID'=>17,'nombre_familia'=>'Picidae'],['ID'=>18,'nombre_familia'=>'Onagraceae'],
            ['ID'=>19,'nombre_familia'=>'Asteraceae'],['ID'=>20,'nombre_familia'=>'Apidae'],
            ['ID'=>21,'nombre_familia'=>'Columbidae'],['ID'=>22,'nombre_familia'=>'Hirundinidae'],
            ['ID'=>23,'nombre_familia'=>'Convolvulaceae'],['ID'=>24,'nombre_familia'=>'Solanaceae'],
            ['ID'=>25,'nombre_familia'=>'Zingiberaceae'],['ID'=>26,'nombre_familia'=>'Bombacaceae'],
            ['ID'=>27,'nombre_familia'=>'Scarabaeidae'],['ID'=>28,'nombre_familia'=>'Bombyliidae'],
            ['ID'=>29,'nombre_familia'=>'Vespidae'],['ID'=>30,'nombre_familia'=>'Sturnidae'],
            ['ID'=>31,'nombre_familia'=>'Trochilidae'],['ID'=>32,'nombre_familia'=>'Acrididae'],
            ['ID'=>33,'nombre_familia'=>'Chrysomelidae'],['ID'=>34,'nombre_familia'=>'Loasaceae'],
            ['ID'=>35,'nombre_familia'=>'Orchidaceae'],['ID'=>36,'nombre_familia'=>'Felidae'],
            ['ID'=>37,'nombre_familia'=>'Rosaceae'],['ID'=>38,'nombre_familia'=>'Poaceae'],
            ['ID'=>39,'nombre_familia'=>'Fabaceae'],['ID'=>40,'nombre_familia'=>'Muridae'],
            ['ID'=>41,'nombre_familia'=>'Pinaceae'],['ID'=>42,'nombre_familia'=>'Phrynosomatidae'],
            ['ID'=>43,'nombre_familia'=>'Lentibulariaceae'],['ID'=>44,'nombre_familia'=>'Rallidae'],
            ['ID'=>45,'nombre_familia'=>'Fringillidae'],['ID'=>46,'nombre_familia'=>'Anatidae'],
            ['ID'=>47,'nombre_familia'=>'Ardeidae'],['ID'=>48,'nombre_familia'=>'Passerellidae'],
            ['ID'=>49,'nombre_familia'=>'Crassulaceae'],['ID'=>50,'nombre_familia'=>'Tyrannidae'],
            ['ID'=>51,'nombre_familia'=>'Parulidae'],['ID'=>52,'nombre_familia'=>'Cardinalidae'],
            ['ID'=>53,'nombre_familia'=>'Malvaceae'],['ID'=>54,'nombre_familia'=>'Iguanidae'],
            ['ID'=>55,'nombre_familia'=>'Polypodiaceae'],['ID'=>56,'nombre_familia'=>'Plantaginaceae'],
            ['ID'=>57,'nombre_familia'=>'Caprifoliaceae'],['ID'=>58,'nombre_familia'=>'Sapindaceae'],
            ['ID'=>59,'nombre_familia'=>'Remizidae'],['ID'=>60,'nombre_familia'=>'Scolopacidae'],
            ['ID'=>61,'nombre_familia'=>'Apocynaceae'],['ID'=>62,'nombre_familia'=>'Brassicaceae'],
            ['ID'=>63,'nombre_familia'=>'Rhamnaceae'],['ID'=>64,'nombre_familia'=>'Mephitidae'],
            ['ID'=>65,'nombre_familia'=>'Pieridae'],['ID'=>66,'nombre_familia'=>'Chenopodiaceae'],
            ['ID'=>67,'nombre_familia'=>'Verbenaceae'],['ID'=>68,'nombre_familia'=>'Coccinellidae'],
            ['ID'=>69,'nombre_familia'=>'Cyperaceae'],['ID'=>70,'nombre_familia'=>'Ericaceae'],
            ['ID'=>71,'nombre_familia'=>'Liliaceae'],['ID'=>72,'nombre_familia'=>'Moraceae'],
            ['ID'=>73,'nombre_familia'=>'Myrtaceae'],['ID'=>74,'nombre_familia'=>'Oleaceae'],
            ['ID'=>75,'nombre_familia'=>'Papaveraceae'],['ID'=>76,'nombre_familia'=>'Rubiaceae'],
            ['ID'=>77,'nombre_familia'=>'Rutaceae'],['ID'=>78,'nombre_familia'=>'Ulmaceae'],
            ['ID'=>79,'nombre_familia'=>'Vitaceae'],['ID'=>80,'nombre_familia'=>'Xanthorrhoeaceae'],
            ['ID'=>81,'nombre_familia'=>'Zygophyllaceae'],
        ];
    }

    private function getEstados(): array
    {
        return [
            ['ID'=>1,'categoria'=>'Preocupación menor'],
            ['ID'=>2,'categoria'=>'Casi amenazado'],
            ['ID'=>3,'categoria'=>'Vulnerable'],
            ['ID'=>4,'categoria'=>'En peligro'],
            ['ID'=>5,'categoria'=>'En peligro crítico'],
        ];
    }

    public function index(Request $request)
    {
        $idZona = $request->query('zona', '');

        if ($idZona) {
            $especies = Http::withHeaders(['X-API-Key' => $this->apiKey])
                ->get("{$this->apiBase}/fichas/especies/zona/{$idZona}")
                ->json() ?? [];
        } else {
            $especies = Http::withHeaders(['X-API-Key' => $this->apiKey])
                ->get("{$this->apiBase}/fichas/especies")
                ->json() ?? [];
        }

        $zonas    = Http::withHeaders(['X-API-Key' => $this->apiKey])
            ->get("{$this->apiBase}/admin/zonas/publico")
            ->json() ?? [];

        $familias = $this->getFamilias();
        $estados  = $this->getEstados();

        return view('admin.especies', compact('especies', 'zonas', 'familias', 'estados', 'idZona'));
    }

    public function store(Request $request)
    {
        $response = Http::withHeaders([
            'X-API-Key'    => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post("{$this->apiBase}/fichas/especies", [
            'Nombre_comun'           => $request->Nombre_comun,
            'nombre_cientifico'      => $request->nombre_cientifico,
            'tipo'                   => (int) $request->tipo,
            'id_familia'             => (int) $request->id_familia,
            'id_zonas'               => (int) $request->id_zonas,
            'id_estado_conservacion' => (int) $request->id_estado_conservacion,
        ]);

        if ($response->successful()) {
            return redirect()->route('admin.especies')
                             ->with('success', 'Especie creada correctamente.');
        }

        return redirect()->route('admin.especies')
                         ->with('error', 'No se pudo crear la especie.');
    }

    public function update(Request $request, $id)
    {
        $response = Http::withHeaders([
            'X-API-Key'    => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->patch("{$this->apiBase}/fichas/especies/{$id}", [
            'Nombre_comun'           => $request->Nombre_comun,
            'nombre_cientifico'      => $request->nombre_cientifico,
            'tipo'                   => (int) $request->tipo,
            'id_familia'             => (int) $request->id_familia,
            'id_zonas'               => (int) $request->id_zonas,
            'id_estado_conservacion' => (int) $request->id_estado_conservacion,
        ]);

        if ($response->successful()) {
            return redirect()->route('admin.especies')
                             ->with('success', 'Especie actualizada correctamente.');
        }

        return redirect()->route('admin.especies')
                         ->with('error', 'No se pudo actualizar la especie.');
    }

    public function destroy($id)
    {
        $response = Http::withHeaders(['X-API-Key' => $this->apiKey])
            ->delete("{$this->apiBase}/fichas/especies/{$id}");

        if ($response->successful()) {
            return redirect()->route('admin.especies')
                             ->with('success', 'Especie eliminada correctamente.');
        }

        return redirect()->route('admin.especies')
                         ->with('error', 'No se pudo eliminar la especie.');
    }
}