<?php
class Conexion {
    private static $db = null;
    // Método estático que devuelve una conexión PDO lista para usar
    public static function conectar() {
        try {
            // Creamos un nuevo objeto PDO para conectarnos a MySQL
            $pdo = new PDO(
                "mysql:host=localhost;dbname=tienda;charset=utf8mb4", // DSN: tipo, servidor, BD y charset
                "root",      // usuario de MySQL
                "root"           // contraseña de MySQL
            );

            // Configuramos PDO para que lance excepciones si ocurre algún error
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Devolvemos el objeto PDO ya configurado
            return $pdo;

        } catch (PDOException $e) {
            // Si ocurre un error en la conexión, se muestra el mensaje y el script termina
            die("Error al conectar: " . $e->getMessage());
        }
    }
}
?>