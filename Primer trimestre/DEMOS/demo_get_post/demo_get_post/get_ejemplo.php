<?php
// Ejemplo básico de GET
$id = $_GET["id"];
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Ejemplo GET</title></head>
<body>
<h2>Ejemplo básico de GET</h2>
<p>Has pedido el producto número <strong><?php echo htmlspecialchars($id); ?></strong>.</p>
<p><a href="index.php">Volver al índice</a></p>
</body></html>