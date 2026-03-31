<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>
</head>
<body>
  <h1>Dashboard</h1>

  <p><b>Nombre:</b> {{ $alumno->nombre }}</p>
  <p><b>Apellido paterno:</b> {{ $alumno->apellido_paterno }}</p>
  <p><b>Apellido materno:</b> {{ $alumno->apellido_materno }}</p>
  <p><b>Número de cuenta:</b> {{ $alumno->numero_cuenta }}</p>
  <p><b>Rol:</b> {{ $alumno->rol }}</p>

  <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Cerrar sesión</button>
  </form>
</body>
</html>
