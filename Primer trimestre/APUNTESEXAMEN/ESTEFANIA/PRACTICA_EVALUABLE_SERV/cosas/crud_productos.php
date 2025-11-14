<?php
// 1. INICIO: Activa la persistencia de la sesión (UT5, UT3)
session_start(); // [cite: 1451]

// Inicializa el array de productos en la sesión si no existe
if (!isset($_SESSION['productos'])) {
    $_SESSION['productos'] = []; // 
}

// Inicializa el array de errores y mensajes
$errores = []; 
$mensaje = ''; 
$datos = [ // Array con "memoria" para el formulario 
    'nombre' => '',
    'precio' => ''
];
$editando_id = -1; // Usado para la operación UPDATE

// Función de saneamiento (seguridad)
function sanear_salida($cadena) {
    // Escapa caracteres especiales para prevenir XSS (UT7)
    return htmlspecialchars($cadena, ENT_QUOTES, 'UTF-8'); // [cite: 36, 98]
}

// 2. LÓGICA DE VALIDACIÓN Y PROCESAMIENTO (UT7)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ===================================
    // Manejo de la acción (Crear o Actualizar)
    // ===================================
    
    // Recoge y limpia los datos de entrada (UT4)
    $nombre = trim($_POST['nombre'] ?? ''); // Limpiar espacios [cite: 86]
    $precio = trim($_POST['precio'] ?? '');
    $id = $_POST['id'] ?? -1;

    // Asignar a la "memoria" del formulario
    $datos['nombre'] = $nombre;
    $datos['precio'] = $precio;
    $editando_id = $id;

    // VALIDACIÓN (UT7)
    if (empty($nombre)) {
        $errores['nombre'] = 'El nombre del producto es obligatorio.'; // [cite: 75, 77]
    } elseif (mb_strlen($nombre) < 3) {
        $errores['nombre'] = 'El nombre debe tener al menos 3 caracteres.'; // [cite: 88, 93]
    }
    
    // Validar formato de precio (UT7)
    if (empty($precio)) {
        $errores['precio'] = 'El precio es obligatorio.';
    } elseif (!is_numeric($precio)) {
        $errores['precio'] = 'El precio debe ser un valor numérico.'; // [cite: 52, 55]
    } elseif ($precio < 0.01) {
        $errores['precio'] = 'El precio debe ser positivo.';
    }

    // PROCESAMIENTO (CREATE o UPDATE)
    if (empty($errores)) {
        // Formatear el precio a float (conversión de tipo) [cite: 60]
        $precio_float = (float) $precio; 

        if ($id == -1) {
            // C: CREATE (Crear Nuevo Producto)
            $nuevo_id = empty($_SESSION['productos']) ? 1 : max(array_keys($_SESSION['productos'])) + 1;
            $_SESSION['productos'][$nuevo_id] = [
                'nombre' => $nombre,
                'precio' => $precio_float
            ];
            $mensaje = '✅ Producto creado correctamente.';
        } else {
            // U: UPDATE (Actualizar Producto Existente)
            if (isset($_SESSION['productos'][$id])) {
                $_SESSION['productos'][$id]['nombre'] = $nombre;
                $_SESSION['productos'][$id]['precio'] = $precio_float;
                $mensaje = '✏️ Producto actualizado correctamente.';
            } else {
                $mensaje = '❌ Error: Producto a actualizar no encontrado.';
            }
        }
        // Limpia el formulario después de una operación exitosa
        $datos = ['nombre' => '', 'precio' => ''];
        $editando_id = -1;
    } 
}

// ===================================
// Manejo de Acciones GET (Borrar y Cargar para Editar) (UT4)
// ===================================
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['accion'])) { // [cite: 41]
    $accion = $_GET['accion'];
    $id = $_GET['id'] ?? null;
    $id_valido = is_numeric($id) && isset($_SESSION['productos'][$id]);
    
    if ($accion === 'borrar' && $id_valido) {
        // D: DELETE (Borrar Producto)
        unset($_SESSION['productos'][$id]);
        $mensaje = '🗑️ Producto eliminado correctamente.';
        // Redireccionar con header() para limpiar la URL de parámetros GET (UT4)
        // Evita que al recargar se intente borrar de nuevo.
        header("Location: crud_productos.php?msg=" . urlencode($mensaje)); // [cite: 272]
        exit();

    } elseif ($accion === 'editar' && $id_valido) {
        // Cargar datos en el formulario para editar
        $producto = $_SESSION['productos'][$id];
        $datos['nombre'] = $producto['nombre'];
        $datos['precio'] = $producto['precio'];
        $editando_id = $id;
        $mensaje = 'Modificando el Producto ID ' . $id;

    }
}

