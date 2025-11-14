<?php
//inicio de sesion 
session_start();
require_once('conexion_db.php');
include 'includes/header.php';

// Si el usuario no existe te manda al login.php para ingresar un usuario
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

    $genero = $_POST['genero'] ?? '';

    if (!empty($genero)) {
        $consulta_generos = "SELECT * FROM libro WHERE genero = '$genero'";
    } else {
         $consulta_generos = "SELECT * FROM libro";
    }
    $listado_libros = mysqli_query($conexion, $consulta_generos);

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="estilos/css.css">
<title>BIBLIOTECA</title>
</head>
    <body>
        
        <form method="post">
            <label for="genero">Gnenero</label>
            <select name="genero" id="genero">
                <option value=""> -- Seleccione un genero --</option>
                <option value="accion"><?php if($genero=="accion") echo 'selected'; ?>Accion</option>
                <option value="romance"><?php if($genero=="romance") echo 'selected'; ?>Romance</option>
                <option value="drama"><?php if($genero=="drama") echo 'selected'; ?>Drama</option>
                <option value="comedia"><?php if($genero=="comedia") echo 'selected'; ?>Comedia</option>
                <option value="fantasia"><?php if($genero=="fantasia") echo 'selected'; ?>Fantasia</option>
            </select>
        
            <input type="submit">
            <a href="listado.php">Mostrar listado</a>
        </form>
        <br>
        <br>
        <table>
            <tr>
                <th>ID</th>
                <th>ISBN</th>
                <th>Titulo</th>
                <th>Genero</th>
                <th>Editorial</th>
                <th>Descripcion</th>
                <th>Imagen</th>
            </tr>
            <?php

            // Comprobamos que la consulta se haya ejecutado correctamente ($listado_libros no es false)
            // y que la tabla tenga al menos una fila (mysqli_num_rows(...) > 0). --> comprueba que no este vacia la tabla
            // Si ambas condiciones se cumplen, significa que sí hay libros para mostrar.
            if ($listado_libros && mysqli_num_rows($listado_libros) > 0) {
                // toma la siguiente fila del resultado y la guarda en $fila hasta que no haya más.
                while ($fila = mysqli_fetch_assoc($listado_libros))  {


                    // <a href='borrar.php?id={$fila['id']}&imagen=" . urlencode($fila['imagen']) . "'>Borrar</a>
                        // Creamos un enlace que envía por la URL el id del libro y el nombre de la imagen.
                        // urlencode() se usa para asegurar que el nombre de la imagen no tenga problemas con espacios u otros caracteres.
                        // Al hacer clic, se llama a borrar.php y se recibe id e imagen por GET.
                    echo "<tr>
                        <td>{$fila['id']}</td>
                        <td>{$fila['ISBN']}</td>
                        <td>{$fila['titulo']}</td>
                        <td>{$fila['genero']}</td>
                        <td>{$fila['editorial']}</td>
                        <td>{$fila['descripcion']}</td>
                        <td>{$fila['imagen']}</td>
                        <td>
                            <a href='index.php?id={$fila['id']}'>Editar</a>
                            <a href='borrar.php?id={$fila['id']}&imagen=" . urlencode($fila['imagen']) . "'>Borrar</a>
                        </td>
                    </tr>";
                }
            }else {
                echo "<tr><td colspan='9'>No se encontraron resultados.</td></tr>";
            }
            ?>
        </table>
        <a href='index.php'>Registrar LIBRO</a>

    </body>
</html>