<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminEstadisticasController extends Controller
{
    private $apiBase = 'http://api-pi:8001';
    private $apiKey  = 'MASTER999';

    // ── Obtener todos los datos de la API ────────────────────────
    private function getData(): array
    {
        $headers = ['X-API-Key' => $this->apiKey];

        $especies    = Http::withHeaders($headers)->get("{$this->apiBase}/fichas/especies")->json()    ?? [];
        $comentarios = Http::withHeaders($headers)->get("{$this->apiBase}/comentarios")->json()        ?? [];
        $usuarios    = Http::withHeaders($headers)->get("{$this->apiBase}/admin/usuarios")->json()     ?? [];
        $consejos    = Http::withHeaders($headers)->get("{$this->apiBase}/consejos")->json()           ?? [];
        $zonas       = Http::withHeaders($headers)->get("{$this->apiBase}/admin/zonas/publico")->json() ?? [];

        // Mapa id → nombre de zona
        $zonaMap = [];
        foreach ($zonas as $z) {
            $zonaMap[$z['ID'] ?? $z['id']] = $z['nombre_region'];
        }

        $estadoLabels = [
            1 => 'Preocupación menor',
            2 => 'Casi amenazado',
            3 => 'Vulnerable',
            4 => 'En peligro',
            5 => 'En peligro crítico',
        ];

        // ── KPIs ──────────────────────────────────────────────────
        $totalFlora  = count(array_filter($especies, fn($e) => ($e['tipo'] ?? 0) == 1));
        $totalFauna  = count(array_filter($especies, fn($e) => ($e['tipo'] ?? 0) == 2));
        $enPeligro   = count(array_filter($especies, fn($e) => in_array($e['id_estado_conservacion'] ?? 0, [4, 5])));
        $admins      = count(array_filter($usuarios, fn($u) => strtolower($u['rol'] ?? '') === 'admin'));

        // ── Por estado de conservación ────────────────────────────
        $porEstado = [];
        foreach ($estadoLabels as $id => $label) {
            $porEstado[$label] = count(array_filter($especies, fn($e) => ($e['id_estado_conservacion'] ?? 0) == $id));
        }

        // ── Especies por zona ─────────────────────────────────────
        $especiesPorZona = [];
        foreach ($especies as $e) {
            $zid    = $e['id_zonas'] ?? 0;
            $nombre = $zonaMap[$zid] ?? "Zona $zid";
            $especiesPorZona[$nombre] = ($especiesPorZona[$nombre] ?? 0) + 1;
        }
        arsort($especiesPorZona);

        // ── Comentarios por zona ──────────────────────────────────
        $comentariosPorZona = [];
        foreach ($comentarios as $c) {
            $nombre = $c['nombre_region'] ?? 'Sin zona';
            $comentariosPorZona[$nombre] = ($comentariosPorZona[$nombre] ?? 0) + 1;
        }
        arsort($comentariosPorZona);

        // ── Consejos por zona ─────────────────────────────────────
        $consejosPorZona = [];
        foreach ($consejos as $c) {
            $zid    = $c['zona'] ?? 0;
            $nombre = $zonaMap[$zid] ?? "Zona $zid";
            $consejosPorZona[$nombre] = ($consejosPorZona[$nombre] ?? 0) + 1;
        }
        arsort($consejosPorZona);

        return [
            'total_flora'          => $totalFlora,
            'total_fauna'          => $totalFauna,
            'total_especies'       => count($especies),
            'en_peligro'           => $enPeligro,
            'total_comentarios'    => count($comentarios),
            'total_usuarios'       => count($usuarios),
            'usuarios_normales'    => count($usuarios) - $admins,
            'admins'               => $admins,
            'total_consejos'       => count($consejos),
            'por_estado'           => $porEstado,
            'especies_por_zona'    => $especiesPorZona,
            'comentarios_por_zona' => $comentariosPorZona,
            'consejos_por_zona'    => $consejosPorZona,
            // Datos crudos para exportaciones
            '_especies'            => $especies,
            '_comentarios'         => $comentarios,
            '_usuarios'            => $usuarios,
            '_zonaMap'             => $zonaMap,
            '_estadoLabels'        => $estadoLabels,
        ];
    }

    // ── Vista principal ──────────────────────────────────────────
    public function index()
    {
        $stats = $this->getData();
        return view('admin.estadisticas', compact('stats'));
    }

    // ── Exportar PDF ─────────────────────────────────────────────
    public function exportPdf()
    {
        $stats        = $this->getData();
        $estadoLabels = $stats['_estadoLabels'];
        $zonaMap      = $stats['_zonaMap'];

        $fecha = now()->format('d/m/Y H:i');

        // Generar HTML del reporte
        $html = "
        <html><head><meta charset='UTF-8'>
        <style>
            body { font-family: Arial, sans-serif; color: #333; font-size: 12px; }
            h1   { color: #8C5E2A; font-size: 20px; margin-bottom: 4px; }
            h2   { color: #8C5E2A; font-size: 14px; border-bottom: 2px solid #8C5E2A; padding-bottom: 4px; margin-top: 24px; }
            .sub { color: #777; font-size: 11px; margin-bottom: 20px; }
            .kpi-grid { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px; }
            .kpi { background: #fdf4ea; border: 1px solid #e0c9a6; border-radius: 8px;
                   padding: 12px 16px; min-width: 120px; text-align: center; }
            .kpi-val   { font-size: 22px; font-weight: bold; color: #8C5E2A; }
            .kpi-label { font-size: 10px; color: #666; }
            table { width: 100%; border-collapse: collapse; margin-top: 8px; font-size: 11px; }
            th    { background: #8C5E2A; color: white; padding: 8px 10px; text-align: left; }
            td    { padding: 7px 10px; border-bottom: 1px solid #eee; }
            tr:nth-child(even) td { background: #fafafa; }
            .footer { margin-top: 30px; text-align: center; color: #aaa; font-size: 10px; }
        </style></head><body>
        <h1>Reporte de Estadísticas — Flora y Fauna de Querétaro</h1>
        <p class='sub'>Generado el {$fecha}</p>

        <h2>Resumen General</h2>
        <div class='kpi-grid'>
            <div class='kpi'><div class='kpi-val'>{$stats['total_especies']}</div><div class='kpi-label'>Total Especies</div></div>
            <div class='kpi'><div class='kpi-val'>{$stats['total_flora']}</div><div class='kpi-label'>Flora</div></div>
            <div class='kpi'><div class='kpi-val'>{$stats['total_fauna']}</div><div class='kpi-label'>Fauna</div></div>
            <div class='kpi'><div class='kpi-val'>{$stats['en_peligro']}</div><div class='kpi-label'>En Peligro / Crítico</div></div>
            <div class='kpi'><div class='kpi-val'>{$stats['total_comentarios']}</div><div class='kpi-label'>Comentarios</div></div>
            <div class='kpi'><div class='kpi-val'>{$stats['total_usuarios']}</div><div class='kpi-label'>Usuarios</div></div>
            <div class='kpi'><div class='kpi-val'>{$stats['total_consejos']}</div><div class='kpi-label'>Consejos</div></div>
        </div>

        <h2>Especies por Estado de Conservación</h2>
        <table>
            <thead><tr><th>Estado</th><th>Cantidad</th></tr></thead>
            <tbody>";
        foreach ($stats['por_estado'] as $estado => $count) {
            $html .= "<tr><td>{$estado}</td><td>{$count}</td></tr>";
        }
        $html .= "</tbody></table>

        <h2>Especies por Zona</h2>
        <table>
            <thead><tr><th>Zona</th><th>Especies</th></tr></thead>
            <tbody>";
        foreach ($stats['especies_por_zona'] as $zona => $count) {
            $html .= "<tr><td>{$zona}</td><td>{$count}</td></tr>";
        }
        $html .= "</tbody></table>

        <h2>Comentarios por Zona</h2>
        <table>
            <thead><tr><th>Zona</th><th>Comentarios</th></tr></thead>
            <tbody>";
        foreach ($stats['comentarios_por_zona'] as $zona => $count) {
            $html .= "<tr><td>{$zona}</td><td>{$count}</td></tr>";
        }
        $html .= "</tbody></table>

        <div class='footer'>Flora y Fauna de Querétaro &mdash; Panel Administrativo &mdash; {$fecha}</div>
        </body></html>";

        // Usar dompdf si está instalado, si no devolver HTML como descarga
        if (class_exists(\Dompdf\Dompdf::class)) {
            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            return response($dompdf->output(), 200, [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="estadisticas_florafauna.pdf"',
            ]);
        }

        // Fallback: devolver HTML directamente
        return response($html, 200, ['Content-Type' => 'text/html']);
    }

    // ── Exportar XLSX ─────────────────────────────────────────────
    public function exportXlsx()
    {
        $stats        = $this->getData();
        $especies     = $stats['_especies'];
        $zonaMap      = $stats['_zonaMap'];
        $estadoLabels = $stats['_estadoLabels'];

        $tipoLabels = [1 => 'Flora', 2 => 'Fauna'];

        // Cabecera CSV (compatible con Excel)
        $rows = [];
        $rows[] = ['ID', 'Nombre Común', 'Nombre Científico', 'Tipo', 'Familia', 'Zona', 'Estado de Conservación'];

        foreach ($especies as $e) {
            $rows[] = [
                $e['ID']               ?? $e['id']    ?? '',
                $e['Nombre_comun']     ?? $e['nombre_comun'] ?? '',
                $e['nombre_cientifico'] ?? '',
                $tipoLabels[$e['tipo'] ?? 0] ?? '—',
                $e['familia']          ?? '—',
                $zonaMap[$e['id_zonas'] ?? 0] ?? '—',
                $estadoLabels[$e['id_estado_conservacion'] ?? 0] ?? '—',
            ];
        }

        // Si PhpSpreadsheet está instalado, generar XLSX real
        if (class_exists(\PhpOffice\PhpSpreadsheet\Spreadsheet::class)) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet       = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Especies');

            // Estilo encabezado
            $sheet->getStyle('A1:G1')->applyFromArray([
                'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['rgb' => '8C5E2A']],
                'alignment' => ['horizontal' => 'center'],
            ]);

            foreach ($rows as $rowIndex => $row) {
                $sheet->fromArray($row, null, 'A' . ($rowIndex + 1));
            }

            // Autoajustar columnas
            foreach (range('A', 'G') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            // Hoja 2: resumen
            $summary = $spreadsheet->createSheet();
            $summary->setTitle('Resumen');
            $summary->fromArray([
                ['Métrica', 'Valor'],
                ['Total Especies',    $stats['total_especies']],
                ['Flora',             $stats['total_flora']],
                ['Fauna',             $stats['total_fauna']],
                ['En Peligro/Crítico',$stats['en_peligro']],
                ['Total Comentarios', $stats['total_comentarios']],
                ['Total Usuarios',    $stats['total_usuarios']],
                ['Administradores',   $stats['admins']],
                ['Total Consejos',    $stats['total_consejos']],
            ]);
            $summary->getStyle('A1:B1')->applyFromArray([
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '8C5E2A']],
            ]);

            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $tmpFile = tempnam(sys_get_temp_dir(), 'xlsx_');
            $writer->save($tmpFile);

            return response()->download($tmpFile, 'estadisticas_florafauna.xlsx', [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ])->deleteFileAfterSend(true);
        }

        // Fallback: CSV si no hay PhpSpreadsheet
        $csvContent = '';
        foreach ($rows as $row) {
            $csvContent .= implode(',', array_map(fn($v) => '"' . str_replace('"', '""', $v) . '"', $row)) . "\n";
        }

        return response($csvContent, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="estadisticas_florafauna.csv"',
        ]);
    }
}