## 🧭 ¿Qué son las Superglobales en PHP?

En PHP, las **superglobales** son variables predefinidas que están **siempre disponibles en cualquier ámbito** del script.

Esto significa que puedes acceder a ellas desde cualquier parte de tu código (dentro de funciones, clases, o en el ámbito global) sin necesidad de declararlas con `global $variable;`. Son la forma principal que tiene PHP de recibir información del exterior (como un formulario, la URL o el propio servidor).

Estas variables son *arrays asociativos* (pares de clave-valor).

### Las Superglobales más importantes

* **`$_GET`**:
  * **Qué es:** Un array con los datos enviados al script a través de la **URL (query string)**.
  * **Ejemplo:** Si tu URL es `index.php?usuario=ana&id=123`, PHP lo recibe así:

        ```php
        $_GET['usuario'] // Contiene 'ana'
        $_GET['id']      // Contiene '123'
        ```

* **`$_POST`**:
  * **Qué es:** Un array con los datos enviados al script a través de un **formulario HTML con `method="POST"`**.
  * **Por qué se usa:** Es el método preferido para enviar datos "sensibles" (como contraseñas) o grandes cantidades de información, ya que los datos viajan en el cuerpo de la petición HTTP y no son visibles en la URL.

* **`$_REQUEST`**:
  * **Qué es:** Un array que **combina el contenido de `$_GET`, `$_POST` y `$_COOKIE`**.
  * **Advertencia:** Generalmente se recomienda no usarla por claridad y seguridad. Es mejor ser explícito y usar `$_GET` o `$_POST` para saber exactamente de dónde viene la información.

* **`$_SERVER`**:
  * **Qué es:** Un array con muchísima información sobre el servidor y el entorno de ejecución. Es increíblemente útil.
  * **Ejemplos comunes:**
    * `$_SERVER['REQUEST_METHOD']`: Te dice si la petición fue `GET` o `POST`. Fundamental para el CRUD.
    * `$_SERVER['PHP_SELF']`: La ruta del script que se está ejecutando (ej. `/crud/index.php`). Útil para los `action` de los formularios.
    * `$_SERVER['HTTP_HOST']`: El dominio de la petición (ej. `www.misitio.com`).
    * `$_SERVER['REMOTE_ADDR']`: La dirección IP del cliente.

* **`$_SESSION`**:
  * **Qué es:** Un array para **almacenar variables de sesión**. Las sesiones permiten guardar información de un usuario (como "usuario logueado") y que persista a través de múltiples páginas.
  * **Importante:** Debes iniciar la sesión con `session_start();` al principio de cada script que la use.

* **`$_FILES`**:
  * **Qué es:** Un array que contiene información sobre los **archivos subidos** a través de un formulario con `enctype="multipart/form-data"`.

* **`$_COOKIE`**:
  * **Qué es:** Un array con los datos de las **cookies** almacenadas en el navegador del cliente.

---

## 🛠️ CRUD Completo y Explicado (PHP y MySQLi)

**CRUD** significa **C**reate (Crear), **R**ead (Leer), **U**pdate (Actualizar) y **D**elete (Eliminar). Es la base de casi cualquier aplicación web.

Usaremos la extensión **MySQLi** (un conector de PHP para bases de datos MySQL) en su estilo procedural, que es muy claro para aprender.

### 1. Preparación: La Base de Datos

Primero, necesitas una base de datos. En tu gestor (como phpMyAdmin), crea una base de datos (ej. `empresa`) y ejecuta esta consulta SQL para crear nuestra tabla de `usuarios`:

```sql
CREATE TABLE usuarios (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL
);

```

---

### 2. La Estructura de Archivos

Crearemos 6 archivos sencillos:

```sql
db.php (Conexión a la BBDD)

index.php (Leer y mostrar datos + formulario de Crear)

guardar.php (Lógica para Crear)

editar.php (Formulario para Actualizar)

actualizar.php (Lógica para Actualizar)

eliminar.php (Lógica para Eliminar)
```

---

### 3. El Código Explicado

##### db.php (La conexión)

Este archivo solo se encarga de conectarse a la BBDD.

```sql
PHP

<?php
// db.php

$host = 'localhost'; // O tu host
$user = 'root';      // Tu usuario de BBDD
$pass = '';         // Tu contraseña
$dbname = 'empresa'; // El nombre de tu BBDD

$conexion = mysqli_connect($host, $user, $pass, $dbname);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Opcional: Para asegurar que los datos se guarden en UTF-8
mysqli_set_charset($conexion, "utf8");

?>
```

Explicación: mysqli_connect() intenta conectarse. Si falla (!$conexion), die() detiene el script y muestra el error.

##### index.php (Read y formulario Create)

