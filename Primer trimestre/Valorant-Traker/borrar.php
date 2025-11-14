<?php
include "includes/plantilla.php";
$titulo="Borrado de contacto";
escribe_cabecera($titulo);
	//comprobar si vienen datos por get, si el dato que viene no es 0

	$ssql="delete from agentes where id=".$_GET['id'];
	if(mysqli_query($conexion,$ssql)){
		echo "Se ha borrado con exito";
		
	}else{
		echo "Tuvimos problemas, intentalo de nuevo más tarde";
			
	}

escribe_pie($conexion);