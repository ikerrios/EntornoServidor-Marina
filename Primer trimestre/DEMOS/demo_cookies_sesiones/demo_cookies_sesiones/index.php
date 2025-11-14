<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Demo Cookies & Sesiones</title>
  <style>
    body { font-family: system-ui; background: #f4f4f9; padding: 2rem; }
    h1 { color: #333; }
    .card { background: white; padding: 1rem; margin: 1rem 0; border-radius: 10px; box-shadow: 0 0 6px #0001; }
    a { display: inline-block; margin: .3rem 0; color: #0077cc; text-decoration: none; }
    a:hover { text-decoration: underline; }
  </style>
</head>
<body>
  <h1>DEMO: Cookies y Sesiones en PHP</h1>
  <p>Ejemplos prácticos y comentados de cómo PHP recuerda datos entre visitas o páginas.</p>

  <div class="card">
    <h2>Ejemplos de Cookies</h2>
    <a href="crear_cookie.php">Crear cookie</a><br>
    <a href="leer_cookie.php">Leer cookie</a><br>
    <a href="actualizar_cookie.php">Actualizar cookie</a><br>
    <a href="borrar_cookie.php">Borrar cookie</a>
  </div>

  <div class="card">
    <h2>Ejemplos de Sesiones</h2>
    <a href="session_inicio.php">Iniciar sesión y guardar datos</a><br>
    <a href="session_leer.php">Leer datos de sesión</a><br>
    <a href="session_id.php">Ver ID de sesión</a><br>
    <a href="session_destruir.php">Destruir sesión</a>
  </div>
</body>
</html>