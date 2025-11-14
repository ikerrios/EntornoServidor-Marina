<?php
session_start();
require_once('conexion_db.php');

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
} else {
    echo 'Buenas, ' . $_SESSION['usuario'];
}

$id = $_GET['id'];
$imagen = $_GET['imagen'];

$borrar = "DELETE FROM libro WHERE id = ".$id;

// Construimos la ruta completa de la imagen en la carpeta 'imagenes'.
// basename() se usa para asegurar que solo obtenemos el nombre del archivo, sin rutas externas.
$ruta_imagen = "imagenes/" . basename($imagen);

// Si el nombre de la imagen no está vacío y el archivo realmente existe en el servidor,
// entonces lo borramos con unlink() para eliminar la imagen antigua.
if (!empty($imagen) && file_exists($ruta_imagen)) {
    unlink($ruta_imagen); // Elimina el archivo del servidor (de la carpeta)
}


    if(mysqli_query($conexion, $borrar)) {
        header("location: listado.php");
        exit;
    }else {
        mysqli_error($conexion);
    }
?>

