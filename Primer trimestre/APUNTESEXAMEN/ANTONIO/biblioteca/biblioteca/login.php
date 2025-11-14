<?php
session_start();


// Comprobamos si en la URL viene el parámetro mensaje=adios,
// lo cual ocurre al cerrar sesión. Si es así, mostramos un mensaje de despedida.
// === (comparación estricta).
if (isset($_GET['mensaje']) && $_GET['mensaje'] === "adios") {
    echo 'Hasta luego! Que tengas un buen día';
}



if (isset($_SESSION['usuario'])) {
    header('Location: listado.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $usuario = trim($_POST['usuario'] ?? '');

    if (!empty($usuario) && is_string($usuario)) {

        $_SESSION['usuario'] = htmlspecialchars($usuario, ENT_QUOTES, 'UTF-8');
        header('location: listado.php');
        exit;

    } else {
        $error = 'Por favor, ingresa un usuario válido.';
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario usuario</title>
</head>
<body>
    <h1>Inicio de sesión</h1>

    <?php if (!empty($error)) : ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario" required>
        <button type="submit">Inciar sesión</button>
    </form>
</body>
</html>

