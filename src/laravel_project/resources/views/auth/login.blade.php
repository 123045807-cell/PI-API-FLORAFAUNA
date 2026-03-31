<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
</head>
<body>
  <h1>Iniciar sesión (Alumno)</h1>

  @if ($errors->any())
    <div style="color:red;">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('login') }}">
    @csrf

    <label>Número de cuenta</label><br>
    <input name="numero_cuenta" value="{{ old('numero_cuenta') }}"><br><br>

    <label>Contraseña</label><br>
    <input type="password" name="password"><br><br>

    <label>
      <input type="checkbox" name="remember" value="1">
      Recordarme
    </label><br><br>

    <button type="submit">Entrar</button>
  </form>

  <p><a href="{{ route('register.form') }}">Crear cuenta</a></p>
</body>
</html>
