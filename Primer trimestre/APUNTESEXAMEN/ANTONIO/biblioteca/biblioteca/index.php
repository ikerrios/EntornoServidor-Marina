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

    // Comprobamos si llega un 'id' por GET o POST (editar).
    // Si existe, significa que estamos editando un libro ya guardado.
    // Entonces activamos $editar, guardamos el id y consultamos ese libro en la base de datos
    // para rellenar el formulario con sus datos actuales.
    //
    // Si no existe 'id', entonces $editar queda en false y el formulario será para registrar uno nuevo.
    $editar = false;
    if (isset($_REQUEST['id'])) {
        $editar = true;
        $idLibro = $_REQUEST['id'];


    // Hacemos una consulta para obtener los datos del libro con el id recibido.
    // mysqli_query() ejecuta la consulta en la base de datos.
    // mysqli_fetch_array() convierte el resultado en un array para poder acceder a los campos,
    // por ejemplo $libro['titulo'], $libro['genero'], etc.
    $consulta = "SELECT * FROM libro WHERE id = '$idLibro'";
    $resultado_consulta = mysqli_query($conexion, $consulta);
    $libro = mysqli_fetch_array($resultado_consulta);

    }



// $_SERVER['REQUEST_METHOD'] contiene el método con el que se envió el formulario (GET o POST).
// Con esta comparación comprobamos si el formulario se envió mediante POST.
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    // $errores = [] --> array guardar los errores con su 'name' que recibe del formulario y el texto del error.
    // $datos = [] --> una vez haya pasado los filtro bien se guarda en este array con su 'name' que recibe del formulario y el texto.
    $errores = [];
    $datos = [];

    // El operador ?? comprueba si $_POST['id'] existe y no es null.
    // Si existe, usa ese valor. Si no, usa '' (cadena vacía) como valor por defecto.
    // Luego trim() quita espacios en blanco al inicio y al final del valor.
    $id = trim($_POST['id'] ?? '');


    $isbn = trim($_POST['isbn'] ?? '');

    // empty($variable) comprueba si la variable está vacía.
    if (empty($isbn)) {
        $errores['isbn'] = 'El ISBN no puede estar vacio';
    } else if (!is_numeric($isbn) || $isbn < 3) {
        $errores['isbn'] = 'El ISBN tiene que ser entre 3 y 6 numeros';
    } else {
        // (tipo)$variable --> convierte la variable en el tipo que queramos
        $datos['isbn'] = (int)$isbn; 
    }

    $titulo = trim($_POST['titulo'] ?? '');

    if (empty($titulo)) {
        $errores['titulo'] = 'El ISBN no puede estar vacio';
        //is_string() , is_numeric() --> comprueba si su tipo es string, numero ...etc
        //mb_strlen() --> // mb_strlen() devuelve la longitud de una cadena contando correctamente caracteres.
    } else if (!is_string($titulo) || mb_strlen($titulo) < 3) { 
        $errores['titulo'] = 'El titulo tiene que tener al menos 3 caracteres';
    } else {
        // htmlspecialchars() convierte caracteres especiales en entidades HTML para evitar
        // que se interpreten como código. Esto previene problemas de seguridad (XSS).
        // ENT_QUOTES hace que también se conviertan las comillas simples y dobles.
        // 'UTF-8' indica la codificación del texto.
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


    // Comprobamos si no se ha enviado el archivo.
    // esto !isset($_FILES['imagen']) verifica que el campo 'imagen' no exista (no se subió nada).
    // $_FILES['imagen']['error'] === UPLOAD_ERR_NO_FILE indica que no se seleccionó ningún archivo.
    // Si cualquiera de estas condiciones se cumple, significa que no hay imagen.
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
                Para hacer validaciones de un arhivo se usan los parametros que te 
                mete por defecto (name,type,tmp_name,error,size).
                */


        // $imagen['error'] contiene el código de error de la subida.
        // UPLOAD_ERR_OK significa que la imagen se subió sin problemas.
        // Si el error es distinto, entonces ocurrió algún problema en la subida.
        if ($imagen['error'] !== UPLOAD_ERR_OK) {
            $errores['imagen'] = 'Error al subir la imagen';
        } else {
            // Extensiones permitidas
            $extensiones_permitidas = ['jpeg', 'png'];

            // strtolower() convierte esa variable a minúsculas.
            // pathinfo($imagen['name'], PATHINFO_EXTENSION) obtiene la extensión del archivo (por ejemplo: "jpg", "png").
            $extension = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));

            // Validar extensión
            if (!in_array($extension, $extensiones_permitidas)) {
                $errores['imagen'] = 'Solo se permiten JPG, JPEG o PNG';
            }

            // Validar tamaño (2MB = 2097152 bytes) las validaciones de tamaño se hacen en bytes.
                // 1MB = 1048576 bytes
                // 3MB = 3145728 bytes
            else if ($imagen['size'] > 2097152) {
                $errores['imagen'] = 'La imagen no debe superar 2MB';
            }
            // Opcional: verificar que sea imagen real
            else {
                // Aquí puedes mover el archivo
                //$nuevo_nombre = 'img_' . uniqid() . '.' . $extension; --> || uniqid() --> te pone un nombre unico.
                $nuevo_nombre = $imagen['name'];
                $ruta = 'imagenes/' . $nuevo_nombre;

                // move_uploaded_file() mueve el archivo desde la carpeta temporal del servidor
                // $imagen['tmp_name'] es el nombre temporal del archivo subido.
                // (donde se guarda al subirlo) hacia la ruta definitiva indicada en $ruta.
                if (move_uploaded_file($imagen['tmp_name'], $ruta)) {
                    echo "¡Imagen subida";
                    $datos['imagen'] = $ruta;
                } else {
                    $errores['imagen'] = 'Error al guardar la imagen';
                }
            }
             
            /*$archivo = $_FILES['texto'];  // name="texto" en el input
            
                1. Abrir el archivo temporal
                    $permiso = fopen($archivo['tmp_name'], 'r');  // 'r' = leer

                2. Leer todo el contenido
                    $contenido = fread($permiso, $archivo['size']);

                3. Cerrar el archivo
                    fclose($permiso);

                4. Buscar la palabra  o por vatiables

                    Buscar la palabra "Juan Antonio"

                        strpos() --> solo puede buscar una cadena cada vez.
                        if (strpos($contenido, 'Juan Antonio') !== false) {
                            $datos['archivo'] =  '¡Encontrado Juan Antonio!';
                        } else {
                            $errores['archivo'] = 'No se encontró JUan Carlos';
                        }

                4. Buscar la variables

                    variables para buscar

                        $nombre1 = 'Juan Carlos';
                        $nombre2 = 'Juan Antonio';

                        strpos() --> solo puede buscar una cadena cada vez.
                        if (strpos($contenido, $nombre1) !== false && strpos($contenido, $nombre2) !== false) {
                            $datos['archivo'] =  '¡Encontrado '.$nombre1. ' y '.$nombre2;
                        } else {
                            $errores['archivo'] = '¡No encontro '.$nombre1. ' y '.$nombre2;
                        }*/
        }
    }
    if ($errores) {
        echo 'Errores encontrados';

    } else {
        if (!empty($id)) {

            // Preparamos una consulta SQL con marcadores (?) para evitar inyecciones SQL.
            // Luego bind_param() asocia cada marcador con una variable y su tipo:
            //
            // "isssssi" indica los tipos de datos en orden:
            //  i = integer (entero)
            //  s = string  (cadena)
            //
            // De esta forma se pasan los datos de manera segura a la consulta.

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
                        header("Location: listado.php");  // ← CORREGIDO
                        exit;                                 // ← AÑADIDO
                    } else {
                        echo "Error: " . mysqli_error($conexion);
                    }
                }
            */
        }

        // $stmt->execute() ejecuta la consulta preparada.
        // Si devuelve true, la consulta se realizó correctamente.
        // Si devuelve false, hubo un error al ejecutar la consulta.
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
<link rel="stylesheet" href="estilos/css.css">
</head>
<body>
    <h1><?= $editar ? 'EDITAR LIBRO' : 'REGISTRAR NUEVO LIBRO' ?></h1>

    <!-- enctype="multipart/form-data" - se coloca por si usamos el $_FILES -->
    <form method="post" enctype="multipart/form-data">
        <?php if ($editar): ?>
            <input type="hidden" name="id" value="<?= $libro['id'] ?>">
            <p><strong>ID:</strong> <?= $libro['id'] ?></p>
        <?php endif; ?>

        <label>ISBN</label>

        <!--Para validar desde el lado del cliente:

            - Si el input es de TEXTO (type="text" o textarea):
                minlength="x"  → número mínimo de CARACTERES
                maxlength="x"  → número máximo de CARACTERES
                
            - Si el input es NUMÉRICO (type="number"):
                min="x"  → valor numérico mínimo permitido
                max="x"  → valor numérico máximo permitido-->
        <input type="number" name="isbn" value="<?= $libro['ISBN'] ?? ($_POST['isbn'] ?? '') ?>">

        <!-- Para mostrar los errores -->
        <?php if (isset($errores['isbn'])): ?>
            <span class="error"><?= $errores['isbn'] ?></span>
        <?php endif; ?>

        <label>Título</label>

        <!-- $libro['titulo'] si estamos editando (ya viene de la BD).
        // Si no existe (estamos creando un nuevo libro), usa $_POST['titulo'] si el usuario ya escribió algo.
        // Si tampoco existe (primera vez que se carga el formulario), usa '' (vacío).-->
        <input type="text" name="titulo" value="<?= htmlspecialchars($libro['titulo'] ?? ($_POST['titulo'] ?? '')) ?>">
        <?php if (isset($errores['titulo'])): ?>
            <span class="error"><?= $errores['titulo'] ?></span>
        <?php endif; ?>

        <label>Género</label>
        <select name="genero">

            <!--Si el valor es 'accion', entonces devuelve 'selected' para marcar la opción en el <select>.
                Si no, devuelve '' (nada), por lo que la opción no queda seleccionada.-->
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


        <!-- required - hace que tenga que ser campo obligatorio -->
        <input type="file" name="imagen" id="imagen" required> 
        <?php if (isset($errores['imagen'])): ?>
            <span class="error"><?php $errores['imagen'] ?></span>
        <?php endif; ?>

        <?php /* ?>

        <label for="texto">Archivo</label>
        <input type="file" name="texto" id="texto" required>

        <?php if (isset($errores['texto'])): ?>
            <span class="error"><?php echo $errores['texto']; ?></span>
        <?php endif; ?>

        <?php */ ?>


        <input type="submit">
    </form>
</body>
</html>