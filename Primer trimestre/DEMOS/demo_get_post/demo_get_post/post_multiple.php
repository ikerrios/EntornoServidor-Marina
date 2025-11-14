<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Varios botones</title></head>
<body>
<h2>Formulario con varios botones</h2>
<form method="post">
  <input type="submit" value="Editar" name="accion">
  <input type="submit" value="Borrar" name="accion">
</form>
<?php
if (isset($_POST["accion"])) {
  if ($_POST["accion"] == "Editar") echo "<p>Modo edición activado</p>";
  elseif ($_POST["accion"] == "Borrar") echo "<p>Eliminando registro...</p>";
}
?>
<p><a href="index.php">Volver</a></p>
</body></html>