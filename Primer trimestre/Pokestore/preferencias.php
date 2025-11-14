<?php
session_start();

//Si viene un POST del formulario...
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {

    //Recojo el valor de tema que viene del form (esperado: 'claro' u 'oscuro')
    $tema = trim($_POST['tema'] ?? '');

    //Valido que el valor sea correcto (si no, por defecto 'claro')
    if ($tema !== 'claro' && $tema !== 'oscuro') {
        $tema = 'claro';
    }

    //Guardo la preferencia en una cookie llamada 'tema' que dura 7 días (importante: antes de cualquier echo/HTML)
    setcookie('tema', $tema, time() + 7*24*60*60, '/');

    //Redirijo para evitar reenvíos del form y que se aplique ya el tema en la vista
    header('Location: preferencias.php');
    exit;
}

//Si no hay POST, simplemente muestro el formulario
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Preferencias</title>
</head>
<body>
  <h2>Elige tema</h2>

  <!-- Form con dos radios: el que envías es el NAME (tema) y su VALUE -->
  <form method="post" action="">
    <label>
      <input type="radio" name="tema" value="claro" checked> Claro
    </label>
    <label>
      <input type="radio" name="tema" value="oscuro"> Oscuro
    </label>
    <button type="submit">Guardar</button>
  </form>

  <p><a href="index.php">Volver al inicio</a></p>
</body>
</html>
