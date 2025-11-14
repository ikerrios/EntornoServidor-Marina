<?php
require __DIR__ . '/../includes/header.php';

$contador = $contador ?? 0;
$usuario = $usuario ?? "Iker";

function incrementar_por_globals(): void {
    $GLOBALS['contador'] = ($GLOBALS['contador'] ?? 0) + 1;
    $GLOBALS['usuario'] = ($GLOBALS['usuario'] ?? "") . " Ríos";
}

function incrementar_bien(int $x): int {
    return $x + 1;
}

if (isset($_GET['modo'])) {
    if ($_GET['modo'] === 'globals') {
        incrementar_por_globals();
    } elseif ($_GET['modo'] === 'bien') {
        $contador = incrementar_bien($contador);
    }
}
?>
<h2>$GLOBALS</h2>
<p>Evita usar <code>$GLOBALS</code> salvo casos muy justificados. Es preferible pasar variables como parámetros.</p>
<div class="card">
    <p>Valor actual de <code>$contador</code>: <strong><?= h((string)$contador) ?></strong></p>
    <p>Valor actual de <code>$usuario</code>: <strong><?= h((string)$usuario) ?></strong></p>
    <a href="?modo=globals">Incrementar usando $GLOBALS (no recomendado)</a> |
    <a href="?modo=bien">Incrementar pasando como parámetro (recomendado)</a>
</div>
<details class="card"><summary>Ver $GLOBALS</summary><?php dump_var($GLOBALS); ?></details>
<?php require __DIR__ . '/../includes/footer.php'; ?>