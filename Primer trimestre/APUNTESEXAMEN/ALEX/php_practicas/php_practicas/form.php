<?php
include 'conexion.php';

$error = [];
$nombre = $email = $telefono = '';
$id = null;


if (isset($user)) {
    $id = $user['id'];
    $nombre = $user['nombre'] ?? '';
    $email = $user['email'] ?? '';
    $telefono = $user['telefono'] ?? '';
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);

    if ($nombre === '') $errores[] = "Nombre obligatorio.";
    if($nombre > 3) $errores[] = "Nombre minimo de 3 letras";
    
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = "El email no es válido.";
    if($email )

    if (empty($errores)) {

        if ($id) {
            
            $stmt = $conexion->prepare("UPDATE usuarios SET nombre = ?, email = ?, telefono = ? WHERE id = ?");
            $stmt->bind_param("sssi", $nombre, $email, $telefono, $id);

        }else{

            $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, email, telefono) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nombre, $email, $telefono);
    }

    if ($stmt->execute()) {
            header("Location: index.php");
            exit;
        } else {
            $error[] = "Error al guardar en la base de datos.";
        }

    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inser nuevo usuario</title>
</head>
<body>
    
    <?php foreach($errores as $error): ?>
    <p style="color:red;"><?= $error ?></p>
    <?php endforeach; ?>

    <form action="" method="POST">

        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($nombre)?>"><br><br>

        <label for="email">Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($email)?>"><br><br>

        <label for="telefono">Telefono</label>
        <input type="text" name="telefono" value="<?= htmlspecialchars($telefono)?>"><br><br>
        <button type="submit">Guardar</button>
        <a href="index.php">Cancelar</a>


    </form>
    
</body>
</html>