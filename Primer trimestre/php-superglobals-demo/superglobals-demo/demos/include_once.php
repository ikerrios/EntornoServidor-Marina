<?php
require __DIR__ . '/../includes/header.php';
?>
<h2>include_once</h2>
<p><code>include_once</code> evita cargar el mismo archivo más de una vez.</p>
<div class="card">
  <p>Primero usaremos <code>include</code> dos veces:</p>
  <?php include __DIR__ . '/../includes/once-demo.php'; ?>
  <?php include __DIR__ . '/../includes/once-demo.php'; ?>
</div>
<div class="card">
  <p>Ahora <code>include_once</code> dos veces (la segunda se ignora):</p>
  <?php include_once __DIR__ . '/../includes/once-demo.php'; ?>
  <?php include_once __DIR__ . '/../includes/once-demo.php'; ?>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
