<?php
session_start();
require __DIR__ . '/../includes/header.php';
?>
<h2>Ver sesión</h2>
<details class="card ok"><summary>$_SESSION</summary><?php dump_var($_SESSION); ?></details>
<p><a href="/demos/session_destroy.php">Destruir sesión</a></p>
<?php require __DIR__ . '/../includes/footer.php'; ?>
