<?php
require __DIR__ . '/../includes/header.php';
?>
<h2>$_REQUEST</h2>
<form method="post" class="card" action="request.php?get_campo=hola">
  <label>Por POST: <input name="post_campo" value=""></label>
  <button type="submit">Enviar POST</button>
</form>

<p>También puedes pasar parámetros por GET: <a href="?get_campo=hola">?get_campo=hola</a></p>

<?php if (!empty($_REQUEST)): ?>
<div class="card ok">
  <h3>Contenido de $_REQUEST</h3>
  <?php dump_var($_REQUEST); ?>
  <p><small>Nota: $_REQUEST suele contener la mezcla de $_GET, $_POST y $_COOKIE (según configuración).</small></p>
</div>
<?php else: ?>
<div class="card warn">Envía algún dato por GET o POST.</div>
<?php endif; ?>
<?php require __DIR__ . '/../includes/footer.php'; ?>
