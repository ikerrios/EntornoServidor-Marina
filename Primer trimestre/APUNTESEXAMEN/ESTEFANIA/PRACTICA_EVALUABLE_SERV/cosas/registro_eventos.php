<?php

// Nombre del archivo de log (UT9)
$archivo_log = "eventos.txt"; 

// Variables para mensaje y error
$mensaje_salida = '';
$error = '';

// ===================================
// 1. PROCESAMIENTO DEL FORMULARIO (UT4)
// ===================================

// Comprueba si la petición fue por POST (envío de formulario)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Recoger el dato de forma segura (UT4)
    $mensaje_usuario = $_POST['mensaje'] ?? ''; 
    
    // VALIDACIÓN (UT7)
    $mensaje_limpio = trim($mensaje_usuario); // Limpiar espacios (UT7)

    if (empty($mensaje_limpio)) { // Comprobar que no esté vacío (UT7)
        $error = '❌ El mensaje no puede estar vacío.';
    } else {
        // SEGURIDAD: Saneamiento del mensaje (UT7)
        // Se usa antes de *escribir* por si el log se comparte (aunque aquí se usará htmlspecialchars en la salida)
        $mensaje_saneado = filter_var($mensaje_limpio, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // Capturar información del entorno (UT3)
        $ip_cliente = $_SERVER['REMOTE_ADDR'] ?? 'Desconocida';
        $timestamp = date("Y-m-d H:i:s");

        // Construir la línea del log
        $linea_log = "[$timestamp] [IP: $ip_cliente] Mensaje: \"$mensaje_saneado\"\n";

        // 2. ESCRITURA EN EL FICHERO (UT9)
        // Usamos file_put_contents para escritura rápida y segura
        // FILE_APPEND: para añadir al final sin sobrescribir
        // LOCK_EX: para bloquear el archivo durante la escritura (seguridad)
        $resultado_escritura = file_put_contents(
            $archivo_log, 
            $linea_log, 
            FILE_APPEND | LOCK_EX //
        );

        if ($resultado_escritura !== false) {
            $mensaje_salida = '✅ Evento registrado con éxito en ' . $archivo_log;
        } else {
            $error = '❌ Error al escribir en el archivo de log. Revisa los permisos (chmod).'; //
        }
    }
}

// 3. LECTURA Y VISUALIZACIÓN DEL FICHERO (UT9)
$contenido_log = '';
if (file_exists($archivo_log)) {
    // Lectura rápida de todo el contenido del archivo (UT9)
    $contenido_log = file_get_contents($archivo_log); 
    
    // Convertir saltos de línea (\n) a etiquetas HTML <br> para visualización
    $contenido_log = nl2br(sanear_salida($contenido_log)); 
} else {
    $error_log = "El archivo de log ($archivo_log) aún no existe.";
}

// Función de saneamiento de salida (UT7)
function sanear_salida($cadena) {
    // Evita XSS al mostrar datos del log (UT7)
    return htmlspecialchars($cadena, ENT_QUOTES, 'UTF-8'); 
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Eventos (Log)</title>
    <style>
        body { font-family: 'Consolas', 'Courier New', monospace; padding: 20px; background-color: #f4f4f4; }
        .formulario, .log-viewer { margin-bottom: 30px; padding: 20px; border-radius: 8px; background-color: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .error { color: red; font-weight: bold; }
        .success { color: green; font-weight: bold; }
        textarea { width: 100%; min-height: 80px; padding: 10px; box-sizing: border-box; resize: vertical; margin-bottom: 10px; }
        .log-content { border: 1px solid #ccc; padding: 15px; background-color: #f9f9f9; min-height: 150px; white-space: pre-wrap; word-wrap: break-word; font-size: 0.9em; }
    </style>
</head>
<body>

    <h1>Registro de Eventos (Log File)</h1>

    <?php if (!empty($error)): ?>
        <p class="error"><?= sanear_salida($error); ?></p>
    <?php endif; ?>

    <?php if (!empty($mensaje_salida)): ?>
        <p class="success"><?= sanear_salida($mensaje_salida); ?></p>
    <?php endif; ?>

    <div class="formulario">
        <h2>Registrar Nuevo Evento</h2>
        <form method="POST" action="<?= sanear_salida($_SERVER['PHP_SELF']); ?>"> 
            <label for="mensaje">Mensaje del evento:</label>
            <textarea id="mensaje" name="mensaje" placeholder="Describe el evento aquí..."><?= sanear_salida($mensaje_limpio ?? ''); ?></textarea>
            <button type="submit">Registrar en Log</button>
        </form>
    </div>

    <div class="log-viewer">
        <h2>Contenido de <?= sanear_salida($archivo_log); ?></h2>
        <div class="log-content">
            <?php if (!empty($contenido_log)): ?>
                <?= $contenido_log; ?>
            <?php else: ?>
                <p>El log está vacío.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>

<!-- Ejecución: Abre registro_log.php en tu navegador.

Escritura:

Escribe un mensaje (ej: "Inicio de sesión de Administrador").

Haz clic en Registrar en Log. Verás el mensaje de éxito y la tabla de log se actualizará.

Intenta enviar un mensaje que contenga código HTML (ej: <script>alert('XSS')</script>). Observa que la salida en el visor del log aparece como texto simple y no se ejecuta, gracias a htmlspecialchars() (Seguridad - UT7).

Manejo de Ficheros:

Verifica que se haya creado un archivo llamado eventos.txt en la misma carpeta donde está registro_log.php.

