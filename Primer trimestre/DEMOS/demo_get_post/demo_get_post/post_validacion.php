<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Validación POST</title></head>
<body>
<h2>Validación de datos POST</h2>
<form method="post" action="">
  <input type="text" name="nombre" placeholder="Tu nombre">
  <input type="submit" value="Enviar">
</form>
<?php
if (isset($_POST["nombre"])) {
  echo "<p>Nombre recibido: <strong>" . htmlspecialchars($_POST["nombre"]) . "</strong></p>";
} else {
  echo "<p>Introduce tu nombre.</p>";
}
?>
<p><a href="index.php">Volver</a></p>
</body></html>