<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Usuarios</title>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    :root {
        --primary: #8C5E2A;
        --bg-body: #f8f7f0;
        --card-bg: #ffffff;
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
    .navbar {
        position: fixed; top: 0; width: 100%; z-index: 1000;
        display: flex; justify-content: space-between; align-items: center;
        padding: 0 2rem; background-color: #fff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1); height: 60px;
    }
    .logo {
        display: flex; align-items: center; font-weight: bold;
        font-family: 'Playfair Display', serif; color: var(--primary);
    }
    .logo img { height: 40px; margin-right: 12px; }
    .links a {
        text-decoration: none; color: #333; font-weight: 500;
        font-size: 0.9rem; margin-left: 20px; transition: color 0.3s;
    }
    .links a:hover { color: var(--primary); }

    .header-gestion {
        max-width: 1200px;
        margin: 30px auto 10px;
        padding: 0 20px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #e5e7eb;
        width: 100%;
        flex-wrap: wrap;
        gap: 20px;
    }
    .header-gestion h1 {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem; color: #333; margin: 0;
    }
    .search-container { position: relative; min-width: 300px; }
    .search-container i {
        position: absolute; left: 15px; top: 50%;
        transform: translateY(-50%); color: #999; font-size: 0.9rem;
    }
    .search-input {
        width: 100%; padding: 10px 15px 10px 40px;
        border: 1px solid #d1d5db; border-radius: 8px;
        font-family: 'Inter', sans-serif; font-size: 0.9rem;
        outline: none; transition: all 0.2s;
    }
    .search-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(140,94,42,0.1);
    }

    .usuarios-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 25px;
        max-width: 1200px;
        margin: 20px auto;
        padding: 0 20px 40px;
        width: 100%;
    }

    .usuario-card {
        background: var(--card-bg);
        border-radius: 15px;
        padding: 25px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        border: 1px solid rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .usuario-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(140,94,42,0.1);
    }
    .user-avatar {
        width: 60px; height: 60px;
        background: #f0ede5; color: var(--primary);
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; font-weight: 700; margin: 0 auto 15px;
        border: 2px solid #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .usuario-card h3 { margin: 10px 0 5px; font-size: 1.05rem; color: #333; }
    .user-email { font-size: 0.83rem; color: #777; margin-bottom: 15px; display: block; word-break: break-all; }
    .badge-rol {
        display: inline-block; padding: 4px 12px; border-radius: 20px;
        font-size: 0.7rem; font-weight: 700; text-transform: uppercase; margin-bottom: 20px;
    }
    .rol-admin   { background: #e0f2fe; color: #0369a1; }
    .rol-usuario { background: #f3f4f6; color: #4b5563; }

    .acciones-usuario {
        display: flex; gap: 10px;
        border-top: 1px solid #f5f5f5; padding-top: 15px;
        width: 100%; margin-top: auto;
    }
    .btn-user-action {
        flex: 1; padding: 10px; border-radius: 8px;
        font-size: 0.85rem; font-weight: 600; transition: 0.3s;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        cursor: pointer; border: 1px solid transparent; text-decoration: none;
    }
    .btn-edit-rol   { background: #fdf4ea; color: var(--primary); border-color: var(--primary); }
    .btn-edit-rol:hover   { background: var(--primary); color: white; }
    .btn-delete-user { background: #fff1f1; color: #dc3545; border-color: #dc3545; }
    .btn-delete-user:hover { background: #dc3545; color: white; }

    .empty-state {
        grid-column: 1 / -1; text-align: center;
        padding: 60px 20px; color: #aaa;
    }
    .empty-state i { display: block; margin-bottom: 12px; }

    #no-results {
        grid-column: 1 / -1; text-align: center;
        padding: 50px; display: none; color: #999;
    }

    .footer {
        background-color: var(--primary); color: #fff;
        padding: 1.5rem; text-align: center; margin-top: auto;
    }
  </style>
</head>
<body>

<nav class="navbar">
    <div class="logo">
        <img src="{{ asset('img/logo.png') }}" alt="Logotipo">
        <span>Panel Administración</span>
    </div>
    <div class="links">
        <a href="/admin">Panel</a>
        <a href="/logout" style="color:#dc3545;">Cerrar sesión</a>
    </div>
</nav>

{{-- Flash messages --}}
@if(session('success'))
<script>
    document.addEventListener("DOMContentLoaded", () => {
        Swal.fire({ icon:'success', title:'¡Éxito!', text:'{{ session('success') }}', timer:2500, showConfirmButton:false });
    });
</script>
@endif
@if(session('error'))
<script>
    document.addEventListener("DOMContentLoaded", () => {
        Swal.fire({ icon:'error', title:'Error', text:'{{ session('error') }}' });
    });
</script>
@endif

<div class="header-gestion">
    <h1>Gestión de Usuarios</h1>
    <div class="search-container">
        <i class="fas fa-search"></i>
        <input type="text" id="userInput" class="search-input"
               placeholder="Buscar por nombre o correo..."
               onkeyup="filterUsers()">
    </div>
</div>

<main class="usuarios-grid" id="userGrid">

    @forelse($usuarios as $u)
        @php
            $id        = $u['id']             ?? null;
            $nombre    = $u['nombre']          ?? '';
            $apPaterno = $u['apellidoPaterno'] ?? '';
            $apMaterno = $u['apellidoMaterno'] ?? '';
            $correo    = $u['correo']          ?? 'Sin correo';
            $rol       = strtolower($u['rol']  ?? 'usuario');
            $nombreFull = trim("$nombre $apPaterno $apMaterno") ?: 'Sin nombre';
            $inicial   = $nombre ? strtoupper(mb_substr($nombre, 0, 1)) : '?';
        @endphp

        <div class="usuario-card"
             data-name="{{ strtolower($nombreFull) }}"
             data-email="{{ strtolower($correo) }}">

            <div class="user-avatar">{{ $inicial }}</div>
            <h3>{{ $nombreFull }}</h3>
            <span class="user-email">{{ $correo }}</span>

            <span class="badge-rol {{ $rol === 'admin' ? 'rol-admin' : 'rol-usuario' }}">
                <i class="fas {{ $rol === 'admin' ? 'fa-user-shield' : 'fa-user' }}"></i>
                {{ strtoupper($rol) }}
            </span>

            <div class="acciones-usuario">
                <a href="{{ route('admin.usuarios.editar', $id) }}"
                   class="btn-user-action btn-edit-rol">
                    <i class="fas fa-user-tag"></i> Rol
                </a>

                <button type="button"
                        class="btn-user-action btn-delete-user"
                        onclick="confirmarEliminar('{{ $id }}', '{{ addslashes($nombreFull) }}')">
                    <i class="fas fa-trash-alt"></i>
                </button>

                {{-- Form oculto para eliminar --}}
                <form id="form-delete-{{ $id }}"
                      action="{{ route('admin.usuarios.destroy', $id) }}"
                      method="POST" style="display:none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>

    @empty
        <div class="empty-state">
            <i class="fas fa-users fa-3x"></i>
            <p>No se encontraron usuarios o la API no está respondiendo.</p>
        </div>
    @endforelse

    <div id="no-results">
        <i class="fas fa-search fa-3x" style="display:block;margin-bottom:10px;opacity:0.4;"></i>
        <p>No se encontraron usuarios que coincidan con la búsqueda.</p>
    </div>

</main>

<footer class="footer">
    <p>&copy; Flora y Fauna de Querétaro</p>
</footer>

<script>
    function filterUsers() {
        const input = document.getElementById('userInput').value.toLowerCase();
        const cards = document.getElementsByClassName('usuario-card');
        let visible = 0;
        for (const card of cards) {
            const match = card.dataset.name.includes(input) || card.dataset.email.includes(input);
            card.style.display = match ? '' : 'none';
            if (match) visible++;
        }
        document.getElementById('no-results').style.display =
            (visible === 0 && cards.length > 0) ? 'block' : 'none';
    }

    function confirmarEliminar(id, nombre) {
        Swal.fire({
            title: '¿Eliminar a ' + nombre + '?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then(result => {
            if (result.isConfirmed) {
                document.getElementById('form-delete-' + id).submit();
            }
        });
    }
</script>

</body>
</html>