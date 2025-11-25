<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="container">

            <h1>Gestor de Alumnos  - MVC</h1>

            <div class="login">
                <?php if($this->logueado): ?>
                    <strong style="color: green;">Admin - Conectado</strong>
                    <a href="index.php?logout" class="logout">Cerrar session</a>

                <?php else: ?>
                    <a href="index.php?login">Entrar como Admin</a>

                <?php endif; ?>
            </div>

            <?php if ($this->logueado): ?>

                <h2>Nuevo Alumno</h2>

                <form method="post" enctype="multipart/form-data">

                    <input type="text" name="nombre" required>
                    <input type="email" name="email" required>
                    <input type="date" name="fecha_nacimiento" required>
                    <input type="file" name="foto" accept="image/*">
                    <button type="submit">Guardar Alumno</button>
                </form>

            <?php else: ?>
                    <p style="color: red;">Debes estar logueado</p>

            <?php endif; ?>

            <h2>Listado de Alumnos</h2>

        <?php if (empty($alumnos)): ?>
        <p>No hay alumnos registrados.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Nacimiento</th>
                <?php if ($this->logueado): ?><th>Acción</th><?php endif; ?>
            </tr>
            <?php foreach ($alumnos as $a): ?>
            <tr>
                <td>
                    <?php if ($a['foto']): ?>
                        <img src="/mvcAlumnos/uploads/<?= htmlspecialchars($a['foto']) ?>" 
                                alt="foto" width="60" height="60" style="border-radius:50%; object-fit:cover;">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/60" alt="sin foto">
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($a['nombre']) ?></td>
                <td><?= htmlspecialchars($a['email']) ?></td>
                <td><?= date('d/m/Y', strtotime($a['fecha_nacimiento'])) ?></td>
                <?php if ($this->logueado): ?>
                <td>
                    <a href="index.php?eliminar=<?= $a['id'] ?>"
                        class="eliminar"
                        onclick="return confirm('¿Eliminar este alumno?')">Eliminar</a>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

</div>
    
</body>
</html>