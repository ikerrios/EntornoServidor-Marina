<?php
require __DIR__ . '/../includes/header.php';
?>
<h2>$_GET</h2>
<p>Parámetros llegados por URL. Prueba los enlaces:</p>
<ul>
  <li><a href="?id=4&nombre=Pepe&color=red">?id=4&amp;nombre=Pepe&amp;color=red</a></li>
  <li><a href="?id=99&nombre=María&filtro=activo&color=blue">?id=99&amp;nombre=Mar%C3%ADa&amp;color=blue&amp;filtro=activo</a></li>
</ul>
<?php if (!empty($_GET)): ?>
<div class="card ok">
  <h3>Valores recibidos</h3>
  <p><strong>id:</strong> <?= isset($_GET['id']) ? h((string)$_GET['id']) : '<em>no enviado</em>' ?></p>
  <p><strong>nombre:</strong> <?= isset($_GET['nombre']) ? h((string)$_GET['nombre']) : '<em>no enviado</em>' ?></p>
  <p><strong>filtro:</strong> <?= isset($_GET['filtro']) ? h((string)$_GET['filtro']) : '<em>no enviado</em>' ?></p>
  <p><strong>filtro:</strong> <?= isset($_GET['color']) ? h((string)$_GET['color']) : '<em>no enviado</em>' ?></p>
  <details><summary>Ver $_GET completo</summary><?php dump_var($_GET); ?></details>
</div>
<?php else: ?>
<div class="card warn">No has enviado parámetros aún. Haz clic en uno de los enlaces de arriba.</div>
<?php endif; ?>
<?php require __DIR__ . '/../includes/footer.php'; ?>