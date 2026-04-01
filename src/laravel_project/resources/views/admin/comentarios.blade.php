<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Comentarios</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary: #8C5E2A;
            --bg-body: #f8f7f0;
            --card-bg: #ffffff;
            --border-color: #e5e7eb;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding-top: 70px;
        }

        /* --- Navbar --- */
        .navbar {
            position: fixed; top: 0; width: 100%; z-index: 1000;
            display: flex; justify-content: space-between; align-items: center;
            padding: 0 2rem; background-color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1); height: 60px;
        }
        .logo {
            display: flex; align-items: center; font-weight: bold; font-family: 'Playfair Display', serif; color: var(--primary);
        }
        .logo img { height: 40px; margin-right: 12px; }
        .links a { text-decoration: none; color: #333; font-weight: 500; font-size: 0.9rem; margin-left: 20px; transition: color 0.3s; }
        .links a:hover { color: var(--primary); }

        /* --- Encabezado Especial --- */
        .header-seccion-especial {
            max-width: 1200px;
            margin: 30px auto 10px;
            padding: 0 20px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
            width: 100%;
        }

        .header-seccion-especial h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            color: #333;
            margin: 0;
        }

        .form-filtro-minimal select {
            padding: 8px 15px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background-color: #fff;
            color: #333;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            cursor: pointer;
            outline: none;
            min-width: 220px;
            transition: border-color 0.2s;
        }
        .form-filtro-minimal select:hover { border-color: var(--primary); }

        /* --- Grid de Comentarios --- */
        .contenedor-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px 40px;
            width: 100%;
        }
        .comentario-card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            border: 1px solid rgba(0,0,0,0.05);
            transition: transform 0.2s ease;
        }
        .comentario-card:hover { transform: translateY(-5px); }

        .card-user { display: flex; align-items: center; gap: 12px; margin-bottom: 15px; }
        .avatar-mini {
            width: 40px; height: 40px; background: #f0ede5; color: var(--primary);
            border-radius: 50%; display: flex; align-items: center; justify-content: center; 
            font-weight: 700; font-size: 1rem; border: 1px solid #e0dacc; flex-shrink: 0;
        }
        .user-data strong { display: block; font-size: 1rem; color: #222; }
        .user-data span { font-size: 0.75rem; color: #999; }

        .card-body {
            font-size: 0.92rem;
            color: #4b5563;
            line-height: 1.6;
            margin-bottom: 20px;
            max-height: 120px;
            overflow-y: auto;
            border-left: 3px solid #f0e6d8;
            padding-left: 12px;
        }
        .card-body::-webkit-scrollbar { width: 3px; }
        .card-body::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #f9f9f9;
            padding-top: 15px;
        }
        
        .zona-tag {
            font-size: 0.7rem;
            background: #f3f0e9;
            color: var(--primary);
            padding: 5px 12px;
            border-radius: 6px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .btn-borrar {
            background: none; border: none; color: #ef4444; cursor: pointer;
            font-size: 1.1rem; transition: 0.2s; padding: 5px;
        }
        .btn-borrar:hover { color: #b91c1c; transform: scale(1.1); }

        .vacio {
            grid-column: 1 / -1;
            text-align: center;
            padding: 100px;
            color: #999;
        }

        .footer { background-color: var(--primary); color: #fff; padding: 2rem; text-align: center; margin-top: auto; }

        @media (max-width: 700px) {
            .header-seccion-especial { flex-direction: column; align-items: flex-start; gap: 15px; }
            .form-filtro-minimal select { width: 100%; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="logo">
        <img src="{{ asset('img/logo.png') }}" alt="Logo">
        <span>Fauna y Flora Local Qro</span>
    </div>
    <div class="links">
        <a href="/">Panel</a>
        <a href="/logout" style="color: #8C5E2A;">Cerrar sesión</a>
    </div>
</nav>

{{-- Alerta flash --}}
@if(session('success'))
<script>
    document.addEventListener("DOMContentLoaded", () => {
        Swal.fire({ icon: 'success', title: 'Listo', text: '{{ session('success') }}', timer: 2000, showConfirmButton: false });
    });
</script>
@endif

<div class="header-seccion-especial">
    <h2>Gestión de Comentarios</h2>
    
    <div class="form-filtro-minimal">
        <select onchange="location='?zona='+this.value">
            <option value="">Todas las zonas</option>
            @foreach($zonas as $z)
                @php $zid = $z['ID'] ?? $z['id']; @endphp
                <option value="{{ $zid }}" {{ ($idZona == $zid) ? 'selected' : '' }}>
                    {{ $z['nombre_region'] }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<main class="contenedor-grid">
    @forelse($comentarios as $c)
        @php
            $id      = $c['ID']               ?? $c['id']               ?? 0;
            $nombre  = $c['nombre']           ?? 'Usuario';
            $fecha   = $c['Fecha_publicacion'] ?? $c['fecha_publicacion'] ?? '—';
            $zona    = $c['nombre_region']    ?? 'Sin zona';
            $texto   = $c['Contenido']         ?? $c['contenido']         ?? '';
            $inicial = strtoupper(substr($nombre, 0, 1));
        @endphp

        <div class="comentario-card">
            <div>
                <div class="card-user">
                    <div class="avatar-mini">{{ $inicial }}</div>
                    <div class="user-data">
                        <strong>{{ $nombre }}</strong>
                        <span><i class="far fa-calendar-alt"></i> {{ $fecha }}</span>
                    </div>
                </div>
                
                <div class="card-body">
                    {{ $texto }}
                </div>
            </div>

            <div class="card-footer">
                <span class="zona-tag">{{ $zona }}</span>
                
                <form action="{{ route('admin.comentarios.destroy', $id) }}" method="POST" onsubmit="confirmarEliminacion(event, this)">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-borrar" title="Eliminar comentario">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="vacio">
            <i class="fas fa-comments fa-3x" style="opacity: 0.3; margin-bottom: 15px; display: block;"></i>
            <p>No se encontraron comentarios para mostrar.</p>
        </div>
    @endforelse
</main>

<footer class="footer">
    <p>&copy; Flora y Fauna de Querétaro</p>
</footer>

<script>
    function confirmarEliminacion(event, form) {
        event.preventDefault();
        Swal.fire({
            title: '¿Eliminar comentario?',
            text: "Esta acción quitará el mensaje permanentemente.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>

</body>
</html>