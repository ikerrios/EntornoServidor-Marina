<?php
    $editar = false;
    require_once('conexion_db.php');

    if (isset($_REQUEST['id'])) {
        $editar = true;
        $idLibro = $_REQUEST['id'];

        // Consulta corregida: selecciona solo el boss que se quiere editar
        $consulta = "SELECT * FROM libro WHERE id = '$idLibro'";
        $resultado_consulta = mysqli_query($conexion, $consulta);
        $libro = mysqli_fetch_array($resultado_consulta);
    }

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $errores = [];
    $datos = [];

    $id = trim($_POST['id'] ?? '');


    $isbn = trim($_POST['isbn'] ?? '');

    if (empty($isbn)) {
        $errores['isbn'] = 'El ISBN no puede estar vacio';
    } else if (!is_numeric($isbn) || $isbn < 3) {
        $errores['isbn'] = 'El ISBN tiene que ser entre 3 y 6 numeros';
    } else {
        $datos['isbn'] = (int)$isbn;
    }

    $titulo = trim($_POST['titulo'] ?? '');

    if (empty($titulo)) {
        $errores['titulo'] = 'El ISBN no puede estar vacio';
    } else if (!is_string($titulo) || mb_strlen($titulo) < 3) {
        $errores['titulo'] = 'El titulo tiene que tener al menos 3 caracteres';
    } else {
        $datos['titulo'] = htmlspecialchars($titulo,ENT_QUOTES,'UTF-8');
    }

    $genero = trim($_POST['genero'] ?? '');

    if (empty($genero)) {
        $errores['genero'] = 'El genero no puede estar vacio';
    } else {
        $generos = ['accion','romance','drama','comedia','fantasia'];

        if (!in_array($genero, $generos)) {
            $errores['genero'] = 'El genero no esta';
        } else {
            $datos['genero'] = htmlspecialchars($genero, ENT_QUOTES, 'UTF-8');
        }
    } 

    $editorial = trim($_POST['editorial'] ?? '');

    if (empty($editorial)) {
        $errores['editorial'] = 'La editorial no puede estar vacio';
    } else if (!is_string($editorial) || mb_strlen($editorial) < 2) {
        $errores['editorial'] = 'La editorial tener al menos 2 caracteres';
    } else {
        $datos['editorial'] = htmlspecialchars($editorial, ENT_QUOTES, 'UTF-8');
    }

    $descripcion = trim($_POST['descripcion'] ?? '');

    if (empty($descripcion)) {
        $errores['descripcion'] = 'La descripcion no puede estar vacio';
    } else if (!is_string($descripcion) || mb_strlen($descripcion) > 400) {
        $errores['descripcion'] = 'La descripcion no debe superar los 400 caracteres';
    } else {
        $datos['descripcion'] = htmlspecialchars($descripcion, ENT_QUOTES, 'UTF-8');
    }


    
// === IMAGEN (USANDO $_FILES) ===
    if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] === UPLOAD_ERR_NO_FILE) {
        $errores['imagen'] = 'Debes subir una imagen';

    } else {
        $imagen = $_FILES['imagen'];
                /*
                $_FILES['imagen'] --> se crea el array con su descripcion.
                $_FILES['imagen'] = [
                    'name'     => 'NombreOriginalDelUsuario.jpg',  // Nombre que tenía el archivo en tu PC
                    'type'     => 'image/jpeg',                    // Tipo MIME (lo envía el navegador)
                    'tmp_name' => '/tmp/phpABC123',                // Ruta temporal en el servidor
                    'error'    => 0,                               // Código de error (0 = OK)
                    'size'     => 123456                           // Tamaño en bytes
                ];
                */
        // Verificar errores de subida
        if ($imagen['error'] !== UPLOAD_ERR_OK) {
            $errores['imagen'] = 'Error al subir la imagen';
        } else {
            // Extensiones permitidas
            $extensiones_permitidas = ['jpg', 'jpeg', 'png'];
            //strlower --> poner todo en minuscula
            $extension = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));

            // Validar extensión
            if (!in_array($extension, $extensiones_permitidas)) {
                $errores['imagen'] = 'Solo se permiten JPG, JPEG o PNG';
            }
            // Validar tamaño (2MB = 2097152 bytes)
            else if ($imagen['size'] > 2097152) {
                $errores['imagen'] = 'La imagen no debe superar 2MB';
            }
            // Opcional: verificar que sea imagen real
            else {
                // Aquí puedes mover el archivo
                //uniqid() --> te pone un nombre unico.
                $nuevo_nombre = 'img_' . uniqid() . '.' . $extension;
                $ruta = 'imagenes/' . $nuevo_nombre;
                if (move_uploaded_file($imagen['tmp_name'], $ruta)) {
                    echo "¡Imagen subida";
                    $datos['imagen'] = $ruta;
                } else {
                    $errores['imagen'] = 'Error al guardar la imagen';
                }
            }
            /* 
            $archivo = $_FILES['texto'];  // name="texto" en el input
            
                1. Abrir el archivo temporal
                $handle = fopen($archivo['tmp_name'], 'r');  // 'r' = leer

                2. Leer todo el contenido
                $contenido = fread($handle, $archivo['size']);

                3. Cerrar el archivo
                fclose($handle);

                /4. Buscar la palabra "gato"
                if (strpos($contenido, 'gato') !== false) {
                    echo "¡Encontrado 'gato'!";
                } else {
                    echo "No se encontró 'gato'";
                }
            */
        }
    }
    if ($errores) {
        echo 'Errores encontrados';

    } else {
        if (!empty($id)) {
            $stmt = $conexion->prepare("UPDATE libro SET ISBN=?, titulo=?, genero=?, editorial=?, descripcion=?, imagen=? WHERE id=?");
            $stmt->bind_param("isssssi", $datos['isbn'], $datos['titulo'], $datos['genero'], $datos['editorial'], $datos['descripcion'], $datos['imagen'], $id);
        } else {
            $stmt = $conexion->prepare("INSERT INTO libro (ISBN, titulo, genero, editorial, descripcion, imagen) VALUES (?,?,?,?,?,?)");
            $stmt->bind_param("isssss", $datos['isbn'], $datos['titulo'], $datos['genero'], $datos['editorial'], $datos['descripcion'], $datos['imagen']);
            /*
                    if ($id) {
                        // UPDATE SIN prepare
                        $sql = "UPDATE libro SET
                                    ISBN = '{$datos['isbn']}',
                                    titulo = '{$datos['titulo']}',
                                    genero = '{$datos['genero']}',
                                    editorial = '{$datos['editorial']}',
                                    descripcion = '{$datos['descripcion']}',
                                    imagen = '{$datos['imagen']}'
                                WHERE id = " . (int)$id;  // ← (int) para seguridad
                    } else {
                        // INSERT SIN prepare
                        $sql = "INSERT INTO libro (ISBN, titulo, genero, editorial, descripcion, imagen)
                                VALUES (
                                    '{$datos['isbn']}',
                                    '{$datos['titulo']}',
                                    '{$datos['genero']}',
                                    '{$datos['editorial']}',
                                    '{$datos['descripcion']}',
                                    '{$datos['imagen']}'
                                )";
                    }
                    // === EJECUTAR Y REDIRIGIR ===
                    if (mysqli_query($conexion, $sql)) {
                        header("Location: list_libros.php");  // ← CORREGIDO
                        exit;                                 // ← AÑADIDO
                    } else {
                        echo "Error: " . mysqli_error($conexion);
                    }
                }
            */
        }
        if ($stmt->execute()) {
            echo '<div class="mensaje-exito">';
            echo !empty($id) ? 'Registro actualizado correctamente' : 'Registro completado correctamente';
            echo '</div>';
            echo '<div class="enlace-volver">';
            echo "<a href='listado.php'>Volver al listado</a>";
            echo '</div>';
        } else {
            echo '<div class="error-db">Error al guardar: '. $stmt->error . '</div>';
        }
    }

    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>BIBLIOTECA</title>
