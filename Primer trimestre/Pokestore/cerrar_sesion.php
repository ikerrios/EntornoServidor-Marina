<?php
session_start();

$_SESSION = [];

session_destroy();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params(); //Obtiene datos de la cookie
        setcookie(session_name(), '', time() - 42000, 
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    echo "<h2>Sesión cerrada correctamente</h2>";
    echo "<p>Hasta pronto, entrenador Pokémon.</p>";
    echo "<p><a href='index.php'>Volver al inicio</a></p>";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cerrar Sesión</title>
</head>
<body>
    <form method="post" action="">
        <button type="submit">Cerrar Sesión</button>
        <input type="hidden" name="sesion" value="<?= htmlspecialchars($sesion, ENT_QUOTES, 'UTF-8') ?>">
    </form>
</body>
</html>