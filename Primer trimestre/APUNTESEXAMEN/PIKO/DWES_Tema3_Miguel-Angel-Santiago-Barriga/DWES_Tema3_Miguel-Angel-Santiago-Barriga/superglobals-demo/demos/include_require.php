<?php
require __DIR__ . '/../includes/header.php';

$mode = $_GET['mode'] ?? null; // include | require
$file = $_GET['file'] ?? null; // exists | missing

$path_exists = __DIR__ . '/../includes/snippet.php';
$path_missing = __DIR__ . '/../includes/no-existe.php'; // no lo creamos adrede

?>
<h2>include vs require</h2>
<p>Prueba las combinaciones para ver cómo se comportan:</p>
<div class="card">
  <a href="?mode=include&file=exists">include archivo existente</a> |
  <a href="?mode=include&file=missing">include archivo inexistente (warning)</a> |
  <a href="?mode=require&file=exists">require archivo existente</a> |
  <a href="?mode=require&file=missing">require archivo inexistente (error fatal)</a>
</div>
<?php
if ($mode && $file) {
    $path = ($file === 'exists') ? $path_exists : $path_missing;
    echo '<div class="card"><strong>Acción:</strong> ' . h($mode) . ' "' . h(basename($path)) . '"</div>';
    if ($mode === 'include') {
        include $path; // si no existe: warning, el script sigue
        echo '<div class="card ok">El script continuó tras include.</div>';
    } elseif ($mode === 'require') {
        require $path; // si no existe: error fatal, el script se detiene
        echo '<div class="card ok">Si ves esto, el require funcionó.</div>';
    }
}
?>
<?php require __DIR__ . '/../includes/footer.php'; ?>
