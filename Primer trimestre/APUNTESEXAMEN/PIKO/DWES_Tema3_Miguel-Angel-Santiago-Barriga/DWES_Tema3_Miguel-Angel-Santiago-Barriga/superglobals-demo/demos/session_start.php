<?php
session_start();
$_SESSION['usuario'] = $_SESSION['usuario'] ?? 'Miguel';
$_SESSION['contador'] = ($_SESSION['contador'] ?? 0) + 1;
$_SESSION['hora'] = $_SESSION['hora'] ?? date("H:i:s", time());
require __DIR__ . '/../includes/header.php';
?>
<h2>$_SESSION</h2>
<div class="card ok">
  <p>Sesión iniciada. Usuario: <strong><?= h((string)$_SESSION['usuario']) ?></strong></p>
  <p>Contador de visitas a esta página en la sesión: <strong><?= h((string)$_SESSION['contador']) ?></strong></p>
  <p>Hora UNIX <strong><?= h((string)$_SESSION['hora']) ?></strong></p>
</div>
<p>
  <a href="/demos/session_show.php">Ver datos de sesión</a> |
  <a href="/demos/session_destroy.php">Destruir sesión</a>
</p>
<?php require __DIR__ . '/../includes/footer.php'; ?>
