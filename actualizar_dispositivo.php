<?php
include 'verificar_sesion.php';

// Conexión a la base de datos
$conexion = new mysqli("localhost:3307", "root", "", "gestioninventario");

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Obtener los datos del formulario
$idDispositivo = $_POST['idDispositivo'];
$nombre = $_POST['nombre'];
$marca = $_POST['marca'];
$estado = $_POST['estado'];
$descripcion = $_POST['descripcion'];

// Preparar la consulta SQL
$sql = "UPDATE inventario SET nombre = ?, marca = ?, estado = ?, descripcion = ? WHERE idDispositivo = ?";
$stmt = $conexion->prepare($sql);

if ($stmt) {
    $stmt->bind_param("sssss", $nombre, $marca, $estado, $descripcion, $idDispositivo);
    if ($stmt->execute()) {
        echo "Dispositivo actualizado correctamente.";
    } else {
        echo "Error al actualizar el dispositivo: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Error en la preparación de la consulta: " . $conexion->error;
}

$conexion->close();
?>