// Carga mensaje de URL después de redirección si existe (UT4)
if (isset($_GET['msg'])) {
    $mensaje = sanear_salida($_GET['msg']);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD de Productos con PHP (Sesiones)</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .formulario, .listado { margin-bottom: 30px; padding: 15px; border: 1px solid #ccc; border-radius: 5px; }
        .error { color: red; font-size: 0.9em; display: block; margin-top: 5px; }
        .mensaje { padding: 10px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; margin-bottom: 20px; border-radius: 5px; }
        .listaerrores { list-style: none; padding: 0; margin: 0 0 15px 0; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 10px; border-radius: 5px; }
        .listaerrores li { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    </style>
</head>
<body>

    <h1>CRUD de Productos</h1>
    
    <?php
    // Mostrar mensaje general
    if (!empty($mensaje)) {
        echo '<div class="mensaje">' . $mensaje . '</div>';
    }

    // Mostrar errores de validación (UT6)
    if (!empty($errores)) {
        echo '<ul class="listaerrores">
                <li>❌ Se encontraron los siguientes errores:</li>';
        foreach ($errores as $campo => $error) {
            echo '<li>' . sanear_salida($error) . '</li>';
        }
        echo '</ul>';
    }
    ?>

    <div class="formulario">
        <h2><?= ($editando_id != -1) ? 'Actualizar Producto ID ' . $editando_id : 'Crear Nuevo Producto'; ?></h2>
        
        <form method="POST" action="<?= sanear_salida($_SERVER['PHP_SELF']); ?>"> 
            <input type="hidden" name="id" value="<?= sanear_salida($editando_id); ?>">
            
            <p>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?= sanear_salida($datos['nombre']); ?>">
                <?php if (isset($errores['nombre'])) echo '<span class="error">' . sanear_salida($errores['nombre']) . '</span>'; ?>
            </p>
            
            <p>
                <label for="precio">Precio:</label>
                <input type="text" id="precio" name="precio" value="<?= sanear_salida($datos['precio']); ?>">
                <?php if (isset($errores['precio'])) echo '<span class="error">' . sanear_salida($errores['precio']) . '</span>'; ?>
            </p>
            
            <p>
                <button type="submit"><?= ($editando_id != -1) ? 'Guardar Cambios' : 'Crear Producto'; ?></button>
                <?php if ($editando_id != -1) echo '<a href="crud_productos.php">Cancelar</a>'; ?>
            </p>
        </form>
    </div>

    <div class="listado">
        <h2>Listado de Productos (<?= count($_SESSION['productos']); ?>)</h2>
        <?php if (empty($_SESSION['productos'])): ?>
            <p>No hay productos registrados.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['productos'] as $id => $producto): ?>
                    <tr>
                        <td><?= $id; ?></td>
                        <td><?= sanear_salida($producto['nombre']); ?></td> 
                        <td><?= number_format($producto['precio'], 2) . ' €'; ?></td>
                        <td>
                            <a href="?accion=editar&id=<?= $id; ?>">Editar</a> 
                            | 
                            <a href="?accion=borrar&id=<?= $id; ?>" onclick="return confirm('¿Seguro que desea borrar este producto?');">Borrar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

</body>
</html>

<!-- 📋 Instrucciones de Prueba
C: Crear

Intenta enviar el formulario con el campo Nombre vacío o el Precio como texto ("cien"). Observa los mensajes de error de validación (UT7).


Crea un producto válido (ej: Nombre: Portátil, Precio: 899.99). Observa que el formulario mantiene el valor si la validación falla (Formulario con Memoria).

R: Leer

Los productos se listan automáticamente en la tabla, demostrando la operación Read.

Recarga la página: la lista persiste gracias a $_SESSION.

U: Actualizar

Haz clic en el enlace Editar de un producto.

Observa que los datos se cargan en el formulario ($datos y $editando_id). Esto usa la acción GET.

Modifica el precio y haz clic en Guardar Cambios.

D: Borrar

Haz clic en el enlace Borrar.

Observa cómo se ejecuta la acción GET, se llama a unset() y se redirige con header() y urlencode() para limpiar la URL (UT4).


