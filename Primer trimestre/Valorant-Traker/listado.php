<table border="1">
	<tr>
		<th>id</th>
		<th>nombre</th>
		<th>rol</th>
		<th>habilidad_firma</th>
		<th>descripcion</th>
		<th colspan="2">Acciones</th>
	</tr>

	<?php
	// Consulta de todos los agentes
	$ssql = "SELECT * FROM agentes";
	if($rs = mysqli_query($conexion, $ssql)) {
		while($fila = mysqli_fetch_assoc($rs)) {
			echo "<tr>";
			echo "<td>" . $fila['id'] . "</td>";
			echo "<td>" . $fila['nombre'] . "</td>";
			echo "<td>" . $fila['rol'] . "</td>";
			echo "<td>" . $fila['habilidad_firma'] . "</td>";
			echo "<td>" . $fila['descripcion'] . "</td>";
			echo "<td><a href='update.php?id=" . $fila['id'] . "'>Editar</a></td>";
			echo "<td><a href='borrar.php?id=" . $fila['id'] . "'>Borrar</a></td>";
			echo "</tr>";
		}
	}

	// ---- Resumen por rol ----
	$resumen = $conexion->query("SELECT rol, COUNT(*) AS total_agentes FROM agentes GROUP BY rol");

	echo "</table>"; // cerramos tabla antes del resumen
	echo "<h3>Resumen por Rol</h3>";
	echo "<ul>";

	while($fila = $resumen->fetch_assoc()) {
		echo "<li><strong>" . $fila['rol'] . "</strong>: " . $fila['total_agentes'] . " agentes</li>";
	}

	echo "</ul>";

	?>
