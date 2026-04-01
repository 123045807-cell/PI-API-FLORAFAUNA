<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Rol</title>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
        padding-top: 80px;
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
        font-size: 0.9rem; margin-left: 20px;
    }
    .links a:hover { color: var(--primary); }

    .editar-contenido {
        max-width: 500px;
        margin: 40px auto;
        width: 90%;
    }
    .card-edicion {
        background: var(--card-bg);
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.05);
        text-align: center;
    }
    .avatar-grande {
        width: 80px; height: 80px;
        background: #f0ede5; color: var(--primary);
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        font-size: 2rem; font-weight: 700; margin: 0 auto 20px;
        border: 3px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    h1 {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem; color: #333; margin-bottom: 6px;
    }
    .user-name-sub {
        font-size: 1rem; font-weight: 600; color: #444; margin-bottom: 4px;
    }
    .user-mail {
        display: block; color: #777; font-size: 0.88rem; margin-bottom: 30px;
    }
    label {
        display: block; text-align: left; font-weight: 700;
        margin-bottom: 8px; font-size: 0.85rem; color: #444;
        text-transform: uppercase; letter-spacing: 0.5px;
    }
    select {
        width: 100%; padding: 12px 15px; border-radius: 10px;
        border: 1px solid #d1d5db; background-color: #f9fafb;
        font-family: 'Inter', sans-serif; font-size: 1rem;
        margin-bottom: 30px; outline: none; cursor: pointer; transition: border-color 0.2s;
    }
    select:focus { border-color: var(--primary); }

    .botones-formulario { display: flex; flex-direction: column; gap: 12px; }
    .boton {
        padding: 14px; border-radius: 10px; font-weight: 700;
        text-decoration: none; font-size: 0.95rem; cursor: pointer;
        transition: 0.3s; border: none; display: block; text-align: center;
    }
    .btn-guardar { background-color: var(--primary); color: white; }
    .btn-guardar:hover { background-color: #6f4a20; }
    .btn-cancelar {
        background-color: transparent; color: #6b7280; border: 1px solid #d1d5db;
    }
    .btn-cancelar:hover { background-color: #f3f4f6; color: #374151; }

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
        <a href="{{ route('admin.usuarios') }}">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
</nav>

<main class="editar-contenido">
    <div class="card-edicion">

        @php
            $nombre    = $usuario['nombre']          ?? '';
            $apPaterno = $usuario['apellidoPaterno'] ?? '';
            $apMaterno = $usuario['apellidoMaterno'] ?? '';
            $correo    = $usuario['correo']          ?? 'Sin correo';
            $rol       = strtolower($usuario['rol']  ?? 'usuario');
            $nombreFull = trim("$nombre $apPaterno $apMaterno") ?: 'Sin nombre';
            $inicial   = $nombre ? strtoupper(mb_substr($nombre, 0, 1)) : '?';
        @endphp

        <div class="avatar-grande">{{ $inicial }}</div>

        <h1>Editar Rol</h1>
        <p class="user-name-sub">{{ $nombreFull }}</p>
        <span class="user-mail">{{ $correo }}</span>

        <form action="{{ route('admin.usuarios.update', $usuario['id']) }}" method="POST">
            @csrf
            @method('PUT')

            <label for="rol">Asignar Nivel de Acceso</label>
            <select name="rol" id="rol">
                <option value="usuario" {{ $rol === 'usuario' ? 'selected' : '' }}>Usuario</option>
                <option value="admin"   {{ $rol === 'admin'   ? 'selected' : '' }}>Administrador</option>
            </select>

            <div class="botones-formulario">
                <button type="submit" class="boton btn-guardar">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
                <a href="{{ route('admin.usuarios') }}" class="boton btn-cancelar">
                    Cancelar
                </a>
            </div>
        </form>

    </div>
</main>

<footer class="footer">
    <p>&copy; Flora y Fauna de Querétaro</p>
</footer>

</body>
</html>