<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost:3307", "root", "", "gestioninventario");

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

?>
