<?php
require __DIR__ . '/../includes/header.php';
?>
<h2>$_SERVER</h2>
<table>
  <tr><th>Clave</th><th>Valor</th></tr>
  <?php
  $keys = ['SERVER_NAME','SERVER_ADDR','SERVER_PORT','REQUEST_METHOD','REQUEST_URI','PHP_SELF','REMOTE_ADDR','HTTP_USER_AGENT','HTTP_ACCEPT_LANGUAGE','SCRIPT_FILENAME'];
  foreach ($keys as $k) {
      $v = $_SERVER[$k] ?? '(no disponible)';
      echo '<tr><td>'.h($k).'</td><td>'.h(is_string($v)?$v:json_encode($v)).'</td></tr>';
  }
  ?>
</table>
<details class="card"><summary>Ver $_SERVER completo</summary><?php dump_var($_SERVER); ?></details>
<?php require __DIR__ . '/../includes/footer.php'; ?>
