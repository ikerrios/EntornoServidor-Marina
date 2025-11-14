<?php
include 'conexion.php';

$resultado = $conexion->query("SELECT * FROM usuarios");
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Lista de usuarios</title></head>
<body>

<h1>Usuarios registrados</h1>

<p><a href="insert.php">Añadir nuevo usuario</a></p>
<a href="update.php?id=<?= $usuario['id'] ?>">Editar</a>


<table border="1" cellpadding="8">
<tr><th>ID</th><th>Nombre</th><th>Email</th><th>Teléfono</th><th>Acciones</th></tr>
<?php while($fila = $resultado->fetch_assoc()): ?>
    <tr>
    <td><?= $fila['id'] ?></td>
    <td><?= htmlspecialchars($fila['nombre']) ?></td>
    <td><?= htmlspecialchars($fila['email']) ?></td>
    <td><?= htmlspecialchars($fila['telefono']) ?></td>
    <td>
        <a href="update.php?id=<?= $fila['id'] ?>">Editar</a> |
        <a href="delete.php?id=<?= $fila['id'] ?>" onclick="return confirm('¿Eliminar este usuario?')">Eliminar</a>
    </td>
    </tr>
<?php endwhile; ?>
</table>
</body>
</html>
