<?php
require_once('conexion_db.php');

?>
<?php
    $genero = $_POST['genero'] ?? '';

    if (!empty($genero)) {
        $consulta_generos = "SELECT * FROM libro WHERE genero";
    } else {
         $consulta_generos = "SELECT * FROM libro";
    }
    $listado_libros = mysqli_query($conexion, $consulta_generos);

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>BIBLIOTECA</title>
</head>
    <body>
        <form method="post">
            <label for="genero">Gnenero</label>
            <select name="genero" id="genero">
                <option value=""> -- Seleccione un genero --</option>
                <option value="accion"><?php if($genero=="accion") echo 'selected'; ?></option>
                <option value="romance"><?php if($genero=="romance") echo 'selected'; ?></option>
                <option value="drama"><?php if($genero=="drama") echo 'selected'; ?></option>
                <option value="comedia"><?php if($genero=="comedia") echo 'selected'; ?></option>
                <option value="fantasia"><?php if($genero=="fantasia") echo 'selected'; ?></option>
            </select>
        
            <input type="submit">
            <a href="listado.php">Mostrar listado</a>
        </form>

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

            if ($listado_libros && mysqli_num_rows($listado_libros) > 0) {
                while ($fila = mysqli_fetch_assoc($listado_libros))  {

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