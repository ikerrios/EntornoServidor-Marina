<?php
require __DIR__ . '/../includes/header.php';

$op = $_GET['op'] ?? null;
$msg = null;

if ($op === 'toggle_errors_on') {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
    $msg = 'display_errors activado y error_reporting=E_ALL';
} elseif ($op === 'toggle_errors_off') {
    ini_set('display_errors', '0');
    $msg = 'display_errors desactivado';
} elseif ($op === 'set_time_limit') {
    ini_set('max_execution_time', '1');
    $msg = 'max_execution_time ajustado temporalmente a 1 segundo (solo para este script)';
} elseif ($op === 'set_upload_limit') { $op = "set_upload_limit";
    $antes = ini_get('upload_max_filesize'); 

    $resultado = ini_set('upload_max_filesize', '20M');

    $despues = ini_get('upload_max_filesize');

} elseif ($op === 'trigger_warning') {
    // Disparar un warning para ver si se muestra según display_errors
    @include __DIR__ . '/../includes/no-existe.php';
    $msg = 'Se intentó incluir un archivo inexistente para provocar un warning.';
} elseif ($op === 'trigger_error') {
    // Disparar un error (división por cero)
    $x = 1/0;
}

?>
<h2>php.ini (ini_get / ini_set)</h2>
<?php if ($msg): ?><div class="card warn"><?= h($msg) ?></div><?php endif; ?>
<table>
  <tr><th>Directiva</th><th>Valor actual</th></tr>
  <?php
  $directivas = ['display_errors','error_reporting','upload_max_filesize','post_max_size','max_execution_time','memory_limit','error_log'];
  foreach ($directivas as $d) {
      echo '<tr><td>'.h($d).'</td><td>'.h((string)ini_get($d)).'</td></tr>';
  }
  ?>
</table>
<div class="card">
  <a href="?op=toggle_errors_on">Activar display_errors</a> |
  <a href="?op=toggle_errors_off">Desactivar display_errors</a> |
  <a href="?op=set_time_limit">max_execution_time = 1 (temporal)</a> |
  <a href="?op=trigger_warning">Provocar warning (include inexistente)</a> |
  <a href="?op=trigger_error">Provocar error fatal (división por cero)</a>
</div>
<p><small>Nota: <code>ini_set</code> solo afecta a este script en tiempo de ejecución. Otro script usará los valores por defecto de <code>php.ini</code>.</small></p>
<?php require __DIR__ . '/../includes/footer.php'; ?>
