<?php
// Incluimos la clase Usuario para poder usar sus métodos del CRUD
require_once("Usuario.php");
require_once("alumno.php");
require_once("profesor.php");

// --- Crear nuevo usuario ---
// Si se ha enviado el formulario con el botón "crear"
if (isset($_POST['crear'])) {
    
    if ($_POST['nombre'] === '' || $_POST['email'] === '' || $_POST['password'] === ''){
        echo("No puedes añadir campos vacíos.");
        exit;
    }
    // Creamos un nuevo objeto Usuario con los datos del formulario
    $usuario = new Usuario($_POST['nombre'], $_POST['email'], $_POST['password']);

    // Llamamos al método agregar() para insertarlo en la base de datos
    $usuario->agregar();
}

// --- Eliminar usuario ---
// Si en la URL viene un parámetro ?eliminar=ID
if (isset($_GET['eliminar'])) {
    // Llamamos al método estático eliminar pasando el ID
    Usuario::eliminar($_GET['eliminar']);
}

// --- Mostrar lista ---
// Obtenemos todos los usuarios desde la base de datos
$usuarios = Usuario::listar();


if (isset($_POST['crearAlumno'])) {
    $alumno = new alumno($_POST['nombre'], $_POST['email'], $_POST['password'], $_POST['curso']);

    $alumno->agregarAlumno();
};

$alumno = alumno::listarAlumno();



if (isset($_POST['crearProfesor'])) {
    
    if ($_POST['nombre'] === '' || $_POST['email'] === '' || $_POST['password'] === '' || $_POST['departamento'] === ''){
        echo("No puedes añadir campos vacíos.");
        exit;
    }
    // Creamos un nuevo objeto Usuario con los datos del formulario
    $profesor = new profesor($_POST['nombre'], $_POST['email'], $_POST['password'], $_POST['departamento']);

    // Llamamos al método agregar() para insertarlo en la base de datos
    $profesor->agregarProfesor();
}

$profesor = profesor::listarProfesor();
?>


<h2>CRUD con POO y PDO</h2>

<form method="post">
    Nombre: <input name="nombre" required>
    Email: <input name="email" type="email" required>
    Password: <input type="password" name="password" required>
    <button type="submit" name="crear">Guardar</button>
</form>

<form method="post">
    Nombre: <input name="nombre" required>
    Email: <input name="email" type="email" required>
    Password: <input type="password" name="password" required>
    Curso: <input type="text" name="curso" required>
    <button type="submit" name="crearAlumno">Guardar</button>
</form>

<form method="post">
    Nombre: <input name="nombre" required>
    Email: <input name="email" type="email" required>
    Password: <input type="password" name="password" required>
    Departamento: <input type="text" name="departamento" required>
    <button type="submit" name="crearProfesor">Guardar</button>
</form>

<hr>


<h3>Usuarios registrados</h3>

<?php foreach ($usuarios as $u): ?>
    <p>
        <!-- 
            Mostramos el nombre y email del usuario
            htmlspecialchars evita ataques XSS escapando caracteres peligrosos 
        -->
        <?= htmlspecialchars($u['nombre']) ?> - <?= htmlspecialchars($u['email']) ?>

        <!-- 
            Enlace para eliminar el usuario:
            - Pasa el ID por GET
            - confirm() pide confirmación antes de borrar
        -->
        <a href="?eliminar=<?= $u['id'] ?>" onclick="return confirm('¿Eliminar?')">🗑</a>
    </p>
<?php endforeach; ?>

<h3>Alumnos registrados</h3>

<?php foreach ($alumno as $a): ?>
    <p>
        <!-- 
            Mostramos el nombre y email del usuario
            htmlspecialchars evita ataques XSS escapando caracteres peligrosos 
        -->
        <?= htmlspecialchars($a['nombre']) ?> - <?= htmlspecialchars($a['curso']) ?>

        <!-- 
            Enlace para eliminar el usuario:
            - Pasa el ID por GET
            - confirm() pide confirmación antes de borrar
        -->
        <a href="?eliminar=<?= $u['id'] ?>" onclick="return confirm('¿Eliminar?')">🗑</a>
    </p>
<?php endforeach; ?>

<h3>Profesores registrados</h3>

<?php foreach ($profesor as $p): ?>
    <p>
        <!-- 
            Mostramos el nombre y email del usuario
            htmlspecialchars evita ataques XSS escapando caracteres peligrosos 
        -->
        <?= htmlspecialchars($p['nombre']) ?> - <?= htmlspecialchars($p['departamento']) ?>

        <!-- 
            Enlace para eliminar el usuario:
            - Pasa el ID por GET
            - confirm() pide confirmación antes de borrar
        -->
        <a href="?eliminar=<?= $u['id'] ?>" onclick="return confirm('¿Eliminar?')">🗑</a>
    </p>
<?php endforeach; ?>

