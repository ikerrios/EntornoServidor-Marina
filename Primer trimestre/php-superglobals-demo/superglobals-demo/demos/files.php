<?php
require __DIR__ . '/../includes/header.php';
?>
<h2>$_FILES</h2>
<form method="post" enctype="multipart/form-data" class="card">
  <label>Selecciona un archivo: <input type="file" name="archivo" required></label>
  <button type="submit">Subir</button>
</form>
<?php
if (!empty($_FILES) && isset($_FILES['archivo'])) {
    $f = $_FILES['archivo'];
    if ($f['error'] === UPLOAD_ERR_OK) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $tipoMime = finfo_file($finfo, $f['tmp_name']);
        finfo_close($finfo);
        
        echo '<div class="card ok">';
        echo '<h3>Tipo MIME detectado:</h3>';
        echo '<p><strong>' . h($tipoMime) . '</strong></p>';
        echo '</div>';
        $dest = __DIR__ . '/../uploads/' . basename($f['name']);
        if (move_uploaded_file($f['tmp_name'], $dest)) {
            echo '<div class="card ok">Archivo subido correctamente a <code>/uploads/' . h(basename($f['name'])) . '</code></div>';
        } else {
            echo '<div class="card err">No se pudo mover el archivo subido.</div>';
        }
    } else {
        echo '<div class="card err">Error al subir: código ' . h((string)$f['error']) . '</div>';
    }
    echo '<details class="card"><summary>Ver $_FILES</summary>'; dump_var($_FILES); echo '</details>';
} else {
    echo '<div class="card warn">Sube un archivo para ver el contenido de $_FILES.</div>';
}
?>
<?php require __DIR__ . '/../includes/footer.php'; ?>
