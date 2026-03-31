<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registro</title>
</head>
<body>
  <h1>Registro Alumno</h1>

  @if ($errors->any())
    <div style="color:red;">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('register') }}">
    @csrf

    <label>Nombre</label><br>
    <input name="nombre" value="{{ old('nombre') }}"><br><br>

    <label>Apellido paterno</label><br>
    <input name="apellido_paterno" value="{{ old('apellido_paterno') }}"><br><br>

    <label>Apellido materno</label><br>
    <input name="apellido_materno" value="{{ old('apellido_materno') }}"><br><br>

    <label>Número de cuenta</label><br>
    <input name="numero_cuenta" value="{{ old('numero_cuenta') }}"><br><br>

    <label>Contraseña</label><br>
    <input type="password" name="password"><br><br>

    <label>Confirmar contraseña</label><br>
    <input type="password" name="password_confirmation"><br><br>

    <button type="submit">Registrarme</button>
  </form>

  <p><a href="{{ route('login.form') }}">Ya tengo cuenta</a></p>
</body>
</html>
