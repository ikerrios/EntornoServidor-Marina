<?php
session_start();

//Variable metodo que almacena la información del servidor.
//Si es POST la coge y si no (??) se convierte en get.
$metodo = $_SERVER['REQUEST_METHOD'] ?? 'GET';

//Metodo no es 'POST'
if($metodo != 'POST') {
   
    if(isset($_SESSION['usuario'])) { //Si en la sesion queda guardado el usuario
        header('Location: catalogo.php'); //llevame
        exit;
    }
}

//Si el método es igual al texto 'POST', haz lo de dentro.
if($metodo === 'POST') {
    $nombre = trim($_POST['nombre'] ?? ''); //Almaceno en nombre trim(eliminar esapcios en blanco) cojo del post el nombre, si no ''.

    if($nombre === '') { 
        $error = 'El nombre es obligatorio.'; // si el nombre es '', error.
        ?> <script> alert("Nombre obligatorio") </script> <?php
        
    } else {
        $_SESSION['usuario'] = $nombre; //$_SESSION contiene información de toda la sesion y crea variable usuario donde se almacena el nombre del post
        header('Location: catalogo.php');// Redirige al catalogo.php
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokestore</title>
</head>
<body>
    <h2>Bienvenido al index</h2>

    <form method="post" action="">
        <label for="nombre">Nombre de entrenador:</label>
        <input type="text" id="nombre" name="nombre">
        <button type="submit">Entrar</button>
    </form>

</body>
</html>