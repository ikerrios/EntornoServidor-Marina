<?php
include ("conexion.php");

$conexion=abrir_conexion("localhost","root","root","valorant_traker");

function escribe_cabecera ($titulo="Agenda de mis agentes"){
	?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Agenda de contactos</title>
		<link rel="stylesheet" href="includes/estilos.css">
	</head>
	<body>
			<header class="cabecera">
				<h1><?php echo $titulo?></h1>
			</header>
			<section>
			<?php
}

function escribe_pie($conexion){
	?>
	</section>
	<footer class="pie">
		<a href="index.php">Página principal</a>
		-
		<a href="insertar.php">Insertar un agente</a>
	</footer>
	</body>
	</html>
	<?php
	cerrar_conexion($conexion);
}