</head>
<body>
    <h1><?= $editar ? 'EDITAR LIBRO' : 'REGISTRAR NUEVO LIBRO' ?></h1>
    <form method="post" enctype="multipart/form-data">
        <?php if ($editar): ?>
            <input type="hidden" name="id" value="<?= $libro['id'] ?>">
            <p><strong>ID:</strong> <?= $libro['id'] ?></p>
        <?php endif; ?>

        <label>ISBN</label>
        <input type="number" name="isbn" value="<?= $libro['ISBN'] ?? ($_POST['isbn'] ?? '') ?>">
        <?php if (isset($errores['isbn'])): ?>
            <span class="error"><?= $errores['isbn'] ?></span>
        <?php endif; ?>

        <label>Título</label>
        <input type="text" name="titulo" value="<?= htmlspecialchars($libro['titulo'] ?? ($_POST['titulo'] ?? '')) ?>">
        <?php if (isset($errores['titulo'])): ?>
            <span class="error"><?= $errores['titulo'] ?></span>
        <?php endif; ?>

        <label>Género</label>
        <select name="genero">
            <option value="">-- Elegir --</option>
            <option value="accion" <?= ($libro['genero'] ?? ($_POST['genero'] ?? '')) == 'accion' ? 'selected' : '' ?>>Acción</option>
            <option value="romance" <?= ($libro['genero'] ?? ($_POST['genero'] ?? '')) == 'romance' ? 'selected' : '' ?>>Romance</option>
            <option value="drama" <?= ($libro['genero'] ?? ($_POST['genero'] ?? '')) == 'drama' ? 'selected' : '' ?>>Drama</option>
            <option value="comedia" <?= ($libro['genero'] ?? ($_POST['genero'] ?? '')) == 'comedia' ? 'selected' : '' ?>>Comedia</option>
            <option value="fantasia" <?= ($libro['genero'] ?? ($_POST['genero'] ?? '')) == 'fantasia' ? 'selected' : '' ?>>Fantasía</option>
        </select>
        <?php if (isset($errores['genero'])): ?>
            <span class="error"><?= $errores['genero'] ?></span>
        <?php endif; ?>

        <label>Editorial</label>
        <input type="text" name="editorial" value="<?= htmlspecialchars($libro['editorial'] ?? ($_POST['editorial'] ?? '')) ?>">
        <?php if (isset($errores['editorial'])): ?>
            <span class="error"><?= $errores['editorial'] ?></span>
        <?php endif; ?>

        <label>Descripción</label>
        <textarea name="descripcion"><?= htmlspecialchars($libro['descripcion'] ?? ($_POST['descripcion'] ?? '')) ?></textarea>
        <?php if (isset($errores['descripcion'])): ?>
            <span class="error"><?= $errores['descripcion'] ?></span>
        <?php endif; ?>

        <label for="imagen">Imagen</label>
        <input type="file" name="imagen" id="imagen" required>
        <?php if (isset($errores['imagen'])): ?>
            <span class="error"><?php $errores['imagen'] ?></span>
        <?php endif; ?>

        <input type="submit">
    </form>
</body>
</html>