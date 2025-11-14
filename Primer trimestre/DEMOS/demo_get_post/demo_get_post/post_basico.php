<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Formulario POST básico</title></head>
<body>
<h2>Formulario POST básico</h2>
<form action="" method="post">
  <label>Nombre: <input type="text" name="nombre"></label>
  <input type="submit" value="Enviar">
</form>
<?php
if ($_POST) {
  echo "<p>Hola, <strong>" . htmlspecialchars($_POST["nombre"]) . "</strong></p>";
}
?>
<p><a href="index.php">Volver</a></p>
</body></html>