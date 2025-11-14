<?php
require __DIR__ . '/../includes/header.php';
?>
<h2>$_POST</h2>
<form method="post" class="card">
  <label>Nombre: <input type="text" name="nombre" required></label><br><br>
  <label>Edad: <input type="number" name="edad" min="0" max="120" required></label><br><br>
  <label>Email: <input type="email" name="email" id="email" required></label><br><br>
  <button type="submit">Enviar</button>
</form>
<?php if (!empty($_POST)): ?>
<div class="card ok">
  <h3>Datos recibidos por POST</h3>
  <p><strong>nombre:</strong> <?= h((string)($_POST['nombre'] ?? '')) ?></p>
  <p><strong>edad:</strong> <?= h((string)($_POST['edad'] ?? '')) ?></p>
  <p><strong>email:</strong> <?= h((string)($_POST['email'] ?? '')) ?></p>
  <details><summary>Ver $_POST completo</summary><?php dump_var($_POST); ?></details>
</div>
<?php else: ?>
<div class="card warn">Rellena el formulario y envíalo.</div>
<?php endif; ?>
<?php require __DIR__ . '/../includes/footer.php'; ?>
