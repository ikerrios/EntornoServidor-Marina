<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Protectora de Animales - MVC</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        form { margin: 20px 0; padding: 15px; border: 1px solid #ccc; display: inline-block; }
        input { margin: 5px; }
        hr { margin: 40px 0; }
    </style>
</head>
<body>
    <h1>Protectora de Animales (MVC)</h1>

    <!-- Crear Animal genérico -->
    <h2>Crear Animal genérico</h2>
    <form method="post" action="index.php">
        Nombre: <input name="nombre" required>
        Edad: <input name="edad" type="number" required>
        <button name="crear_animal">Crear Animal</button>
    </form>

    <!-- Crear Perro -->
    <h2>Crear Perro</h2>
    <form method="post" action="index.php?c=perro">
        Nombre: <input name="nombre" required>
        Edad: <input name="edad" type="number" required>
        Raza: <input name="raza" required>
        <button name="crear_perro">Crear Perro</button>
    </form>

    <!-- Crear Gato -->
    <h2>Crear Gato</h2>
    <form method="post" action="index.php?c=gato">
        Nombre: <input name="nombre" required>
        Edad: <input name="edad" type="number" required>
        Color: <input name="color" required>
        <button name="crear_gato">Crear Gato</button>
    </form>

    <hr>

    <h2>Todos los animales</h2>
    <?php foreach ($animales as $a): ?>
        <p>
            <?= htmlspecialchars($a['nombre']) ?> - <?= $a['edad'] ?> años - <?= $a['tipo'] ?>
            <?php if ($a['raza']): ?> - Raza: <?= htmlspecialchars($a['raza']) ?><?php endif; ?>
            <?php if ($a['color']): ?> - Color: <?= htmlspecialchars($a['color']) ?><?php endif; ?>
            <a href="index.php?eliminar=<?= $a['id'] ?>" 
            onclick="return confirm('¿Seguro?')">Eliminar</a>
        </p>
    <?php endforeach; ?>

    <h2>Solo Perros</h2>
    <?php foreach ($perros as $p): ?>
        <p><?= htmlspecialchars($p['nombre']) ?> - <?= $p['edad'] ?> años - Raza: <?= htmlspecialchars($p['raza']) ?></p>
    <?php endforeach; ?>

    <h2>Solo Gatos</h2>
    <?php foreach ($gatos as $g): ?>
        <p><?= htmlspecialchars($g['nombre']) ?> - <?= $g['edad'] ?> años - Color: <?= htmlspecialchars($g['color']) ?></p>
    <?php endforeach; ?>
</body>
</html>