<?php
/*
================================================================================
|                                                                              |
|                GUÍA COMPLETA DE VARIABLES SUPERGLOBALES EN PHP               |
|                                                                              |
================================================================================

Las variables superglobales son variables predefinidas en PHP que están siempre 
disponibles en todos los ámbitos (dentro de funciones, clases y en el script 
principal) sin necesidad de usar la declaración `global`.

Contienen información valiosa sobre el entorno del servidor, la petición del 
cliente y el estado de la aplicación. Son siempre arrays asociativos.

Para probar los ejemplos, guarda este archivo como "guia_PHP.php" en tu servidor
web y accede a él desde tu navegador.

*/

// Para usar $_SESSION, es OBLIGATORIO iniciar la sesión al principio del script.
session_start();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Guía de Superglobales en PHP</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; padding: 20px; }
        h1, h2 { border-bottom: 2px solid #007bff; padding-bottom: 5px; }
        pre { background-color: #f4f4f4; padding: 15px; border-radius: 5px; border: 1px solid #ccc; white-space: pre-wrap; word-wrap: break-word; }
        .nota { background-color: #fffbe6; border-left: 4px solid #ffc107; padding: 10px; margin: 10px 0; }
        .peligro { background-color: #f8d7da; border-left: 4px solid #dc3545; padding: 10px; margin: 10px 0; }
    </style>
</head>
<body>

<h1>Guía de Superglobales en PHP</h1>

<?php

/*
================================================================================
| 1. $_SERVER                                                                  |
================================================================================

Contiene información sobre el servidor web y el entorno de ejecución. Es muy útil
para obtener detalles sobre la petición actual.

Usos Comunes:
- `$_SERVER['REQUEST_METHOD']`: Método de la petición ('GET', 'POST', etc.).
- `$_SERVER['PHP_SELF']`: Nombre del script que se está ejecutando.
- `$_SERVER['REMOTE_ADDR']`: Dirección IP del cliente.
- `$_SERVER['HTTP_HOST']`: Dominio desde el que se accede.
- `$_SERVER['REQUEST_TIME']`: Marca de tiempo del inicio de la petición.

*/
echo "<h2>1. \$_SERVER</h2>";
echo "<pre>";
echo "Método de la petición (REQUEST_METHOD): " . htmlspecialchars($_SERVER['REQUEST_METHOD']) . "\n";
echo "Script actual (PHP_SELF): " . htmlspecialchars($_SERVER['PHP_SELF']) . "\n";
echo "Tu dirección IP (REMOTE_ADDR): " . htmlspecialchars($_SERVER['REMOTE_ADDR'] ?? 'No disponible') . "\n";
echo "Host (HTTP_HOST): " . htmlspecialchars($_SERVER['HTTP_HOST'] ?? 'No disponible') . "\n";
echo "</pre>";


/*
================================================================================
| 2. $_GET                                                                     |
================================================================================

Contiene las variables pasadas al script a través de la URL (query string).
Ejemplo: /guia_PHP.php?id=123&accion=ver

¡SEGURIDAD! Los datos en $_GET son visibles y fáciles de manipular.
NUNCA confíes en ellos. Siempre valida y sanea los datos.

*/
echo "<h2>2. \$_GET</h2>";
echo '<div class="nota">Prueba a visitar esta página añadiendo <strong>?usuario=Ana&id=99</strong> a la URL.</div>';

// Se comprueba si la variable 'usuario' existe en la URL
$usuario_get = "Invitado";
if (isset($_GET['usuario'])) {
    // Se sanea la entrada para prevenir ataques XSS antes de mostrarla.
    $usuario_get = htmlspecialchars($_GET['usuario']);
}

// Se valida que el 'id' sea un número entero.
$id_get = "No especificado";
$id_validado = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id_validado !== false && $id_validado !== null) {
    $id_get = $id_validado;
}

echo "<pre>";
echo "Valor de \$_GET['usuario']: " . $usuario_get . "\n";
echo "Valor de \$_GET['id'] (validado como entero): " . $id_get . "\n";
echo "Contenido completo de \$_GET: \n";
print_r($_GET);
echo "</pre>";


/*
================================================================================
| 3. $_POST                                                                    |
================================================================================

Contiene las variables pasadas al script a través de una petición HTTP POST,
típicamente desde un formulario HTML. Los datos no son visibles en la URL.

¡SEGURIDAD! Aunque no son visibles, los datos de $_POST también provienen del
usuario y deben ser validados y saneados rigurosamente.

*/
echo "<h2>3. \$_POST</h2>";

// Lógica para procesar el formulario cuando se envía
$nombre_post = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'])) {
    // Recoger, limpiar y sanear el dato
    $nombre_post = htmlspecialchars(trim($_POST['nombre']));
    echo "<div class='nota'>Formulario recibido. Hola, <strong>{$nombre_post}</strong>.</div>";
}
?>
<!-- Formulario de ejemplo que envía datos por POST a esta misma página -->
<form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <label for="nombre">Introduce tu nombre:</label>
    <input type="text" id="nombre" name="nombre" value="">
    <button type="submit">Enviar por POST</button>
</form>
<pre>
<?php
echo "Contenido completo de \$_POST (después de enviar el formulario): \n";
print_r($_POST);
?>
</pre>
<?php


/*
================================================================================
| 4. $_SESSION                                                                 |
================================================================================

Permite almacenar información del usuario a través de múltiples páginas en una
misma visita (sesión). Los datos se guardan en el servidor.

Recuerda: session_start() debe ser llamado al inicio de CADA script que use sesiones.

*/
echo "<h2>4. \$_SESSION</h2>";

// Ejemplo: un contador de visitas de página durante la sesión
if (!isset($_SESSION['visitas'])) {
    $_SESSION['visitas'] = 0;
}
$_SESSION['visitas']++;

// Guardar un dato en la sesión
$_SESSION['usuario_actual'] = 'Carlos';

echo "<pre>";
echo "Esta página ha sido visitada " . $_SESSION['visitas'] . " veces en esta sesión.\n";
echo "Contenido completo de \$_SESSION: \n";
print_r($_SESSION);
echo "</pre>";
echo '<div class="nota">Recarga la página para ver cómo el contador de visitas aumenta. Cierra y abre el navegador para reiniciar la sesión.</div>';


/*
================================================================================
| 5. $_COOKIE                                                                  |
================================================================================

Contiene las variables pasadas al script a través de cookies HTTP. Las cookies
son pequeños ficheros que el servidor pide al navegador del cliente que guarde.

Para establecer una cookie, se usa la función `setcookie()`. Debe llamarse
ANTES de cualquier salida HTML. El valor estará disponible en la SIGUIENTE carga.

*/
echo "<h2>5. \$_COOKIE</h2>";

// Establecer una cookie de ejemplo (si no existe)
if (!isset($_COOKIE['mi_cookie_de_ejemplo'])) {
    // La cookie se llama 'mi_cookie_de_ejemplo', tiene el valor 'HolaMundo' y expira en 1 hora.
    setcookie('mi_cookie_de_ejemplo', 'HolaMundo', time() + 3600, "/");
    echo '<div class="nota">Cookie "mi_cookie_de_ejemplo" establecida. Recarga la página para leer su valor.</div>';
}

$valor_cookie = $_COOKIE['mi_cookie_de_ejemplo'] ?? 'Aún no establecida. Recarga la página.';

echo "<pre>";
echo "Valor de \$_COOKIE['mi_cookie_de_ejemplo']: " . htmlspecialchars($valor_cookie) . "\n";
echo "Contenido completo de \$_COOKIE: \n";
print_r($_COOKIE);
echo "</pre>";


/*
================================================================================
| 6. $_FILES                                                                   |
================================================================================

Contiene información sobre los ficheros subidos al servidor a través de un
formulario con `method="POST"` y `enctype="multipart/form-data"`.

Es un array multidimensional con información como nombre, tipo, ruta temporal,
error y tamaño del fichero.

¡SEGURIDAD MÁXIMA! La subida de archivos es una fuente común de vulnerabilidades.
Valida siempre el tipo, tamaño y mueve el fichero con `move_uploaded_file()`.

*/
echo "<h2>6. \$_FILES</h2>";
echo '<div class="nota">Esta sección es solo demostrativa. Para un ejemplo funcional, se necesita un script completo de subida de archivos.</div>';
echo "<pre>";
echo "Si se subiera un archivo con <input type=\"file\" name=\"mi_archivo\">, \$_FILES contendría algo así:\n\n";
echo "Array\n";
echo "(\n";
echo "    [mi_archivo] => Array\n";
echo "        (\n";
echo "            [name] => nombre_original.jpg\n";
echo "            [type] => image/jpeg\n";
echo "            [tmp_name] => /tmp/php123ABC\n";
echo "            [error] => 0\n";
echo "            [size] => 12345\n";
echo "        )\n";
echo ")\n";
echo "</pre>";

?>

</body>
</html>