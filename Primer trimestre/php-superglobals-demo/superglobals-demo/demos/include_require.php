<?php
// demos/include_require.php
require __DIR__ . '/../includes/header.php';

$mode = $_GET['mode'] ?? null;   // include | require | include_once | require_once
$file = $_GET['file'] ?? null;   // exists | missing

$path_exists  = __DIR__ . '/../includes/snippet.php';
$path_missing = __DIR__ . '/../includes/no-existe.php'; // no lo creamos adrede

// (Opcional) Mostrar errores para ver los warnings claramente en pantalla:
ini_set('display_errors', '1');
error_reporting(E_ALL);
?>
<h2>include vs require</h2>
<p>Prueba las combinaciones para ver cómo se comportan:</p>

<div class="card">
  <a href="?mode=include&file=exists">include archivo existente</a> |
  <a href="?mode=include&file=missing">include archivo inexistente (warning)</a> |
  <a href="?mode=require&file=exists">require archivo existente</a> |
  <a href="?mode=require&file=missing">require archivo inexistente (error fatal)</a> |
  <a href="?mode=include_once&file=exists">include_once (solo una vez)</a> |
  <a href="?mode=require_once&file=exists">require_once (solo una vez)</a> |
  <a href="?mode=require_once&file=missing">require_once inexistente (error fatal)</a>
</div>

<?php
if ($mode && $file) {
    $path = ($file === 'exists') ? $path_exists : $path_missing;

    echo '<div class="card"><strong>Acción:</strong> ' . h($mode) . ' "' . h(basename($path)) . '"</div>';

    // --- BREAKPOINT: pon aquí un breakpoint para capturar el Call Stack ---
    if ($mode === 'include') {
        include $path; // si no existe: WARNING (el script continúa)
        echo '<div class="card ok">El script continuó tras include.</div>';

    } elseif ($mode === 'require') {
        require $path; // si no existe: FATAL ERROR (el script se detiene)
        echo '<div class="card ok">Si ves esto, el require funcionó.</div>';

    } elseif ($mode === 'include_once') {
        include_once $path; // solo lo carga la primera vez
        include_once $path; // segunda vez: no hace nada
        echo '<div class="card ok"><code>include_once</code> solo incluyó el archivo una vez.</div>';

    } elseif ($mode === 'require_once') {
        require_once $path; // FATAL si no existe (igual que require)
        require_once $path; // segunda vez: no hace nada
        echo '<div class="card ok"><code>require_once</code> solo requirió el archivo una vez.</div>';
    }
}
?>

<?php require __DIR__ . '/../includes/footer.php'; ?>
