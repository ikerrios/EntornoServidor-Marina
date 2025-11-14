<?php
session_start();

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $usuario = trim($_POST['nombre']);
        $contraseña = trim($_POST['contraseña']) ;
    
        if(empty($usuario) || empty($contraseña)) {
            echo "Nombre o Contraseña vacíos";
        } else {
            $_SESSION['usuario'] = $usuario;
            $_SESSION['contraseña'] = $contraseña;
            
            header ('Location: listado.php');
        }
    }


?>

<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Index</title>
   </head>
   <body>
        <h2>Bienvenido a la Biblioteca</h2>

        <form method="post" action="">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre"><br><br>

        <label for="contraseña">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña"><br><br>

        <button type="submit">Entrar</button>
    
    </form>        
   </body>
</html>