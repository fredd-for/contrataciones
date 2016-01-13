<?php
// Datos para la conexion
$host = 'localhost';
$database = 'bd_comercial';
$username = 'user_comercial';
$password = 'pass_comercial';

// Conectarse a MySQL
$link = mysql_connect($host, $username, $password);
if (!$link) {
    die('Error al conectarse a mysql: ' . mysql_error());
}
// Seleccionar nuestra base de datos
$db_selected = mysql_select_db($database, $link);
if (!$db_selected) {
    die ('Error al abrir la base de datos: ' . mysql_error());
}
// else {
//  echo 'Conexion exitosa.';
// }
?>