<?php
// Gestionar acciones ANTES de enviar salida
$action = $_GET['action'] ?? null;
if ($action === 'set') {
    setcookie('demo_usuario', 'Miguel', time() + 3600, '/');
    header('Location: /demos/cookie.php');
    exit;
}
if ($action === 'delete') {
    setcookie('demo_usuario', '', time() - 3600, '/');
    header('Location: /demos/cookie.php');
    exit;
}

require __DIR__ . '/../includes/header.php';
?>
<h2>$_COOKIE</h2>
<p>Las cookies se almacenan en el navegador del usuario.</p>
<div class="card">
  <a href="?action=set">Crear cookie demo_usuario</a> |
  <a href="?action=delete">Borrar cookie demo_usuario</a>
</div>
<div class="card <?= isset($_COOKIE['demo_usuario']) ? 'ok' : 'warn' ?>">
  <strong>demo_usuario:</strong>
  <?= isset($_COOKIE['demo_usuario']) ? h($_COOKIE['demo_usuario']) : '<em>No existe</em>' ?>
</div>
<details class="card"><summary>Ver $_COOKIE completo</summary><?php dump_var($_COOKIE); ?></details>
<?php require __DIR__ . '/../includes/footer.php'; ?>
