<?php
session_start();

require_once 'includes/arrays.php';

$mensaje = "";

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nombre = trim($_POST['Nombre'] ?? '');
    $edad   = trim($_POST['Edad'] ?? '');

    if ($nombre === "" || $edad === "") {
        $mensaje = "Rellena todos los campos.";
    } elseif (!is_numeric($edad) || (int)$edad <= 0) {
        $mensaje = "Introduce una edad válida.";
    } else {
        // Mismo formato que en arrays.php
        $nuevoUsuario = [
            "nombre" => $nombre,
            "edad" => (int)$edad,
            "librosPrestados" => []
        ];

        // Añadir al array de sesión
        $_SESSION['usuarios'][] = $nuevoUsuario;

        // Actualizar variables locales (por si las usas luego)
        $usuarios = $_SESSION['usuarios'];

        // Volver al listado
        header('Location: listado.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Usuario</title>
</head>
<body>
    <h1>Añadir Usuario</h1>

    <?php if (!empty($mensaje)) : ?>
        <p><strong><?php echo htmlspecialchars($mensaje); ?></strong></p>
    <?php endif; ?>

    <form method="post" action="">
        <label for="Nombre">Nombre:</label>
        <input type="text" id="Nombre" name="Nombre"><br><br>

        <label for="Edad">Edad:</label>
        <input type="number" id="Edad" name="Edad" min="1"><br><br>

        <button type="submit">Añadir usuario</button>
    </form>

    <p><a href="listado.php">Volver al listado</a></p>
</body>
</html>
