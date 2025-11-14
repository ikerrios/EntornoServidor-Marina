<?php
require __DIR__ . '/includes/header.php';
?>
<div class="card">
  <h2>Bienvenido</h2>
  <p>Esta demo acompaña al Tema 3 y muestra, de forma práctica, cómo funcionan las variables superglobales de PHP, el archivo <code>php.ini</code>, y las sentencias <code>include</code>/<code>require</code>.</p>
  <p>Recorrido sugerido:</p>
  <ol>
    <li><a href="/demos/get.php">$_GET</a> y <a href="/demos/post.php">$_POST</a></li>
    <li><a href="/demos/request.php">$_REQUEST</a></li>
    <li><a href="/demos/files.php">$_FILES</a></li>
    <li><a href="/demos/cookie.php">$_COOKIE</a> y <a href="/demos/session_start.php">$_SESSION</a></li>
    <li><a href="/demos/server.php">$_SERVER</a> y <a href="/demos/globals.php">$GLOBALS</a></li>
    <li><a href="/demos/ini.php">php.ini (ini_get / ini_set)</a> y <a href="/demos/phpinfo.php">phpinfo()</a></li>
    <li><a href="/demos/include_require.php">include vs require</a> e <a href="/demos/include_once.php">include_once</a></li>
  </ol>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
