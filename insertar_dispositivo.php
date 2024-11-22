<?php

session_start();
include 'Conexion.php';

// Obtener los datos del formulario
$idDispositivo = $_POST['idDispositivo'];
$nombre = $_POST['nombre'];
$marca = $_POST['marca'];
$estado = $_POST['estado'];
$descripcion = $_POST['descripcion'];
$idUsuario = $_SESSION['usuario_id']; // Asumiendo que el ID del usuario está almacenado en la sesión

// Preparar la consulta SQL
$sql = "INSERT INTO inventario (idDispositivo, nombre, marca, estado, descripcion, idUsuario) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);

if ($stmt) {
    $stmt->bind_param("sssssi", $idDispositivo, $nombre, $marca, $estado, $descripcion, $idUsuario);
    if ($stmt->execute()) {
        echo "Dispositivo registrado con éxito";
    } else {
        echo "Error al registrar el dispositivo: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Error en la preparación de la consulta: " . $conexion->error;
}

$conexion->close();
?>