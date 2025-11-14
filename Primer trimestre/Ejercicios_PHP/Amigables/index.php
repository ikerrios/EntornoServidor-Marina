<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formularios usables</title>
</head>
<body>
    
    <h1>Formularios php</h1>

    
    <?php if (!$_POST) {
        include 'formulario.php'; 
    } else {
        //procesamos el formulario
        if(!isset($_POST["nombre"])) {
            echo "No he recibido el nombre";
        } elseif (!srtlen($_POST["nombre"]) < 6) {
            echo "Campo demasiado corto";
        } elseif (!isset($_POST["email"])) {
            echo "No he recibido el email";
        } elseif (!srtlen($_POST["email"]) < 6) {
            echo "Campo demasiado corto";
        } else if(!isset($_POST["clave1"]) || !isset($_POST["clave2"])) {
            echo "No he recibido el mensaje";
        } elseif (!srtlen($_POST["clave1"]) < 5) {
            echo "La clave debería de tener 5 o mas carácteres.";
        } else if(!isset($_POST[""])) {

        }
    }

</body>
</html>