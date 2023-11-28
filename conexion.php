<?php
$host = 'localhost'; 
$usuario = 'root';
$contrasena = 'root';
$base_datos = 'banco';

// Intenta conectar a la base de datos
$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);

// Verifica si la conexión fue exitosa
if ($conexion->connect_error) {
    die('Error de conexión a la base de datos: ' . $conexion->connect_error);
} else {
    echo 'Conexión exitosa a la base de datos.';
}


?>