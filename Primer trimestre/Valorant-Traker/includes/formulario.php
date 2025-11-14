<?php require_once 'validaciones.php'; ?>

<!doctype html><meta charset="utf-8">
<title>Formulario Agentes</title>
<h1>Formulario Agentes</h1>
<form method="post" novalidate>
<p>id: <input name="id" value="<?= esc($id) ?>"> <?= $e['id']??'' ?></p>
<p>nombre: <input name="nombre" value="<?= esc($nombre) ?>"> <?= $e['nombre']??'' ?></p>

<label for = "rol">rol:</label>
<select name="rol" id="rol">
    <option value = "Controlador" selected></option> 
    <option value ="Duelista">Duelista</option> 
    <option value ="Iniciador">Iniciador</option> 
    <option value = "Centinela"> Centinela </option> 
    <option value = "Controlador"> Controlador </option> 
</select>
<p>habilidad_firma: <input name="habilidad_firma" value="<?= esc($habilidad_firma) ?>"> <?= $e['habilidad_firma']??'' ?></p>
<p>descripcion: <input name="descripcion" value="<?= esc($descripcion) ?>"> <?= $e['descripcion']??'' ?></p>
<?php
if($_GET){
    echo "<input type=hidden name='id' value=".$_GET['id'].">";
}
?>
<button>Enviar</button>
</form>
<?php if ($is_post && !$e): ?>
<hr><h2>Datos validados y saneados</h2>
<ul>
<li>id: <?= esc($id) ?></li>
<li>nombre: <?= esc($nombre) ?></li>
<li>rol: <?= esc($rol) ?></li>
<li>habilidad_firma: <?= esc($habilidad_firma) ?></li>
<li>descripcion: <?= esc($descripcion) ?></li>
</ul>
<?php endif; ?>