<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Formulario con arrays</title></head>
<body>
<h2>Formulario con arrays y selects múltiples</h2>
<form method="post">
  <label>Contraseña: <input type="password" name="clave[original]"></label><br>
  <label>Repetir: <input type="password" name="clave[repetida]"></label><br>
  <label>Categorías:</label><br>
  <select name="categorias[]" multiple>
    <option value="php">PHP</option>
    <option value="html">HTML</option>
    <option value="css">CSS</option>
  </select><br><br>
  <input type="submit" value="Enviar">
</form>
<?php
if ($_POST) {
  echo "<pre>";
  print_r($_POST);
  echo "</pre>";
}
?>
<p><a href="index.php">Volver</a></p>
</body></html>