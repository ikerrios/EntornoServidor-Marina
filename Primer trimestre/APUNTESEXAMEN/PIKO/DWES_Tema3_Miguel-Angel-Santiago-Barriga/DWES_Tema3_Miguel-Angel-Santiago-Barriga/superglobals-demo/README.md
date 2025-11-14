# PHP Superglobals Demo

## Requisitos
- PHP 8+ (con servidor embebido)
- Permisos de escritura en la carpeta `uploads/`

## Cómo ejecutarlo
```bash
php -S localhost:8000 -t superglobals-demo
```
Luego visita: http://localhost:8000

## Recorrido sugerido
1. $_GET y $_POST
2. $_REQUEST
3. $_FILES
4. $_COOKIE y $_SESSION
5. $_SERVER y $GLOBALS
6. php.ini (ini_get / ini_set) y phpinfo()
7. include vs require e include_once

> Nota: Algunas páginas provocan warnings o errores a propósito para la demo.
