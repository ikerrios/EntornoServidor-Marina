<?php
include("includes/plantilla.php");
$titulo="Insercion de agentes";
escribe_cabecera($titulo);

// Incluir validaciones
include "validaciones.php";

if(!$_POST){
    include "includes/formulario.php";
}else{
    // Verificar si hay errores de validación
    if($e) {
        // Hay errores, mostrar formulario con errores
        include "includes/formulario.php";
    } else {
        // No hay errores, realizar la inserción con datos saneados
        $ssql = "INSERT INTO agentes(id, nombre, rol, habilidad_firma, descripcion) 
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($conexion, $ssql);
        mysqli_stmt_bind_param($stmt, "issss", $id, $nombre, $rol, $habilidad_firma, $descripcion);
        
        if(mysqli_stmt_execute($stmt)){
            echo "Agente insertado correctamente";
        } else {
            echo "Error al insertar";
            echo "<br />". mysqli_error($conexion);
            include "includes/formulario.php";
        }
        mysqli_stmt_close($stmt);
    }
}

escribe_pie($conexion);
?>