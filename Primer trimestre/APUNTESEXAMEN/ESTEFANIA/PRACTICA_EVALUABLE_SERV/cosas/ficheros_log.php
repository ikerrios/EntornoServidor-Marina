<?php
// Nombres de los archivos de persistencia
$archivo_contador = 'contador.txt';
$archivo_log = 'acceso.log';

$dir_actual = __DIR__;

// --- Funciones del Ejercicio ---

/**
 * Registra un acceso en el archivo de log.
 * Utiliza file_put_contents con FILE_APPEND y LOCK_EX para seguridad.
 */
function registrar_acceso($archivo_log) {
    global $dir_actual;
    $ruta_completa = $dir_actual . '/' . $archivo_log;

    // 1. Obtener datos del entorno (UT3)
    $ip_cliente = $_SERVER['REMOTE_ADDR'] ?? 'Desconocida'; //
    // Obtener la fecha actual formateada
    $fecha_acceso = date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME'] ?? time()); //
    
    // Crear la línea del log
    $linea_log = "[$fecha_acceso] IP: $ip_cliente - Acceso a: " . basename($_SERVER['PHP_SELF']) . "\n"; //

    // 2. Escribir en el archivo con bloqueo y añadir (UT9)
    if (is_writable($ruta_completa) || !file_exists($ruta_completa)) { //
        // FILE_APPEND añade al final. LOCK_EX (Bloqueo Exclusivo) previene escrituras simultáneas (UT9)
        $bytes_escritos = file_put_contents($ruta_completa, $linea_log, FILE_APPEND | LOCK_EX); //
        if ($bytes_escritos === false) {
             return "❌ Error al escribir en el archivo de log: Permiso denegado o error de disco.";
        }
    } else {
        return "⚠️ Error de permisos: El archivo de log no es escribible. Ejecutar chmod 0666.";
    }
    return ""; // Éxito
}

/**
 * Incrementa y guarda el contador de visitas.
 * Utiliza file_get_contents y file_put_contents (UT9).
 */
function actualizar_contador($archivo_contador) {
    global $dir_actual;
    $ruta_completa = $dir_actual . '/' . $archivo_contador;
    
    $visitas = 0;
    
    // 1. Leer el contador actual (UT9)
    if (file_exists($ruta_completa)) { //
        $contenido = file_get_contents($ruta_completa); //
        $visitas = (int) $contenido; // Conversión de tipo a entero
    }
    
    $visitas++;

    // 2. Escribir el nuevo valor (sobrescribe) (UT9)
    if (is_writable($ruta_completa) || !file_exists($ruta_completa)) { //
        file_put_contents($ruta_completa, $visitas, LOCK_EX); //
    } else {
        // En caso de fallo de permisos, devolvemos un mensaje y el contador actual.
        return "⚠️ Error de permisos al actualizar el contador. Visitas actuales: " . ($visitas - 1);
    }

    return $visitas;
}

// --- Ejecución del Script ---

// Inicializa el mensaje de error/estado
$mensaje_log = registrar_acceso($archivo_log);

// Llama a la función principal del contador
$contador_actual = actualizar_contador($archivo_contador);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Ficheros y Log</title>
    <style>
        body { font-family: 'Courier New', monospace; padding: 20px; line-height: 1.5; }
        .contador { font-size: 2em; color: #007bff; margin: 20px 0; padding: 10px; border: 1px dashed #007bff; max-width: 400px; }
        .log-display { border: 1px solid #ccc; padding: 15px; background: #f9f9f9; }
        .warning { color: orange; font-weight: bold; }
    </style>
</head>
<body>

    <h1>Contador de Visitas y Registro de Acceso (Ficheros PHP)</h1>
    
    <?php if (is_numeric($contador_actual)): ?>
        <div class="contador">
            Página visitada <span style="font-size: 1.5em; font-weight: bold;"><?= $contador_actual; ?></span> veces.
        </div>
    <?php else: ?>
        <p class="warning"><?= $contador_actual; ?></p>
    <?php endif; ?>

    <?php if (!empty($mensaje_log)): ?>
        <p class="warning"><?= $mensaje_log; ?></p>
    <?php endif; ?>

    <h2>Contenido del Archivo de Log (<?= $archivo_log; ?>)</h2>
    <div class="log-display">
        <?php
        $ruta_log = $dir_actual . '/' . $archivo_log;
        
        // C: Comprobación de existencia (UT9)
        if (file_exists($ruta_log)) { //
            // L: Lectura rápida del contenido del log (UT9)
            $contenido_log = file_get_contents($ruta_log); //
            echo nl2br(sanear_salida($contenido_log)); 
        } else {
            echo "El archivo de log aún no existe o no se pudo crear. Recarga la página.";
        }
        
        // Función auxiliar para seguridad de salida
        function sanear_salida($cadena) {
            return htmlspecialchars($cadena, ENT_QUOTES, 'UTF-8');
        }
        ?>
    </div>

</body>
</html>

<!-- 📋 Instrucciones de Prueba
Ejecución Inicial: Abre ficheros_log.php en tu navegador.

Si es la primera vez, se crearán los archivos contador.txt (con el valor 1) y acceso.log (con el primer registro).

Incremento y Log: Recarga la página varias veces.

Observa cómo el contador numérico aumenta (persistencia en contador.txt).

Revisa la sección del Log; cada recarga ha añadido una nueva línea con la IP y la hora (FILE_APPEND).

Seguridad: Intenta abrir el archivo contador.txt directamente en tu navegador (ej: http://localhost/contador.txt).

Deberías ver solo el número simple, demostrando el mecanismo básico de persistencia fuera del código PHP.

Comprobación de Comandos:

$_SERVER['REMOTE_ADDR'] se utiliza para obtener tu IP en el log.

file_put_contents() con LOCK_EX garantiza que las operaciones de lectura/escritura sean seguras y no se corrompan los archivos si muchos usuarios acceden a la vez.
