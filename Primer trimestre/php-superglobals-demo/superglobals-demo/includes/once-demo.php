<?php
// This file is used to demonstrate include vs include_once
if (!isset($GLOBALS['once_demo_count'])) {
    $GLOBALS['once_demo_count'] = 0;
}
$GLOBALS['once_demo_count']++;
echo '<div class="card ok">Contenido de once-demo.php cargado. Conteo: ' . h((string)$GLOBALS['once_demo_count']) . '</div>';
