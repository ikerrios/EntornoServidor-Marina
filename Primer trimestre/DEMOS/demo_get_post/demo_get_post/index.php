<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Demo GET & POST en PHP</title>
  <style>
    body { font-family: system-ui; background: #f4f4f9; padding: 2rem; }
    h1 { color: #333; }
    .card { background: white; padding: 1rem; margin: 1rem 0; border-radius: 10px; box-shadow: 0 0 6px #0001; }
    a { display: inline-block; margin: .3rem 0; color: #0077cc; text-decoration: none; }
    a:hover { text-decoration: underline; }
  </style>
</head>
<body>
  <h1>DEMO: Métodos GET y POST en PHP</h1>
  <p>Haz clic en los enlaces o prueba los formularios para ver cómo se envían y reciben los datos.</p>

  <div class="card">
    <h2>Ejemplos con GET</h2>
    <a href="get_ejemplo.php?id=34">Ver producto 34</a><br>
    <a href="get_validacion.php">Validar parámetro GET</a><br>
    <a href="get_urlencode.php">Uso de urlencode()</a>
  </div>

  <div class="card">
    <h2>Ejemplos con POST</h2>
    <a href="post_basico.php">Formulario POST básico</a><br>
    <a href="post_validacion.php">Validación de formulario</a><br>
    <a href="post_multiple.php">Formulario con varios botones</a><br>
    <a href="arrays_form.php">Formulario con arrays</a>
  </div>
</body>
</html>