Esta es nuestra página principal. Muestra los usuarios y el formulario para añadir nuevos.

```sql
PHP

<?php
// index.php
include 'db.php'; // Incluimos la conexión
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD de Usuarios</title>
    <style>
        body { font-family: Arial, sans-serif; container: 90%; margin: 20px auto; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        form { margin-bottom: 20px; }
        input[type="text"] { padding: 5px; }
        input[type="submit"], .boton { padding: 5px 10px; background: #007bff; color: white; border: none; cursor: pointer; text-decoration: none; display: inline-block; }
        .boton.editar { background: #ffc107; }
        .boton.eliminar { background: #dc3545; }
    </style>
</head>
<body>

    <h2>Añadir Nuevo Usuario (Create)</h2>
    <form action="guardar.php" method="POST">
        Nombre: <input type="text" name="nombre" required>
        Email: <input type="text" name="email" required>
        <input type="submit" value="Guardar">
    </form>

    <hr>

    <h2>Lista de Usuarios (Read)</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // (R)EAD
            $sql = "SELECT * FROM usuarios";
            $resultado = mysqli_query($conexion, $sql);

            // mysqli_num_rows() comprueba si la consulta devolvió filas
            if (mysqli_num_rows($resultado) > 0) {
                // mysqli_fetch_assoc() extrae una fila de resultados como un array asociativo
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    // Usamos las superglobales $_GET para pasar el ID a las otras páginas
                    // ¡IMPORTANTE! Usamos htmlspecialchars() para prevenir ataques XSS al imprimir datos.
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($fila['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['nombre']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['email']) . "</td>";
                    echo "<td>";
                    echo "<a href='editar.php?id=" . htmlspecialchars($fila['id']) . "' class='boton editar'>Editar</a> ";
                    // Preguntamos antes de eliminar por seguridad
                    echo "<a href='eliminar.php?id=" . htmlspecialchars($fila['id']) . "' class='boton eliminar' onclick='return confirm(\"¿Estás seguro?\")'>Eliminar</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No hay usuarios registrados.</td></tr>";
            }

            // Cerramos la conexión al final
            mysqli_close($conexion);
            ?>
        </tbody>
    </table>

</body>
</html>
```

Explicación (Read):

include 'db.php' reutiliza nuestra conexión.

Hacemos un `SELECT * FROM` usuarios para pedir todos los usuarios.

Usamos `while ($fila = mysqli_fetch_assoc($resultado))` para recorrer cada fila (usuario) que nos devolvió la BBDD.

Imprimimos los datos en la tabla HTML.

Superglobal `$_GET` en acción: Creamos los enlaces de "Editar" y "Eliminar". Fíjate en la URL: editar.php?id=.... Estamos enviando el id del usuario a través de la URL.

Explicación (Create-Form):

El formulario tiene `method="POST"`, por lo que los datos viajarán en la superglobal `$_POST`.

El action="guardar.php" le dice al navegador que envíe esos datos a ese archivo.

##### guardar.php (Lógica Create)

Este archivo no tiene HTML. Solo recibe los datos de index.php y los guarda.

```sql
PHP

<?php
// guardar.php
include 'db.php'; // Incluimos la conexión

// Comprobamos si los datos han sido enviados por POST
// Aquí usamos la superglobal $_SERVER para verificar el método
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Usamos la superglobal $_POST para recoger los datos del formulario
    // mysqli_real_escape_string es una MEDIDA DE SEGURIDAD BÁSICA contra Inyección SQL
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);

    // (C)REATE
    $sql = "INSERT INTO usuarios (nombre, email) VALUES ('$nombre', '$email')";

    if (mysqli_query($conexion, $sql)) {
        // Si todo va bien, redirigimos al usuario de vuelta al index
        header("Location: index.php");
        exit; // Es buena práctica usar exit() después de una redirección
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
    }
}

mysqli_close($conexion);
?>
```

Explicación:

Comprobamos que se llegó a este script usando `POST ($_SERVER['REQUEST_METHOD'])`.

Recogemos las variables usando la superglobal `$_POST['nombre'] y $_POST['email']`.

Seguridad: Usamos `mysqli_real_escape_string()` para "limpiar" los datos que vienen del usuario y evitar ataques básicos de Inyección SQL.

Ejecutamos la consulta INSERT INTO.

header("Location: index.php") redirige al navegador de vuelta a la página principal, donde ahora verá al nuevo usuario.

##### editar.php (Formulario Update)

Este archivo es muy parecido a index.php, pero muestra un formulario precargado con los datos del usuario que queremos editar.

