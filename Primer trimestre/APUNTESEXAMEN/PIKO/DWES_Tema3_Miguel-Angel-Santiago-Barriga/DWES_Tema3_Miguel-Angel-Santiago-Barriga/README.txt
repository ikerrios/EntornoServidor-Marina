Miguel Ángel Santiago Barriga 	   2ºDAW 	Practica 03 Superglobals 	Desarrollo Web en Entorno Servidor

1. $_GET es una variable global que se usa para enviar información, en este caso la información se muestra también en la URL de la pagina en el formato(/BASE_URL?parametro1=1&parametro2=2).
1.Debug. Después de añadir el color, se puede observar que $_GET tiene 3 parámetros: id, nombre y color.

2. $_POST es una variable global que se usa para enviar información, en este caso la información no se muestra en la URL y solo se podrá ver por código.
2.Debug. Después de añadir el email como parámetro, se puede observar que $_POST tiene 3 parámetros: nombre, edad y email.

3. $_REQUEST muestra las variables de GET, POST y COOKIE.
3.Debug. Tras modificar el form para poder usar get y post a la vez, se puede observar que en $_REQUEST se muestran las 2 variables con su contenido


4. $_FILES guarda toda la información de los archivos que se suben desde la aplicación
4.Debug. En el debug se pueden ver todos los parámetros del archivo, su nombre, su ubicación temporal o su extensión

5. $_COOKIE es variable tipo array asociativo de variables pasadas al script actual a través de Cookies HTTP. 
5.Debug. Se pueden ver los datos de $_COOKIE, que se mantienen tras actualizar.

6. $_SESSION se utiliza para controlar las sesiones de usuarios.
6.Debug. Se pueden observar que los datos de la sesión se mantienen una vez actualizada la pagina 

7. $_SERVER muestra todos los datos del servidor, como por ejemplo HTTP_REFERER, que muestra el enlace de la página actual
7.Debug. Se muestran los 31 parámetros que tiene el servidor.

8. $GLOBALS contiene todas las variables.
8.Debug. Se puede observar todo el contenido de las variables

9. phpinfo() Muestra numerosas informaciones sobre la configuración de PHP, como si versión o la ubicación del archivo de configuración. En mi caso el archivo de configuración php.ini esta en C:\xampp\php\php.ini

10. php_ini y ini_set() Permite cambiar los ajustes de php.ini.
10.Debug. No he conseguido cambiar los ajustes por código.

11. include_require incluye un archivo dentro de otro.
11.Debug. La pila de llamadas esta vacía porque todavía no se ha usado el require.

12. once_require permite enviar múltiples conexiones al mismo archivo.
12.Debug.