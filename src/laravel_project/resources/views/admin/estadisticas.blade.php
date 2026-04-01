<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Estadísticas</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    :root {
        --primary: #8C5E2A;
        --primary-light: #fdf4ea;
        --bg-body: #f8f7f0;
        --border: #e5e7eb;
        --card: #ffffff;
    }
    * { box-sizing: border-box; }
    body {
        margin: 0; font-family: 'Inter', sans-serif;
        background: var(--bg-body); display: flex;
        flex-direction: column; min-height: 100vh; padding-top: 60px;
    }

    .navbar {
        position: fixed; top: 0; width: 100%; z-index: 1000;
        display: flex; justify-content: space-between; align-items: center;
        padding: 0 2rem; background: #fff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1); height: 60px;
    }
    .logo {
        display: flex; align-items: center; font-weight: bold;
        font-family: 'Playfair Display', serif; color: var(--primary);
    }
    .logo img { height: 40px; margin-right: 12px; }
    .links a {
        text-decoration: none; color: #333; font-weight: 500;
        font-size: .9rem; margin-left: 20px; transition: color .3s;
    }
    .links a:hover { color: var(--primary); }

    .page-header {
        max-width: 1300px; margin: 30px auto 0;
        padding: 0 20px 20px;
        display: flex; justify-content: space-between; /* Alinea título a la izquierda y botón a la derecha */
        align-items: center; flex-wrap: wrap; gap: 16px;
        border-bottom: 1px solid var(--border);
    }
    .page-header h1 {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem; color: #333; margin: 0;
    }
    .export-btns { 
        margin-left: auto; /* Empuja el contenedor hacia la derecha */
    }
    .btn-pdf {
        display: flex; align-items: center; gap: 8px;
        padding: 10px 18px; border-radius: 8px; font-size: .85rem;
        font-weight: 700; cursor: pointer; text-decoration: none;
        transition: all .2s;
        background: #fff1f1; color: #dc3545; border: 1px solid #dc3545;
    }
    .btn-pdf:hover { background: #dc3545; color: #fff; }

    .stats-wrapper {
        max-width: 1300px; margin: 30px auto 50px;
        padding: 0 20px; display: flex; flex-direction: column; gap: 30px;
    }

    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 16px;
    }
    .kpi-card {
        background: var(--card); border-radius: 12px; padding: 22px 20px;
        border: 1px solid var(--border); box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        display: flex; flex-direction: column; gap: 6px;
    }
    .kpi-icon {
        width: 42px; height: 42px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; margin-bottom: 8px;
    }
    .kpi-value { font-size: 1.8rem; font-weight: 700; color: #222; line-height: 1; }
    .kpi-label { font-size: .75rem; color: #777; font-weight: 500; }

    .kpi-verde  { background: #e8f5e9; color: #2e7d32; }
    .kpi-azul   { background: #e3f2fd; color: #1565c0; }
    .kpi-cafe   { background: var(--primary-light); color: var(--primary); }
    .kpi-rojo   { background: #fff1f1; color: #c62828; }
    .kpi-naranja{ background: #fff3e0; color: #e65100; }
    .kpi-morado { background: #f3e5f5; color: #6a1b9a; }

    .charts-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    .chart-card {
        background: var(--card); border-radius: 12px; padding: 24px;
        border: 1px solid var(--border); box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .chart-card.full { grid-column: 1 / -1; }
    .chart-title {
        font-size: 1rem; font-weight: 700; color: #333;
        margin: 0 0 20px; display: flex; align-items: center; gap: 8px;
    }
    .chart-wrap { position: relative; height: 260px; }

    .footer {
        background: var(--primary); color: #fff;
        padding: 1.5rem; text-align: center; margin-top: auto;
    }

    @media (max-width: 1100px) {
        .kpi-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 700px) {
        .charts-grid { grid-template-columns: 1fr; }
        .kpi-grid    { grid-template-columns: repeat(2, 1fr); }
        .export-btns { margin-left: 0; width: 100%; }
    }
</style>
</head>
<body>

<nav class="navbar">
    <div class="logo">
        <img src="{{ asset('img/logo.png') }}" alt="Logo">
        <span>Panel de Administración</span>
    </div>
    <div class="links">
        <a href="/admin">Panel</a>
        <a href="/logout" style="color:#8C5E2A;">Cerrar sesión</a>
    </div>
</nav>

<div class="page-header">
    <h1>Estadísticas Generales</h1>
    <div class="export-btns">
        <a href="{{ route('admin.estadisticas.pdf') }}" class="btn-pdf">
            <i class="fas fa-file-pdf"></i> Guardar PDF
        </a>
    </div>
</div>

<div class="stats-wrapper">

    {{-- KPIs --}}
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-icon kpi-verde"><i class="fas fa-seedling"></i></div>
            <span class="kpi-value">{{ $stats['total_flora'] }}</span>
            <span class="kpi-label">Especies de Flora</span>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon kpi-azul"><i class="fas fa-paw"></i></div>
            <span class="kpi-value">{{ $stats['total_fauna'] }}</span>
            <span class="kpi-label">Especies de Fauna</span>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon kpi-cafe"><i class="fas fa-leaf"></i></div>
            <span class="kpi-value">{{ $stats['total_especies'] }}</span>
            <span class="kpi-label">Total de Especies</span>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon kpi-rojo"><i class="fas fa-exclamation-triangle"></i></div>
            <span class="kpi-value">{{ $stats['en_peligro'] }}</span>
            <span class="kpi-label">En Peligro / Crítico</span>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon kpi-naranja"><i class="fas fa-comments"></i></div>
            <span class="kpi-value">{{ $stats['total_comentarios'] }}</span>
            <span class="kpi-label">Comentarios</span>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon kpi-morado"><i class="fas fa-users"></i></div>
            <span class="kpi-value">{{ $stats['total_usuarios'] }}</span>
            <span class="kpi-label">Usuarios</span>
        </div>
    </div>

    <div class="charts-grid">
        <div class="chart-card">
            <p class="chart-title"><i class="fas fa-chart-pie" style="color:var(--primary)"></i> Flora vs Fauna</p>
            <div class="chart-wrap">
                <canvas id="chartFloraFauna"></canvas>
            </div>
        </div>

        <div class="chart-card">
            <p class="chart-title"><i class="fas fa-chart-bar" style="color:var(--primary)"></i> Estado de Conservación</p>
            <div class="chart-wrap">
                <canvas id="chartEstados"></canvas>
            </div>
        </div>

        <div class="chart-card full">
            <p class="chart-title"><i class="fas fa-map-marker-alt" style="color:var(--primary)"></i> Especies por Zona</p>
            <div class="chart-wrap">
                <canvas id="chartZonas"></canvas>
            </div>
        </div>

        <div class="chart-card">
            <p class="chart-title"><i class="fas fa-comments" style="color:var(--primary)"></i> Comentarios por Zona</p>
            <div class="chart-wrap">
                <canvas id="chartComentariosZona"></canvas>
            </div>
        </div>

        <div class="chart-card">
            <p class="chart-title"><i class="fas fa-users-cog" style="color:var(--primary)"></i> Usuarios por Rol</p>
            <div class="chart-wrap">
                <canvas id="chartUsuarios"></canvas>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <p>&copy; Flora y Fauna de Querétaro</p>
</footer>

<script>
const COLORS = ['#2E7D32', '#1565C0', '#8C5E2A', '#C62828', '#E65100', '#6A1B9A', '#00838F', '#AD1457'];

const defaultOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: { 
        legend: { position: 'bottom', labels: { font: { family: 'Inter', size: 11 } } } 
    }
};

new Chart(document.getElementById('chartFloraFauna'), {
    type: 'pie',
    data: {
        labels: ['Flora', 'Fauna'],
        datasets: [{
            data: [{{ $stats['total_flora'] }}, {{ $stats['total_fauna'] }}],
            backgroundColor: ['#4CAF50', '#2196F3']
        }]
    },
    options: defaultOptions
});

new Chart(document.getElementById('chartEstados'), {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_keys($stats['por_estado'])) !!},
        datasets: [{
            label: 'Especies',
            data: {!! json_encode(array_values($stats['por_estado'])) !!},
            backgroundColor: COLORS,
            borderRadius: 6
        }]
    },
    options: {
        ...defaultOptions,
        plugins: { legend: { display: false } }
    }
});

new Chart(document.getElementById('chartZonas'), {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_keys($stats['especies_por_zona'])) !!},
        datasets: [{
            label: 'Especies',
            data: {!! json_encode(array_values($stats['especies_por_zona'])) !!},
            backgroundColor: '#8C5E2A',
            borderRadius: 5
        }]
    },
    options: {
        ...defaultOptions,
        plugins: { legend: { display: false } }
    }
});

new Chart(document.getElementById('chartComentariosZona'), {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_keys($stats['comentarios_por_zona'])) !!},
        datasets: [{
            label: 'Comentarios',
            data: {!! json_encode(array_values($stats['comentarios_por_zona'])) !!},
            backgroundColor: '#FF9800',
            borderRadius: 5
        }]
    },
    options: {
        ...defaultOptions,
        plugins: { legend: { display: false } }
    }
});

new Chart(document.getElementById('chartUsuarios'), {
    type: 'pie',
    data: {
        labels: ['Usuarios', 'Administradores'],
        datasets: [{
            data: [{{ $stats['usuarios_normales'] }}, {{ $stats['admins'] }}],
            backgroundColor: ['#2196F3', '#8C5E2A']
        }]
    },
    options: defaultOptions
});
</script>

</body>
</html>