```sql
PHP

<?php
// editar.php
include 'db.php';

// Verificamos que se haya pasado un ID por la URL
// Aquí usamos la superglobal $_GET
if (!isset($_GET['id'])) {
    header("Location: index.php"); // Si no hay ID, volvemos al inicio
    exit;
}

$id_usuario = $_GET['id'];

// (R)EAD - Leemos los datos del usuario específico
$sql = "SELECT * FROM usuarios WHERE id = $id_usuario";
$resultado = mysqli_query($conexion, $sql);

if (mysqli_num_rows($resultado) == 1) {
    $fila = mysqli_fetch_assoc($resultado);
    $nombre = $fila['nombre'];
    $email = $fila['email'];
} else {
    echo "Usuario no encontrado.";
    exit;
}

mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <style>
        body { font-family: Arial, sans-serif; container: 90%; margin: 20px auto; }
        input[type="text"] { padding: 5px; width: 250px; }
        input[type="submit"] { padding: 5px 10px; background: #28a745; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>

    <h2>Editar Usuario (Update)</h2>
    <form action="actualizar.php" method="POST">
        
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id_usuario); ?>">

        <p>
            Nombre: <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
        </p>
        <p>
            Email: <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        </p>
        <input type="submit" value="Actualizar">
    </form>

</body>
</html>
```

Explicación:

Recogemos el ID de la URL usando la superglobal $_GET['id'].

Hacemos un SELECT pero con WHERE id = $id_usuario para obtener solo los datos de ese usuario.

En el formulario HTML, usamos value="<?php echo $nombre; ?>" para precargar los datos en los campos de texto.

Importante: Añadimos un <input type="hidden" name="id" ...> para pasar el ID a actualizar.php vía $_POST.

##### actualizar.php (Lógica Update)

Recibe los datos del formulario de editar.php y actualiza la BBDD.

```sql
PHP

<?php
// actualizar.php
include 'db.php';

// Usamos $_SERVER para verificar que sea POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Recogemos los datos de $_POST (incluido el ID oculto)
    // Limpiamos los datos para seguridad
    $id = mysqli_real_escape_string($conexion, $_POST['id']);
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);

    // (U)PDATE
    $sql = "UPDATE usuarios SET nombre = '$nombre', email = '$email' WHERE id = $id";

    if (mysqli_query($conexion, $sql)) {
        // Redirigimos al index
        header("Location: index.php");
        exit;
    } else {
        echo "Error al actualizar: " . mysqli_error($conexion);
    }
}

mysqli_close($conexion);
?>
```

Explicación:

Recogemos las variables de $_POST, incluyendo el id.

Ejecutamos la consulta UPDATE usando el WHERE id = $id para asegurarnos de que solo modificamos al usuario correcto.

Redirigimos al index.php.

##### eliminar.php (Lógica Delete)

Este archivo recibe el ID por $_GET y borra el registro.

```sql
PHP

<?php
// eliminar.php
include 'db.php';

// Verificamos que se haya pasado un ID por la URL
// Usamos la superglobal $_GET
if (isset($_GET['id'])) {
    
    $id = mysqli_real_escape_string($conexion, $_GET['id']);

    // (D)ELETE
    $sql = "DELETE FROM usuarios WHERE id = $id";

    if (mysqli_query($conexion, $sql)) {
        // Redirigimos al index
        header("Location: index.php");
        exit;
    } else {
        echo "Error al eliminar: " . mysqli_error($conexion);
    }
} else {
    // Si no hay ID, volvemos al inicio
    header("Location: index.php");
    exit;
}

mysqli_close($conexion);
?>

```

Explicación:

Recogemos el ID de la superglobal `$_GET['id']`.

Ejecutamos la consulta DELETE FROM usuarios WHERE id = $id.

Redirigimos al index.php.

#### 🚨 Nota de Seguridad MUY Importante

El método que usamos (mysqli_real_escape_string) es la protección mínima contra la Inyección SQL.

La forma moderna y correcta de gestionar datos en PHP es usando Consultas Preparadas (Prepared Statements). Con mysqli se vería así:

```sql
PHP

// Ejemplo de consulta preparada (más segura) para 'guardar.php'
$sql = "INSERT INTO usuarios (nombre, email) VALUES (?, ?)";

// 1. Preparar la consulta
$stmt = mysqli_prepare($conexion, $sql);

// 2. Vincular los parámetros (s = string)
mysqli_stmt_bind_param($stmt, "ss", $_POST['nombre'], $_POST['email']);

// 3. Ejecutar
mysqli_stmt_execute($stmt);

// En este método, PHP se encarga de la seguridad y no necesitas 'mysqli_real_escape_string'
Aunque el código del CRUD anterior funciona y es más fácil de leer al principio, te recomiendo investigar y adoptar las consultas preparadas (ya sea con mysqli o PDO) tan pronto como te sientas cómodo.

```
