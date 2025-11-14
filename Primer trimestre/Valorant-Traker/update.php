<?php
include "includes/plantilla.php";
$titulo="Editando un agente";
escribe_cabecera($titulo);


if($_POST){
	//quieres editar 
	$ssql="update agentes set id='".$_POST['id']."', nombre='".$_POST['nombre']."', rol='".$_POST['rol']."', habilidad_firma='".$_POST['habilidad_firma']."', descripcion='".$_POST['descripcion']."' where id=".$_POST['id'];

	if(mysqli_query($conexion,$ssql)){
		echo "Usuario actualizado";
	}else{
		echo "Error" . mysqli_error($conexion);
	}


}else{
	$ssql="select * from agentes where id=".$_GET['id'];
	if($rs=mysqli_query($conexion,$ssql)){
		$fila=mysqli_fetch_array($rs);
		include ("includes/formulario.php");
	}

}
escribe_pie($conexion);