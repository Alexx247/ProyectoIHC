<?php
include 'verificar_sesion.php';

// Conexión a la base de datos
$conexion = new mysqli("localhost:3307", "root", "", "gestioninventario");

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
// Obtener el ID del dispositivo a eliminar
$data = json_decode(file_get_contents('php://input'), true); // Recibir los datos en formato JSON
$idDispositivo = $data['idDispositivo']; // Obtener el N.C desde el JSON


// Preparar la consulta SQL
$sql = "DELETE FROM inventario WHERE idDispositivo = ?";
$stmt = $conexion->prepare($sql);

if ($stmt) {
    $stmt->bind_param("s", $idDispositivo);
    if ($stmt->execute()) {
        echo "Dispositivo eliminado con éxito";
    } else {
        echo "Error al eliminar el dispositivo: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Error en la preparación de la consulta: " . $conexion->error;
}

$conexion->close();
?>