<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Panel de Control | Administradora</title>
  
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <style>
    :root {
        --primary: #8C5E2A;
        --bg-body: #f8f7f0;
        --card-bg: #ffffff;
    }

    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background-color: var(--bg-body);
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      padding-top: 60px;
    }

    .navbar {
      position: fixed; top: 0; width: 100%; z-index: 1000;
      display: flex; justify-content: space-between; align-items: center;
      padding: 0 2rem; background-color: #fff;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1); height: 60px; box-sizing: border-box;
    }

    .logo {
      display: flex; align-items: center; font-weight: bold;
      font-family: 'Playfair Display', serif; color: var(--primary);
    }

    .logo img { height: 40px; margin-right: 12px; }

    .links a {
      text-decoration: none;
      color: #8C5E2A;
      font-weight: 600;
      font-size: 0.9rem;
      transition: 0.3s;
    }

    .links a:hover { opacity: 0.7; }

    .panel-contenido {
      max-width: 1200px;
      margin: 0 auto;
      padding: 40px 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
      width: 100%;
      box-sizing: border-box;
    }

    .bienvenida {
      text-align: center;
      margin-bottom: 40px;
    }

    .bienvenida h1 {
      font-family: 'Playfair Display', serif;
      font-size: 2.5rem;
      color: #333;
      margin: 0 0 10px 0;
    }

    .bienvenida p {
      color: #777;
      font-size: 1.1rem;
    }

    .grid-acciones {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
      width: 100%;
      max-width: 1100px; 
    }

    .card-acceso {
      background: var(--card-bg);
      padding: 25px 15px;
      border-radius: 20px;
      text-decoration: none;
      text-align: center;
      color: #333;
      box-shadow: 0 4px 15px rgba(0,0,0,0.03);
      border: 1px solid rgba(0,0,0,0.05);
      transition: all 0.3s ease;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 15px;
    }

    .card-acceso i {
      font-size: 2.2rem; 
      color: var(--primary);
      background: #fdf4ea;
      width: 70px;
      height: 70px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      transition: 0.3s;
    }

    .card-acceso span {
      font-weight: 700;
      font-size: 1rem;
    }

    .card-acceso:hover {
      transform: translateY(-8px);
      box-shadow: 0 12px 30px rgba(140, 94, 42, 0.1);
      border-color: var(--primary);
    }

    .card-acceso:hover i {
      background: var(--primary);
      color: white;
    }

    .imagen-centro {
      width: 100%;
      max-width: 350px;
      opacity: 0.9;
      margin-top: 10px;
    }

    .imagen-centro img {
      width: 100%;
      height: auto;
      filter: drop-shadow(0 10px 20px rgba(0,0,0,0.1));
    }

    @media (max-width: 768px) {
      .grid-acciones {
        grid-template-columns: repeat(2, 1fr); 
      }
    }

    .footer {
      background-color: var(--primary);
      color: #fff;
      padding: 1.5rem;
      text-align: center;
      margin-top: auto;
    }
  </style>
</head>

<body>

<nav class="navbar">
  <div class="logo">
    <img src="{{ asset('img/logo.png') }}" alt="Logotipo">
    <span>Panel Administradora</span>
  </div>

  <div class="links">
    <a href="{{ route('logout') }}">
      <i class="fas fa-sign-out-alt"></i> Cerrar sesión
    </a>
  </div>
</nav>

<main class="panel-contenido">

<section class="bienvenida">
  <h1>¡Bienvenida, administradora!</h1>
  <p>¿Qué deseas gestionar hoy en el sistema?</p>
</section>

<div class="grid-acciones">

  <a href="{{ route('admin.usuarios') }}" class="card-acceso">
    <i class="fas fa-users-cog"></i>
    <span>Usuarios</span>
  </a>

  <a href="{{ route('admin.especies') }}" class="card-acceso">
    <i class="fas fa-leaf"></i>
    <span>Especies</span>
  </a>

  <a href="{{ route('admin.comentarios') }}" class="card-acceso">
    <i class="fas fa-comments"></i>
    <span>Comentarios</span>
  </a>

  <a href="{{ route('admin.consejos') }}" class="card-acceso">
    <i class="fas fa-lightbulb"></i>
    <span>Consejos</span>
  </a>

</div>

<div class="imagen-centro">
  <img src="{{ asset('img/logo.png') }}" alt="Ilustración Administración">
</div>

</main>

<footer class="footer">
  <p>&copy; 2025 Flora y Fauna de Querétaro. Panel de Control Centralizado.</p>
</footer>

</body>
</html>