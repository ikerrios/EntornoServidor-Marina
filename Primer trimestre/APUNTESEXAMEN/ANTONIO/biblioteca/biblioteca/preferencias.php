<?php
session_start();


if (isset($_POST['tema'])) {

    // setcookie() crea una cookie en el navegador.
    // 'tema' es el nombre de la cookie.
    // $_POST['tema'] es el valor que guardará al recibirlo por POST.
    // time() + 604800 --> indica la duración: ahora + 7 días (604800 segundos).
    setcookie('tema', $_POST['tema'], time() + 604800);
}

// El operador ?? asigna un valor por defecto si la cookie no existe (en este caso 'claro').
// htmlspecialchars() convierte caracteres especiales para evitar inyección de código (XSS).
// ENT_QUOTES hace que convierta también comillas simples y dobles.
// 'UTF-8' indica la codificación del texto.
$tema_actual = htmlspecialchars($_COOKIE['tema'] ?? 'claro', ENT_QUOTES, 'UTF-8');

?>


<!DOCTYPE html>
<html lang="es" data-tema="<?php echo $tema_actual; ?>">
<head>
    <meta charset="UTF-8">
    <title>Preferencias</title>
    <link rel="stylesheet" href="estilos/css.css">
</head>
<body>
    <h1>Elige tu tema favorito</h1>

    <form method="post">
        <input type="radio" name="tema" value="claro" id="claro" <?php if($tema_actual == 'claro') echo 'checked'; ?>>
        <label for="claro">Tema Claro</label><br>
        
        <input type="radio" name="tema" value="oscuro" id="oscuro" <?php if($tema_actual == 'oscuro') echo 'checked'; ?>>
        <label for="oscuro">Tema Oscuro</label><br>
        <button>Guardar</button>
    </form>
    <br>
    <a href="listado.php">Volver al listado</a>
</body>
</html>
</html>