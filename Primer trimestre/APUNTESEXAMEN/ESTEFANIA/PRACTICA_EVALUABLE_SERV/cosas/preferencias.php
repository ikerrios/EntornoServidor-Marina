<?php
// Define las opciones válidas (Lista Blanca) (UT4)
$idiomas_validos = ['es', 'en', 'fr'];
$temas_validos = ['claro', 'oscuro'];

// 1. LECTURA DE PREFERENCIAS (UT5)
// Intenta leer las cookies al inicio
$idioma_actual = $_COOKIE['preferencia_idioma'] ?? 'es'; // Por defecto: español
$tema_actual = $_COOKIE['preferencia_tema'] ?? 'claro'; // Por defecto: claro

$mensaje = '';

// 2. PROCESAMIENTO Y VALIDACIÓN (UT7)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoge los datos del formulario (UT4)
    $idioma_seleccionado = $_POST['idioma'] ?? ''; 
    $tema_seleccionado = $_POST['tema'] ?? '';
    
    $errores = [];

    // Validar el idioma con Lista Blanca (UT4)
    if (!in_array($idioma_seleccionado, $idiomas_validos)) {
        $errores[] = 'Error: Idioma seleccionado no válido.';
    }

    // Validar el tema con Lista Blanca
    if (!in_array($tema_seleccionado, $temas_validos)) {
        $errores[] = 'Error: Tema seleccionado no válido.';
    }

    // Si no hay errores, se establecen las cookies
    if (empty($errores)) {
        // Establecer la cookie (UT5)
        // La cookie caducará en 30 días (30 * 24 * 3600 segundos)
        $expiracion = time() + (30 * 24 * 3600); 

        // Se usa httponly=true (seguridad) para evitar acceso desde JavaScript (UT5)
        setcookie('preferencia_idioma', $idioma_seleccionado, $expiracion, '/', '', false, true); //
        setcookie('preferencia_tema', $tema_seleccionado, $expiracion, '/', '', false, true); //

        $mensaje = "✅ Preferencias guardadas: Idioma ($idioma_seleccionado), Tema ($tema_seleccionado).";

        // Redirigir para que el array $_COOKIE se actualice inmediatamente (UT5)
        header("Location: preferencias.php?msg=" . urlencode($mensaje)); //
        exit;
        
    } else {
        $mensaje = "❌ " . implode(" ", $errores);
    }
}

// 3. ACTUALIZACIÓN POST-REDIRECCIÓN Y SANEAMIENTO (UT4, UT7)
// Si viene un mensaje en la URL (después de redirección), lo muestra
if (isset($_GET['msg'])) {
    // Sanear la salida del mensaje para evitar XSS
    $mensaje = sanear_salida($_GET['msg']); //
}

// Recargar los valores actuales (ya sea desde la cookie o los valores por defecto)
$idioma_actual = $_COOKIE['preferencia_idioma'] ?? $idioma_actual;
$tema_actual = $_COOKIE['preferencia_tema'] ?? $tema_actual;
$estilo_fondo = ($tema_actual === 'oscuro') ? 'background-color: #222; color: #f0f0f0;' : 'background-color: #fff; color: #333;';

// Función de saneamiento de salida (UT7)
function sanear_salida($cadena) {
    return htmlspecialchars($cadena, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="<?= sanear_salida($idioma_actual); ?>">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Preferencias</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; <?= $estilo_fondo; ?> transition: background-color 0.5s; }
        .formulario { padding: 15px; border: 1px solid #ccc; border-radius: 5px; max-width: 400px; }
        .mensaje { padding: 10px; margin-bottom: 20px; border-radius: 5px; }
        .mensaje.exito { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .mensaje.error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        select { padding: 8px; margin-top: 5px; width: 100%; box-sizing: border-box; }
        button { padding: 10px 15px; margin-top: 15px; cursor: pointer; }
    </style>
</head>
<body>

    <h1>Configuración de Preferencias de Usuario</h1>
    
    <?php
    // Muestra el mensaje de éxito o error (UT6)
    if (!empty($mensaje)):
        $clase_mensaje = (strpos($mensaje, '✅') !== false) ? 'exito' : 'error';
        echo '<div class="mensaje ' . sanear_salida($clase_mensaje) . '">' . $mensaje . '</div>';
    endif;
    ?>

    <div class="formulario">
        <h2>Preferencias Actuales: <?= sanear_salida(strtoupper($idioma_actual)); ?> / <?= sanear_salida(ucfirst($tema_actual)); ?></h2>
        
        <form method="POST" action="<?= sanear_salida($_SERVER['PHP_SELF']); ?>">
            
            <label for="idioma">Seleccionar Idioma:</label>
            <select id="idioma" name="idioma">
                <?php foreach ($idiomas_validos as $lang): ?>
                    <option value="<?= sanear_salida($lang); ?>" <?= ($lang === $idioma_actual) ? 'selected' : ''; ?>>
                        <?= sanear_salida(strtoupper($lang)); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <label for="tema">Seleccionar Tema:</label>
            <select id="tema" name="tema">
                <?php foreach ($temas_validos as $tema): ?>
                    <option value="<?= sanear_salida($tema); ?>" <?= ($tema === $tema_actual) ? 'selected' : ''; ?>>
                        <?= sanear_salida(ucfirst($tema)); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <button type="submit">Guardar Preferencias</button>
        </form>
    </div>

    <p style="margin-top: 30px;">(El fondo y el idioma de la página se adaptan inmediatamente gracias a la lectura de la cookie guardada).</p>

</body>
</html>

<!-- 📋 Instrucciones de Prueba
Guardar Cookies: Selecciona el idioma FR y el tema Oscuro, y haz clic en "Guardar Preferencias".

Observa cómo el color de fondo cambia (aplicación de la preferencia).

La redirección con header() asegura que el valor se refleje inmediatamente.

Persistencia: Cierra el navegador y vuelve a abrir preferencias.php.

La página recordará el idioma y el tema gracias a la lectura de $_COOKIE.

Validación (Lista Blanca): Si manipularas el formulario para enviar un idioma no listado ('de'), el script rechazaría la petición, demostrando la seguridad implementada con in_array().