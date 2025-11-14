<?php
$is_post = $_SERVER['REQUEST_METHOD'] === 'POST';
$e = [];
$id = trim($_POST['id'] ?? '');
$nombre = trim($_POST['nombre'] ?? '');
$rol = trim($_POST['rol'] ?? '');
$habilidad_firma = trim($_POST['habilidad_firma'] ?? '');
$descripcion = trim($_POST['descripcion'] ?? '');

// Conjunto de roles permitidos
$roles_permitidos = ['Controlador', 'Iniciador', 'Centinela'];

if ($is_post) {
    // Validar ID (obligatorio y único)
    if ($id === '') {
        $e['id'] = 'ID obligatorio';
    } elseif (!filter_var($id, FILTER_VALIDATE_INT, ['options'=>['min_range'=>1]])) {
        $e['id'] = 'ID debe ser número entero positivo';
    } else {
        // Verificar si el ID ya existe
        $sql = "SELECT COUNT(*) FROM agentes WHERE id = ?";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $count);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        
        if ($count > 0) {
            $e['id'] = 'ID ya existe';
        }
    }
    
    // Validar nombre (obligatorio, 2-100 caracteres)
    if ($nombre === '') {
        $e['nombre'] = 'Nombre obligatorio';
    } elseif (mb_strlen($nombre) < 2) {
        $e['nombre'] = 'Mínimo 2 caracteres';
    } elseif (mb_strlen($nombre) > 100) {
        $e['nombre'] = 'Máximo 100 caracteres';
    }
    
    // Validar rol (obligatorio y en conjunto permitido)
    if ($rol === '') {
        $e['rol'] = 'Rol obligatorio';
    } elseif (!in_array($rol, $roles_permitidos)) {
        $e['rol'] = 'Rol debe ser: ' . implode(', ', $roles_permitidos);
    }
    
    // Validar habilidad_firma (obligatorio)
    if ($habilidad_firma === '') {
        $e['habilidad_firma'] = 'Habilidad firma obligatoria';
    }
    
    // Validar descripción (máximo 400 caracteres)
    if (mb_strlen($descripcion) > 400) {
        $e['descripcion'] = 'Máximo 400 caracteres';
    }
}

function esc($s){ 
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); 
}
?>